<?php

$conn = mysqli_connect("localhost", "root", "", "modal");
date_default_timezone_set('Asia/Jakarta');

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function tambah($data)
{
    global $conn;

    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    $kelaminan = htmlspecialchars($data["kelaminan"]);
    $bidang = htmlspecialchars($data["bidang"]);
    $waktu = time();

    if ($data == true) {

        $query = "INSERT INTO user VALUES('', '$nama', '$email', '$kelaminan', '$bidang', '$waktu')";

        mysqli_query($conn, $query);

        return mysqli_affected_rows($conn);
    } else {
        $_SESSION['message'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Gagal!</strong> User tidak ditambahkan.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
    }
}


function edit($data)
{
    global $conn;

    $id = $data['id'];
    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    $kelaminan = htmlspecialchars($data["kelaminan"]);
    $bidang = htmlspecialchars($data["bidang"]);

    if ($data == true) {
        $query = "UPDATE user SET nama = '$nama', email = '$email', kelaminan = '$kelaminan', bidang = '$bidang' WHERE id = $id";
        mysqli_query($conn, $query);

        return mysqli_affected_rows($conn);
    } else {
        $_SESSION['message'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Gagal!</strong> User tidak ditambahkan.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
}

function hapus($data)
{
    global $conn;

    $id = $data['id'];

    if ($data == true) {
        mysqli_query($conn, "DELETE FROM user WHERE id = '$id'");

        return mysqli_affected_rows($conn);
    } else {
        $_SESSION['message'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Gagal!</strong> User tidak ditambahkan.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
}
