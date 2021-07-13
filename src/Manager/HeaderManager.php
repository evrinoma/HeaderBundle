<?php

namespace Evrinoma\HeaderBundle\Manager;

use Evrinoma\UtilsBundle\Rest\RestTrait;

/**
 * Class SoapManager
 *
 * @package Evrinoma\SoapBundle\Manager
 */
class HeaderManager
{
    use RestTrait;

//region SECTION: Fields
    /**
     * @var HeaderServiceInterface[]
     */
    private array $headerServices = [];

//endregion Fields


//region SECTION: Public
    public function addHeaderService(HeaderServiceInterface $service): void
    {
        $this->headerServices[$service->getName()] = $service;
    }

//endregion Public
//region SECTION: Getters/Setters
    public function getRestStatus(): int
    {
        return $this->status;
    }
//endregion Getters/Setters
}