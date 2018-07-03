<?php

namespace App\Controllers;

class Index extends Base
{

    private $model = null;

    public function __construct(\Windward\Core\Container $container)
    {
        parent::__construct($container);
        $this->model = $container->model('Index');
    }

    public function indexAction()
    {
    	$sh = $this->request->getQuery('sh');
    	$res = $this->model->getList($sh);
    	$response = new \Windward\Core\Response\Smarty($this->container);
    	$response->set('results', $res);
    	$response->set('sh', $sh);
        return $response;
    }

    public function inputAction()
    {
    	$id = $this->router->getParams('id');
        $errors = array();
        if ($this->request->isComplete()) {
            $data = $this->request->getPost('app');
            $data['id'] = $id;
            $data['username'] = trim($data['username']);
            $data['mobile'] = trim($data['mobile']);
            if ($this->model->validInput($data, $errors)) {
                if(!$data['authcode']){
                    $data['authcode'] = $this->getCode();
                    $res = $this->model->getAuthCode($data['authcode']);
                    while ( $res == false) {
                        $data['authcode'] = $this->getCode();
                        $res = $this->model->getAuthCode($data['authcode']);
                    }
                }
                $this->model->save($data);
                $this->redirect('/admin/list');
            }
        } else {
            if ($id) {
                $data = $this->model->getById($id);
                if (!$data) {
                    $this->redirect('/admin/list');
                }
            } else {
                $date1 = date('Y-m-d',time());
                $data['duedate'] = date('Y/m/d',strtotime("{$date1} +1 month"));
            }
        }
        $nationality = $this->codeConfig['nationality'];
    	$response = new \Windward\Core\Response\Smarty($this->container);
    	$response->set('errors', $errors);
    	$response->set('app',$data);
        $response->set('nationality',$nationality);
        return $response;
    }

    public function deleteAction()
    {
    	$id = (int) $this->request->getPost('id');

    	$res = $this->model->update('tb_user',['deleted' => 1],['id' => $id]);
    	if($res) {
    		return $this->plainSuccess(json_encode(['status' =>1]));
    	} else {
    		return $this->plainSuccess(json_encode(['status' =>0]));
    	}
    }

}