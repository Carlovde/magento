/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

const { defineConfig } = require("cypress");

const defaultProductId = process.env.DEFAULT_PRODUCT_ID || 2;

module.exports = defineConfig({
  projectId: "44bnds",
  chromeWebSecurity: false,
  retries: {
    runMode: 2,
  },
  env: {
    defaultProductId: defaultProductId,
  },
  e2e: {
    experimentalWebKitSupport: true,
    async setupNodeEvents(on, config) {
      require('./cypress/plugins/index.js')(on, config);
      require('./cypress/plugins/disable-successful-videos.js')(on, config);

      // If we're running in CI, we need to set the CI env variable
      if (process.env.CI) {
        config.env.CI = true
      }

      config.excludeSpecPattern = ['cypress/e2e/magento/no-api-key.cy.js'];
      if (typeof process.env.NO_API_KEY_TEST != 'undefined' && process.env.NO_API_KEY_TEST == 'true') {
        console.info('Running tests without API key');

        config.specPattern = ['cypress/e2e/magento/no-api-key.cy.js'];
        config.excludeSpecPattern = [];

        return config;
      }

      process.env['NODE_TLS_REJECT_UNAUTHORIZED'] = 0;

      // Retrieve available method
      await new Promise((resolve, reject) => {
        var https = require('follow-redirects').https;

        const baseUrl = config.baseUrl;
        const urlObj = new URL(baseUrl);
        const hostname = urlObj.hostname;

        const query = `
          query {
             molliePaymentMethods(input:{amount:50}) {
               methods {
                 code
                 image
                 name
               }
             }
            }
          `;

        var options = {
          'method': 'GET',
          'hostname': hostname,
          'path': '/graphql?query=' + encodeURIComponent(query),
          'headers': {
            'Content-Type': 'application/json',
            // 'Cookie': 'XDEBUG_SESSION=PHPSTORM'
          },
          'maxRedirects': 20
        };

        console.log('Requesting Mollie payment methods from "' + baseUrl + '". One moment please...');
        var req = https.request(options, function (res) {
          var chunks = [];

          res.on("data", function (chunk) {
            chunks.push(chunk);
          });

          res.on("end", function (chunk) {
            const body = Buffer.concat(chunks);

            const methods = JSON.parse(body.toString()).data.molliePaymentMethods.methods.map(data => {
              return data.code
            })

            // Region ID is expected to be a select, but in Magento 2.3.7-p4 it is an input
            if (process.env.MAGENTO_VERSION === '2.3.7-p4') {
              methods.splice(methods.indexOf('swish'), 1);

              console.log('Detected Magento 2.3.7-p4, removing Swish from the list of available methods');
            }


            config.env.mollie_available_methods = methods;

            console.log('Available Mollie payment methods: ', methods);

            resolve(config);
          });

          res.on("error", function (error) {
            console.error('Error while fetching Mollie Payment methods', error);
            reject(error);
          });
        });

        req.end();
      });

      // retrieve admin token
      await new Promise((resolve, reject) => {
        const baseUrl = config.baseUrl;
        const urlObj = new URL(baseUrl);
        const hostname = urlObj.hostname;

        const username = 'exampleuser';
        const password = 'examplepassword123';

        var options = {
            'method': 'POST',
            'hostname': hostname,
            'path': '/rest/all/V1/integration/admin/token',
            'headers': {
                'accept': 'application/json',
                'Content-Type': 'application/json',
                // 'Cookie': 'XDEBUG_SESSION=PHPSTORM'
            },
            'body': JSON.stringify({
                'username': username,
                'password': password,
            }),
        };

        console.log('Requesting admin token from "' + baseUrl + '". One moment please...');
        var https = require('follow-redirects').https;
        var req = https.request(options, function (res) {
            var chunks = [];
            res.on("data", function (chunk) {
                chunks.push(chunk);
            });

            res.on("end", function (chunk) {
                const body = Buffer.concat(chunks);

                if (res.statusCode !== 200) {
                    console.error('Received invalid status code', res.statusCode, body.toString());
                    reject(body.toString());
                }

                console.log('Received admin token', body.toString(), res.statusCode);
                config.env.admin_token = JSON.parse(body.toString());

                resolve(config);
            });

            res.on("error", function (error) {
                console.error('Error while fetching Mollie Payment methods', error);
                reject(error);
            });
        });

        req.write(options.body);
        req.end();
      });

      return config;
    },
  },
});
