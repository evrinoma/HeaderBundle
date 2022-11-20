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

namespace Evrinoma\HeaderBundle\Dto\Preserve;

use Evrinoma\DtoCommon\ValueObject\Mutable\IdentityInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\IdInterface;
use Evrinoma\HeaderBundle\DtoCommon\ValueObject\Mutable\TagInterface;

interface HeaderApiDtoInterface extends IdInterface, IdentityInterface, TagInterface
{
}
