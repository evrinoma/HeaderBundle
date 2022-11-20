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
use Evrinoma\HeaderBundle\Repository\AliasInterface;
use Evrinoma\UtilsBundle\Mediator\AbstractQueryMediator;
use Evrinoma\UtilsBundle\Mediator\Orm\QueryMediatorTrait;
use Evrinoma\UtilsBundle\QueryBuilder\QueryBuilderInterface;

class QueryMediator extends AbstractQueryMediator implements QueryMediatorInterface
{
    use QueryMediatorTrait;

    protected static string $alias = AliasInterface::HEADER;

    /**
     * @param DtoInterface          $dto
     * @param QueryBuilderInterface $builder
     *
     * @return mixed
     */
    public function createQuery(DtoInterface $dto, QueryBuilderInterface $builder): void
    {
        $alias = $this->alias();

        /** @var $dto HeaderApiDtoInterface */
        if ($dto->hasId()) {
            $builder
                ->andWhere($alias.'.id = :id')
                ->setParameter('id', $dto->getId());
        }

        if ($dto->hasIdentity()) {
            $builder
                ->andWhere($alias.'.identity like :identity')
                ->setParameter('identity', '%'.$dto->getIdentity().'%');
        }

        if ($dto->hasTag()) {
            $builder
                ->andWhere($alias.'.tag = :tag')
                ->setParameter('tag', $dto->getTag());
        }
    }

    public function createQueryTag(HeaderApiDtoInterface $dto, QueryBuilderInterface $builder): void
    {
        $alias = $this->alias();

        $builder
            ->select($alias.'.tag')
            ->groupBy($alias.'.tag');
    }

    public function getResultTag(HeaderApiDtoInterface $dto, QueryBuilderInterface $builder): array
    {
        return array_column($this->getResult($dto, $builder), 'tag');
    }
}
