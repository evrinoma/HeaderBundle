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

namespace Evrinoma\HeaderBundle\Dto;

use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\IdentityTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\IdTrait;
use Evrinoma\HeaderBundle\DtoCommon\ValueObject\Mutable\TagTrait;
use Symfony\Component\HttpFoundation\Request;

class HeaderApiDto extends AbstractDto implements HeaderApiDtoInterface
{
    use IdentityTrait;
    use IdTrait;
    use TagTrait;

    public function toDto(Request $request): DtoInterface
    {
        $class = $request->get(DtoInterface::DTO_CLASS);

        if ($class === $this->getClass()) {
            $identity = $request->get(HeaderApiDtoInterface::IDENTITY);
            $id = $request->get(HeaderApiDtoInterface::ID);
            $tag = $request->get(HeaderApiDtoInterface::TAG);

            if ($identity) {
                $this->setIdentity($identity);
            }
            if ($id) {
                $this->setId($id);
            }
            if ($tag) {
                $this->setTag($tag);
            }
        }

        return $this;
    }
}
