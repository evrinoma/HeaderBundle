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

namespace Evrinoma\HeaderBundle\Controller;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Evrinoma\DtoBundle\Factory\FactoryDtoInterface;
use Evrinoma\HeaderBundle\Dto\HeaderApiDtoInterface;
use Evrinoma\HeaderBundle\Exception\HeaderCannotBeCreatedException;
use Evrinoma\HeaderBundle\Exception\HeaderCannotBeRemovedException;
use Evrinoma\HeaderBundle\Exception\HeaderCannotBeSavedException;
use Evrinoma\HeaderBundle\Exception\HeaderInvalidException;
use Evrinoma\HeaderBundle\Exception\HeaderNotFoundException;
use Evrinoma\HeaderBundle\Facade\Header\FacadeInterface;
use Evrinoma\HeaderBundle\Serializer\GroupInterface;
use Evrinoma\UtilsBundle\Controller\AbstractWrappedApiController;
use Evrinoma\UtilsBundle\Controller\ApiControllerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

final class HeaderApiController extends AbstractWrappedApiController implements ApiControllerInterface
{
    private string $dtoClass;

    private ?Request $request;

    private FactoryDtoInterface $factoryDto;

    private FacadeInterface $facade;

    public function __construct(
        SerializerInterface $serializer,
        RequestStack $requestStack,
        FactoryDtoInterface $factoryDto,
        FacadeInterface $facade,
        string $dtoClass
    ) {
        parent::__construct($serializer);
        $this->request = $requestStack->getCurrentRequest();
        $this->factoryDto = $factoryDto;
        $this->dtoClass = $dtoClass;
        $this->facade = $facade;
    }

    /**
     * @Rest\Post("/api/header/create", options={"expose": true}, name="api_header_create")
     * @OA\Post(
     *     tags={"header"},
     *     description="the method perform create header",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 example={
     *                     "class": "Evrinoma\HeaderBundle\Dto\HeaderApiDto",
     *                 },
     *                 type="object",
     *                 @OA\Property(property="class", type="string", default="Evrinoma\HeaderBundle\Dto\HeaderApiDto"),
     *             )
     *         )
     *     )
     * )
     * @OA\Response(response=200, description="Create header")
     *
     * @return JsonResponse
     */
    public function postAction(): JsonResponse
    {
        /** @var HeaderApiDtoInterface $headerApiDto */
        $headerApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $this->setStatusCreated();

        $json = [];
        $error = [];
        $group = GroupInterface::API_POST_HEADER;

        try {
            $this->facade->post($headerApiDto, $group, $json);
        } catch (\Exception $e) {
            $error = $this->setRestStatus($e);
        }

        return $this->setSerializeGroup($group)->JsonResponse('Create header', $json, $error);
    }

    /**
     * @Rest\Put("/api/header/save", options={"expose": true}, name="api_header_save")
     * @OA\Put(
     *     tags={"header"},
     *     description="the method perform save header for current entity",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 example={
     *                     "class": "Evrinoma\HeaderBundle\Dto\HeaderApiDto",
     *                 },
     *                 type="object",
     *                 @OA\Property(property="class", type="string", default="Evrinoma\HeaderBundle\Dto\HeaderApiDto"),
     *             )
     *         )
     *     )
     * )
     * @OA\Response(response=200, description="Save header")
     *
     * @return JsonResponse
     */
    public function putAction(): JsonResponse
    {
        /** @var HeaderApiDtoInterface $headerApiDto */
        $headerApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $json = [];
        $error = [];
        $group = GroupInterface::API_PUT_HEADER;

        try {
            $this->facade->put($headerApiDto, $group, $json);
        } catch (\Exception $e) {
            $error = $this->setRestStatus($e);
        }

        return $this->setSerializeGroup($group)->JsonResponse('Save header', $json, $error);
    }

    /**
     * @Rest\Delete("/api/header/delete", options={"expose": true}, name="api_header_delete")
     * @OA\Delete(
     *     tags={"header"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="Evrinoma\HeaderBundle\Dto\HeaderApiDto",
     *             readOnly=true
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="id Entity",
     *         in="query",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="3",
     *         )
     *     )
     * )
     * @OA\Response(response=200, description="Delete header")
     *
     * @return JsonResponse
     */
    public function deleteAction(): JsonResponse
    {
        /** @var HeaderApiDtoInterface $headerApiDto */
        $headerApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $this->setStatusAccepted();

        $json = [];
        $error = [];

        try {
            $this->facade->delete($headerApiDto, '', $json);
        } catch (\Exception $e) {
            $error = $this->setRestStatus($e);
        }

        return $this->JsonResponse('Delete header', $json, $error);
    }

    /**
     * @Rest\Delete("/api/header/remove", options={"expose": true}, name="api_remove_header")
     * @OA\Delete(
     *     tags={"header"}
     * )
     * @OA\Response(response=200, description="Remove all header items")
     *
     * @return JsonResponse
     */
    public function removeAction(): JsonResponse
    {
        $this->setStatusAccepted();

        $json = [];
        $error = [];

        try {
            $this->facade->remove(new $this->dtoClass(), '', $json);
        } catch (\Exception $e) {
            $error = $this->setRestStatus($e);
        }

        return $this->JsonResponse('Remove all items', $json, $error);
    }

    /**
     * @Rest\Get("/api/header/criteria", options={"expose": true}, name="api_header_criteria")
     * @OA\Get(
     *     tags={"header"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="Evrinoma\HeaderBundle\Dto\HeaderApiDto",
     *             readOnly=true
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="identity header",
     *         in="query",
     *         name="identity",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="app.basic.contr_agent",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="tag",
     *         in="query",
     *         description="tag header",
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(
     *                 type="string",
     *                 ref=@Model(type=Evrinoma\HeaderBundle\Form\Rest\HeaderTagChoiceType::class, options={"data": "tag"}),
     *             ),
     *         ),
     *         style="form"
     *     )
     * )
     * @OA\Response(response=200, description="Return headers")
     *
     * @return JsonResponse
     */
    public function criteriaAction(): JsonResponse
    {
        /** @var HeaderApiDtoInterface $headerApiDto */
        $headerApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $json = [];
        $error = [];
        $group = GroupInterface::API_CRITERIA_HEADER;

        try {
            $this->facade->criteria($headerApiDto, $group, $json);
        } catch (\Exception $e) {
            $error = $this->setRestStatus($e);
        }

        return $this->setSerializeGroup($group)->JsonResponse('Get header', $json, $error);
    }

    /**
     * @Rest\Get("/api/header", options={"expose": true}, name="api_header")
     * @OA\Get(
     *     tags={"header"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="Evrinoma\HeaderBundle\Dto\HeaderApiDto",
     *             readOnly=true
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="id Entity",
     *         in="query",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="1000",
     *         )
     *     )
     * )
     * @OA\Response(response=200, description="Return headers")
     *
     * @return JsonResponse
     */
    public function getAction(): JsonResponse
    {
        /** @var HeaderApiDtoInterface $headerApiDto */
        $headerApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $json = [];
        $error = [];
        $group = GroupInterface::API_GET_HEADER;

        try {
            $this->facade->get($headerApiDto, $group, $json);
        } catch (\Exception $e) {
            $error = $this->setRestStatus($e);
        }

        return $this->setSerializeGroup($group)->JsonResponse('Get header', $json, $error);
    }

    /**
     * @Rest\Post("/api/header/registry/create", name="api_registry_create_header")
     * @OA\Post(tags={"header"})
     * @OA\Response(response=200, description="Returns the rewards of default generated header")
     *
     * @return JsonResponse
     */
    public function registryAction(): JsonResponse
    {
        $this->setStatusCreated();

        $json = [];
        $error = [];
        $group = GroupInterface::API_POST_REGISTRY_HEADER;

        try {
            $this->facade->registry($group, $json);
        } catch (\Exception $e) {
            $error = $this->setRestStatus($e);
        }

        return $this->setSerializeGroup($group)->JsonResponse('Create header from registry', $json, $error);
    }

    /**
     * @param \Exception $e
     *
     * @return array
     */
    public function setRestStatus(\Exception $e): array
    {
        switch (true) {
            case $e instanceof HeaderCannotBeCreatedException:
            case $e instanceof HeaderCannotBeRemovedException:
            case $e instanceof HeaderCannotBeSavedException:
                $this->setStatusNotImplemented();
                break;
            case $e instanceof HeaderNotFoundException:
                $this->setStatusNotFound();
                break;
            case $e instanceof UniqueConstraintViolationException:
                $this->setStatusConflict();
                break;
            case $e instanceof HeaderInvalidException:
                $this->setStatusUnprocessableEntity();
                break;
            default:
                $this->setStatusBadRequest();
        }

        return [$e->getMessage()];
    }
}
