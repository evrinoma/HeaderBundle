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

namespace Evrinoma\HeaderBundle\PreValidator;

use Evrinoma\HeaderBundle\Dto\HeaderApiDtoInterface;
use Evrinoma\HeaderBundle\Exception\HeaderInvalidException;

interface DtoPreValidatorInterface
{
    /**
     * @param HeaderApiDtoInterface $dto
     *
     * @throws HeaderInvalidException
     */
    public function onPost(HeaderApiDtoInterface $dto): void;

    /**
     * @param HeaderApiDtoInterface $dto
     *
     * @throws HeaderInvalidException
     */
    public function onPut(HeaderApiDtoInterface $dto): void;

    /**
     * @param HeaderApiDtoInterface $dto
     *
     * @throws HeaderInvalidException
     */
    public function onDelete(HeaderApiDtoInterface $dto): void;
}
