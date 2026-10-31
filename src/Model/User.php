<?php
namespace Aslam\Test\Model;
use Aslam\Test\public\Model;
class User extends Model{
    protected $tableName='users';
    public function findByUsername($userName){
        $query="SELECT * FROM $this->tableName WHERE username = :username";
        $this->query($query);
        $this->bind(':username', $userName);
        $row=$this->single();
        return !empty($row) ? true : false;
    }
    public function Register($data){
        $query="INSERT INTO $this->tableName (username,firstname,middlename,lastname,password) VALUES (:username,:firstname,:middlename,:lastname,:password)";
        $this->query($query);
        $this->bind(':username', $data['username']);
        $this->bind(':firstname', $data['firstname']);
        $this->bind(':middlename', $data['middlename']);
        $this->bind(':lastname', $data['lastname']);
        $this->bind(':password', $data['password']);
        return $this->execute() ? true : false;
    }
    public function Login($userName,$password){
        $query="SELECT * FROM $this->tableName WHERE username = :username";
        $this->query($query);
        $this->bind(':username', $userName);
        $row=$this->single();
        if(!empty($row)){
            $hash_password=$row->password;
            if(password_verify($password,$hash_password)){
                return $row;
            }else{
                return false;
            }
        }
    }

}