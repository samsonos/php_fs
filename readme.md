#SamsonPHP File service 

This module gives abstraction for working with files independently
of file system being used. The main goal is to configure the ```$fileServiceID```
service parameter. By default ```fs_local``` is set to use standart local file
system service which is implemented in (SamsonPHP local file system module ```php_fs_local```)[http://github.com/samsonos/php_fs_local]