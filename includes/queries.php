<?php



require_once __DIR__ . '/../config/database.php';






function get_user_by_username(mysqli $conn, string $username): ?array
{
    $sql = "SELECT user_id, username, password, full_name, role, photo
            FROM user WHERE username = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    return $row ?: null;
}






function get_all_students(mysqli $conn): array
{
    $sql = "SELECT * FROM student ORDER BY id DESC";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}



function get_student_by_id(mysqli $conn, int $id): ?array
{
    $sql = "SELECT * FROM student WHERE id = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return $row ?: null;
}



function get_next_student_id(mysqli $conn): string
{
    $sql = "SELECT MAX(CAST(student_id AS UNSIGNED)) AS max_id FROM student";
    $row = $conn->query($sql)->fetch_assoc();
    $max = (int)($row['max_id'] ?? 0);
    if ($max <= 0) {
        $max = 2023111000;   
    }
    return (string)($max + 1);
}



function student_id_exists(mysqli $conn, string $student_id, int $exclude_id = 0): bool
{
    $sql  = "SELECT id FROM student WHERE student_id = ? AND id <> ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $student_id, $exclude_id);
    $stmt->execute();
    $exists = $stmt->get_result()->num_rows > 0;
    $stmt->close();
    return $exists;
}



function search_students(mysqli $conn, string $keyword): array
{
    $like = '%' . $keyword . '%';
    $sql  = "SELECT * FROM student
             WHERE student_id LIKE ? OR name LIKE ?
             ORDER BY id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $like, $like);
    $stmt->execute();
    $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $rows;
}



function add_student(mysqli $conn, array $data): int
{
    $sql = "INSERT INTO student
            (student_id, name, address1, address2, postcode, city, state,
             gender, race, religion, contact, email, photo)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        'sssssssssssss',
        $data['student_id'], $data['name'], $data['address1'], $data['address2'],
        $data['postcode'],   $data['city'], $data['state'],    $data['gender'],
        $data['race'],       $data['religion'], $data['contact'], $data['email'],
        $data['photo']
    );
    $stmt->execute();
    $newId = $stmt->insert_id;
    $stmt->close();
    return $newId;
}



function update_student(mysqli $conn, int $id, array $data): bool
{
    $sql = "UPDATE student SET
                student_id = ?, name = ?, address1 = ?, address2 = ?,
                postcode = ?, city = ?, state = ?, gender = ?, race = ?,
                religion = ?, contact = ?, email = ?, photo = ?
            WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        'sssssssssssssi',
        $data['student_id'], $data['name'], $data['address1'], $data['address2'],
        $data['postcode'],   $data['city'], $data['state'],    $data['gender'],
        $data['race'],       $data['religion'], $data['contact'], $data['email'],
        $data['photo'],      $id
    );
    $ok = $stmt->execute();
    $stmt->close();
    return $ok;
}



function delete_student(mysqli $conn, int $id): bool
{
    $sql  = "DELETE FROM student WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $ok = $stmt->execute();
    $stmt->close();
    return $ok;
}
