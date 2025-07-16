<?php
require_once "Student.php";
$student = new Student();

// Get student ID from URL
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int)$_GET['id'];
$data = $student->getStudent($id);

// If student doesn't exist
if (!$data) {
    echo "Student not found.";
    exit;
}

// Fetch classes for dropdown
$classes = $student->conn->query("SELECT * FROM classes");

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $age = (int)$_POST['age'];
    $gender = $_POST['gender'];
    $class_id = (int)$_POST['class_id'];
    $marks = (float)$_POST['marks'];

    if ($student->updateStudent($id, $name, $age, $gender, $class_id, $marks)) {
        header("Location: index.php?msg=updated");
        exit;
    } else {
        $error = "Failed to update student.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
     <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">✏️ Edit Student</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Name</label>
            <input type="text" name="name" required value="<?= htmlspecialchars($data['name']) ?>" class="form-control">
        </div>
        <div class="col-md-3">
            <label class="form-label">Age</label>
            <input type="number" name="age" required value="<?= $data['age'] ?>" class="form-control">
        </div>
        <div class="col-md-3">
            <label class="form-label">Gender</label>
            <select name="gender" class="form-select" required>
                <option value="">Select</option>
                <option value="Male" <?= $data['gender'] === 'Male' ? 'selected' : '' ?>>Male</option>
                <option value="Female" <?= $data['gender'] === 'Female' ? 'selected' : '' ?>>Female</option>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Class</label>
            <select name="class_id" class="form-select" required>
                <option value="">-- Select Class --</option>
                <?php while ($class = $classes->fetch_assoc()): ?>
                    <option value="<?= $class['id'] ?>" <?= $class['id'] == $data['class_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($class['name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Marks</label>
            <input type="number" step="0.01" name="marks" required value="<?= $data['marks'] ?>" class="form-control">
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-success">💾 Update Student</button>
            <a href="index.php" class="btn btn-secondary">↩️ Back</a>
        </div>
    </form>
</div>
</body>
</html>
