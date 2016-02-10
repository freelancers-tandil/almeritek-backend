<?php
/**
 *
 */
class Taller_m extends CI_Model
{
  public function add_taller($taller)
  {
    $resp = $this->db->insert('taller', $taller);
    if($data['error']=$this->db->error()){
      return $data;
    }
    else{
      $this->db->select('*');
      $this->db->from('taller t');
      $this->db->where('id',$this->db->insert_id());
      return $this->db->get()->result();
    }
  }

  public function check_exists($id){

    $this->db->select('id');
    $this->db->from('taller t');
    $this->db->where('id', $id);
    $res=$this->db->get()->result();
    if($res){
      return $res;
    }
    return false;
  }

  public function delete_taller($id)
  {
    if($this->check_exists($id)){
      $this->db->where('id',$id);
      $this->db->delete('taller');
      if ($this->check_exists($id)){
        return array('error' => $this->db->error());
      }
      return true;
    } else {
      $error = array(
        'code'=>'50001',
        'message'=>'El id del taller no existe'
      );
      return array('error' => $error);
    }
  }

  public function get_talleres(){

    $this->db->select('*');
    $this->db->from('taller t');

    $query=$this->db->get();
    if($query->num_rows()>0)
    {
      return $query->result();
    }
  }

  public function update_taller($taller)
  {
    $taller = (object) $taller;
    if($this->check_exists($taller->id)){
      $data = array(
      );
      if(isset($taller->nombre_taller)){
        $data['nombre_taller']=$taller->nombre_taller;
      }
      if(isset($taller->direccion)){
        $data['direccion']=$taller->direccion;
      }
      if(isset($taller->telefono)){
        $data['telefono']=$taller->telefono;
      }
      $this->db->where('id',$taller->id);
      $this->db->update('taller',$data);
      return true;
    }
    else
    {
      $error = array(
        'code'=>'50001',
        'message'=>'El id del taller no existe'
      );
      return array('error' => $error);
    }
  }

  public function get_taller_by_id($id)
  {
    $this->db->select('*');
    $this->db->from('taller t');
    $this->db->where('id',$id);
    $query = $this->db->get();
    if($query->num_rows()>=0)
    {
      return $query->result();
    }
  }

  public function cant_talleres(){
    $this->db->select('*');
    $this->db->from('taller t');
    $query=$this->db->get();
    return $query->num_rows();
  }

}
 ?>
