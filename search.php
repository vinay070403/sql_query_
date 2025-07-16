<?php
require_once "Student.php";
$student = new Student();

$results = null;
$keyword = '';

// If form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $keyword = trim($_POST['keyword']);
    $results = $student->searchStudents($keyword);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Students</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
     <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">🔎 Search Students</h2>

    <form method="POST" class="input-group mb-4">
        <input type="text" name="keyword" class="form-control" placeholder="Enter name to search..." value="<?= htmlspecialchars($keyword) ?>" required>
        <button class="btn btn-primary" type="submit">Search</button>
        <a href="index.php" class="btn btn-secondary">Back</a>
    </form>

    <?php if ($results !== null): ?>
        <?php if ($results->num_rows > 0): ?>
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Class ID</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Marks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $results->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= $row['class_id'] ?></td>
                            <td><?= $row['age'] ?></td>
                            <td><?= $row['gender'] ?></td>
                            <td><?= $row['marks'] ?></td>
                        </tr>
                    <?php endwhile ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-warning">No students found for "<?= htmlspecialchars($keyword) ?>"</div>
        <?php endif ?>
    <?php endif ?>
</div>
</body>
</html>
