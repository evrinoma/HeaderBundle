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

namespace Evrinoma\HeaderBundle\Tests\Functional\Action;

use Evrinoma\HeaderBundle\Dto\HeaderApiDto;
use Evrinoma\HeaderBundle\Dto\HeaderApiDtoInterface;
use Evrinoma\HeaderBundle\Registry\ObjectInterface;
use Evrinoma\HeaderBundle\Tests\Functional\Helper\BaseHeaderTestTrait;
use Evrinoma\HeaderBundle\Tests\Functional\ValueObject\Header\Id;
use Evrinoma\HeaderBundle\Tests\Functional\ValueObject\Header\Identity;
use Evrinoma\TestUtilsBundle\Action\AbstractServiceTest;

class BaseHeader extends AbstractServiceTest implements BaseHeaderTestInterface
{
    use BaseHeaderTestTrait;

    public const API_GET = 'evrinoma/api/header';
    public const API_CRITERIA = 'evrinoma/api/header/criteria';
    public const API_DELETE = 'evrinoma/api/header/delete';
    public const API_PUT = 'evrinoma/api/header/save';
    public const API_POST = 'evrinoma/api/header/create';

    protected static function getDtoClass(): string
    {
        return HeaderApiDto::class;
    }

    protected static function defaultData(): array
    {
        return [
            HeaderApiDtoInterface::DTO_CLASS => static::getDtoClass(),
            HeaderApiDtoInterface::ID => Id::default(),
            HeaderApiDtoInterface::IDENTITY => Identity::default(),
            HeaderApiDtoInterface::TAG => ObjectInterface::DEFAULT_TAG,
        ];
    }

    public function actionPost(): void
    {
    }

    public function actionDelete(): void
    {
    }

    public function actionGet(): void
    {
    }

    public function actionGetNotFound(): void
    {
    }

    public function actionDeleteNotFound(): void
    {
    }

    public function actionDeleteUnprocessable(): void
    {
    }

    public function actionPutNotFound(): void
    {
    }

    public function actionPutUnprocessable(): void
    {
    }

    public function actionPostUnprocessable(): void
    {
    }

    public function actionCriteriaNotFound(): void
    {
    }

    public function actionCriteria(): void
    {
    }

    public function actionPut(): void
    {
    }

    public function actionPostDuplicate(): void
    {
    }
}
