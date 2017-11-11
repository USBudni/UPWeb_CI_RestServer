<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Token_model extends CI_Model {

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
        $select = $this->db->query('select user_login from users where user_login = ? and token = ?', array($user, $token));
        $verify = false;
        if(count($select->result_array()) > 0){
            $verify = true;
        }

        return $verify;
    }

}
