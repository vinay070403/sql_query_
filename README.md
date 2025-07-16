# sql_query_

# create database in mysql 

CREATE TABLE classes (        <br>
    id INT PRIMARY KEY AUTO_INCREMENT, <br>
    name VARCHAR(100) NOT NULL /n <br>
);


CREATE TABLE students (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100),
    age INT,
    gender ENUM('Male','Female'),
    class_id INT,
    marks FLOAT,
    FOREIGN KEY (class_id) REFERENCES classes(id)
);
