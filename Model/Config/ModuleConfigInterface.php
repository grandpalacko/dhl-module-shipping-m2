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
 * @copyright 2017 Netresearch GmbH & Co. KG
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.netresearch.de/
 */
namespace Dhl\Shipping\Model\Config;

/**
 * ModuleConfigInterface
 *
 * @category Dhl
 * @package  Dhl\Shipping
 * @author   Christoph Aßmann <christoph.assmann@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.netresearch.de/
 */
interface ModuleConfigInterface
{
    const CONFIG_XML_PATH_TITLE = 'carriers/dhlshipping/title';
    const CONFIG_XML_PATH_LOG_LEVEL = 'carriers/dhlshipping/log_level';
    const CONFIG_XML_PATH_DHLMETHODS = 'carriers/dhlshipping/shipment_dhlmethods';
    const CONFIG_XML_PATH_CODMETHODS = 'carriers/dhlshipping/shipment_dhlcodmethods';
    const CONFIG_XML_PATH_LOGGING_ENABLED = 'carriers/dhlshipping/logging_enabled';
    const CONFIG_XML_PATH_DEFAULT_PRODUCT = 'carriers/dhlshipping/default_shipping_product';
    const CONFIG_XML_PATH_SANDBOX_MODE = 'carriers/dhlshipping/sandbox_mode';

    const CONFIG_XML_PATH_AUTOCREATE_ENABLED = 'carriers/dhlshipping/shipment_autocreate_enabled';
    const CONFIG_XML_PATH_AUTOCREATE_ORDER_STATUS = 'carriers/dhlshipping/shipment_autocreate_order_status';
    const CONFIG_XML_PATH_AUTOCREATE_NOTIFY_CUSTOMER = 'carriers/dhlshipping/shipment_autocreate_send_shippinginfo';

    /**
     * Check if logging is enabled
     *
     * @param int $level
     * @return bool
     */
    public function isLoggingEnabled($level = null);

    /**
     * Check if Sandbox mode is enabled.
     *
     * @param mixed $store
     * @return bool
     */
    public function isSandboxModeEnabled($store = null);

    /**
     * @param mixed $store
     * @return array
     */
    public function getEuCountryList($store = null);

    /**
     * Obtain the shipping method that should be processed with DHL Shipping.
     *
     * @param mixed $store
     * @return string[]
     */
    public function getShippingMethods($store = null);

    /**
     * Obtain the payment methods that should be treated as COD.
     *
     * @param mixed $store
     * @return string[]
     */
    public function getCodPaymentMethods($store = null);

    /**
     * Obtain the default product setting. This is used to highlight one
     * shipping product in case multiple products apply to the current route.
     *
     * @param mixed $store
     * @return string
     */
    public function getDefaultProduct($store = null);

    /**
     * Obtain shipper country from shipping origin configuration.
     *
     * @param mixed $store
     * @return string
     */
    public function getShipperCountry($store = null);

    /**
     * Check if the given origin/destination combination can be processed with DHL Shipping.
     *
     * @see canProcessShipping()
     * @param string $destinationCountryId
     * @param mixed $store
     * @return bool
     */
    public function canProcessRoute($destinationCountryId, $store = null);

    /**
     * Check if the given shipping method should be processed with DHL Shipping.
     *
     * @see canProcessShipping()
     * @param string $shippingMethod
     * @param mixed $store
     * @return bool
     */
    public function canProcessMethod($shippingMethod, $store = null);

    /**
     * Check if the current order can be shipped with DHL Shipping (incl. shipping method and route).
     *
     * @param string $shippingMethod
     * @param string $destCountryId
     * @param mixed $store
     * @return bool
     */
    public function canProcessShipping($shippingMethod, $destCountryId, $store = null);

    /**
     * Check if the given payment method is cash on delivery.
     *
     * @param string $paymentMethod
     * @param mixed $store
     * @return bool
     */
    public function isCodPaymentMethod($paymentMethod, $store = null);

    /**
     * Checks if the route is crossing borders for given store configuration
     *
     * @param int $destinationCountryId
     * @param int|null $storeId
     * @return bool
     */
    public function isCrossBorderRoute($destinationCountryId, $storeId = null);

    /**
     * Get allowed order statuses for automatic shipment creation
     *
     * @param null $store
     * @return mixed
     */
    public function getAutoCreateOrderStatus($store = null);

    /**
     * Get Notify Customer config.
     *
     * @param null $store
     * @return bool
     */
    public function getAutoCreateNotifyCustomer($store = null);
}
