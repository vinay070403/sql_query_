<?php
require_once "Student.php";

$student = new Student();$searchKeyword = isset($_GET['search']) ? trim($_GET['search']) : null;

if ($searchKeyword) {
    $students = $student->searchStudents($searchKeyword);
} else {
    $students = $student->getAllStudents();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">

</head>
<body class="bg-light">


<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>📋 Student Dashboard</h2>

        <form method="GET" class="d-flex mb-3" role="search" style="max-width: 400px;">
    <input class="form-control me-2" type="search" name="search" placeholder="Search by name..." aria-label="Search" value="<?= htmlspecialchars($searchKeyword ?? '') ?>">
    <button class="btn btn-outline-primary" type="submit">Search</button>
</form>

    <?php if ($searchKeyword): ?>
    <p class="text-muted">Showing results for: <strong><?= htmlspecialchars($searchKeyword) ?></strong> 
        <a href="index.php" class="btn btn-sm btn-link">Clear</a></p>
<?php endif; ?>


        <a href="add.php" class="btn btn-primary">+ Add Student</a>
    </div>

    <?php if ($students->num_rows > 0): ?>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Class</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Marks</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                
                <?php while($row = $students->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= $row['class_name'] ?? 'Unassigned' ?></td>
                    <td><?= $row['age'] ?></td>
                    <td><?= $row['gender'] ?></td>
                    <td><?= $row['marks'] ?></td>
                    <td>
                        <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="index.php?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this student?')" class="btn btn-sm btn-danger">Delete</a>
                    </td>
                </tr>
                <?php endwhile ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No students found.</p>
    <?php endif; ?>
</div>

<?php
// Handle deletion if `?delete=ID` is in the URL
if (isset($_GET['delete'])) {
    $student->deleteStudent($_GET['delete']);
    header("Location: index.php");
    exit;
}
?>

</body>
</html>
