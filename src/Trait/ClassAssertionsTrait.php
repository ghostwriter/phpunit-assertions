<?php

declare(strict_types=1);

namespace Ghostwriter\PHPUnitAssertions\Trait;

use Ghostwriter\PHPUnitAssertions\Constraint\Class\ClassDoesNotHaveMethodConstraint;
use Ghostwriter\PHPUnitAssertions\Constraint\Class\ClassExtendsClassConstraint;
use Ghostwriter\PHPUnitAssertions\Constraint\Class\ClassExtendsClassesConstraint;
use Ghostwriter\PHPUnitAssertions\Constraint\Class\ClassHasMethodConstraint;
use Ghostwriter\PHPUnitAssertions\Constraint\Class\ClassImplementsInterfaceConstraint;
use Ghostwriter\PHPUnitAssertions\Constraint\Class\ClassImplementsInterfacesConstraint;
use Ghostwriter\PHPUnitAssertions\Constraint\Class\ClassUsesTraitConstraint;
use Ghostwriter\PHPUnitAssertions\Constraint\Class\ClassUsesTraitsConstraint;
use PHPUnit\Framework\Assert;

trait ClassAssertionsTrait
{
    /**
     * Asserts that the class does not have the specified method.
     *
     * @param string        $methodName the name of the method to check for
     * @param object|string $class      the class name or object to check
     * @param string        $message    optional message to display if the assertion fails
     */
    final public static function assertClassDoesNotHaveMethod(
        string $methodName,
        object|string $class,
        string $message = '',
    ): void {
        Assert::assertThat($class, new ClassDoesNotHaveMethodConstraint($methodName), $message);
    }

    /**
     * Asserts that the class extends the specified parent class.
     *
     * @param object|string $class       the class name or object to check
     * @param string        $parentClass the parent class the class should extend
     * @param string        $message     optional message to display if the assertion fails
     */
    final public static function assertClassExtendsClass(
        object|string $class,
        string $parentClass,
        string $message = '',
    ): void {
        Assert::assertThat($class, new ClassExtendsClassConstraint($parentClass), $message);
    }

    /**
     * Asserts that the class extends all specified parent classes.
     *
     * @param object|string $class         the class name or object to check
     * @param list<string>  $parentClasses the parent classes the class should extend
     * @param string        $message       optional message to display if the assertion fails
     */
    final public static function assertClassExtendsClasses(
        object|string $class,
        array $parentClasses,
        string $message = '',
    ): void {
        Assert::assertThat($class, new ClassExtendsClassesConstraint($parentClasses), $message);
    }

    /**
     * Asserts that the class has the specified method.
     *
     * @param string        $methodName the name of the method to check for
     * @param object|string $class      the class name or object to check
     * @param string        $message    optional message to display if the assertion fails
     */
    final public static function assertClassHasMethod(
        string $methodName,
        object|string $class,
        string $message = ''
    ): void {
        Assert::assertThat($class, new ClassHasMethodConstraint($methodName), $message);
    }

    /**
     * Asserts that the class implements the specified interface.
     *
     * @param object|string $class     the class name or object to check
     * @param string        $interface the interface the class should implement
     * @param string        $message   optional message to display if the assertion fails
     */
    final public static function assertClassImplementsInterface(
        object|string $class,
        string $interface,
        string $message = '',
    ): void {
        Assert::assertThat($class, new ClassImplementsInterfaceConstraint($interface), $message);
    }

    /**
     * Asserts that the class implements all specified interfaces.
     *
     * @param object|string $class      the class name or object to check
     * @param list<string>  $interfaces the interfaces the class should implement
     * @param string        $message    optional message to display if the assertion fails
     */
    final public static function assertClassImplementsInterfaces(
        object|string $class,
        array $interfaces,
        string $message = '',
    ): void {
        Assert::assertThat($class, new ClassImplementsInterfacesConstraint($interfaces), $message);
    }

    /**
     * Asserts that the class uses the specified trait.
     *
     * @param object|string $class   the class name or object to check
     * @param string        $trait   the trait the class should use
     * @param string        $message optional message to display if the assertion fails
     */
    final public static function assertClassUsesTrait(
        object|string $class,
        string $trait,
        string $message = '',
    ): void {
        Assert::assertThat($class, new ClassUsesTraitConstraint($trait), $message);
    }

    /**
     * Asserts that the class uses all specified traits.
     *
     * @param object|string $class   the class name or object to check
     * @param list<string>  $traits  the traits the class should use
     * @param string        $message optional message to display if the assertion fails
     */
    final public static function assertClassUsesTraits(
        object|string $class,
        array $traits,
        string $message = '',
    ): void {
        Assert::assertThat($class, new ClassUsesTraitsConstraint($traits), $message);
    }
}
