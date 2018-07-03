<?php

namespace App\Controllers;

class Base extends \Base\Controller\Admin
{

    protected function uploadOss($file, $path = 'demo')
    {
        if (!$file) {
            return false;
        }
        $oss = new \Base\Lib\Aliyun\Oss(\ConstConfig::OSS_REGIONID, \ConstConfig::OSS_ACCESSKEY, \ConstConfig::OSS_ACCESSSECRET, \ConstConfig::OSS_ROLEARN, \ConstConfig::OSS_BUCKET, \ConstConfig::OSS_ENDPOINT);
        $oss->setStorage($this->redis);
        $oss->setUploadType('ram');
        $uploadFile = $oss->uploadPostFile($file, $path . '/' . date('Ymd'));
        return $uploadFile ? : false;
    }

    public function str_rand($str, $codeLen)
    {
        $rand="";
        for($i=0; $i<$codeLen; $i++){
            $rand .= $str[mt_rand(0, strlen($str)-1)]; 
        }
        return $rand;
    }

    public function getCode()
    {

        $code = $this->str_rand(STR,2).'-'.$this->str_rand(NUM,5);
        return $code;
    }

    public function beforeHandle()
    {
        $uri = lcfirst($this->request->getNormalizedUri());
    
        if ($uri != "login/index") {
            if (!$_SESSION["platform_admin"]) {
                $this->redirect("/login/index");
            }
        } else {
            if ($_SESSION["platform_admin"]) {
                $this->redirect("/index/index");
            }
        }
    }

    public function sendMail($to,$title,$content){

        require_once APP .'/Extend/Phpmailer/class.phpmailer.php';
        require_once APP .'/Extend/Phpmailer/class.smtp.php';
        $mail = new \PHPMailer();

        //$mail->isSMTP();

        $mail->SMTPDebug = 1;

        $mail->SMTPAuth=true;

        $mail->Host = SNEDHOST;

        $mail->SMTPSecure = 'ssl';

        $mail->Port = 465;

        $mail->CharSet = 'UTF-8';

        $mail->FromName = FROMNAME;

        $mail->Username = SNEDUSER;

        $mail->Password = SNEDPASS;

        $mail->From = SNEDUSER;

        $mail->isHTML(true);

        $mail->addAddress($to,'');

        $mail->Subject = $title;

        $mail->Body = $content;

        $status = $mail->send();

        if($status) {
            return true;
        }else{
            return false;
        }
    }
}
