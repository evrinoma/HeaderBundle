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

namespace Evrinoma\HeaderBundle\Mediator;

use Evrinoma\HeaderBundle\Dto\HeaderApiDtoInterface;
use Evrinoma\HeaderBundle\Exception\HeaderCannotBeCreatedException;
use Evrinoma\HeaderBundle\Exception\HeaderCannotBeRemovedException;
use Evrinoma\HeaderBundle\Exception\HeaderCannotBeSavedException;
use Evrinoma\HeaderBundle\Model\Header\HeaderInterface;

interface CommandMediatorInterface
{
    /**
     * @param HeaderApiDtoInterface $dto
     * @param HeaderInterface       $entity
     *
     * @return HeaderInterface
     *
     * @throws HeaderCannotBeSavedException
     */
    public function onUpdate(HeaderApiDtoInterface $dto, HeaderInterface $entity): HeaderInterface;

    /**
     * @param HeaderApiDtoInterface $dto
     * @param HeaderInterface       $entity
     *
     * @throws HeaderCannotBeRemovedException
     */
    public function onDelete(HeaderApiDtoInterface $dto, HeaderInterface $entity): void;

    /**
     * @param HeaderApiDtoInterface $dto
     * @param HeaderInterface       $entity
     *
     * @return HeaderInterface
     *
     * @throws HeaderCannotBeSavedException
     * @throws HeaderCannotBeCreatedException
     */
    public function onCreate(HeaderApiDtoInterface $dto, HeaderInterface $entity): HeaderInterface;
}
