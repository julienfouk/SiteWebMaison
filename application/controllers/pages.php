<?php

class Pages extends CI_Controller{
	
	//page de démarrage 
	//rerouter par la route par défaut
	function view($page = 'home')
	{
		
		if( !file_exists('application/views/pages/'.$page.'.php'))
		{
			show_404();
		}
		
		$this->load->view('pages/'.$page);
		//echo $page;
	}
	
	//gestion des mails
	function mail($page='mail')
	{
		if( !file_exists('application/views/pages/'.$page.'.php'))
		{
			show_404();
		}
		
		$this->load->library('email');
		$this->load->view('pages/'.$page);
	}
	
}


?>