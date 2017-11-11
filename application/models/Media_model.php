<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Media_model extends CI_Model {
	public function __construct(){
        parent::__construct();
        // Your own constructor code
    }

    public function getMedias(){
    	$query = $this->db->get('media');
    	$row = array();

    	if(count($query->result_array()) > 0){
    		foreach ($query->result_array() as $key => $media){
				$row[$key] = $media;
			}
			return $row;
    	}
		

		return false;
    }

    public function getMedia($data){
    	$row = Array();
    	$query = $this->db->query('select * from media where id = ?', $data['id']);

    	if(count($query->result_array()) > 0){
    		foreach ($query->result_array() as $key => $media){
                $row[$key]['id'] = $media['id'];
		        $row[$key]['nome'] = $media['nome'];
		        $row[$key]['url_twitter'] = $media['url_twitter'];
		        $row[$key]['url_instagram'] = $media['url_instagram'];
		        $row[$key]['is_twitter'] = $media['is_twitter'];
		        $row[$key]['is_instagram'] = $media['is_instagram'];
		        $row[$key]['is_mentions'] = $media['is_mentions'];
		        $row[$key]['is_hashtags'] = $media['is_hashtags'];
			}
		}

    	return $row;
    }

    public function saveMedia($data){
        $newMedia = Array(
            'nome' => $data['media']['nome'],
            'is_instagram' => $data['media']['is_instagram'],
            'is_twitter' => $data['media']['is_twitter'],
            'is_mentions' => $data['media']['is_mentions'],
            'is_hashtags' => $data['media']['is_hashtags'],
            'url_instagram' => $data['media']['url_instagram'],
            'url_twitter' => $data['media']['url_twitter'],
        );

        $sql = $this->db->insert('media', $newMedia);
        if($sql){
            return true;
        }

        return false;

    }

    public function updateMedia($data){
        $select = $this->db->query('select * from media where id = ?', $data['media']['id']);
        if(count($select->result_array()) > 0){
            $this->db->set('nome', $data['media']['nome']);
            $this->db->set('url_instagram', $data['media']['url_instagram']);
            $this->db->set('url_twitter', $data['media']['url_twitter']);
            $this->db->set('is_twitter', $data['media']['is_twitter']);
            $this->db->set('is_instagram', $data['media']['is_instagram']);
            $this->db->set('is_mentions', $data['media']['is_mentions']);
            $this->db->set('is_hashtags', $data['media']['is_hashtags']);

            $this->db->where('id', $data['media']['id']);
            $result = $this->db->update('media');

            if($result){
                return true;
            }
        }

        return false;
    }

    public function deleteMedia($data){
    	$sql = $this->db->delete('media', array('id' => $data['id']));
    	if($sql){
    		return true;
    	}

    	return false;
    }
}