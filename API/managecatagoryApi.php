<?php
error_reporting(0);
include_once "lib.php";
if($_POST){
	extract($_POST);
	extract($_FILES);
	if(isset($addcat) && $addcat!=""){
		if($addcat == "addcatagory"){
			if(isset($catagorystatus) && $catagorystatus!=""){
				if(isset($catagoryimage)){
					if ($_FILES['catagoryimage']['tmp_name'] != '') {
						$filename = $_FILES['catagoryimage']['name'];
						$catagory_pic = "catagoryid_" . round(microtime(true)) . '.' .$filename;
						move_uploaded_file($_FILES['catagoryimage']['tmp_name'], "../assets/images/categories/" . $catagory_pic);
					}
					else{
						echo "invalid image!";
						exit();
					}
					if(isset($catagoryname) && $catagoryname!=""){
						if(isset($catagorydesc) && $catagorydesc!=""){
							if(isset($addby) && $addby!=""){
								if(isset($adddate) && $adddate!=""){
									$m->set_data('catagorystatus', $catagorystatus);
									$m->set_data('catagoryimage', $catagory_pic);
									$m->set_data('catagoryname', $catagoryname);
									$m->set_data('catagorydesc', $catagorydesc);
									$m->set_data('addby', $addby);
									$m->set_data('adddate', $adddate);
									$m->set_data('updateby', $updateby);
									$m->set_data('updatedate', $updatedate);

									$catagorydata = array(
										"catagorystatus" => $m->get_data('catagorystatus'),
										"catagoryimage" => $m->get_data('catagoryimage') ,
										"catagoryname" => $m->get_data('catagoryname'),
										"catagorydesc" => $m->get_data('catagorydesc'),
										"addby" => $m->get_data('addby'),
										"adddate" => $m->get_data('adddate'),
										"updateby" => $m->get_data('updateby'),
										"updatedate" => $m->get_data('updatedate'),

									);
									$q = $d->insert("catagory_master", $catagorydata);
									if ($q) {
										$response["status"] = "200";
										$response["message"] = 'Successfully added.';
										$response["catagorystatus"] = $catagorystatus;
										$response["catagoryimage"] = $base_url . "assets/images/categories/" . $catagory_pic;
										$response["catagoryname"] = $catagoryname;
										$response["catagorydesc"] = $catagorydesc;
										$response["addby"] = $addby;
										$response["adddate"] = $adddate;
										$response["updateby"] = $updateby;
										$response["updatedate"] = $updatedate;
									}
									else{
										$response["status"] = "201";
										$response["message"] = "Try again!!";
									}

								}
								else{
									$response["status"] = "201";
									$response["message"] = "Invalid adddate.";
								}

							}
							else{
								$response["status"] = "201";
								$response["message"] = "Invalid addby.";
							}
						}
						else{
							$response["status"] = "201";
							$response["message"] = "Invalid catagorydescription.";
						}
					}
					else{
						$response["status"] = "201";
						$response["message"] = "Invalid catagoryname.";
					}
				}
				else{
					$response["status"] = "201";
					$response["message"] = "Invalid catagoryimage.";
				}
			}
			else{
				$response["status"] = "201";
				$response["message"] = "Invalid catagorystatus.";
			}
		}
		else{
			$response["status"] = "201";
			$response["message"] = "variable are not set.";
		}
	}
	else{
		$response["status"] = "201";
		$response["message"] = "Access denied.";
	}
	if(isset($manage) && $manage!=""){
		if($manage == "managecatagory"){
			if(isset($catagoryid) && $catagoryid!=""){
				$data = $d->select("catagory_master", "catagoryid='$catagoryid'");
				if(mysqli_num_rows($data) > 0){
					$catagory = mysqli_fetch_array($data);
					$response["status"] = "200";
					$response["message"] = "catagory exist.";
					$response["catagorystatus"] = $catagory['catagorystatus']."";
					$response["catagoryimage"] = $base_url."assets/ima  ges/categories".$catagory['catagoryimage']."";
					$response["catagoryname"] = $catagory['catagoryname']."";
					$response["catagorydesc"] = $catagory['catagorydesc']."";
					$response["addby"] = $catagory['addby']."";
					$response["adddate"] = $catagory['adddate']."";
				} else {
					$response["status"] = "201";
					$response["message"] = "catagory not found.";
				}
			} else {
				$response["status"] = "201";
				$response["message"] = "Invalid catagoryid!";
			}
		}
		else{
			$response["status"] = "401";
			$response["message"] = "Access Denied!!";
		}
	}
}
else{
	$response["error"]="Fillup the required Credentials";
}
echo json_encode($response);
?>
