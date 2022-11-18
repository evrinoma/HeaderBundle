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
use Evrinoma\HeaderBundle\Exception\HeaderCannotBeCreatedException;
use Evrinoma\HeaderBundle\Exception\HeaderCannotBeRemovedException;
use Evrinoma\HeaderBundle\Exception\HeaderCannotBeSavedException;
use Evrinoma\HeaderBundle\Exception\HeaderInvalidException;
use Evrinoma\HeaderBundle\Exception\HeaderNotFoundException;
use Evrinoma\HeaderBundle\Factory\HeaderFactoryInterface;
use Evrinoma\HeaderBundle\Mediator\CommandMediatorInterface;
use Evrinoma\HeaderBundle\Model\Header\HeaderInterface;
use Evrinoma\HeaderBundle\Repository\Header\HeaderRepositoryInterface;
use Evrinoma\UtilsBundle\Validator\ValidatorInterface;

final class CommandManager implements CommandManagerInterface
{
    private HeaderRepositoryInterface $repository;
    private ValidatorInterface $validator;
    private HeaderFactoryInterface $factory;
    private CommandMediatorInterface $mediator;

    /**
     * @param ValidatorInterface        $validator
     * @param HeaderRepositoryInterface $repository
     * @param HeaderFactoryInterface    $factory
     * @param CommandMediatorInterface  $mediator
     */
    public function __construct(ValidatorInterface $validator, HeaderRepositoryInterface $repository, HeaderFactoryInterface $factory, CommandMediatorInterface $mediator)
    {
        $this->validator = $validator;
        $this->repository = $repository;
        $this->factory = $factory;
        $this->mediator = $mediator;
    }

    /**
     * @param HeaderApiDtoInterface $dto
     *
     * @return HeaderInterface
     *
     * @throws HeaderInvalidException
     * @throws HeaderCannotBeCreatedException
     * @throws HeaderCannotBeSavedException
     */
    public function post(HeaderApiDtoInterface $dto): HeaderInterface
    {
        $header = $this->factory->create($dto);

        $this->mediator->onCreate($dto, $header);

        $errors = $this->validator->validate($header);

        if (\count($errors) > 0) {
            $errorsString = (string) $errors;

            throw new HeaderInvalidException($errorsString);
        }

        $this->repository->save($header);

        return $header;
    }

    /**
     * @param HeaderApiDtoInterface $dto
     *
     * @return HeaderInterface
     *
     * @throws HeaderInvalidException
     * @throws HeaderNotFoundException
     * @throws HeaderCannotBeSavedException
     */
    public function put(HeaderApiDtoInterface $dto): HeaderInterface
    {
        try {
            $header = $this->repository->find($dto->idToString());
        } catch (HeaderNotFoundException $e) {
            throw $e;
        }

        $this->mediator->onUpdate($dto, $header);

        $errors = $this->validator->validate($header);

        if (\count($errors) > 0) {
            $errorsString = (string) $errors;

            throw new HeaderInvalidException($errorsString);
        }

        $this->repository->save($header);

        return $header;
    }

    /**
     * @param HeaderApiDtoInterface $dto
     *
     * @throws HeaderCannotBeRemovedException
     * @throws HeaderNotFoundException
     */
    public function delete(HeaderApiDtoInterface $dto): void
    {
        try {
            $header = $this->repository->find($dto->idToString());
        } catch (HeaderNotFoundException $e) {
            throw $e;
        }
        $this->mediator->onDelete($dto, $header);
        try {
            $this->repository->remove($header);
        } catch (HeaderCannotBeRemovedException $e) {
            throw $e;
        }
    }

    /**
     * @param HeaderApiDtoInterface $dto
     *
     * @throws HeaderCannotBeRemovedException
     * @throws HeaderNotFoundException
     */
    public function remove(HeaderApiDtoInterface $dto): void
    {
        try {
            $menuItems = $this->repository->findByCriteria($dto);
        } catch (HeaderNotFoundException $e) {
            throw $e;
        }
        foreach ($menuItems as $menu) {
            $this->mediator->onDelete($dto, $menu);
            try {
                $this->repository->remove($menu);
            } catch (HeaderCannotBeRemovedException $e) {
                throw $e;
            }
        }
    }
}
