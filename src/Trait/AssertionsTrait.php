<?php

declare(strict_types=1);

namespace Ghostwriter\PHPUnitAssertions\Trait;

trait AssertionsTrait
{
    use AttributeAssertionsTrait;
    use ClassAssertionsTrait;
    use ConstantAssertionsTrait;
    use EnumAssertionsTrait;
    use FunctionAssertionsTrait;
    use InterfaceAssertionsTrait;
    use MethodAssertionsTrait;
    use PropertyAssertionsTrait;
    use TraitAssertionsTrait;
}
