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

use Evrinoma\HeaderBundle\Dto\HeaderApiDtoInterface;
use Evrinoma\HeaderBundle\Registry\ObjectRegistryInterface;
use Evrinoma\UtilsBundle\Repository\Api\RepositoryWrapper;

abstract class HeaderRepositoryWrapper extends RepositoryWrapper
{
    public function persistWrapped($entity): void
    {
    }

    public function removeWrapped($entity): void
    {
    }

    public function findWrapped($id, $lockMode = null, $lockVersion = null)
    {
        return null;
    }

    protected function criteriaWrapped($entity): array
    {
        /** @var ObjectRegistryInterface $manager */
        $manager = $this->managerRegistry->getManager(ObjectRegistryInterface::class);
        $headers = $manager->getObjects();

        /* @var HeaderapiDtoInterface $entity */
        return (\array_key_exists($entity->getIdentity(), $headers)) ? $headers[$entity->getIdentity()]->create() : [];
    }
}
