# PHP Asterisk Notation

[![Latest Stable Version](https://img.shields.io/packagist/v/setnemo/asterisk-notation.svg)](https://packagist.org/packages/setnemo/asterisk-notation)
[![Github actions Build](https://github.com/setnemo/asterisk-notation/workflows/Actions/badge.svg)](//github.com/setnemo/asterisk-notation/actions)
[![SonarCloud Coverage](https://sonarcloud.io/api/project_badges/measure?project=setnemo_asterisk-notation&metric=coverage)](https://sonarcloud.io/component_measures/metric/coverage/list?id=setnemo_asterisk-notation)
[![SonarCloud Reliability rating](https://sonarcloud.io/api/project_badges/measure?project=setnemo_asterisk-notation&metric=reliability_rating)](https://sonarcloud.io/component_measures/metric/reliability_rating/list?id=setnemo_asterisk-notation)
[![SonarCloud Security rating](https://sonarcloud.io/api/project_badges/measure?project=setnemo_asterisk-notation&metric=security_rating)](https://sonarcloud.io/component_measures/metric/security_rating/list?id=setnemo_asterisk-notation)
[![SonarCloud Bugs](https://sonarcloud.io/api/project_badges/measure?project=setnemo_asterisk-notation&metric=bugs)](https://sonarcloud.io/component_measures/metric/bugs/list?id=setnemo_asterisk-notation)
[![SonarCloud Code Smells](https://sonarcloud.io/api/project_badges/measure?project=setnemo_asterisk-notation&metric=code_smells)](https://sonarcloud.io/component_measures/metric/code_smells/list?id=setnemo_asterisk-notation)
[![Github License](https://img.shields.io/github/license/setnemo/asterisk-notation.svg)](https://packagist.org/packages/setnemo/asterisk-notation)
[![Total Downloads](https://img.shields.io/packagist/dt/setnemo/asterisk-notation.svg)](https://packagist.org/packages/setnemo/asterisk-notation)

Asterisk notation for array access in PHP. Update array access to the next level of usability.

## Asterisk notation

```php
use Setnemo\Asterisk;

$items = new Asterisk([
    'Europe' => [
        'Ukraine' => [
            'capital' => 'Kyiv',
            'currency' => 'UAH'
        ],
        'Poland' => [
            'capital' => 'Warsaw',
            'currency' => 'PLN'
        ],

    ],
    'Africa' => [
        'South Africa' => [
            'capital' => 'Capetown',
            'currency' => 'ZAR'
        ],
        'Nigeria' => [
            'capital' => 'Abuja',
            'currency' => 'NGN'
        ],
    ],
]);
$city = 'Kyiv';
$resultTrue = $items->has('*.*.capital', $city);
$resultFalse = $items->has('Africa.*.capital', $city);
if ($resultTrue === true && $resultFalse === false) {
    echo "Wow! It works correctly!";
}
```

## Install

Install the latest version using Composer:

```bash
composer require setnemo/asterisk-notation
```

## Usage

Create a new Asterisk object:

```php
use Adbar\Dot;
use Setnemo\Asterisk;
$asterisk = new Asterisk;
$array = ['first_one' => ['second' => 'value'], 'first_two' => ['second' => 'value'],];
// With existing array
$asterisk = new Asterisk($array);
// With existing \Adbar\Dot
$dot = new Dot($array);
$asterisk = new Asterisk($dot);
// or existing Asterisk
$newAsterisk = new Asterisk($asterisk);
```

## Methods

Asterisk has the following methods:

- [add()](#add) // done, test included
- [all()](#all) // done, test included
- [clear()](#clear) // use Dot::clear(), test included because used set()
- [count()](#count) // use Dot::count(), test included because used get()
- [delete()](#delete) // done, test included
- [flatten()](#flatten) // use Dot::flatten()
- [get()](#get) // done, test included
- [has()](#has) // done, with 2 new parameters, test included
- [isEmpty()](#isempty) // use Dot::isEmpty(), test included because used get()
- [merge()](#merge) // use Dot::merge()
- [mergeRecursive()](#mergerecursive)// use Dot::mergeRecursive()
- [mergeRecursiveDistinct()](#mergerecursivedistinct)// use Dot::mergeRecursiveDistinct()
- [pull()](#pull) // use Dot::pull(), **need write tests**, because used get(), clear(), delete()
- [push()](#push) // use Dot::push(), **need write tests**, because used get(), set()
- [replace()](#replace) // use Dot::replace(), **need write tests**, because used get(), set()
- [set()](#set) // done, test included
- [setArray()](#setarray) // use Dot::setarray()
- [setReference()](#setreference) // use Dot::setReference()
- [toJson()](#tojson) // use Dot::toJson(), **need write tests**, because used get()

<a name="add"></a>
### add()

Using for adding element with asterisk in key
> Work like [Adbar\Dot::add()](https://github.com/adbario/php-dot-notation#add)

<a name="all"></a>
### all()

> Work like [Adbar\Dot::all()](https://github.com/adbario/php-dot-notation#all)

<a name="clear"></a>
### clear()

Deletes the contents of a given key (sets an empty array):
```php
$asterisk->clear('department.*.write_rules');

// Equivalent vanilla PHP
$array['department']['project1']['write_rules'] = [];
$array['department']['project2']['write_rules'] = [];
$array['department']['projectN']['write_rules'] = [];
```

Multiple keys:
```php
$asterisk->clear(['department.*.write_rules', 'department.*.read_rules']);
```

All the stored items:
```php
$asterisk->clear();

// Equivalent vanilla PHP
$array = [];
```

> If key not contains * (asterisk) - it works like [Adbar\Dot::clear()](https://github.com/adbario/php-dot-notation#clear)

<a name="count"></a>
### count()

Returns the number of items in a given key:
```php
$asterisk->count('user.siblings');
```

Items in the root of Dot object:
```php
$asterisk->count();

// Or use count() function as Dot implements Countable
count($asterisk);
```
> If key not contains * (asterisk) - it works like [Adbar\Dot::count()](https://github.com/adbario/php-dot-notation#count)


<a name="delete"></a>
### delete()

Deletes the given key:
```php
$asterisk->delete('*.name');

// ArrayAccess
unset($asterisk['user1.name']);
unset($asterisk['user2.name']);

// Equivalent vanilla PHP
unset($array['user1']['name']);
unset($array['user2']['name']);
```

Multiple keys:
```php
$asterisk->delete([
    '*.name',
    '*.title'
]);
```

<a name="flatten"></a>
### flatten()

> It works like [Adbar\Dot::flatten()](https://github.com/adbario/php-dot-notation#flatten)

<a name="get"></a>
### get()

Returns the value of a given key:
```php
$result = $asterisk->get('*.name'));

// ArrayAccess
$result['user1.name'] = $asterisk['user1.name'];
$result['user2.name'] = $asterisk['user2.name'];

// Equivalent vanilla PHP 
if (isset($array['user1']['name']) {
    $result['user1.name'] = $array['user1']['name'];
}
if (isset($array['user1']['name']) {
    $result['user2.name'] = $array['user2']['name'];
}

```

Returns a given default value, if the given key doesn't exist:
```php
echo $asterisk->get('user.name', 'some default value');
```
> Default value not work with asterisk

<a name="has"></a>
### has()

Checks if a given key exists (returns boolean true or false):
```php
$asterisk->has('user.name');

// ArrayAccess
isset($asterisk['user.name']);
```

Multiple keys:
```php
$asterisk->has([
    'user.name',
    'page.title'
]);
```

With asterisk:
```php
$asterisk = new Asterisk(['1' => ['second' => 'value'],'2' => ['second' => 'value']]);
$asterisk->has('*.second'); // true
$asterisk = new Asterisk(['1' => ['first' => ['test' => 42]],'2' => ['second' => 'value'],'3' => ['third' => ['value' => 42]]]);
$asterisk->has('*.*.value'); // true
$asterisk = new Asterisk(['user1' => ['name' => 'John', 'job' => 'warrior'], 'user2' => ['name' => 'Robin', 'job' => 'archer']);
$asterisk->has('*.spouse'); // false
```

With asterisk and value:
```php
$asterisk = new Asterisk([]);
$asterisk->has('*', false); // false
$asterisk = new Asterisk(['*' => ['second' => 'VALUE']]);
$asterisk->has('*.second', 'VALUE'); // true
$asterisk->has('*.second', 'value'); // false because lowercase
$asterisk = new Asterisk(['*' => ['second' => 'value'], 0 => [0 => 0], 11 => 11]);
$asterisk->has('*.11', 11); // true
$asterisk = new Asterisk(['1' => ['second' => 'value'],'2' => ['second' => '-']]);
$asterisk->has('*.second', 'value'); // false because 'second' => '-'
$asterisk = new Asterisk(['1' => ['second' => 'value'],'2' => ['second' => 'value']]);
$asterisk->has('*.second', 'value'); // true
```
With asterisk and value (non-strict mode):
```php
$asterisk = new Asterisk([
'locations' => [
    'Europe' => [
        'Ukraine' => [
            'capital' => 'Kyiv',
            'currency' => 'UAH'
        ],
        'Poland' => [
            'capital' => 'Warsaw',
            'currency' => 'PLN'
        ],

    ],
    'Africa' => [
        'South Africa' => [
            'capital' => 'Capetown',
            'currency' => 'ZAR'
        ],
        'Nigeria' => [
            'capital' => 'Abuja',
            'currency' => 'NGN'
        ],
    ],
]]);
// third parameter is false for non-strict mode
$asterisk->has('locations.*.*.capital', 'Kyiv', false); // true
$asterisk->has('locations.*.*.currency', 'ZAR', false); // true
$asterisk->has('locations.Europe.*.currency', 'ZAR', false); // false
```

<a name="isempty"></a>
### isEmpty()

Checks if a given key is empty (returns boolean true or false):
```php
$asterisk->isEmpty('user.name');

// ArrayAccess
empty($asterisk['user.name']);

// Equivalent vanilla PHP
empty($array['user']['name']);
```

Multiple keys:
```php
$asterisk->isEmpty([
    'user.name',
    'page.title'
]);
```

Checks the whole Asterisk object:
```php
$asterisk->isEmpty();
```

Also works with asterisk in key:
```php
$asterisk = new Asterisk(['user1' => ['name' => 'John'], 'user2' => ['name' => 'Robin']);
$asterisk->isEmpty('*.name'); // false
$asterisk->isEmpty('*.spouse'); // true
```

<a name="merge"></a>
### merge()

> It works like [Adbar\Dot::merge()](https://github.com/adbario/php-dot-notation#merge)

<a name="mergerecursive"></a>
### mergeRecursive()

> It works like [Adbar\Dot::mergeRecursive()](https://github.com/adbario/php-dot-notation#mergeRecursive)

<a name="mergerecursivedistinct"></a>
### mergeRecursiveDistinct()

> It works like [Adbar\Dot::mergeRecursiveDistinct()](https://github.com/adbario/php-dot-notation#mergeRecursiveDistinct)

<a name="pull"></a>
### pull()

Returns the value of a given key and deletes the key:
```php
echo $asterisk->pull('user.name');

// Equivalent vanilla PHP < 7.0
echo isset($array['user']['name']) ? $array['user']['name'] : null;
unset($array['user']['name']);

// Equivalent vanilla PHP >= 7.0
echo $array['user']['name'] ?? null;
unset($array['user']['name']);
```

Returns a given default value, if the given key doesn't exist:
```php
echo $asterisk->pull('user.name', 'some default value');
```

Returns all the stored items as an array and clears the Dot object:
```php
$items = $asterisk->pull();
```

<a name="push"></a>
### push()

Pushes a given value to the end of the array in a given key:
```php
$asterisk->push('users', 'John');

// Equivalent vanilla PHP
$array['users'][] = 'John';
```

Pushes a given value to the end of the array:
```php
$asterisk->push('John');

// Equivalent vanilla PHP
$array[] = 'John';
```

<a name="replace"></a>
### replace()

> It works like [Adbar\Dot::replace()](https://github.com/adbario/php-dot-notation#replace)

<a name="set"></a>
### set()

Sets a given key / value pair:
```php
$asterisk->set('user.name', 'John');

// ArrayAccess
$asterisk['user.name'] = 'John';

// Equivalent vanilla PHP
$array['user']['name'] = 'John';
```

Multiple key / value pairs:
```php
$asterisk->set([
    'user.name' => 'John',
    'page.title'     => 'Home'
]);
```

<a name="setarray"></a>
### setArray()

> It works like [Adbar\Dot::setarray()](https://github.com/adbario/php-dot-notation#setarray)

<a name="setreference"></a>
### setReference()

> It works like [Adbar\Dot::setreference()](https://github.com/adbario/php-dot-notation#setreference)

<a name="tojson"></a>
### toJson()

> It works like [Adbar\Dot::toJson()](https://github.com/adbario/php-dot-notation#toJson)


## License

[MIT license](LICENSE)
