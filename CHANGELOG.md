# Change Log - DataManipulation

## [1.0.3] - 2026-08-12

### Added

- ArrayManipulators::min in order to retrieve the minimun value from a given array
- ArrayManipulators::max in order to retrieve the maximun value from a given array
- ArrayManipulators::map in order to apply a callback function for each iterable elements
- ArrayManipulators::fillKeys in order to create a new iterable with the provided keys and filled with the selected value
- StringsManipulators::hash method in order to create signatures with old hash systems (not HMAC)
- StringsManipulators::split method in order to split a string into a StringManipulators collection, with a defined bytes length(instead chars length) with support for multibyte strings
- StringsManipulators::substringBeforeChar and StringsManipulators::substringAfterChar methods, now accept parameter occurrence, in order to apply manipulation over subsequence of string, including negative for start to search from the end

### Changed

- StringsManipulators::chunk method reuse internal methods (split and concatenation) in order to unify the use of native functions for manteinance if someone are deprecated
- ArrayManipulators can receive as parameter a sequence of elements, and perform the manipulations for every one. Or you can use a multidimensional array for apply a list of manipulators for the group
- ArrayManipulators::filter now accepts a callback as parameter

### Fixed

- StringsManipulators::reverse method, in order to apply manipulation over multibyte strings
- StringsManipulators::replace method, in order to apply a rigth case sensitive verification
- StringsManipulators::padding method, in order to apply a rigth length for multibyte strings for PHP versions prior 8.3
- Check for stripos == false when substring does not have more data
- Verifyed php 8.6 compatibility

## [1.0.2] - 2026-01-30

### Added

- StringsManipulators::base64UrlX methods, in order to retrieve a new StringManipulators with url safe base64 encoding/decoding
- StringsManipulators::hashHmac method, in order to retrieve a new StringManipulators with digested value

### Changed

### Fixed

## [1.0.1] - 2026-01-09

### Added

- StringsManipulators::substringBeforeChar method, in order to retrieve a new StringManipulators with a substring since 0 to selector position
- StringsManipulators::substringAfterChar method, in order to retrieve a new StringManipulators with a substring since selector position
- StringsManipulators::explode in order to apply an explode and return a list of new StringManipulators for every part

### Changed

### Fixed

## [1.0.0] - 2026-01-07

### Added

- Initial release, first version

### Changed

### Fixed
