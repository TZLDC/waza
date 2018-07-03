<?php

namespace App\Extend;

class Validator extends \Windward\Extend\Validator
{
    public function checkAnswer($data, $vars = array())
    {
        $type = $vars['type'];

        foreach ($data as $key => $item) {
            if ($item['is_right'] && !$item['text']) {
                return false;
            }
            $ord = ord($key);
            if ($item['is_right'] || $item['text']) {
                $prevKey = chr($ord - 1);
                if (!$data[$prevKey]['text'] && $ord != 97) {
                    return false;
                }
            }
        }

        $tmp = array_map(function(&$item) {
            return $item['is_right'];
        }, $data);
        if ($type == 1 || $type == 3) {
            return array_sum($tmp) == 1;
        } elseif ($type == 2) {
            return array_sum($tmp) > 1;
        }
    }

    function checkAccount($field, $vars = array())
    {
        return preg_match('/^[0-9a-zA-Z]{3,18}$/', $field);
    }

    public function checkPhone($data)
    {
        $regex = '/^[0-9\+\-]+$/';
        return preg_match($regex, $data);
    }
    
    public function isEmail($data)
    {
        $regex = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/";
        return preg_match($regex, $data);
    }
}
