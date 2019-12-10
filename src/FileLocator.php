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
class FileLocator implements FileLocatorInterface
{
    /**
     * @inheritDoc
     */
    public function find(
            string $filename, 
            Directory $location, 
            FileLocatorStrategy $strategy,
            ?int $maxDepth = null
    ): ?File 
    {
        $files = $this->findAll($filename, $location, $strategy, $maxDepth);
        return count($files) ? $files[0] : null;
    }

    /**
     * @inheritDoc
     */
    public function findAll(
        string $filename,
        Directory $location,
        FileLocatorStrategy $strategy,
        ?int $maxDepth = null
    ): array
    {
        if (!$location->exists()) {
            throw new InvalidArgumentException("Location '$location' does not exists");
        }

        if($strategy == FileLocatorStrategy::RECURSIVE_UP) {
            return $this->findUp($filename, $location, $maxDepth);
        }

        if($strategy == FileLocatorStrategy::RECURSIVE_DOWN) {
            return $this->findDown($filename, $location, $maxDepth);
        }

        if($strategy == FileLocatorStrategy::RECURSIVE_BOTH()) {
            $filesUp = $this->findAll($filename, $location, FileLocatorStrategy::RECURSIVE_UP(), $maxDepth);
            $filesDown = $this->findAll($filename, $location, FileLocatorStrategy::RECURSIVE_DOWN(), $maxDepth);
            return array_merge($filesUp, $filesDown);
        }

        throw new StrategyNotImplementedException($strategy);
    }


    /**
     * Tries to find a file at a specific location
     * and going up the parents recursively until it finds the first occurence
     * @param string $filename
     * @param Directory $location
     * @param int|null $maxDepth
     * @return array
     * @throws Exception
     */
    private function findUp(string $filename, Directory $location, ?int $maxDepth): array
    {
        $files = [];
        $currentDepth = 0;
        while (true) {
            // find composer.json in current dir
            $candidate = File::fromStringPath(
                "$location/$filename"
            );

            if ($candidate->exists()) {
                $files[] = $candidate;
            }

            // Are we at max depth
            if($currentDepth === $maxDepth) {
                break;
            }
            $currentDepth++;

            // Are we up at maximum ?
            $parent = $location->getDirectory();
            if ($parent->isEqualTo($location)) {
                break;
            }
            $location = $parent;
        }
        return $files;
    }

    /**
     * Tries to find a file at a specific location
     * and going down recursively until it finds the first occurence
     * @param string $filename
     * @param Directory $location
     * @param int|null $maxDepth
     * @return array
     */
    private function findDown(string $filename, Directory $location, ?int $maxDepth): array
    {
        $finder = new Finder();
        
        $files = $finder->ignoreUnreadableDirs()
               ->in((string)$location)
               ->files()
               ->followLinks()
               ->name($filename);

        if($maxDepth) {
            $files = $files->depth($maxDepth);
        }

        $retFiles = [];
        foreach($files as $f) {
            $retFiles[] = File::fromStringPath((string)$f);
        }
        return $retFiles;
    }
}
