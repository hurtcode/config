# Config

----

This is a library designed to create configurations for various systems. It provides a basic interface and a unit of
work for this. The configuration is an array of static, predefined parameters

**Begin work**

```php

// first: create configurator unit of work
$configurator = new Configurator(
    ConfigInterface::class, // your config realization
    CompilerInterface::class, // your compiler realization
    CacheItemPoolInterface::class // your cache realization
);

$configs = $configurator->run(); // start configuration building

```

---

### Configurator

This is unit, that do all job to create configurations. It depends on two interfaces:
`ConfigInterface` and `CompilerInterface`. Configurator compiles configs only once time and after takes it from cache.

### ConfigInterface

This interface is responsible for locating the configuration directory, and the input configuration file. Its main
purpose to show where and what *compiler* need to get

### CompilerInterface

This interface is responsible for compiling configuration. It takes main config file string content and parses in array
of keys and value. This order of things allows you to use any format as configuration files (json,yaml,xml etc.).

---
**Suggest work flow**

- ConfigInterface gives file content string
- CompilerInterface parses it using specific rules
- Configurator rules them all and caches result.

