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

use Doctrine\DBAL\Exception\TableNotFoundException;
use Evrinoma\HeaderBundle\Dto\HeaderApiDtoInterface;
use Evrinoma\HeaderBundle\Exception\HeaderTagNotFoundException;
use Evrinoma\HeaderBundle\Manager\Header\QueryManagerInterface;
use Evrinoma\UtilsBundle\Form\Rest\RestChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HeaderTagChoiceType extends AbstractType
{
    protected static string $dtoClass;

    private QueryManagerInterface $queryManager;

    public function __construct(QueryManagerInterface $queryManager, string $dtoClass)
    {
        $this->queryManager = $queryManager;
        static::$dtoClass = $dtoClass;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $callback = function (Options $options) {
            $value = [];
            try {
                if ($options->offsetExists('data')) {
                    switch ($options->offsetGet('data')) {
                        case HeaderApiDtoInterface::TAG:
                            $value = $this->queryManager->tags(new static::$dtoClass());
                            break;
                        default:
                            $criteria = $this->queryManager->criteria(new static::$dtoClass());
                            foreach ($criteria as $entity) {
                                $value[] = $entity->getId();
                            }
                    }
                } else {
                    throw new HeaderTagNotFoundException();
                }
            } catch (TableNotFoundException|HeaderTagNotFoundException $e) {
                $value = RestChoiceType::REST_CHOICES_DEFAULT;
            }

            return $value;
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
