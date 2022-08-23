<?php

session_start();

require 'proses.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["tambah"])) {
        if (tambah($_POST) > 0) {
            $_SESSION['message'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil!</strong> User baru telah ditambahkan.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        } else {
            $_SESSION['message'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">' . mysqli_error($conn) . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
    }

    if (isset($_POST["edit"])) {
        if (edit($_POST) > 0) {
            $_SESSION['message'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil!</strong> User telah diperbarui.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        } else {
            $_SESSION['message'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">' . mysqli_error($conn) . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
    }

    if (isset($_POST["hapus"])) {
        if (hapus($_POST) > 0) {
            $_SESSION['message'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil!</strong> User telah dihapus.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        } else {
            $_SESSION['message'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">' . mysqli_error($conn) . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
    }
}

$i = 1;
$user = query("SELECT * FROM user");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Modal</title>
    <link rel="stylesheet" href="assets/css/bootstrap.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">CRUD Modal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://github.com/rioagungpurnomo" target="_blank">Github</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <?php
        if (isset($_SESSION['message'])) {
            $message = $_SESSION['message'];
            unset($_SESSION['message']);
            echo $message;
        }
        ?>
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Daftar User</h5>
            </div>
            <div class="card-body">
                <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambah">Tambah User</button>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Email</th>
                                <th scope="col">Kelaminan</th>
                                <th scope="col">Bidang</th>
                                <th scope="col">Ditambah pada</th>
                                <th scope="col">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($user as $u) : ?>
                                <tr>
                                    <th scope="row"><?= $i++; ?></th>
                                    <td><?= $u['nama']; ?></td>
                                    <td><?= $u['email']; ?></td>
                                    <td><?= $u['kelaminan']; ?></td>
                                    <td><?= $u['bidang']; ?></td>
                                    <td><?= date('d - m - Y', $u['waktu']); ?></td>
                                    <td>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit<?= $u['id']; ?>">Edit</button>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapus<?= $u['id']; ?>">Hapus</button>
                                    </td>
                                </tr>

                                <!-- Modal Form Edit User -->
                                <div class="modal fade" id="edit<?= $u['id']; ?>" tabindex="-1" aria-labelledby="edit<?= $u['id']; ?>Label" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="edit<?= $u['id']; ?>Label">Form Edit User</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="index.php" method="post">
                                                <div class="modal-body">
                                                    <input type="hidden" name="id" value="<?= $u['id']; ?>">
                                                    <div class="mb-3">
                                                        <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama" value="<?= $u['nama']; ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                                        <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email" value="<?= $u['email']; ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="bidang" class="form-label">Bidang <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="bidang" name="bidang" placeholder="Masukkan Bidang" value="<?= $u['bidang']; ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="kelaminan" class="form-label">Kelaminan <span class="text-danger">*</span></label>
                                                        <select class="form-select" id="kelaminan" name="kelaminan" aria-label="Default select example" required>
                                                            <option value="<?= $u['kelaminan']; ?>"><?= $u['kelaminan']; ?></option>
                                                            <option value="Laki - Laki">Laki - Laki</option>
                                                            <option value="Perempuan">Perempuan</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                    <button type="submit" name="edit" class="btn btn-primary">Edit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Hapus User -->
                                <div class="modal fade" id="hapus<?= $u['id']; ?>" tabindex="-1" aria-labelledby="hapus<?= $u['id']; ?>Label" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="hapus<?= $u['id']; ?>Label">Apakah anda yakin menghapus User ini?</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="index.php" method="post">
                                                <input type="hidden" name="id" value="<?= $u['id']; ?>">
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                                                    <button type="submit" name="hapus" class="btn btn-primary">Ya, Yakin</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Form Tambah User -->
    <div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="tambahLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahLabel">Form Tambah User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="index.php" method="post">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email" required>
                        </div>
                        <div class="mb-3">
                            <label for="bidang" class="form-label">Bidang <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="bidang" name="bidang" placeholder="Masukkan Bidang" required>
                        </div>
                        <div class="mb-3">
                            <label for="kelaminan" class="form-label">Kelaminan <span class="text-danger">*</span></label>
                            <select class="form-select" id="kelaminan" name="kelaminan" aria-label="Default select example" required>
                                <option value="">Pilih Jenis Kelaminan</option>
                                <option value="Laki - Laki">Laki - Laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="assets/js/bootstrap.js"></script>
</body>

</html>