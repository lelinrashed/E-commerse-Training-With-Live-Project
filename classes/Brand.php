<?php 
	include_once '../lib/Database.php';
	include_once '../helpers/Format.php';

	class Brand
	{
		private $db;
		private $fm;

		public function __construct()
		{
			$this->db = new Database();
			$this->fm = new Format();
		}

		public function brandInsert($brandName)
		{
			$brandName = $this->fm->validation($brandName);
			$brandName = mysqli_real_escape_string($this->db->link, $brandName);

			if ($brandName == "") {
				$msg = "<span class='error'>Brand field must not be empty !</span>";
				return $msg;
			}else{
				$query = "INSERT INTO tbl_brand(brandName) VALUES('$brandName')";
				$brandInsert = $this->db->insert($query);
				if ($brandInsert) {
					$msg = "<span class='success'>Brand inserted successfully.</span>";
					return $msg;
				}else{
					$msg = "<span class='error'>Brand not inserted !</span>";
					return $msg;
				}
			}
		}

		public function getAllBrand()
		{
			$query = "SELECT * FROM tbl_brand ORDER BY brandId DESC";
			$result = $this->db->select($query);	
			return $result;
		}

		public function getBrandById($id)
		{
			$query = "SELECT * FROM tbl_brand WHERE brandId = '$id'";
			$result = $this->db->select($query);
			return $result;
		}

		public function catUpdate($brandName, $id)
		{
			$brandName = $this->fm->validation($brandName);
			$brandName = mysqli_real_escape_string($this->db->link, $brandName);
			$id = mysqli_real_escape_string($this->db->link, $id);

			if ($brandName == "") {
				$msg = "<span class='error'>Brand field must not be empty !</span>";
				return $msg;
			}else{
				$query = "UPDATE tbl_brand SET brandName = '$brandName' WHERE brandId = '$id'";
				$updated_row = $this->db->update($query);
				if ($updated_row) {
					$msg = "<span class='success'>Brand updated successfully.</span>";
					return $msg;
				}else{
					$msg = "<span class='error'>Brand not updated !</span>";
					return $msg;
				}
			}
		}

		public function delBrandById($id)
		{
			$query = "DELETE FROM tbl_brand WHERE brandId = '$id'";
			$deldata = $this->db->delete($query);
			if ($deldata) {
				$msg = "<span class='success'>Brand Deleted Successfully !</span>";
				return $msg;
			}else{
				$msg = "<span class='error'>Brand not Deleted !</span>";
				return $msg;
			}
		}


	}


 ?>