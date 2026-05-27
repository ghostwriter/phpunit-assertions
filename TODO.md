# TODO

add `AssertionsTrait` classes for:

- [ ] AttributeAssertionsTrait
- [x] ClassAssertionsTrait;
- [ ] ConstantAssertionsTrait
- [ ] EnumAssertionsTrait;
- [ ] ExceptionAssertionsTrait
- [ ] FunctionAssertionsTrait;
- [ ] InterfaceAssertionsTrait;
- [ ] MethodAssertionsTrait
- [ ] PropertyAssertionsTrait
- [ ] TraitAssertionsTrait;

add `Constraint` classes with `assert{type}*` methods for:

- [ ] Attribute
- [ ] Class
- [ ] Constant
- [ ] Enum
- [ ] Exception
- [ ] Function
- [ ] Interface
- [ ] Method
- [ ] Property
- [ ] Trait

add `Is`, `IsNot`, `Has`, and `DoesNotHave` assertions with `Operator` constraints:

```php
BinaryOperator
LogicalAnd
LogicalNot
LogicalOr
LogicalXor
UnaryOperator
```


## Attribute assertions

```php
AttributeHasArgumentConstraint
AttributeHasNamedArgumentConstraint
AttributeHasTargetConstraint
AttributeIsRepeatedConstraint
AttributeTargetClassConstraint
AttributeTargetClassMethodConstraint
AttributeTargetClassPropertyConstraint
AttributeTargetClassConstantConstraint
AttributeTargetFunctionConstraint
AttributeTargetMethodConstraint
AttributeTargetPropertyConstraint
AttributeTargetParameterConstraint
AttributeTargetTraitConstraint
```

## Class assertions

```php

ClassDoesNotHaveMethodConstraint
ClassExtendsClassConstraint
ClassExtendsClassesConstraint
ClassHasMethodConstraint
ClassImplementsInterfaceConstraint
ClassImplementsInterfacesConstraint
ClassUsesTraitConstraint
ClassUsesTraitsConstraint
ClassHasAttributeConstraint
ClassHasConstantConstraint
ClassHasPropertyConstraint

ClassExtendsConstraint
ClassImplementsConstraint
ClassUsesTraitConstraint

ClassDoesNotExtendConstraint
ClassDoesNotImplementConstraint
ClassDoesNotUseTraitConstraint

ClassDoesNotHaveAttributeConstraint
ClassDoesNotHaveConstantConstraint
ClassDoesNotHaveMethodConstraint
ClassDoesNotHavePropertyConstraint

```

## Constant assertions

```php
ClassConstantEqualsConstraint

```

## Enum assertions

```php
EnumBackedValueEqualsConstraint
EnumHasCaseConstraint
```

## Method assertions

```php
ConstructorHasParameterConstraint
ConstructorParameterHasTypeConstraint
ConstructorParameterHasDefaultValueConstraint

MethodHasAttributeConstraint
MethodHasParameterConstraint
MethodIsPublicConstraint
MethodIsProtectedConstraint
MethodIsPrivateConstraint
MethodIsStaticConstraint
MethodIsFinalConstraint
MethodIsAbstractConstraint

MethodParameterHasTypeConstraint
MethodParameterHasDefaultValueConstraint
MethodParameterIsOptionalConstraint
MethodParameterIsVariadicConstraint
```

## Property assertions

```php
PropertyHasAttributeConstraint
PropertyHasTypeConstraint
PropertyIsPrivateConstraint
PropertyIsProtectedConstraint
PropertyIsPublicConstraint
PropertyIsReadonlyConstraint


```
