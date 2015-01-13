#SamsonPHP File service 

[![Latest Stable Version](https://poser.pugx.org/samsonphp/fs/v/stable.svg)](https://packagist.org/packages/samsonphp/fs) 
[![Build Status](https://travis-ci.org/samsonphp/fs.png)](https://travis-ci.org/samsonphp/fs) 
[![Code Coverage](https://scrutinizer-ci.com/g/samsonphp/fs/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/samsonphp/fs/?branch=master)
[![Total Downloads](https://poser.pugx.org/samsonphp/fs/downloads.svg)](https://packagist.org/packages/samsonphp/fs)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/samsonphp/fs/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/samsonphp/fs/?branch=master)
[![Stories in Ready](https://badge.waffle.io/samsonphp/fs.png?label=ready&title=Ready)](https://waffle.io/samsonos/php_compressor)
 
This module gives abstraction level for working with file system independently
of what exact file system is being used.

##Configuration  

The main goal is to configure the ```$fileServiceClassName```
service parameter. 

This is usually done using [SamsonPHP module/service configuration](https://github.com/samsonos/php_core/wiki/0.3-Configurating)

By default ```$fileServiceClassName``` is set to ```samson\fs\LocalFileService``` - it uses standard local file
system service. This parameter has to be set to file service class name, for example - local file service - ```samson\fs\LocalFileService```, no module/service identifiers or anything else should be used,
 first namespace separator ```\``` should be avoided too:
  * ```\samson\fs\LocalFileService``` - incorrect
  * ```samson\fs\LocalFileService``` - correct
  
> When service is initialized it checks if configured file service class is present otherwise fatal error is signaled.

This gives you ability, for example, to quickly change your web-application file system from local file system to Amazon Web Services S3 bucket, which is implemented by [SamsonPHP AWS file service ```php_fs_aws```](http://github.com/samsonphp/fs_aws). All you have to do is add configuration for this SamsonPHP file service(```fs```):
```php
class FileServiceConfig extends \samson\core\Config 
{
  /**@var string Configured module/service identifier */
  public $__id = 'fs';
  
  /**@var string Set Amazon Web Services as web-application file service using its identifier */
  public $fileServiceID = 'samson\fs\AWSFileService';
}
```

## Usage

To work with this SamsonPHP file service you should get file service instance pointer:
```php
/**@var \samson\fs\FileService $fs Pointer to file service */
$fs = & m('fs');
```
After this you can use all available methods from [```AbstractFileService``` interface](https://github.com/samsonos/php_fs/blob/master/src/IFileSystem.php), which this SamsonPHP file service(```fs```) implements. 
All this method call act like a proxy and passes them to currently configured file service(by default ```php_fs_local```).

Example usage:
```php
if (!$fs->exists(...)) {
  $fs->write(...);
}
```

### Using service in tests
First of all you should create service instance:
```php
// Create instance
$this->fileService = new FileService(__DIR__.'../');
```
In other places called after service creation you should retrieve service object via factory method:
```php
// Get instance using services factory as error will signal other way
$this->fileService = \samson\core\Service::getInstance('samson\fs\FileService');
```

> All other SamsonPHP modules must and use this file service approach when working with files.
