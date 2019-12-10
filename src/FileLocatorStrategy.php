<?php

namespace Morebec\FileLocator;

use Morebec\ValueObjects\BasicEnum;

/**
 * FileLocatorStrategy
 * @method static RECURSIVE_DOWN()
 * @method static RECURSIVE_UP()
 * @method static RECURSIVE_BOTH()
 */
class FileLocatorStrategy extends BasicEnum
{
    // Check recursively in ascending order
    public const RECURSIVE_UP = 'RECURSIVE_UP';

    // Check recursively in descending order
    public const RECURSIVE_DOWN = 'RECURSIVE_DOWN';

    // Checks in ascending and descending order
    public const RECURSIVE_BOTH = 'RECURSIVE_BOTH';
}
