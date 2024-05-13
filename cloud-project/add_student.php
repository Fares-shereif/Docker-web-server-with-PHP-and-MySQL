<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <form action="add_student.php" method="post" class="form">
            <h2>Add Student</h2>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="age">Age:</label>
                <input type="text" id="age" name="age" required>
            </div>
            <div class="form-group">
                <label for="id">ID:</label>
                <input type="text" id="id" name="id" required>
            </div>
            <div class="form-group">
                <label for="cgpa">CGPA:</label>
                <input type="text" id="cgpa" name="cgpa" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Add Student">
                <!-- Button to go back to index.php -->
                <a href="index.php" class="btn">Back to Students</a>
            </div>
</body>
</html>

<?php
// Database connection
$servername = "db"; // Use the service name from docker-compose.yml
$username = "php_docker"; // Use the username defined in docker-compose.yml
$password = "password"; // Use the password defined in docker-compose.yml
$dbname = "php_docker";

try {
    // Check if the form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Establish connection to database
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Retrieve and sanitize form data
        $name = htmlspecialchars($_POST['name']);
        $age = intval($_POST['age']);
        $cgpa = floatval($_POST['cgpa']);
        $id = htmlspecialchars($_POST['id']);

        // Validate input data
        if(empty($name) || empty($id)) {
            throw new Exception("Name and ID are required fields");
        }
        if($age <= 0) {
            throw new Exception("Age must be a positive integer");
        }
        if($cgpa < 0 || $cgpa > 4) {
            throw new Exception("CGPA must be between 0 and 4");
        }
                // Check if student with same ID already exists
                $stmt_check = $conn->prepare("SELECT * FROM students WHERE id = :id");
                $stmt_check->bindParam(':id', $id);
                $stmt_check->execute();
        
                if ($stmt_check->rowCount() > 0) {
                    throw new Exception("Student with the same ID already exists");
                }

        // Prepare SQL statement to insert a new student
        $stmt = $conn->prepare("INSERT INTO students (name, age, id, cgpa) VALUES (:name, :age, :id, :cgpa)");

        // Bind parameters
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':age', $age);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':cgpa', $cgpa);
        // Execute the prepared statement to insert the new student
        $stmt->execute();
        echo "New student added successfully";
    }
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
} catch(Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
