<?php

namespace Evrinoma\HeaderBundle\Repository;

use Evrinoma\HeaderBundle\Dto\HeaderApiDtoInterface;
use Evrinoma\HeaderBundle\Entity\HeaderInterface;
use Evrinoma\HeaderBundle\Exception\HeaderNotFoundException;


class HeaderRepository implements HeaderRepositoryInterface
{
    /**
     * @var HeaderInterface[]
     */
    private array $headers = [];

//region SECTION: Find Filters Repository
    /**
     * @param HeaderApiDtoInterface $dto
     *
     * @return array
     * @throws HeaderNotFoundException
     */
    public function findByCriteria(HeaderApiDtoInterface $dto): array
    {
        $headers = [];

        if ($headers === null) {
            throw new HeaderNotFoundException("Cannot find header with findByCriteria");
        }

        return $headers;
    }
//endregion Find Filters Repository
    public function addHeader(HeaderInterface $header): void
    {
        $this->headers[$header->getName()] = $header;
    }
}