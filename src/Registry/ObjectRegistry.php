<?php

declare(strict_types=1);

/*
 * This file is part of the package.
 *
 * (c) Nikolay Nikolaev <evrinoma@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Evrinoma\HeaderBundle\Registry;

use Evrinoma\HeaderBundle\Exception\ObjetRegistryException;

final class ObjectRegistry implements ObjectRegistryInterface
{
    /**
     * @var ObjectInterface[]
     */
    private array $headerItems = [];

    public function addObject(ObjectInterface $item): void
    {
        if (!\array_key_exists($item->tag(), $this->headerItems)) {
            $this->headerItems[$item->tag()] = $item;
        } else {
            throw new ObjetRegistryException('The Object '.\get_class($item).'trying to override another Object');
        }
    }

    public function getObjects(): array
    {
        return $this->headerItems;
    }
}
