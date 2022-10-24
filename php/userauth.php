<?php

require_once "../config.php";

//register users
function registerUser($fullnames, $email, $password, $gender, $country)
{
    //creating a connection variable using the db function in config.php
    $conn = db();
    //checking if user with this email already exist in the database
    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM students WHERE email= '$email'")) >= 1) {
        echo "Email has been registered to another user,Registration Unsuccessful ";
    } else {
        $sql = "INSERT INTO Students (full_names, email, password, gender, country)
             VALUES ('$fullnames', '$email', '$password', '$gender', '$country');";
        if (mysqli_query($conn, $sql)) {
            echo "User Successfully Registered, Proceed to login";
        } else {
            echo "Registration Unsuccessful";
        }
    }
}


//login users
function loginUser($email, $password)
{
    //creating a connection variable using the db function in config.php
    $conn = db();
    //opening connection to the database and check if username exist in the database and 
    // checking if the password is the same with what is given
    $query = "SELECT * FROM students WHERE email= '$email' AND password = '$password'";
    if (mysqli_num_rows(mysqli_query($conn, $query)) >= 1) {
         //setting user session for the user and redirecting to the dasbboard
        session_start();
        $_SESSION ['username'] = $email;
        header("location: ../dashboard.php");
    } else {
        header("location: ../forms/login.html?INCORRECT CREDENTIALS");
    } 
}

function resetPassword($email, $password)
{
    //creating a connection variable using the db function in config.php
    $conn = db();
    //opening connection to the database and check if username exist in the database
    $query = "SELECT * FROM students WHERE email= '$email'";
    if (mysqli_num_rows(mysqli_query($conn, $query)) >= 1) {
    //replacing the password with $password given
    $sql = "UPDATE Students SET
      password='$password' WHERE email= '$email'";
        if (mysqli_query($conn, $sql)) {
            echo "Password Reset Successful";
        } else {
            echo "Error Reseting Password";
        }
    }
}

function getusers()
{
    $conn = db();
    $sql = "SELECT * FROM Students";
    $result = mysqli_query($conn, $sql);
    echo "<html>
    <head></head>
    <body>
    <center><h1><u> ZURI PHP STUDENTS </u> </h1> 
    <table border='1' style='width: 700px; background-color: magenta; border-style: none'; >
    <tr style='height: 40px'><th>ID</th><th>Full Names</th> <th>Email</th> <th>Gender</th> <th>Country</th> <th>Action</th></tr>";
    if (mysqli_num_rows($result) > 0) {
        while ($data = mysqli_fetch_assoc($result)) {
            //show data
            echo "<tr style='height: 30px'>" .
                "<td style='width: 50px; background: blue'>" . $data['id'] . "</td>
                <td style='width: 150px'>" . $data['full_names'] .
                "</td> <td style='width: 150px'>" . $data['email'] .
                "</td> <td style='width: 150px'>" . $data['gender'] .
                "</td> <td style='width: 150px'>" . $data['country'] .
                "</td>
                <form action='action.php' method='post'>
                <input type='hidden' name='id'" .
                "value=" . $data['id'] . ">" .
                "<td style='width: 150px'> <button type='submit', name='delete'> DELETE </button>" .
                "</tr>";
        }
        echo "</table></table></center></body></html>";
    }
    //return users from the database
    //loop through the users and display them on a table
}
function deleteaccount($id)
{
    $conn = db();
    //deleting user with the given id from the database
    $sql = "DELETE FROM Students 
       WHERE id = '$id'";
        if (mysqli_query($conn, $sql)) {
            echo "User Deleted";
        } else {
            echo "Error Deleting User";
        }
    
}
