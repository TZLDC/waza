<?php

namespace App\Controllers;
use Windward\Core\Response\Plain as PlainResponse;

class Show extends Base
{

    private $model = null;
    private $lang = 'eng';
    public function __construct(\Windward\Core\Container $container)
    {
        parent::__construct($container);
        $this->model = $container->model('User');
        $this->lang = $this->router->getParams('lang');
        $langArr = array('eng'=>'English', 'cn'=>'简体中文', 'tcn'=>'繁体中文', 'kr'=>'한국어', 'jp'=>'日本語');
        if (!isset($langArr[$this->lang])) {
            $this->lang = 'eng';
        }
        $response = new \Windward\Core\Response\Smarty($this->container);
        $response->set('lang', $this->lang);
        $response->set('langStr', $langArr[$this->lang]);
        $response->set('langArr', $this->getLang());
    }

    public function codeAction()
    {
        $data = array();
        if ($this->request->isPost()) {
            $data = $this->request->getPost('code');
            $code = $data['pre'] . '-' . $data['end'];
            $user = $this->model->checkCode($code);
            if ($user) {
                $this->redirect('/360/u/'.$this->lang.'/'.$user['authcode']);
            }
        }
        $response = new \Windward\Core\Response\Smarty($this->container);
        $response->set('data', $data);
        return $response;
    }

    public function ajaxCheckAction()
    {
        if ($this->request->isPost()) {
            $data = $this->request->getPost('code');
            $code = $data['pre'] . '-' . $data['end'];
            $user = $this->model->checkCode($code);
            if ($user) {
                $back = array('code'=>200);
            } else {
                $back = array('code'=>400);
            }
            echo json_encode($back);
            die;
        } else {
            $this->redirect('/360/u/check_code');
        }
    }

    public function aroundAction()
    {
        $code = $this->router->getParams('code');
        $user = $this->model->checkCode($code);
        if (!$user) {
            $this->redirect('/360/u/check_code/'.$this->lang);
        }
        $image =  $this->model->getAroundImage($user['id']);
        $response = new \Windward\Core\Response\Smarty($this->container);
        $response->set('code', $user['authcode']);
        $response->set('image', $image);
        return $response;
    }

    public function videoAction()
    {
        $code = $this->router->getParams('code');
        $user = $this->model->checkCode($code);
        if (!$user) {
            $this->redirect('/360/u/check_code/'.$this->lang);
        }
        $video = $this->model->getVideoByUserId($user['id']);
        $poster = $this->model->getPoster($user['id']);
        $response = new \Windward\Core\Response\Smarty($this->container);
        $response->set('video', $video);
        $response->set('poster', $poster);
        return $response;
    }

    public function photoAction()
    {
        $code = $this->router->getParams('code');
        $id = $this->router->getParams('id');
        $user = $this->model->checkCode($code);
        if (!$user) {
            $this->redirect('/360/u/check_code/'.$this->lang);
        }
        $response = new \Windward\Core\Response\Smarty($this->container);
        if ($id) {
            $image = $this->model->getImageById($id);
            if (!$image) {
                $this->redirect('/360/u/'.$this->lang.'/'.$code.'/images');
            }
            $response->set('image', str_replace("upload", "thumb", $image));
            $response->setTpl('Show/detail');
            return $response;
        }
        $images = $this->model->getImageByUserId($user['id']);
        $response->set('code', $user['authcode']);
        $response->set('images', $images);
        return $response;
    }

    private function getLang()
    {
        include ROOT .'/Lang/' . $this->lang . '/' . 'lang.php';
        return $langInfo;
    }
}
