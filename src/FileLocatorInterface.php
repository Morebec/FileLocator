<?php

namespace Morebec\FileLocator;

use Morebec\ValueObjects\File\Directory;
use Morebec\ValueObjects\File\File;

/**
 * File locator interface
 */
interface FileLocatorInterface
{
    /**
     * Tries to find a file starting at a specific location
     * by using a strategy. Stops at the first found occurrence of the file.
     * RECURSIVE_UP => Tries to find a file at specified location, and if not found goes one
     *                 level up and repeats this process until the file is found, or until
     *                 there is no longer a parent level.
     * RECURSIVE_DOWN => Tries to find a file in the at specified location, and if not found goes one level down,
     *                   until the file is found or there are no children
     * RECURSIVE_BOTH => Tries to find a file at up and down
     *
     * @param string $filename              Name of the file to find
     * @param Directory $location           Starting location for search
     * @param FileLocatorStrategy $strategy Strategy to use for searching
     * @param int|null $maxDepth            Descend or Ascend (depending on strategy) at most levels N levels of
     *                                      directories above or below the starting location.
     *                                      A value of 0 means only check at starting location (regardless of strategy).
     *                                      If set to null will go until the end of the filesystem
     * @return File|null                    The file if it was found, otherwise null
     */
    public function find(
        string $filename, 
        Directory $location, 
        FileLocatorStrategy $strategy,
        ?int $maxDepth = null
    ): ?File;


    /**
     * Tries to find files with a certain name starting at a specific location
     * by using a strategy and stopping after a certain depth has been reached
     * RECURSIVE_UP => Tries to find a file at specified location, and if not found goes one
     *                 level up and repeats this process until the file is found, or until
     *                 there is no longer a parent level.
     * RECURSIVE_DOWN => Tries to find a file in the at specified location, and if not found goes one level down,
     *                   until the file is found or there are no children
     * AT_LOCATION => Tries to find a file only at the specified location without going up or down
     *
     * @param string $filename              Name of the file to find
     * @param Directory $location           Starting location for search
     * @param FileLocatorStrategy $strategy Strategy to use for searching
     * @param int|null $maxDepth            Descend or Ascend (depending on strategy) at most levels N levels of
     *                                      directories above or below the starting location.
     *                                      A value of 0 means only check at starting location (regardless of strategy).
     *                                      If set to null will go until the end of the filesystem
     * @return File[]                       All the files matching the filename
     */
    public function findAll(
        string $filename,
        Directory $location,
        FileLocatorStrategy $strategy,
        ?int $maxDepth = null
    ): array;
}
