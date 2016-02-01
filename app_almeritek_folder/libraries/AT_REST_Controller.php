<?php

require(APPPATH.'libraries/REST_Controller.php');

/**
 *
 */
abstract class AT_REST_Controller extends REST_Controller
{

  protected $authorization;

  function __construct()
  {
    header('Access-Control-Allow-Origin: *');
    parent::__construct();

    $this->load->config('almeritek');
    $this->authorization = $this->config->item('authorization');
    $var_name=$this->config->item('authorization_role_session_var');
    if (null!==$var_name){
      $has_access=false;
      if (null!==$this->session->userdata($var_name)){
        $roles=$this->session->userdata($var_name);
        // [S,S,S]
        if (isset($this->authorization[$this->router->class][$this->router->method][$this->request->method]) &&
            (!empty($this->authorization[$this->router->class][$this->router->method][$this->request->method]))){
          $access=$this->authorization[$this->router->class][$this->router->method][$this->request->method];
        } // [S,S,A]
        else if (isset($this->authorization[$this->router->class][$this->router->method]['*']) &&
                  (!empty($this->authorization[$this->router->class][$this->router->method]['*']))){
          $access=$this->authorization[$this->router->class][$this->router->method]['*'];
        } // [S,A,S]
        else if (isset($this->authorization[$this->router->class]['*'][$this->request->method]) &&
                  (!empty($this->authorization[$this->router->class]['*'][$this->request->method]))){
          $access=$this->authorization[$this->router->class]['*'][$this->request->method];
        } // [S,A,A]
        else if (isset($this->authorization[$this->router->class]['*']['*']) &&
                  (!empty($this->authorization[$this->router->class]['*']['*']))){
          $access=$this->authorization[$this->router->class]['*']['*'];
        } // [A,S,S]
        else if (isset($this->authorization['*'][$this->router->method][$this->request->method]) &&
                  (!empty($this->authorization['*'][$this->router->method][$this->request->method]))){
          $access=$this->authorization['*'][$this->router->method][$this->request->method];
        } // [A,S,A]
        else if (isset($this->authorization['*'][$this->router->method]['*']) &&
                  (!empty($this->authorization['*'][$this->router->method]['*']))){
          $access=$this->authorization['*'][$this->router->method]['*'];
        } // [A,A,S]
        else if (isset($this->authorization['*']['*'][$this->request->method]) &&
                  (!empty($this->authorization['*']['*'][$this->request->method]))){
          $access=$this->authorization['*']['*'][$this->request->method];
        } // [A,A,A]
        else if (isset($this->authorization['*']['*']['*']) &&
                  (!empty($this->authorization['*']['*']['*']))){
          $access=$this->authorization['*']['*']['*'];
        } // Nothing defined
        else {
          $has_access=false;
        }
      }
      if (isset($access)){
        if (in_array('*',$access)){
          $has_access=true;
        } else if (is_array($roles)){
          foreach ($roles as $role) {
            if (in_array($roles,$access)){
              $has_access=true;
              break;
            }
          }
        } else if (!in_array($roles,$access)){
          $has_access=true;
        }
      }
      if ((!$has_access)&&
          ($this->config->item('authorization_enabled')) &&
          (!$this->config->item('authorization_exceptions')[$this->router->class][$this->router->method][$this->request->method])){
        $this->response([
                $this->config->item('rest_status_field_name') => FALSE,
                $this->config->item('rest_message_field_name') => $this->lang->line('text_rest_api_key_unauthorized'),
                'prueba'=>'valor'], self::HTTP_UNAUTHORIZED
            );
      }
    }
  }

  protected function _parse_delete()
  {
  // Set up out DELETE variables (which shouldn't really exist, but sssh!)
    if (stripos($this->input->server('CONTENT_TYPE'), "application/xml") === FALSE){
      $this->_delete_args = (array)json_decode(file_get_contents("php://input"));
    } else {
      $this->_delete_args = $this->format->_from_xml(file_get_contents("php://input"));
    }
  }
}


?>
