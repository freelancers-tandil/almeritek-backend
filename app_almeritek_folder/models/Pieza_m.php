<?php
/**
 *
 */
class Pieza_m extends CI_Model
{

  public function add_pieza($pieza)
  {
    $resp = $this->db->insert('pieza', $pieza);
    if($data['error']=$this->db->error()){
      return $data;
    }
    else{
      $this->db->select('*');
      $this->db->from('pieza p');
      $this->db->where('id',$this->db->insert_id());
      return $this->db->get()->result();
    }
  }

  public function check_exists($id){

    $this->db->select('id');
    $this->db->from('pieza p');
    $this->db->where('id', $id);
    $res=$this->db->get()->result();
    if($res){
      return $res;
    }
    return false;
  }

  public function delete_pieza($id)
  {
    if($this->check_exists($id)){
      $this->db->where('id',$id);
      $this->db->delete('pieza');
      return !$this->check_exists($id);
    }
    return false;
  }

  public function get_piezas(){

    $this->db->select('*');
    $this->db->from('pieza p');

    $query=$this->db->get();
    if($query->num_rows()>0)
    {
      return $query->result();
    }
  }

  public function update_pieza($pieza)
  {
    $pieza = (object) $pieza;
    if($this->check_exists($pieza->id)){
      $data = array(
        'producto'=>$pieza->producto,
        'precio'=>$pieza->precio,
        'link'=>$pieza->link,
        'pedido'=>$pieza->pedido,
      );
      $this->db->where('id',$pieza->id);
      $this->db->update('pieza',$data);
      return true;
    }
    else
    {
      $error = array(
        'code'=>'50001',
        'message'=>'El id de la pieza no existe'
      );
      return array('error' => $error);
    }
  }

  public function get_pieza_by_id($id)
  {
    $this->db->select('*');
    $this->db->from('pieza p');
    $this->db->where('id',$id);
    $query = $this->db->get();
    if($query->num_rows()>=0)
    {
      return $query->result();
    }
  }

}
 ?>
