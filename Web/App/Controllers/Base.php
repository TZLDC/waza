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

}
