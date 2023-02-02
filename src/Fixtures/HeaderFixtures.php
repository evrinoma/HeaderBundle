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

namespace Evrinoma\HeaderBundle\Fixtures;

use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Evrinoma\HeaderBundle\Dto\HeaderApiDtoInterface;
use Evrinoma\HeaderBundle\Entity\Header\BaseHeader;
use Evrinoma\HeaderBundle\Model\Header\HeaderInterface;
use Evrinoma\HeaderBundle\Registry\ObjectInterface;
use Evrinoma\TestUtilsBundle\Fixtures\AbstractFixture;

class HeaderFixtures extends AbstractFixture implements FixtureGroupInterface, OrderedFixtureInterface
{
    protected static array $data = [
        [
            HeaderApiDtoInterface::IDENTITY => 'Test_SUPER_ADMIN',
            HeaderApiDtoInterface::TAG => ObjectInterface::DEFAULT_TAG,
        ],
        [
            HeaderApiDtoInterface::IDENTITY => 'Test_USER',
            HeaderApiDtoInterface::TAG => ObjectInterface::DEFAULT_TAG,
        ],
        [
            HeaderApiDtoInterface::IDENTITY => 'Test_SUPER_ADMIN',
            HeaderApiDtoInterface::TAG => 'test',
        ],
        [
            HeaderApiDtoInterface::IDENTITY => 'Test_USER',
            HeaderApiDtoInterface::TAG => 'test',
        ],
    ];

    protected static string $class = BaseHeader::class;

    public static function getGroups(): array
    {
        return [
            FixtureInterface::HEADER_FIXTURES,
        ];
    }

    public function getOrder()
    {
        return 0;
    }

    /**
     * @param ObjectManager $manager
     *
     * @return $this
     *
     * @throws \Exception
     */
    protected function create(ObjectManager $manager): self
    {
        $referenceName = static::getReferenceName();
        $i = 0;

        $this->entityGenerator($manager, $referenceName, $i, $this->getData());

        return $this;
    }

    private function entityGenerator(ObjectManager $manager, string $referenceName, int &$i, array $data)
    {
        foreach ($data as $record) {
            /** @var HeaderInterface $entity */
            $entity = $this->getEntity();

            $entity
                ->setIdentity($record[HeaderApiDtoInterface::IDENTITY])
                ->setTag($record[HeaderApiDtoInterface::TAG]);

            $this->expandEntity($entity, $record);

            $this->addReference($referenceName.$i, $entity);
            $manager->persist($entity);
            ++$i;
        }
    }
}
