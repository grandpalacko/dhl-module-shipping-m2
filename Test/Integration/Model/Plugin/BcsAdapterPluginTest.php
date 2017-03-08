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
 * @author    Sebastian Ertner <sebastian.ertner@netresearch.de>
 * @copyright 2017 Netresearch GmbH & Co. KG
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.netresearch.de/
 */
namespace Dhl\Shipping\Model\Plugin;

use Magento\TestFramework\Interception\PluginList;
use \Magento\TestFramework\ObjectManager;

/**
 * ConfigTest
 *
 * @category Dhl
 * @package  Dhl\Shipping\Test\Integration
 * @author   Sebastian Ertner <sebastian.ertner@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.netresearch.de/
 */
class BcsAdapterPluginTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var $objectManager ObjectManager
     */
    private $objectManager;

    /**
     * @var \Dhl\Shipping\Webservice\Adapter\BcsAdapter|\PHPUnit_Framework_MockObject_MockObject
     */
    private $bcsAdapter;

    public function setUp()
    {
        parent::setUp();
        $this->objectManager = ObjectManager::getInstance();
        $this->objectManager->removeSharedInstance(PluginList::class);
        $this->objectManager->removeSharedInstance(\Dhl\Shipping\Model\Plugin\BcsAdapterPlugin::class);
    }

    public function getValidOrder()
    {
        $order = \Dhl\Shipping\Test\Integration\Provider\ShipmentOrderProvider::getValidOrder();
        return $order;
    }

    /**
     * @test
     * @dataProvider getValidOrder
     */
    public function logDebug($shipmentOrder)
    {
        $bcsSoapClient = $this->getMock(
            \Dhl\Shipping\Webservice\Client\BcsSoapClient::class,
            ['createShipmentOrder'],
            [],
            '',
            false
        );

        $bcsSoapClient
            ->expects($this->once())
            ->method('createShipmentOrder');

        $loggerMock = $this->getMock(
            \Dhl\Shipping\Webservice\Logger::class,
            ['wsDebug', 'log', 'wsWarning', 'wsError'],
            [],
            '',
            false
        );

        $loggerMock
            ->expects($this->once())
            ->method('wsDebug');

        $loggerMock
            ->expects($this->never())
            ->method('wsWarning');

        $loggerMock
            ->expects($this->never())
            ->method('wsError');

        $this->objectManager->addSharedInstance($loggerMock, \Dhl\Shipping\Webservice\Logger::class);

        $mapperMock =  $this->getMock(\Dhl\Shipping\Webservice\BcsDataMapper::class,[],[],'',false);
        $parserMock = $this->getMock(
            \Dhl\Shipping\Webservice\ResponseParser\BcsResponseParser::class,
            ['parseCreateShipmentResponse'],
            [],
            '',
            false
        );

        $parserMock
            ->expects($this->once())
            ->method('parseCreateShipmentResponse')
            ->will($this->returnValue('foo'));


        $bcsAdapter = $this->objectManager->create(
            \Dhl\Shipping\Webservice\Adapter\BcsAdapter::class,
            [
                'soapClient' => $bcsSoapClient,
                'dataMapper' => $mapperMock,
                'responseParser' => $parserMock
            ]
        );

        $bcsAdapter->createLabels([$shipmentOrder]);
    }

    /**
     * @test
     * @dataProvider getValidOrder
     */
    public function logError($shipmentOrder)
    {
        $bcsSoapClient = $this->getMock(
            \Dhl\Shipping\Webservice\Client\BcsSoapClient::class,
            ['createShipmentOrder'],
            [],
            '',
            false
        );

        $bcsSoapClient
            ->expects($this->once())
            ->method('createShipmentOrder')
            ->willThrowException(new \SoapFault('1', 'error'));

        $loggerMock = $this->getMock(
            \Dhl\Shipping\Webservice\Logger::class,
            ['wsDebug', 'log', 'wsWarning', 'wsError'],
            [],
            '',
            false
        );

        $loggerMock
            ->expects($this->never())
            ->method('wsDebug');

        $loggerMock
            ->expects($this->never())
            ->method('wsWarning');

        $loggerMock
            ->expects($this->once())
            ->method('wsError');

        $this->objectManager->addSharedInstance($loggerMock, \Dhl\Shipping\Webservice\Logger::class);

        $mapperMock =  $this->getMock(\Dhl\Shipping\Webservice\BcsDataMapper::class,[],[],'',false);

        $bcsAdapter = $this->objectManager->create(
            \Dhl\Shipping\Webservice\Adapter\BcsAdapter::class,
            [
                'soapClient' => $bcsSoapClient,
                'dataMapper' => $mapperMock
            ]
        );

        $this->setExpectedException(\SoapFault::class);
        $bcsAdapter->createLabels([$shipmentOrder]);

    }

    /**
     * @test
     * @dataProvider getValidOrder
     */
    public function logWarning($shipmentOrder)
    {
        $bcsSoapClient = $this->getMock(
            \Dhl\Shipping\Webservice\Client\BcsSoapClient::class,
            ['createShipmentOrder'],
            [],
            '',
            false
        );

        $createShipmentStatusExceptionMock = $this->getMock(
            \Dhl\Shipping\Webservice\CreateShipmentStatusException::class,
            [],
            [],
            '',
            false
        );

        $bcsSoapClient
            ->expects($this->once())
            ->method('createShipmentOrder')
            ->willThrowException($createShipmentStatusExceptionMock);

        $loggerMock = $this->getMock(
            \Dhl\Shipping\Webservice\Logger::class,
            ['wsDebug', 'log', 'wsWarning'],
            [],
            '',
            false
        );

        $loggerMock
            ->expects($this->never())
            ->method('wsDebug');

        $loggerMock
            ->expects($this->once())
            ->method('wsWarning');

        $this->objectManager->addSharedInstance($loggerMock, \Dhl\Shipping\Webservice\Logger::class);

        $mapperMock =  $this->getMock(\Dhl\Shipping\Webservice\BcsDataMapper::class,[],[],'',false);

        $this->bcsAdapter = $this->objectManager->create(
            \Dhl\Shipping\Webservice\Adapter\BcsAdapter::class,
            [
                'soapClient' => $bcsSoapClient,
                'dataMapper' => $mapperMock
            ]
        );


        $this->setExpectedException(\Dhl\Shipping\Webservice\CreateShipmentStatusException::class);
        $this->bcsAdapter->createLabels([$shipmentOrder]);
    }

}
