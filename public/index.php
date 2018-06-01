<?php

$method = $_SERVER['REQUEST_METHOD'];

if (empty($_SERVER['REQUEST_URI'])) {
    include('./views/home.php');
    exit;
}

$analysis = explode('/', $_SERVER['REQUEST_URI']);
$call = null;

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
    $class = new $call();
    $ret = $class->index($analysis);
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
