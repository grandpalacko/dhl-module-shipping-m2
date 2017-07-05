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
 * @package   Dhl\Shipping\Webservice
 * @author    Christoph Aßmann <christoph.assmann@netresearch.de>
 * @copyright 2017 Netresearch GmbH & Co. KG
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.netresearch.de/
 */

namespace Dhl\Shipping\Webservice;

use \Dhl\Shipping\Webservice\RequestType\CreateShipment\ShipmentOrder\Service\AbstractServiceFactory;
use \Dhl\Shipping\Webservice\RequestType\CreateShipment\ShipmentOrder\Service\CodFactory;

/**
 * Generic service factory
 *
 * @category Dhl
 * @package  Dhl\Shipping\Webservice
 * @author   Christoph Aßmann <christoph.assmann@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.netresearch.de/
 */
class RequestServiceFactory extends AbstractServiceFactory
{
    /**
     * @var CodFactory
     */
    private $codFactory;

    /**
     * RequestServiceFactory constructor.
     * @param CodFactory $codFactory
     */
    public function __construct(CodFactory $codFactory)
    {
        $this->codFactory = $codFactory;
    }

    /**
     * Create class instance with specified parameters
     *
     * @param string $instanceCode
     * @param mixed[] $data
     * @return \Dhl\Shipping\Webservice\RequestType\CreateShipment\ShipmentOrder\Service\ServiceInterface
     */
    public function create($instanceCode, array $data = [])
    {
        switch ($instanceCode) {
            case AbstractServiceFactory::SERVICE_CODE_COD:
                return $this->codFactory->create($data);
            default:
                return null;
        }
    }
}
