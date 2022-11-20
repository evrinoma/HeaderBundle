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

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\HeaderBundle\Dto\HeaderApiDtoInterface;
use Evrinoma\HeaderBundle\Model\Header\HeaderInterface;
use Evrinoma\UtilsBundle\Mediator\AbstractCommandMediator;

class CommandMediator extends AbstractCommandMediator implements CommandMediatorInterface
{
    public function onUpdate(DtoInterface $dto, $entity): HeaderInterface
    {
        /* @var $dto HeaderApiDtoInterface */
        $entity
            ->setIdentity($dto->getIdentity())
            ->setTag($dto->getTag());

        return $entity;
    }

    public function onDelete(DtoInterface $dto, $entity): void
    {
    }

    public function onCreate(DtoInterface $dto, $entity): HeaderInterface
    {
        /* @var $dto HeaderApiDtoInterface */
        $entity
            ->setIdentity($dto->getIdentity())
            ->setTag($dto->getTag());

        return $entity;
    }
}
