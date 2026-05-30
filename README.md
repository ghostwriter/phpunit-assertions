# PHPUnit Assertions

[![Automation](https://github.com/ghostwriter/phpunit-assertions/actions/workflows/automation.yml/badge.svg)](https://github.com/ghostwriter/phpunit-assertions/actions/workflows/automation.yml)
[![PHP Version](https://badgen.net/packagist/php/ghostwriter/phpunit-assertions?color=777BB4)](https://www.php.net/supported-versions)
[![Packagist Downloads](https://badgen.net/packagist/dt/ghostwriter/phpunit-assertions?color=F28D1A)](https://packagist.org/packages/ghostwriter/phpunit-assertions)
[![PayPal](https://img.shields.io/badge/paypal-@codepoet-0079C1?logo=paypal&logoColor=002991)](https://paypal.me/codepoet)
[![Sponsors via GitHub](https://img.shields.io/github/sponsors/ghostwriter?label=Sponsor+@ghostwriter/phpunit-assertions&logo=GitHub+Sponsors)](https://github.com/sponsors/ghostwriter)

Additional assertions for PHPUnit

## Installation

You can install the package via composer:

``` bash
composer require ghostwriter/phpunit-assertions --dev
```

### Star ⭐️ this repo if you find it useful

You can also star (🌟) this repo to find it easier later.

## Usage

```php
<?php

declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Ghostwriter\PHPUnitAssertions\Trait\ClassAssertionsTrait;

final class ExampleTest extends TestCase
{
    use ClassAssertionsTrait;

    public function testClassAssertions(): void
    {
        self::assertClassHasMethod('invoke', ExampleChild::class);
        self::assertClassDoesNotHaveMethod('missing', ExampleChild::class);
        self::assertClassExtendsClass(ExampleChild::class, ExampleBase::class);
        self::assertClassExtendsClasses(ExampleChild::class, [ExampleBase::class, ExampleRoot::class]);
        self::assertClassImplementsInterface(ExampleChild::class, ExampleInterface::class);
        self::assertClassImplementsInterfaces(ExampleChild::class, [ExampleInterface::class, ExampleExtraInterface::class]);
        self::assertClassUsesTrait(ExampleChild::class, ExampleTraitA::class);
        self::assertClassUsesTraits(ExampleChild::class, [ExampleTraitA::class, ExampleTraitB::class]);
    }
}

interface ExampleInterface {}
interface ExampleExtraInterface {}
interface ExampleCompositeInterface extends ExampleInterface, ExampleExtraInterface {}

trait ExampleTraitA {}
trait ExampleTraitB {}

class ExampleRoot {}

class ExampleBase extends ExampleRoot
{
    use ExampleTraitA;

    public function invoke(): void {}
}

class ExampleChild extends ExampleBase implements ExampleCompositeInterface
{
    use ExampleTraitB;
}
```

## Trait methods

### `ClassAssertionsTrait`

- `ClassAssertionsTrait::assertClassHasMethod`
- `ClassAssertionsTrait::assertClassDoesNotHaveMethod`
- `ClassAssertionsTrait::assertClassExtendsClass`
- `ClassAssertionsTrait::assertClassExtendsClasses`
- `ClassAssertionsTrait::assertClassImplementsInterface`
- `ClassAssertionsTrait::assertClassImplementsInterfaces`
- `ClassAssertionsTrait::assertClassUsesTrait`
- `ClassAssertionsTrait::assertClassUsesTraits`

### Credits

- [Nathanael Esayeas](https://github.com/ghostwriter)
- [Sebastian Bergmann](https://github.com/sebastianbergmann) creator of [PHPUnit](https://github.com/sebastianbergmann/phpunit)
- [All Contributors](https://github.com/ghostwriter/phpunit-assertions/contributors)

### Changelog

Please see [CHANGELOG.md](./CHANGELOG.md) for more information on what has changed recently.

### License

Please see [LICENSE](./LICENSE) for more information on the license that applies to this project.

### Security

Please see [SECURITY.md](./SECURITY.md) for more information on security disclosure process.
