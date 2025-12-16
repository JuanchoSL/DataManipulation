# DataManipulation

## Description

Little methods collection in order to manipulate variables contents. Group of some features in order to clean, modify, convert, apply math operations and some other actions

## Install

```bash
composer require juanchosl/datamanipulation
```

## Manipulators

### Strings

| Manipulation          | Description |
| --------------------- | ----------- |
| substring             |             |
| repeat                |             |
| format                |             |
| replace               |             |
| reverse               |             |
| toUpperFirst          |             |
| toLowerFirst          |             |
| toUpperWords          |             |
| toUpper               |             |
| toLower               |             |
| padding               |             |
| preppend              |             |
| concatenation         |             |
| chunk                 |             |
| wordWrap              |             |
| trim                  |             |
| ltrim                 |             |
| rtrim                 |             |
| shuffle               |             |
| rotate13              |             |
| md5                   |             |
| quotedPrintableEncode |             |
| quotedPrintableDecode |             |
| uuEncode              |             |
| uuDecode              |             |
| base64Encode          |             |
| base64Decode          |             |
| binToHex              |             |
| hexToBin              |             |

### Numbers

| Operation          | Description                                                                                       |
| ------------------ | ------------------------------------------------------------------------------------------------- |
| absolute           | The positive value, ignoring the original, allways to positive                                    |
| negation           | the inversed, if is a positive, converts to negative                                              |
| sum                | sum a quantity to the internal object value                                                       |
| sub                | substraction a quantity to the internal object value                                              |
| product            | calculate the product with the internal object value                                              |
| division           | calculate the division with the internal object value                                             |
| module             | calculate the module of a division with the internal object value                                 |
| exponent           | calculate the exponent of the internal object value to the indicated exponent                     |
| root               | calculate the root of the internal object value to the indicated degree, square by default        |
| percent            | calculate the indicated percentage of the internal object value                                   |
| increasePercent    | add the indicated percentage of the internal object value                                         |
| decreasePercent    | down the indicated percentage of the internal object value                                        |
| roundHalfUp        |                                                                                                   |
| roundHalfDown      |                                                                                                   |
| roundAwayToZero    |                                                                                                   |
| roundAwayFromZero  |                                                                                                   |
| roundToHighInteger |                                                                                                   |
| roundToLowInteger  |                                                                                                   |
| min                | pass an array or floats list and return the min including the internal value into the comparation |
| max                | pass an array or floats list and return the max including the internal value into the comparation |

```php
echo (string)(NumbersManipulators($pvu = 100))
    ->product($units = 10)
    ->increasePercent($taxes = 21); 
    
//1210
```

### Date + Times

Check, parse a value as a date from some origins and formats, and retunrs a DateTime instance

#### Create from excel time value

```php
echo  (new DateManipulators())
    ->fromExcel(46023)
    ->format("Y-m-d");
    
// 2026-01-01
```

#### Create from timestamp

```php
echo  (new DateManipulators())
    ->fromTimestamp(1735689600)
    ->format("Y-m-d");

// 2026-01-01
```

#### Create from string

```php
echo  (new DateManipulators())
    ->fromString("Thursday, 01-Jan-26 00:00:00 UTC")
    ->format("Y-m-d");

// 2026-01-01
```

#### Create from knowed format

```php
echo  (new DateManipulators())
    ->fromFormatString(20260101, "Ymd")
    ->format("Y-m-d");

// 2026-01-01
```

## Sanitizers

Filter, clean and convert contents variables, for use from forms, file contents, DTOs or other origins

- Strings
- Numbers

### Strings

#### Clean Email

[FILTER_SANITIZE_EMAIL](https://www.php.net/manual/es/filter.constants.php#constant.filter-sanitize-email).

```php
$sanitizer = (new StringSanitizers())->email();
echo $sanitizer('Juan. Sanchez@tecnicosweb.com'); //Juan.Sanchez@tecnicosweb.com
```

#### Clean URL

[FILTER_SANITIZE_URL](https://www.php.net/manual/es/filter.constants.php#constant.filter-sanitize-url).

#### Add Slashes

[FILTER_SANITIZE_ADD_SLASHES](https://www.php.net/manual/es/filter.constants.php#constant.filter-sanitize-add-slashes).

```php
$sanitizer = (new StringSanitizers())->addSlashes();
echo $sanitizer('SELECT * FROM "table"'); //SELECT * FROM \"table\"
```

#### HTML Special Chars

[FILTER_SANITIZE_FULL_SPECIAL_CHARS](https://www.php.net/manual/es/filter.constants.php#constant.filter-sanitize-full-special-chars).

```php
$sanitizer = (new StringSanitizers())->htmlSpecialChars();
echo $sanitizer('<div>Text</div>'); //&lt;div&gt;Text&lt;/div&gt;
```

#### Strip HTML Tags

[strip_tags](https://www.php.net/manual/es/function.strip-tags.php).

```php
$sanitizer = (new StringSanitizers())->stripTags();
echo $sanitizer('<div>Text</div>'); //Text
```

#### Combine Sanitizators

```php
$sanitizator= (new StringSanitizers())->stripTags()->htmlSpecialChars();
echo $sanitizator("<div>Camión&\r\n</div>"); //"Cami&oacute;n&amp;\r\n"
```

### Extended String Sanitizators

#### setStripBacktick

Remove or not the backtick character, an executor for unix terminals, in order to avoid code execution

#### setStripChars

You can indicate if would remove the control ASCII chars (less than 32) or the extended ASCII codes (greather than 127)

#### setEncodeChars

You can indicate if would encode the control ASCII chars (less than 32) or the extended ASCII codes (greather than 127)

#### unsafe

[FILTER_UNSAFE_RAW](https://www.php.net/manual/es/filter.constants.php#constant.filter-unsafe-raw).+ FILTER_FLAG_EMPTY_STRING_NULL

#### safe

[FILTER_SANITIZE_SPECIAL_CHARS](https://www.php.net/manual/es/filter.constants.php#constant.filter-sanitize-special-chars). + FILTER_FLAG_EMPTY_STRING_NULL

#### urlEncode

[FILTER_SANITIZE_ENCODED](https://www.php.net/manual/es/filter.constants.php#constant.filter-sanitize-encoded). + FILTER_FLAG_EMPTY_STRING_NULL

#### hmtlEncode

[FILTER_SANITIZE_SPECIAL_CHARS](https://www.php.net/manual/es/filter.constants.php#constant.filter-sanitize-special-chars). + FILTER_FLAG_EMPTY_STRING_NULL + FILTER_FLAG_ENCODE_AMP

```php
$sanitizator= (new StringSanitizers())->stripTags()->htmlSpecialChars();
echo $sanitizator("<div>Camión&\r\n</div>"); //"Cami&oacute;n&amp;\r\n"
```

### Numbers

Can extract and parse from an origin, the numeric part, extracting the integer or float contained, removing (or not) the thousand separators.
Into code, the colon is a parameters separator, for this reason, by default, we don't preserve it, but you can preserve thousand separator pasing TRUE.

### Floats

[FILTER_SANITIZE_NUMBER_FLOAT](https://www.php.net/manual/es/filter.constants.php#constant.filter-sanitize-number-float). + FILTER_FLAG_ALLOW_THOUSAND

```php
$sanitizer = (new NumberSanitizers())->float($with_thousand_separator = false);
echo $sanitizer('2,000.22€'); //2000.22
```

### Integers

[FILTER_SANITIZE_NUMBER_INT](https://www.php.net/manual/es/filter.constants.php#constant.filter-sanitize-number-int). + FILTER_FLAG_ALLOW_THOUSAND

```php
$sanitizer = (new NumberSanitizers())->integer($with_thousand_separator = false);
echo $sanitizer('Z123456789N'); //123456789
```

> For integer sanitization, the FILTER_FLAG_ALLOW_FRACTION is not used, allways perform a number_format with 0 fraction for remove the decimals,
> taken only the integer part, not just removing dot

```php
$sanitizer = (new NumberSanitizers())->integer($with_thousand_separator = false);
echo $sanitizer('2,000.22€'); //2000
```
