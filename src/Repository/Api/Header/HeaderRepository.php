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

namespace Evrinoma\HeaderBundle\Repository\Api\Header;

use Evrinoma\HeaderBundle\Mediator\QueryMediatorInterface;
use Evrinoma\HeaderBundle\Repository\Header\HeaderRepositoryInterface;
use Evrinoma\HeaderBundle\Repository\Header\HeaderRepositoryTrait;
use Evrinoma\UtilsBundle\Persistence\ManagerRegistryInterface;
use Evrinoma\UtilsBundle\Repository\Api\RepositoryWrapper;
use Evrinoma\UtilsBundle\Repository\RepositoryWrapperInterface;

class HeaderRepository extends RepositoryWrapper implements HeaderRepositoryInterface, RepositoryWrapperInterface
{
    use HeaderRepositoryTrait;

    /**
     * @param ManagerRegistryInterface $managerRegistry
     * @param string                   $entityClass
     * @param QueryMediatorInterface   $mediator
     */
    public function __construct(ManagerRegistryInterface $managerRegistry, string $entityClass, QueryMediatorInterface $mediator)
    {
        parent::__construct($managerRegistry);
        $this->mediator = $mediator;
        $this->entityClass = $entityClass;
    }
}
