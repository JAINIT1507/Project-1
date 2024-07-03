<?php
include_once "lib.php";
if($_POST){
	extract($_POST);
	if(isset($tag) && $tag!=""){
		if($tag=="login"){
			if(isset($phone) && $phone!="" && isset($password) && $password!=""){
				$q = $d->select("registration1","phone='$phone' AND password='$password'");
				if(mysqli_num_rows($q)>0){
					$data = mysqli_fetch_array($q);
					$response["status"] = "200";
					$response["message"] = "Login Successfully";
					$response["id"] = $data['id']."";
					$response["name"] = $data['name']."";
					$response["phone"] = $data['phone']."";
					$response["image"] = $base_url."assets/images/profile_images/".$data['image']."";
					$response["email"] = $data['email']."";
					$response["gender"] = $data['gender']."";
					$response["registration_type"] = $data['registration_type']."";
				}else{
					$response["status"] = "201";
					$response["message"] = "Access denied!!";
				}
			}
			else{
				$response["status"] = "201";
				$response["message"] = "Invalid Request.";
			}
		}
	}
}
echo json_encode($response);
?>