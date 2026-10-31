<?php
namespace Aslam\Test\Controller;
use Aslam\Test\View;

class Kitchen{
    private $kitchenModel;
    public function __construct(){
        $this->kitchenModel=new \Aslam\Test\Model\Kitchen();
    }
    public function index(){
        View::Render('kitchen.php');
    }
    public function getOrder(){
        $listed=isset($_POST['listed']) ? $_POST['listed'] : [];
        
        echo $this->kitchenModel->getOrders($listed);
    }
    public function serveOrder($id){
        echo $this->kitchenModel->serveOrder($id);
    }
}

    