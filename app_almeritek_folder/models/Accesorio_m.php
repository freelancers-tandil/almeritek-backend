<?php
/**
 *
 */
class Accesorio_m extends CI_Model
{

  public function add_accesorio($accesorio)
  {
    $resp = $this->db->insert('accesorio', $accesorio);
    if($data['error']=$this->db->error()){
      return $data;
    }
    else{
      $this->db->select('*');
      $this->db->from('accesorio a');
      $this->db->where('id',$this->db->insert_id());
      return $this->db->get()->result();
    }
  }

  public function check_exists($id){

    $this->db->select('id');
    $this->db->from('accesorio a');
    $this->db->where('id', $id);
    $res=$this->db->get()->result();
    if($res){
      return $res;
    }
    return false;
  }

  public function delete_accesorio($id)
  {
    if($this->check_exists($id)){
      $this->db->where('id',$id);
      $this->db->delete('accesorio');
      if ($this->check_exists($id)){
        return array('error' => $this->db->error());
      }
      return true;
      } else {
        $error = array(
          'code'=>'50001',
          'message'=>'El id del accesorio no existe'
        );
        return array('error' => $error);
    }
  }

  public function get_accesorios(){

    $this->db->select('*');
    $this->db->from('accesorio a');

    $query=$this->db->get();
    if($query->num_rows()>0)
    {
      return $query->result();
    }
  }

  public function update_accesorio($accesorio)
  {
    $accesorio = (object) $accesorio;
    if($this->check_exists($accesorio->id)){
      $data = array(
      );
      if(isset($accesorio->cargador)){
        $data['cargador']=$accesorio->cargador;
      }
      if(isset($accesorio->cable)){
        $data['cable']=$accesorio->cable;
      }
      if(isset($accesorio->maletin)){
        $data['maletin']=$accesorio->maletin;
      }
      if(isset($accesorio->caja)){
        $data['caja']=$accesorio->caja;
      }
      if(isset($accesorio->otros)){
        $data['otros']=$accesorio->otros;
      }
      $this->db->where('id',$accesorio->id);
      $this->db->update('accesorio',$data);
      return true;
    }
    else
    {
      $error = array(
        'code'=>'50001',
        'message'=>'El id del accesorio no existe'
      );
      return array('error' => $error);
    }
  }

  public function get_accesorio_by_id($id)
  {
    $this->db->select('*');
    $this->db->from('accesorio a');
    $this->db->where('id',$id);
    $query = $this->db->get();
    if($query->num_rows()>=0)
    {
      return $query->result();
    }
  }

  public function cant_accesorios(){
    $this->db->select('*');
    $this->db->from('accesorio a');
    $query=$this->db->get();
    return $query->num_rows();
  }

}
 ?>
