<?php
namespace App\Models;

use App\Extend\Validator;

class Login extends Base
{
    public function validLogin($data, &$errors)
    {
        $config = [
            'account' => array(
                array('isNotNull', 'account_not_null'),
            ),
            'password' => array(
                array('isNotNull', 'pwd_not_null'),
            ),
        ];

        $validator = new Validator($this->container);
        if (!$result = $validator->validate($config, $data, false)) {
            $errors = $validator->error;
            $this->language->validator('login', $errors);
        } else {
            $config = [
                'account' => array(
                    array('checkAccount', 'login_failure'),
                ),
                'password' => array(
                    array('checkAccount', 'login_failure'),
                ),
            ];
            if (!$result = $validator->validate($config, $data, false)) {
                $errors = $validator->error;
                $this->language->validator('login', $errors);
            }
        }
        return $result;
    }

    public function login($data, &$errors)
    {
    	$account = $this->codeConfig['login']['username'];
        $password = $this->codeConfig['login']['password'];
        if ( $data["password"] != $password || $data['account'] !=$account) {
            $validator = new Validator($this->container);
            $validator->setError('account', 'login_failure');
            $errors = $validator->error;
            $this->language->validator('login', $errors);
            return false;
        }
        $_SESSION["platform_admin"] = [
            "user" => $account,
            "password" => $password
        ];
        return true;
    }

}