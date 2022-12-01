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

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\HeaderBundle\Manager\Header\CommandManagerInterface;
use Evrinoma\HeaderBundle\Manager\Header\QueryManagerInterface;
use Evrinoma\HeaderBundle\PreValidator\DtoPreValidatorInterface;
use Evrinoma\HeaderBundle\Provider\DtoProviderInterface;
use Evrinoma\UtilsBundle\Adaptor\AdaptorRegistryInterface;
use Evrinoma\UtilsBundle\Facade\FacadeTrait;
use Evrinoma\UtilsBundle\Handler\HandlerInterface;

final class Facade implements FacadeInterface
{
    use FacadeTrait;

    protected CommandManagerInterface $commandManager;

    protected QueryManagerInterface $queryManager;

    protected DtoPreValidatorInterface $preValidator;

    protected DtoProviderInterface  $provider;

    public function __construct(
        CommandManagerInterface $commandManager,
        QueryManagerInterface $queryManager,
        DtoProviderInterface $provider,
        AdaptorRegistryInterface $adaptorRegistry,
        DtoPreValidatorInterface $preValidator,
        HandlerInterface $handler
    ) {
        $this->adaptorRegistry = $adaptorRegistry;
        $this->commandManager = $commandManager;
        $this->queryManager = $queryManager;
        $this->preValidator = $preValidator;
        $this->handler = $handler;
        $this->provider = $provider;
    }

    public function remove(DtoInterface $dto, string $group, array &$data): void
    {
        $commandManager = $this->commandManager;

        $this->adaptorRegistry->transactional(
            function () use ($dto, $commandManager, &$json) {
                $commandManager->remove($dto);
                $json = ['OK'];
            }
        );
    }

    public function registry(string $group, array &$data): void
    {
        $commandManager = $this->commandManager;
        $provider = $this->provider;

        $this->adaptorRegistry->transactionals(
            function ($em) use ($provider, $commandManager, &$json) {
                foreach ($provider->toDto()->getReverse() as $item) {
                    $this->preValidator->onPost($item);
                    $headerItem = $commandManager->post($item);
                    $em->flush();
                    $item->setId($headerItem->getId());
                }
            }
        );
    }
}
