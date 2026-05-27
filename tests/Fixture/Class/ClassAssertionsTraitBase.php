<?php

declare(strict_types=1);

namespace Tests\Fixture\Class;

use Tests\Fixture\Trait\ClassAssertionsTraitA;

class ClassAssertionsTraitBase extends ClassAssertionsTraitRoot
{
    use ClassAssertionsTraitA;

    public function invoke(): void {}
}
