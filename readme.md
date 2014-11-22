#SamsonPHP File service 

This module gives abstraction for working with files independently
of file system being used. The main goal is to configure the ```$fileServiceID```
service parameter. 

This is done using [SamsonPHP module/service configuration](https://github.com/samsonos/php_core/wiki/0.3-Configurating)

By default ```$fileServiceID``` is set to ```fs_local``` - uses standart local file
system service which is implemented in [SamsonPHP local file system module ```php_fs_local```](http://github.com/samsonos/php_fs_local).

