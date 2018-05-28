<?php
function BootpayAutoload($class)
{
    $base_dir = __DIR__;
    $file = $base_dir . "/" . str_replace('\\', '/', $class) . ".php";
    if (file_exists($file)) {
        /** @noinspection PhpIncludeInspection */
        include $file;
    }
}