<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		// Chargement de la librarie assets
		$this->load->library('assets');
		
		// On recuper la vue dans une varibale page
		$page = $this->load->view('welcome_page', null, true);
		// exemple avec un header : $header = $this->load->view('header', null, true);
		
		// On ajoute tous les vues recuperer
		// pour le header $wrapper = "{$header}{$page}";
		$wrapper = "{$page}";
		
		// On utilise autoload pour charger les scripts definie dans la config/assets.php
		$scripts = $this->assets->get_autoload();
		
		// On ajoute des script manuellement '$this->assets->get_asset(file)'
		$script_js = array_merge($scripts['script_js'], []);
		$script_css = array_merge($scripts['script_css'], []);
		
		// On cree l'option qui servira au template
		$data_template =
		[
			'title' => 'title',
			'wrapper' => $wrapper,
			'script_js' => $script_js,
			'script_css' => $script_css
		];
		
		// On parse le vue base_template
		$this->parser->parse('base_template', $data_template);
	}
}
