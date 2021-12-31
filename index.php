<?php 
//use Multitone\FileSave;
use StaticFabric\StaticFactory; 

require "functions.php";
spl_autoload_register('project_autoload');

/*
$file = FileSave::getInstance('user-logs');
$file->save(__DIR__);

$file = FileSave::getInstance('system-logs');
$file->save(__DIR__);

$file = FileSave::getInstance('user-logs');
$file->save(__DIR__);

$file = FileSave::getInstance('system-logs');
$file->save(__DIR__);
*/

$obj = StaticFactory::create('\StaticFabric\FactoryClass');
$obj->save();





