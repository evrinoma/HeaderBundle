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

namespace Evrinoma\HeaderBundle\Manager\Header;

use Evrinoma\HeaderBundle\Dto\HeaderApiDtoInterface;
use Evrinoma\HeaderBundle\Exception\HeaderNotFoundException;
use Evrinoma\HeaderBundle\Exception\HeaderProxyException;
use Evrinoma\HeaderBundle\Model\Header\HeaderInterface;
use Evrinoma\HeaderBundle\Repository\Header\HeaderQueryRepositoryInterface;

final class QueryManager implements QueryManagerInterface
{
    private HeaderQueryRepositoryInterface $repository;

    public function __construct(HeaderQueryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param HeaderApiDtoInterface $dto
     *
     * @return array
     *
     * @throws HeaderNotFoundException
     */
    public function criteria(HeaderApiDtoInterface $dto): array
    {
        try {
            $header = $this->repository->findByCriteria($dto);
        } catch (HeaderNotFoundException $e) {
            throw $e;
        }

        return $header;
    }

    /**
     * @param HeaderApiDtoInterface $dto
     *
     * @return HeaderInterface
     *
     * @throws HeaderProxyException
     */
    public function proxy(HeaderApiDtoInterface $dto): HeaderInterface
    {
        try {
            if ($dto->hasId()) {
                $header = $this->repository->proxy($dto->idToString());
            } else {
                throw new HeaderProxyException('Id value is not set while trying get proxy object');
            }
        } catch (HeaderProxyException $e) {
            throw $e;
        }

        return $header;
    }

    /**
     * @param HeaderApiDtoInterface $dto
     *
     * @return HeaderInterface
     *
     * @throws HeaderNotFoundException
     */
    public function get(HeaderApiDtoInterface $dto): HeaderInterface
    {
        try {
            $header = $this->repository->find($dto->idToString());
        } catch (HeaderNotFoundException $e) {
            throw $e;
        }

        return $header;
    }

    /**
     * @param HeaderApiDtoInterface $dto
     *
     * @return array
     *
     * @throws HeaderNotFoundException
     */
    public function tags(HeaderApiDtoInterface $dto): array
    {
        try {
            $tags = $this->repository->findTags($dto);
        } catch (HeaderNotFoundException $e) {
            throw $e;
        }

        return $tags;
    }
}
