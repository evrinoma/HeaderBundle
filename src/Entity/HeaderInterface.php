<?php
namespace Evrinoma\HeaderBundle\Entity;

/**
 * Interface HeaderInterface
 *
 * @package Evrinoma\HeaderBundle\Entity
 */
interface HeaderInterface
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