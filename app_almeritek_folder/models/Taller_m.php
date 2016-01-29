<?php
/**
 *
 */
class Taller extends CI_Model
{
  public function add_taller($taller)
  {
    $this->db->insert('taller', $taller);
    if($data['error']=$this->db->error()){
      return $data;
    }
    return false;
  }

  public function check_exists($taller){
    $this->db->select('id');
    $this->db->from('taller t');
    $this->db->where('id', $id);
    $res=$this->db->get()->result();
    if($res){
      return $res;
    }
    return false;
  }

  public function delete_taller($taller)
  {
    if($this->check_exists($taller)){
      $this->db->delete('taller');
      return !$this->check_exists($taller);
    }
    return false;
  }

}
 ?>
