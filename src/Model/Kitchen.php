<?php
namespace Aslam\Test\Model;
use Aslam\Test\public\Model;

class Kitchen extends Model{
    public function getOrders($listed){
       $where='';
       if(isset($listed) && count($listed)>0){
           $where .= " and id not in (".implode(",",$listed).")";
       }
       $query="SELECT * FROM order_list WHERE status= 0 $where ORDER BY date_created DESC";
       $this->query($query);
       $orders= $this->resultSet();
       $data=[];

       foreach($orders as $order){
        $itemQuery="select oi.*,concat(ml.code,'-',ml.name) as item from order_items oi join menu_list ml 
        on oi.menu_id=ml.id where oi.order_id=$order->id";
        $this->query($itemQuery);
        $items=$this->resultSet();
        $order->item_arr=$items;
        $data[]=$order;
        
       }
       return json_encode([
           'status'=>'success',
           'data'=>$data
       ]);
    }
    public function serveOrder($id){
        $query="UPDATE order_list set status=1 where id=$id";
        $this->query($query);
        if($this->execute()){
            return json_encode([
                'status'=>'success',
                'msg'=>'order has been served successfully'
            ]);
        }
    }
}