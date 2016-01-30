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
          return $login[0];
      }

      return false;
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
      $this->db->insert('user', $user);
      if($data['error'] = $this->db->error())
        return $data;
      return false;
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

    function delete_user($username)
    {
      if($this->check_exists($username)){
        $this->db->where('username', $username);
        $this->db->delete('user');
        return !$this->check_exists($username);
      }
      return false;
    }

    function update_user($user)
    {
      $user = (object) $user;
      if($this->check_exists($user->username)){
        $data = array(
          'username'=>$user->username,
          'password'=>$user->password,
          'nombre'=>$user->nombre,
          'apellido'=>$user->apellido,
          'email'=>$user->email,
          'rol'=>$user->rol
        );
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
}
 ?>
