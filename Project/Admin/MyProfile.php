<?php

include("../Assets/Connection/Connection.php");

session_start();




	$selQry="select * from tbl_admin where admin_id='".$_SESSION["adminid"]."'";
  	$result= $con->query($selQry);
  	$data=$result->fetch_assoc();
 		

?>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<a href="HomePage.php">Home</a>
<table width="200" border="1">
  <tr>
    <td width="74">Name</td>
    <td width="110"><?php echo $data["admin_name"] ?></td>
  </tr>
  <tr>
    <td>Email</td>
    <td><?php echo $data["admin_email"] ?></td>
  </tr>
  <tr> 
    <td colspan="2" align="center">
    <a href="EditProfile.php">EditProfile</a>/<a href="ChangePassword.php">ChangePassword</a>
    
    </td>
   
  </tr>
</table>
</body>
</html>