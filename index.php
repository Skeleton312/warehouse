<?php
require_once 'database.php';
require_once 'gudang.php';

$database = new Database();
$db = $database->getConnection();

$gudang = new Gudang($db);

$limit = 3;
$page = isset($_GET['page']) ? $_GET['page'] : 1; 
$start = ($page - 1) * $limit; 

$total_stmt = $gudang->read();
$total_records = $total_stmt->rowCount();

$stmt = $gudang->paginasi($start, $limit);
$num = $stmt->rowCount();

$total_pages = ceil($total_records / $limit);

ob_start();
?>

<div class="card-header d-flex justify-content-between align-items-center p-3">
    <h1 class="mb-0">List Gudang</h1>
    <a href="view-create.php" class="btn btn-primary">Tambah Gudang +</a>
</div>

<?php
if ($num > 0) {
    echo "<table class='table table-bordered table-hover' style='height:50vh;'>";
    echo "<thead class='table-dark'><tr><th>ID</th><th>Name</th><th>Location</th><th>Capacity</th><th>Status</th><th>Opening</th><th>Closing</th><th>Action</th></tr></thead>";
    echo "<tbody >";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        echo "<tr>";
        echo "<td>{$id}</td>";
        echo "<td>{$name}</td>";
        echo "<td>{$location}</td>";
        echo "<td>{$capacity}</td>";
        echo "<td>" . ($status == 'aktif' ? 'Aktif' : 'Tidak Aktif') . "</td>";
        echo "<td>{$opening_hour}</td>";
        echo "<td>{$closing_hour}</td>";
        echo "<td>";
        echo "<a href='view-edit.php?id={$id}' class='btn btn-sm btn-warning'>Edit</a> ";
        echo "<a href='delete.php?id={$id}' class='btn btn-sm btn-danger' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Hapus</a>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    echo "<nav aria-label='Page navigation example'>";
    echo "<ul class='pagination justify-content-center'>";

    if ($page > 1) {
        echo "<li class='page-item'><a class='page-link' href='index.php?page=" . ($page - 1) . "'>Previous</a></li>";
    }

    for ($i = 1; $i <= $total_pages; $i++) {
        echo "<li class='page-item " . ($i == $page ? 'active' : '') . "'><a class='page-link' href='index.php?page={$i}'>{$i}</a></li>";
    }

    if ($page < $total_pages) {
        echo "<li class='page-item'><a class='page-link' href='index.php?page=" . ($page + 1) . "'>Next</a></li>";
    }

    echo "</ul>";
    echo "</nav>";
} else {
    echo "<p class='alert alert-info'>Tidak ada data.</p>";
}

$content = ob_get_clean();
include 'layout.php';
?>
