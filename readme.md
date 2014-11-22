#SamsonPHP File service 

This module gives abstraction for working with files independently
of file system being used. 

##Configuration 

The main goal is to configure the ```$fileServiceID```
service parameter. 

This is usually done using [SamsonPHP module/service configuration](https://github.com/samsonos/php_core/wiki/0.3-Configurating)

By default ```$fileServiceID``` is set to ```fs_local``` - it uses standart local file
system service which is implemented in [SamsonPHP local file service ```php_fs_local```](http://github.com/samsonos/php_fs_local). This parameter has to be set to file service identifier, for local file service - ```fs_local```, no class names or anything else. 
> When service is initialized it checks if configured file service is present in web-application otherwise fatal error is signaled, the search is made via module/service identifiers.

To work with current file system service you should get file system service instance pointer:
```php
/**@var \samson\fs\FileService $fs Pointer to file service */
$fs = & m('fs');
```
After this you can use all available methods from ```IFileService``` interface which this SamsonPHP file service(```fs```) implements. 
All this method call acts like a proxy and passes them to to currently configured file service(by default ```php_fs_local```).

```php
if (!$fs->exists(...)) {
  $fs->write(...);
}
```

This gives you ability, for example, to quickly change your web-application file system from local file system to Amazon Web Services S3 bucket, which is implemented by [SamsonPHP AWS file service ```php_fs_aws```](http://github.com/samsonos/php_fs_aws). All you have to do is add configuration for this SamsonPHP file service(```fs```):
```php
class FileServiceConfig extends \samson\core\Config 
{
  /**@var string Configured module/service identifier */
  public $__id = 'fs';
  
  /**@var string Set Amazon Web Services as web-application file service using its identifier */
  public $fileServiceID = 'fs_aws';
}
```

> All other SamsonPHP modules must and use this file service approach when working with files.

#
