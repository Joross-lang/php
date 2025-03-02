<?php
// Database Connection
$servername = "localhost";
$username = "root"; // Change if needed
$password = "";
$database = "student_db";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Add/Edit/Delete
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $name = $_POST['name'];
    $age = $_POST['age'];

    if ($id) {
        $sql = "UPDATE students SET name='$name', age='$age' WHERE id=$id";
    } else {
        $sql = "INSERT INTO students (name, age) VALUES ('$name', '$age')";
    }

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM students WHERE id=$id");
    header("Location: index.php");
    exit();
}

// Fetch Students
$students = $conn->query("SELECT * FROM students");

// Fetch Data for Editing
$editData = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM students WHERE id=$id");
    $editData = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function confirmDelete(id) {
            if (confirm("Are you sure you want to delete this student?")) {
                window.location.href = "index.php?delete=" + id;
            }
        }
    </script>
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow p-4">
        <h2 class="text-center text-primary">Student Management</h2>
        
        <!-- Add / Edit Form -->
        <form method="post" class="mt-3">
            <input type="hidden" name="id" value="<?= $editData['id'] ?? '' ?>">
            <div class="mb-3">
                <label class="form-label">Name:</label>
                <input type="text" name="name" class="form-control" value="<?= $editData['name'] ?? '' ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Age:</label>
                <input type="number" name="age" class="form-control" value="<?= $editData['age'] ?? '' ?>" required>
            </div>
            <button type="submit" class="btn btn-<?= isset($editData) ? 'warning' : 'success' ?> w-100">
                <?= isset($editData) ? 'Update' : 'Add' ?> Student
            </button>
        </form>

        <!-- Student Table -->
        <table class="table table-bordered table-striped mt-4">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $students->fetch_assoc()): ?>
                    <tr class="<?= isset($_GET['edit']) && $_GET['edit'] == $row['id'] ? 'table-warning' : '' ?>">
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['name'] ?></td>
                        <td><?= $row['age'] ?></td>
                        <td>
                            <a href="index.php?edit=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                            <button onclick="confirmDelete(<?= $row['id'] ?>)" class="btn btn-sm btn-danger">Delete</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
