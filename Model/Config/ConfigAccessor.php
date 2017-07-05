<?php
/**
 * Dhl Shipping
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to
 * newer versions in the future.
 *
 * PHP version 7
 *
 * @category  Dhl
 * @package   Dhl\Shipping
 * @author    Christoph Aßmann <christoph.assmann@netresearch.de>
 * @author    Sebastian Ertner <sebastian.ertner@netresearch.de>
 * @copyright 2017 Netresearch GmbH & Co. KG
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.netresearch.de/
 */
namespace Dhl\Shipping\Model\Config;

use \Magento\Framework\App\Config\ConfigTypeInterface;
use \Magento\Framework\App\Config\Storage\WriterInterface;
use \Magento\Framework\App\Config\ScopeConfigInterface;
use \Magento\Store\Model\ScopeInterface;
use \Magento\Store\Model\StoreManagerInterface;

/**
 * ConfigAccessor
 *
 * @category Dhl
 * @package  Dhl\Shipping
 * @author   Christoph Aßmann <christoph.assmann@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.netresearch.de/
 */
class ConfigAccessor implements ConfigAccessorInterface
{
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var WriterInterface
     */
    private $configWriter;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var ConfigTypeInterface
     */
    private $systemConfigType;

    /**
     * Config constructor.
     * @param StoreManagerInterface $storeManager
     * @param ScopeConfigInterface $scopeConfig
     * @param WriterInterface $configWriter
     * @param ConfigTypeInterface $systemConfigType
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        ScopeConfigInterface $scopeConfig,
        WriterInterface $configWriter,
        ConfigTypeInterface $systemConfigType
    ) {
        $this->storeManager     = $storeManager;
        $this->scopeConfig      = $scopeConfig;
        $this->configWriter     = $configWriter;
        $this->systemConfigType = $systemConfigType;
    }

    /**
     * Save config value to storage.
     *
     * @param string $path
     * @param string $value
     * @param mixed $scopeId
     */
    public function saveConfigValue($path, $value, $scopeId = 0)
    {
        $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT;
        if ($scopeId) {
            $scope = ScopeInterface::SCOPE_STORES;
            $scopeId = $this->storeManager->getStore($scopeId)->getId();
        }

        $this->configWriter->save($path, $value, $scope, $scopeId);
        $this->systemConfigType->clean();
    }

    /**
     * Read config value from storage.
     *
     * @param $path
     * @param int $scopeId
     * @return mixed
     */
    public function getConfigValue($path, $scopeId = null)
    {
        $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT;
        if ($scopeId) {
            $scope = ScopeInterface::SCOPE_STORE;
        }

        return $this->scopeConfig->getValue($path, $scope, $scopeId);
    }
}
