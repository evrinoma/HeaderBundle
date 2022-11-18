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
use Evrinoma\UtilsBundle\QueryBuilder\QueryBuilderInterface;

interface TagQueryMediatorInterface
{
    /**
     * @param HeaderApiDtoInterface   $dto
     * @param QueryBuilderInterface $builder
     *
     * @return mixed
     */
    public function createQueryTag(HeaderApiDtoInterface $dto, QueryBuilderInterface $builder): void;

    /**
     * @param HeaderApiDtoInterface   $dto
     * @param QueryBuilderInterface $builder
     *
     * @return array
     */
    public function getResultTag(HeaderApiDtoInterface $dto, QueryBuilderInterface $builder): array;
}
