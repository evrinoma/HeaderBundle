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
use Evrinoma\HeaderBundle\Exception\HeaderNotFoundException;
use Evrinoma\HeaderBundle\Exception\HeaderProxyException;
use Evrinoma\HeaderBundle\Model\Header\HeaderInterface;

interface QueryManagerInterface
{
    /**
     * @param HeaderApiDtoInterface $dto
     *
     * @return array
     *
     * @throws HeaderNotFoundException
     */
    public function criteria(HeaderApiDtoInterface $dto): array;

    /**
     * @param HeaderApiDtoInterface $dto
     *
     * @return HeaderInterface
     *
     * @throws HeaderNotFoundException
     */
    public function get(HeaderApiDtoInterface $dto): HeaderInterface;

    /**
     * @param HeaderApiDtoInterface $dto
     *
     * @return HeaderInterface
     *
     * @throws HeaderProxyException
     */
    public function proxy(HeaderApiDtoInterface $dto): HeaderInterface;

    /**
     * @param HeaderApiDtoInterface $dto
     *
     * @return array
     *
     * @throws HeaderNotFoundException
     */
    public function tags(HeaderApiDtoInterface $dto): array;
}
