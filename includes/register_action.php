<?php
session_abort();
require 'db.php';

//getting form data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $province = trim($_POST['Province']);
    $password = $_POST['password'];
    $account_type = $_POST['account_type'];

    //check for esisting email
    $stmt = $pdo->prepare('SELECT id FROM users WHERE email=?');
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
        header("Location: ../register.php?error=This email is already registered");
        exit();}

    //password hashing
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    //Insert in database
    $stmt = $pdo->prepare("INSERT INTO users(full_name, email, phone, province, password, account_type)
    VALUES(?,?,?,?,?,?)");

    $stmt->execute([$full_name,$email,$phone,$province,$hashed_password,$account_type]);

    //getting new user ID
    $user_id =$pdo->lastInsertId();

    //storing in session
    $_SESSION["USER_id"] = $user_id;
    $_SESSION["full_name"] = $full_name;
    $_SESSION["account_type"] = $account_type;
    $_SESSION["role"] = 'user';

    //redirecting to dashboard
    header("Location: ../dashboard.php");
    exit();}

    else{
        header("Location: ../register.php");
        exit();
    }
    ?>









