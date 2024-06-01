Sorting extension
=================

## Installation & Requirements

Install with [Composer](https://getcomposer.org):

```shell script
composer require jmf/sort
```

## Usage

### Associative sorter

Sorts provided array, preserving key-value association.

```php
<?php

use Jmf\Sort\AssociativeSorter;

$sorter = new AssociativeSorter();

$unsorted = [
    'foo' => 'def',
    'bar' => 'abc',
    'baz' => 'ghi',
];

$sorted = $sorter->sort($unsorted);
```

### By key sorter

Sorts provided array by key.

```php
<?php

use Jmf\Sort\ByKeySorter;

$sorter = new ByKeySorter();

$unsorted = [
    'def' => 'foo',
    'abc' => 'bar',
    'ghi' => 'baz',
];

$sorted = $sorter->sort($unsorted);
```

### By value sorter

Sorts provided array by value, losing key-value association.

```php
<?php

use Jmf\Sort\ByValueSorter;

$sorter = new ByValueSorter();

$unsorted = [
    'def',
    'abc',
    'ghi',
];

$sorted = $sorter->sort($unsorted);
```

### By property sorter

Sorts provided array of arrays, or array of objects, based on one or more properties, and preserving key-value association.

Property path syntax is from [Symfony PropertyAccess component](https://symfony.com/doc/current/components/property_access.html).

#### Sorting arrays

```php
<?php

use Jmf\Sort\ByPropertySorter;

$sorter = ByPropertySorter::createDefault();

$unsorted = [
    ['foo' => 'def', 'bar' => 123],
    ['foo' => 'abc', 'bar' => 123],
    ['foo' => 'abc', 'bar' => 23],
    ['foo' => 'ghi', 'bar' => 345],
];

$sorted = $sorter->sort(
    $unsorted,
    [
        PropertyPass::asc(
            '[foo]',
        ),
        PropertyPass::desc(
            '[bar]',
            SORT_NUMERIC,
        ),
    ]
);
```

#### Sorting objects

```php
<?php

use Jmf\Sort\ByPropertySorter;

$sorter = ByPropertySorter::createDefault();

$articles = getArticles(); // Objects from a repository. 

$sorted = $sorter->sort(
    $articles,
    [
        PropertyPass::desc(
            'publicationDate',
        ),
        PropertyPass::asc(
            'author.name',
        ),
        PropertyPass::asc(
            'title',
        ),
    ]
);
```
