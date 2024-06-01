<?php

namespace Jmf\Sort;

readonly class PropertyPass
{
    public static function asc(
        string $property,
        int $flags = SORT_REGULAR,
    ): self {
        return new self($property, Direction::ASC, $flags);
    }

    public static function desc(
        string $property,
        int $flags = SORT_REGULAR,
    ): self {
        return new self($property, Direction::DESC, $flags);
    }

    public function __construct(
        private string $property,
        private Direction $direction = Direction::ASC,
        private int $flags = SORT_REGULAR,
    ) {
    }

    public function getProperty(): string
    {
        return $this->property;
    }

    public function getDirection(): Direction
    {
        return $this->direction;
    }

    public function getFlags(): int
    {
        return $this->flags;
    }
}
