<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$config['authorization_enabled']=true;

$config['authorization_role_session_var']='rol';

$config['authorization_exceptions']['user']['login']['post']=true;
$config['authorization_exceptions']['user']['logout']['get']=true;
$config['authorization_exceptions']['user']['checklogin']['post']=true;
$config['authorization']['user']['*']['*']=array('0');
$config['authorization']['*']['*']['*']=array('*');

 ?>
