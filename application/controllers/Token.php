<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Token extends CI_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();        
    }

    public function generateToken($login) {
        $now = new DateTime();
        $timestamp = $now->getTimestamp();

        $str = "" .  $login . (string) $timestamp;
        
        return md5($str);
    }

    public function verifyToken($user, $token){
        $select = $this->db->query('select user,login from users where user_login = ? and user_token = ?', $user, $token);
        $verify = false;
        if(count($select->result_array()) > 0){
            $verify = true;
        }

        return $verify;
    }

}
