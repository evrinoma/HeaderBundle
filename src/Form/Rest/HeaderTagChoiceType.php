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

namespace Evrinoma\HeaderBundle\Form\Rest;

use Evrinoma\HeaderBundle\Dto\Preserve\HeaderApiDto;
use Evrinoma\HeaderBundle\Exception\HeaderTagNotFoundException;
use Evrinoma\HeaderBundle\Manager\Header\QueryManagerInterface;
use Evrinoma\UtilsBundle\Form\Rest\RestChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HeaderTagChoiceType extends AbstractType
{
    /**
     * @var QueryManagerInterface
     */
    private QueryManagerInterface $queryManager;

    /**
     * ServerType constructor.
     */
    public function __construct(QueryManagerInterface $queryManager)
    {
        $this->queryManager = $queryManager;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $callback = function (Options $options) {
            try {
                $tags = $this->queryManager->tags(new HeaderApiDto());
            } catch (HeaderTagNotFoundException $exception) {
                $tags = [];
            }

            return $tags;
        };
        $resolver->setDefault(RestChoiceType::REST_COMPONENT_NAME, 'tag');
        $resolver->setDefault(RestChoiceType::REST_DESCRIPTION, 'tagList');
        $resolver->setDefault(RestChoiceType::REST_CHOICES, $callback);
    }

    public function getParent()
    {
        return RestChoiceType::class;
    }
}
