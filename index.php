<?php
$host = "localhost";
$user = "root";
$pass = 'Siddhi@123';
$db = "anganwadi";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("❌ Connection failed: " . $conn->connect_error);

// Insert logic
if (isset($_POST['add_student'])) {
    $sql = "INSERT INTO students (name, parents_name, aadhar_number, dob, is_handicapped)
            VALUES ('{$_POST['name']}', '{$_POST['parents_name']}', '{$_POST['aadhar_number']}', '{$_POST['dob']}', " . (isset($_POST['is_handicapped']) ? 1 : 0) . ")";
    $conn->query($sql);
}
if (isset($_POST['add_woman'])) {
    $sql = "INSERT INTO pregnant_women (name, aadhar_number, medical_proof)
            VALUES ('{$_POST['pname']}', '{$_POST['paadhar']}', '{$_POST['proof']}')";
    $conn->query($sql);
}
if (isset($_POST['add_visit'])) {
    $sql = "INSERT INTO doctor_visits (woman_id, visit_date, diagnosis)
            VALUES ({$_POST['woman_id']}, '{$_POST['visit_date']}', '{$_POST['diagnosis']}')";
    $conn->query($sql);
}
if (isset($_POST['add_center'])) {
    $sql = "INSERT INTO anganwadi (date, ration_used, quantity, activity_performed, students_present)
            VALUES ('{$_POST['date']}', '{$_POST['ration_used']}', '{$_POST['quantity']}', '{$_POST['activity_performed']}', {$_POST['students_present']})";
    $conn->query($sql);
}
if (isset($_POST['add_faculty'])) {
    $sql = "INSERT INTO faculty (name, role, contact)
            VALUES ('{$_POST['fname']}', '{$_POST['role']}', '{$_POST['fcontact']}')";
    $conn->query($sql);
}

// Delete logic
if (isset($_GET['student_id'])) $conn->query("DELETE FROM students WHERE student_id = " . intval($_GET['student_id']));
if (isset($_GET['woman_id'])) $conn->query("DELETE FROM pregnant_women WHERE woman_id = " . intval($_GET['woman_id']));
if (isset($_GET['visit_id'])) $conn->query("DELETE FROM doctor_visits WHERE visit_id = " . intval($_GET['visit_id']));
if (isset($_GET['center_id'])) $conn->query("DELETE FROM anganwadi WHERE center_id = " . intval($_GET['center_id']));
if (isset($_GET['faculty_id'])) $conn->query("DELETE FROM faculty WHERE faculty_id = " . intval($_GET['faculty_id']));

// Fetch
$students = $conn->query("SELECT * FROM students");
$women = $conn->query("SELECT * FROM pregnant_women");
$visits = $conn->query("SELECT doctor_visits.*, pregnant_women.name AS woman_name 
                        FROM doctor_visits 
                        JOIN pregnant_women ON doctor_visits.woman_id = pregnant_women.woman_id");
$centers = $conn->query("SELECT * FROM anganwadi");
$faculty = $conn->query("SELECT * FROM faculty");

if (!$students || !$women || !$visits || !$centers || !$faculty) die("❌ Query failed: " . $conn->error);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Anganwadi Management System</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            background: #f0f8ff;
            padding: 20px;
        }
        h1 {
            background: #009688;
            color: white;
            padding: 15px;
            text-align: center;
            border-radius: 8px;
        }
        h2 {
            color: #006064;
            border-left: 5px solid #26a69a;
            padding-left: 10px;
        }
        form {
            background: #ffffff;
            border: 1px solid #cfd8dc;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        input, textarea, select {
            padding: 8px;
            margin: 6px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: calc(100% - 20px);
        }
        input[type="submit"], button {
            background: #00796b;
            color: white;
            border: none;
            padding: 10px 18px;
            margin-top: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover, button:hover {
            background: #004d40;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 15px;
            background: white;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
        }
        th {
            background: #e0f2f1;
        }
        td a {
            color: #d32f2f;
            text-decoration: none;
        }
        td a:hover {
            text-decoration: underline;
        }
        .section {
            margin-bottom: 50px;
        }
    </style>
</head>
<body>

    <h1>Anganwadi Management System</h1>

    <!-- Students -->
    <div class="section">
        <h2>Students</h2>
        <form method="POST">
            <input name="name" placeholder="Name" required>
            <input name="parents_name" placeholder="Parents Name" required>
            <input name="aadhar_number" placeholder="Aadhar Number" required>
            <input type="date" name="dob" required>
            <label><input type="checkbox" name="is_handicapped"> Handicapped</label><br>
            <input type="submit" name="add_student" value="Add Student">
        </form>
        <table>
            <tr><th>Name</th><th>Parents</th><th>Aadhar</th><th>DOB</th><th>Handicapped</th><th>Action</th></tr>
            <?php while($r = $students->fetch_assoc()): ?>
                <tr>
                    <td><?= $r['name'] ?></td><td><?= $r['parents_name'] ?></td>
                    <td><?= $r['aadhar_number'] ?></td><td><?= $r['dob'] ?></td>
                    <td><?= $r['is_handicapped'] ? 'Yes' : 'No' ?></td>
                    <td><a href="?student_id=<?= $r['student_id'] ?>">Delete</a></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <!-- Pregnant Women -->
    <div class="section">
        <h2>Pregnant Women</h2>
        <form method="POST">
            <input name="pname" placeholder="Name" required>
            <input name="paadhar" placeholder="Aadhar Number" required>
            <textarea name="proof" placeholder="Medical Proof" required></textarea>
            <input type="submit" name="add_woman" value="Add Woman">
        </form>
        <table>
            <tr><th>Name</th><th>Aadhar</th><th>Proof</th><th>Action</th></tr>
            <?php while($r = $women->fetch_assoc()): ?>
                <tr>
                    <td><?= $r['name'] ?></td><td><?= $r['aadhar_number'] ?></td><td><?= $r['medical_proof'] ?></td>
                    <td><a href="?woman_id=<?= $r['woman_id'] ?>">Delete</a></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <!-- Doctor Visits -->
    <div class="section">
        <h2>Doctor Visits</h2>
        <form method="POST">
            <select name="woman_id" required>
                <option value="">Select Woman</option>
                <?php
                $wlist = $conn->query("SELECT woman_id, name FROM pregnant_women");
                while($w = $wlist->fetch_assoc()) {
                    echo "<option value='{$w['woman_id']}'>{$w['name']}</option>";
                }
                ?>
            </select>
            <input type="date" name="visit_date" required>
            <textarea name="diagnosis" placeholder="Diagnosis" required></textarea>
            <input type="submit" name="add_visit" value="Add Visit">
        </form>
        <table>
            <tr><th>Woman Name</th><th>Date</th><th>Diagnosis</th><th>Action</th></tr>
            <?php while($r = $visits->fetch_assoc()): ?>
                <tr>
                    <td><?= $r['woman_name'] ?></td><td><?= $r['visit_date'] ?></td><td><?= $r['diagnosis'] ?></td>
                    <td><a href="?visit_id=<?= $r['visit_id'] ?>">Delete</a></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <!-- Anganwadi Daily Report -->
    <div class="section">
        <h2>Anganwadi Daily Report</h2>
        <form method="POST">
            <input type="date" name="date" required>
            <input type="text" name="ration_used" placeholder="Ration Used" required>
            <input type="text" name="quantity" placeholder="Quantity" required>
            <input type="text" name="activity_performed" placeholder="Activity Performed" required>
            <input type="number" name="students_present" placeholder="No. of Students Present" required>
            <button type="submit" name="add_center">Add Report</button>
        </form>
        <table>
            <tr>
                <th>Date</th><th>Ration Used</th><th>Quantity</th><th>Activity Performed</th><th>Students Present</th><th>Action</th>
            </tr>
            <?php while ($r = $centers->fetch_assoc()): ?>
                <tr>
                    <td><?= $r['date'] ?></td><td><?= $r['ration_used'] ?></td>
                    <td><?= $r['quantity'] ?></td><td><?= $r['activity_performed'] ?></td>
                    <td><?= $r['students_present'] ?></td>
                    <td><a href="?center_id=<?= $r['center_id'] ?>">Delete</a></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <!-- Faculty -->
    <div class="section">
        <h2>Faculty</h2>
        <form method="POST">
            <input name="fname" placeholder="Name" required>
            <input name="role" placeholder="Role" required>
            <input name="fcontact" placeholder="Contact" required>
            <input type="submit" name="add_faculty" value="Add Faculty">
        </form>
        <table>
            <tr><th>Name</th><th>Role</th><th>Contact</th><th>Action</th></tr>
            <?php while($r = $faculty->fetch_assoc()): ?>
                <tr>
                    <td><?= $r['name'] ?></td><td><?= $r['role'] ?></td><td><?= $r['contact'] ?></td>
                    <td><a href="?faculty_id=<?= $r['faculty_id'] ?>">Delete</a></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

</body>
</html>
