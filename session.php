<?php
session_start();

if (isset($_POST['email'])) {
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['id'] = $_POST['id'];
    $_SESSION['type'] = $_POST['type'];
}
if (isset($_POST['logout'])) {
    session_destroy();
}
?>
