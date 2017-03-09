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
 * @package   Dhl\Shipping\Test\Integration
 * @author    Christoph Aßmann <christoph.assmann@netresearch.de>
 * @copyright 2017 Netresearch GmbH & Co. KG
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.netresearch.de/
 */
namespace Dhl\Shipping\Model\Checkout;

use \Magento\TestFramework\ObjectManager;

/**
 * CheckoutInfoTest
 *
 * @category Dhl
 * @package  Dhl\Shipping\Test\Integration
 * @author   Christoph Aßmann <christoph.assmann@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.netresearch.de/
 */
class CheckoutInfoTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var CheckoutInfo
     */
    private $checkoutInfo;

    protected function setUp()
    {
        parent::setUp();

        $this->objectManager = ObjectManager::getInstance();
        $this->checkoutInfo = $this->objectManager->create(CheckoutInfo::class);
    }

    /**
     * Simple in / out test
     *
     * @test
     */
    public function getServices()
    {
        $services = ['foo domestic', 'foo express'];

        $this->checkoutInfo->setServices($services);
        $result = $this->checkoutInfo->getServices();

        $this->assertInternalType('array', $result);
        foreach ($services as $service) {
            $this->assertContains($service, $result);
        }
    }

    /**
     * Simple in / out test
     *
     * @test
     */
    public function getPostalFacility()
    {
        $postalFacility = 'packstation';

        $this->checkoutInfo->setPostalFacility($postalFacility);

        $this->assertEquals($postalFacility, $this->checkoutInfo->getPostalFacility());
    }
}
