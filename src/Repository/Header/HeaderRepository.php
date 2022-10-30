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

use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Evrinoma\HeaderBundle\Dto\HeaderApiDtoInterface;
use Evrinoma\HeaderBundle\Exception\HeaderCannotBeSavedException;
use Evrinoma\HeaderBundle\Exception\HeaderNotFoundException;
use Evrinoma\HeaderBundle\Exception\HeaderProxyException;
use Evrinoma\HeaderBundle\Mediator\QueryMediatorInterface;
use Evrinoma\HeaderBundle\Model\Header\HeaderInterface;
use Evrinoma\UtilsBundle\Persistence\ManagerRegistryInterface;
use Evrinoma\UtilsBundle\Repository\RepositoryWrapperInterface;

class HeaderRepository extends HeaderRepositoryWrapper implements HeaderRepositoryInterface, RepositoryWrapperInterface
{
    private QueryMediatorInterface $mediator;

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

    /**
     * @param HeaderInterface $header
     *
     * @return bool
     *
     * @throws HeaderCannotBeSavedException
     * @throws ORMException
     */
    public function save(HeaderInterface $header): bool
    {
        try {
            $this->persistWrapped($header);
        } catch (ORMInvalidArgumentException $e) {
            throw new HeaderCannotBeSavedException($e->getMessage());
        }

        return true;
    }

    /**
     * @param HeaderInterface $header
     *
     * @return bool
     */
    public function remove(HeaderInterface $header): bool
    {
        return true;
    }

    /**
     * @param HeaderApiDtoInterface $dto
     *
     * @return array
     *
     * @throws HeaderNotFoundException
     */
    public function findByCriteria(HeaderApiDtoInterface $dto): array
    {
        $builder = $this->createQueryBuilderWrapped($this->mediator->alias());

        $this->mediator->createQuery($dto, $builder);

        $headers = $this->mediator->getResult($dto, $builder);

        if (0 === \count($headers)) {
            throw new HeaderNotFoundException('Cannot find header by findByCriteria');
        }

        return $headers;
    }

    /**
     * @param      $id
     * @param null $lockMode
     * @param null $lockVersion
     *
     * @return mixed
     *
     * @throws HeaderNotFoundException
     */
    public function find($id, $lockMode = null, $lockVersion = null): HeaderInterface
    {
        /** @var HeaderInterface $header */
        $header = $this->findWrapped($id);

        if (null === $header) {
            throw new HeaderNotFoundException("Cannot find header with id $id");
        }

        return $header;
    }

    /**
     * @param string $id
     *
     * @return HeaderInterface
     *
     * @throws HeaderProxyException
     * @throws ORMException
     */
    public function proxy(string $id): HeaderInterface
    {
        $header = $this->referenceWrapped($id);

        if (!$this->containsWrapped($header)) {
            throw new HeaderProxyException("Proxy doesn't exist with $id");
        }

        return $header;
    }
}
