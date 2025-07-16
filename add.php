<?php
require_once "Student.php";
$student = new Student();

// Fetch all classes for the dropdown
$classes = $student->conn->query("SELECT * FROM classes");

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $age = (int)$_POST['age'];
    $gender = $_POST['gender'];
    $class_id = (int)$_POST['class_id'];
    $marks = (float)$_POST['marks'];

    if ($student->addStudent($name, $age, $gender, $class_id, $marks)) {
        header("Location: index.php?msg=added");
        exit;
    } else {
        $error = "Failed to add student.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">

</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">➕ Add New Student</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Name</label>
            <input type="text" name="name" required class="form-control">
        </div>
        <div class="col-md-3">
            <label class="form-label">Age</label>
            <input type="number" name="age" required class="form-control">
        </div>
        <div class="col-md-3">
            <label class="form-label">Gender</label>
            <select name="gender" class="form-select" required>
                <option value="">Select</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Class</label>
            <select name="class_id" class="form-select" required>
                <option value="">-- Select Class --</option>
                <?php while ($class = $classes->fetch_assoc()): ?>
                    <option value="<?= $class['id'] ?>"><?= htmlspecialchars($class['name']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Marks</label>
            <input type="number" step="0.01" name="marks" required class="form-control">
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-success">✅ Add Student</button>
            <a href="index.php" class="btn btn-secondary">↩️ Back to Dashboard</a>
        </div>
    </form>
</div>
</body>
</html>
