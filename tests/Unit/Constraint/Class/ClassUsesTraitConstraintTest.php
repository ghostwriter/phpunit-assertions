<?php

declare(strict_types=1);

namespace Tests\Unit\Constraint\Class;

use Countable;
use Ghostwriter\PHPUnitAssertions\Constraint\Class\ClassExtendsClassConstraint;
use Ghostwriter\PHPUnitAssertions\Constraint\Class\ClassImplementsInterfaceConstraint;
use Ghostwriter\PHPUnitAssertions\Constraint\Class\ClassUsesTraitConstraint;
use Ghostwriter\PHPUnitAssertions\Trait\ClassAssertionsTrait;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\UsesTrait;
use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\SelfDescribing;
use Tests\Fixture\Class\ClassUsesTraitLeaf;
use Tests\Fixture\Class\ClassUsesTraitPeer;
use Tests\Fixture\Trait\ClassUsesTraitTraitA;
use Tests\Unit\AbstractTestCase;

use function sprintf;

#[CoversClass(ClassUsesTraitConstraint::class)]
#[UsesClass(ClassExtendsClassConstraint::class)]
#[UsesClass(ClassImplementsInterfaceConstraint::class)]
#[UsesTrait(ClassAssertionsTrait::class)]
final class ClassUsesTraitConstraintTest extends AbstractTestCase
{
    use ClassAssertionsTrait;

    public function testCustomFailureMessage(): void
    {
        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('custom uses-trait message');

        self::assertThat(
            ClassUsesTraitPeer::class,
            new ClassUsesTraitConstraint(ClassUsesTraitTraitA::class),
            'custom uses-trait message',
        );
    }

    public function testDefaultFailureMessage(): void
    {
        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage(sprintf("uses trait '%s'", ClassUsesTraitTraitA::class));

        self::assertThat(ClassUsesTraitPeer::class, new ClassUsesTraitConstraint(ClassUsesTraitTraitA::class));
    }

    public function testExtendsConstraint(): void
    {
        self::assertClassExtendsClass(ClassUsesTraitConstraint::class, Constraint::class);
    }

    public function testImplementsCountable(): void
    {
        self::assertClassImplementsInterface(ClassUsesTraitConstraint::class, Countable::class);
    }

    public function testImplementsSelfDescribing(): void
    {
        self::assertClassImplementsInterface(ClassUsesTraitConstraint::class, SelfDescribing::class);
    }

    public function testMatchesObjectInput(): void
    {
        $constraint = new ClassUsesTraitConstraint(ClassUsesTraitTraitA::class);

        self::assertTrue($constraint->evaluate(new ClassUsesTraitLeaf(), '', true));
    }

    public function testMatchesTraitOnClassOrAncestor(): void
    {
        $constraint = new ClassUsesTraitConstraint(ClassUsesTraitTraitA::class);

        self::assertTrue($constraint->evaluate(ClassUsesTraitLeaf::class, '', true));
        self::assertFalse($constraint->evaluate(ClassUsesTraitPeer::class, '', true));
    }

    public function testReturnsFalseWhenClassStringCannotBeReflectedByClassUses(): void
    {
        $constraint = new ClassUsesTraitConstraint(ClassUsesTraitTraitA::class);

        self::assertFalse($constraint->evaluate('Tests\\Fixture\\Class\\MissingUsesTraitTarget', '', true));
    }

    public function testReturnsFalseWhenInputIsNotClassStringOrObject(): void
    {
        $constraint = new ClassUsesTraitConstraint(ClassUsesTraitTraitA::class);

        self::assertFalse($constraint->evaluate(123, '', true));
    }
}
