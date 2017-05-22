# Wye

[![Build Status](https://travis-ci.org/stratedge/wye.svg?branch=master)](https://travis-ci.org/stratedge/wye)
[![Latest Stable Version](https://poser.pugx.org/stratedge/wye/v/stable)](https://packagist.org/packages/stratedge/wye)
[![Total Downloads](https://poser.pugx.org/stratedge/wye/downloads)](https://packagist.org/packages/stratedge/wye)
[![License](https://poser.pugx.org/stratedge/wye/license)](https://packagist.org/packages/stratedge/wye)

A library that makes unit testing database-driven code in PHP a breeze. Mock the native PDO class, define query results, and inspect executed statements.

"[In firefighting a] hose appliance used for splitting one line into two discharges. Often a gated wye is used to allow and disallow water flow through the two separate discharges." - [https://en.wikipedia.org/wiki/Glossary\_of\_firefighting\_equipment#Wye](https://en.wikipedia.org/wiki/Glossary\_of\_firefighting\_equipment#Wye)

# Installation

Wye is registered with [Packagist](https://packagist.org) and can be installed with [Composer](https://getcomposer.org). Run the following on the command line:

```sh
composer require --dev stratedge/wye
```

Once Wye has been included in your project, just make sure to require Composer's autoloader:

```php
require_once 'vendor/autoload.php';
```

# Basic Usage Example

```php
use Stratedge\Wye\Wye;

//In test setup
//-------------

//Reset the Wye to its clean state
Wye::reset()

//Create a Wye PDO object
$pdo = Wye::makePDO();

//Inject PDO into database layer
Database::setConnection($pdo);

//In test
//-------

//Create a Result object
$result = Wye::makeResult();

//Add a row or two to return
$result->addRow(['type' => 'Pumper', 'apparatus' => 'Engine 1']);

//Attach Result to Wye to be served when a query is executed
$result->attach();

//Run code to test
$class_to_test->doSomething();

//Inspect execution
$stmt = Wye::getStatementAtIndex(0);
$this->assertStringStartsWith('SELECT', $stmt->getStatement());
$this->assertCount(2, count($stmt->getBindings());
$this->assertSame('id', $stmt->getBindings()->first()->getParameter());
$this->assertSame(1, Wye::getNumQueries());
//and more!
```

> **<u>WAIT, THERE'S MORE</u>**  
> For a much more in-depth look at Wye' usage, check out the extensive documentation, especially the section on [Basic Usage](https://github.com/stratedge/wye/wiki/Introduction#basic-usage).

# Documentation

Complete and up-to-date documentation is available on [the Wiki](https://github.com/stratedge/wye/wiki).

Some of the major topics discussed include: [An Introduction](https://github.com/stratedge/wye/wiki/Introduction), [Defining Results](https://github.com/stratedge/wye/wiki/Defining-Results), [Inspecting Execution Info](https://github.com/stratedge/wye/wiki/Inspecting-Execution-Info), and [Inspecting Bindings](https://github.com/stratedge/wye/wiki/Inspecting-Bindings).

## Todo & Roadmap

List of enhancements and implementations is available on the [Todo & Roadmap](https://github.com/stratedge/wye/wiki/Todo-&-Roadmap) page of the wiki.

## Issue Tracking

If you should find an issue in Wye, and you think you can fix it, by all means please do so. Pull requests are gladly accepted. If you don't have the time or energy to fix it, please log the issue with as much detail as possible so I can take a look.

Issues can be logged on the [Github issue tracker](https://github.com/stratedge/wye/issues).

## Acknowledgements

Wye is built on top of an idea I first saw implemented by my friend/colleague [Josh](https://github.com/phpcodecrafting).
