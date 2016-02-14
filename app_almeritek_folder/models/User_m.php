<?php
/**
 *
 */
class User_m extends CI_Model
{

  var $details;

  function validate_user( $username, $password ) {
      // Build a query to retrieve the user's details
      // based on the received username and password
      $this->db->from('user');
      $this->db->where('username',$username );
      $this->db->where( 'password', $password );
      $login = $this->db->get()->result();

      // The results of the query are stored in $login.
      // If a value exists, then the user account exists and is validated
      if ( is_array($login) && count($login) == 1 ) {
          // Set the users details into the $details property of this class
          $this->details = $login[0];
          // Call set_session to set the user's session vars via CodeIgniter
          $this->set_session();
          return array('user'=>$login[0]);
      } else {
        $error = array('code'=>'40001',
                       'message' => "Nombre de usuario o contraseña incorrectos."
                       );
        return array('error'=>(object) $error);
      }

  }

  function set_session() {
        // session->set_userdata is a CodeIgniter function that
        // stores data in CodeIgniter's session storage.  Some of the values are built in
        // to CodeIgniter, others are added.  See CodeIgniter's documentation for details.
        $this->session->set_userdata( array(
                'user_id'=>$this->details->id,
                'name'=> $this->details->nombre . ' ' . $this->details->apellido,
                'email'=>$this->details->email,
                'rol'=>$this->details->rol,
                'isLoggedIn'=>true
            )
        );
    }

    function get_usuarios()
    {
      $this->db->select('*');
      $this->db->from('user u');

      $query=$this->db->get();

      if($query->num_rows()>0)
      {
        return $query->result();
      }

    }

    function add_user($user)
    {
      $db_response = $this->db->insert('user', $user);
      if ($db_response){
        $this->db->select('*');
        $this->db->from('user u');
        $this->db->where('id',$this->db->insert_id());
        return $this->db->get()->result();
      } else {
        return array('error'=>$this->db->error());
      }
    }

    function check_exists($username){
      $this->db->select('username');
      $this->db->from('user u');
      $this->db->where('username', $username);
      $res=$this->db->get()->result();
      if($res){
        return $res;
      }
      return false;
    }


    function check_exists_id($id){
      $this->db->select('id');
      $this->db->from('user u');
      $this->db->where('id', $id);
      $res=$this->db->get()->result();
      if($res){
        return $res;
      }
      return false;
    }

    function delete_user($username)
    {
      if($this->check_exists($username)){
        $this->db->where('username', $username);
        $this->db->delete('user');
        if ($this->check_exists($username)){
          return array('error' => $this->db->error());
        }
        return true;
      } else {
        $error = array(
          'code'=>'50001',
          'message'=>'El id del usuario no existe'
        );
        return array('error' => $error);
      }
    }

    function update_user($user)
    {
      $user = (object) $user;
      if($this->check_exists($user->username)){
        $data = array(
        );
        if(isset($user->username)){
          $data['username']=$user->username;
        }
        if(isset($user->password)){
          $data['password']=$user->password;
        }
        if(isset($user->nombre)){
          $data['nombre']=$user->nombre;
        }
        if(isset($user->apellido)){
          $data['apellido']=$user->apellido;
        }
        if(isset($user->email)){
          $data['email']=$user->email;
        }
        if(isset($user->rol)){
          $data['rol']=$user->rol;
        }
        $this->db->where('username',$user->username);
        $this->db->update('user',$data);
        return true;
      }
      else
      {
          $error = array(
            'code'=>'50000',
            'message'=>'El nombre de usuario no existe'
          );
          return array('error' => $error);
      }

    }

    public function get_user_by_id($id){
      $this->db->from('user');
      $this->db->where('id',$id );
      $login = $this->db->get()->result();

      // The results of the query are stored in $login.
      // If a value exists, then the user account exists and is validated
      if ( is_array($login) && count($login) == 1 ) {
          return $login[0];
      }
      return false;
    }

    public function cant_users(){
      $this->db->select('*');
      $this->db->from('user u');
      $query=$this->db->get();
      return $query->num_rows();
    }
}
 ?>
