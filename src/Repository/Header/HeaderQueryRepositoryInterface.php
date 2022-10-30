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
use Evrinoma\HeaderBundle\Dto\HeaderApiDtoInterface;
use Evrinoma\HeaderBundle\Exception\HeaderNotFoundException;
use Evrinoma\HeaderBundle\Exception\HeaderProxyException;
use Evrinoma\HeaderBundle\Model\Header\HeaderInterface;

interface HeaderQueryRepositoryInterface
{
    /**
     * @param HeaderApiDtoInterface $dto
     *
     * @return array
     *
     * @throws HeaderNotFoundException
     */
    public function findByCriteria(HeaderApiDtoInterface $dto): array;

    /**
     * @param string $id
     * @param null   $lockMode
     * @param null   $lockVersion
     *
     * @return HeaderInterface
     *
     * @throws HeaderNotFoundException
     */
    public function find(string $id, $lockMode = null, $lockVersion = null): HeaderInterface;

    /**
     * @param string $id
     *
     * @return HeaderInterface
     *
     * @throws HeaderProxyException
     * @throws ORMException
     */
    public function proxy(string $id): HeaderInterface;
}
