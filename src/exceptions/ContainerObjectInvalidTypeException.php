<?php

declare(strict_types = 1);

namespace mepihindeveloper\components\container\exceptions;

use Psr\Container\ContainerExceptionInterface;
use TheSeer\Tokenizer\Exception;

/**
 * Class ContainerObjectInvalidTypeException
 *
 * Данное исключение необходимо для обозначения ошибки типа служб в контейнере
 *
 * @package mepihindeveloper\components\container\exceptions
 */
class ContainerObjectInvalidTypeException extends Exception implements ContainerExceptionInterface {

}