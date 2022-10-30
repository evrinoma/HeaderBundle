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

namespace Evrinoma\HeaderBundle\Factory;

use Evrinoma\HeaderBundle\Dto\HeaderApiDtoInterface;
use Evrinoma\HeaderBundle\Entity\Header\BaseHeader;
use Evrinoma\HeaderBundle\Model\Header\HeaderInterface;

class HeaderFactory implements HeaderFactoryInterface
{
    private static string $entityClass = BaseHeader::class;

    public function __construct(string $entityClass)
    {
        self::$entityClass = $entityClass;
    }

    /**
     * @param HeaderApiDtoInterface $dto
     *
     * @return HeaderInterface
     */
    public function create(HeaderApiDtoInterface $dto): HeaderInterface
    {
        /* @var BaseHeader $header */
        return new self::$entityClass();
    }
}
