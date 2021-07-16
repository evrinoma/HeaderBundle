<?php


namespace Evrinoma\HeaderBundle\Repository;

use Evrinoma\HeaderBundle\Dto\HeaderApiDtoInterface;
use Evrinoma\HeaderBundle\Exception\HeaderNotFoundException;
use Evrinoma\HeaderBundle\Entity\HeaderInterface;


interface HeaderQueryRepositoryInterface
{
//region SECTION: Find Filters Repository
    /**
     * @param HeaderApiDtoInterface $dto
     *
     * @return array
     * @throws HeaderNotFoundException
     */
    public function findByCriteria(HeaderApiDtoInterface $dto): array;


    public function addHeader(HeaderInterface $header): void;
//endregion Find Filters Repository
}