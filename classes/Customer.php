<?php 
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../lib/Database.php');
	include_once ($filepath.'/../helpers/Format.php');

	class Customer
	{
		private $db;
		private $fm;

		public function __construct()
		{
			$this->db = new Database();
			$this->fm = new Format();
		}

		public function customerRegistration($data, $file)
		{
			$name = $this->fm->validation($data['name']);
			$address = $this->fm->validation($data['address']);
			$city = $this->fm->validation($data['city']);
			$country = $this->fm->validation($data['country']);
			$zip = $this->fm->validation($data['zip']);
			$phone = $this->fm->validation($data['phone']);
			$email = $this->fm->validation($data['email']);
			$pass = $this->fm->validation(md5($data['pass']));

			$name = mysqli_real_escape_string($this->db->link, $name);
			$address = mysqli_real_escape_string($this->db->link, $address);
			$city = mysqli_real_escape_string($this->db->link, $city);
			$country = mysqli_real_escape_string($this->db->link, $country);
			$zip = mysqli_real_escape_string($this->db->link, $zip);
			$phone = mysqli_real_escape_string($this->db->link, $phone);
			$email = mysqli_real_escape_string($this->db->link, $email);
			$pass = mysqli_real_escape_string($this->db->link, $pass);

			if ($name == "" || $address == "" || $city == "" || $country == "" || $zip == "" || $phone == "" || $email == "" || $pass == "") {
		    	$msg = "<span class='error'>Field must not be empty !</span>";
				return $msg;
		    }
		    $mailquery = "SELECT * FROM tbl_customer WHERE email = '$email' LIMIT 1";
		    $mailchk = $this->db->select($mailquery);
		    if ($mailchk != false) {
		    	$msg = "<span class='error'>Mail already exist !</span>";
				return $msg;
		    }else{
		    	$query = "INSERT INTO tbl_customer(name, address, city, country, zip, phone, email, pass)VALUES('$name','$address', '$city', '$country', '$zip', '$phone', '$email', '$pass')";
			    $inserted_rows = $this->db->insert($query);
			    if ($inserted_rows) {
			    	$msg = "<span class='success'>Customer data inserted successfully.</span>";
					return $msg;
			    }else {
			    	$msg = "<span class='error'>Customer data not inserted !</span>";
					return $msg;
			    }
		    }
		}
		
		public function customerLogin($data)
		{
			$email = $this->fm->validation($data['email']);
			$pass = $this->fm->validation(md5($data['pass']));

			$email = mysqli_real_escape_string($this->db->link, $email);
			$pass = mysqli_real_escape_string($this->db->link, $pass);

			if (empty($email) || empty($pass)) {
				$msg = "<span class='error'>Field must not be empty !</span>";
				return $msg;
			}

			$query = "SELECT * FROM tbl_customer WHERE email = '$email' AND pass = '$pass'";
			$result = $this->db->select($query);
			if ($result != false) {
				$value = $result->fetch_assoc();
				Session::set("Custlogin", true);
				Session::set("cmrId", $value['id']);
				Session::set("cmrName", $value['name']);
				header("Location:cart.php");
			}else{
				$msg = "<span class='error'>Email or Password not matched !</span>";
				return $msg;
			}
		}


		public function getCustomerData($id)
		{
			$query = "SELECT * FROM tbl_customer WHERE id = '$id'";
			$result = $this->db->select($query);
			return $result;
		}

		public function customerUpdate($data, $cmrId)
		{
			$name = $this->fm->validation($data['name']);
			$address = $this->fm->validation($data['address']);
			$city = $this->fm->validation($data['city']);
			$country = $this->fm->validation($data['country']);
			$zip = $this->fm->validation($data['zip']);
			$phone = $this->fm->validation($data['phone']);
			$email = $this->fm->validation($data['email']);

			$name = mysqli_real_escape_string($this->db->link, $name);
			$address = mysqli_real_escape_string($this->db->link, $address);
			$city = mysqli_real_escape_string($this->db->link, $city);
			$country = mysqli_real_escape_string($this->db->link, $country);
			$zip = mysqli_real_escape_string($this->db->link, $zip);
			$phone = mysqli_real_escape_string($this->db->link, $phone);
			$email = mysqli_real_escape_string($this->db->link, $email);

			if ($name == "" || $address == "" || $city == "" || $country == "" || $zip == "" || $phone == "" || $email == "") {
		    	$msg = "<span class='error'>Field must not be empty !</span>";
				return $msg;
		    }else{
		    	$query = "UPDATE tbl_customer SET
					    	name = '$name',
					    	address = '$address',
					    	city = '$city',
					    	country = '$country',
					    	zip = '$zip',
					    	phone = '$phone',
					    	email = '$email'
					    	WHERE id = '$cmrId'";
			    $updated_rows = $this->db->update($query);
			    if ($updated_rows) {
			    	$msg = "<span class='success'>User Data updated successfully.</span>";
					return $msg;
			    }else {
			    	$msg = "<span class='error'>User Data not updated !</span>";
					return $msg;
			    }
		    }
		}





	}
 ?>