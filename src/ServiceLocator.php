<?php

declare(strict_types = 1);

namespace mepihindeveloper\components\container;

use mepihindeveloper\components\container\exceptions\ContainerObjectInvalidTypeException;
use mepihindeveloper\components\container\interfaces\ServiceInterface;
use Psr\Container\ContainerInterface;

/**
 * Class ServiceLocator
 *
 * Данный класс реализует логику контейнера служб по шаблону проектирования "Локатор служб".
 *
 * @package mepihindeveloper\components\container
 */
class ServiceLocator implements ContainerInterface {

    /** @var array Карта классов и параметров. Параметры - аргументы конструктора */
    protected array $services = [];
    /** @var ServiceInterface[] Экземпляры сервисов */
    protected array $instances = [];

    /**
     * @inheritDoc
     */
    public function get(string $id) {
        if (array_key_exists($id, $this->instances)) {
            return $this->instances[$id];
        }

        $serviceInstance = new $id(...$this->services[$id]);

        if (!($serviceInstance instanceof ServiceInterface)) {
            throw new ContainerObjectInvalidTypeException('Не удалось зарегистрировать службу: нет экземпляра службы');
        }

        $this->instances[$id] = $serviceInstance;

        return $serviceInstance;
    }

    /**
     * @inheritDoc
     */
    public function has(string $id): bool {
        return array_key_exists($id, $this->services) || array_key_exists($id, $this->instances);
    }

    /**
     * Добавляет класс-службу
     *
     * @param string $id     Идентификатор класса-службы (object::class)
     * @param array  $params Аргументы конструктора класса-службы
     */
    public function addService(string $id, array $params): void {
        $this->services[$id] = $params;
    }

    /**
     * Добавляет экземпляр класс-службу
     *
     * @param string           $id      Идентификатор класса-службы (object::class)
     * @param ServiceInterface $service Экземпляр класса-службы
     */
    public function addInstance(string $id, ServiceInterface $service): void {
        $this->instances[$id] = $service;
    }
}