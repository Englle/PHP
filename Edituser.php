<?php

/**
 * @Author: Administrator
 * @Date:   2018-04-11 08:34:23
 * @Last Modified by:   Administrator
 * @Last Modified time: 2018-04-13 09:56:55
 */
include "conn.php";
  $valid   = true;
  $message = '';

if (isset($_POST['send']) && $_POST['send']==true) {
	  
	   if (isset($_POST['EditID']) && $_POST['EditID']!="") {
	   	    $EditID = $_POST['EditID'];

			  if (isset($_POST['pass']) && isset($_POST['checkPass']) && $_POST['pass']!="" && $_POST['checkPass']!="") {

			          $password = $_POST['pass'];
			          $setpassword = $_POST['checkPass'];

			          if ($password != $setpassword) {
			               $message = "初始密码和确认密码不符合";
			               $valid   = false;
			          }else{
			              $password = sha1($password);
			          }

			      }


			      if (isset($_POST['sex'])){
			        	 if ($_POST['sex'] == "男"){
			        	 	$usersex = 1;
			        	 }else if ($_POST['sex'] == "女") {
			        	 	$usersex = 0;
			        	 }else if ($_POST['sex'] == "人妖"){
			                $usersex = 2;
			        	 }else{
			        	 	$usersex = $_POST['sex'];
			        	 }
			      }


			      if (isset($_POST['level'])){
			        	 if ($_POST['level'] == "管理员"){
			        	 	$userlevel = 0;
			        	 }else if ($_POST['level'] == "普通会员") {
			        	 	$userlevel = 1;
			        	 }else{
			        	 	$userlevel = $_POST['level'];
			        	 }
			      }

	   }else{
          $message = "用户编辑ID不能为空";
          $valid   = false;
	   }




    if ($valid) {
    
        $result = mysqli_query($conn,"SELECT * From user WHERE id =".$EditID);  //验证是否存在
        if(mysqli_num_rows($result) == 1 ){ 
          if (!empty($password) && !$password=="") {

          	$sql="UPDATE user SET userpass='".$password."',userlevel=$userlevel,usersex=$usersex WHERE id=".$EditID;

          }else{
        	$sql="UPDATE user SET userlevel=$userlevel,usersex=$usersex WHERE id=".$EditID;

          }
             
             if(mysqli_query($conn,$sql)){
                $message =  '用户修改成功!';
              }else{
                $message =  "用户修改失败!".mysqli_error($conn).$sql;
                $valid   = false;
              }
        }else{
              $message =  "用户不存在,可能已经被其它管理员删除";
              $valid   = false;
        }
      }else{
            $message =  $message;
            $valid   = false; 
      }

    

}else{
	$valid   = false;
    $message = '接口不存在';
}


echo json_encode(
    $valid ? array('valid' => $valid, 'message' => $message) : array('valid' => $valid, 'message' => $message),JSON_UNESCAPED_UNICODE
);

$conn->close();

?>