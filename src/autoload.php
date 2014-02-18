<?php


spl_autoload_register(function ($class_name) {

    if( false !== strpos($class_name, 'Development\\')){

        include __DIR__ .$class_name.'.php';
    }
});

