# Wye

[![Build Status](https://travis-ci.org/stratedge/wye.svg?branch=master)](https://travis-ci.org/stratedge/wye)

A library for mocking native PDO connections and query results

Wye is designed to mock PHP's PDO class in order to abstract away the need for a database in unit testing. Individual query results can be defined and controlled, and all queries that are executed are logged for inspection or use in assertions.

"[In firefighting a] hose appliance used for splitting one line into two discharges. Often a gated wye is used to allow and disallow water flow through the two separate discharges." - [https://en.wikipedia.org/wiki/Glossary\_of\_firefighting\_equipment#Wye]()

## Installation

Wye can be installed using Composer:

```sh
composer config repositories.wye vcs https://github.com/stratedge/wye.git
composer require stratedge/wye:dev-master
```

## Usage

### Replacing Native PDO

Since Wye's PDO class extends from the native PDO class, simply inject Wye's PDO class in place of the native PDO class. A new `Stratedge\Wye\PDO\PDO` class can be generated with `Stratedge\Wye\Wye::makePDO()`.

```php
<?php

use Stratedge\Wye\Wye;

$pdo = Wye::makePDO();

//You can now inject $pdo wherever you would normally inject the native PDO class in your framework
```

### Defining Results

Since Wye does not connect to a database, you will need to define what results Wye should return every time a query is executed.

```php
$result = Wye::makeResult(); //$result is an instance of \Stratedge\Wye\Result
```

#### Adding Rows

Out of the box, a `Stratedge\Wye\Result` object will accept rows defined as associatiave arrays of column-name/value pairs.

> #### A Note on Constructing Row Data:
> You should define your return data in its raw state - meaning as the data source would return it.  Wye will use the fetch style that your code defines to format the data on your behalf so that if you change your fetch style in the future there should be no need to revisit your test data.

```php
//Define a single row
$result->addRow(["id" => 1, "apparatus" => "Engine 1"]);

//Define multile rows
$result->addRows(
	["id" => 2, "apparatus" => "Engine 2"],
	["id" => 3, "apparatus" => "Ladder 5"]
);

//Define multiple rows by chaining
$result->addRow(["id" => 4, "apparatus" => "Rescue 1")
	->addRow(["id" => 5, "apparatus" => "Squad 2")
	->addRow(["id" => 6, "apparatus" => "Command Car 1");
```

#### Adding Rows When Column Names Are Predefined

For the sake of ease, readibility, and brevity, you can define the columns of a `Stratedge\Wye\Result` object once, and then each row can be defined by a plain array of values, or as individual parameters to the `addRow()` method.

> #### A Note on Constructing Row Data:
> You should define your return data in its raw state - meaning as the data source would return it.  Wye will use the fetch style that your code defines to format the data on your behalf so that if you change your fetch style in the future there should be no need to revisit your test data.

```php
//There are two ways to define the columns for a result:
$result->columns(["id", "apparatus"]); //As an array of values
$result->columns("id", "apparatus"); //As individual parameters

$result->addRow([7, "Engine 8"]); //Row defined by plain array
	->addRow(8, "Ladder 2"); //Row defined by individual parameters
	->addRows([
		[9, "Rescue 2"],
		[10, "Ambulance 1"]
	]);
```

#### Attaching Results

Once the result is built it must be attached to the Wye so it can be served when a query is executed. You can attach as many `Stratedge\Wye\Result` objects to the Wye as you wish, and the same `Stratedge\Wye\Result` object can be attached any number of times. Results are used in the order that they are attached.

```php
//There are two ways to attach the Result to the Wye:
Wye::addResult($result); //Pass the result to the Wye
$result->attach(); //Tell the result to attach itself (convenient for chaining)
```

When a query is executed the corresponding PDOStatement will receive the data from the `Stratedge\Wye\Result` object that next in line to be served.

### Resetting Wye

When unit testing, each test should start with a clean slate. As such, Wye includes a `reset()` method to cleanup the data for the next test:

```php
use Stratedge\Wye\Wye;

Wye::reset();
```

### Getting Query Execution Data

#### Get Number of Queries Run

```php
use Stratedge\Wye\Wye;

$num_queries = Wye::numQueries();
```

#### Get All Statements Executed

```php
use Stratedge\Wye\Wye;

$statements = Wye::statements() //Returns an array of \Stratedge\Wye\PDO\PDOStatement objects
```

#### Get Statement Executed By Index

If you wish to inspect a single `PDOStatement` run at a particular point in the order of queries executed, you may use the `getStatementAtIndex()` method;

```php
use Stratedge\Wye\Wye;

$statement = Wye::getStatementAtIndex(3); //Returns the 4th query executed (0-indexed)
```

#### Get All Attached Results

```php
use Stratedge\Wye\Wye;

$results = Wye::results() //Returns an array of \Stratedge\Wye\Result objects
```
