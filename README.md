# FileLocator
[![Build Status](https://travis-ci.com/Morebec/FileLocator.svg?branch=master)](https://travis-ci.com/Morebec/FileLocator)

The FileLocator Component allows one to locate files using different strategies.
This is mostly useful to find configuration files or project roots, e.g. trying to find a possibly near `composer.json` file.

There are three strategies:
 * Recursive up: Tries to find a file at specified location, and if not found goes one level up and repeats this process until the file is found, or until there is no longer a parent level.
 * Recursive down: Tries to find a file in the at specified location, and if not found goes one level down
 * At location: Tries to find a file only at the specified location without going up or down

## Installation
To install the library in a project, add these lines to your `composer.json` configuration file:

```
{
    "repositories": [
        {
            "url": "https://github.com/Morebec/FileLocator.git",
            "type": "git"
        }
    ],
    "require": {
        "morebec/file-locator": "^1.0"
    }
}
```

## Usage
The `FileLocator` has a single entry point where one needs to provide, the name of the file to find, the location and the strategy. 

Here is an example to find composer in the parent directories of the current working directory:

```php
$locator = new FileLocator();
$file = $locator->find(
    'composer.json',
    Directory::fromStringPath(getcwd()),
    FileLocatorStrategy::RECURSIVE_UP()
);

if(!$file) {
    throw new \Exception('Composer could not be found.');
}

// Parse composer file
$composerConfig = json_decode($file->getContents(), true);
```


## Running Tests
```bash
composer test
```

