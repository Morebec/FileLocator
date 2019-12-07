<?php

namespace Morebec\FileLocator;

use Morebec\ValueObjects\BasicEnum;

/**
 * FileLocatorStrategy
 */
class FileLocatorStrategy extends BasicEnum
{
    // Only at location not going down or up recursively
    public const AT_LOCATION = 'AT_LOCATION';
    
    // go check parents recursively
    public const RECURSIVE_UP = 'RECURSIVE_UP';
    
    // Only at location not going down or up recursively
    public const RECURSIVE_DOWN = 'RECURSIVE_DOWN';
}
