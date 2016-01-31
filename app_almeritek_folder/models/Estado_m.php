<?php
/**
 *
 */
class Estado_m extends CI_Model
{

  public function add_estado($estado)
  {
    $resp = $this->db->insert('estado', $estado);
    if($data['error']=$this->db->error()){
      return $data;
    }
    else{
      $this->db->select('*');
      $this->db->from('estado e');
      $this->db->where('id',$this->db->insert_id());
      return $this->db->get()->result();
    }
  }

  public function check_exists($id){

    $this->db->select('id');
    $this->db->from('estado e');
    $this->db->where('id', $id);
    $res=$this->db->get()->result();
    if($res){
      return $res;
    }
    return false;
  }

  public function delete_estado($id)
  {
    if($this->check_exists($id)){
      $this->db->where('id',$id);
      $this->db->delete('estado');
      return !$this->check_exists($id);
    }
    return false;
  }

  public function get_estados(){

    $this->db->select('*');
    $this->db->from('estado e');

    $query=$this->db->get();
    if($query->num_rows()>0)
    {
      return $query->result();
    }
  }

  public function update_estado($estado)
  {
    $estado = (object) $estado;
    if($this->check_exists($estado->id)){
      $data = array(
        'recibido'=>$estado->recibido,
        'presupuestado'=>$estado->presupuestado,
        'en_curso'=>$estado->en_curso,
        'reparado'=>$estado->reparado,
        'entregado'=>$estado->entregado,
        'cancelado'=>$estado->cancelado,
      );
      $this->db->where('id',$estado->id);
      $this->db->update('estado',$data);
      return true;
    }
    else
    {
      $error = array(
        'code'=>'50001',
        'message'=>'El id del estado no existe'
      );
      return array('error' => $error);
    }
  }

  public function get_estado_by_id($id)
  {
    $this->db->select('*');
    $this->db->from('estado e');
    $this->db->where('id',$id);
    $query = $this->db->get();
    if($query->num_rows()>=0)
    {
      return $query->result();
    }
  }

}
 ?>
