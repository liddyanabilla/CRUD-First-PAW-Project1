<?php
// Koneksi database
$koneksi = mysqli_connect("localhost", "root", "", "latihan_db");

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// 1. PROSES TAMBAH DATA (CREATE)
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $jabatan = $_POST['jabatan'];

    $query = "INSERT INTO karyawan (nama, email, jabatan) VALUES ('$nama', '$email', '$jabatan')";
    mysqli_query($koneksi, $query);
    header("Location: index.php");
}

// 2. PROSES UPDATE DATA
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $jabatan = $_POST['jabatan'];

    $query = "UPDATE karyawan SET nama='$nama', email='$email', jabatan='$jabatan' WHERE id=$id";
    mysqli_query($koneksi, $query);
    header("Location: index.php");
}

// 3. PROSES DELETE DATA
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM karyawan WHERE id=$id");
    header("Location: index.php");
}

// Ambil data untuk diedit
$data_edit = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result_edit = mysqli_query($koneksi, "SELECT * FROM karyawan WHERE id=$id");
    $data_edit = mysqli_fetch_assoc($result_edit);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>CRUD PHP Dasar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .form-group {
            margin-bottom: 10px;
        }
        label {
            display: inline-block;
            width: 80px;
        }
        input[type="text"], input[type="email"] {
            padding: 5px;
            width: 200px;
        }
        /* Styling Tombol & Link Warna */
        .btn-tambah, .btn-update {
            background-color: #28a745;
            color: white;
            padding: 6px 12px;
            border: none;
            cursor: pointer;
        }
        .btn-update {
            background-color: #ffc107;
            color: black;
        }
        .btn-edit {
            background-color: #fd7e14;
            color: white;
            padding: 4px 8px;
            text-decoration: none;
            border-radius: 3px;
        }
        .btn-hapus {
            background-color: #dc3545;
            color: white;
            padding: 4px 8px;
            text-decoration: none;
            border-radius: 3px;
        }
        .btn-batal {
            color: #6c757d;
            text-decoration: none;
            margin-left: 10px;
        }
    </style>
</head>
<body>

    <h2>Aplikasi CRUD Karyawan</h2>

    <!-- FORM INPUT / EDIT -->
    <?php if ($data_edit): ?>
        <h3>Edit Data Karyawan</h3>
        <form action="" method="POST">
            <input type="hidden" name="id" value="<?php echo $data_edit['id']; ?>">
            <div class="form-group">
                <label>Nama:</label>
                <input type="text" name="nama" value="<?php echo $data_edit['nama']; ?>" required>
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" value="<?php echo $data_edit['email']; ?>" required>
            </div>
            <div class="form-group">
                <label>Jabatan:</label>
                <input type="text" name="jabatan" value="<?php echo $data_edit['jabatan']; ?>" required>
            </div>
            <button type="submit" name="update" class="btn-update">Simpan Perubahan</button>
            <a href="index.php" class="btn-batal">Batal</a>
        </form>
    <?php else: ?>
        <h3>Tambah Data Karyawan</h3>
        <form action="" method="POST">
            <div class="form-group">
                <label>Nama:</label>
                <input type="text" name="nama" required>
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Jabatan:</label>
                <input type="text" name="jabatan" required>
            </div>
            <button type="submit" name="tambah" class="btn-tambah">Tambah Data</button>
        </form>
    <?php endif; ?>

    <br>
    <hr>

    <!-- TABEL DATA (READ) -->
    <h3>Daftar Karyawan</h3>
    <table>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Jabatan</th>
            <th>Aksi</th>
        </tr>
        <?php
        $no = 1;
        $result = mysqli_query($koneksi, "SELECT * FROM karyawan ORDER BY id DESC");
        while ($row = mysqli_fetch_assoc($result)):
        ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $row['nama']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['jabatan']; ?></td>
            <td>
                <a href="index.php?edit=<?php echo $row['id']; ?>" class="btn-edit">Edit</a> 
                <a href="index.php?hapus=<?php echo $row['id']; ?>" class="btn-hapus" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

</body>
</html>