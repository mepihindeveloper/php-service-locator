<?php

use Codeception\Test\Unit;
use mepihindeveloper\components\container\exceptions\ContainerObjectInvalidTypeException;
use mepihindeveloper\components\container\interfaces\LogService;
use mepihindeveloper\components\container\interfaces\ServiceInterface;
use mepihindeveloper\components\container\ServiceLocator;

class ServiceLocatorTest extends Unit {

    /**
     * @var UnitTester
     */
    protected $tester;
    protected ServiceLocator $serviceLocator;
    protected $logger;

    public function testHasServiceIntance() {
        $this->serviceLocator->addInstance(get_class($this->logger), $this->logger);

        self::assertTrue($this->serviceLocator->has(get_class($this->logger)));
        self::assertFalse($this->serviceLocator->has(self::class));
    }

    public function testHasServices() {
        $this->serviceLocator->addService(get_class($this->logger), []);

        self::assertTrue($this->serviceLocator->has(get_class($this->logger)));
        self::assertFalse($this->serviceLocator->has(self::class));
    }

    public function testGet() {
        $this->serviceLocator->addService(get_class($this->logger), ['/var/www/']);
        $logger = $this->serviceLocator->get(get_class($this->logger));

        self::assertInstanceOf(get_class($this->logger), $logger);
    }

    public function testGetExistingInstance() {
        $this->serviceLocator->addInstance(get_class($this->logger), $this->logger);
        $logger = $this->serviceLocator->get(get_class($this->logger));

        self::assertInstanceOf(get_class($this->logger), $logger);
    }

    public function testGetWithException() {
        $this->expectException(ContainerObjectInvalidTypeException::class);
        $this->serviceLocator->addService(ServiceLocator::class, []);
        $object = $this->serviceLocator->get(ServiceLocator::class);
    }

    public function testServiceHasFilledFilePath() {
        $this->serviceLocator->addService(get_class($this->logger), ['/var/www/']);
        $logger = $this->serviceLocator->get(get_class($this->logger));

        self::assertSame('/var/www/', $logger->getFilePath());
    }

    protected function _before() {
        $this->serviceLocator = new ServiceLocator();
        $this->logger = new class implements ServiceInterface {

            protected string $filePath;

            public function __construct(string $filePath = '') {
                $this->filePath = $filePath;
            }

            public function getFilePath() {
                return $this->filePath;
            }
        };
    }
}