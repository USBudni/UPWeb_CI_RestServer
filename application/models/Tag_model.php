<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tag_model extends CI_Model {
	public function __construct(){
        parent::__construct();
        // Your own constructor code
    }

    public function getTags(){
    	$query = $this->db->get('tags');
    	$row = array();

    	if(count($query->result_array()) > 0){
    		foreach ($query->result_array() as $key => $tag){
				$row[$key] = $tag;
			}
			return $row;
    	}
		

		return false;
    }

    public function getTag($data){
    	$row = Array();
    	$query = $this->db->query('select * from tags where id = ?', $data['id']);

    	if(count($query->result_array()) > 0){
    		foreach ($query->result_array() as $key => $tag){
                $row[$key]['id'] = $tag['id'];
		        $row[$key]['nome'] = $tag['nome'];
			}
		}

    	return $row;
    }

    public function saveTag($data){
        
        $newTag = Array(
            'nome' => $data['tag'][0]['nome']
        );
       
        $sql = $this->db->insert('tags', $newTag);
        
        if($sql){
            return true;
        }

        return false;

    }

    public function updateTag($data){
        $select = $this->db->query('select * from tags where id = ?', $data['tag'][0]['id']);
        if(count($select->result_array()) > 0){
            $this->db->set('nome', $data['tag'][1]['nome']);
            $this->db->where('id', $data['tag'][0]['id']);
            $result = $this->db->update('tags');

            if($result){
                return true;
            }
        }

        return false;
    }

    public function deleteTag($data){
        var_dump($data);
    	$sql = $this->db->delete('tags', array('id' => $data['id']));
    	if($sql){
    		return true;
    	}

    	return false;
    }
}