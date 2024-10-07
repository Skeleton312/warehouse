<?php 
require_once 'database.php';
require_once 'gudang.php';

$database = new Database();
$db = $database->getConnection();

$gudang = new Gudang($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $gudang->name = $_POST['name'];
    $gudang->location = $_POST['location'];
    $gudang->capacity = $_POST['capacity'];
    $gudang->status = $_POST['status'];
    $gudang->openTime = $_POST['openTime'];
    $gudang->closeTime = $_POST['closeTime'];
    
    if ($gudang->create()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Gagal menambahkan data.";
    }
}
ob_start();
?>

<h1>Tambah List Gudang</h1>

<form action="view-create.php" method="POST">
<div class="mb-2">
        <label for="name">Nama Gudang:</label>
        <input type="text" class="form-control" name="name" id="name" value="<?php echo $gudang->name; ?>" required><br>
    </div>

    <div class="mb-2">
        <label for="location">Lokasi:</label>
        <select name="location" id="location" class="form-control">
            <option value="Jakarta">Jakarta</option>
            <option value="Surabaya">Surabaya</option>
            <option value="Bogor">Bogor</option>
            <option value="Semarang">Semarang</option>
        </select><br>
    </div>

    <div class="mb-2">
        <label for="capacity">Kapasitas:</label>
        <input type="text" class="form-control" name="capacity" id="capacity"  required><br>
    </div>

    <div class="mb-2">
        <label for="status">Status:</label>
        <select name="status" id="status" class="form-control">
            <option value="aktif">Aktif</option>
            <option value="tidak_aktif">Tidak Aktif</option>
        </select><br>
    </div>

    <div class="mb-2">
        <label for="openTime">Jam Buka:</label>
        <input type="time" class="form-control" name="openTime" id="openTime" required><br>
    </div>

    <div class="mb-2">
        <label for="closeTime">Jam Tutup:</label>
        <input type="time" class="form-control" name="closeTime" id="closeTime" required><br>
    </div>
    <a href='index.php' class="btn btn-danger">Batal</a>
    <input type="submit" class="btn btn-primary" value="Tambah Gudang">
</form>

<br>
<a href="index.php">Kembali ke Daftar</a>


<?php
    $content = ob_get_clean();

    include 'layout.php';
?>
