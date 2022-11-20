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
use Evrinoma\HeaderBundle\Exception\HeaderCannotBeRemovedException;
use Evrinoma\HeaderBundle\Exception\HeaderCannotBeSavedException;
use Evrinoma\HeaderBundle\Exception\HeaderNotFoundException;
use Evrinoma\HeaderBundle\Exception\HeaderProxyException;
use Evrinoma\HeaderBundle\Exception\HeaderTagNotFoundException;
use Evrinoma\HeaderBundle\Mediator\QueryMediatorInterface;
use Evrinoma\HeaderBundle\Model\Header\HeaderInterface;

trait HeaderRepositoryTrait
{
    private QueryMediatorInterface $mediator;

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
     *
     * @throws HeaderCannotBeRemovedException
     * @throws ORMException
     */
    public function remove(HeaderInterface $header): bool
    {
        try {
            $this->removeWrapped($header);
        } catch (ORMInvalidArgumentException $e) {
            throw new HeaderCannotBeRemovedException($e->getMessage());
        }

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

    /**
     * @param HeaderApiDtoInterface $dto
     *
     * @return array
     *
     * @throws HeaderTagNotFoundException
     */
    public function findTags(HeaderApiDtoInterface $dto): array
    {
        $builder = $this->createQueryBuilderWrapped($this->mediator->alias());

        $this->mediator->createQueryTag($dto, $builder);

        $tags = $this->mediator->getResultTag($dto, $builder);

        if (0 === \count($tags)) {
            throw new HeaderTagNotFoundException('Cannot find tags by findTags');
        }

        return $tags;
    }
}
