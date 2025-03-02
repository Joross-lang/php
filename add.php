<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $age = $_POST['age'];

    $sql = "INSERT INTO students (name, age) VALUES ('$name', '$age')";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
</head>
<body>
    <h2>Add Student</h2>
    <form method="post">
        Name: <input type="text" name="name" required><br>
        Age: <input type="number" name="age" required><br>
        <button type="submit">Add</button>
    </form>
    <a href="index.php">Back</a>
</body>
</html>