<?php
namespace Aslam\Test\Controller;

use Aslam\Test\public\Request;
use Aslam\Test\View;
use Aslam\Test\Model\User;
class Register{
    private $user;
    public function __construct(){
        $this->user=new User();
    }
    public function showRegister(){
        View::Render('register.php');
    }
    public function handleRegister(){
        $userData=filter_input_array(INPUT_POST);
        if($this->user->findByUsername($userData['username'])){
            throw new \Exception('User already exists');
        }
        $password_hash=password_hash($userData['password'],PASSWORD_BCRYPT);
        $user=[
            'username'=>$userData['username'],
            'firstname'=>$userData['firstname'],
            'middlename'=>$userData['middlename'],
            'lastname'=>$userData['lastname'],
            'password'=>$password_hash
        ];
        if($this->user->Register($user)){
            Request::redirect('login/showLogin');
        }else{
            Request::redirect('register/showRegister');
    }
    }
}