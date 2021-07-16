<?php

namespace Evrinoma\HeaderBundle\Controller;

use Evrinoma\DtoBundle\Factory\FactoryDtoInterface;
use Evrinoma\HeaderBundle\Dto\HeaderApiDto;
use Evrinoma\HeaderBundle\Dto\HeaderApiDtoInterface;
use Evrinoma\HeaderBundle\Exception\HeaderInvalidException;
use Evrinoma\HeaderBundle\Exception\HeaderNotFoundException;
use Evrinoma\HeaderBundle\Manager\QueryManagerInterface;
use Evrinoma\UtilsBundle\Controller\AbstractApiController;
use Evrinoma\UtilsBundle\Rest\RestInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

final class HeaderApiController extends AbstractApiController
{
//region SECTION: Fields
    /**
     * @var ?Request
     */
    private ?Request $request;
    /**
     * @var FactoryDtoInterface
     */
    private FactoryDtoInterface $factoryDto;

    /**
     * @var QueryManagerInterface|RestInterface
     */
    private QueryManagerInterface $queryManager;
//endregion Fields

//region SECTION: Constructor
    /**
     * ApiController constructor.
     *
     * @param SerializerInterface $serializer
     * @param RequestStack        $requestStack
     * @param FactoryDtoInterface $factoryDto
     */
    public function __construct(
        SerializerInterface $serializer,
        RequestStack $requestStack,
        FactoryDtoInterface $factoryDto,
        QueryManagerInterface $queryManager,
    ) {
        parent::__construct($serializer);
        $this->request    = $requestStack->getCurrentRequest();
        $this->factoryDto = $factoryDto;
        $this->queryManager   = $queryManager;
    }

    /**
     * @Rest\Get("/api/header", options={"expose"=true}, name="api_header")
     * @OA\Get(
     *     tags={"header"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="Evrinoma\HeaderBundle\Dto\HeaderApiDto",
     *           readOnly=true
     *         )
     *     ),
     *      @OA\Parameter(
     *         description="identity header",
     *         in="query",
     *         name="identity",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="app.basic.contr_agent",
     *         )
     *     )
     * )
     * @OA\Response(response=200,description="Return headers")
     *
     * @return JsonResponse
     */
    public function getAction(): JsonResponse
    {
        /** @var HeaderApiDtoInterface $headerApiDto */
        $headerApiDto = $this->factoryDto->setRequest($this->request)->createDto(HeaderApiDto::class);

        try {
            $json = $this->queryManager->get($headerApiDto);
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->queryManager, $e);
        }

        return $this->setSerializeGroup('api_get_header')->json(['message' => 'Get headers', 'data' => $json], $this->queryManager->getRestStatus());
    }


    private function setRestStatus(RestInterface $manager, \Exception $e): array
    {
        switch (true) {
            case $e instanceof HeaderNotFoundException:
                $manager->setRestNotFound();
                break;
            case $e instanceof HeaderInvalidException:
                $manager->setRestUnprocessableEntity();
                break;
            default:
                $manager->setRestBadRequest();
        }

        return ['errors' => $e->getMessage()];
    }
//endregion Constructor
}