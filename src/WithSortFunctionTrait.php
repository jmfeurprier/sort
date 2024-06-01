<?php

namespace Jmf\Sort;

trait WithSortFunctionTrait
{
    /**
     * @param array<int|string, mixed> $array
     *
     * @return array<int|string, mixed>
     */
    public function sort(
        array $array,
        Direction $direction = Direction::ASC,
        int $flags = SORT_REGULAR,
    ): array {
        $this->getFunction($direction)($array, $flags);

        return $array;
    }

    /**
     * @param array<int|string, mixed> $array
     *
     * @return array<int|string, mixed>
     */
    public function rsort(
        array $array,
        int $flags = SORT_REGULAR,
    ): array {
        $this->getFunction(Direction::DESC)($array, $flags);

        return $array;
    }

    private function getFunction(Direction $direction): callable
    {
        if (Direction::DESC === $direction) {
            return $this->getDescendingSortFunction();
        }

        return $this->getAscendingSortFunction();
    }

    abstract protected function getDescendingSortFunction(): callable;

    abstract protected function getAscendingSortFunction(): callable;
}
