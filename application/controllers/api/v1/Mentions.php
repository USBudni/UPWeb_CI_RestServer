<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . 'libraries/REST_Controller.php';

class Mentions extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['Mentions_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['Mentions_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['Mentions_delete']['limit'] = 50; // 50 requests per hour per user/key
    }

    public function Mentions_get()
    {

        $id = $this->get('id');
              
        // If the id parameter doesn't exist return all the Mentions

        $this->load->model('Mentions_model');   
        if ($id == NULL)
        {        
            $MentionsArray = $this->Mentions_model->getMentions();
            if ($MentionsArray == NULL)
            {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No Mentions were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
            else
            {
                $this->response($MentionsArray, REST_Controller::HTTP_OK);
            }
        }

        // Find and return a single record for a particular user.

        $id = (int) $id;

        // Validate the id.
        if ($id <= 0)
        {
            // Invalid id, set the response and exit.
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        // Get the user from the array, using the id as key for retrieval.
        // Usually a model is to be used for this.

        $tag = NULL;
        $Mentions = $this->Mentions_model->getMentions();        
        if (!empty($Mentions))
        {
            foreach ($Mentions as $key => $value)
            {
                if (isset($value['id']) && (int)$value['id'] === $id)
                {
                    $tag = $value;
                }
            }
        }
        
        if (!empty($tag))
        {
            $this->set_response($tag, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
        else
        {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Mention(s) nao encontrada(s)'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }    

}
