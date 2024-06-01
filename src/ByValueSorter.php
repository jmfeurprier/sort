<?php

namespace Jmf\Sort;

readonly class ByValueSorter
{
    use WithSortFunctionTrait {
        sort as private doSort;
        rsort as private doRsort;
    }

    /**
     * @param iterable<mixed> $array
     *
     * @return iterable<mixed>
     */
    public function sort(
        iterable $array,
        Direction $direction = Direction::ASC,
        int $flags = SORT_REGULAR,
    ): iterable {
        return $this->doSort((array) $array, $direction, $flags);
    }

    /**
     * @param iterable<mixed> $array
     *
     * @return iterable<mixed>
     */
    public function rsort(
        iterable $array,
        int $flags = SORT_REGULAR,
    ): iterable {
        return $this->doRsort((array) $array, $flags);
    }

    protected function getDescendingSortFunction(): callable
    {
        return rsort(...);
    }

    protected function getAscendingSortFunction(): callable
    {
        return sort(...);
    }
}
