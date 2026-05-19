<?php

declare(strict_types=1);

namespace Jmf\Sort;

readonly class ByKeySorter
{
    use WithSortFunctionTrait;

    protected function getDescendingSortFunction(): callable
    {
        return krsort(...);
    }

    protected function getAscendingSortFunction(): callable
    {
        return ksort(...);
    }
}
