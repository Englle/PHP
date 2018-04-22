<?php

/**
 * @Author: Administrator
 * @Date:   2018-04-10 09:13:55
 * @Last Modified by:   Administrator
 * @Last Modified time: 2018-04-10 09:25:02
 */
include 'conn.php';
if (!isset($_POST['a'])) {
	$a = "0";
}else{
    $a = $_POST['a'];
}
echo $a; 