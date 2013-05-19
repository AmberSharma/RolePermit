<!--  ************************** Creation Log ***************************** -->
<!-- * File Name - classes.validation -->
<!-- * Name - Open -->
<!-- * Description - Class file for validation -->
<!-- * Version - 1.0 Created by - Debanshu Kar & Gaurav Kumar Sharma -->
<!-- * Created on - March 27, 2013 -->
<!-- * ************************** Update Log ****************************** -->
<!-- * Sr.NO. Version Updated by Updated on Description -->
<!-- * ----------------------------------------------------------------------- -->
<!-- * 1 1.0 Debanshu Kar April 04, 2013 -->
<!-- * ********************************************************************** -->


<?php
class validate {
	protected $errName;
	public function is_validFloat($float, $min = 0, $max = 32767) {
		if (filter_var ( $float, FILTER_VALIDATE_FLOAT )) {
			if ($float <= $max && $float >= $min)
				return true;
			else {
				$_SESSION ["msgErrors"] ['int'] = 'Not  valid value.';
				return false;
			}
		} else {
			$_SESSION ["msgErrors"] ['int'] = 'Not  valid value.';
			return false;
		}
	}
	public function is_validInt($int, $min = 0, $max = 32767) {
		$int_options = array (
				"options" => array (
						"min_range" => $min,
						"max_range" => $max 
				) 
		);
		if ($int === 0 && $min <= 0 && $max >= 0)
			return true;
		
		if (! filter_var ( $int, FILTER_VALIDATE_INT, $int_options )) {
			$_SESSION ["msgErrors"] ['int'] = 'Not  valid value.';
			return false;
		} else {
			return true;
		}
	}
	public function is_validName($name) {
		$error = "";
		$name = filter_var ( $name, FILTER_SANITIZE_STRING );
		
		if (preg_match ( "/^[A-Z][a-zA-Z ']+$/", $name ) == 0)
			$error = "error";
		
		if (! empty ( $error )) {
			$_SESSION ["msgErrors"] [] = '<p class="errText">Name must be from letters, spaces and must not start with dash</p>';
			
			return false;
		} else
			return $name;
	}
	public function is_validUserName($userName) {
		$error = "";
		
		$userName = filter_var ( $userName, FILTER_SANITIZE_STRING );
		
		if (preg_match ( "/^[A-Za-z][a-zA-Z0-9_]+$/", $userName ) == 0)
			$error = "error";
		
		if (! empty ( $error )) {
			$_SESSION ["msgErrors"] [] = '<p class="errText">UserName must be from letters, underscore and must  start with letters</p>';
			
			return false;
		} else
			return $userName;
	}
	public function is_validAddress($address) {
		$error = "";
		
		$address = filter_var ( $address, FILTER_SANITIZE_STRING );
		
		
		if (! empty ( $error )) {
			$_SESSION ["msgErrors"] [] = '<p class="errText">Must be only letters, numbers or one of the following _ - . , : " ' . "'</p>";
			
			return false;
		} else
			return $address;
	}
	public function is_validEmail($email) {
		$error = "";
		
		$email = filter_var ( $email, FILTER_SANITIZE_STRING );
		
		if (! filter_var ( $email, FILTER_VALIDATE_EMAIL )) {
			
			$_SESSION ["msgErrors"] [] = '<p class="errText">Email must comply with this mask: chars(.chars)@chars(.chars).chars(2-4)</p>';
			return false;
		} 

		else
			return $email;
	}
	public function is_validPassword($password) {
		$error = "";
		
		$password = filter_var ( $password, FILTER_SANITIZE_STRING );
		if (preg_match ( "/^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/", $password ) == 0) {
			$_SESSION ["msgErrors"] [] = '<p class="errText">Password must be at least 8 characters and must contain at least one lower case letter, one upper case letter and one digit</p>';
			
			return false;
		} else
			return $password;
	}
	public function is_validDOB($dob) {
		$dob = filter_var ( $dob, FILTER_SANITIZE_STRING );
		$date = date_parse ( $dob );
		if ($date ['error_count'] == 0) { // or date_parse_from_format("d/m/Y", $date);
			if (checkdate ( $date ['month'], $date ['day'], $date ['year'] )) {
				if (date ( 'y' ) > $date ['year'] && ((date ( 'y' ) - $date ['year']) > 15 && (date ( 'y' ) - $date ['year']) < 80)) {
					
					return $dob;
				} else {
					$_SESSION ["msgErrors"] [] = "your age must be greater than 15 and less than 80.";
				}
			}
		} else
			return false;
	}
	public function is_validPhone($phone) {
		$phone = filter_var ( $phone, FILTER_SANITIZE_STRING );
		if (preg_match ( "/^[7-9][0-9]{9}$/", $phone ) == 0) {
			$_SESSION ["msgErrors"] [] = '<p class="errText">Phone Number must  comply with this mask: first digit greater than 6 and number must be 10 digits.</p>';
			
			return false;
		} else
			return $phone;
	}
}

?>