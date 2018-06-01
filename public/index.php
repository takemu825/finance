<?php

$method = $_SERVER['REQUEST_METHOD'];

if (empty($_SERVER['REQUEST_URI'])) {
    include('./views/home.php');
    exit;
}

$url = parse_url($_SERVER['REQUEST_URI']);
$analysis = explode('/', $url['path']);
$call = null;
echo 'test' . rand();

foreach ($analysis as $value) {
    if ($value !== "") {
        $call = $value;
        break;
    }
}

if ($call == null) {
    include('./views/home.php');
    exit;
}

if (file_exists('./models/'.$call.'.php')) {

    include('./models/'.$call.'.php');

    $post_date = $_POST;
    $class = new $call();
    if (!empty($post_date)) {
        var_dump($post_date);
        $ret = $class->create($_POST);
    } else {
        $ret = $class->index($_GET);
    }
    if (!is_null($ret)) {
        if(is_array($ret)){
            extract($ret);
        }
    }
}

if (file_exists('./views/template/'.$call.'.tpl.html')) {
    include('./views/template/'.$call.'.tpl.html');
} else {
    include('./views/error.php');
}

if (file_exists('./views/'.$call.'.php')) {
    include('./views/'.$call.'.php');
} else {
    include('./views/error.php');
}
