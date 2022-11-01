# php-service-locator

![release](https://img.shields.io/github/v/release/mepihindeveloper/php-service-locator?label=version)
[![Packagist Version](https://img.shields.io/packagist/v/mepihindeveloper/php-service-locator)](https://packagist.org/packages/mepihindeveloper/php-service-locator)
[![PHP Version Require](http://poser.pugx.org/mepihindeveloper/php-service-locator/require/php)](https://packagist.org/packages/mepihindeveloper/php-service-locator)
![license](https://img.shields.io/github/license/mepihindeveloper/php-service-locator)

![build](https://github.com/mepihindeveloper/php-service-locator/actions/workflows/php.yml/badge.svg?branch=stable)
[![codecov](https://codecov.io/gh/mepihindeveloper/php-service-locator/branch/stable/graph/badge.svg?token=36PP7VKHKG)](https://codecov.io/gh/mepihindeveloper/php-service-locator)

Компонент-контейнер для работы с экземплярами классов-служб. Реализует логику контейнера служб по шаблону проектирования "Локатор служб". 

# Структура

```
src/
--- exceptions/
------ ContainerObjectInvalidTypeException.php
--- interfaces/
------ ServiceInterface.php
--- ServiceLocator.php
```

В директории `interfaces` хранятся необходимые интерфейсы, которые необходимо имплементировать в при реализации 
собственных классов служб. Класс `ServiceLocator` выступает в качестве контейнера служб. 
В директории `exceptions` хранятся необходимые исключения. Исключение `QueryStringNotFoundException` исключение необходимо для обозначения ошибки типа служб в контейнере.

Примерная реализация функционала:

```php
<?php

declare(strict_types = 1);

use mepihindeveloper\components\container\interfaces\ServiceInterface;
use mepihindeveloper\components\container\ServiceLocator;

error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

require_once 'vendor/autoload.php';

$serviceLocator = new ServiceLocator();
// Анонимный класс используется в тестах, но можно реализовать собственный класс.
$logger = new class implements ServiceInterface {
    protected string $filePath;

    public function __construct(string $filePath = '') {
        $this->filePath = $filePath;
    }

    /**
     * Получает путь к файлу
     * 
     * @return string
     */
    public function getFilePath(): string {
        return $this->filePath;
    }
};
$serviceLocator->addInstance(get_class($logger), $logger);
var_dump($serviceLocator->has(get_class($logger)), $serviceLocator->get(get_class($logger)));

// OR

$serviceLocator->addService(get_class($logger), ['/var/www/']);
$logger = $this->serviceLocator->get(get_class($logger));
var_dump($logger->getFilePath()); // /var/www/

```


# Доступные методы

## ServiceLocator

| Метод                                                    | Аргументы                                                                                                  | Возвращаемые данные | Исключения                                                      | Описание                              |
|----------------------------------------------------------|------------------------------------------------------------------------------------------------------------|---------------------|-----------------------------------------------------------------|---------------------------------------|
| get(string $id)                                          | Идентификатор службы (класс объекта object::class)                                                         | ServiceInterface    | ContainerObjectInvalidTypeException\|NotFoundExceptionInterface | Получает службу из контейнера         |
| has(string $id): bool                                    | Идентификатор службы (класс объекта object::class)                                                         | bool                |                                                                 | Проверяет наличие службы в контейнере |
| addService(string $id, array $params): void              | string $id Идентификатор класса-службы (object::class); array $params Аргументы конструктора класса-службы |                     |                                                                 | Добавляет класс-службу                |
| addInstance(string $id, ServiceInterface $service): void | string $id Идентификатор класса-службы (object::class); ServiceInterface $service Экземпляр класса-службы  |                     |                                                                 | Добавляет экземпляр класс-службу      |                                           |                                                            | QueryStringInterface         |                                                  | Формирует объект QueryString. Может быть изменен в конструкторе класса |

# Контакты

Вы можете связаться со мной в социальной сети ВКонтакте: [ВКонтакте: Максим Епихин](https://vk.com/maksimepikhin)

Если удобно писать на почту, то можете воспользоваться этим адресом: mepihindeveloper@gmail.com

Мой канал на YouTube, который посвящен разработке веб и игровых
проектов: [YouTube: Максим Епихин](https://www.youtube.com/channel/UCKusRcoHUy6T4sei-rVzCqQ)

Поддержать меня можно переводом на Яндекс.Деньги: [Денежный перевод](https://yoomoney.ru/to/410012382226565)