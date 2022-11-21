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
use Evrinoma\HeaderBundle\Tests\Functional\Helper\BaseHeaderTestTrait;
use Evrinoma\HeaderBundle\Tests\Functional\ValueObject\Header\Id;
use Evrinoma\HeaderBundle\Tests\Functional\ValueObject\Header\Identity;
use Evrinoma\HeaderBundle\Tests\Functional\ValueObject\Header\Tag;
use Evrinoma\TestUtilsBundle\Action\AbstractServiceTest;
use Evrinoma\UtilsBundle\Model\Rest\ErrorModel;
use Evrinoma\UtilsBundle\Model\Rest\PayloadModel;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Response;

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
            HeaderApiDtoInterface::TAG => Tag::default(),
        ];
    }

    public function actionPost(): void
    {
        $this->createHeader();
        $this->testResponseStatusCreated();
    }

    public function actionDelete(): void
    {
        $find = $this->assertGet(Id::value());

        $this->delete(Id::value());
        $this->testResponseStatusAccepted();

        $delete = $this->assertGet(Id::value(), Response::HTTP_NOT_FOUND);
    }

    public function actionGet(): void
    {
        $find = $this->assertGet(Id::value());
    }

    public function actionGetNotFound(): void
    {
        $response = $this->get(Id::wrong());
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $response);
        $this->testResponseStatusNotFound();
    }

    public function actionDeleteNotFound(): void
    {
        $response = $this->delete(Id::wrong());
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $response);
        $this->testResponseStatusNotFound();
    }

    public function actionDeleteUnprocessable(): void
    {
        $this->delete(Id::empty());
        $this->testResponseStatusUnprocessable();
    }

    public function actionPutNotFound(): void
    {
        $updated = $this->put(static::getDefault([HeaderApiDtoInterface::ID => Id::wrong()]));
        $this->testResponseStatusNotFound();
    }

    public function actionPutUnprocessable(): void
    {
        $updated = $this->put(static::getDefault([HeaderApiDtoInterface::ID => Id::empty()]));
        $this->testResponseStatusUnprocessable();
    }

    public function actionPostUnprocessable(): void
    {
        $this->postWrong();
        $this->testResponseStatusUnprocessable();

        $query = static::getDefault();
        unset($query[HeaderApiDtoInterface::TAG]);
        $this->post($query);
        $this->testResponseStatusUnprocessable();

        $query = static::getDefault();
        unset($query[HeaderApiDtoInterface::IDENTITY]);
        $this->post($query);
        $this->testResponseStatusUnprocessable();
    }

    public function actionCriteriaNotFound(): void
    {
        $query = static::getDefault([HeaderApiDtoInterface::TAG => Tag::wrong()]);
        unset($query[HeaderApiDtoInterface::IDENTITY]);
        unset($query[HeaderApiDtoInterface::ID]);

        $response = $this->criteria($query);
        $this->testResponseStatusNotFound();
        Assert::assertArrayHasKey(ErrorModel::ERROR, $response);

        $query = static::getDefault([HeaderApiDtoInterface::ID => Id::wrong()]);
        unset($query[HeaderApiDtoInterface::TAG]);
        unset($query[HeaderApiDtoInterface::IDENTITY]);

        $response = $this->criteria($query);
        $this->testResponseStatusNotFound();
        Assert::assertArrayHasKey(ErrorModel::ERROR, $response);

        $query = static::getDefault([HeaderApiDtoInterface::IDENTITY => Identity::wrong()]);
        unset($query[HeaderApiDtoInterface::TAG]);
        unset($query[HeaderApiDtoInterface::ID]);

        $response = $this->criteria($query);
        $this->testResponseStatusNotFound();
        Assert::assertArrayHasKey(ErrorModel::ERROR, $response);
    }

    public function actionCriteria(): void
    {
        $query = static::getDefault();
        unset($query[HeaderApiDtoInterface::TAG]);
        unset($query[HeaderApiDtoInterface::IDENTITY]);

        $response = $this->criteria($query);
        $this->testResponseStatusOK();
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $response);
        Assert::assertCount(1, $response[PayloadModel::PAYLOAD]);
        $entity = $response[PayloadModel::PAYLOAD][0];
        $this->checkHeader($entity);
        Assert::assertEquals($entity[HeaderApiDtoInterface::ID], $query[HeaderApiDtoInterface::ID]);

        $query = static::getDefault();
        unset($query[HeaderApiDtoInterface::TAG]);
        unset($query[HeaderApiDtoInterface::ID]);

        $response = $this->criteria($query);
        $this->testResponseStatusOK();
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $response);
        Assert::assertCount(4, $response[PayloadModel::PAYLOAD]);
        foreach ($response[PayloadModel::PAYLOAD] as $entity) {
            $this->checkHeader($entity);
        }

        $query = static::getDefault();
        unset($query[HeaderApiDtoInterface::IDENTITY]);
        unset($query[HeaderApiDtoInterface::ID]);

        $response = $this->criteria($query);
        $this->testResponseStatusOK();
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $response);
        Assert::assertCount(2, $response[PayloadModel::PAYLOAD]);
        foreach ($response[PayloadModel::PAYLOAD] as $entity) {
            $this->checkHeader($entity);
            Assert::assertEquals($entity[HeaderApiDtoInterface::TAG], $query[HeaderApiDtoInterface::TAG]);
        }
    }

    public function actionPut(): void
    {
        $find = $this->assertGet(Id::value());

        $query = static::getDefault([HeaderApiDtoInterface::ID => Id::value()]);

        $updated = $this->put($query);
        $this->testResponseStatusOK();
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $updated);
        Assert::assertNotEquals($updated[PayloadModel::PAYLOAD], $find[PayloadModel::PAYLOAD]);

        $criteria = $this->get(Id::value());
        $this->testResponseStatusOK();
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $criteria);
        Assert::assertEquals($updated[PayloadModel::PAYLOAD], $criteria[PayloadModel::PAYLOAD]);
    }

    public function actionPostDuplicate(): void
    {
        Assert::markTestIncomplete('This test has not been implemented yet.');
    }
}
