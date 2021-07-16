<?php

namespace Evrinoma\HeaderBundle\Manager;

use Evrinoma\HeaderBundle\Dto\HeaderApiDtoInterface;
use Evrinoma\HeaderBundle\Exception\HeaderNotFoundException;
use Evrinoma\HeaderBundle\Repository\HeaderRepositoryInterface;
use Evrinoma\UtilsBundle\Rest\RestInterface;
use Evrinoma\UtilsBundle\Rest\RestTrait;


final class QueryManager implements QueryManagerInterface, RestInterface
{
    use RestTrait;

//region SECTION: Getters/Setters
//region SECTION: Fields
    private HeaderRepositoryInterface $repository;
//endregion Fields

//region SECTION: Constructor
    public function __construct(HeaderRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
//endregion Constructor
    /**
     * @param HeaderApiDtoInterface $dto
     *
     * @return array
     * @throws HeaderNotFoundException
     */
    public function get(HeaderApiDtoInterface $dto): array
    {
        try {
            $header = $this->repository->findByCriteria($dto);
        } catch (HeaderNotFoundException $e) {
            throw $e;
        }

        return $header;
    }

    public function getRestStatus(): int
    {
        return $this->status;
    }
//endregion Getters/Setters
}