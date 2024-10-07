<?php
require_once 'database.php';
require_once 'gudang.php';

$database = new Database();
$db = $database->getConnection();

$gudang = new Gudang($db);

$gudang->id = isset($_GET['id']) ? $_GET['id'] : die('Error: ID tidak ditemukan.');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $gudang->name = $_POST['name'];
    $gudang->location = $_POST['location'];
    $gudang->capacity = $_POST['capacity'];
    $gudang->status = $_POST['status'];
    $gudang->openTime = $_POST['openTime'];
    $gudang->closeTime = $_POST['closeTime'];
    
    if ($gudang->update()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Gagal mengupdate gudang.";
    }
} else {

    $stmt = $gudang->show($gudang->id);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    $gudang->name = $data['name'];
    $gudang->location = $data['location'];
    $gudang->capacity = $data['capacity'];
    $gudang->status = $data['status'];
    $gudang->openTime = $data['opening_hour'];
    $gudang->closeTime = $data['closing_hour'];
}

ob_start();
?>

<h1>Edit Gudang</h1>

<form action="view-edit.php?id=<?php echo $gudang->id; ?>" method="POST">
    <div class="mb-2">
        <label for="name">Nama Gudang:</label>
        <input type="text" class="form-control" name="name" id="name" value="<?php echo $gudang->name; ?>" required><br>
    </div>

    <div class="mb-2">
        <label for="location">Lokasi:</label>
        <select name="location" id="location" class="form-control">
            <option value="Jakarta" <?php if($gudang->location == 'Jakarta') echo 'selected'; ?>>Jakarta</option>
            <option value="Surabaya" <?php if($gudang->location == 'Surabaya') echo 'selected'; ?>>Surabaya</option>
            <option value="Bogor" <?php if($gudang->location == 'Bogor') echo 'selected'; ?>>Bogor</option>
            <option value="Semarang" <?php if($gudang->location == 'Semarang') echo 'selected'; ?>>Semarang</option>
        </select><br>
    </div>

    <div class="mb-2">
        <label for="capacity">Kapasitas:</label>
        <input type="text" class="form-control" name="capacity" id="capacity" value="<?php echo $gudang->capacity; ?>" required><br>
    </div>

    <div class="mb-2">
        <label for="status">Status:</label>
        <select name="status" id="status" class="form-control">
            <option value="aktif" <?php if($gudang->status == 'aktif') echo 'selected'; ?>>Aktif</option>
            <option value="tidak_aktif" <?php if($gudang->status == 'tidak_aktif') echo 'selected'; ?>>Tidak Aktif</option>
        </select><br>
    </div>

    <div class="mb-2">
        <label for="openTime">Jam Buka:</label>
        <input type="time" class="form-control" name="openTime" id="openTime" value="<?php echo $gudang->openTime; ?>" required><br>
    </div>

    <div class="mb-2">
        <label for="closeTime">Jam Tutup:</label>
        <input type="time" class="form-control" name="closeTime" id="closeTime" value="<?php echo $gudang->closeTime; ?>" required><br>
    </div>

    <input type="submit" class="btn btn-warning w-100" value="Update Gudang">
</form>

<br>
<a href="index.php">Kembali ke Daftar Gudang</a>

<?php
    $content = ob_get_clean();
    include 'layout.php';
?>
