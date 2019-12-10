<?php

namespace Morebec\FileLocator;

use InvalidArgumentException;
use Morebec\ValueObjects\File\Directory;
use Morebec\ValueObjects\File\File;
use PHPUnit\Framework\TestCase;

/**
 * FileLocatorTest
 */
class FileLocatorTest extends TestCase
{
    public function testFindUpStrategy()
    {
        $locator = new FileLocator;
        $file = $locator->find(
            '.gitignore',
            Directory::fromStringPath(__DIR__),
            FileLocatorStrategy::RECURSIVE_UP()
        );
        $this->assertNotNull($file);
        $this->assertTrue($file->exists());
    }


    public function testFindDownStrategy()
    {
        $locator = new FileLocator;
        $file = $locator->find(
            File::fromStringPath(__FILE__)->getBasename(),
            Directory::fromStringPath(__DIR__ . '/../'),
            FileLocatorStrategy::RECURSIVE_DOWN()
        );

        $this->assertNotNull($file);
        $this->assertTrue($file->exists());
    }


    public function testFindAtLocationStrategy()
    {
        $locator = new FileLocator;
        $file = $locator->find(
            File::fromStringPath(__FILE__)->getBasename(),
            Directory::fromStringPath(__DIR__),
            FileLocatorStrategy::RECURSIVE_DOWN(),
            0
        );

        $this->assertNotNull($file);
        $this->assertTrue($file->exists());
    }


    public function testFindBoth()
    {
        $locator = new FileLocator;
        $file = $locator->find(
            'composer.json',
            Directory::fromStringPath(__DIR__),
            FileLocatorStrategy::RECURSIVE_BOTH(),
            2 // max depth
        );

        $this->assertNotNull($file);
        $this->assertTrue($file->exists());
    }


    public function testFindAllUpStrategy()
    {
        $locator = new FileLocator;
        $file = $locator->findAll(
            '.gitignore',
            Directory::fromStringPath(__DIR__),
            FileLocatorStrategy::RECURSIVE_UP()
        );
        $this->assertNotEmpty($file);
        $this->assertTrue($file[0]->exists());
    }


    public function testFindAllDownStrategy()
    {
        $locator = new FileLocator;
        $file = $locator->findAll(
            File::fromStringPath(__FILE__)->getBasename(),
            Directory::fromStringPath(__DIR__ . '/../'),
            FileLocatorStrategy::RECURSIVE_DOWN()
        );

        $this->assertNotEmpty($file);
        $this->assertTrue($file[0]->exists());
    }


    public function testFindAllAtLocationStrategy()
    {
        $locator = new FileLocator;
        $file = $locator->findAll(
            File::fromStringPath(__FILE__)->getBasename(),
            Directory::fromStringPath(__DIR__),
            FileLocatorStrategy::RECURSIVE_DOWN(),
            0
        );

        $this->assertNotEmpty($file);
        $this->assertTrue($file[0]->exists());
    }


    public function testFindAllBoth()
    {
        $locator = new FileLocator;
        $file = $locator->findAll(
            'composer.json',
            Directory::fromStringPath(__DIR__),
            FileLocatorStrategy::RECURSIVE_BOTH(),
            2 // max depth
        );

        $this->assertNotEmpty($file);
        $this->assertTrue($file[0]->exists());
    }

    public function testFindInNonExistingDirectory()
    {
        $locator = new FileLocator;

        $this->expectException(InvalidArgumentException::class);
        $file = $locator->find(
            '.gitignore',
            Directory::fromStringPath(__DIR__ . '/does-not-exist'),
            FileLocatorStrategy::RECURSIVE_UP()
        );
    }

    public function testFindAllInNonExistingDirectory()
    {
        $locator = new FileLocator;

        $this->expectException(InvalidArgumentException::class);
        $file = $locator->find(
            '.gitignore',
            Directory::fromStringPath(__DIR__ . '/does-not-exist'),
            FileLocatorStrategy::RECURSIVE_UP()
        );
    }
}
