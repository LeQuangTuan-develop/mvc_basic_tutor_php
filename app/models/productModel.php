<?php 

	class productModel extends Dmodel {
		public $table = 'sanpham';
		
		public function __construct() {
			parent::__construct();
		}

		public function getProducts() {
			$sql = "SELECT * FROM $this->table";
			return $this->db->select($sql);
		} 

		public function getProductById($cond) {
			$sql = "SELECT * FROM $this->table WHERE $cond AND deleted_at IS NULL";
			return $this->db->select($sql);
		}

		public function getProductsByCategory($cond) {
			$sql = "SELECT * FROM $this->table WHERE $cond AND deleted_at IS NULL";
			return $this->db->select($sql);
		}

		public function getProductsTopNew() {
			$sql = "SELECT * FROM $this->table WHERE is_new = 1 AND deleted_at IS NULL ORDER BY created_at DESC LIMIT 4";
			return $this->db->select($sql);
		} 

		public function getProductsTrend() {
			$sql = "SELECT * FROM $this->table WHERE deleted_at IS NULL ORDER BY view DESC LIMIT 4";
			return $this->db->select($sql);
		} 

		public function getProductsSearch($search, $cond = "") {
			if ($cond != "") {
				$sql = "SELECT * FROM $this->table WHERE product_name LiKE '%$search%' AND $cond";
				return $this->db->select($sql);
			}
			$sql = "SELECT * FROM $this->table WHERE product_name LiKE '%$search%'";
			return $this->db->select($sql);
		}

		public function insertProduct( $data) {
			return $this->db->insert($this->table, $data);
		}

		public function updateProduct( $data, $cond) {
			return $this->db->update($this->table, $data, $cond);
		}

		public function increaseView($increase,  $cond) {
			$sql = "UPDATE $this->table SET view = view + $increase WHERE $cond";
			return $this->db->updateBySQL($sql);
		}

		public function deleteProduct($cond) {
			return $this->db->delete($this->table, $cond);
		}

		public function insertProduct_post($data) {
			return $this->db->insert($this->table, $data);
		}
	}

?>