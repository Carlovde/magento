<?php
namespace Magento\Theme\Model\Theme\Registration;

/**
 * Interceptor class for @see \Magento\Theme\Model\Theme\Registration
 */
class Interceptor extends \Magento\Theme\Model\Theme\Registration implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Theme\Model\ResourceModel\Theme\Data\CollectionFactory $collectionFactory, \Magento\Theme\Model\Theme\Data\Collection $filesystemCollection)
    {
        $this->___init();
        parent::__construct($collectionFactory, $filesystemCollection);
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'register');
        return $pluginInfo ? $this->___callPlugins('register', func_get_args(), $pluginInfo) : parent::register();
    }

    /**
     * {@inheritdoc}
     */
    public function getThemeFromDb($fullPath)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getThemeFromDb');
        return $pluginInfo ? $this->___callPlugins('getThemeFromDb', func_get_args(), $pluginInfo) : parent::getThemeFromDb($fullPath);
    }

    /**
     * {@inheritdoc}
     */
    public function checkPhysicalThemes()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'checkPhysicalThemes');
        return $pluginInfo ? $this->___callPlugins('checkPhysicalThemes', func_get_args(), $pluginInfo) : parent::checkPhysicalThemes();
    }

    /**
     * {@inheritdoc}
     */
    public function checkAllowedThemeRelations()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'checkAllowedThemeRelations');
        return $pluginInfo ? $this->___callPlugins('checkAllowedThemeRelations', func_get_args(), $pluginInfo) : parent::checkAllowedThemeRelations();
    }
}
