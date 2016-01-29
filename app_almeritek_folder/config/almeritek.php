<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$config['authorization_enabled']=true;

$config['authorization_role_session_var']='rol';


$config['authorization']['*']['*']['*']=array();
$config['authorization']['user']['login']['get']=array('*');
$config['authorization']['cliente']['*']['*']=array();

 ?>
