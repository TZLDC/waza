<?php

namespace App\Models;

use App\Extend\Validator;

class Image extends Base
{
	public function validInput($data, &$errors)
	{
		$config = [
            'img' => [
                ['isNotNull', 'username_not_null'],
            ],
            'mobile' => [
                ['isNotNull', 'mobile_not_null'],
            ],
            'email' => [
                ['isNotNull', 'email_not_null'],
                ['isMail', 'is_not_email'],
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

	public function getImgById($id)
	{
		$res = $this->get('tb_user_img', '*', ['userid' => $id, 'deleted' => 0],false,'type asc,sort asc');
        foreach ($res as $key => $value) {
            $res[$key]['img'] = str_replace('upload', 'thumb', $res[$key]['img']);
        }
		if(!$res) {
			return false;
		}
		return $res;
	}

    // public function getSonImgById($id)
    // {
    //     $res = $this->get('tb_user_img', '*', ['userid' => $id, 'deleted' => 0,'type' =>1],false,'sort asc,created asc');
    //     foreach ($res as $key => $value) {
    //         $res[$key]['img'] = str_replace('upload', 'thumb', $res[$key]['img']);
    //     }
    //     if(!$res) {
    //         return false;
    //     }
    //     return $res;
    // }

    // public function getSonById($id)
    // {
    //     $res = $this->get('tb_user_img', '*', ['imgid' => $id, 'deleted' => 0],false,'sort desc,created desc');
    //     foreach ($res as $key => $value) {
    //         $res[$key]['img'] = str_replace('upload', 'thumb', $res[$key]['img']);
    //     }
    //     if(!$res) {
    //         return false;
    //     }
    //     return $res;
    // }
}