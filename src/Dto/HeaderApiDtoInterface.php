<?php

namespace Evrinoma\HeaderBundle\Dto;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\IdentityInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\IdInterface;

interface HeaderApiDtoInterface extends DtoInterface, IdentityInterface, IdInterface
{
}