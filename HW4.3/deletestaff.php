<?php
session_start();

if(!isset($_SESSION['loggedin'])){
    header("location: login.php");
}
require_once("dbconfig.php");


if ($_POST){

    $id = $_POST['id'];


    $sql = "DELETE 
            FROM staff
            WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();


    header("location: staff.php");
} else {

    $id = $_GET['id'];
    $sql = "SELECT *
            FROM staff
            WHERE id = ?";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_object();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>DELETE STAFF</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body style="background-color:#483D8B">
    <div class="container"style='color:#EEDD82;'>
        <h1>ลบข้อมูลคณะกรรมการ</h1>
        <table class="table table-hover" style='color:#EEDD82;'>
            <tr>
                <th style='width:120px'>รหัสพนักงาน</th>
                <td><?php echo $row->stf_code;?></td>
            </tr>
            <tr>
                <th>ชื่อ-นามสกุล</th>
                <td><?php echo $row->stf_name;?></td>
            </tr>
           
           

        </table>
        <form action="deletestaff.php" method="post">
            <input type="hidden" name="id" value="<?php echo $row->id;?>">
            <button type="button" class="btn btn-warning" onClick="window.history.back()">Cancel Delete</button>
            <input type="submit" value="Confirm delete" class="btn btn-danger">
        </form>
</body>

</html>