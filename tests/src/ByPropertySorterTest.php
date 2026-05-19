<?php

namespace Jmf\Sort;

use Override;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PropertyAccess\PropertyAccessor;

class ByPropertySorterTest extends TestCase
{
    private ByPropertySorter $byPropertySorter;

    #[Override]
    protected function setUp(): void
    {
        $this->byPropertySorter = new ByPropertySorter(
            new PropertyAccessor(),
            new AssociativeSorter(),
        );
    }

    public function testSortWithEmptyArray(): void
    {
        $input = [];

        $result = $this->byPropertySorter->sort(
            $input,
            [
                PropertyPass::asc(
                    'foo',
                ),
            ]
        );

        $this->assertSame([], $result);
    }

    public function testSortWithOneItem(): void
    {
        $input = [
            ['foo' => 'bar'],
        ];

        $result = $this->byPropertySorter->sort(
            $input,
            [
                PropertyPass::asc(
                    '[foo]',
                ),
            ]
        );

        $this->assertSame($input, $result);
    }

    public function testSortWithMultipleItems(): void
    {
        $input = [
            ['foo' => 'def'],
            ['foo' => 'abc'],
            ['foo' => 'ghi'],
        ];

        $result = $this->byPropertySorter->sort(
            $input,
            [
                PropertyPass::asc(
                    '[foo]',
                ),
            ]
        );

        $this->assertSame(
            [
                1 => ['foo' => 'abc'],
                0 => ['foo' => 'def'],
                2 => ['foo' => 'ghi'],
            ],
            $result,
        );
    }

    public function testSortByMultiplePropertiesPrimaryKeyDecides(): void
    {
        $input = [
            ['year' => 1800, 'month' => 1,  'day' => 1],
            ['year' => 1744, 'month' => 11, 'day' => 14],
            ['year' => 1600, 'month' => 6,  'day' => 3],
        ];

        $result = $this->byPropertySorter->sort(
            $input,
            [
                PropertyPass::asc('[year]'),
                PropertyPass::asc('[month]'),
                PropertyPass::asc('[day]'),
            ],
        );

        $this->assertSame(
            [
                2 => ['year' => 1600, 'month' => 6,  'day' => 3],
                1 => ['year' => 1744, 'month' => 11, 'day' => 14],
                0 => ['year' => 1800, 'month' => 1,  'day' => 1],
            ],
            $result,
        );
    }

    public function testSortByMultiplePropertiesSecondaryKeyDecides(): void
    {
        $input = [
            ['year' => 1744, 'month' => 11, 'day' => 14],
            ['year' => 1744, 'month' => 5,  'day' => 11],
        ];

        $result = $this->byPropertySorter->sort(
            $input,
            [
                PropertyPass::asc('[year]'),
                PropertyPass::asc('[month]'),
                PropertyPass::asc('[day]'),
            ],
        );

        $this->assertSame(
            [
                1 => ['year' => 1744, 'month' => 5,  'day' => 11],
                0 => ['year' => 1744, 'month' => 11, 'day' => 14],
            ],
            $result,
        );
    }

    public function testSortByMultiplePropertiesTertiaryKeyDecides(): void
    {
        $input = [
            ['year' => 1744, 'month' => 5, 'day' => 14],
            ['year' => 1744, 'month' => 5, 'day' => 3],
            ['year' => 1744, 'month' => 5, 'day' => 11],
        ];

        $result = $this->byPropertySorter->sort(
            $input,
            [
                PropertyPass::asc('[year]'),
                PropertyPass::asc('[month]'),
                PropertyPass::asc('[day]'),
            ],
        );

        $this->assertSame(
            [
                1 => ['year' => 1744, 'month' => 5, 'day' => 3],
                2 => ['year' => 1744, 'month' => 5, 'day' => 11],
                0 => ['year' => 1744, 'month' => 5, 'day' => 14],
            ],
            $result,
        );
    }

    public function testSortDescendingWithMultipleItems(): void
    {
        $input = [
            ['foo' => 'def'],
            ['foo' => 'abc'],
            ['foo' => 'ghi'],
        ];

        $result = $this->byPropertySorter->sort(
            $input,
            [
                PropertyPass::desc(
                    '[foo]',
                ),
            ]
        );

        $this->assertSame(
            [
                2 => ['foo' => 'ghi'],
                0 => ['foo' => 'def'],
                1 => ['foo' => 'abc'],
            ],
            $result,
        );
    }
}
