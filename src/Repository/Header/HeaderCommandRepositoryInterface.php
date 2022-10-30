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

namespace Evrinoma\HeaderBundle\Repository\Header;

use Evrinoma\HeaderBundle\Exception\HeaderCannotBeRemovedException;
use Evrinoma\HeaderBundle\Exception\HeaderCannotBeSavedException;
use Evrinoma\HeaderBundle\Model\Header\HeaderInterface;

interface HeaderCommandRepositoryInterface
{
    /**
     * @param HeaderInterface $header
     *
     * @return bool
     *
     * @throws HeaderCannotBeSavedException
     */
    public function save(HeaderInterface $header): bool;

    /**
     * @param HeaderInterface $header
     *
     * @return bool
     *
     * @throws HeaderCannotBeRemovedException
     */
    public function remove(HeaderInterface $header): bool;
}
