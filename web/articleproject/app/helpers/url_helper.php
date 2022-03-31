<?php

function redirect($path)
{
    header('location:' . URLROOT . $path);
}

?>