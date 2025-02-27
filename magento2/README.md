# Magento 2 - Installatie en Testinstructies

Deze repository bevat aanpassingen en oplossingen voor Magento 2. Volg deze instructies om de omgeving op te zetten en te testen.

## 1. Installatie en Setup

### 1.1 Vereisten

Zorg ervoor dat je de volgende afhankelijkheden hebt geïnstalleerd:

- PHP 8.1+
- MySQL 8.0+
- Apache/Nginx
- Composer 2+
- Node.js & NPM (voor frontend ontwikkeling)

### 1.2 Magento 2 installeren (indien nodig)

Als Magento nog niet is geïnstalleerd, voer dan de volgende commando's uit:

```
composer create-project --repository-url=https://repo.magento.com/ magento/project-community-edition .
bin/magento setup:install \
  --base-url=http://jouw-magento-site.com/ \
  --db-host=localhost \
  --db-name=magento2 \
  --db-user=magentip \
  --db-password=JOUW_WACHTWOORD \
  --admin-firstname=Admin \
  --admin-lastname=User \
  --admin-email=admin@example.com \
  --admin-user=admin \
  --admin-password=Admin123 \
  --language=nl_NL \
  --currency=EUR \
  --timezone=Europe/Amsterdam \
  --use-rewrites=1
```

### 1.3 Magento 2 configureren en rechten instellen

Zorg ervoor dat alle bestanden correct toegankelijk zijn:

```
sudo chown -R www-data:www-data /var/www/html/magento2
sudo chmod -R 775 /var/www/html/magento2
```

## 2. Aanpassingen en Oplossingen Laden

### 2.1 Cache legen en opnieuw opbouwen

Bij wijzigingen in Magento moet je de cache en indexen vernieuwen:

```
bin/magento cache:flush
bin/magento setup:upgrade
bin/magento setup:di:compile
bin/magento setup:static-content:deploy -f
bin/magento indexer:reindex
```

### 2.2 Debuggen en logbestanden controleren

Als iets niet werkt, check dan de logs:

```
tail -f var/log/system.log var/log/exception.log
```

Voor foutopsporing in de frontend:

```
bin/magento deploy:mode:set developer
```

## 3. Testen van de Oplossingen

### 3.1 Webfant

- ga naar http://jouw-magento-site.com/webfant/skilltest
- hier zie je de tekst te staan Hallo webfant!

### 3.2 Productpagina testen

Controleer of de aanpassingen op de productdetailpagina correct worden weergegeven:

- Ga naar `https://jouw-magento-site.com/test.html`
hier zie je bovenaan staan dat ik mijn naam heb toegevoegd


## 4. Vragen en Issues

Als je problemen ondervindt, check eerst de logs (`var/log/`) en foutmeldingen in de browserconsole (`F12 → Console`).
Voor verdere hulp, maak een GitHub Issue aan of raadpleeg de [Magento Developer Docs](https://developer.adobe.com/commerce/).

