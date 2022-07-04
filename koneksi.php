<?php
    $server = "localhost";
    $user = "root";
    $password = "";
    $db = "dbcrud2022";

    //buat Koneksi
    $koneksi = mysqli_connect($server, $user, $password, $db) or die(mysqli_error($koneksi));
?>