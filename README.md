kohana-config-file-writer
=========================

Run:
```git submodule add https://github.com/ppx17/kohana-config-file-writer.git modules/config-writer```

Add the module to your bootstrap and add:
```Kohana::$config->attach(new Config_File_Writer);```

Right after your Kohana::modules() call in your bootstrap.php.
