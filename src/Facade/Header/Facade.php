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

namespace Evrinoma\HeaderBundle\Facade\Header;

use Doctrine\Persistence\ManagerRegistry;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\HeaderBundle\Manager\Header\CommandManagerInterface;
use Evrinoma\HeaderBundle\Manager\QueryManagerInterface;
use Evrinoma\HeaderBundle\PreValidator\DtoPreValidatorInterface;
use Evrinoma\HeaderBundle\Exception\HeaderCannotBeCreatedException;
use Evrinoma\HeaderBundle\Exception\HeaderCannotBeRemovedException;
use Evrinoma\HeaderBundle\Exception\HeaderCannotBeSavedException;
use Evrinoma\HeaderBundle\Exception\HeaderNotFoundException;
use Evrinoma\UtilsBundle\Facade\FacadeTrait;
use Evrinoma\UtilsBundle\Handler\HandlerInterface;

final class Facade implements FacadeInterface
{
    use FacadeTrait;

    protected CommandManagerInterface $commandManager;

    protected QueryManagerInterface $queryManager;

    protected DtoPreValidatorInterface $preValidator;

    protected ManagerRegistry $managerRegistry;

    public function __construct(
        ManagerRegistry $managerRegistry,
        CommandManagerInterface $commandManager,
        QueryManagerInterface $queryManager,
        DtoPreValidatorInterface $preValidator,
        HandlerInterface $handler
    ) {
        $this->managerRegistry = $managerRegistry;
        $this->commandManager = $commandManager;
        $this->queryManager = $queryManager;
        $this->preValidator = $preValidator;
        $this->handler = $handler;
    }

    public function post(DtoInterface $dto, string $group, array &$data): void
    {
        throw new HeaderCannotBeCreatedException();
    }

    public function put(DtoInterface $dto, string $group, array &$data): void
    {
        throw new HeaderCannotBeSavedException();
    }

    public function delete(DtoInterface $dto, string $group, array &$data): void
    {
        throw new HeaderCannotBeRemovedException();
    }

    public function get(DtoInterface $dto, string $group, array &$data): void
    {
        throw new HeaderNotFoundException();
    }
}
