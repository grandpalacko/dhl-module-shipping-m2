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
 * @package   Dhl\Shipping\Test\Unit
 * @author    Christoph Aßmann <christoph.assmann@netresearch.de>
 * @copyright 2017 Netresearch GmbH & Co. KG
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.netresearch.de/
 */
namespace Dhl\Shipping\Model\Adminhtml\System\Config\Source;

use \Dhl\Shipping\Model\Adminhtml\System\Config\Source\Loglevel;
use \Magento\Framework\TestFramework\Unit\Helper\ObjectManager;

/**
 * LoglevelTest
 *
 * @category Dhl
 * @package  Dhl\Shipping\Test\Unit
 * @author   Christoph Aßmann <christoph.assmann@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.netresearch.de/
 */
class LoglevelTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    protected function setUp()
    {
        parent::setUp();
        $this->objectManager = new ObjectManager($this);
    }

    /**
     * @test
     */
    public function sourceModel()
    {
        $sourceModel = $this->objectManager->getObject(Loglevel::class);
        $optionArray = $sourceModel->toOptionArray();

        foreach ($optionArray as $option) {
            $this->assertInternalType('array', $option);
            $this->assertArrayHasKey('value', $option);
            $this->assertArrayHasKey('label', $option);
            $this->assertInternalType('int', $option['value']);
            $this->assertLessThanOrEqual(\Monolog\Logger::ERROR, $option['value']);
        }
    }
}
