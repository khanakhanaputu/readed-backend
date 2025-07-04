<?php
include_once("core/ezSyntax.php");
include_once("router.php");
include_once("core/middleware.php");
include_once("config.php");
include_once('views/components/navbar.php');
$base_url = BASE_URL;
$Router = new Router();
// buat hide error pas udah production
// ini_set('display_errors', 0);

// ngecek url ada /api atau ngga

$detect_api = explode("/", trim($_SERVER['REQUEST_URI'], "/"));
if (isset($detect_api[0]) && $detect_api[0] === 'api' || isset($detect_api[1]) && $detect_api[1] === 'api') {
    // kalo ada /api tampiannya cuman jsone response
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    echo $Router->run();  // ngejalanin router api
} else {
    // kalo nggaada /api nampilih struktur html untuk view nya

    // fix css
    function fixcss()
    {
        $base_url = BASE_URL;
        return (strpos($_SERVER['REQUEST_URI'], "/$base_url") === 0) ? "/$base_url/" : '';
    }

    function checkUserAccount() {}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />

    <title></title>

</head>

<body class="font-poppins">
    <?php
        navbar();
        $Router->run();
        ?>
    <script></script>
</body>

</html>
<?php
}
?>