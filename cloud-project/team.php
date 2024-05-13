<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Team Data</title>
</head>
<body>
    <div class="container my-5">
        <h1>List of Members Team</h1>
        <br>
        <a class='btn btn-primary my-2' href="/Team/create.php">Add New Student</a>
        <table>
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Name</td>
                    <td>Age</td>
                    <td>CGPA</td>
                </tr>
            </thead>
            <tbody>        
                 <?php

                 $servername="localhost";
                 $username="root";
                 $password="";
                 $database="team_database";
                 $conn=new mysqli($servername, $username,$password,$database);
                 if($conn->connect_error)
                 {
                    die("connection failed: ".$conn->connect_error);
                 }
                 $sql="SELECT * FROM team";
                 $result=$conn->query($sql);
                 if(!$result)
                 {
                    die("invalid query: ".$conn->error);
                 }
                 while($row=$result->fetch_assoc())      
             {
                    echo"
                         <tr>
                    <td>$row[id]</td>
                    <td>$row[name]</td>
                    <td>$row[age]</td>
                    <td>$row[cgpa]</td>
                    <td>
                        <a class='btn btn-primary btn-sm' href='/Team/edit.php?id=$row[id]'>Edit</a>
                        <a class='btn btn-danger btn-sm' href='/Team/delete.php?$row[id]'>Delete</a>
                    </td>
                    </tr>

                    ";
            }        
                 ?>
            </tbody>
        </table>
    </div>
</body>
</html>