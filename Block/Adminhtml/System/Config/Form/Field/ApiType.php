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
 * @author    Sebastian Ertner <sebastian.ertner@netresearch.de>
 * @copyright 2017 Netresearch GmbH & Co. KG
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.netresearch.de/
 */
namespace Dhl\Shipping\Block\Adminhtml\System\Config\Form\Field;

use Dhl\Shipping\Model\Adminhtml\System\Config\Source\ApiType as Source;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Shipping\Model\Config as ShippingConfig;
use Magento\Store\Model\ScopeInterface;

/**
 * Config field block for the current API type. API type depends on shipping
 * origin country in the same scope, it is not meant to be configured manually.
 * The field is used as reference for config field dependencies.
 *
 * @category Dhl
 * @package  Dhl\Shipping
 * @author   Sebastian Ertner <sebastian.ertner@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.netresearch.de/
 */
class ApiType extends Field
{
    /**
     * @param AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        $element->setData('inherit', false);
        $element->setData('disabled', false);

        if ($this->getData('value')) {
            return parent::_getElementHtml($element);
        }

        $scopeId = $this->_request->getParam('website', 0);
        if ($scopeId) {
            $shippingOrigin = $this->_scopeConfig->getValue(
                ShippingConfig::XML_PATH_ORIGIN_COUNTRY_ID,
                ScopeInterface::SCOPE_WEBSITE,
                $scopeId
            );
        } else {
            $shippingOrigin = $this->_scopeConfig->getValue(ShippingConfig::XML_PATH_ORIGIN_COUNTRY_ID);
        }

        switch ($shippingOrigin) {
            case 'DE':
            case 'AT':
                $element->setData('value', Source::API_TYPE_BCS);
                break;
            default:
                $element->setData('value', Source::API_TYPE_GLA);
        }

        return parent::_getElementHtml($element);
    }
}
