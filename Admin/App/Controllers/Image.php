<?php

namespace App\Controllers;

use Windward\Core\Response\Plain as PlainResponse;

class Image extends Base
{

	private $model = null;

    public function __construct(\Windward\Core\Container $container)
    {
        parent::__construct($container);
        $this->model = $container->model('Image');
    }

    public function IndexAction()
    {
    	$id = $this->router->getParams('id');
        $user = $this->model->get('tb_user','username, sendMail',['id' => $id,'deleted' =>0]);
        $sendflag = 0;
        if ($this->request->isComplete()) {
                $this->redirect('/index/index');
        } else {
            if ($id) {
                $data = $this->model->getImgById($id);
                // $dataimg = $this->model->getSonImgById($id);
                $video = $this->model->get('tb_user_video','*',['userid' => $id,'deleted'=>0],true,'created desc');
                if($video){
                    $videourl = $video['video'];
                    $videotime = $video['created'];
                    $sendflag = 1;
                } else {
                    $videourl = '';
                    $videotime = '';
                }
            }
        }
    	$response = new \Windward\Core\Response\Smarty($this->container);
        $response->set('uid', $id);
        $response->set('data',$data);
        // $response->set('dataimg',$dataimg);
        $response->set('videourl',$videourl);
        $response->set('user',$user);
        $response->set('sendflag',$sendflag);
        $response->set('videotime',$videotime);
        return $response;
    }

    // public function uploadImgAction()
    // {
    // 	$response = new PlainResponse($this->container);
    //     $response->setContentType(PlainResponse::CONTENT_TYPE_HTML);
    //     $id = $this->router->getParams('authcode');
    //     $sort = $this->router->getParams('sort');
    //     $uid = $this->router->getParams('authcode');
    //     $authcode = $this->model->get('tb_user', 'authcode', ['id'=> $uid, 'deleted' => 0])['authcode'];
    // 	$filePath = WEB_PATH.'/upload/'.$authcode;

    // 	if (isset($_FILES['file'])) {
    //         $file = \App\Extend\Upload::upload($filePath, 'file');
    //         if ($file['save']) {
    //             $iname = $_FILES['file']['name'];
    //             $thumbPath = WEB_PATH.str_replace('upload', 'thumb', $file['save']);
    //             $dr = str_replace('upload', 'thumb', $filePath);
    //             $imgH =(int)getimagesize(WEB_PATH.$file['save'])[1];
    //             $imgW =(int) getimagesize(WEB_PATH.$file['save'])[0];
    //             $thumbWidth = (int) (($imgW*THUMBHEIGHT)/$imgH);
    //             $thumb = \App\Extend\Upload::thumb(WEB_PATH.$file['save'],$thumbWidth, THUMBHEIGHT, $thumbPath, $dr);
    //             $url = $file['save'];
    //             $data = [
    //             	'userid' => $uid,
    //             	'img' => $url,
    //             	'created' => NOW,
    //             	'sort' => $sort,
    //                 'type' => 1,
    //                 'iname' => $iname
    //             ];
    //             $imgid = $this->model->insert('tb_user_img',$data);
    //         } else {
    //             return $response->setContent(json_encode(['status' => '0']));
    //         }
    //     } else {
    //         return $response->setContent(json_encode(['status' => '0']));
    //     }
    //     $url = str_replace('upload', 'thumb', $file['save']);
    //     $content = [
    //         'status' => '1',
    //         'data' => ['url' => $url],
    //         'imgid' => $imgid,
    //         'iname' => $iname
    //     ];
    //     return $response->setContent(json_encode($content));
    // }

    public function uploadAction()
    {
    	$response = new PlainResponse($this->container);
        $response->setContentType(PlainResponse::CONTENT_TYPE_HTML);
        $id = $this->router->getParams('authcode');
        $authcode = $this->model->get('tb_user', 'authcode', ['id'=> $id, 'deleted' => 0])['authcode'];
    	$filePath = WEB_PATH.'/upload/'.$authcode;
    	if (isset($_FILES['file'])) {
            $iname = $_FILES['file']['name'];
            $file = \App\Extend\Upload::upload($filePath, 'file');
            if ($file['save']) {
                $type = 0;
                if(strpos($iname, 'Y') !== false) {
                    $type = 1;
                }
                preg_match('/\d+/',$iname,$arr);
                $sort = (int) $arr[0];
                $thumbPath = WEB_PATH.str_replace('upload', 'thumb', $file['save']);
                $dr = str_replace('upload', 'thumb', $filePath);
                $imgH =(int)getimagesize(WEB_PATH.$file['save'])[1];
                $imgW =(int) getimagesize(WEB_PATH.$file['save'])[0];
                $thumbWidth = (int) (($imgW*THUMBHEIGHT)/$imgH);
                $thumb = \App\Extend\Upload::thumb(WEB_PATH.$file['save'],$thumbWidth, THUMBHEIGHT, $thumbPath, $dr);
                $url = $file['save'];
                $data = [
                	'userid' => $id,
                	'img' => $url,
                	'created' => NOW,
                	'sort' => $sort,
                    'type' => $type,
                    'iname' => $iname
                ];
                $imgid = $this->model->insert('tb_user_img',$data);
            } else {
                return $response->setContent(json_encode(['status' => '0']));
            }
        } else {
            return $response->setContent(json_encode(['status' => '0']));
        }
        $url = str_replace('upload', 'thumb', $file['save']);
        $content = [
            'status' => '1',
            'data' => ['url' => $url],
            'imgid' => $imgid,
            'iname' => $iname
        ];
        return $response->setContent(json_encode($content));
    }

    public function deletedAction()
    {
    	$id = $this->request->getPost('id');

        $son = $this->model->get('tb_user_img','*',['deleted'=>0,'imgid'=>$id],false);
        if($son){
            foreach ($son as $k => $v) {
               $this->model->update('tb_user_img',['deleted'=>1],['id'=>$v['id']]);
            }
        }
    	if($id) {
            $res = $this->model->update('tb_user_img',['deleted' => 1],['id' => $id]);
            if($res) {
            	return $this->plainSuccess(json_encode(['status' =>1]));
            }
		}
    }

    public function checkSortAction()
    {
    	$sortArr = $this->request->getPost('sort');
    	$imgCount = count($sortArr);
    	foreach ($sortArr as $key => $value) {
    		$sort = $key;
    		$this->model->update('tb_user_img',['sort' =>$sort],['id'=>$value]);
    	}
    	return $this->plainSuccess(json_encode(['status' =>1]));
    }

    public function videoAction()
    {
        $id = $this->request->getPost('mid');
        $img = $this->model->get('tb_user_img','img',['userid'=>$id, 'deleted'=>0, 'type' => 0],false,'sort asc');
        $authcode = $this->model->get('tb_user','authcode',['id'=>$id,'deleted'=>0])['authcode'];
        $imgPath = '';
        foreach ($img as $k => $v) {
            $v['img'] = str_replace('upload', 'thumb', $v['img']);
            $imgPath .= WEB_PATH.$v['img'].' ';
        }
        $imgPath = $imgPath . $imgPath . $imgPath;
        $timenow = strtotime("now");
        $baseDir = WEB_PATH."/upload/".$authcode;
        $pipeFile = $baseDir."/images.pipe";
        $videoFile = $baseDir."/".$timenow.".mp4";
        $logFile = $baseDir."/video.log";
        //ffmpeg -f image2pipe -i /data/staging/Waza-Web-On-Samurai/Admin/Public/upload/qw-49899/images.pipe -aspect 4:3 -s 640x480 -vcodec libx264 -pix_fmt yuv420p -profile main -b:v 200k -r 10 -y /data/staging/Waza-Web-On-Samurai/Admin/Public/upload/qw-49899/1530285941.mp4
        $cmdPipe = "cat {$imgPath} > ".$pipeFile;
        //$cmdVideo = VIDEOBIN." -y -threads 2 -r 8 -f image2pipe -i {$pipeFile} ".$videoFile." > ".$logFile." 2>&1";
        // $cmdVideo = VIDEOBIN." -f image2pipe -i {$pipeFile} -aspect 4:3 -s 640x480 -vcodec libx264 -pix_fmt yuv420p -profile main -b:v 200k -r 10 -y ".$videoFile." > ".$logFile." 2>&1";
        $cmdVideo = VIDEOBIN." -y -threads 2 -r 8 -f image2pipe -i {$pipeFile} -aspect 4:3 -s 640x480 -vcodec libx264 -pix_fmt yuv420p -profile main -b:v 200k ".$videoFile." > ".$logFile." 2>&1";
        $this->logger->log('video', "exec_pipe: ", $cmdPipe);
        exec($cmdPipe, $output);
        
        if (filesize($pipeFile) > 0) {
            $this->logger->log('video', "exec_video: ", $cmdVideo);
            exec($cmdVideo, $output);
            $output	= file($logFile);
            if(strpos(end($output),'kb/s')){
                $data = [
                    'userid' => $id,
                    'video' => '/upload/'.$authcode."/".$timenow.".mp4",
                    'created' => NOW,
                ];
                if($this->model->insert('tb_user_video',$data)){
                    $this->logger->log('video', "success: ", $data);
                    return $this->plainSuccess(json_encode(['status' =>1,'msg'=>'合成成功','url' =>$data['video'],'created' => NOW]));
                }
            }
        }
        $this->logger->log('video', "error: ", $output);
        return $this->plainSuccess(json_encode(['status' =>0,'msg'=>'合成に失敗しました']));
    }

    public function sendMailAction()
    {
        $id = $this->request->getPost('uid');
        $info = $this->model->get('tb_user', '*', ['id' => $id, 'deleted' => 0]);
        if($info['sex'] == 1) {
            if($info['language'] == 0) {
                $info['username'] = $info['username'].'様';
            } elseif ($info['language'] == 1) {
                $info['username'] = '先生'.$info['username'];
            } elseif ($info['language'] == 2) {
                $info['username'] = '先生'.$info['username'];
            } elseif ($info['language'] == 3) {
                $info['username'] = 'Mr. '.$info['username'];
            } elseif ($info['language'] == 4) {
                $info['username'] = $info['username'].'선생';
            }
        } elseif ($info['sex'] == 2) {
            if($info['language'] == 0) {
                $info['username'] = $info['username'].'様';
            } elseif ($info['language'] == 1) {
                $info['username'] = '女士'.$info['username'];
            } elseif ($info['language'] == 2) {
                $info['username'] = '女士'.$info['username'];
            } elseif ($info['language'] == 3) {
                $info['username'] = 'Ms. '.$info['username'];
            } elseif ($info['language'] == 4) {
                $info['username'] = $info['username'].'님';
            }
        }
        $language = $info['language'];
        $body = $this->codeConfig['sendBody'][$language];
        $patterns = ['/!/','/@/','/#/','/&/'];
        $end = floor((strtotime($info['duedate'])-strtotime(date("Y-m-d"),time()))/86400);
        if($info['language'] == 3) {
            if($end>1) {
                $end = $end.'days';
            } else {
                $end = $end.'day';
            }
        }
        $replacements = [$info['username'], $info['authcode'], date('Y/m/d',strtotime($info['duedate'])),$end];
        $sendBody = preg_replace($patterns, $replacements, $body['body']);
        $send = $this->sendMail($info['email'], $body['title'], $sendBody);
        if(!$send) {
            return $this->plainSuccess(json_encode(['status' =>0,'msg'=>'送信失敗しました']));
        } else {
            $this->model->update('tb_user',['sendMail' => date('Y-m-d H:i:s',time())],['id' => $id]);
            return $this->plainSuccess(json_encode(['status' =>1,'msg'=>'送信しました','sendtime' => date('Y-m-d',time())]));
        }
    }
}