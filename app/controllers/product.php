<?php 

class Product extends Dcontroller{
	public $productModel;

	function __construct() {
		parent::__construct();
		$this->productModel = $this->load->model('productModel');
	}

	public function index(){
		$this->list_products();
	}

	public function list_products() {
		$data['products'] = $this->productModel->getProducts();

		$this->load->view('header');
		$this->load->view('list_products', $data);
		$this->load->view('footer');
	}

    public function edit_product($id) {
		$cond = "product_id='$id'";
		
		$this->load->view('header');
		$this->load->view('update_product');
		$this->load->view('footer');
	}

	public function add_product() {
		$this->load->view('header');
		$this->load->view('add_product');
		$this->load->view('footer');
	}

	public function insert_product() {
		$name = $_POST['productName'];
		$code = $_POST['SKU'];
		$description = $_POST['description'];
		$price = floatval($_POST['productPrice']);
		$supplier = $_POST['supplierProductId'];
		// $quantity = $_POST['quantity_product'];
		$categoryId = $_POST['categoryProductId'];

		// $image = $_FILES['image_product']['name'];
		// $tmp_image = $_FILES['image_product']['tmp_name'];

		// $div = explode('.' , $image);
		// $file_ext = strtolower(end($div));
		// $unique_image = $div[0].time().'.'.$file_ext;

		// $path_uploads = "public/uploads/product/".$unique_image;

		$data =  array(
			'product_name'     => $name,
			'product_code'     => $code,
			'description'      => $description,
			'list_price'       => $price,
			'supplier_id'          => $supplier,
			// 'quantity_product' => $quantity,
			'category_id'      => $categoryId
		);

		$result = $this->productModel->insertProduct($data);
		if ($result == 1) {
			// move_uploaded_file($tmp_image, $path_uploads);
			$message['msg'] = "Thêm sản phẩm thành công";
			header('Location: '.BASE_URL.'/product/list_product?msg='.urlencode(serialize($message)));
		} else {
			$message['msg'] = "Thêm sản phẩm thất bại";
			header('Location: '.BASE_URL.'/product/list_product?msg='.urlencode(serialize($message)));
		}
	}


	public function update_product($id) {
		$cond = "product_id ='$id'";
		$imageOfProduct = $this->productImageModel->getImagesOfProductById($cond);
		$productbyId = $this->productModel->getproductById($cond);
			
		$data = json_decode($_POST['data'], true);

		$countNewImg = count($data['imgListName']);
		$countOldImg = count($imageOfProduct);

		$name = $data['productName'];
		$code = $data['SKU'];
		$description = $data['description'];
		$price = $data['productPrice'];
		$supplier = $data['supplierProductId'];
		// $quantity = $data['quantity_product'];
		$categoryId = $data['categoryProductId'];

		if (isset($_FILES)) {
				
			// tạm thời chưa xử lý được vì nhiều vấn đề về cách lưu dữ liệu trong db
			if ($countOldImg + 1 > $countNewImg) {
				$image = $_FILES['file']['name'];
				unlink("public/uploads/product/".$productbyId[0]['image_product']);

				$tmp_image = $_FILES['image_product']['tmp_name'];
				$div = explode('.' , $image);
				$file_ext = strtolower(end($div));
				$unique_image = $div[0].time().'.'.$file_ext;
				$path_uploads = "public/uploads/product/".$unique_image;

				$data =  array(
					'product_name'     => $name,
					'product_code'     => $code,
					'description'      => $description,
					'list_price'       => $price,
					'supplier_id'          => $supplier,
					// 'quantity_product' => $quantity,
					'image_product'    => $unique_image,
					'category_id'      => $categoryId
				);
				move_uploaded_file($tmp_image, $path_uploads);
			}

			foreach ($_FILES as $file) {
				$image = $file['name'];
				$tmp_image = $file['tmp_name'];
				$div = explode('.' , $image);
				$file_ext = strtolower(end($div));
				$unique_image = $div[0].time().'.'.$file_ext;
				$path_uploads = "./public/images/products/".$unique_image;

				$imgData = array(
					"product_id" => $id,
					"image" 	 => $unique_image
				);
				$this->productImageModel->insertImageOfProduct($imgData);
				move_uploaded_file($tmp_image, $path_uploads);
			}
			
		} 

		$data =  array(
			'product_name'     => $name,
			'product_code'     => $code,
			'description'      => $description,
			'list_price'       => $price,
			'supplier_id'          => $supplier,
			// 'quantity_product' => $quantity,
			'category_id'      => $categoryId
		);

		$result = $this->productModel->updateProduct($data, $cond);

		if ($result == 1) {
			$message = array(
				"status" => "1"
			);
		} else {
			$message = array(
				"status" => "0"
			);
		}

		exit(json_encode($message));
	}

	public function delete_product($id) {
		$today = date("Y-m-d h:i:s");
		$data = array( 'deleted_at' =>  $today);
		if ($id == "all") {
			$dataCheck = $_POST['productCheckbox'];
			$stringId = implode(",", $dataCheck);
			$cond = "product_id IN ($stringId)";
			$deleteproduct = $this->productModel->updateProduct($data, $cond);
		} else {
			$cond = "product_id='$id'";
			$deleteproduct = $this->productModel->updateProduct($data, $cond);
		}

		if ($deleteproduct) {
			$message= "xóa sản phẩm thành công";
		} else {
			$message= "xóa sản phẩm thất bại";
		}

		// unlink("public/uploads/product/".$product[0]['image_product']);
		// $result = $this->productModel->deleteProduct($table, $cond);

		header("Location: ".BASE_URL."/product/list_products");
	}
}
?>