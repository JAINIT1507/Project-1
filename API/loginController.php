<?php
include "lib.php";
if($_POST){
	extract($_POST);
	if(isset($userlogin) && $userlogin=="userlogin"){
		if(isset($usermobile) && $usermobile!="" && strlen($usermobile)>=8){
		}else{
			$response['status'] = "201";
			$response['message'] = "Please enter valid mobile number";
			echo json_encode($response);
		}
	}else if(isset($userslist) && $userslist=="userslist"){
		$q = $d->select("blood_donation_user","user_phone_no!=0");
		if(mysqli_num_rows($q)>0){
			$usersdata = array();
			while ($data = mysqli_fetch_array($q)) {
				$as['u_id'] = $data['user_id'];
				$as['first_name'] = $data['user_firstname'];
				$as['last_name'] = $data['user_lastname'];
				array_push($usersdata, $as);
			}
			$response['status'] = "200";
			$response['message'] = "Users found";
			$response['userslist'] = $usersdata;
			echo json_encode($response);
		}else{
			$response['status'] = "201";
			$response['message'] = "Users not available";
			echo json_encode($response);
		}
	}else if(isset($userdetails) && $userdetails=="userdetails"){
		if(isset($user_id) && $user_id!=""){
			$q = $d->select("blood_donation_user","user_id='$user_id'");
			if(mysqli_num_rows($q)>0){
				$data = mysqli_fetch_array($q);
				$response['status'] = "200";
				$response['message'] = "Users found";
				$response['u_id'] = $data['user_id'];
				$response['first_name'] = $data['user_firstname'];
				$response['last_name'] = $data['user_lastname'];
				$response['user_country_code'] = $data['user_country_code'];
				$response['user_phone_no'] = $data['user_phone_no'];
				$response['user_address'] = $data['user_address'];
				$response['registration_date'] = date("d-M-Y", strtotime($data['registration_date']));
				echo json_encode($response);
			}else{
				$response['status'] = "201";
				$response['message'] = "Invalid user";
				echo json_encode($response);
			}
		}else{
			$response['status'] = "201";
			$response['message'] = "Something wents wrong";
			echo json_encode($response);
		}
	}else{
		$response['status'] = "201";
		$response['message'] = "Invalid Tag";
		echo json_encode($response);
	}
	// $response['status'] = "200";
	// $response['message'] = "Hii";
	// echo json_encode($response);
}else{
	$response['status'] = "201";
	$response['message'] = "Invalid Method";
	echo json_encode($response);
}