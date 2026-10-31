<?php
namespace Aslam\Test\Model;
use Aslam\Test\public\Model;
use Aslam\Test\public\Session;
class Order extends Model{
    protected $tableName="order_list";
    // private $session;

    public function __construct(){
        parent::__construct();
        // $this->session=new Session();
    }

    public function placeOrder($data){

        // $data['user_id']=$this->session->getSession('user_id');
        $data['code']=$this->generateCode();
        $data['queue']=$this->extractQueue($data['code']);
        $orderListResult=$this->insertOrderList($data);

        if($orderListResult['success']==true){
           $orderId=$orderListResult['order_id'];
           $orderItemResult=$this->insertOrderItem($data,$orderId);
           if($orderItemResult['success']==true){
               return json_encode([
                   'status'=>'success',
                   'msg'=>'order has been placed successfully',
                   'order_id'=>$orderId
               ]);
           }else{
               return json_encode([
                   'status'=>'fail',
                   'msg'=>'order has not been placed',
                   'error'=>$orderItemResult['error']
               ]);
           }
        }else{
            return json_encode([
                'status'=>'fail',
                'msg'=>'order has not been placed',
                'error'=>$orderListResult['error']
            ]);
        }
        
    }
    private  function  insertOrderList($data){
        $orderFields=['code','queue','total_amount','tendered_amount','user_id'];
        $fields=[];
        $placeHolders=[];
        foreach($data as $key=>$value){
            if(in_array($key,$orderFields)&& !is_array($value)){
                $fields[]=$key;
                $placeHolders[]=":{$key}";
            }
            
        }
        $query="INSERT INTO $this->tableName (".implode(",",$fields).") VALUES (".implode(",",$placeHolders).")";
        $this->query($query);
        foreach($data as $key=>$value){
            if(in_array($key,$orderFields)&& !is_array($value)){
                $this->bind(':' .$key,$value);
            }
        }
        $success=$this->execute();
        if($success){
            return ['success'=>true,'order_id'=>$this->connection->lastInsertId()];

        }else{
            return ['success'=>false,'error'=>$this->connection->errorInfo()];
        }
     
    }
    private  function insertOrderItem($orderData,$orderId){
        $data='';
        foreach($orderData['menu_id'] as $key=>$value){
            if(!empty($data)){
                $data.=",";
            }
            $data.="({$orderId},'{$orderData['menu_id'][$key]}',{$orderData['price'][$key]},{$orderData['quantity'][$key]})";
        }
        $query="INSERT INTO order_items (order_id,menu_id,price,quantity) VALUES $data";
        $this->query($query);
        $success=$this->execute();
        if($success){
            return ['success'=>true];
        }else{
            return ['success'=>false,'error'=>$this->connection->errorInfo()];
        }
    }
    
    private function generateCode(){
        $prefix = date("Ymd");
        $code = sprintf("%'.05d", 1);
        while (true) {
            $query = "SELECT * FROM $this->tableName WHERE code = '{$prefix}{$code}'";
            $this->query($query);
            $row=$this->single();
            if ($row) {
                $code = sprintf("%'.05d", $code + 1);
            } else {
                return $prefix . $code;
            }
        }
    }
    private function extractQueue($code){
        return substr($code, -5);
    }
    public function getOrders(){
        $query="SELECT * FROM $this->tableName";
        $this->query($query);
        return $this->resultSet();
    }
    public function getOrderDetail($id){
        $query="SELECT * FROM $this->tableName where id=$id";
        $this->query($query);
        return $this->single();
    }
    public function getOrderItemDetail($id){
        $query="SELECT oi.*,concat(ml.code,'-',ml.name) as item 
        FROM order_items oi join menu_list ml on oi.menu_id=ml.id where oi.order_id=$id";
        $this->query($query);
        return $this->single();
        
    }
    public function deleteOrder($id){
        $query="DELETE FROM $this->tableName where id=$id";
        $this->query($query);
        return $this->execute();
    }
    
        
}    
// Array ( [total_amount] => 25
// [ menu_id] => Array ( [0] => 5 ) 
// [price] => Array ( [0] => 25 ) 
// [quantity] => Array ( [0] => 1 ) 
// [tendered_amount] => 50 
// [code] => 2026090500001 
// [queue] => 00001 )