<?php

use Morebec\ValueObjects\File\Directory;
use Morebec\FileLocator\FileLocatorStrategy;

/**
 * File locator interface
 */
interface FileLocatorInterface
{
    /**
     * Tries to find a file starting at a specific location
     * by using a strategy. Stops at the first found occurence of the file.
     * RECURSIVE_UP => Tries to find a file at specified location, and if not found goes one 
     *                 level up and repeats this process until the file is found, or until      
     *                 there is no longer a parent level.
     * RECURSIVE_DOWN => Tries to find a file in the at specified location, and if not found goes one level down,
     *                   until the file is found or there are no children
     * AT_LOCATION => Tries to find a file only at the specified location without going up or down
     *
     * @param string $filename Name of the file to find
     * @param Directory $location Starting location for search
     * @param FileLocatorStrategy $strategy Strategy to use for searching
     * @return File|null The file if it was found, otherwise null
     */
    public function find(
        string $filename, 
        Directory $location, 
        FileLocatorStrategy $strategy
    ): ?File;
}
