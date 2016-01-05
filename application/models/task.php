<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class task extends CI_Model {
  public function all()
  {
    return $this->db->query("SELECT * FROM tasks")->result_array();
  }

  public function create_task($info){
    $query = "INSERT INTO tasks (name,created_at,updated_at) VALUES(?,NOW(),NOW())";
    $values = array($info['name']);
    return $this->db->query($query,$values);
  }

  public function edit_task($info){
    $query = "UPDATE tasks
              SET name = ?,updated_at = NOW()
              WHERE id = ?";
    $values = array($info['name'],$info['id']);
    return $this->db->query($query,$values);
  }

  public function delete_task($info){
    $query = "DELETE FROM tasks WHERE id = ?";
    $values = array($info['id']);
    return $this->db->query($query,$values);
  }
  
  

}
?>