<!DOCTYPE html>
<html lang="en">

<head>
    <title>STAFF</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body style="background-color:#483D8B">
    <div  align =center class="container"style='color:#EEDD82;'>
    <h1 align =right>คณะกรรมการ&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
        <a href='document.php'><span class='glyphicon glyphicon-arrow-left 'style="color:#FFCC33;"></span></a></h1>
    <h2 align =center>รายชื่อคณะกรรมการ </h2>
    <h3 align =center>เพิ่มรายชื่อ | <a href='newstaff.php'><span class='glyphicon glyphicon-plus-sign'style="color:#FFCC33;"></span></a></h3>
        <form  align =center action="#" method="post">
            <input type="text" name="kw" placeholder="ค้นหารหัส/ชื่อบุคลากร" value="" size=140 style="background-color:#FFFACD">
            <button type="submit" class="glyphicon glyphicon-search btn btn-warning"></button>
        </form>

        <?php
        require_once("dbconfig.php");

        @$kw = "%{$_POST['kw']}%";

        $sql = "SELECT *
                FROM staff
                WHERE concat(stf_code, stf_name) LIKE ? 
                ORDER BY stf_code";

        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $kw);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 0) {
            echo "Not found!";
        } else {
            echo "Found " . $result->num_rows . " record(s)."; 
            $table = "<table class='table table-hover'>
                        <thead>
                            <tr>
                                <th scope='col'>#</th>
                                <th scope='col'>รหัสพนักงาน</th>
                                <th scope='col'>ชื่อ-นามสกุล</th>
                                <th scope='col'></th>
                            </tr>
                        </thead>
                        <tbody>";
                        
            
            $i = 1; 

            while($row = $result->fetch_object()){ 
                $table.= "<tr>";
                $table.= "<td>" . $i++ . "</td>";
                $table.= "<td>$row->stf_code</td>";
                $table.= "<td>$row->stf_name</td>";
                $table.= "<td>";
                $table.= "<a style='color:#EEDD82;'href='editstaff.php?id=$row->id'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a>";
                $table.= " | ";
                $table.= "<a style='color:#EEDD82;'href='deletestaff.php?id=$row->id'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a>";
                $table.= "</td>";
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