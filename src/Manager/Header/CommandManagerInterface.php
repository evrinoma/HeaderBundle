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

namespace Evrinoma\HeaderBundle\Manager\Header;

use Evrinoma\HeaderBundle\Dto\HeaderApiDtoInterface;
use Evrinoma\HeaderBundle\Exception\HeaderCannotBeRemovedException;
use Evrinoma\HeaderBundle\Exception\HeaderInvalidException;
use Evrinoma\HeaderBundle\Exception\HeaderNotFoundException;
use Evrinoma\HeaderBundle\Model\Header\HeaderInterface;

interface CommandManagerInterface
{
    /**
     * @param HeaderApiDtoInterface $dto
     *
     * @return HeaderInterface
     *
     * @throws HeaderInvalidException
     */
    public function post(HeaderApiDtoInterface $dto): HeaderInterface;

    /**
     * @param HeaderApiDtoInterface $dto
     *
     * @return HeaderInterface
     *
     * @throws HeaderInvalidException
     * @throws HeaderNotFoundException
     */
    public function put(HeaderApiDtoInterface $dto): HeaderInterface;

    /**
     * @param HeaderApiDtoInterface $dto
     *
     * @throws HeaderCannotBeRemovedException
     * @throws HeaderNotFoundException
     */
    public function delete(HeaderApiDtoInterface $dto): void;
}
