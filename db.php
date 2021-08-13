<?php

//db.php
    $con = mysqli_connect("localhost","root","");

    $sql = "CREATE DATABASE IF NOT EXISTS contact";
    if(mysqli_query($con, $sql)){
    


        $connect = new PDO("mysql:host=localhost;dbname=contact", "root", "");
        $con = mysqli_connect("localhost", "root", "", "contact");
        $sql = "
        CREATE TABLE IF NOT EXISTS contacts (
            id int(11) NOT NULL AUTO_INCREMENT ,
            contact_name VARCHAR (50) NOT NULL,
            contact_number VARCHAR (20) NOT NULL,
            contact_email VARCHAR (50) NOT NULL,
            contact_address VARCHAR (50),
            user_email VARCHAR (50),
            PRIMARY KEY(id)
           );
           ";
        
        if(!mysqli_query($con, $sql)){
            echo "Cannot Create table...!";
        }

        $sql = "
        CREATE TABLE IF NOT EXISTS users (
            id int(11) NOT NULL AUTO_INCREMENT ,
            name varchar(50) NOT NULL,
            email varchar(50) NOT NULL,
            pass varchar(50) NOT NULL,
            PRIMARY KEY(id)
           );
           ";
        
        if(!mysqli_query($con, $sql))
        {
            echo "Cannot Create table...!";
        }
    }
    else{
        echo "error";
    }

?>