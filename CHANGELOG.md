# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased] - 2018-XX-XX

### Added
- Define custom Export Descriptions via product attribute
- Support for third party shipping methods with dynamic method codes
- Configuration of default products per available route
- Mass action and cron autocreation for cross border shipping
### Changed
- Updated DHL product names and codes
- Reordered configuration fields to make dependencies clearer
### Deprecated

### Removed
- Removed support for Magento 2.1
### Fixed
- Shipping product options for DE->AT route
- Packaging popup not respecting config defaults for preselects
### Security

## [0.8.1] - 2018-05-24

### Fixed

- Payment method selector for COD methods now displays all available methods
- Improved packaging popup template injection to be less invasive

### Security

- Improved output escaping in backend templates

## 0.8.0 - 2018-01-10

### Added

- API support for postal facilities (Packstation, Postfiliale)
- Cancel Business Customer Shipping labels
- Cash On Delivery support for Global Shipping API labels

### Fixed

- Now displaying separate tracking link for Global Shipping API labels
- Reworked product attribute uninstaller

[Unreleased]: https://git.netresearch.de/dhl/module-shipping-m2/compare/1.8.1...develop
[0.9.0]: https://git.netresearch.de/dhl/module-shipping-m2/compare/0.8.1...0.9.0
[0.8.1]: https://git.netresearch.de/dhl/module-shipping-m2/compare/0.8.0...0.8.1
