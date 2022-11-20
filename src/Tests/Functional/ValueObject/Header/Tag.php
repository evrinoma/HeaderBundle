<?php

declare(strict_types=1);

/*
 * This file is part of the package.
 *
 * (c) Nikolay Nikolaev <evrinoma@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Evrinoma\HeaderBundle\Tests\Functional\ValueObject\Header;

use Evrinoma\HeaderBundle\Registry\ObjectInterface;
use Evrinoma\TestUtilsBundle\ValueObject\AbstractValueObject;

class Tag extends AbstractValueObject
{
    protected static string $value = 'test';
    protected static string $wrong = 'XXXX';
    protected static string $default = ObjectInterface::DEFAULT_TAG;

    public static function value(): string
    {
        return parent::value();
    }
}
