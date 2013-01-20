<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Session data query API
 *
 * This controller is design for match/destroy sessions.
 * The "session" doesn't saved on server/client or browser.
 * It was encode and encrypt saved in database , so it's very safe.
 *
 * @package		CodeIgniter
 * @subpackage	UDSync
 * @author 		a20968
 * @category	Controller
 * @link 		https://github.com/a20968/UDSync
*/

class Session extends CI_Controller
{
	function session_match( $hash = null , $appid = null , $appkey = null) //Set default value
	{
		if( !$hash || !$appid || !$appkey) //Verify value is exist
		{
			$data = array('json' => $this->json->create_message('1','Value error'));//Returned an error message
			$this->load->view('api/json_view',$data); //Load view file
		}

		$this->load->model('Application_data'); //Load application model
		$this->load->model('Session_data'); //Load session model

		if( $this->Application_data->match_app( $appid , $appkey ) == 1 ) //Make sure request was sent by registered client
		{
		$match = $this->Session_data->match_session( $hash );

		if( $this->Session_data->match_session( $hash ) == FALSE )
		{
			$data = array('json' => $this->json->create_message('2','No match'));//Returned level 2 message(other)
			$this->load->view('api/json_view',$data); //Load view file
		} else {
			$data = array('json' => $this->json->create_message('0',$match));//Returned level 2 message(other)
			$this->load->view('api/json_view',$data); //Load view file
		}	
		} else {
			echo $this->json->create_message('3','Unauthorized access'); //Returned unauthorized error
			$this->load->view('api/json_view',$data); //Load view file
		}
	}
}