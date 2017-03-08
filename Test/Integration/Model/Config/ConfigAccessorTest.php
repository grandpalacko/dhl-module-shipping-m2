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
namespace Dhl\Shipping\Model\Config;

use \Magento\TestFramework\ObjectManager;

/**
 * ConfigTest
 *
 * @category Dhl
 * @package  Dhl\Shipping\Test\Integration
 * @author   Christoph Aßmann <christoph.assmann@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.netresearch.de/
 */
class ConfigAccessorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var $objectManager ObjectManager
     */
    private $objectManager;

    /** @var  ConfigAccessor */
    private $configModel;

    protected function setUp()
    {
        parent::setUp();
        $this->objectManager = ObjectManager::getInstance();
    }

    /**
     * @test
     */
    public function saveConfig()
    {
        $path  = GlConfig::CONFIG_XML_PATH_AUTH_USERNAME;
        $value = 'myTestValue';

        $writerMock = $this->getMock(
            \Magento\Framework\App\Config\Storage\Writer::class,
            ['save'],
            [],
            '',
            false
        );

        $writerMock
            ->expects($this->once())
            ->method('save')
            ->with($path, $value);

        $this->configModel = $this->objectManager->create(
            \Dhl\Shipping\Model\Config\ConfigAccessor::class,
            ['configWriter' => $writerMock]
        );
        $this->configModel->saveConfigValue($path, $value, 1);
    }

    /**
     * @test
     */
    public function getConfig()
    {
        $path  = GlConfig::CONFIG_XML_PATH_AUTH_USERNAME;

        $scopeConfigMock = $this->getMock(
            \Magento\Framework\App\Config::class,
            ['getValue'],
            [],
            '',
            false
        );

        $scopeConfigMock
            ->expects($this->once())
            ->method('getValue')
            ->with($path, 'store', 'store');

        $this->configModel = $this->objectManager->create(
            \Dhl\Shipping\Model\Config\ConfigAccessor::class,
            ['scopeConfig' => $scopeConfigMock]
        );
        $this->configModel->getConfigValue($path, 'store');
    }
}
