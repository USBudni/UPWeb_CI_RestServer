<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
	public function __construct(){
        parent::__construct();
        // Your own constructor code
    }

    public function getData(){
        $users = Array();
    	$query = $this->db->query('select id, user_login from users');
       
    	foreach ($query->result_array() as $key => $user){
            $users[$key]['login'] = $user['user_login'];
            $users[$key]['id'] = $user['id'];
            // $users[$key]['pass'] = $user['user_pass'];
		}
        
    	return $users;
    }

    public function getUser($data){
        $row = Array();
        $query = $this->db->query('select * from users where user_login = ?', $data['login']);
    	if(count($query->result_array()) > 0){
	    	foreach ($query->result_array() as $key => $user){
				$row[$key]['login'] = $user['user_login'];	
				$row[$key]['pass'] = $user['user_pass'];
			}

			if($row[0]['login'] == $data['login'] && $row[0]['pass'] == $data['pass']){
				return true;
			}
		}

		return false;
    }

    public function recoverPass($data){
        $select = $this->db->query('select * from users where user_login = ?', $data['login']);
        if(count($select->result_array()) > 0){
            $this->db->query('update users set user_pass = ? where user_login = ?', array(md5('abc123'), $data['login']));

            $result = $this->db->query('select * from users where user_login = ?', $data['login']);

            if($result){
                return true;
            }
        }

        return false;
    }

    public function createUser($data){        
        $newUser = array('user_login' => $data['login'], 'user_pass' => md5('newuser123'));
        $sql = $this->db->insert('users', $newUser);
        if($sql){
            return true;
        }

        return false;
    }

    public function deleteUser($data){
        var_dump($data);
    	$sql = $this->db->delete('Users', array('id' => $data['id']));
    	if($sql){
    		return true;
        }

    	return false;

    }

    public function updateUser($data){
        $select = $this->db->query('select * from Users where id = ?', $data['id']);
        if(count($select->result_array()) > 0){
            $this->db->set('user_login', $data['user'][0]['nome']);
            $this->db->set('user_pass', $data['user'][1]['pass']);
            $this->db->where('id', $data['id']);
            $result = $this->db->update('users');

            if($result){
                return true;
            }
        }

        return false;
    }

}