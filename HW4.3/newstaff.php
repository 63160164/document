<?php 
session_start();

if(!isset($_SESSION['loggedin'])){
    header("location: login.php");
}

require_once("dbconfig.php");


if ($_POST){
    $stf_code = $_POST['stf_code'];
    $stf_name = $_POST['stf_name'];
    $admin = $_POST['admin'];
    $username = $_POST['username'];
    $password = base64_encode($_POST['password']);

    $sql = "INSERT 
            INTO staff (stf_code,stf_name,is_admin,username,password) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sssss",$stf_code,$stf_name,$admin,$username,$password);
    $stmt->execute();

    
    header("location: staff.php");
}
echo "Bonjour! ".$_SESSION['stf_name'];


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>ADD STAFF</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body style="background-color:#483D8B">
    <div class="container"style='color:#EEDD82;'>
        <h1>เพิ่มบุคลากร</h1>
        <form action="newstaff.php" method="post">
            <div class="form-group">
                <label for="stf_code">รหัสพนักงาน</label>
                <input type="text" class="form-control" name="stf_code" id="stf_code">
            </div>
            <div class="form-group">
                <label for="stf_name">ชื่อ-นามสกุล</label>
                <input type="text" class="form-control" name="stf_name" id="stf_name">
            </div>
            <div class="form-group">
                <label  for="username">Username</label>
                <input type="text" class="form-control" name="username" id="username" >
            </div>
            <div class="form-group">
                <label  for="password">Password</label>
                <input  type="password" class="form-control" name="password" id="password">
            </div>
            <div class="form-group">
                <label for="admin">ตำแหน่ง</label>
                
                <input type="radio"  name="admin" id="is_admin" value="Y"> ADMIN
                <input type="radio"  name="admin" id="is_admin" value=""> USER
            </div>
            <br>
            <button type="button" class="btn btn-warning" onclick="history.back();">Back</button>
            <button type="submit" class="btn btn-success">Save</button>
        </form>
</body>

</html>