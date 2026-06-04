CREATE DATABASE IF NOT EXISTS anganwadi;
USE anganwadi;

CREATE TABLE students (
    student_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    parents_name VARCHAR(100),
    aadhar_number BIGINT,
    dob DATE,
    is_handicapped BOOLEAN
);

CREATE TABLE pregnant_women (
    woman_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    aadhar_number BIGINT,
    medical_proof TEXT
);

CREATE TABLE doctor_visits (
    visit_id INT AUTO_INCREMENT PRIMARY KEY,
    woman_id INT,
    visit_date DATE,
    diagnosis TEXT,
    FOREIGN KEY (woman_id) REFERENCES pregnant_women(woman_id)
);

CREATE TABLE anganwadi (
    center_id INT AUTO_INCREMENT PRIMARY KEY,
    date DATE,
    ration_used VARCHAR(100),
    quantity VARCHAR(50),
    activity_performed TEXT,
    students_present INT
);

CREATE TABLE faculty (
    faculty_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    role VARCHAR(100),
    contact VARCHAR(20)
);
INSERT INTO students (name, parents_name, aadhar_number, dob, is_handicapped) VALUES
('Ravi', 'Suresh', 586348536742, '2021-05-10', FALSE),
('Meena', 'Kiran', 486245973105, '2021-08-22', TRUE),
('Amit', 'Raghav', 924813570325, '2021-11-30', FALSE),
('Sneha', 'Vinod', 120569820157, '2020-02-14', FALSE),
('Arjun', 'Mohan', 357106598215, '2021-03-18', FALSE);

INSERT INTO pregnant_women (woman_id,name, aadhar_number, medical_proof) VALUES
(1,'Lakshmi', 324851026812, 'Registered at civil'),
(2,'Radha', 624863185421, 'Pregnancy card'),
(3,'Kavita', 932448965411, 'Doctor letter'),
(4,'Sunita', 864701293547, 'Registered at civil'),
(5,'Anjali', 542648562154, 'Registered at cantoment');

INSERT INTO faculty (faculty_id, name, role,contact) VALUES
(5401,'Seema', 'teacher','9549354012'),
(5402,'Pooja', 'teacher', '9876509876'),
(5403, 'Geeta', 'attender', '7894561230');

select * From students;
select * From pregnant_women;
select * From doctor_visits;
select * From anganwadi;
select * From faculty
