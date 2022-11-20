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

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\HeaderBundle\Dto\HeaderApiDtoInterface;
use Evrinoma\HeaderBundle\Exception\HeaderInvalidException;
use Evrinoma\UtilsBundle\PreValidator\AbstractPreValidator;

class DtoPreValidator extends AbstractPreValidator implements DtoPreValidatorInterface
{
    public function onPost(DtoInterface $dto): void
    {
        $this->checkTag($dto);
        $this->checkIdentity($dto);
    }

    public function onPut(DtoInterface $dto): void
    {
        $this->checkId($dto);
        $this->checkTag($dto);
        $this->checkIdentity($dto);
    }

    public function onDelete(DtoInterface $dto): void
    {
        $this->checkId($dto);
    }

    private function checkId(DtoInterface $dto): void
    {
        /** @var HeaderApiDtoInterface $dto */
        if (!$dto->hasId()) {
            throw new HeaderInvalidException('The Dto has\'t ID or class invalid');
        }
    }

    private function checkTag(DtoInterface $dto): void
    {
        /** @var HeaderApiDtoInterface $dto */
        if (!$dto->hasTag()) {
            throw new HeaderInvalidException('The Dto has\'t Tag or class invalid');
        }
    }

    private function checkIdentity(DtoInterface $dto): void
    {
        /** @var HeaderApiDtoInterface $dto */
        if (!$dto->hasIdentity()) {
            throw new HeaderInvalidException('The Dto has\'t Identity or class invalid');
        }
    }
}
