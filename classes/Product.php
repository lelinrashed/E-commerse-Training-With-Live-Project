<?php 
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../lib/Database.php');
	include_once ($filepath.'/../helpers/Format.php');

	class Product
	{
		private $db;
		private $fm;

		public function __construct()
		{
			$this->db = new Database();
			$this->fm = new Format();
		}

		public function productInsert($data, $file)
		{
			$productName = $this->fm->validation($data['productName']);
			$catId = $this->fm->validation($data['catId']);
			$brandId = $this->fm->validation($data['brandId']);
			$body = $this->fm->validation($data['body']);
			$price = $this->fm->validation($data['price']);
			$type = $this->fm->validation($data['type']);

			$productName = mysqli_real_escape_string($this->db->link, $productName);
			$catId = mysqli_real_escape_string($this->db->link, $catId);
			$brandId = mysqli_real_escape_string($this->db->link, $brandId);
			$body = mysqli_real_escape_string($this->db->link, $body);
			$price = mysqli_real_escape_string($this->db->link, $price);
			$type = mysqli_real_escape_string($this->db->link, $type);

			$permited  = array('jpg', 'jpeg', 'png', 'gif');
		    $file_name = $file['image']['name'];
		    $file_size = $file['image']['size'];
		    $file_temp = $file['image']['tmp_name'];

		    $div = explode('.', $file_name);
		    $file_ext = strtolower(end($div));
		    $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
		    $uploaded_image = "uploads/".$unique_image;

		    if ($productName == "" || $catId == "" || $brandId == "" || $body == "" || $price == "" || $file_name == "" || $type == "") {
		    	$msg = "<span class='error'>Product field must not be empty !</span>";
				return $msg;
		    }elseif ($file_size >1048567) {
		     	echo "<span class='error'>Image Size should be less then 1MB!</span>";
		    } elseif (in_array($file_ext, $permited) === false) {
		     	echo "<span class='error'>You can upload only:-".implode(', ', $permited)."</span>";
		    } else{
		    	move_uploaded_file($file_temp, $uploaded_image);
			    $query = "INSERT INTO tbl_product(productName, catId, brandId, body, price, image, type)VALUES('$productName','$catId', '$brandId', '$body', '$price', '$uploaded_image', '$type')";
			    $inserted_rows = $this->db->insert($query);
			    if ($inserted_rows) {
			    	$msg = "<span class='success'>Product inserted successfully.</span>";
					return $msg;
			    }else {
			    	$msg = "<span class='error'>Product not inserted !</span>";
					return $msg;
			    }
		    }
		}

		public function getAllProduct()
		{
			// $query = "SELECT tbl_product.*,
			// tbl_category.catName,tbl_brand.brandName
			// FROM tbl_product
			// INNER JOIN tbl_category
			// ON tbl_product.catId = tbl_category.catId
			// INNER JOIN tbl_brand
			// ON tbl_product.brandId = tbl_brand.brandId
			// ORDER BY tbl_product.productId DESC";

			$query = "SELECT p.*, c.catName, b.brandName
			FROM tbl_product as p, tbl_category as c, tbl_brand as b
			WHERE p.catId = c.catId AND p.brandId = b.brandId
			ORDER BY p.productId DESC";
			$result = $this->db->select($query);
			return $result;
		}

		public function getProById($id)
		{
			$query = "SELECT * FROM tbl_product WHERE productId = '$id'";
			$result = $this->db->select($query);
			return $result;
		}


		public function productUpdate($data, $file, $id)
		{
			$productName = $this->fm->validation($data['productName']);
			$catId = $this->fm->validation($data['catId']);
			$brandId = $this->fm->validation($data['brandId']);
			$body = $this->fm->validation($data['body']);
			$price = $this->fm->validation($data['price']);
			$type = $this->fm->validation($data['type']);

			$productName = mysqli_real_escape_string($this->db->link, $productName);
			$catId = mysqli_real_escape_string($this->db->link, $catId);
			$brandId = mysqli_real_escape_string($this->db->link, $brandId);
			$body = mysqli_real_escape_string($this->db->link, $body);
			$price = mysqli_real_escape_string($this->db->link, $price);
			$type = mysqli_real_escape_string($this->db->link, $type);

			$permited  = array('jpg', 'jpeg', 'png', 'gif');
		    $file_name = $file['image']['name'];
		    $file_size = $file['image']['size'];
		    $file_temp = $file['image']['tmp_name'];

		    $div = explode('.', $file_name);
		    $file_ext = strtolower(end($div));
		    $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
		    $uploaded_image = "uploads/".$unique_image;

		    if ($productName == "" || $catId == "" || $brandId == "" || $body == "" || $price == "" || $type == "") {
		    	$msg = "<span class='error'>Product field must not be empty !</span>";
				return $msg;
		    }else{
		    	if (!empty($file_name)) {
		    		if ($file_size >1048567) {
				     	echo "<span class='error'>Image Size should be less then 1MB!</span>";
				    } elseif (in_array($file_ext, $permited) === false) {
				     	echo "<span class='error'>You can upload only:-".implode(', ', $permited)."</span>";
				    } else{
				    	move_uploaded_file($file_temp, $uploaded_image);
				    	$query = "UPDATE tbl_product SET
					    	productName = '$productName',
					    	catId = '$catId',
					    	brandId = '$brandId',
					    	body = '$body',
					    	price = '$price',
					    	image = '$uploaded_image',
					    	type = '$type'
					    	WHERE productId = '$id'
			    	  	";
					    $updated_rows = $this->db->update($query);
					    if ($updated_rows) {
					    	$msg = "<span class='success'>Product updated successfully.</span>";
							return $msg;
					    }else {
					    	$msg = "<span class='error'>Product not updated !</span>";
							return $msg;
					    }
				    }
		    	}else{
		    		$query = "UPDATE tbl_product SET
				    	productName = '$productName',
				    	catId = '$catId',
				    	brandId = '$brandId',
				    	body = '$body',
				    	price = '$price',
				    	type = '$type'
				    	WHERE productId = '$id'
		    	  	";
				    $updated_rows = $this->db->update($query);
				    if ($updated_rows) {
				    	$msg = "<span class='success'>Product updated successfully.</span>";
						return $msg;
				    }else {
				    	$msg = "<span class='error'>Product not updated !</span>";
						return $msg;
				    }
		    	}
		    	
		    }
		    
		}


		public function delProById($id)
		{

			$query = "SELECT * FROM tbl_product WHERE productId = '$id'";
			$getData = $this->db->select($query);
			if ($getData) {
				while ($delImg = $getData->fetch_assoc()) {
					$dellink = $delImg['image'];
					unlink($dellink);
				}
			}


			$query = "DELETE FROM tbl_product WHERE productId = '$id'";
			$deldata = $this->db->delete($query);
			if ($deldata) {
				$msg = "<span class='success'>Product Deleted Successfully !</span>";
				return $msg;
			}else{
				$msg = "<span class='error'>Product not Deleted !</span>";
				return $msg;
			}
		}


		public function getFeaturedProduct()
		{
			$query = "SELECT * FROM tbl_product WHERE type = '0' ORDER BY productId DESC LIMIT 4";
			$result = $this->db->select($query);
			return $result;
		}


		public function getNewProduct()
		{
			$query = "SELECT * FROM tbl_product ORDER BY productId DESC LIMIT 4";
			$result = $this->db->select($query);
			return $result;
		}



		public function getSingleProduct($id)
		{
			$query = "SELECT p.*, c.catName, b.brandName
			FROM tbl_product as p, tbl_category as c, tbl_brand as b
			WHERE p.catId = c.catId AND p.brandId = b.brandId AND p.productId = '$id'";
			$result = $this->db->select($query);
			return $result;
		}



		public function latestFromIphone()
		{
			$query = "SELECT * FROM tbl_product WHERE brandId = '1' ORDER BY productId DESC LIMIT 1";
			$result = $this->db->select($query);
			return $result;
		}

		public function latestFromSamsung()
		{
			$query = "SELECT * FROM tbl_product WHERE brandId = '3' ORDER BY productId DESC LIMIT 1";
			$result = $this->db->select($query);
			return $result;
		}

		public function latestFromAcer()
		{
			$query = "SELECT * FROM tbl_product WHERE brandId = '5' ORDER BY productId DESC LIMIT 1";
			$result = $this->db->select($query);
			return $result;
		}

		public function latestFromCanon()
		{
			$query = "SELECT * FROM tbl_product WHERE brandId = '4' ORDER BY productId DESC LIMIT 1";
			$result = $this->db->select($query);
			return $result;
		}


		public function productByCat($id)
		{
			$id = mysqli_real_escape_string($this->db->link, $id);
			$query = "SELECT * FROM tbl_product WHERE catId = '$id'";
			$result = $this->db->select($query);
			return $result;
		}



	}
 ?>