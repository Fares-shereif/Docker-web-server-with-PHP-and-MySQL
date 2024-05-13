<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Student Management System</h2>
        <div class="btn-container">
            <a href="add_student.php" class="add-btn">Add Student</a>
        </div>
        <?php
        // Database connection
        $servername = "db"; // Use the service name from docker-compose.yml
        $username = "php_docker"; // Use the username defined in docker-compose.yml
        $password = "password"; // Use the password defined in docker-compose.yml
        $dbname = "php_docker";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Determine sorting column and order
            $orderBy = isset($_GET['orderBy']) ? $_GET['orderBy'] : 'id';
            $order = isset($_GET['order']) ? $_GET['order'] : 'ASC';

            // Fetch all students with sorting
            $stmt = $conn->query("SELECT * FROM students ORDER BY $orderBy $order");
            $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Display students in a table
            echo "<table>";
            echo "<tr><th><a href='?orderBy=id&order=" . ($order == 'ASC' ? 'DESC' : 'ASC') . "'>ID</a></th>
                  <th><a href='?orderBy=name&order=" . ($order == 'ASC' ? 'DESC' : 'ASC') . "'>Name</a></th>
                  <th><a href='?orderBy=age&order=" . ($order == 'ASC' ? 'DESC' : 'ASC') . "'>Age</a></th>
                  <th><a href='?orderBy=cgpa&order=" . ($order == 'ASC' ? 'DESC' : 'ASC') . "'>CGPA</a></th>
                  <th>Action</th></tr>";
            foreach ($students as $student) {
                echo "<tr>";
                echo "<td>" . $student['id'] . "</td>";
                echo "<td>" . $student['name'] . "</td>";
                echo "<td>" . $student['age'] . "</td>";
                echo "<td>" . $student['cgpa'] . "</td>";
                echo "<td><a href='delete_student.php?id=" . $student['id'] . "'><img src='6861362.ico' alt='Delete' class='btn'></a></td>";
                echo "</tr>";
            }
            echo "</table>";

        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        ?>
    </div>
</body>
</html>
