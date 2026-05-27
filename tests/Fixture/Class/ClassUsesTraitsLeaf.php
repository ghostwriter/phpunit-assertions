<?php

declare(strict_types=1);

namespace Tests\Fixture\Class;

use Tests\Fixture\Trait\ClassUsesTraitsTraitB;

class ClassUsesTraitsLeaf extends ClassUsesTraitsBase
{
    use ClassUsesTraitsTraitB;
}
