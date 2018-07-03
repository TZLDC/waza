<?php

namespace App\Models;

class User extends Base
{

    public function checkCode($code)
    {
        $now = date('Y-m-d H:i:s');
        $sql = "select * from tb_user where authcode = '{$code}' and deleted = 0 and duedate >= '{$now}' ";
        return $this->fetchOne($sql);
    }

    public function getVideoByUserId($user_id)
    {
        $sql = "select video from tb_user_video where  deleted = 0 and userid = {$user_id} order by created desc";
        return $this->fetchOne($sql);
    }

    public function getImageByUserId($user_id)
    {
        $sql = "select * from tb_user_img where  deleted = 0 and userid = {$user_id} order by type asc,sort asc,created asc";
        $data = $this->fetchAll($sql);
        foreach ($data as $k => $v) {
            $data[$k]['img'] = str_replace("upload", "thumb", $v['img']);
        }
        return $data;
    }

    public function getImageById($id)
    {
        $sql = "select img from tb_user_img where  deleted = 0 and id = {$id} ";
        return $this->fetchOne($sql);
    }

    public function getAroundImage($user_id)
    {
        $back = array();
        $sql = "select id,userid,img,sort,imgid from tb_user_img where  deleted = 0 and userid = {$user_id} and imgid = 0 and `type` = 0 order by sort asc ";
        $image_x = $this->fetchAll($sql);
        $image_x_arr = array();
        $image_x_id = array();
        foreach ($image_x as $k => $v) {
            $image_x_arr[] = str_replace("upload", "thumb", $v['img']);
            $image_x_id[] = $v['id'];
        }

        $sql = "select id,userid,img,sort,imgid from tb_user_img where  deleted = 0 and userid = {$user_id} and type = 1 order by sort asc ";
        $image_y = $this->fetchAll($sql);
        $image_y_format = array();
        $image_y_arr = array();
        foreach ($image_y as $k => $v) {
            $image_y_format[] = str_replace("upload", "thumb", $v['img']);
        }
        if ($image_y) {
            foreach ($image_x_id as $k => $v) {
                $image_y_arr[$k] = $image_y_format; 
            }
        }
        $back['image_x'] = $image_x_arr;
        $back['image_y'] = $image_y_arr;
        return $back;
    }

    public function getPoster($user_id)
    {
        $sql = "select img from tb_user_img 
                where type = 0 and  deleted = 0 and userid = {$user_id} order by sort desc ,created asc limit 1";
        $row = $this->fetchOne($sql);
        if ($row) {
            return str_replace("upload", "thumb", $row['img']);
        } else {
            return '';
        }
    }
}
