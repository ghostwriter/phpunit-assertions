<?php

declare(strict_types=1);

namespace Tests\Fixture\Class;

use Tests\Fixture\Interface\ClassAssertionsTraitCompositeContract;
use Tests\Fixture\Trait\ClassAssertionsTraitB;

class ClassAssertionsTraitChild extends ClassAssertionsTraitBase implements ClassAssertionsTraitCompositeContract
{
    use ClassAssertionsTraitB;
}
