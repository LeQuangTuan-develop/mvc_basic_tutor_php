<?php 

class Dmodel {

	protected $db = array();

	public function __construct() {
		$conn = 'mysql:dbname=quanlysanpham;host=localhost';
		$user = 'root';
		$pass = '';
		$this->db = new Database($conn, $user, $pass);
	}
}

?>