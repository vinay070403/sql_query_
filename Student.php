<?php
require_once 'DB.php';

class Student extends DB
{

    // Add a new student (INSERT)
    public function addStudent($name, $age, $gender, $class_id, $marks)
    {
        $stmt = $this->conn->prepare("INSERT INTO students (name, age, gender, class_id, marks) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sisid", $name, $age, $gender, $class_id, $marks);
        return $stmt->execute();
    }

    // Get all students (SELECT *)
    public function getAllStudents()
    {
        return $this->conn->query("SELECT s.*, c.name AS class_name 
                                   FROM students s 
                                   LEFT JOIN classes c ON s.class_id = c.id 
                                   ORDER BY s.id DESC");
    }

    // Get student by ID (SELECT WHERE)
    public function getStudent($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM students WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Update a student (UPDATE)
    public function updateStudent($id, $name, $age, $gender, $class_id, $marks)
    {
        $stmt = $this->conn->prepare("UPDATE students SET name=?, age=?, gender=?, class_id=?, marks=? WHERE id=?");
        $stmt->bind_param("sisidi", $name, $age, $gender, $class_id, $marks, $id);
        return $stmt->execute();
    }

    // Delete a student (DELETE)
    public function deleteStudent($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM students WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Search students by name (LIKE)
    public function searchStudents($keyword) {
    $stmt = $this->conn->prepare("SELECT s.*, c.name AS class_name 
                                  FROM students s 
                                  LEFT JOIN classes c ON s.class_id = c.id 
                                  WHERE s.name LIKE ?");
    $like = '%' . $keyword . '%';
    $stmt->bind_param("s", $like);
    $stmt->execute();
    return $stmt->get_result();
}

    // Filter students by age range (BETWEEN)
    public function getStudentsByAgeRange($minAge, $maxAge)
    {
        $stmt = $this->conn->prepare("SELECT * FROM students WHERE age BETWEEN ? AND ?");
        $stmt->bind_param("ii", $minAge, $maxAge);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Get students by class (JOIN + WHERE)
    public function getStudentsByClass($classId)
    {
        $stmt = $this->conn->prepare("SELECT s.*, c.name AS class_name 
                                      FROM students s 
                                      JOIN classes c ON s.class_id = c.id 
                                      WHERE c.id = ?");
        $stmt->bind_param("i", $classId);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Count students per class (GROUP BY + COUNT)
    public function getStudentCountPerClass()
    {
        return $this->conn->query("SELECT c.name AS class_name, COUNT(s.id) AS student_count 
                                   FROM classes c 
                                   LEFT JOIN students s ON s.class_id = c.id 
                                   GROUP BY c.id");
    }

    // Get top 5 students (ORDER BY + LIMIT)
    public function getTopStudents($limit = 5)
    {
        $stmt = $this->conn->prepare("SELECT * FROM students ORDER BY marks DESC LIMIT ?");
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Get students by list of IDs (IN)
    public function getStudentsByIds($ids)
    {
        $in = implode(',', array_map('intval', $ids)); // Sanitize
        return $this->conn->query("SELECT * FROM students WHERE id IN ($in)");
    }

    // Get average marks per class (GROUP BY + AVG)
    public function getMarksAveragePerClass()
    {
        return $this->conn->query("SELECT c.name AS class_name, AVG(s.marks) AS avg_marks 
                                   FROM classes c 
                                   LEFT JOIN students s ON s.class_id = c.id 
                                   GROUP BY c.id");
    }

    // Get top scorer using a subquery (SUBQUERY)
    public function getTopScorer()
    {
        return $this->conn->query("SELECT * FROM students 
                                   WHERE marks = (SELECT MAX(marks) FROM students)");
    }

    
}

?>