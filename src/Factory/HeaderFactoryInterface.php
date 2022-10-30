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

namespace Evrinoma\HeaderBundle\Factory;

use Evrinoma\HeaderBundle\Dto\HeaderApiDtoInterface;
use Evrinoma\HeaderBundle\Model\Header\HeaderInterface;

interface HeaderFactoryInterface
{
    /**
     * @param HeaderApiDtoInterface $dto
     *
     * @return HeaderInterface
     */
    public function create(HeaderApiDtoInterface $dto): HeaderInterface;
}
