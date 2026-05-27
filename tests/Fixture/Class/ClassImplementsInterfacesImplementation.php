<?php

declare(strict_types=1);

namespace Tests\Fixture\Class;

use Tests\Fixture\Interface\ClassImplementsInterfacesContractA;
use Tests\Fixture\Interface\ClassImplementsInterfacesContractB;

class ClassImplementsInterfacesImplementation implements ClassImplementsInterfacesContractA, ClassImplementsInterfacesContractB {}
