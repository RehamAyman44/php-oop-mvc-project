<?php
namespace Aslam\Test\Controller;
use Aslam\Test\Model\Category;
use Aslam\Test\Model\Menu;
use Aslam\Test\View;
use Aslam\Test\public\Session;
use Aslam\Test\Model\Order;
class Sales{
    private $categoryModel;
    private $menuModel;
    private $orderModel;
    private $session;
    public function __construct(){
        $this->categoryModel=new Category();
        $this->menuModel=new Menu();
        $this->orderModel=new Order();
        $this->session=new Session();
    }
    public function index(){
        $allCategories=$this->categoryModel->getAllCategories();
        $allMenuies=$this->menuModel->getAllMenuies();
        View::Render('sales.php',['allCategories'=>$allCategories,'allMenuies'=>$allMenuies]);
    }
    public function makeOrder(){
        $orderData=filter_input_array(INPUT_POST);
        $orderData['user_id']=$this->session->getSession('user_id');
        echo $this->orderModel->placeOrder($orderData);
    }
    public function showReceipt($id){
        $orderList=$this->orderModel->getOrderDetail($id);
        $orderItems=$this->orderModel->getOrderItemDetail($id);
        $processedBy=$this->session->getSession('user_name');
        View::Render('receipt.php',['orderList'=>$orderList,'orderItems'=>$orderItems,'processedBy'=>$processedBy]);
        
    }
}