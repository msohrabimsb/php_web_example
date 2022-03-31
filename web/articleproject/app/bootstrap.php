<?php

require_once("config/config.php");

require_once("helpers/url_helper.php");

require_once("helpers/session_helper.php");

function app_autoload($className)
{
    require_once("libraries/" . $className . ".php");
}
spl_autoload_register('app_autoload');

?>