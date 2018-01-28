# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased]

- No pending changes

## [0.5.0] - 2018-01-28
### Added
- Mock for the `PDO::exec()` method

## [0.4.0] - 2017-07-30
### Added
- Mock for the `PDO::commit()` method
- Mock for the `PDO::rollBack()` method
- `rolled_back` property to `Stratedge\Wye\Transaction`
- `getRolledBack()` method to `Stratedge\Wye\Transaction`
- `setRolledBack()` method to `Stratedge\Wye\Transaction`

## [0.3.0] - 2017-05-23
### Added
- Mock for the `PDOStatement::bindValue()` method
- Inspect parameter, value, and data type bindings on executed statements
- CHANGELOG.md

### Changed
- Move documentation from README.md to Github wiki - [https://github.com/stratedge/wye/wiki](https://github.com/stratedge/wye/wiki)
- Remove the `params` property from `Stratedge\Wye\PDO\PDOStatement`
- Remove `params()` method from `Stratedge\Wye\PDO\PDOStatement`
- Remove `getParams()` method from `Stratedge\Wye\PDO\PDOStatement`
- Remove `setParams()` method from `Stratedge\Wye\PDO\PDOStatement`
- Drop support for HHVM <= 3.6

## [0.2.0] - 2017-05-02
### Added
- Mock for the `PDOStatement::rowCount()` method
- Return count of rows associated to a result
- Override and set the count of rows for a specific result
- Support for PHP 7.1

### Changed
- Drop support for PHP 5.5

## 0.1.0 - 2017-01-05
### Added
- Register results to return when queries are run
- Retrieve information about each query that is run
- Fetch results with `PDO::FETCH_ASSOC`, `PDO::FETCH_BOTH`, `PDO::FETCH_CLASS`,
    and `PDO::FETCH_OBJ` formatting
- Record transactions
- Record query quoting
- Reset the record of queries that have been run
- Mock for the `PDOStatement::execute()` method
- Mock for the `PDOStatement::fetch()` method
- Mock for the `PDOStatement::fetchAll()` method
- Mock for the `PDOStatement::fetchObject()` method
- Mock for the `PDOStatement::setFetchMode()` method
- Mock for the `PDO::beginTransaction()` method
- Mock for the `PDO::lastInsertId()` method
- Mock for the `PDO::prepare()` method
- Mock for the `PDO::quote()` method

[Unreleased]: https://github.com/stratedge/wye/compare/v0.5.0...HEAD
[0.4.0]: https://github.com/stratedge/wye/compare/v0.4.0...v0.5.0
[0.4.0]: https://github.com/stratedge/wye/compare/v0.3.0...v0.4.0
[0.3.0]: https://github.com/stratedge/wye/compare/v0.2.0...v0.3.0
[0.2.0]: https://github.com/stratedge/wye/compare/v0.1.0...v0.2.0
