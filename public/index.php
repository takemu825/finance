<?php

$method = $_SERVER['REQUEST_METHOD'];

if (empty($_SERVER['REQUEST_URI'])) {
    //紹介ページを表示
    include('./views/home.php');
    exit;
}

//スラッシュで区切られたurlを取得します
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

//modelをインクルードします
if (file_exists('./models/'.$call.'.php')) {

    include('./models/'.$call.'.php');
    //$call名のクラスをインスタンス化します
    $class = new $call();
    //modelのindexメソッドを呼ぶ仕様です
    $ret = $class->index($analysis);
    //配列キーが設定されている配列なら展開します
    if (!is_null($ret)) {
        if(is_array($ret)){
            extract($ret);
        }
    }
}

//view/tamplateをインクルードします
if (file_exists('./views/template/'.$call.'.tpl.html')) {
    include('./views/template/'.$call.'.tpl.html');
} else {
    include('./views/error.php');
}

//viewをインクルードします
if (file_exists('./views/'.$call.'.php')) {
    include('./views/'.$call.'.php');
} else {
    include('./views/error.php');
}
