<?php

declare(strict_types=1);

namespace Tests\Unit\Constraint\Class;

use Countable;
use Ghostwriter\PHPUnitAssertions\Constraint\Class\ClassExtendsClassConstraint;
use Ghostwriter\PHPUnitAssertions\Constraint\Class\ClassImplementsInterfaceConstraint;
use Ghostwriter\PHPUnitAssertions\Constraint\Class\ClassUsesTraitsConstraint;
use Ghostwriter\PHPUnitAssertions\Trait\ClassAssertionsTrait;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\UsesTrait;
use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\SelfDescribing;
use Tests\Fixture\Class\ClassUsesTraitsLeaf;
use Tests\Fixture\Class\ClassUsesTraitsPeer;
use Tests\Fixture\Trait\ClassUsesTraitsTraitA;
use Tests\Fixture\Trait\ClassUsesTraitsTraitB;
use Tests\Unit\AbstractTestCase;

use function sprintf;

#[CoversClass(ClassUsesTraitsConstraint::class)]
#[UsesClass(ClassExtendsClassConstraint::class)]
#[UsesClass(ClassImplementsInterfaceConstraint::class)]
#[UsesTrait(ClassAssertionsTrait::class)]
final class ClassUsesTraitsConstraintTest extends AbstractTestCase
{
    use ClassAssertionsTrait;

    public function testCustomFailureMessage(): void
    {
        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('custom uses-traits message');

        self::assertThat(
            ClassUsesTraitsPeer::class,
            new ClassUsesTraitsConstraint([ClassUsesTraitsTraitA::class, ClassUsesTraitsTraitB::class]),
            'custom uses-traits message',
        );
    }

    public function testDefaultFailureMessage(): void
    {
        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage(sprintf(
            'uses traits [%s, %s]',
            ClassUsesTraitsTraitA::class,
            ClassUsesTraitsTraitB::class,
        ));

        self::assertThat(
            ClassUsesTraitsPeer::class,
            new ClassUsesTraitsConstraint([ClassUsesTraitsTraitA::class, ClassUsesTraitsTraitB::class]),
        );
    }

    public function testExtendsConstraint(): void
    {
        self::assertClassExtendsClass(ClassUsesTraitsConstraint::class, Constraint::class);
    }

    public function testImplementsCountable(): void
    {
        self::assertClassImplementsInterface(ClassUsesTraitsConstraint::class, Countable::class);
    }

    public function testImplementsSelfDescribing(): void
    {
        self::assertClassImplementsInterface(ClassUsesTraitsConstraint::class, SelfDescribing::class);
    }

    public function testMatchesAllTraitsAcrossHierarchy(): void
    {
        $constraint = new ClassUsesTraitsConstraint([ClassUsesTraitsTraitA::class, ClassUsesTraitsTraitB::class]);

        self::assertTrue($constraint->evaluate(ClassUsesTraitsLeaf::class, '', true));
        self::assertFalse($constraint->evaluate(ClassUsesTraitsPeer::class, '', true));
    }

    public function testMatchesObjectInput(): void
    {
        $constraint = new ClassUsesTraitsConstraint([ClassUsesTraitsTraitA::class, ClassUsesTraitsTraitB::class]);

        self::assertTrue($constraint->evaluate(new ClassUsesTraitsLeaf(), '', true));
    }

    public function testReturnsFalseWhenClassStringCannotBeReflectedByClassUses(): void
    {
        $constraint = new ClassUsesTraitsConstraint([ClassUsesTraitsTraitA::class, ClassUsesTraitsTraitB::class]);

        self::assertFalse($constraint->evaluate('Tests\\Fixture\\Class\\MissingUsesTraitsTarget', '', true));
    }

    public function testReturnsFalseWhenInputIsNotClassStringOrObject(): void
    {
        $constraint = new ClassUsesTraitsConstraint([ClassUsesTraitsTraitA::class, ClassUsesTraitsTraitB::class]);

        self::assertFalse($constraint->evaluate(123, '', true));
    }
}
