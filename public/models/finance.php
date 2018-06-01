<?php

class finance {

    function index($params) {
        $link = mysqli_connect('127.0.0.1', 'root', 'root', 'test_db1');
//        var_dump($link);
        return array('str'=>'Hello 家計簿!');
    }

}
