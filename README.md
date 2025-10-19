# Flaphl Precept 

**Precept** is a contract-driven Object-Relational Mapper (ORM) for PHP 8.2+, providing a powerful and flexible data persistence layer.

## Features

- **Entity Management** - Complete lifecycle with state tracking
- **Repository Pattern** - Type-safe repositories with query builders
- **Relationships** - OneToOne, ManyToOne, OneToMany, ManyToMany
- **Attribute Mapping** - PHP 8 attributes for entity configuration
- **Schema Management** - DDL operations and migrations
- **Transaction Support** - ACID-compliant transactions
- **Query Builder** - Fluent interface for complex queries
- **Event System** - Lifecycle events (PrePersist, PostLoad, etc.)
- **Cache Integration** - Query and metadata caching (PSR-6)
- **DI Integration** - Works with PSR-11 containers

## Installation

```bash
composer require flaphl/precept
```

## Quick Start

### Define an Entity

```php
use Flaphl\Fridge\Precept\Mapping as ORM;

#[ORM\Entity(table: 'users')]
class User
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'string', unique: true)]
    private string $email;

    #[ORM\OneToMany(targetEntity: Post::class, mappedBy: 'author')]
    private array $posts = [];
}
```

### Basic Operations

```php
// Create
$user = new User();
$user->setName('Jane Doe');
$user->setEmail('jane@example.com');
$entityManager->persist($user);
$entityManager->flush();

// Find
$user = $entityManager->find(User::class, 1);
$users = $entityManager->getRepository(User::class)->findAll();

// Update
$user->setName('Jane Smith');
$entityManager->flush();

// Delete
$entityManager->remove($user);
$entityManager->flush();
```

### Query Builder

```php
$users = $repository->createQueryBuilder('u')
    ->where('u.name LIKE :name')
    ->setParameter('name', 'Jane%')
    ->orderBy('u.createdAt', 'DESC')
    ->setMaxResults(10)
    ->getResult();
```

### Relationships

```php
// ManyToOne
#[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'posts')]
#[ORM\JoinColumn(name: 'author_id', referencedColumnName: 'id')]
private User $author;

// OneToMany
#[ORM\OneToMany(targetEntity: Post::class, mappedBy: 'author')]
private array $posts = [];
```

### Transactions

```php
$entityManager->transactional(function($em) use ($user) {
    $em->persist($user);
    $em->flush();
});
```

## Architecture

Precept follows Flaphl's contract-first design:

- **64 interfaces** defining all ORM functionality
- **PSR compliance** - PSR-6 (Cache), PSR-11 (Container), PSR-14 (Events)
- **Type-safe** - Full PHP 8.2+ type declarations with generics
- **Event-driven** - 11 lifecycle events for entity operations
- **Modular** - Independent contracts with unified integration

## Testing

Precept includes comprehensive test coverage:

- **150 tests, 445 assertions, 100% passing**
- All interfaces, attributes, enums, and traits tested
- Stress-tested before release

## Requirements

- PHP 8.2 or higher
- psr/event-dispatcher ^1.0
- psr/cache ^3.0
- psr/container ^2.0

## License

MIT License - see LICENSE file for details

## About Flaphl

Precept is part of the Flaphl framework, designed for evolution over revolution with:
- Contract-first design
- PSR standard compliance
- Graceful deprecation handling
- Comprehensive tooling support

For detailed documentation, see [CHANGELOG.md](CHANGELOG.md).
