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

namespace Evrinoma\HeaderBundle\Model\Header;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\UtilsBundle\Entity\IdentityTrait;
use Evrinoma\UtilsBundle\Entity\IdTrait;

/**
 * @ORM\MappedSuperclass
 * @ORM\Table(uniqueConstraints={
 *     @ORM\UniqueConstraint(name="idx_id", columns={"id"})
 * }
 * )
 */
abstract class AbstractHeader implements HeaderInterface
{
    use IdentityTrait;
    use IdTrait;
    /**
     * @var string
     *
     * @ORM\Column(name="tag", type="string")
     */
    protected string $tag;

    /**
     * @return string
     */
    public function getTag(): string
    {
        return $this->tag;
    }

    /**
     * @param string $tag
     *
     * @return HeaderInterface
     */
    public function setTag(string $tag): HeaderInterface
    {
        $this->tag = $tag;

        return $this;
    }
}
