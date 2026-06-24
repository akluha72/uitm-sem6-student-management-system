<?php
/**
 * ============================================================
 *  queries.php  —  SINGLE CENTRAL FILE FOR ALL SQL QUERIES
 * ============================================================
 *  Every database read/write in this application goes through a
 *  function defined here. No SQL is written anywhere else in the
 *  project. All statements use prepared statements to prevent
 *  SQL injection.
 * ============================================================
 */

require_once __DIR__ . '/../config/database.php';

/* ----------------------------------------------------------
 *  AUTHENTICATION / USER QUERIES
 * -------------------------------------------------------- */

/** Fetch a single user row by username (for login). */
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

/* ----------------------------------------------------------
 *  STUDENT QUERIES
 * -------------------------------------------------------- */

/** Return all student records (newest first). */
function get_all_students(mysqli $conn): array
{
    $sql = "SELECT * FROM student ORDER BY id DESC";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

/** Return a single student by primary key id. */
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

/** Check whether a student_id already exists (optionally excluding one id). */
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

/** Search students by Student ID or Name (partial match). */
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

/** Insert a new student. $data is an associative array of all columns. */
function add_student(mysqli $conn, array $data): int
{
    $sql = "INSERT INTO student
            (student_id, name, address1, address2, postcode, city,
             gender, race, religion, contact, email, photo)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        'ssssssssssss',
        $data['student_id'], $data['name'], $data['address1'], $data['address2'],
        $data['postcode'],   $data['city'], $data['gender'],   $data['race'],
        $data['religion'],   $data['contact'], $data['email'], $data['photo']
    );
    $stmt->execute();
    $newId = $stmt->insert_id;
    $stmt->close();
    return $newId;
}

/** Update an existing student by id. */
function update_student(mysqli $conn, int $id, array $data): bool
{
    $sql = "UPDATE student SET
                student_id = ?, name = ?, address1 = ?, address2 = ?,
                postcode = ?, city = ?, gender = ?, race = ?,
                religion = ?, contact = ?, email = ?, photo = ?
            WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        'ssssssssssssi',
        $data['student_id'], $data['name'], $data['address1'], $data['address2'],
        $data['postcode'],   $data['city'], $data['gender'],   $data['race'],
        $data['religion'],   $data['contact'], $data['email'], $data['photo'],
        $id
    );
    $ok = $stmt->execute();
    $stmt->close();
    return $ok;
}

/** Delete a student by id. Returns the deleted photo filename (if any). */
function delete_student(mysqli $conn, int $id): bool
{
    $sql  = "DELETE FROM student WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $ok = $stmt->execute();
    $stmt->close();
    return $ok;
}
