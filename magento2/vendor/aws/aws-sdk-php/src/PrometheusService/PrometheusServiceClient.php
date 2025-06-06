<?php
namespace Aws\PrometheusService;

use Aws\AwsClient;

/**
 * This client is used to interact with the **Amazon Prometheus Service** service.
 * @method \Aws\Result createAlertManagerDefinition(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createAlertManagerDefinitionAsync(array $args = [])
 * @method \Aws\Result createLoggingConfiguration(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createLoggingConfigurationAsync(array $args = [])
 * @method \Aws\Result createRuleGroupsNamespace(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createRuleGroupsNamespaceAsync(array $args = [])
 * @method \Aws\Result createScraper(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createScraperAsync(array $args = [])
 * @method \Aws\Result createWorkspace(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createWorkspaceAsync(array $args = [])
 * @method \Aws\Result deleteAlertManagerDefinition(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteAlertManagerDefinitionAsync(array $args = [])
 * @method \Aws\Result deleteLoggingConfiguration(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteLoggingConfigurationAsync(array $args = [])
 * @method \Aws\Result deleteRuleGroupsNamespace(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteRuleGroupsNamespaceAsync(array $args = [])
 * @method \Aws\Result deleteScraper(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteScraperAsync(array $args = [])
 * @method \Aws\Result deleteWorkspace(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteWorkspaceAsync(array $args = [])
 * @method \Aws\Result describeAlertManagerDefinition(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeAlertManagerDefinitionAsync(array $args = [])
 * @method \Aws\Result describeLoggingConfiguration(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeLoggingConfigurationAsync(array $args = [])
 * @method \Aws\Result describeRuleGroupsNamespace(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeRuleGroupsNamespaceAsync(array $args = [])
 * @method \Aws\Result describeScraper(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeScraperAsync(array $args = [])
 * @method \Aws\Result describeWorkspace(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeWorkspaceAsync(array $args = [])
 * @method \Aws\Result describeWorkspaceConfiguration(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeWorkspaceConfigurationAsync(array $args = [])
 * @method \Aws\Result getDefaultScraperConfiguration(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getDefaultScraperConfigurationAsync(array $args = [])
 * @method \Aws\Result listRuleGroupsNamespaces(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listRuleGroupsNamespacesAsync(array $args = [])
 * @method \Aws\Result listScrapers(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listScrapersAsync(array $args = [])
 * @method \Aws\Result listTagsForResource(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listTagsForResourceAsync(array $args = [])
 * @method \Aws\Result listWorkspaces(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listWorkspacesAsync(array $args = [])
 * @method \Aws\Result putAlertManagerDefinition(array $args = [])
 * @method \GuzzleHttp\Promise\Promise putAlertManagerDefinitionAsync(array $args = [])
 * @method \Aws\Result putRuleGroupsNamespace(array $args = [])
 * @method \GuzzleHttp\Promise\Promise putRuleGroupsNamespaceAsync(array $args = [])
 * @method \Aws\Result tagResource(array $args = [])
 * @method \GuzzleHttp\Promise\Promise tagResourceAsync(array $args = [])
 * @method \Aws\Result untagResource(array $args = [])
 * @method \GuzzleHttp\Promise\Promise untagResourceAsync(array $args = [])
 * @method \Aws\Result updateLoggingConfiguration(array $args = [])
 * @method \GuzzleHttp\Promise\Promise updateLoggingConfigurationAsync(array $args = [])
 * @method \Aws\Result updateScraper(array $args = [])
 * @method \GuzzleHttp\Promise\Promise updateScraperAsync(array $args = [])
 * @method \Aws\Result updateWorkspaceAlias(array $args = [])
 * @method \GuzzleHttp\Promise\Promise updateWorkspaceAliasAsync(array $args = [])
 * @method \Aws\Result updateWorkspaceConfiguration(array $args = [])
 * @method \GuzzleHttp\Promise\Promise updateWorkspaceConfigurationAsync(array $args = [])
 */
class PrometheusServiceClient extends AwsClient {}
