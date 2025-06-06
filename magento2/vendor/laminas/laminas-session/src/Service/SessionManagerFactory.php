<?php

namespace Laminas\Session\Service;

// phpcs:disable WebimpressCodingStandard.PHP.CorrectClassNameCase

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Laminas\Session\Config\ConfigInterface;
use Laminas\Session\Container;
use Laminas\Session\ManagerInterface;
use Laminas\Session\SaveHandler\SaveHandlerInterface;
use Laminas\Session\SessionManager;
use Laminas\Session\Storage\StorageInterface;

use function array_merge;
use function class_exists;
use function get_debug_type;
use function is_array;
use function is_subclass_of;
use function sprintf;

class SessionManagerFactory implements FactoryInterface
{
    /**
     * Default configuration for manager behavior
     *
     * @var array
     */
    protected $defaultManagerConfig = [
        'enable_default_container_manager' => true,
    ];

    /**
     * Create session manager object (v3 usage).
     *
     * Will consume any combination (or zero) of the following services, when
     * present, to construct the SessionManager instance:
     *
     * - Laminas\Session\Config\ConfigInterface
     * - Laminas\Session\Storage\StorageInterface
     * - Laminas\Session\SaveHandler\SaveHandlerInterface
     *
     * The first two have corresponding factories inside this namespace. The
     * last, however, does not, due to the differences in implementations, and
     * the fact that save handlers will often be written in userland. As such
     * if you wish to attach a save handler to the manager, you will need to
     * write your own factory, and assign it to the service name
     * "Laminas\Session\SaveHandler\SaveHandlerInterface", (or alias that name
     * to your own service).
     *
     * You can configure limited behaviors via the "session_manager" key of the
     * Config service. Currently, these include:
     *
     * - enable_default_container_manager: whether to inject the created instance
     *   as the default manager for Container instances. The default value for
     *   this is true; set it to false to disable.
     * - validators: ...
     *
     * @param string $requestedName
     * @return SessionManager
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $config        = null;
        $storage       = null;
        $saveHandler   = null;
        $validators    = [];
        $managerConfig = $this->defaultManagerConfig;
        $options       = [];

        if ($container->has(ConfigInterface::class)) {
            $config = $container->get(ConfigInterface::class);
            if (! $config instanceof ConfigInterface) {
                throw new ServiceNotCreatedException(sprintf(
                    'SessionManager requires that the %s service implement %s; received "%s"',
                    ConfigInterface::class,
                    ConfigInterface::class,
                    get_debug_type($config)
                ));
            }
        }

        if ($container->has(StorageInterface::class)) {
            $storage = $container->get(StorageInterface::class);
            if (! $storage instanceof StorageInterface) {
                throw new ServiceNotCreatedException(sprintf(
                    'SessionManager requires that the %s service implement %s; received "%s"',
                    StorageInterface::class,
                    StorageInterface::class,
                    get_debug_type($storage)
                ));
            }
        }

        if ($container->has(SaveHandlerInterface::class)) {
            $saveHandler = $container->get(SaveHandlerInterface::class);
            if (! $saveHandler instanceof SaveHandlerInterface) {
                throw new ServiceNotCreatedException(sprintf(
                    'SessionManager requires that the %s service implement %s; received "%s"',
                    SaveHandlerInterface::class,
                    SaveHandlerInterface::class,
                    get_debug_type($saveHandler)
                ));
            }
        }

        // Get session manager configuration, if any, and merge with default configuration
        if ($container->has('config')) {
            $configService = $container->get('config');
            if (
                isset($configService['session_manager'])
                && is_array($configService['session_manager'])
            ) {
                $managerConfig = array_merge($managerConfig, $configService['session_manager']);
            }

            if (isset($managerConfig['validators'])) {
                $validators = $managerConfig['validators'];
            }

            if (isset($managerConfig['options'])) {
                $options = $managerConfig['options'];
            }
        }

        $managerClass = class_exists($requestedName) ? $requestedName : SessionManager::class;
        if (! is_subclass_of($managerClass, ManagerInterface::class)) {
            throw new ServiceNotCreatedException(sprintf(
                'SessionManager requires that the %s service implement %s',
                $managerClass,
                ManagerInterface::class
            ));
        }

        $manager = new $managerClass($config, $storage, $saveHandler, $validators, $options);

        // If configuration enables the session manager as the default manager for container
        // instances, do so.
        if (
            isset($managerConfig['enable_default_container_manager'])
            && $managerConfig['enable_default_container_manager']
        ) {
            Container::setDefaultManager($manager);
        }

        return $manager;
    }

    /**
     * @deprecated This method will be removed in version 3.0
     * Create a SessionManager instance (v2 usage)
     *
     * @param null|string $canonicalName
     * @param string $requestedName
     * @return SessionManager
     */
    public function createService(
        ServiceLocatorInterface $services,
        $canonicalName = null,
        $requestedName = SessionManager::class
    ) {
        return $this($services, $requestedName);
    }
}
