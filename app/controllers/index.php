<?php 

class Index extends Dcontroller{
	public $categoryModel;
	public $productModel;
	
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$this->homePage();
	}

	public function homePage() {
		$this->load->view('header');
		$this->load->view('home');
        $this->load->view('footer');
	}

	public function notfound() {
		$this->load->view('header');
		$this->load->view('404');
        $this->load->view('footer');
	}
}

?>