<?php 
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../lib/Database.php');
	include_once ($filepath.'/../helpers/Format.php');

	class Category
	{

		private $db;
		private $fm;

		public function __construct()
		{
			$this->db = new Database();
			$this->fm = new Format();
		}

		public function catInsert($catName)
		{
			$catName = $this->fm->validation($catName);
			$catName = mysqli_real_escape_string($this->db->link, $catName);

			if ($catName == "") {
				$msg = "<span class='error'>Category field must not be empty !</span>";
				return $msg;
			}else{
				$query = "INSERT INTO tbl_category(catName) VALUES('$catName')";
				$catInsert = $this->db->insert($query);
				if ($catInsert) {
					$msg = "<span class='success'>Category inserted successfully.</span>";
					return $msg;
				}else{
					$msg = "<span class='error'>Category not inserted !</span>";
					return $msg;
				}
			}

		}


		public function getAllCat()
		{
			$query = "SELECT * FROM tbl_category ORDER BY catId DESC";
			$result = $this->db->select($query);
			return $result;
		}


		public function getCatById($id)
		{
			$query = "SELECT * FROM tbl_category WHERE catId = '$id'";
			$result = $this->db->select($query);
			return $result;
		}


		public function catUpdate($catName, $id)
		{
			$catName = $this->fm->validation($catName);
			$catName = mysqli_real_escape_string($this->db->link, $catName);
			$id = mysqli_real_escape_string($this->db->link, $id);

			if ($catName == "") {
				$msg = "<span class='error'>Category field must not be empty !</span>";
				return $msg;
			}else{
				$query = "UPDATE tbl_category SET catName = '$catName' WHERE catId = '$id'";
				$updated_row = $this->db->update($query);
				if ($updated_row) {
					$msg = "<span class='success'>Category updated successfully.</span>";
					return $msg;
				}else{
					$msg = "<span class='error'>Category not updated !</span>";
					return $msg;
				}
			}
		}


		public function delCatById($id)
		{
			$query = "DELETE FROM tbl_category WHERE catId = '$id'";
			$deldata = $this->db->delete($query);
			if ($deldata) {
				$msg = "<span class='success'>Category Deleted Successfully !</span>";
				return $msg;
			}else{
				$msg = "<span class='error'>Category not Deleted !</span>";
				return $msg;
			}
		}


	}
 ?>