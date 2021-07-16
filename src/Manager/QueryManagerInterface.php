<?php

namespace Evrinoma\HeaderBundle\Manager;

use Evrinoma\HeaderBundle\Dto\HeaderApiDtoInterface;

interface QueryManagerInterface
{
//region SECTION: Getters/Setters
    /**
     * @param HeaderApiDtoInterface $dto
     *
     * @return array
     */
    public function get(HeaderApiDtoInterface $dto): array;
//endregion Getters/Setters
}