<?php

namespace Base\Model;

class Base extends \Windward\Mvc\Model
{

    public function questionList($sh = null)
    {
        $this->switchSlave();
        $curpage = $sh['page'];
        $perpage = isset($sh['perpage']) ? $sh['perpage'] : current(array_keys($this->codeConfig["paging"]["demo"])) ? : 10;
        $sql = "select * from question a where a.deleted = 0 ";
        $cond = [];
        if ($sh['type']) {
            $cond['a.type'] = $sh['type'];
        }
        if ($sh['question']) {
            $cond['[lk]a.question'] = $sh['question'];
        }
        if ($sh['begin']) {
            $cond['[tgt]created'] = $sh['begin'];
        }
        if ($sh['end']) {
            $cond['[tlt]created'] = $sh['end'];
        }
        $params = $this->cond($sql, $cond);
        $this->orderBy($sql, 'a.desc', $this->codeConfig['order']['demo']);
        $list = $this->paginate($sql, $curpage, $perpage, $params);

        array_walk($list['items'], function(&$item) {
            $item['answer'] = json_decode($item['answer'], true);
        });
        return $list;
    }

use \Base\Traits\Base;
}
