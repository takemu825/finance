<?php

class finance {

    function create($params) {
        $params['item_type'] = '';
        return $this->render($params);
    }

    function index($params) {
        return $this->render($params);
    }

    private function render($params) {
        $item_type = $params['item_type'];
        $input_items = $this->getInputItems();
        $output_items = $this->getOutputItems();
        if ($item_type == 'input') {
            $items = $input_items;
        } else {
            $items = $output_items;
        }
        return [
            'str'=>'Hello 家計簿!',
            'item_type' => $item_type,
            'input_items' => $input_items,
            'output_items' => $output_items,
            'items' => $items
        ];
    }

    private function getInputItems() {
        return [
            '給与・賞与',
            'その他'
        ];
    }

    private function getOutputItems() {
        return [
            '食費',
            '水道光熱費',
            '通信費',
            'レジャー費',
            '交通費',
            '美容費',
            '医療費',
            '被服費',
            '生活雑貨・日用品',
            '住宅費',
            '税金',
            '保険',
            'その他'
        ];
    }

}
