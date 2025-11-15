<?php
    declare(strict_types=1);

    require_once __DIR__ . '/../DBConnect.php';

    spl_autoload_register(function ($className) {
        $file = __DIR__ . "/_modules/$className.php";
        if (file_exists($file)) {
            require_once $file;
        }
    });

    // spl_autoload_register(function ($className) {
    //     $file = __DIR__ . "/_admin_panel/$className.php";
    //     if (file_exists($file)) {
    //         require_once $file;
    //     }
    // });


    ini_set("display_errors",1);
$page = $_GET["page"] ?? '';

$root = dirname(__DIR__);

if (file_exists("$root/src/_pages/{$page}.php")) {
    require "$root/src/_pages/{$page}.php";

} elseif (file_exists("$root/src/_admin_panel/_license/{$page}.php")) {
    require "$root/src/_admin_panel/_license/{$page}.php";

} else {
    return null;
}

?>