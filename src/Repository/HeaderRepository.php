<?php

namespace Evrinoma\HeaderBundle\Repository;

use Evrinoma\HeaderBundle\Dto\HeaderApiDtoInterface;
use Evrinoma\HeaderBundle\Entity\HeaderInterface;
use Evrinoma\HeaderBundle\Exception\HeaderNotFoundException;


class HeaderRepository implements HeaderRepositoryInterface
{
//region SECTION: Fields
    /**
     * @var HeaderInterface[]
     */
    private array $headers = [];
//endregion Fields

//region SECTION: Public
    public function addHeader(HeaderInterface $header): void
    {
        $this->headers[$header->getName()] = $header;
    }
//endregion Public

//region SECTION: Find Filters Repository
    /**
     * @param HeaderApiDtoInterface $dto
     *
     * @return array
     * @throws HeaderNotFoundException
     */
    public function findByCriteria(HeaderApiDtoInterface $dto): array
    {
        if (array_key_exists($dto->getIdentity(), $this->headers)) {
            $headers = $this->headers[$dto->getIdentity()]->getFields();
        } else {
            throw new HeaderNotFoundException("Cannot find header with findByCriteria");
        }

        return $headers;
    }
//endregion Find Filters Repository
}