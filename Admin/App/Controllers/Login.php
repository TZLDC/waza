<?php

namespace App\Controllers;

use Windward\Core\Response\Plain as PlainResponse;

class Login extends Base
{
	private $model = null;

    public function __construct(\Windward\Core\Container $container)
    {
        parent::__construct($container);
        $this->model = $container->model('Login');

    }

    public function indexAction()
    {
    	$errors = array();
        $data = $this->request->getPost("data");
        if ($this->request->isComplete()) {
            if ($this->model->validLogin($data, $errors) && $this->model->login($data, $errors)) {
                $this->redirect('/admin/list');
            } else {
                $this->view->assign('errors', $errors);
                $this->view->assign('data', $data);
            }
        }
        $response = new \Windward\Core\Response\Smarty($this->container);
        return $response;
    }

    public function logoutAction()
    {
        unset($_SESSION["platform_admin"]);
        $this->redirect("/login/index");
    }

}