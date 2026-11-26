<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $seller_id   = $_SESSION['user_id'];
    $title       = trim($_POST['title']);
    $category_id = $_POST['category_id'];
    $price       = $_POST['price'];
    $description = trim($_POST['description']);

    //uploading image
    $image_name = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {

        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $ext     = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            header("Location: ../post_listing.php?error=Only JPG and PNG images allowed");
            exit();
        }
        //creating filename
        $image_name = uniqid() . '.' . $ext;
        $upload_path = '../uploads/products/' . $image_name;
        move_uploaded_file($_FILES['image']['tmp_name'], $upload_path);
    }

    //inserting into database
    $stmt = $pdo->prepare("INSERT INTO products 
        (seller_id, category_id, title, description, price, image) 
        VALUES (?, ?, ?, ?, ?, ?)");

    $stmt->execute([
        $seller_id,
        $category_id,
        $title,
        $description,
        $price,
        $image_name
    ]);

    header("Location: ../listings.php");
    exit();

} else {
    header("Location: ../post_listing.php");
    exit();
}
?>
        

