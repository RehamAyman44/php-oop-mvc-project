<?php
namespace Aslam\Test\Model;
use Aslam\Test\public\Model;

class Menu extends Model{
    protected $tableName = 'menu_list';
    public function getAllMenuies(){
        $query="SELECT * FROM $this->tableName WHERE status = 1 AND delete_flag = 0 ORDER BY name ASC";
        $this->query($query);
        return $this->resultSet();
    }
}