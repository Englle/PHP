<?php
  include "conn.php";

  $valid   = true;
  $users = '';
   
              if (isset($_GET['EditID']) && $_GET['EditID']!="") {
              	$EditID = $_GET['EditID'];
              	$sql = "SELECT id,useremail,userlevel,usersex FROM user WHERE id=".$EditID;
              }else{
              	$sql = "SELECT id,useremail,userlevel,usersex FROM user";
              }
               
            
	  			$result = $conn->query($sql);
					 
					if ($result->num_rows > 0) {
					    // 输出数据
					    while($row = $result->fetch_assoc()) {
					        $users[]=$row;
					    }
					} else {
						$valid=false;
					    $users[]='没有信息';
					}
			
   
        echo json_encode(
		    $valid ? array('valid' => $valid, 'users' => $users) : array('valid' => $valid, 'users' => $users),JSON_UNESCAPED_UNICODE
		);

		$conn->close();
?>