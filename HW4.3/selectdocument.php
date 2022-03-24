<?php 
session_start();

        if(!isset($_SESSION['loggedin'])){
            header("location: login.php");
        }  
        echo "Bonjour! ".$_SESSION['stf_name'];
        require_once("dbconfig.php");
        ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title> SEARCH </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body style="background-color:#483D8B">
    <div align =center class="container"style='color:#EEDD82'>
    <h1 align =right style='color:#EEDD82'>ค้นหารายชื่อบุคลากร&คำสั่งแต่งตั้ง&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
        <a href='document.php'><span class='glyphicon glyphicon-arrow-left'style='color:#EEDD82'></span></a></h1>
        <form align =center action="#" method="post">
            <input type="text" name="kw" placeholder="ค้นหาเลขที่/ชื่อคำสั่งแต่งตั้ง" value="" size=140 style="background-color:#FFFACD">
            <button type="submit" class="glyphicon glyphicon-search btn btn-warning"></button>
        </form>

        <?php

        @$kw = "%{$_POST['kw']}%";

        $sql = "SELECT DISTINCT documents.* 
FROM documents LEFT JOIN doc_staff ON documents.id=doc_staff.doc_id
      LEFT JOIN staff ON doc_staff.stf_id=staff.id 
WHERE concat(doc_num, doc_title,stf_name) LIKE ?
ORDER BY doc_num;";

        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $kw);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 0) {
            echo  "Not found!";
        } else {
            echo "Found " . $result->num_rows . " record(s).";
            $table = "<table class='table table-hover'>
                        <thead>
                            <tr style='color:#EEDD82;'>
                                <th scope='col'>#</th>
                                <th scope='col'>เลขที่คำสั่ง</th>
                                <th scope='col'>ชื่อคำสั่ง</th>
                                <th scope='col'>วันที่เริ่มต้นคำสั่ง</th>
                                <th scope='col'>วันที่สิ้นสุด</th>
                                <th scope='col'>สถานะ</th>
                                <th scope='col'>ชื่อไฟล์เอกสาร</th>
                            </tr>
                        </thead>
                        <tbody>";
                        
             
            $i = 1; 

            while($row = $result->fetch_object()){ 
                $table.= "<tr style='color:#EEDD82;'>";
                $table.= "<td>" . $i++ . "</td>";
                $table.= "<td>$row->doc_num &emsp;</td>";
                $table.= "<td>$row->doc_title</td>";
                $table.= "<td>$row->doc_start_date</td>";
                $table.= "<td>$row->doc_to_date</td>";
                $table.= "<td>$row->doc_status</td>";
                $table.= "<td><a href='uploads/$row->doc_file_name'>$row->doc_file_name</a></td>";
                $table.= "</tr>";
            }

            $table.= "</tbody>";
            $table.= "</table>";
            
            echo $table;
        }
        ?>
    </div>
</body>

</html>