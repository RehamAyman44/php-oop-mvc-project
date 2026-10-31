<?php 

namespace Aslam\Test\public;

class Request{
    public function QueryString(){
        return $_SERVER['QUERY_STRING'];
    }
    public static function redirect($page){
        header("Location:".base_url . $page); 
    }

}