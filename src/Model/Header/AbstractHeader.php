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
     * @var string
     *
     * @ORM\Column(name="value", type="string")
     */
    protected string $value;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="string")
     */
    protected string $text;

    /**
     * @var string
     *
     * @ORM\Column(name="align", type="string")
     */
    protected string $align;

    /**
     * @var bool
     *
     * @ORM\Column(name="sortable", type="boolean")
     */
    protected bool $sortable;

    /**
     * @var string
     *
     * @ORM\Column(name="filterable", type="string")
     */
    protected string $filterable;

    /**
     * @var string
     *
     * @ORM\Column(name="order", type="string")
     */
    protected string $order;

    /**
     * @var bool
     *
     * @ORM\Column(name="visible", type="boolean")
     */
    protected bool $visible;

    /**
     * @var string
     *
     * @ORM\Column(name="hidden", type="string")
     */
    protected string $hidden;

    /**
     * @var string
     *
     * @ORM\Column(name="width", type="string")
     */
    protected string $width;

    /**
     * @var string
     *
     * @ORM\Column(name="column_class", type="string")
     */
    protected string $columnClass;

    /**
     * @var string
     *
     * @ORM\Column(name="cell_class", type="string")
     */
    protected string $cellClass;

    /**
     * @var string
     *
     * @ORM\Column(name="column_data_type", type="string")
     */
    protected string $columnDataType;

    /**
     * @var array
     *
     * @ORM\Column(name="components", type="array")
     */
    protected array $components;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     */
    protected string $name;

    /**
     * @var string
     *
     * @ORM\Column(name="params", type="string")
     */
    protected string $params;

    /**
     * @var array
     *
     * @ORM\Column(name="events", type="array")
     */
    protected array $events;

    /**
     * @var array
     *
     * @ORM\Column(name="contexts", type="array")
     */
    protected array $contexts;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string")
     */
    protected string $type;

    /**
     * @var string
     *
     * @ORM\Column(name="default", type="string")
     */
    protected string $default;

    /**
     * @var string
     *
     * @ORM\Column(name="filter", type="string")
     */
    protected string $filter;

    /**
     * @var array
     *
     * @ORM\Column(name="rules", type="array")
     */
    protected array $rules;

    /**
     * @var string
     *
     * @ORM\Column(name="fixed", type="string")
     */
    protected string $fixed;

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
