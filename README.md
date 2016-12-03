# Elemeno

The official PHP client for Elemeno, an API based CMS. Use this module to easily integrate your content created on Elemeno into your PHP projects.
  		  
Create an account and get started for free at https://elemeno.io

## Requirements

- A minimum of PHP 5.5.0
- [Composer](https://getcomposer.org/doc/00-intro.md) must be installed 

## Installation

If Composer is installed globally:
```bash
composer require elemeno/elemeno:~0.1
```

If Composer is installed locally:
```bash
php composer.phar require elemeno/elemeno:~0.1
```

## Elemeno Documentation

API documentation is available at http://docs.elemeno.io

## Usage

If you haven't already, you must include the following line when using Composer:
```php
require_once 'vendor/autoload.php';
```

You can then create a new Elemeno Client with the following:
```php
// Create a new Elemeno Client with your unique API key
$elemeno = new \Elemeno\Client('123e4567-e89b-12d3-a456-426655440000');
```
**Note: API keys can be created in settings**

## Example Usage

```php
<?php
	require_once 'vendor/autoload.php';

	$elemeno = new \Elemeno\Client('123e4567-e89b-12d3-a456-426655440000');

	$options = [
		'filters' => [
			'$title' => [
				'$contains' => 'pie'
			]
		],
		'sort' => [
			'$datePublished' => 'ASC'
		],
		'page' => 1,
		'size' => 20
	];

	print_r($elemeno->getCollectionItems('recipes', $options));
?>
```

## API Overview

### Singles

#### `$elemeno->getSingles([$options])`

```php
$options = [
	'sort' => [
		'$dateUpdated' => 'DESC'
	],
	'page' => 1,
	'size' => 20
];

print_r($elemeno->getSingles($options));
```

#### `$elemeno->getSingle($singleSlug)`

```php
print_r($elemeno->getSingle('about'));
```

### Collections

#### `$elemeno->getCollections([$options])`

```php
$options = [
	'sort' => [
		'$dateCreated' => 'DESC'
	],
	'page' => 1,
	'size' => 20
];

print_r($elemeno->getCollections($options));
```

#### `$elemeno->getCollection($collectionSlug)`

```php
print_r($elemeno->getCollection('recipes'));
```

#### `$elemeno->getCollectionItems($collectionSlug, [$options])`

```php
$options = [
	'filters' => [
		'$title' => [
			'$contains' => 'pie'
		]
	],
	'sort' => [
		'$datePublished' => 'ASC'
	],
	'page' => 1,
	'size' => 20
];

print_r($elemeno->getCollectionItems('recipes', $options));
```

#### `$elemeno->getCollectionItem($collectionSlug, $itemSlug, [$options])`

```php
$elemeno->getCollectionItem(
	'recipes',   // collectionSlug
	'apple-pie'  // itemSlug
);
```

or `byId`:

```php
$options = [
	'byId' => true
];

$elemeno->getCollectionItem(
	'recipes',                               // collectionSlug
	'281cf9b2-b355-11e6-b10e-5b3ff757fea2',  // itemId
	$options
);
```
