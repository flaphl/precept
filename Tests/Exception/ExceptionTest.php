<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Tests\Exception;

use Flaphl\Fridge\Precept\Exception\PreceptException;
use Flaphl\Fridge\Precept\Exception\EntityNotFoundException;
use Flaphl\Fridge\Precept\Exception\MappingException;
use Flaphl\Fridge\Precept\Exception\QueryException;
use Flaphl\Fridge\Precept\Exception\HydrationException;
use Flaphl\Fridge\Precept\Exception\TransactionException;
use Flaphl\Fridge\Precept\Exception\CacheException;
use Flaphl\Fridge\Precept\Exception\MigrationException;
use PHPUnit\Framework\TestCase;

class ExceptionTest extends TestCase
{
    public function testPreceptExceptionIsRuntimeException(): void
    {
        $exception = new PreceptException('test message');
        
        $this->assertInstanceOf(\RuntimeException::class, $exception);
        $this->assertSame('test message', $exception->getMessage());
    }

    public function testEntityNotFoundFromIdentifier(): void
    {
        $exception = EntityNotFoundException::fromIdentifier('App\\Entity\\User', 123);
        
        $this->assertInstanceOf(PreceptException::class, $exception);
        $this->assertStringContainsString('App\\Entity\\User', $exception->getMessage());
        $this->assertStringContainsString('123', $exception->getMessage());
        $this->assertStringContainsString('not found', $exception->getMessage());
    }

    public function testEntityNotFoundFromCriteria(): void
    {
        $exception = EntityNotFoundException::fromCriteria('App\\Entity\\User', ['email' => 'test@example.com']);
        
        $this->assertInstanceOf(PreceptException::class, $exception);
        $this->assertStringContainsString('App\\Entity\\User', $exception->getMessage());
        $this->assertStringContainsString('email', $exception->getMessage());
        $this->assertStringContainsString('not found', $exception->getMessage());
    }

    public function testMappingExceptionUnknownEntity(): void
    {
        $exception = MappingException::unknownEntity('App\\Entity\\Unknown');
        
        $this->assertInstanceOf(PreceptException::class, $exception);
        $this->assertStringContainsString('App\\Entity\\Unknown', $exception->getMessage());
        $this->assertStringContainsString('not recognized', $exception->getMessage());
    }

    public function testMappingExceptionMissingIdentifier(): void
    {
        $exception = MappingException::missingIdentifier('App\\Entity\\User');
        
        $this->assertInstanceOf(PreceptException::class, $exception);
        $this->assertStringContainsString('App\\Entity\\User', $exception->getMessage());
        $this->assertStringContainsString('no identifier', $exception->getMessage());
    }

    public function testMappingExceptionInvalidFieldMapping(): void
    {
        $exception = MappingException::invalidFieldMapping('App\\Entity\\User', 'email', 'Invalid type');
        
        $this->assertInstanceOf(PreceptException::class, $exception);
        $this->assertStringContainsString('email', $exception->getMessage());
        $this->assertStringContainsString('Invalid type', $exception->getMessage());
    }

    public function testQueryExceptionInvalidQuery(): void
    {
        $exception = QueryException::invalidQuery('Missing WHERE clause');
        
        $this->assertInstanceOf(PreceptException::class, $exception);
        $this->assertStringContainsString('Invalid query', $exception->getMessage());
        $this->assertStringContainsString('Missing WHERE clause', $exception->getMessage());
    }

    public function testQueryExceptionNonUniqueResult(): void
    {
        $exception = QueryException::nonUniqueResult(5);
        
        $this->assertInstanceOf(PreceptException::class, $exception);
        $this->assertStringContainsString('exactly one result', $exception->getMessage());
        $this->assertStringContainsString('5', $exception->getMessage());
    }

    public function testHydrationExceptionHydratingEntity(): void
    {
        $exception = HydrationException::hydratingEntity('App\\Entity\\User', 'Missing required field');
        
        $this->assertInstanceOf(PreceptException::class, $exception);
        $this->assertStringContainsString('App\\Entity\\User', $exception->getMessage());
        $this->assertStringContainsString('Missing required field', $exception->getMessage());
    }

    public function testHydrationExceptionUnknownMode(): void
    {
        $exception = HydrationException::unknownMode('INVALID_MODE');
        
        $this->assertInstanceOf(PreceptException::class, $exception);
        $this->assertStringContainsString('Unknown hydration mode', $exception->getMessage());
        $this->assertStringContainsString('INVALID_MODE', $exception->getMessage());
    }

    public function testTransactionExceptionNoActiveTransaction(): void
    {
        $exception = TransactionException::noActiveTransaction();
        
        $this->assertInstanceOf(PreceptException::class, $exception);
        $this->assertStringContainsString('No active transaction', $exception->getMessage());
    }

    public function testTransactionExceptionNestedNotSupported(): void
    {
        $exception = TransactionException::nestedNotSupported();
        
        $this->assertInstanceOf(PreceptException::class, $exception);
        $this->assertStringContainsString('Nested transactions', $exception->getMessage());
        $this->assertStringContainsString('not supported', $exception->getMessage());
    }

    public function testCacheExceptionImplementsPsrCacheException(): void
    {
        $exception = new CacheException('test');
        
        $this->assertInstanceOf(\Psr\Cache\CacheException::class, $exception);
        $this->assertInstanceOf(PreceptException::class, $exception);
    }

    public function testCacheExceptionInvalidationFailed(): void
    {
        $exception = CacheException::invalidationFailed('Backend unavailable');
        
        $this->assertInstanceOf(PreceptException::class, $exception);
        $this->assertStringContainsString('invalidation failed', $exception->getMessage());
        $this->assertStringContainsString('Backend unavailable', $exception->getMessage());
    }

    public function testMigrationExceptionNotFound(): void
    {
        $exception = MigrationException::notFound('2025_10_19_create_users_table');
        
        $this->assertInstanceOf(PreceptException::class, $exception);
        $this->assertStringContainsString('2025_10_19_create_users_table', $exception->getMessage());
        $this->assertStringContainsString('not found', $exception->getMessage());
    }

    public function testMigrationExceptionAlreadyExists(): void
    {
        $exception = MigrationException::alreadyExists('2025_10_19_create_users_table');
        
        $this->assertInstanceOf(PreceptException::class, $exception);
        $this->assertStringContainsString('2025_10_19_create_users_table', $exception->getMessage());
        $this->assertStringContainsString('already exists', $exception->getMessage());
    }

    public function testMigrationExceptionExecutionFailed(): void
    {
        $previous = new \RuntimeException('SQL error');
        $exception = MigrationException::executionFailed('create_users_table', $previous);
        
        $this->assertInstanceOf(PreceptException::class, $exception);
        $this->assertStringContainsString('create_users_table', $exception->getMessage());
        $this->assertStringContainsString('execution failed', $exception->getMessage());
        $this->assertSame($previous, $exception->getPrevious());
    }

    public function testMigrationExceptionRollbackFailed(): void
    {
        $previous = new \RuntimeException('SQL error');
        $exception = MigrationException::rollbackFailed('create_users_table', $previous);
        
        $this->assertInstanceOf(PreceptException::class, $exception);
        $this->assertStringContainsString('create_users_table', $exception->getMessage());
        $this->assertStringContainsString('rollback failed', $exception->getMessage());
        $this->assertSame($previous, $exception->getPrevious());
    }

    public function testMigrationExceptionInvalidFile(): void
    {
        $exception = MigrationException::invalidFile('/path/to/migration.php', 'Missing class');
        
        $this->assertInstanceOf(PreceptException::class, $exception);
        $this->assertStringContainsString('/path/to/migration.php', $exception->getMessage());
        $this->assertStringContainsString('Missing class', $exception->getMessage());
    }

    public function testMigrationExceptionRepositoryNotFound(): void
    {
        $exception = MigrationException::repositoryNotFound();
        
        $this->assertInstanceOf(PreceptException::class, $exception);
        $this->assertStringContainsString('repository does not exist', $exception->getMessage());
    }
}
