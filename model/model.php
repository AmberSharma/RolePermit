<?php

require_once "../libraries/constant.php";
require_once SITEPATH.'model/singleton.php';


abstract class model {

    protected $db = "";

    function __construct() {
        $this->db = DBConnection::Connect();
    }

}

class MyModel extends model {
	private $_count;
   public function FindUsers($val = "") {
		if ($val == 2) {
			$this->db->Fields ( array (
					"user_name" 
			) );
		} else {
			$this->db->Fields ( array (
					"user_name",
					"password",
					"name",
					"contact_no",
					"email" ,
					"user_id",
					"user_type"
			) );
		}
		$this->db->From ( "user_registration" );
		if ($val == 1) {
			$this->db->Where ( array (
					"user_name" =>$_SESSION['user_name']));
		}
		$this->db->Select ();
		$result = $this->db->resultArray ();
		return $result;
	}
	
    public function retriveImage()
    {
    	$this->db->Fields ( array ("image" , "url") );
    	$this->db->From ( "advertisement" );
    	$this->db->Where ( array ("uploadtime>" =>date('Y-m-d')));
    	$this->db->Limit("");
    	$this->db->Select ();
    	$result = $this->db->resultArray ();
    	return $result;
    
    }
  function uploadImage($image,$url,$type,$uploadtime)
    {
    
    	$this->db->fields(array("image_id"));
    	$this->db->from("advertisement");
    	$this->db->OrderBy("image_id","DESC");
    	$this->db->Limit("1");
    	$this->db->select();
    	$result=$this->db->resultArray();
    	$this->db->Start_transaction();
    	if($result==null)
    	{
    		$image=$image.(1);
    	}
    	else {
    		$image=$image.($result[0]['image_id']+1);
    	}
    
    	$this->db->fields(array("image_id"=>'',"image"=>$image,"url"=>$url,"type"=>$type,"uploadtime"=>$uploadtime));
    	$this->db->from("advertisement");
    	$test=$this->db->insert();
    	if($test==1)
    	{
    		$id=$this->db->lastInsertId();
    		$this->db->transaction_commit();
    		return $id;
    	}
    	else
    	{
    		$this->db->transaction_rollback();
    	}
    
    }
    function LastInsertedID()
    {
    	return $this->db->lastInsertId();
    }
    function uploadImageProperty($image,$id)
    {
    	$this->db->fields(array("image_id"=>'',"property_id"=>$id,"image"=>$image));
    	$this->db->from("property_image");
    	$this->db->insert();
    	//echo $this->db->lastQuery();die;
    	$this->db->resultArray();
    
    }
	public function AddBroker($matchfield , $val){
		$this->db->Fields($matchfield);
		$this->db->From("user_registration");
		$bool=$this->db->Insert();
		if($bool)
		{
			$val['b_id']=$this->db->lastInsertId();
			$this->db->Fields($val);
			$this->db->From("broker");
			$bool1=$this->db->Insert();
		}
		if($bool && $bool1)
		{
				return $bool1;
		}	
		else
		{
			return false;
		}	
	}

	public function DeleteBroker(){
	    $this->db->From("user_registration");
	    $this->db->where(array("name"=>$_REQUEST['name']));
	    $bool1=$this->db->Delete();
	    //echo $this->db->lastQuery();
	    return $bool1;
	}
	public function SearchContent($matchfield) {


		
		$this->db->Fields(array("property_id" , "price"));
		$this->db->From("seller_table");
		$this->db->where($matchfield);
		
		if(isset($_SESSION['user_id']))
		{
			if($matchfield==null)
			{
				$this->db->where1(" property_id not in (select  property_buy.property_id from property_buy  where user_id=".$_SESSION['user_id'].")");
			}
			else 
			{
				$this->db->where1("AND property_id not in (select  property_buy.property_id from property_buy  where user_id=".$_SESSION['user_id'].")");
					
			}
		}
		
		$this->db->Select();
		$result = $this->db->resultArray();
		//echo $this->db->lastQuery(); 
		return $result;
		 
	}
	public function SearchProperty($matchfield1=array()) {

		
		$this->db->From("seller_table");
		$this->db->Join("property_image","seller_table.property_id=property_image.property_id");
		$count=count($matchfield1);
		
		if($count==1)
		$this->db->where(array("seller_table.property_id"=>$matchfield1['property_id'],"property_status<>"=>"done"));
		else if($count==2)
		$this->db->where(array("property_id"=>"in (select  property_id from property_buy  where user_id=".$_SESSION['user_id'].")","seller_table.property_id"=>$matchfield1['property_id'],"seller_table.price"=>$matchfield1['price']));
		$this->db->GroupBy("property_id");
		$this->db->Select();
		$result = $this->db->resultArray();
// 		echo $this->db->lastQuery(); 
		return $result;
		 
	}
	public function SearchPropertypage($val ,$limit) {
	
		$this->db->From("seller_table");
		$this->db->Join("property_image","seller_table.property_id=property_image.property_id");
		$this->db->In("Property_id" , $val);
		$this->db->Limit($limit);
		$this->db->GroupBy("property_id");
		$this->db->Select();
		$result = $this->db->resultArray();
		return $result;
			
	}
	public function PropertyDetailed($matchfield){
	
		//$this->db->Fields(array("name"=> $_REQUEST['name'],"contact_no"=>$_REQUEST['contact_no'],"email"=>$_REQUEST['email'],"user_name"=>$_REQUEST['user_name'],"password"=>$_REQUEST['password'],"status"=>"t","user_type"=>"m"));
		$this->db->From("seller_table");
		
		//$this->db->Join("property_image","seller_table.property_id=property_image.property_id","cross");
		$this->db->where($matchfield);
		$bool1=$this->db->Select();
		//echo $this->db->lastQuery();
		$result = $this->db->resultArray();
		return $result;
		
	}
	public function PropertyImage($matchfield){
	
		$this->db->Fields(array("image"));
		$this->db->From("property_image");
		//print_r($matchfield);
		//$this->db->Join("property_image","seller_table.property_id=property_image.property_id","cross");
		$this->db->where($matchfield);
		$bool1=$this->db->Select();
		//echo $this->db->lastQuery();
		$result = $this->db->resultArray();
		return $result;
		
	}
	public function AdminDetails($matchfield) {
	
		//$this->db->Fields(array("user_name","password","user_type"));
		$this->db->From("user_registration");
		$this->db->where($matchfield);
		$this->db->Select();
		//echo $this->db->lastQuery();die;
		$result = $this->db->resultArray();
		//print_r($result);die;
		return $result;
		 
	}
public function SendFeedback($value)
	{
		require_once SITEPATH.'model/Feedback_class.php';
		$obj2 = new Feedback();
		$obj2 = unserialize($value);
		$this->db->Fields(array("feedback_to"=>$obj2->getFeedback_to(),"feedback_by"=>$_SESSION['user_name'],"user_id"=>$_SESSION['user_id'],"feedback_subject"=>$obj2->getSubject(),"feedback_content"=>$obj2->getContent(),"feedback_time"=>date('Y-m-d H:m:s'),"status"=>"f","type"=>$obj2->getStatus()));
		$this->db->From("feedback");
		$bool1=$this->db->Insert();
		return $bool1;
		
	}

public function viewFeedback($val = "") {
	
	
		$this->db->Fields ( array ("feedback_by","feedback_time","feedback_content","feedback_subject" ,"user_id") );
	
		$this->db->From ( "feedback" );
		if($_SESSION['user_type']=='a')
		$this->db->Where ( array ("status" =>"f","type" =>"new"));
		else
		$this->db->Where ( array ("status" =>"f","type" =>"reply","feedback_to"=>$_SESSION['user_id']));
		if($val!="0")
		{
			$this->db->limit ($val);
		}
		$this->db->Select ();
		$result = $this->db->resultArray ();
		//echo $this->db->lastQuery();
		return $result;
	}
	public function FetchFeedbackuser($uid){
		$this->db->Fields(array ("user_name"));
		$this->db->From("user_registration");
		$this->db->Where(array("user_id"=>$uid));
		$this->db->select();
		$result = $this->db->resultArray ();
//echo $this->db->lastQuery();
		return $result;
	
	}
	public function oldPassword()
	{
		$this->db->Fields(array("password"));
		$this->db->Where(array("user_name"=>$_SESSION['user_name']));
		$this->db->From("login");
		$this->db->select();
		//echo $this->db->lastQuery();
		$result = $this->db->resultArray();
		return $result;
		
	}
	public function changePassword($value = "", $action = "") {
		require_once SITEPATH.'model/profile.php';
		$obj3 = new Profile ();
		$obj3 = unserialize ( $value );
		
		if ($action == 1) {
			$this->db->Fields ( array (
					"user_name" => $obj3->getUsername (),
					"password" => $obj3->getPassword (),
					"name" => $obj3->getName (),
					"contact_no" => $obj3->getContact_no (),
					"email" => $obj3->getEmail () 
			) );
		} else {
			$_SESSION ['password'] = $obj3->getPassword ();
			$this->db->Fields ( array (
					"password" => $obj3->getPassword () 
			) );
		}
		$this->db->Where ( array (
				"user_name" => $_SESSION['user_name']
		) );
		$this->db->From ( "user_registration" );
		$result = $this->db->update ();
//echo $this->db->lastQuery();die;
		return $result;
	}
	public function uploadProperty($value= "")
	{
		$obj2 = new SellProperty();
		$obj2 = unserialize($value);
	
		$this->db->Fields(array("user_id"=>$_SESSION['user_id'],"deal_type"=>$obj2->getDealtype(),"address"=>$obj2->getAddress(),"property_type"=>$obj2->getPropertytype(),
					"transaction_type"=>"hi","property_area"=>$obj2->getSize(),
					"facility"=>$obj2->getFacility(),"price"=>$obj2->getPrice(),
					"direction"=>$obj2->getDirection(),"description"=>$obj2->getDescription(),
					"property_feature"=>$obj2->getPropertyfeature(),"bargain_amount"=>$obj2->getLastprice(),
					"furnished_item"=>$obj2->getFurnisheditem(),"sector"=>$obj2->getSector(),
					"transaction_type"=>$obj2->getTransaction(),"deal_type"=>$obj2->getDealtype(),
					"city"=>$obj2->getCity(),"bhk"=>$obj2->getBhk(),
					"property_status"=>'inactive',"date"=>date('Y-m-d H:m:s')));
		$this->db->From("seller_table");
		$result=$this->db->insert();
	
		return $result;
	}
	
	public function FindProperty() {
	
		$this->db->Fields(array("address","property_type","property_area","facility","price" ,"property_status","city"));
		$this->db->From("seller_table");
		$this->db->Join("property_buy","seller_table.property_id=property_buy.property_id");
		$this->db->Select();
		echo $this->db->lastQuery();
		$result = $this->db->resultArray();
		return $result;
		 
	}
	public function FindCommonProperty($area) {
		//$this->db->Fields(array("property_id" , "price"));
		$this->db->From("seller_table");
		$this->db->Join("property_buy","seller_table.property_id=property_buy.property_id");
		$this->db->where(array("city"=>$area,"property_status"=>"inactive"));
		$this->db->GroupBy("property_id");
		$this->db->Select();
		//echo $this->db->lastQuery();die;
		$result = $this->db->resultArray();
		return $result;
		 
	}
	public function FindAreaBroker($matchfield) {
		$this->db->Fields(array("b_name","b_id","b_property_assign"));
		$this->db->From("broker");
		//$this->db->Join("seller_table","seller_table.city=broker.b_area");
		//$this->db->In("city" , $matchfield);
		$this->db->where(array("b_area"=>$matchfield));
		//$this->db->GroupBy("b_name");
		$this->db->Select();
		//echo $this->db->lastQuery();die;
		$result = $this->db->resultArray();
		return $result;
		 
	}
	public function AssignProperties($pid,$bid) {
		$this->db->Fields(array("assign_to"=>$bid,"property_status"=>"active"));
		$this->db->From("seller_table");
		$this->db->In("property_id" , $pid);
		$result=$this->db->Update();
		//echo $this->db->lastQuery();
		return $result;
			
	}
	
	public function UpdateBroker($bid) {
		
		$this->db->Fields(array("b_property_assign"=>"`b_property_assign` +1"));
		$this->db->From("broker");
		$this->db->Where(array("b_id"=>$bid));
		$result2=$this->db->Update();
		//echo $this->db->lastQuery();
		return $result2;
			
	}
public function viewMessage($val = "") {
	
	
		$this->db->Fields ( array ("message_time","message_subject","message_content","assign_name","property_id") );
	
		$this->db->From ( "message" );
	
		$this->db->Where ( array ("assigned_to" =>$_SESSION['user_id']));
		if($val!="0")
		{
			$this->db->limit ($val);
		}
		$this->db->Select ();
		$result = $this->db->resultArray ();
		//echo $this->db->lastQuery();
		return $result;
	}
	
	public function FetchUserList(){
		$this->db->Fields(array ("user_name","user_id"));
		$this->db->From("user_registration where user_id in (select assign_to from seller_table where user_id=".$_SESSION['user_id'].")");
		$this->db->select();
		$result = $this->db->resultArray ();
		return $result;
	
	}
	public function FetchBuyerList($val=""){
    	$this->db->Fields(array ("user_name","user_id"));
    	$this->db->From("user_registration where user_id in (select user_id from property_buy where property_id=".$val.")");
    	$this->db->select();
		$result = $this->db->resultArray ();
		return $result;
    
    }
    public function FetchAdminList(){
    	$this->db->Fields(array ("user_id","user_name"));
    	$this->db->From("user_registration");
    	$this->db->where(array("user_type"=>"a"));
    	$this->db->select();
    	
    	//echo $this->db->lastQuery();die;
    	$result = $this->db->resultArray ();
    	return $result;
    
    }
	public function FetchSeller($val=""){
    	$this->db->Fields(array ("user_registration.user_id","user_name"));
    	$this->db->From("user_registration");
    	$this->db->Join("seller_table","seller_table.user_id=user_registration.user_id");
    	$this->db->Where(array("property_id"=>$val));
    	$this->db->select();
    	$result = $this->db->resultArray ();
    	return $result;
    
    }
    
    public function FetchBuyer($val=""){
    	$this->db->Fields(array ("buyer_id"));
    	$this->db->From("commission");
    	$this->db->Where(array("property_id"=>$val));
    	$this->db->select();
    	//echo $this->db->lastQuery();die;
    	$result = $this->db->resultArray ();
    	return $result;
    
    }
public function FinalProperty($value)
	{
		require_once SITEPATH.'model/commission_class.php';
		$obj2 = new Commission();
		$obj2 = unserialize($value);
		$this->db->Fields(array("broker_id"=>$obj2->getBroker_id(),"buyer_id"=>$obj2->getBuyer_id(),"buyer_amount"=>$obj2->getB_amt(),"property_id"=>$obj2->getProperty_id(),"seller_amount"=>$obj2->getS_amt(),"final_time"=>date('Y-m-d H:m:s'),"status_d"=>"t"));
		$this->db->From("commission");
		$bool1=$this->db->Insert();
		//echo $this->db->lastQuery()."<br/>";
		$this->db->Fields(array("property_status"=>"done"));
		$this->db->From("seller_table");
		$this->db->where(array("property_id"=>$obj2->getProperty_id()));
		$bool2=$this->db->update();
		//echo $this->db->lastQuery()."<br/>"; 
		$this->db->Fields(array("status"=>"done"));
		$this->db->From("property_buy");
		$this->db->where(array("property_id"=>$obj2->getProperty_id()));
		$bool3=$this->db->update();
		//echo $this->db->lastQuery()."<br/>";
		$this->db->Fields(array("b_property_done"=>"`b_property_done`+1"));
		$this->db->From("broker");
		$this->db->where(array("b_id"=>$obj2->getBroker_id()));
		$bool4=$this->db->update();
		//echo $this->db->lastQuery()."<br/>";
		if($bool1 && $bool2 && $bool3 && $bool4)
		return true;
	
	}
	public function SendMessage($value)
	{
		require_once SITEPATH.'model/message_class.php';
		$obj2 = new Message();
		$obj2 = unserialize($value);
	
		$this->db->Fields(array("property_id"=>$obj2->getProperty_id(),"assign_name"=>$_SESSION['user_name'],"assigned_by"=>$_SESSION['user_id'],
				"assigned_to"=>$obj2->getMessage_To(),
				"message_subject"=>$obj2->getSubject(),"message_content"=>$obj2->getContent(),
				"message_time"=>date('Y-m-d H:m:s'),"status"=>"t"));
		$this->db->From("message");
		$bool1=$this->db->Insert();
		//echo $this->db->lastQuery(); 
		return $bool1;
	
	}
public function FetchSendList($pid,$tablename){
	
		$this->db->Fields(array("user_id"));
		$this->db->From($tablename);
	
		
		$this->db->where(array("property_id"=>$pid));
		$this->db->Select();
		//echo $this->db->lastQuery();
		$result = $this->db->resultArray();
		return $result;
	
	}
public function MyBuyHistory($userid1) {
		$this->db->Fields(array("property_id"));
		$this->db->From("property_buy");
		$this->db->where(array("user_id"=>$userid1));
		$this->db->Select();
		//echo $this->db->lastQuery();
		$result = $this->db->resultArray();
		return $result;
	}
	
	
	public function MySellHistory($userid1) {
		$this->db->Fields(array("property_id"));
		$this->db->From("seller_table");
		$this->db->where(array("user_id"=>$userid1));
		$this->db->Select();
		//echo $this->db->lastQuery();
		$result = $this->db->resultArray();
		return $result;
	}
	public function MyRentHistory($userid1) {
		$this->db->Fields(array("property_id"));
		$this->db->From("property_rent");
		$this->db->where(array("user_id"=>$userid1));
		$this->db->Select();
		//echo $this->db->lastQuery();
		$result = $this->db->resultArray();
		return $result;
	}
public function PropBuy($proid1) {
		$this->db->Fields(array("property_id","price","address","property_status"));
		$this->db->From("seller_table");
		$this->db->where(array("property_id"=>$proid1));
		$this->db->Select();
		//echo $this->db->lastQuery();
		$result = $this->db->resultArray();
		return $result;
	}
public function DeleteProperty($val) {
	
		$this->db->Fields(array("property_status"=>"delete"));
		$this->db->From("seller_table");
		$this->db->Where(array("property_id"=>$val));
		$result2=$this->db->Update();
		//echo $this->db->lastQuery();
		return $result2;
			
	}

	public function CountProperty() {
		
		$this->db->Fields(array("count(*) as a"));
		$this->db->From("seller_table");
		//$this->db->Where(array("b_id"=>$bid));
		$this->db->select();
		$result = $this->db->resultArray();
		//echo $this->db->lastQuery();
		return $result;
			
	}
	public function HouseCount() {
		
		$this->db->Fields(array("count(*) as a"));
		$this->db->From("seller_table");
		$this->db->Where(array("property_type"=>"house"));
		
		$this->db->select();
		$result = $this->db->resultArray();
		//echo $this->db->lastQuery();
		return $result;
			
	}
	public function BestProperty() {
		
		$this->db->Fields(array("property_id"));
		$this->db->From("seller_table where price=(select max(price) from seller_table)");
		$this->db->select();
		
		$result = $this->db->resultArray();
		
		//print_r($result);

		$this->db->Fields(array("image"));
		$this->db->From("property_image");
		$this->db->Where(array("property_id"=>$result[0]['property_id']));
		$this->db->Limit("1");
		$this->db->select();
		//echo $this->db->lastQuery();die;
		$result1 = $this->db->resultArray();
		return $result1;
			
	}
	public function TodayAttraction() {
		$this->db->Fields(array("price"));
		$this->db->From("seller_table where price=(select max(price) from seller_table)");
		$this->db->Limit("1");
		$this->db->Select();
		
		$result = $this->db->resultArray();
		
		if($result)
		{
		$this->db->From("seller_table");
		$this->db->Join("property_image","seller_table.property_id=property_image.property_id");
		$this->db->Where(array("price"=>$result[0]['price']));
		$this->db->Limit("1");
		$this->db->GroupBy("property_id");
		$this->db->Select();
		//echo $this->db->lastQuery();die;
		
		$result1 = $this->db->resultArray();

		}
		if($result && $result1)
		{
			return $result1;
		}

}
public function NewList() {
        $this->db->Fields(array("distinct seller_table.property_id"));
        $this->db->From("seller_table");
        $this->db->Join("property_image","seller_table.property_id=property_image.property_id");
        $this->db->OrderBy("Date","DESC");
        $this->db->Limit("10");
        $this->db->Select();
        //echo $this->db->lastQuery();
        $result = $this->db->resultArray();
        return $result;
        

}

	public function BuyProperty($matchfield){
    	$this->db->Fields($matchfield);
    	$this->db->From("property_buy");
    	$bool1=$this->db->Insert();
    	//echo $this->db->lastQuery();
    	return $bool1;
    
    }
  public function Brokercontact1() {
    	
		
		$this->db->Fields(array("b_name","b_area","b_property_done"));
		$this->db->From("broker");
		//$this->db->Where(array("user_type"=>"b"));
		$this->db->select();
		$result = $this->db->resultArray();
		//echo $this->db->lastQuery();
		return $result;
			
	}
	public function Admincontact1() {
		 
	
		$this->db->Fields(array("name","contact_no","email"));
		$this->db->From("user_registration");
		$this->db->Where(array("user_type"=>"a"));
		$this->db->select();
		$result = $this->db->resultArray();
		//echo $this->db->lastQuery();
		return $result;
			
	}

public function Askquestion($limit) {
		$this->db->Fields(array("id","ques","answer"));
		$this->db->From("faq");
		//$this->db->Join("seller_table","seller_table.city=broker.b_area");
		//$this->db->In("city" , $matchfield);
		$this->db->where(array("user_id"=>"1"));
		//$this->db->GroupBy("b_name");
		$this->db->Limit($limit);
		$this->db->Select();
		//echo $this->db->lastQuery();die;
		$result = $this->db->resultArray();
		return $result;
			
	}
	public function FaqCount() {
		$this->db->Fields(array("ques"));
		$this->db->From("faq");
		$this->db->where(array("user_id"=>"1"));
		$this->db->Select();
		$result = $this->db->resultArray();
		return count($result);
			
	}
	public function SendQuestion($value)
	{
		//echo "ho";
		require_once SITEPATH.'model/Questionclass.php';
		$obj2 = new Question1();
		$obj2 = unserialize($value);
	
		$this->db->Fields(array("user_id"=>$obj2->getId(),"ques"=>$obj2->getQues(),"status"=>"pending"));
		$this->db->From("faq");
		
		$bool1=$this->db->Insert();
		//echo $this->db->lastQuery();
		return $bool1;
	
	}
	public function ViewCount() {
	
		$this->db->Fields ( array ("ques") );
	
		$this->db->From ( "faq" );
		$this->db->Where ( array ("status" =>"pending" ));
		$this->db->Select ();
		$result = $this->db->resultArray ();
		$count=count($result);
		//echo $this->db->lastQuery();
		return $count;
	}
public function ViewQuestion($val) {
	
	
		$this->db->Fields ( array ("ques","status","user_id","id") );
	
		$this->db->From ( "faq" );
		
		$this->db->Where ( array ("status" =>"pending" ));
		
			$this->db->limit ($val);
		
		$this->db->Select ();
		$result = $this->db->resultArray ();
		//echo $this->db->lastQuery();
		return $result;
	}
public function InsertAnswer($m,$k)
	{
		//echo "ho";
		//require_once SITEPATH.'controller/questionreply.php';
		//echo $_REQUEST ; die;
		$this->db->Fields(array("answer"=>$m));
		$this->db->From("faq"); 
		$this->db->Where(array("id"=>$k));
		$bool1=$this->db->Update();
		//echo $this->db->lastQuery(); 
		return $bool1;
	
	}
	public function FetchImage()
	{
		//echo "ho";
		//require_once SITEPATH.'controller/questionreply.php';
		//echo $_REQUEST ; die;
		$this->db->Fields(array("image" , "url"));
		$this->db->From("advertisement"); 
		$this->db->Where(array("uploadtime>"=>date('Y-m-d H:m:s')));
		$this->db->Select();
		$result = $this->db->resultArray ();
		//echo $this->db->lastQuery();
		return $result;
	
	}
	public function ViewCount1() {
	
		$this->db->Fields ( array ("location") );
	
		$this->db->From ( "propertyfair" );
		//$this->db->Where ( array ("status" =>"pending" ));
		$this->db->Select ();
		$result = $this->db->resultArray ();
		$count=count($result);
		//echo $this->db->lastQuery();
		return $count;
	}
	public function AddFair($value)
	{
		
		require_once SITEPATH.'model/propertyfair_class.php';
		$obj2 = new Fair();
		$obj2 = unserialize($value);
		$time=$obj2->getDate()." ".date('H:m:s');
		$this->db->Fields(array("ID"=>' ',"location"=>$obj2->getLocation(),"date"=>$time,"feature"=>$obj2->getFeatures()));
		$this->db->From("propertyfair");
		
		$bool1=$this->db->Insert();
	
		return $bool1;
	
	}
	public function FaqCount1() {
		$this->db->Fields(array("location"));
		$this->db->From("propertyfair");
		//$this->db->where(array("user_id"=>"1"));
		$this->db->Select();
		$result = $this->db->resultArray();
		return count($result);
			
	}
	public function Propertyfairview($limit) {
		$this->db->Fields(array("id","location","date","feature"));
		$this->db->From("propertyfair");
		//$this->db->Join("seller_table","seller_table.city=broker.b_area");
		//$this->db->In("city" , $matchfield);
		//$this->db->where(array("status"=>"done"));
		//$this->db->GroupBy("b_name");
		$this->db->Limit($limit);
		$this->db->Select();
		//echo $this->db->lastQuery();die;
		$result = $this->db->resultArray();
		return $result;
			
	}
	
	public function propertyidfind($limit) {
		$this->db->Fields(array("property_id"));
		$this->db->From("property_buy");
		//$this->db->Join("seller_table","seller_table.city=broker.b_area");
		//$this->db->In("city" , $matchfield);
		$this->db->where(array("status"=>"active"));
		//$this->db->GroupBy("b_name");
		//$this->db->Limit($limit);
		$this->db->Select();
		//echo $this->db->lastQuery();
		$result = $this->db->resultArray();
		return $result;
			
	}
}
