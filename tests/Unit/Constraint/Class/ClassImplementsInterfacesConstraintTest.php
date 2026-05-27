<?php

declare(strict_types=1);

namespace Tests\Unit\Constraint\Class;

use Countable;
use Ghostwriter\PHPUnitAssertions\Constraint\Class\ClassExtendsClassConstraint;
use Ghostwriter\PHPUnitAssertions\Constraint\Class\ClassImplementsInterfaceConstraint;
use Ghostwriter\PHPUnitAssertions\Constraint\Class\ClassImplementsInterfacesConstraint;
use Ghostwriter\PHPUnitAssertions\Trait\ClassAssertionsTrait;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\UsesTrait;
use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\SelfDescribing;
use Tests\Fixture\Class\ClassImplementsInterfacesImplementation;
use Tests\Fixture\Class\ClassImplementsInterfacesPartialImplementation;
use Tests\Fixture\Interface\ClassImplementsInterfacesContractA;
use Tests\Fixture\Interface\ClassImplementsInterfacesContractB;
use Tests\Unit\AbstractTestCase;

use function sprintf;

#[CoversClass(ClassImplementsInterfacesConstraint::class)]
#[UsesClass(ClassExtendsClassConstraint::class)]
#[UsesClass(ClassImplementsInterfaceConstraint::class)]
#[UsesTrait(ClassAssertionsTrait::class)]
final class ClassImplementsInterfacesConstraintTest extends AbstractTestCase
{
    use ClassAssertionsTrait;

    public function testCustomFailureMessage(): void
    {
        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('custom implements-interfaces message');

        self::assertThat(
            ClassImplementsInterfacesPartialImplementation::class,
            new ClassImplementsInterfacesConstraint([
                ClassImplementsInterfacesContractA::class,
                ClassImplementsInterfacesContractB::class,
            ]),
            'custom implements-interfaces message',
        );
    }

    public function testDefaultFailureMessage(): void
    {
        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage(sprintf(
            'implements interfaces [%s, %s]',
            ClassImplementsInterfacesContractA::class,
            ClassImplementsInterfacesContractB::class,
        ));

        self::assertThat(
            ClassImplementsInterfacesPartialImplementation::class,
            new ClassImplementsInterfacesConstraint([
                ClassImplementsInterfacesContractA::class,
                ClassImplementsInterfacesContractB::class,
            ]),
        );
    }

    public function testExtendsConstraint(): void
    {
        self::assertClassExtendsClass(ClassImplementsInterfacesConstraint::class, Constraint::class);
    }

    public function testImplementsCountable(): void
    {
        self::assertClassImplementsInterface(ClassImplementsInterfacesConstraint::class, Countable::class);
    }

    public function testImplementsSelfDescribing(): void
    {
        self::assertClassImplementsInterface(ClassImplementsInterfacesConstraint::class, SelfDescribing::class);
    }

    public function testMatchesAllInterfaces(): void
    {
        $constraint = new ClassImplementsInterfacesConstraint([
            ClassImplementsInterfacesContractA::class,
            ClassImplementsInterfacesContractB::class,
        ]);

        self::assertTrue($constraint->evaluate(ClassImplementsInterfacesImplementation::class, '', true));
        self::assertFalse($constraint->evaluate(ClassImplementsInterfacesPartialImplementation::class, '', true));
    }

    public function testMatchesObjectInput(): void
    {
        $constraint = new ClassImplementsInterfacesConstraint([
            ClassImplementsInterfacesContractA::class,
            ClassImplementsInterfacesContractB::class,
        ]);

        self::assertTrue($constraint->evaluate(new ClassImplementsInterfacesImplementation(), '', true));
    }

    public function testReturnsFalseWhenClassStringCannotBeReflectedByClassImplements(): void
    {
        $constraint = new ClassImplementsInterfacesConstraint([
            ClassImplementsInterfacesContractA::class,
            ClassImplementsInterfacesContractB::class,
        ]);

        self::assertFalse($constraint->evaluate('Tests\\Fixture\\Class\\MissingImplementsInterfacesTarget', '', true));
    }

    public function testReturnsFalseWhenInputIsNotClassStringOrObject(): void
    {
        $constraint = new ClassImplementsInterfacesConstraint([
            ClassImplementsInterfacesContractA::class,
            ClassImplementsInterfacesContractB::class,
        ]);

        self::assertFalse($constraint->evaluate(123, '', true));
    }
}
