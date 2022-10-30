<?php

namespace Evrinoma\HeaderBundle\Dto;

use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\IdentityTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\IdTrait;
use Symfony\Component\HttpFoundation\Request;

class HeaderApiDto extends AbstractDto implements HeaderApiDtoInterface
{
    use IdentityTrait;
    use IdTrait;

    public function toDto(Request $request): DtoInterface
    {
        $class = $request->get(DtoInterface::DTO_CLASS);

        if ($class === $this->getClass()) {
            $identity = $request->get(HeaderApiDtoInterface::IDENTITY);
            $id = $request->get(HeaderApiDtoInterface::ID);

            if ($identity) {
                $this->setIdentity($identity);
            }
            if ($id) {
                $this->setId($id);
            }
        }

        return $this;
    }
}