<?php

namespace App\Models;

use App\Extend\Validator;

class Index extends Base
{
    public function getCodeById($id)
    {
    	$res = $this->get('tb_user','*',['id' => $id,'deleted' => 0])['authcode'];
    	if($res){
    		return false; 
    	}
    	return true;
    }

    public function getList($sh = null)
    {
    	$curpage = $sh['page'];
        $perpage = isset($sh['perpage']) ? $sh['perpage'] : current(array_keys($this->codeConfig["paging"]['index'])) ?: 200;
        $sql = "SELECT
            a.id,
            a.username,
            a.mobile,
            a.email,
            a.sex,
            a.duedate,
            a.authcode,
            a.updated,
            a.sendMail,
            a.nationality,
            count(b.id) imgcon
        FROM
            tb_user a 
        LEFT JOIN tb_user_img b ON a.id = b.userid and b.deleted = 0
        WHERE a.deleted = 0 group by a.id";
        $cond = [];
        $countSql = "select count(id) cnt from tb_user where 1 = 1 and deleted = 0";
        if ($sh['authcode'] != '') {
            $cond['[lk]a.authcode'] = $sh['authcode'];
        }
        if ($sh['username'] != '') {
            $cond['[lk]a.username'] = $sh['username'];
        }
        if ($sh['mobile'] != '') {
            $cond['[lk]a.mobile'] = $sh['mobile'];
        }
        if ($sh['email'] != '') {
            $cond['[lk]a.email'] = $sh['email'];
        }
        foreach ($cond as $k => $v) {
            $k = str_replace('[lk]a.','',$k);
            $countSql .= " and {$k} like '%{$v}%'";
        }
        if($cond) {
            $sql = str_replace('group by a.id', '', $sql);
        }
        
        $params = $this->cond($sql, $cond);

        if($cond) {
            $sql = $sql.' group by a.id';
        }

        $this->orderBy($sql, 'a.desc', $this->codeConfig['order']['user']);
        $list = $this->paginate($sql, $curpage, $perpage, $params, $countSql);
        
        return $list;
    }

	public function getAuthCode($code)
	{
        $res = $this->get('tb_user','*',['authcode' => $code, 'deleted' => 0]);
        if($res){
        	return false;
        }
        return true;
	}

	public function validInput($data, &$errors)
	{
		$config = [
            'username' => [
                ['isNotNull', 'username_not_null'],
            ],
            'mobile' => [
                ['isNotNull', 'mobile_not_null'],
                ['checkPhone', 'mobile_not_check'],
            ],
            'email' => [
                ['isNotNull', 'email_not_null'],
                ['isEmail', 'is_not_email'],
            ],
            'duedate' => [
                ['isNotNull', 'duedate_not_null'],
            ]
        ];
        $validator = new \App\Extend\Validator($this->container);
        if (!$result = $validator->validate($config, $data)) {
            $errors = $validator->error;
            $this->language->validator('user', $errors);
        }

        return $result;
	}

	public function save($data)
	{
		$id = (int)$data['id'];
        
        $user_data = [
            'username' => (string)$data['username'],
            'mobile' => (string)$data['mobile'],
            'email' => (string)$data['email'],
            'sex' => (int)$data['sex'],
            'duedate' => $data['duedate'],
            'authcode' => (string)$data['authcode'],
            'language' => (int)$data['language'],
            'nationality' => (int)$data['nationality']
        ];
        if (!$id) {
            // 创建
            $user_data['created'] = NOW;
            return $this->insert('tb_user', $user_data);
        } else {
            // 编辑
            return $this->update('tb_user', $user_data, ['id' => $id]);
        }
	}

	public function getById($id)
	{
		 $id = (int)$id;

        if (!$id) {
            return [];
        }

        $user = $this->get('tb_user', '*', ['id' => $id]);

        if (!$user) {
            return [];
        }

        return $user;
	}
}