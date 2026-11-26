<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //getting data
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    //finding user
    $stmt= $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user= $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {

    //storing user info
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['full_name'] = $user['full_name'];
    $_SESSION['account_type'] = $user['account_type'];
    $_SESSION['role'] = $user['role'];

    if ($user['role'] == 'admin' || $user['role'] == 'superadmin' || $user['role'] == 'moderator') {
        header("Location: ../admin/index.php");}
        else {
            header("Location: ../dashboard.php");
        }
        exit();}

        else{
            header("Location: ../login.php?error=Email or password is invalid");
            exit();
        }}
        else {
            header("Location: ../login.php");
            exit();
        }
        ?>





