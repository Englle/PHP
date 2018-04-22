<?php

/**
 * @Author: Administrator
 * @Date:   2018-04-11 08:34:23
 * @Last Modified by:   Administrator
 * @Last Modified time: 2018-04-12 10:42:15
 */
include "conn.php";
  $valid   = true;
  $message = '';

if (isset($_POST['send']) && $_POST['send']==true) {
	

        if (isset($_POST['email']) && $_POST['email']!="") {
           $useremail = htmlentities($_POST['email'], ENT_QUOTES, 'UTF-8');
           $regexp = "/^([_a-z0-9-]+)(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/";
         if (!preg_match($regexp,$useremail)){
             $message = "邮箱不合法";
             $valid   = false;
            }
        }else{
          $message = "邮箱不合法";
          $valid   = false;
        }

      if (isset($_POST['pass']) && isset($_POST['checkPass']) && $_POST['pass']!="" && $_POST['checkPass']!="") {
          $password = $_POST['pass'];
          $setpassword = $_POST['checkPass'];
          
          if ($password != $setpassword) {
               $message = "初始密码和确认密码不符合";
               $valid   = false;
          }else{
              $password = sha1($password);
          }

      }else{
         $message = "密码不能为空";
         $valid   = false;
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

     


     if ($valid) {
    	
		
        $result = mysqli_query($conn,"SELECT * From user WHERE useremail =  '$useremail' ");  //验证是否存在
        if(mysqli_num_rows($result) == 0 ){ 

             $sql="INSERT INTO user (useremail,userpass,usersex,userlevel) VALUES ('".$useremail."','".$password."',".$usersex.",".$userlevel.")";

             if(mysqli_query($conn,$sql)){
                $message =  '用户注册成功!';
              }else{
                $message =  "用户注册失败!".mysqli_error($conn).$sql;
                $valid   = false;
              }
        }else{
             $message =  "邮箱可能已经存在！请重新输入";
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