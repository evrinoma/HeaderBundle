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

namespace Evrinoma\HeaderBundle\Serializer;

interface GroupInterface
{
    public const API_POST_HEADER = 'API_POST_HEADER';
    public const API_PUT_HEADER = 'API_PUT_HEADER';
    public const API_DELETE_HEADER = 'API_DELETE_HEADER';
    public const API_REMOVE_HEADER = 'API_REMOVE_HEADER';
    public const API_GET_HEADER = 'API_GET_HEADER';
    public const API_CRITERIA_HEADER = self::API_GET_HEADER;
    public const API_POST_REGISTRY_HEADER = 'API_POST_REGISTRY_HEADER';
}
