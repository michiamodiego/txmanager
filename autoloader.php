<?php
spl_autoload_register(function ($class) {
    $classpath = "./src/";
    $classpath = str_replace("/", DIRECTORY_SEPARATOR, $classpath);
    $classFilename = str_replace("\\", DIRECTORY_SEPARATOR, $class);
    require_once ("${classpath}${classFilename}.php"); // fqcn
});
?>