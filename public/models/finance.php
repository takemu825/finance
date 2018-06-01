<?php

class finance {

    function create($params) {
        $type = $params["contents:form:type"];//収支タイプ
        $date = $params["contents:form:date"];//日付
        $categoryID = $params["contents:form:categoryID"];//項目
        $product = $params["contents:form:product"];//品目
        $amount = $params["contents:form:amount"];//金額

        $current = $type.','.$date.','.$categoryID.','.$product.','.$amount;
        $path='finance2.txt';
        $arrayData=file($path);
        array_unshift($arrayData,$current."\n");
        $content=join('',$arrayData);
        file_put_contents($path,$content);

        $params['item_type'] = '';
        return $this->data($params);
    }

    function index($params) {
        $params['start_date'] = $params["contents:form:start_date"];
        $params['end_date'] = $params["contents:form:end_date"];
        return $this->data($params);
    }

    private function data($params) {
        $item_type = $params['item_type'];
        $start_date = $params['start_date'];
        $end_date = $params['end_date'];
        $input_items = $this->getInputItems();
        $output_items = $this->getOutputItems();
        if ($item_type == 'input') {
            $items = $input_items;
        } else {
            $items = $output_items;
        }

        $current = [];
        $file = 'finance2.txt';
        $fp = fopen($file, "r");
        if($fp){
            while ($line = fgets($fp)) {
                $data = explode(',', $line);
                $current[] = $data;
            }
        }
        fclose($fp);
        $sum = $this->calculate($current, $start_date, $end_date);

        return [
            'str'=>'Hello 家計簿!',
            'item_type' => $item_type,
            'input_items' => $input_items,
            'output_items' => $output_items,
            'items' => $items,
            'current' => $current,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'sum' => $sum
        ];
    }

    private function calculate($data, $start_date, $end_date) {
        if (!empty($start_date)) {
            $start_date_time = new DateTime($start_date);
        }
        if (!empty($end_date)) {
            $end_date_time = new DateTime($end_date);
        }
        $sum = 0;
        foreach ($data as $value) {
            $date = $value[1];
            $date_time = new DateTime($date);
            if (!empty($start_date_time) && $date_time < $start_date_time) {
                continue;
            }
            if (!empty($end_date_time) && $date_time > $end_date_time) {
                continue;
            }
            if ($value[0] == 1) {
                $sum = $sum - $value[4];
            } else if ($value[0] == 2) {
                $sum = $sum + $value[4];
            }
        }
        return $sum;
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
