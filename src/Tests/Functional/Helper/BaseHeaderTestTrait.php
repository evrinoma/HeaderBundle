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

namespace Evrinoma\HeaderBundle\Tests\Functional\Helper;

use Evrinoma\HeaderBundle\Dto\HeaderApiDtoInterface;
use Evrinoma\UtilsBundle\Model\Rest\ErrorModel;
use Evrinoma\UtilsBundle\Model\Rest\PayloadModel;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Response;

trait BaseHeaderTestTrait
{
    protected function assertGet(string $id, int $status = Response::HTTP_OK): array
    {
        $find = $this->get($id);

        switch ($status) {
            case Response::HTTP_OK:
                $this->testResponseStatusOK();
                $this->checkResult($find);
                break;
            case Response::HTTP_NOT_FOUND:
                $this->testResponseStatusNotFound();
                Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $find);
                Assert::assertCount(0, $find[PayloadModel::PAYLOAD]);
                Assert::assertCount(1, $find[ErrorModel::ERROR]);
                break;
        }

        return $find;
    }

    protected function createHeader(): array
    {
        $query = static::getDefault();

        return $this->post($query);
    }

    protected function checkResult($entity): void
    {
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $entity);
        Assert::assertCount(1, $entity[PayloadModel::PAYLOAD]);
        $this->checkHeader($entity[PayloadModel::PAYLOAD][0]);
    }

    protected function checkHeader($entity): void
    {
        Assert::assertArrayHasKey(HeaderApiDtoInterface::ID, $entity);
        Assert::assertArrayHasKey(HeaderApiDtoInterface::IDENTITY, $entity);
        Assert::assertArrayHasKey(HeaderApiDtoInterface::TAG, $entity);
    }
}
