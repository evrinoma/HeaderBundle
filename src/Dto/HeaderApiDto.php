<?php

namespace Evrinoma\HeaderBundle\Dto;

use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\HeaderBundle\Model\HeaderModelInterface;
use Symfony\Component\HttpFoundation\Request;

class HeaderApiDto extends AbstractDto  implements HeaderApiDtoInterface
{
    private string $identity = '';

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

    public function hasIdentity(): bool
    {
        return $this->identity !== '';
    }

    /**
     * @return string
     */
    public function getIdentity(): string
    {
        return $this->identity;
    }

    public function toDto(Request $request): DtoInterface
    {
        $class = $request->get(DtoInterface::DTO_CLASS);

        if ($class === $this->getClass()) {
            $identity   = $request->get(HeaderModelInterface::IDENTITY);

            if ($identity) {
                $this->setIdentity($identity);
            }
        }

        return $this;
    }
}