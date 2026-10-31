<?php
namespace Aslam\Test\Controller;
use Aslam\Test\View;
use Aslam\Test\Model\User;
use Aslam\Test\public\Request;
use Aslam\Test\public\Session;

class Login{
    private $userModel;
    private $session;
    public function __construct(){
        $this->userModel=new User();
        $this->session=new Session();
    }
    public function showLogin(){
        View::Render('login.php');
    }
    public function handleLogin(){
        $userData=filter_input_array(INPUT_POST);
        $loginUser=$this->userModel->Login($userData['username'],$userData['password']);
        if($loginUser){
            $this->createUserSession($loginUser);
            Request::redirect('home/index');
        }else{
            Request::redirect('login/showLogin');
        }
    }
    public function createUserSession($user){
        $this->session->setSession('user_id', $user->id);
        $this->session->setSession('user_name', $user->username);
        
    }
}