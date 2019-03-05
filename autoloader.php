<?php
spl_autoload_register(function ($class) {
    $classpath = "./src/";
    $classFilename = str_replace("\\", DIRECTORY_SEPARATOR, $class);
    require_once ("${classpath}${classFilename}.php");
});
?>