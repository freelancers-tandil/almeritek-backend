<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$config['authorization']['enabled']=true;

$config['authorization']['cliente']['*']['*']=array('1');
$config['authorization']['*']['get']=array('0');

 ?>
