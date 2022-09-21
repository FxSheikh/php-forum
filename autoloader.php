<?php
function loadClass($classname){
  $classdir = "classes";
  $classpath = $classdir."/".strtolower($classname).".php";
  include($classpath);
}
spl_autoload_register('loadClass');
?>