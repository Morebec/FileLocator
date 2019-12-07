<?php

namespace Morebec\FileLocator;

use Exception;
use InvalidArgumentException;
use Morebec\ValueObjects\File\Directory;
use Morebec\ValueObjects\File\File;
use Symfony\Component\Finder\Finder;

/**
 * The file locator allows one to find files
 * recursively by going either up or down in a hirarchy
 */
class FileLocator
{
    public function find(
            string $filename, 
            Directory $location, 
            FileLocatorStrategy $strategy
    ): ?File 
    {
        if (!$location->exists()) {
            throw new InvalidArgumentException("Location '$location' does not exists");
        }

        if($strategy == FileLocatorStrategy::RECURSIVE_UP) {
            return $this->findUp($filename, $location);
        }
        
        if($strategy == FileLocatorStrategy::RECURSIVE_DOWN) {
            return $this->findDown($filename, $location);
        }
        
        if($strategy == FileLocatorStrategy::AT_LOCATION) {
            return $this->findAtLocation ($filename, $location);
        }
        
        throw new Exception("Strategy '$strategy' not implemented");
    }
    
    /**
     * Tries to find a file at a specific location without going up or 
     * down the file tree
     * @param string $filename
     * @param Directory $location
     * @return File|null
     */
    private function findAtLocation(string $filename, Directory $location): ?File
    {
        foreach($location->getFiles() as $file) {
            if($file->getBasename() === $filename) {
                return $file;
            }
        }
        
        return null;
    }
    
    /**
     * Tries to find a file at a specific location
     * and going up the parents recursively until it finds the first occurence
     * @param string $filename
     * @param Directory $location
     * @return File|null
     */
    private function findUp(string $filename, Directory $location): ?File
    {
        $file = null;
        while (!$file) {
            // find composer.json in current dir
            $candidate = File::fromStringPath(
                "$location/$filename"
            );
            if ($candidate->exists()) {
                return $candidate;
            }
            
            $parent = $location->getDirectory();
            // Are we up at maximum ?
            if ($parent->isEqualTo($location)) {
                break;
            }
            $location = $parent;
        }
        return $file;
    }
    
    /**
     * Tries to find a file at a specific location
     * and going down recursively until it finds the first occurence
     * @param string $filename
     * @param Directory $location
     * @return File|null
     */
    private function findDown(string $filename, Directory $location): ?File
    {
        $finder = new Finder();
        
        $files = $finder->ignoreUnreadableDirs()
               ->in((string)$location)
               ->files()
               ->followLinks()
               ->name($filename);
        foreach($files as $f) {
            return File::fromStringPath((string)$f);
        }
        
        return null;
    }
}
