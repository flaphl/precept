<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Tests\Migrator;

use Flaphl\Fridge\Precept\Migrator\MigrationInterface;
use Flaphl\Fridge\Precept\Migrator\MigratorInterface;
use Flaphl\Fridge\Precept\Migrator\MigrationRepositoryInterface;
use Flaphl\Fridge\Precept\Migrator\MigrationGeneratorInterface;
use Flaphl\Fridge\Precept\Migrator\MigrationResolverInterface;
use Flaphl\Fridge\Precept\Migrator\MigrationCreatorInterface;
use Flaphl\Fridge\Precept\Migrator\MigrationStatus;
use PHPUnit\Framework\TestCase;

class MigrationInterfaceTest extends TestCase
{
    public function testMigrationInterfaceHasRequiredMethods(): void
    {
        $reflection = new \ReflectionClass(MigrationInterface::class);
        
        $this->assertTrue($reflection->hasMethod('getName'));
        $this->assertTrue($reflection->hasMethod('getDescription'));
        $this->assertTrue($reflection->hasMethod('up'));
        $this->assertTrue($reflection->hasMethod('down'));
        $this->assertTrue($reflection->hasMethod('isTransactional'));
    }

    public function testMigratorInterfaceHasExecutionMethods(): void
    {
        $reflection = new \ReflectionClass(MigratorInterface::class);
        
        $this->assertTrue($reflection->hasMethod('run'));
        $this->assertTrue($reflection->hasMethod('rollback'));
        $this->assertTrue($reflection->hasMethod('reset'));
    }

    public function testMigratorInterfaceHasBatchMethods(): void
    {
        $reflection = new \ReflectionClass(MigratorInterface::class);
        
        $this->assertTrue($reflection->hasMethod('getNextBatchNumber'));
        $this->assertTrue($reflection->hasMethod('getLastBatch'));
    }

    public function testMigratorInterfaceHasQueryMethods(): void
    {
        $reflection = new \ReflectionClass(MigratorInterface::class);
        
        $this->assertTrue($reflection->hasMethod('getPendingMigrations'));
        $this->assertTrue($reflection->hasMethod('getRanMigrations'));
    }

    public function testMigratorInterfaceHasConnectionMethods(): void
    {
        $reflection = new \ReflectionClass(MigratorInterface::class);
        
        $this->assertTrue($reflection->hasMethod('getConnection'));
        $this->assertTrue($reflection->hasMethod('setConnection'));
    }

    public function testMigrationRepositoryInterfaceHasTrackingMethods(): void
    {
        $reflection = new \ReflectionClass(MigrationRepositoryInterface::class);
        
        $this->assertTrue($reflection->hasMethod('getRan'));
        $this->assertTrue($reflection->hasMethod('getMigrations'));
        $this->assertTrue($reflection->hasMethod('getLast'));
        $this->assertTrue($reflection->hasMethod('getMigrationsByBatch'));
    }

    public function testMigrationRepositoryInterfaceHasLogMethods(): void
    {
        $reflection = new \ReflectionClass(MigrationRepositoryInterface::class);
        
        $this->assertTrue($reflection->hasMethod('log'));
        $this->assertTrue($reflection->hasMethod('delete'));
    }

    public function testMigrationRepositoryInterfaceHasBatchMethods(): void
    {
        $reflection = new \ReflectionClass(MigrationRepositoryInterface::class);
        
        $this->assertTrue($reflection->hasMethod('getNextBatchNumber'));
        $this->assertTrue($reflection->hasMethod('getLastBatchNumber'));
    }

    public function testMigrationRepositoryInterfaceHasSetupMethods(): void
    {
        $reflection = new \ReflectionClass(MigrationRepositoryInterface::class);
        
        $this->assertTrue($reflection->hasMethod('createRepository'));
        $this->assertTrue($reflection->hasMethod('repositoryExists'));
        $this->assertTrue($reflection->hasMethod('deleteRepository'));
    }

    public function testMigrationGeneratorInterfaceHasGenerationMethods(): void
    {
        $reflection = new \ReflectionClass(MigrationGeneratorInterface::class);
        
        $this->assertTrue($reflection->hasMethod('generateFromEntities'));
        $this->assertTrue($reflection->hasMethod('generateFromDiff'));
        $this->assertTrue($reflection->hasMethod('generateBlank'));
        $this->assertTrue($reflection->hasMethod('generateContent'));
    }

    public function testMigrationGeneratorInterfaceHasConfigMethods(): void
    {
        $reflection = new \ReflectionClass(MigrationGeneratorInterface::class);
        
        $this->assertTrue($reflection->hasMethod('setPath'));
        $this->assertTrue($reflection->hasMethod('getPath'));
        $this->assertTrue($reflection->hasMethod('setNamespace'));
        $this->assertTrue($reflection->hasMethod('getNamespace'));
    }

    public function testMigrationResolverInterfaceHasResolutionMethods(): void
    {
        $reflection = new \ReflectionClass(MigrationResolverInterface::class);
        
        $this->assertTrue($reflection->hasMethod('getMigrations'));
        $this->assertTrue($reflection->hasMethod('resolveMigration'));
        $this->assertTrue($reflection->hasMethod('getMigrationName'));
        $this->assertTrue($reflection->hasMethod('getMigrationClass'));
    }

    public function testMigrationResolverInterfaceHasValidationMethods(): void
    {
        $reflection = new \ReflectionClass(MigrationResolverInterface::class);
        
        $this->assertTrue($reflection->hasMethod('isMigrationFile'));
        $this->assertTrue($reflection->hasMethod('sortMigrations'));
    }

    public function testMigrationCreatorInterfaceHasCreationMethods(): void
    {
        $reflection = new \ReflectionClass(MigrationCreatorInterface::class);
        
        $this->assertTrue($reflection->hasMethod('create'));
        $this->assertTrue($reflection->hasMethod('getStub'));
        $this->assertTrue($reflection->hasMethod('populateStub'));
    }

    public function testMigrationCreatorInterfaceHasNamingMethods(): void
    {
        $reflection = new \ReflectionClass(MigrationCreatorInterface::class);
        
        $this->assertTrue($reflection->hasMethod('getClassName'));
        $this->assertTrue($reflection->hasMethod('getDatePrefix'));
        $this->assertTrue($reflection->hasMethod('getFileName'));
    }

    public function testMigrationStatusEnumCases(): void
    {
        $cases = MigrationStatus::cases();
        
        $this->assertCount(4, $cases);
        $this->assertContains(MigrationStatus::PENDING, $cases);
        $this->assertContains(MigrationStatus::RAN, $cases);
        $this->assertContains(MigrationStatus::FAILED, $cases);
        $this->assertContains(MigrationStatus::RUNNING, $cases);
    }

    public function testMigrationStatusValues(): void
    {
        $this->assertSame('pending', MigrationStatus::PENDING->value);
        $this->assertSame('ran', MigrationStatus::RAN->value);
        $this->assertSame('failed', MigrationStatus::FAILED->value);
        $this->assertSame('running', MigrationStatus::RUNNING->value);
    }

    public function testMigrationStatusLabels(): void
    {
        $this->assertSame('Pending', MigrationStatus::PENDING->label());
        $this->assertSame('Ran', MigrationStatus::RAN->label());
        $this->assertSame('Failed', MigrationStatus::FAILED->label());
        $this->assertSame('Running', MigrationStatus::RUNNING->label());
    }

    public function testMigrationStatusCanExecute(): void
    {
        $this->assertTrue(MigrationStatus::PENDING->canExecute());
        $this->assertFalse(MigrationStatus::RAN->canExecute());
        $this->assertFalse(MigrationStatus::FAILED->canExecute());
        $this->assertFalse(MigrationStatus::RUNNING->canExecute());
    }

    public function testMigrationStatusCanRollback(): void
    {
        $this->assertFalse(MigrationStatus::PENDING->canRollback());
        $this->assertTrue(MigrationStatus::RAN->canRollback());
        $this->assertFalse(MigrationStatus::FAILED->canRollback());
        $this->assertFalse(MigrationStatus::RUNNING->canRollback());
    }

    public function testAllMigrationInterfacesExist(): void
    {
        $interfaces = [
            MigrationInterface::class,
            MigratorInterface::class,
            MigrationRepositoryInterface::class,
            MigrationGeneratorInterface::class,
            MigrationResolverInterface::class,
            MigrationCreatorInterface::class,
        ];
        
        foreach ($interfaces as $interface) {
            $this->assertTrue(
                interface_exists($interface),
                sprintf('Interface %s does not exist', $interface)
            );
        }
    }

    public function testMigrationStatusIsEnum(): void
    {
        $reflection = new \ReflectionEnum(MigrationStatus::class);
        
        $this->assertTrue($reflection->isEnum());
        $this->assertSame('string', $reflection->getBackingType()?->getName());
    }
}
