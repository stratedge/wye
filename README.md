# Wye

[![Build Status](https://travis-ci.org/stratedge/wye.svg?branch=master)](https://travis-ci.org/stratedge/wye)
[![Latest Stable Version](https://poser.pugx.org/stratedge/wye/v/stable)](https://packagist.org/packages/stratedge/wye)
[![Total Downloads](https://poser.pugx.org/stratedge/wye/downloads)](https://packagist.org/packages/stratedge/wye)
[![License](https://poser.pugx.org/stratedge/wye/license)](https://packagist.org/packages/stratedge/wye)

A library for mocking native PDO connections and query results

Wye is designed to mock PHP's PDO class in order to abstract away the need for a database in unit testing. Individual query results can be defined and controlled, and all queries that are executed are logged for inspection or use in assertions.

"[In firefighting a] hose appliance used for splitting one line into two discharges. Often a gated wye is used to allow and disallow water flow through the two separate discharges." - [https://en.wikipedia.org/wiki/Glossary\_of\_firefighting\_equipment#Wye]()

## Installation

Wye can be installed using Composer:

```sh
composer require stratedge/wye
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

#### Setting the Last Insert ID

When conducting inserts, you may need to get the ID of the last inserted row through the `PDO::lastInsertId()` method. Since no actual rows are created by Wye, you will need to define the last insert ID on the `Stratedge\Wye\Result` object that corresponds to the insert statement.

> **NOTE:** All values added as last insert IDs will be converted to and returned as strings. If the value cannot be converted to a string, PHP will throw an exception/throwable.

```php
$result->lastInsertId(5); //Use the "smart" getter/setter method which sets the value if one is provided
$result->setLastInserId(5); //Or use the explicit setter

//The methods that set the last insert ID return the Result object for chaining
Wye::makeResult()->lastInsertId(10)->attach();
```

#### Setting the Row Count

By default, when the `rowCount()` method is called on `Stratedge\Wye\PDOStatement`, the count of rows that have been added to the corresponding `Stratedge\Wye\Result` object will be returned.

You can control this number by setting a row count manually, which will override the count of rows contained in the result, by calling `Stratedge\Wye\Result::setNumRows()`.

```php
//By default, the number of added rows is returned as the row count
$result->addRow(['id' => 47]); //Row-count is now 1

//Override the default by manually setting the number of rows affected
$result->setNumRows(12); //Row-count will now return 12

//The method that sets the number of rows returns the Result object for chaining
$result->setNumRows(3)->attach();
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

## Todo & Roadmap

Wye is far from finished. _Repeat: far from finished_. It works for a few cases presently but needs to handle all of them, plus have a robust suite of unit tests before it can be of greatest use.

Below are the areas needing work. If you'd like to help, pull requests are accepted!

Definitions:

* Items marked with **_Implement_** have not yet been started and must be built.
* Items marked with **_Finish_** are presently available for use, but may not account for all the possible functionality/errors that must be implemented.

### General

- Phase out the "smart" getters and setters
- Fetch mode should be an object in PDOStatement

### Stratedge\Wye\Wye

- ~~Remove boot functionality~~
- Implement a collection for storing statements
- Implement a collection for storing results
- Implement recording when transactions are used
- Implement a system for throwing errors/exceptions

### Stratedge\Wye\PDO\PDO

- ~~Implement the `beginTransaction` method~~
- Implement the `commit` method
- Implement the `errorCode` method
- Implement the `errorInfo` method
- Implement the `exec` method
- Implement the `getAttribute` method
- Implement the `getAvailableDrivers` method
- Implement the `inTransaction` method
- Finish the `lastInsertId` method
- Implement the `query` method
- ~~Implement the `quote` method~~
- Implement the `rollBack` method
- Implement the `setAttribute` method

### Stratedge\Wye\PDO\PDOStatement

- Implement `bindColumn` method
- Implement `bindParam` method
- Implement `bindValue` method
- Implement `closeCursor` method
- Implement `columnCount` method
- Implement `debugDumpParams` method
- Implement `errorCode` method
- Implement `errorInfo` method
- Finish `execute` method
- Finish `fetch` method
- ~~Implement `fetchAll` method~~
- Implement `fetchColumn` method
- ~~Implement `fetchObject` method~~
- Implement `getAttribute` method
- Implement `getColumnMeta` method
- Implement `nextRowset` method
- ~~Implement `rowCount` method~~
- Implement `setAttribute` method
- ~~Implement `setFetchMode` method~~

### Stratedge\Wye\Result

- Finish `fetch` method
- Implement `fetchColumn` method
- Implement `rowCount` method

### Stratedge\Wye\Row

- Implement `PDO::FETCH_CLASSTYPE` flag on `PDO::FETCH_CLASS`
- Implement `PDO::FETCH_PROPS_LATE` flag on `PDO::FETCH_CLASS`
- Implement `PDO::FETCH_BOUND`
- Implement `PDO::FETCH_INTO`
- Implement `PDO::FETCH_LAZY`
- Implement `PDO::FETCH_NAMED`
- Implement `PDO::FETCH_NUM`
- ~~Implement `PDO::FETCH_OBJ`~~

## Acknowledgements

Wye is built on top of an idea I first saw implemented by my friend/colleague [Josh](https://github.com/phpcodecrafting).
