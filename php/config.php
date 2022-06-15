<?php

spl_autoload_register( function($class_name){
    $filemane = "..".DIRECTORY_SEPARATOR."class".DIRECTORY_SEPARATOR.$class_name.".php";
    if(file_exists($filemane)==true){
        require_once($filemane);
    }
    else{
        $filemane ="..".DIRECTORY_SEPARATOR."class".DIRECTORY_SEPARATOR."classbd".DIRECTORY_SEPARATOR.$class_name.".php";
        if(file_exists($filemane)==true){
            require_once($filemane);
        }


        else if(file_exists($filemane)==false){
            echo 'Nao existe o arquivo da classe';
        }
    }
});

?>