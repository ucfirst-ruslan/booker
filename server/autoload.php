<?php

function __autoload($class)
{
	//echo $class.'<br />';
	require_once str_replace("\\", "/", $class) . '.php';
}