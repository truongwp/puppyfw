## [Unreleased]
### Added
- Options page builder
- Hook `puppyfw_before_init`

### Changed
- Refactor framework structure and api

## [0.2.0]
### Added
- Hook `puppyfw_after_init`
- Hook `puppyfw_before_page_rendering`
- Added API to get page instance
- Added API to get option value
- Added API for defining fields use OOP

### Removed
- Removed demo code. It will be moved to documentation

### Changed
- Used singleton pattern for Framework class
- Moved framework init to `plugins_loaded` hook
- Fix style editor field
- Improve demo

## [0.1.2]
### Added
- Added `html`, `colorpicker`, `datepicker` field

## [0.1.1] - 2017-09-21
### Added
- Check user capability when save

### Removed
- Remove short syntax of dependency

## [0.1.0] - 2017-09-19
- First release

[Unreleased]: https://github.com/truongwp/puppyfw/compare/0.2.0...HEAD
[0.2.0]: https://github.com/truongwp/puppyfw/compare/0.1.2...HEAD
[0.1.2]: https://github.com/truongwp/puppyfw/compare/0.1.1...0.1.2
[0.1.1]: https://github.com/truongwp/puppyfw/compare/0.1.0...0.1.1
