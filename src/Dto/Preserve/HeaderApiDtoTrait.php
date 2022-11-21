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

use Evrinoma\DtoCommon\ValueObject\Preserve\IdentityTrait;
use Evrinoma\DtoCommon\ValueObject\Preserve\IdTrait;
use Evrinoma\HeaderBundle\DtoCommon\ValueObject\Preserve\TagTrait;

trait HeaderApiDtoTrait
{
    use IdentityTrait;
    use IdTrait;
    use TagTrait;
}
