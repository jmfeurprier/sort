<?php

namespace Jmf\Sort;

readonly class AssociativeSorter
{
    use WithSortFunctionTrait;

    protected function getDescendingSortFunction(): callable
    {
        return arsort(...);
    }

    protected function getAscendingSortFunction(): callable
    {
        return asort(...);
    }
}
