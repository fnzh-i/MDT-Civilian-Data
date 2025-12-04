<?php
declare(strict_types=1);

require_once __DIR__ . '/../DBConnect.php';

spl_autoload_register(function ($className) {
    $paths = [
        __DIR__ . "/_modules/$className.php",
        __DIR__ . "/_modules/enums/$className.php",
        __DIR__ . "/api/$className.php"
    ];

    foreach ($paths as $file) {
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});


ini_set("display_errors", "1");
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