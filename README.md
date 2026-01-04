# DataManipulation

## Description

Little methods collection in order to manipulate variables contents. Group of some features in order to clean, modify, convert, apply math operations and some other actions

## Install

```bash
composer require juanchosl/datamanipulation
```

## Manipulators

### Strings

Perform actions over strings, using multibyte functions where are available, and returns a new StringManipulator object in order to mantain inmutability over previous entities

| Manipulation          | MultiByte | Description |
| --------------------- |:---------:| -------- |
| substring             |     X     | Extract a part of a string, starting from indicated char and with the desired lenght         |
| repeat                |          | Repeat the string n times         |
| format                |          | Apply format, with indicated values, to the string         |
| replace               |          | Search and replace a substring, can be case sensitive or not         |
| reverse               |          | Apply a reverse to the string         |
| toUpperFirst          |     X      | To upper the first char of the string         |
| toLowerFirst          |     X      |  To lower the first char of the string        |
| toUpperWords          |          | To upper the first char of every word into the string, can be indicated the char separator, not only spaces         |
| toUpper               |     X      | To upper all the string         |
| toLower               |     X      | To lower all the string         |
| padding               |     X      | Fill the string to the desired lenght with the value, at the left, rigth or both        |
| preppend              |     X      | Concat a new value at the start of the string, can be indicated an union char, a space is used if not           |
| concatenation         |     X      | Concat a new value at the end of the string, can be indicated an union char, a space is used if not         |
| chunk                 |     X      | Convert to a multiline string with a fix lenght         |
| wordWrap              |          | Convert to a multiline string with a fix lenght, but safely for word, ensuring do not cut, applying from the previous space         |
| trim                  |     X      | Clean a string, removing spaces or control chars at the start or the end of the string          |
| ltrim                 |     X      | Clean a string, removing spaces or control chars at the start of the string          |
| rtrim                 |     X      | Clean a string, removing spaces or control chars at the end of the string         |
| eol                   |     X      | Convert breaklines chars (\r,\n,\r\n) to the desired new char, in order to ensure the use of PHP_EOL constant for unknow origins        |
| shuffle               |          | Apply a random shuffle          |
| rotate13              |          | Apply a rot13 transformation        |
| md5                   |          | Calculate the md5         |
| quotedPrintableEncode |          | Convert form 8bits string to QP string, following the rules from RFC2045         |
| quotedPrintableDecode |          | Convert to 8bits string from QP string, following the rules from RFC2045         |
| uuEncode              |          | Encode the string using the uuencode algorithm         |
| uuDecode              |          | Decode a uuencoded string        |
| urlEncode             |          | Encode the string using the rawurlencode algorithm, following the rules from RFC3986         |
| urlDecode             |          | Decode a rawurlencoded string, following the rules from RFC3986        |
| base64Encode          |          | Encode to Base 64         |
| base64Decode          |          | Decode from Base 64         |
| binToHex              |          | Convert the binary string to hexadecimal equivalent         |
| hexToBin              |          | Convert the hexadecimal string to binary data         |

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
