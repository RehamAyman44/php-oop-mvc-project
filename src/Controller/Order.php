<?php
namespace Aslam\Test\Controller;
use Aslam\Test\View;
use Aslam\Test\Model\Order as ModelOrder;

class Order{
    private $orderModel;
    public function __construct(){
        $this->orderModel=new ModelOrder();
    } 
    public function allOrders(){
        $allOrders=$this->orderModel->getOrders();
        View::Render('orders.php',['allOrders'=>$allOrders]);
    }
    public function deleteOrder($id){
        echo $this->orderModel->deleteOrder($id);
    }
}