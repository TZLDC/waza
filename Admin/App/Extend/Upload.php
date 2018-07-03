<?php

namespace App\Extend;

class Upload
{

    public static function mkdirs($dir, $mode = 0777)
    {
        if (!is_dir($dir)) {
            self::mkdirs(dirname($dir), $mode);
            if (mkdir($dir, $mode)) {
                chmod($dir, $mode);
                return true;
            } else {
                return false;
            }
        }
        return true;
    }

    public static function fileExt($fileName)
    {
        $tmp = explode(".", $fileName);
        $fileExt = $tmp[count($tmp) - 1];
        return strtolower($fileExt);
    }

    public static function changeName($fileName)
    {
        //$name = date('His', time()) . '_' . rand(1000,9999);
        $name = md5(uniqid(rand()));
        $ext = self::fileExt($fileName);
        return $name . '.' . $ext;
    }

    public static function upload($basedir = '', $filename = '', $multi = false)
    {
        $upload = $_FILES[$filename];
        if (!$upload) {
            return [];
        }
        $now = date('Ymd');
        $dir = $basedir . '/';
        if (self::mkdirs($dir) === false) {
            return [];
        }
        if ($multi) {
            $files = $upload['name'];
            $newfiles = [];
            foreach ($files as $key => $file) {
                $newfile = self::changeName($file);
                if (@move_uploaded_file($upload['tmp_name'][$key], $dir . $newfile)) {
                    $newfiles[$key] = [
                        'name' => $upload['name'][$key],
                        'size' => $upload['size'][$key],
                        'type' => $upload['type'][$key],
                        'ext' => self::fileExt($upload['name'][$key]),
                        'save' => strstr($dir . $newfile, '/upload'),
                    ];
                } elseif (@copy($upload['tmp_name'][$key], $dir . $newfile)) {
                    $newfiles[$key] = [
                        'name' => $upload['name'][$key],
                        'size' => $upload['size'][$key],
                        'type' => $upload['type'][$key],
                        'ext' => self::fileExt($upload['name'][$key]),
                        'save' => strstr($dir . $newfile, '/upload'),
                    ];
                } else {
                    $newfiles[$key] = [];
                }
            }
            return $newfiles;
        } else {
            $newfile = self::changeName($upload['name']);
            if (move_uploaded_file($upload['tmp_name'], $dir . $newfile)) {
                return [
                    'name' => $upload['name'],
                    'size' => $upload['size'],
                    'type' => $upload['type'],
                    'ext' => self::fileExt($upload['name']),
                    'save' => strstr($dir . $newfile, '/upload'),
                ];
            } elseif (@copy($upload['tmp_name'], $dir . $newfile)) {
                return [
                    'name' => $upload['name'],
                    'size' => $upload['size'],
                    'type' => $upload['type'],
                    'ext' => self::fileExt($upload['name']),
                    'save' => strstr($dir . $newfile, '/upload'),
                ];
            } else {
                return [];
            }
        }
    }

    public function thumb($src_path,$max_w,$max_h,$thumb_path,$dir,$flag = true)
    {
        $ext=  strtolower(strrchr($src_path,'.')); 

        switch($ext){
            case '.jpg':
                $type='jpeg';
                break;
            case '.gif':
                $type='gif';
                break;
            case '.png':
                $type='png';
                break;
            default:
                $this->error='文件格式不正确';
                return false;
        }

        $open_fn = 'imagecreatefrom'.$type;

        $src = $open_fn($src_path);

        $dst = imagecreatetruecolor($max_w,$max_h);

        $src_w = imagesx($src);

        $src_h = imagesy($src);

        if ($flag) {

            if ($max_w/$max_h < $src_w/$src_h) {

                $dst_w = $max_w;
                $dst_h = $max_w * $src_h/$src_w;
            }else{

                $dst_h = $max_h;   
                $dst_w = $max_h * $src_w/$src_h;
            }

            $dst_x=(int)(($max_w-$dst_w)/2);
            $dst_y=(int)(($max_h-$dst_h)/2);
        }else{

            $dst_x=0;
            $dst_y=0;
            $dst_w=$max_w;
            $dst_h=$max_h;
        }

        imagecopyresampled($dst,$src,$dst_x,$dst_y,0,0,$dst_w,$dst_h,$src_w,$src_h);

        $filename = basename($src_path);

        $foldername=substr(dirname($src_path),0);

        if (self::mkdirs($dir) === false) {
            return [];
        }

        imagepng($dst,$thumb_path);

        imagedestroy($dst);
        imagedestroy($src);

        return $prefix.$filename;
    }

}
