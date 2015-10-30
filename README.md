## Create project

`composer init`

kellyj/tddexample

Create `src` and `tests` directories.

Setup [PSR-4](http://www.php-fig.org/psr/psr-4/) autoloading

```json
"autoload": {
    "psr-4": {
        "Tdd\\": "src"
    }
},
"autoload-dev": {
    "psr-4": {
        "Tdd\\Test\\": "tests"
    }
},
```

Create `phpunit.xml` file

```xml
<?xml version="1.0" encoding="UTF-8"?>
<phpunit bootstrap="vendor/autoload.php"
         backupGlobals="false"
         backupStaticAttributes="false"
         colors="true"
         verbose="true"
         convertErrorsToExceptions="true"
         convertNoticesToExceptions="true"
         convertWarningsToExceptions="true"
         processIsolation="false"
         stopOnFailure="false">
    <testsuites>
        <testsuite name="Wrapper Test Suite">
            <directory>tests</directory>
        </testsuite>
    </testsuites>
    <filter>
        <whitelist>
            <directory suffix=".php">src/</directory>
        </whitelist>
    </filter>
</phpunit>
```

## Require PHPUnit

`$ composer require --dev phpunit/phpunit`

composer.json:

```json
"require-dev": {
	"phpunit/phpunit": "^4.8"
}
```

## Create first test

tests/Text/WrapperText.php

```php
public function testCanCreateAWrapper()
{
    $wrapper = new Wrapper();
    $this->assertInstanceOf('\\Tdd\\Text\\Wrapper', $wrapper);
}
```

## Additional Tests

### Simplest

What's the simplest?

What happens when I give it a blank string

```php
public function testItShouldWrapAnEmptyString()
{
    $wrapper = new Wrapper();
    $this->assertEquals('', $wrapper->wrap(''));
}
```

### Shorter string

What's the next simplest?

What happens when I give it a string shorter than max chars?

```php
public function testItDoesNotWrapAShortEnoughWord()
{
    $wrapper = new Wrapper();
    $this->assertEquals('word', $wrapper->wrap('word', 5));
}
```

Wrapper.php

`return $text;`

### Refactor

Move up `$wrapper` to setUp

Define variables for "magic" strings and integer. (Option+Command+V)

### Long word

Now for failing a long word test

```php
public function testItWrapsAWordLongerThanLineLength()
{
    $textToBeParsed = 'alongword';
    $maxLineLength = 5;
    $this->assertEquals("along\nword", $this->wrapper->wrap($textToBeParsed, $maxLineLength));
}
```

Add to Wrapper.php

```php
if (strlen($text) > $lineLength) {
    return substr($text, 0, $lineLength) . "\n" . substr($text, $lineLength);
}
```

Fix failing test

### Very long word

```php
public function testITWrapsAWordSeveralTimesIfItsTooLong()
{
    $textToBeParsed = 'averyverylongword';
    $maxLineLength = 5;
    $this->assertEquals("avery\nveryl\nongwo\nrd", $this->wrapper->wrap($textToBeParsed, $maxLineLength));
}
```

Can you smell the while loop?

```php
return substr($text, 0, $lineLength) . "\n" . $this->wrap(substr($text, $lineLength), $lineLength);
```

### Two words

```php
public function testItWrapsTwoWordsWhenSpaceAtTheEndOfLine()
{
    $textToBeParsed = 'word word';
    $maxLineLength = 5;
    $this->assertEquals("word\nword", $this->wrapper->wrap($textToBeParsed, $maxLineLength));
}

```php
return trim(substr($text, 0, $lineLength)) . "\n" . $this->wrap(substr($text, $lineLength), $lineLength);
```

```php
if (strlen($text) > $lineLength) {
    if (strpos(substr($text, 0, $lineLength), ' ') != 0) {
        return substr($text, 0, strpos($text, ' ')) . "\n" . $this->wrap(substr($text, strpos($text, ' ') + 1), $lineLength);
    }

    return substr($text, 0, $lineLength) . "\n" . $this->wrap(substr($text, $lineLength), $lineLength);
}

return $text;
```

Refactor, early return

```php
if (strlen($text) <= $lineLength) {
    return $text;
}
```

### Three words on Three lines

Should you write a test when you know it will pass?  If you have doubts, yes.  Also, tests are documentation.

### Three words on Two lines

```php
public function testItWraps3WordsOn2Lines()
{
    $textToBeParsed = 'word word word';
    $maxLineLength = 12;
    $this->assertEquals("word word\nword", $this->wrapper->wrap($textToBeParsed, $maxLineLength));
}
```

change `strpos` to `strrpos`

### It's getting harder

It's getting harder to find failing tests.  Good indication we're close to done.

### Two words at Boundry

```php
public function testItWraps2WordsAtBoundry()
{
    $textToBeParsed = 'word word';
    $maxLineLength = 4;
    $this->assertEquals("word\nword", $this->wrapper->wrap($textToBeParsed, $maxLineLength));
}
```

Add `trim()`
