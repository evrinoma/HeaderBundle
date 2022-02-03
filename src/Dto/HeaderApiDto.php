<?php

namespace Evrinoma\HeaderBundle\Dto;

use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\IdentityTrait;
use Symfony\Component\HttpFoundation\Request;

class HeaderApiDto extends AbstractDto  implements HeaderApiDtoInterface
{
    use IdentityTrait;

    /**
     * @param string $identity
     *
     * @return HeaderApiDto
     */
    protected function setIdentity(string $identity): HeaderApiDto
    {
        $this->identity = $identity;

        return $this;
    }

    public function toDto(Request $request): DtoInterface
    {
        $class = $request->get(DtoInterface::DTO_CLASS);

        if ($class === $this->getClass()) {
            $identity = $request->get(HeaderApiDtoInterface::IDENTITY);

            if ($identity) {
                $this->setIdentity($identity);
            }
        }

        return $this;
    }
}