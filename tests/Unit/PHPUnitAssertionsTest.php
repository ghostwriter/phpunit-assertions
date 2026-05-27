<?php

declare(strict_types=1);

namespace Tests\Unit;

use Ghostwriter\PHPUnitAssertions\Constraint\Class\ClassDoesNotHaveMethodConstraint;
use Ghostwriter\PHPUnitAssertions\Constraint\Class\ClassExtendsClassConstraint;
use Ghostwriter\PHPUnitAssertions\Constraint\Class\ClassExtendsClassesConstraint;
use Ghostwriter\PHPUnitAssertions\Constraint\Class\ClassHasMethodConstraint;
use Ghostwriter\PHPUnitAssertions\Constraint\Class\ClassImplementsInterfaceConstraint;
use Ghostwriter\PHPUnitAssertions\Constraint\Class\ClassImplementsInterfacesConstraint;
use Ghostwriter\PHPUnitAssertions\Constraint\Class\ClassUsesTraitConstraint;
use Ghostwriter\PHPUnitAssertions\Constraint\Class\ClassUsesTraitsConstraint;
use Ghostwriter\PHPUnitAssertions\Trait\ClassAssertionsTrait;
use PHPUnit\Framework\Attributes\CoversTrait;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\ExpectationFailedException;
use Tests\Fixture\Class\ClassAssertionsTraitBase;
use Tests\Fixture\Class\ClassAssertionsTraitChild;
use Tests\Fixture\Class\ClassAssertionsTraitPeer;
use Tests\Fixture\Class\ClassAssertionsTraitProxy;
use Tests\Fixture\Class\ClassAssertionsTraitRoot;
use Tests\Fixture\Interface\ClassAssertionsTraitContract;
use Tests\Fixture\Interface\ClassAssertionsTraitExtraContract;
use Tests\Fixture\Trait\ClassAssertionsTraitA;
use Tests\Fixture\Trait\ClassAssertionsTraitB;

#[CoversTrait(ClassAssertionsTrait::class)]
#[UsesClass(ClassExtendsClassConstraint::class)]
#[UsesClass(ClassExtendsClassesConstraint::class)]
#[UsesClass(ClassHasMethodConstraint::class)]
#[UsesClass(ClassImplementsInterfaceConstraint::class)]
#[UsesClass(ClassImplementsInterfacesConstraint::class)]
#[UsesClass(ClassDoesNotHaveMethodConstraint::class)]
#[UsesClass(ClassUsesTraitConstraint::class)]
#[UsesClass(ClassUsesTraitsConstraint::class)]
final class PHPUnitAssertionsTest extends AbstractTestCase
{
    public function testAssertClassDoesNotHaveMethod(): void
    {
        ClassAssertionsTraitProxy::assertClassDoesNotHaveMethod('missing', ClassAssertionsTraitChild::class);
    }

    public function testAssertClassExtendsClass(): void
    {
        ClassAssertionsTraitProxy::assertClassExtendsClass(
            ClassAssertionsTraitChild::class,
            ClassAssertionsTraitBase::class
        );
    }

    public function testAssertClassExtendsClassFailure(): void
    {
        $this->expectException(ExpectationFailedException::class);

        ClassAssertionsTraitProxy::assertClassExtendsClass(
            ClassAssertionsTraitPeer::class,
            ClassAssertionsTraitBase::class
        );
    }

    public function testAssertClassExtendsClasses(): void
    {
        ClassAssertionsTraitProxy::assertClassExtendsClasses(ClassAssertionsTraitChild::class, [
            ClassAssertionsTraitBase::class,
            ClassAssertionsTraitRoot::class,
        ]);
    }

    public function testAssertClassHasMethod(): void
    {
        ClassAssertionsTraitProxy::assertClassHasMethod('invoke', ClassAssertionsTraitChild::class);
    }

    public function testAssertClassImplementsInterface(): void
    {
        ClassAssertionsTraitProxy::assertClassImplementsInterface(
            ClassAssertionsTraitChild::class,
            ClassAssertionsTraitContract::class
        );
    }

    public function testAssertClassImplementsInterfaceFailure(): void
    {
        $this->expectException(ExpectationFailedException::class);

        ClassAssertionsTraitProxy::assertClassImplementsInterface(
            ClassAssertionsTraitPeer::class,
            ClassAssertionsTraitContract::class
        );
    }

    public function testAssertClassImplementsInterfaces(): void
    {
        ClassAssertionsTraitProxy::assertClassImplementsInterfaces(ClassAssertionsTraitChild::class, [
            ClassAssertionsTraitContract::class,
            ClassAssertionsTraitExtraContract::class,
        ]);
    }

    public function testAssertClassUsesTrait(): void
    {
        ClassAssertionsTraitProxy::assertClassUsesTrait(ClassAssertionsTraitChild::class, ClassAssertionsTraitA::class);
    }

    public function testAssertClassUsesTraitFailure(): void
    {
        $this->expectException(ExpectationFailedException::class);

        ClassAssertionsTraitProxy::assertClassUsesTrait(ClassAssertionsTraitPeer::class, ClassAssertionsTraitB::class);
    }

    public function testAssertClassUsesTraits(): void
    {
        ClassAssertionsTraitProxy::assertClassUsesTraits(ClassAssertionsTraitChild::class, [
            ClassAssertionsTraitA::class,
            ClassAssertionsTraitB::class,
        ]);
    }
}
