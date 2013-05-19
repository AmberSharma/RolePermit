<?php
require_once 'model.php';
ini_set ( "display_error", 'on' );
class Register extends model {
	protected $id;
	protected $userName;
	protected $userType;
	protected $password;
	protected $firstName;
	protected $lastName;
	protected $address;
	protected $email;
	protected $phoneNo;
	protected $gender;
	protected $dob;
	protected $collegeOrCompany;
	protected $name;
	public function getName() {
		return $this->name;
	}
	public function setName($name) {
		$this->name = $name;
	}
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
	}
	public function getUserName() {
		return $this->userName;
	}
	public function setUserName($userName) {
		$this->userName = $userName;
	}
	public function getUserType() {
		return $this->userType;
	}
	public function setUserType($userType) {
		$this->userType = $userType;
	}
	public function getPassword() {
		return $this->password;
	}
	public function setPassword($password) {
		$this->password = $password;
	}
	public function getFirstName() {
		return $this->firstName;
	}
	public function setFirstName($firstName) {
		$this->firstName = $firstName;
	}
	public function getLastName() {
		return $this->lastName;
	}
	public function setLastName($lastName) {
		$this->lastName = $lastName;
	}
	public function getAddress() {
		return $this->address;
	}
	public function setAddress($address) {
		$this->address = $address;
	}
	public function getEmail() {
		return $this->email;
	}
	public function setEmail($email) {
		$this->email = $email;
	}
	public function getPhoneNo() {
		return $this->phoneNo;
	}
	public function setPhoneNo($phoneNo) {
		$this->phoneNo = $phoneNo;
	}
	public function getGender() {
		return $this->gender;
	}
	public function setGender($gender) {
		$this->gender = $gender;
	}
	public function getDob() {
		return $this->dob;
	}
	public function setDob($dob) {
		$this->dob = $dob;
	}
	public function getCollegeOrCompany() {
		return $this->collegeOrCompany;
	}
	public function setCollegeOrCompany($collegeOrCompany) {
		$this->collegeOrCompany = $collegeOrCompany;
	}
	public function FindRole(){
    	$this->db->Fields(array("id","role"));
    	$this->db->From("roles");
    	$this->db->Select ();
    	$result = $this->db->resultArray ();
    	return $result;
    
    }
    public function FindUser(){
    	$this->db->Fields(array("id","name"));
    	$this->db->From("users");
    	$this->db->Select ();
    	$result = $this->db->resultArray ();
    	return $result;
    
    }
    
    public function addUser(){
    	
    	$this->db->Fields(array("role_id"=>$_REQUEST['role']));
    	$this->db->From("users");
    	$this->db->where(array("id"=>$_REQUEST['user']));
    	
    	if($this->db->update ())
    	{
    		
    		return("updated");
    	}
    	//return $result;
    
    }
    
    public function FindScreen(){
    	
    	
    	$this->db->Fields(array("screen_id","permit"));
    	$this->db->From("defaultroles");
    	$this->db->where(array("role_id"=>$_REQUEST['role']));
    	$this->db->Select ();
    	$result = $this->db->resultArray ();
    	
    	//echo "<pre>";
    	//print_r($result);
    	$this->db->Fields(array("name"));
    	$this->db->From("screens");
    	$this->db->Select ();
    	$result1 = $this->db->resultArray ();
    	$_SESSION['count'] = count($result1);
    	return array("permission"=>$result,"screens"=>$result1); 
    
    }

    public function fetchScreen(){
    	
	$this->db->Fields(array("role_id","screen_id","permit"));
    	$this->db->From("users");
    	$this->db->where(array("id"=>$_REQUEST['user']));
    	$this->db->Select ();
    	$result = $this->db->resultArray ();
    	if($result[0]['role_id'] == 0)
	{
		if($result[0]['screen_id'] == 0)
		{
    			$this->db->Fields(array("name"));
    			$this->db->From("screens");
    			$this->db->Select ();
    			$result1 = $this->db->resultArray ();
			return $result1;
    			//$_SESSION['count'] = count($result1);
    			//return array("permission"=>$result,"screens"=>$result1);
		}
	}
    		//$this->db->Fields(array("screen_id","permit"));
    		//$this->db->From("defaultroles");
    		//$this->db->where(array("role_id"=>$_REQUEST['role']));
    		//$this->db->Select ();
    		//$result = $this->db->resultArray ();
    	//echo "<pre>";
    	//print_r($result);
    	 
    
    }


	public function addpermissionform(){
    	
	$this->db->Fields(array("id","name"));
    	$this->db->From("screens");
    	//$this->db->where(array("id"=>$_REQUEST['user']));
    	$this->db->Select ();
    	$result = $this->db->resultArray ();
	$_SESSION['count'] = count($result);
    	return $result;			
    	 
    
    }

	public function addRole()
	{
    	
	$this->db->Fields(array("role_id"=>$_REQUEST['role']));
    	$this->db->From("users");
    	$this->db->where(array("id"=>$_REQUEST['user']));
    	if($this->db->update ())
	{
		
    		return "1";
	}			
    	}

	public function deleteRole()
	{
    	
	$this->db->Fields(array("role_id"=>" "));
    	$this->db->From("users");
    	$this->db->where(array("id"=>$_REQUEST['user']));
    	if($this->db->update ())
	{
    		return "1";
	}			
    	}

	public function deleteDefault()
	{
    	
	//$this->db->Fields(array("role_id"=>" "));
    	$this->db->From("userpermission");
    	$this->db->where(array("role_id"=>" " , "user_id"=>$_REQUEST['user']));
    	if($this->db->Delete ())
	{
		
    		return "1";
	}			
    	}
    
public function addpermission($value)
{
	
    	for($i=0;$i<$_SESSION['count'];$i++)
    	{
    		$add="";
    		if(!empty($value['add']))
    		{
    			if(isset($value['add'][$i]))
    			{
    				$add.="1".",";
    			}
    			else
    			{
    				$add.="0".",";
    			}
    		}
    		else
    		{
    			$add.="0".",";
    		}
    		if(!empty($value['edit']))
    		{
    			if(isset($value['edit'][$i]))
    			{
    				$add.="1".",";
    			}
    			else
    			{
    				$add.="0".",";
    			}
    		}
    		else
    		{
    			$add.="0".",";
    		}
    		if(!empty($value['delete']))
    		{
    			if(isset($value['delete'][$i]))
    			{
    				$add.="1".",";
    			}
    			else
    			{
    				$add.="0".",";
    			}
    		}
    		else
    		{
    			$add.="0".",";
    		}
    		if(!empty($value['view']))
    		{
    			if(isset($value['view'][$i]))
    			{
    				$add.="1";
    			} 
    			else
    			{
    				$add.="0";
    			}
    		}
    		else
    		{
    			$add.="0";
    		}
		echo "<br/>";
    		$k=$i+1;
    		$this->db->Fields(array("permit"));
    		$this->db->From("userpermission");
		if(empty($_REQUEST['role']))
		{
			$this->db->where(array("screen_id"=>$k , "user_id"=>$_REQUEST['user']));
		}
		else
		{
    			$this->db->where(array("role_id"=>$_REQUEST['role'],"screen_id"=>$k , "user_id"=>$_REQUEST['user']));
		}
    		$this->db->Select ();
    		//echo $this->db->lastQuery();die;
    		if($this->db->resultArray ())
    		{
    			
    			$this->db->Fields(array("permit"=>$add));
    			$this->db->From("userpermission");
			if(empty($_REQUEST['role']))
			{
				$this->db->where(array("user_id"=>$_REQUEST['user'],"screen_id"=>$k));
			}
			else
			{
				$this->db->where(array("role_id"=>$_REQUEST['role'],"user_id"=>$_REQUEST['user'],"screen_id"=>$k));	
			}
    			$up[] = $this->db->update ();
    		}
    		else 
    		{
    			if(empty($_REQUEST['role']))
			{
			$this->db->fields(array("id"=>'',"role_id"=>"0","user_id"=>$value['user'],"screen_id"=>$i+1,"permit"=>$add));
			}
			else
			{	
    			$this->db->fields(array("id"=>'',"role_id"=>$value['role'],"user_id"=>$value['user'],"screen_id"=>$i+1,"permit"=>$add));
			}
    			$test[]=$this->db->insert();
    		}
    	}
	
    	if(isset($test))
    	{
    		echo "inserted";
    	}
    	if(isset($up))
    	{
    		echo "updated!!!";
    	}
    	
    	
    }	
    	 
    



    public function fetchRoles(){
    	$this->db->Fields(array("role_id"));
    	$this->db->From("users");
    	$this->db->where(array("id"=>$_REQUEST['user']));
    	$this->db->Select ();
    	$result = $this->db->resultArray ();

	$this->db->Fields(array("screen_id","permit"));
    	$this->db->From("defaultroles");
    	$this->db->where(array("role_id"=>$result[0]['role_id']));
    	$this->db->Select ();
    	$result1 = $this->db->resultArray ();

	$this->db->Fields(array("permit"));
    	$this->db->From("userpermission");
    	$this->db->where(array("user_id"=>$_REQUEST['user']));
	$this->db->Select ();
    	$result2 = $this->db->resultArray ();

    	$this->db->Fields(array("role_id","screen_id","permit"));
    	$this->db->From("userpermission where role_id in (0 ,".$result[0]['role_id'].") and user_id=".$_REQUEST['user']);
	$this->db->Select ();
    	$result3 = $this->db->resultArray ();
    	if(count($result3) > $_SESSION['count'])
	{
		
		for($i=0;$i< count($result3);$i++)
    		{
			if($result3[$i]['role_id'] == 0)
			{
				for($j=0;$j< count($result1);$j++)
    				{
    					if($result1[$j]['screen_id']==$result3[$i]['screen_id'])
    					{
    						$result1[$j]['permit']=$result3[$i]['permit'];
    					}
    				}
			}
		}
	}
	else
	{
		for($i=0;$i< count($result3);$i++)
    		{
    			for($j=0;$j< count($result1);$j++)
    			{
    				if($result1[$i]['screen_id']==$result3[$j]['screen_id'])
    				{
    					$result1[$i]['permit']=$result3[$j]['permit'];
    				}
    			}
    		
    		}
	} 	
    	$this->db->Fields(array("name"));
    	$this->db->From("screens");
    	$this->db->Select ();
    	$result4 = $this->db->resultArray ();
    	//$_SESSION['count'] = count($result1);
    	return array("permission"=>$result1,"screens"=>$result4); 
    
    }
    
    public function assignRole($value){
    	
    	$this->db->From ( "defaultroles" );  	
    	for($i=0;$i<$_SESSION['count'];$i++)
    	{
    		$add="";
    		if(!empty($value['add']))
    		{
    			if(isset($value['add'][$i]))
    			{
    				$add.="1".",";
    			}
    			else
    			{
    				$add.="0".",";
    			}
    		}
    		else
    		{
    			$add.="0".",";
    		}
    		if(!empty($value['edit']))
    		{
    			if(isset($value['edit'][$i]))
    			{
    				$add.="1".",";
    			}
    			else
    			{
    				$add.="0".",";
    			}
    		}
    		else
    		{
    			$add.="0".",";
    		}
    		if(!empty($value['delete']))
    		{
    			if(isset($value['delete'][$i]))
    			{
    				$add.="1".",";
    			}
    			else
    			{
    				$add.="0".",";
    			}
    		}
    		else
    		{
    			$add.="0".",";
    		}
    		if(!empty($value['view']))
    		{
    			if(isset($value['view'][$i]))
    			{
    				$add.="1";
    			} 
    			else
    			{
    				$add.="0";
    			}
    		}
    		else
    		{
    			$add.="0";
    		}
    		$k=$i+1;
    		$this->db->Fields(array("permit"));
    		$this->db->From("defaultroles");
    		$this->db->where(array("role_id"=>$_REQUEST['role'],"screen_id"=>$k));
    		$this->db->Select ();
    		
    		if($this->db->resultArray ())
    		{
    			
    			$this->db->Fields(array("permit"=>$add));
    			$this->db->From("defaultroles");
    			$this->db->where(array("role_id"=>$_REQUEST['role'],"screen_id"=>$k));
    			$up[] = $this->db->update ();
    		}
    		else 
    		{
    			
    			$this->db->fields(array("id"=>'',"role_id"=>$value['role'],"screen_id"=>$i+1,"permit"=>$add));
    			$test[]=$this->db->insert();
    		}
    	}
    	if(isset($test))
    	{
    		echo "inserted";
    	}
    	if(isset($up))
    	{
    		echo "updated!!!";
    	}
    	
    
    }
}

?>
