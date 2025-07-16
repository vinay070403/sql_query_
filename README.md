# sql_query_in php

# create database in mysql 

CREATE TABLE classes (        <br>
    id INT PRIMARY KEY AUTO_INCREMENT, <br>
    name VARCHAR(100) NOT NULL  <br>
); <br>


CREATE TABLE students (            <br>
    id INT PRIMARY KEY AUTO_INCREMENT,    <br>
    name VARCHAR(100),   <br>
    age INT,       <br>
    gender ENUM('Male','Female'),     <br>
    class_id INT,     <br>
    marks FLOAT,  <br>
    FOREIGN KEY (class_id) REFERENCES classes(id)     <br>
);
