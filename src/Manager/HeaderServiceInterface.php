<?php
namespace Evrinoma\HeaderBundle\Manager;

/**
 * Interface SoapServiceInterface
 *
 * @package Evrinoma\SoapBundle\Manager
 */
interface HeaderServiceInterface
{
//region SECTION: Getters/Setters
    /**
     * @return array
     */
    public function getFields():array;

    /**
     * @return string
     */
    public function getName():string;
//endregion Getters/Setters
}