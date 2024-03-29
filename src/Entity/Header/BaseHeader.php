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

namespace Evrinoma\HeaderBundle\Entity\Header;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\HeaderBundle\Model\Header\AbstractHeader;

/**
 * @ORM\Table(name="e_header")
 * @ORM\Entity
 */
class BaseHeader extends AbstractHeader
{
}
