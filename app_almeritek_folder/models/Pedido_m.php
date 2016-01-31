<?php
/**
 *
 */
class Pedido_m extends CI_Model
{

  public function add_pedido($pedido)
  {
    $resp = $this->db->insert('pedido', $pedido);
    if($data['error']=$this->db->error()){
      return $data;
    }
    else{
      $this->db->select('*');
      $this->db->from('pedido p');
      $this->db->where('id',$this->db->insert_id());
      return $this->db->get()->result();
    }
  }

  public function check_exists($id){

    $this->db->select('id');
    $this->db->from('pedido p');
    $this->db->where('id', $id);
    $res=$this->db->get()->result();
    if($res){
      return $res;
    }
    return false;
  }

  public function delete_pedido($id)
  {
    if($this->check_exists($id)){
      $this->db->where('id',$id);
      $this->db->delete('pedido');
      return !$this->check_exists($id);
    }
    return false;
  }

  public function get_pedidos(){

    $this->db->select('*');
    $this->db->from('pedido p');

    $query=$this->db->get();
    if($query->num_rows()>0)
    {
      return $query->result();
    }
  }

  public function update_pedido($pedido)
  {
    $pedido = (object) $pedido;
    if($this->check_exists($pedido->id)){
      $data = array(
      );
      if(isset($pedido->fecha_pedido)){
        $data['fecha_pedido']=$pedido->fecha_pedido;
      }
      if(isset($pedido->proveedor)){
        $data['proveedor']=$pedido->proveedor;
      }
      if(isset($pedido->fecha_entrega)){
        $data['fecha_entrega']=$pedido->fecha_entrega;
      }
      if(isset($pedido->precio)){
        $data['precio']=$pedido->precio;
      }
      $this->db->where('id',$pedido->id);
      $this->db->update('pedido',$data);
      return true;
    }
    else
    {
      $error = array(
        'code'=>'50001',
        'message'=>'El id del pedido no existe'
      );
      return array('error' => $error);
    }
  }

  public function get_pedido_by_id($id)
  {
    $this->db->select('*');
    $this->db->from('pedido p');
    $this->db->where('id',$id);
    $query = $this->db->get();
    if($query->num_rows()>=0)
    {
      return $query->result();
    }
  }

}
 ?>
