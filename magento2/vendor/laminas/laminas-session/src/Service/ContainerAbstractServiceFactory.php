<?php

namespace Laminas\Session\Service;

// phpcs:disable WebimpressCodingStandard.PHP.CorrectClassNameCase

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\AbstractFactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Laminas\Session\Container;
use Laminas\Session\ManagerInterface;

use function array_change_key_case;
use function array_flip;
use function array_key_exists;
use function is_array;
use function strtolower;

/**
 * Session container abstract service factory.
 *
 * Allows creating Container instances, using the ManagerInterface
 * if present. Containers are named in a "session_containers" array in the
 * Config service:
 *
 * <code>
 * return array(
 *     'session_containers' => array(
 *         'SessionContainer\sample',
 *         'my_sample_session_container',
 *         'MySessionContainer',
 *     ),
 * );
 * </code>
 *
 * <code>
 * $container = $services->get('MySessionContainer');
 * </code>
 */
class ContainerAbstractServiceFactory implements AbstractFactoryInterface
{
    /**
     * Cached container configuration
     *
     * @var array
     */
    protected $config;

    /**
     * Configuration key in which session containers live
     *
     * @var string
     */
    protected $configKey = 'session_containers';

    /** @var ManagerInterface */
    protected $sessionManager;

    /**
     * Can we create an instance of the given service? (v3 usage).
     *
     * @param string $requestedName
     * @return bool
     */
    public function canCreate(ContainerInterface $container, $requestedName)
    {
        $config = $this->getConfig($container);
        if ($config === []) {
            return false;
        }

        $containerName = $this->normalizeContainerName($requestedName);
        return array_key_exists($containerName, $config);
    }

    /**
     * @deprecated This method will be removed in version 3.0
     * Can we create an instance of the given service? (v2 usage)
     *
     * @param string $name
     * @param string $requestedName
     * @return bool
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $container, $name, $requestedName)
    {
        return $this->canCreate($container, $requestedName);
    }

    /**
     * Create and return a named container (v3 usage).
     *
     * @param string $requestedName
     * @return Container
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $manager = $this->getSessionManager($container);
        return new Container($requestedName, $manager);
    }

    /**
     * @deprecated This method will be removed in version 3.0
     * Create and return a named container (v2 usage).
     *
     * @param string $name
     * @param string $requestedName
     * @return Container
     */
    public function createServiceWithName(ServiceLocatorInterface $container, $name, $requestedName)
    {
        return $this($container, $requestedName);
    }

    /**
     * Retrieve config from service locator, and cache for later
     *
     * @return array
     */
    protected function getConfig(ContainerInterface $container)
    {
        if (null !== $this->config) {
            return $this->config;
        }

        if (! $container->has('config')) {
            $this->config = [];
            return $this->config;
        }

        $config = $container->get('config');
        if (! isset($config[$this->configKey]) || ! is_array($config[$this->configKey])) {
            $this->config = [];
            return $this->config;
        }

        $config = $config[$this->configKey];
        $config = array_flip($config);

        $this->config = array_change_key_case($config);

        return $this->config;
    }

    /**
     * Retrieve the session manager instance, if any
     *
     * @return null|ManagerInterface
     */
    protected function getSessionManager(ContainerInterface $container)
    {
        if ($this->sessionManager !== null) {
            return $this->sessionManager;
        }

        if ($container->has(ManagerInterface::class)) {
            $this->sessionManager = $container->get(ManagerInterface::class);
        }

        return $this->sessionManager;
    }

    /**
     * Normalize the container name in order to perform a lookup
     *
     * @param  string $name
     * @return string
     */
    protected function normalizeContainerName($name)
    {
        return strtolower($name);
    }
}
