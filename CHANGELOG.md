# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/), and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## Unreleased

For a full diff see [`0.3.1...master`][0.3.1...master].

## [`0.3.1`][0.3.1]

For a full diff see [`0.3.0...0.3.1`][0.3.0...0.3.1].

### Added

* Added support for PHP 8.0 ([#79]), by [@pascalbaljet]

### Changed

* Dropped support for PHP 5.4 ([#55]), by [@localheinz]
* Dropped support for PHP 5.5 ([#57]), by [@localheinz]
* Dropped support for PHP 5.6 ([#58]), by [@localheinz]
* Dropped support for PHP 7.0 ([#59]), by [@localheinz]

## [`0.3.0`][0.3.0]

For a full diff see [`0.2.7...0.3.0`][0.2.7...0.3.0].

### Added

* Added support for PHP 7.1 ([#47]), by [@localheinz]
* Added support for PHP 7.2 ([#48]), by [@localheinz]
* Added support for PHP 7.3 ([#49]), by [@localheinz]
* Added support for PHP 7.4 ([#50]), by [@localheinz]

### Changed

* Dropped support for HHVM ([#35]), by [@localheinz]
* Moved constructor from `NodeTrait` to `Node` ([#30]), by [@asalazar-pley]

## [`0.2.7`][0.2.7]

For a full diff see [`0.2.6...0.2.7`][0.2.6...0.2.7].

### Added

* Added pre-order and post-order visitors ([#24]), by [@localheinz]

## [`0.2.6`][0.2.6]

For a full diff see [`0.2.5...0.2.6`][0.2.5...0.2.6].

### Added

* Added a `getSize()` method to `Node` ([#17]), by [@Djuki]

## [`0.2.5`][0.2.5]

For a full diff see [`0.2.4...0.2.5`][0.2.4...0.2.5].

### Added

* Added `getDepth()` and `getHeight()` methods to `Node` ([#9]), by [@nicmart]

## [`0.2.4`][0.2.4]

For a full diff see [`0.2.3...0.2.4`][0.2.3...0.2.4].

### Added

* New accessor methods ([#6]), by [@mdwheele]

## [`0.2.3`][0.2.3]

For a full diff see [`0.2.2...0.2.3`][0.2.2...0.2.3].

### Changed

* `Node::getAncestors()` now does not return the current node ([#4]), by [@nicmart],

## [`0.2.2`][0.2.2]

For a full diff see [`0.2.1...0.2.2`][0.2.1...0.2.2].

### Fixed

* Fixed a bug in the builder ([#3]), by [@nicmart]

## [`0.2.1`][0.2.1]

For a full diff see [`0.2.0...0.2.1`][0.2.0...0.2.1].

### Added

* Added `root()` and `isRoot()` to `Node`

## [`0.2.0`][0.2.0]

For a full diff see [`0.1.2...0.2.0`][0.1.2...0.2.0].

### Changed

* Dropped support for PHP 5.3
* Extracted `NodeTrait` from `Node`

## [`0.1.2`][0.1.2]

For a full diff see [`0.1.1...0.1.2`][0.1.1...0.1.2].

### Added

* Added `YieldVisitor`, to get the yield of the tree

## [`0.1.1`][0.1.1]

For a full diff see [`fcfd14e...v0.1.1`][fcfd14e...0.1.1].

### Added

* Parent and neighbors methods, by [@jdeniau]

[0.1.1]: https://github.com/nicmart/Tree/releases/tag/v0.1.0
[0.1.2]: https://github.com/nicmart/Tree/releases/tag/v0.1.2
[0.2.0]: https://github.com/nicmart/Tree/releases/tag/v0.2.0
[0.2.1]: https://github.com/nicmart/Tree/releases/tag/v0.2.1
[0.2.2]: https://github.com/nicmart/Tree/releases/tag/v0.2.2
[0.2.3]: https://github.com/nicmart/Tree/releases/tag/v0.2.3
[0.2.4]: https://github.com/nicmart/Tree/releases/tag/v0.2.4
[0.2.5]: https://github.com/nicmart/Tree/releases/tag/v0.2.5
[0.2.6]: https://github.com/nicmart/Tree/releases/tag/v0.2.6
[0.2.7]: https://github.com/nicmart/Tree/releases/tag/v0.2.7
[0.3.0]: https://github.com/nicmart/Tree/releases/tag/v0.3.0
[0.3.1]: https://github.com/nicmart/Tree/releases/tag/0.3.1

[fcfd14e...0.1.1]: https://github.com/nicmart/Tree/compare/fcfd14e...v0.1.1
[0.1.1...0.1.2]: https://github.com/nicmart/Tree/compare/v0.1.1...v0.1.2
[0.1.2...0.2.0]: https://github.com/nicmart/Tree/compare/v0.1.2...v0.2.0
[0.2.0...0.2.1]: https://github.com/nicmart/Tree/compare/v0.2.0...v0.2.1
[0.2.1...0.2.2]: https://github.com/nicmart/Tree/compare/v0.2.1...v0.2.2
[0.2.2...0.2.3]: https://github.com/nicmart/Tree/compare/v0.2.2...v0.2.3
[0.2.3...0.2.4]: https://github.com/nicmart/Tree/compare/v0.2.3...v0.2.4
[0.2.4...0.2.5]: https://github.com/nicmart/Tree/compare/v0.2.4...v0.2.5
[0.2.5...0.2.6]: https://github.com/nicmart/Tree/compare/v0.2.5...v0.2.6
[0.2.6...0.2.7]: https://github.com/nicmart/Tree/compare/v0.2.6...v0.2.7
[0.2.7...0.3.0]: https://github.com/nicmart/Tree/compare/v0.2.7...0.3.0
[0.3.0...0.3.1]: https://github.com/nicmart/Tree/compare/0.3.0...0.3.1
[0.3.1...master]: https://github.com/nicmart/Tree/compare/0.3.1...master

[#3]: https://github.com/nicmart/Tree/issues/3
[#4]: https://github.com/nicmart/Tree/issues/4
[#6]: https://github.com/nicmart/Tree/pull/6
[#9]: https://github.com/nicmart/Tree/issues/9
[#17]: https://github.com/nicmart/Tree/pull/17
[#24]: https://github.com/nicmart/Tree/pull/24
[#30]: https://github.com/nicmart/Tree/pull/30
[#35]: https://github.com/nicmart/Tree/pull/35
[#47]: https://github.com/nicmart/Tree/pull/47
[#48]: https://github.com/nicmart/Tree/pull/48
[#49]: https://github.com/nicmart/Tree/pull/49
[#50]: https://github.com/nicmart/Tree/pull/50
[#55]: https://github.com/nicmart/Tree/pull/55
[#57]: https://github.com/nicmart/Tree/pull/57
[#58]: https://github.com/nicmart/Tree/pull/58
[#59]: https://github.com/nicmart/Tree/pull/59
[#79]: https://github.com/nicmart/Tree/pull/79

[@asalazar-pley]: https://github.com/asalazar-pley
[@Djuki]: https://github.com/Djuki
[@jdeniau]: https://github.com/jdeniau
[@localheinz]: https://github.com/localheinz
[@mdwheele]: https://github.com/mdwheele
[@nicmart]: https://github.com/nicmart
[@pascalbaljet]: https://github.com/pascalbaljet
