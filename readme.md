#SamsonPHP File service 

This module gives abstraction for working with files independently
of file system being used. The main goal is to configure the ```$fileServiceID```
service parameter. 

This is done using [SamsonPHP module/service configuration](https://github.com/samsonos/php_core/wiki/0.3-Configurating)

By default ```$fileServiceID``` is set to ```fs_local``` - uses standart local file
system service which is implemented in [SamsonPHP local file service ```php_fs_local```](http://github.com/samsonos/php_fs_local).

To work with current file system service you should get file system service instance pointer:
```php
/**@var \samson\fs\FileService $fs Pointer to file service */
$fs = & m('fs');
```

After this you can use all available methods from ```IFileService``` interface which FileService implements. 
All this method call acts like a proxy and pass this call to currently configured file service(by default ```fs_local```).

This gives you ability, for example, to quickly change your file system from local file system to Amazon Web Services S3 bucket,
which is implemented by [SamsonPHP AWS file service ```php_fs_aws```](http://github.com/samsonos/php_fs_aws). All you have to do is add configuration fo SamsonPHP file service(```fs```):
```php
class FileServiceConfig extends \samson\core\Config 
{
  /**@var string Set Amazon Web Services as web-application file service */
  public $fileServiceID = 'fs_aws';
}
```
