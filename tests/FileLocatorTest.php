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
    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown(): void
    {
    }

    /**
     * @covers Morebec\Devtools\Core\Domain\Locator\FileLocator::find
     */
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
    
    /**
     * @covers Morebec\Devtools\Core\Domain\Locator\FileLocator::find
     */
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
    
    /**
     * @covers Morebec\Devtools\Core\Domain\Locator\FileLocator::find
     */
    public function testFindAtLocationStrategy()
    {
        $locator = new FileLocator;
        $file = $locator->find(
                File::fromStringPath(__FILE__)->getBasename(),
                Directory::fromStringPath(__DIR__),
                FileLocatorStrategy::AT_LOCATION()
        );
        
        $this->assertNotNull($file);
        $this->assertTrue($file->exists());
    }

    /**
     * @covers Morebec\Devtools\Core\Domain\Locator\FileLocator::find
     */
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
}
