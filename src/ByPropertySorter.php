<?php

namespace Jmf\Sort;

use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Webmozart\Assert\Assert;

readonly class ByPropertySorter
{
    public static function createDefault(): self
    {
        return new self(
            new PropertyAccessor(),
            new AssociativeSorter(),
        );
    }

    public function __construct(
        private PropertyAccessorInterface $propertyAccessor,
        private AssociativeSorter $associativeSorter,
    ) {
    }

    /**
     * @param array<int|string, array<string, mixed>|object> $array
     * @param PropertyPass[]                                 $propertyPasses
     *
     * @return array<int|string, array<string, mixed>|object>
     */
    public function sort(
        array $array,
        iterable $propertyPasses,
    ): array {
        Assert::notEmpty($propertyPasses);
        Assert::allIsInstanceOf($propertyPasses, PropertyPass::class);

        // Trivial cases.
        if (count($array) < 2) {
            return $array;
        }

        foreach (array_reverse((array) $propertyPasses) as $propertyPass) {
            $array = $this->applyPass($propertyPass, $array);
        }

        return $array;
    }

    /**
     * @param array<int|string, array<string, mixed>|object> $array
     *
     * @return array<int|string, array<string, mixed>|object>
     */
    private function applyPass(
        PropertyPass $propertyPass,
        array $array,
    ): array {
        $propertyValues = [];

        foreach ($array as $key => $item) {
            $propertyValues[$key] = $this->propertyAccessor->getValue(
                $item,
                $propertyPass->getProperty(),
            );
        }

        $propertyValues = $this->associativeSorter->sort(
            $propertyValues,
            $propertyPass->getDirection(),
            $propertyPass->getFlags(),
        );

        $ordered = [];

        foreach (array_keys($propertyValues) as $key) {
            $ordered[$key] = $array[$key];
        }

        return $ordered;
    }
}
