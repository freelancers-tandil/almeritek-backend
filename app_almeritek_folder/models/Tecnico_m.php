<?php
/**
 *
 */
class Tecnico_m extends CI_Model
{
  public function add_tecnico($tecnico)
  {
    $resp = $this->db->insert('tecnico', $tecnico);
    if($data['error']=$this->db->error()){
      return $data;
    }
    else{
      $this->db->select('*');
      $this->db->from('tecnico t');
      $this->db->where('id',$this->db->insert_id());
      return $this->db->get()->result();
    }
  }

  public function check_exists($id){

    $this->db->select('id');
    $this->db->from('tecnico t');
    $this->db->where('id', $id);
    $res=$this->db->get()->result();
    if($res){
      return $res;
    }
    return false;
  }

  public function delete_tecnico($id)
  {
    if($this->check_exists($id)){
      $this->db->where('id',$id);
      $this->db->delete('tecnico');
      return !$this->check_exists($id);
    }
    return false;
  }

  public function get_tecnicos(){

    $this->db->select('*');
    $this->db->from('tecnico t');

    $query=$this->db->get();
    if($query->num_rows()>0)
    {
      return $query->result();
    }
  }

  public function update_tecnico($tecnico)
  {
    $tecnico = (object) $tecnico;
    if($this->check_exists($tecnico->id)){
      $data = array(
      );
      if(isset($tecnico->nombre)){
        $data['nombre']=$tecnico->nombre;
      }
      if(isset($tecnico->apellido)){
        $data['apellido']=$tecnico->apellido;
      }
      $this->db->where('id',$tecnico->id);
      $this->db->update('tecnico',$data);
      return true;
    }
    else
    {
      $error = array(
        'code'=>'50001',
        'message'=>'El id del tecnico no existe'
      );
      return array('error' => $error);
    }
  }

  public function get_tecnico_by_id($id)
  {
    $this->db->select('*');
    $this->db->from('tecnico t');
    $this->db->where('id',$id);
    $query = $this->db->get();
    if($query->num_rows()>=0)
    {
      return $query->result();
    }
  }

  public function cant_tecnicos(){
    $this->db->select('*');
    $this->db->from('tecnico c');
    $query=$this->db->get();
    return $query->num_rows();
  }

}
 ?>
