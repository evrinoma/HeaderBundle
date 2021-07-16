<?php

namespace Evrinoma\HeaderBundle\Dto;

interface HeaderApiDtoInterface
{
    public function getIdentity(): string;

    public function hasIdentity(): bool;
}