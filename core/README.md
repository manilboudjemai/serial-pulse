# `Core\`

## `SingletonRegistry`

The `SingletonRegistry` class manages shared instances, enabling the reuse of a single class instance across scripts without enforcing the traditional constraints of the singleton pattern.

By utilizing `SingletonRegistry`, you ensure only one instantiation of a class is stored in shared memory, providing a centralized solution.

This centralized solution is particularly useful when employing the `SerialConnector` class for establishing a serial connection in the context of a single command through the CLI but needing to reuse the same connection instance for sending data in the context of a different command across distinct scripts.

### Usage

#### Registering an Instance

```php
// This method registers a single instance of the specified class in the registry.
SingletonRegistry::register(MyClass::class, $instance);
```

#### Retrieving an Instance

```php
// This method retrieves the stored instance for the specified class.
SingletonRegistry::get(MyClass::class);
```
