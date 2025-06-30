<?php
$koneksi = new mysqli("localhost", "root", "", "belajar");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

$pesan = "";
$dataDitemukan = null;

// Cari data
if (isset($_POST['cari'])) {
    $kategori = $koneksi->real_escape_string($_POST['kategori']);
    $keyword = $koneksi->real_escape_string($_POST['keyword']);

    $result = $koneksi->query("SELECT * FROM barang WHERE $kategori = '$keyword'");
    if ($result && $result->num_rows > 0) {
        $dataDitemukan = $result->fetch_assoc();
    } else {
        $pesan = "Data tidak ditemukan.";
    }
}

// Hapus data
if (isset($_POST['hapus'])) {
    $id = $koneksi->real_escape_string($_POST['id_barang']);
    if ($koneksi->query("DELETE FROM barang WHERE id_barang = '$id'")) {
        $pesan = "Data berhasil dihapus.";
    } else {
        $pesan = "Gagal menghapus data.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Hapus Data Barang</title>
    <link rel="icon" type="image/png" href="logostruk.png">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eef5fb;
        }
        .container {
            background-color: white;
            width: 450px;
            margin: 50px auto;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #1d62d3;
        }
        label {
            font-weight: bold;
        }
        select, input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0 16px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        .button-row {
            display: flex;
            justify-content: space-between;
            gap: 8px;
        }
        .button-row button, .button-row a {
            flex: 1;
            padding: 10px;
            text-align: center;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            color: white;
            cursor: pointer;
            text-decoration: none;
        }
        .btn-primary {
            background-color: #007bff;
        }
        .btn-secondary {
            background-color: #007bff;
        }
        .btn-secondary:hover,
        .btn-primary:hover,
        .btn-danger:hover {
            opacity: 0.9;
        }
        .btn-danger {
            background-color: #dc3545;
        }

        .message {
            text-align: center;
            color: green;
            font-weight: bold;
            margin-top: 10px;
        }
        .confirm-info {
            background-color: #f8f9fa;
            padding: 15px;
            margin-top: 15px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 999;
            left: 0; top: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.5);
        }
        .modal-content {
            background: #fff;
            width: 400px;
            margin: 15% auto;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }
        .modal-content p {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Hapus Data Barang</h2>
    <form method="POST">
        <label for="kategori">Pilih Berdasarkan:</label>
        <select name="kategori" required>
            <option value="id_barang">ID Barang</option>
            <option value="nama_barang">Nama Barang</option>
        </select>
        <input type="text" name="keyword" placeholder="Masukkan keyword" required>

        <div class="button-row">
            <button type="submit" name="cari" class="btn-primary">Cari</button>
            <button type="button" class="btn-secondary" onclick="resetForm()">Reset</button>
            <a href="menu.html" class="btn-secondary">Batal</a>
        </div>
    </form>

    <?php if ($pesan): ?>
        <p class="message"><?= $pesan ?></p>
    <?php endif; ?>

    <?php if ($dataDitemukan): ?>
        <div class="confirm-info">
            <p><strong>ID:</strong> <?= $dataDitemukan['id_barang'] ?></p>
            <p><strong>Nama:</strong> <?= $dataDitemukan['nama_barang'] ?></p>
            <p><strong>Harga:</strong> <?= $dataDitemukan['harga'] ?></p>
            <p><strong>Stok:</strong> <?= $dataDitemukan['stok'] ?></p>

            <button class="btn-danger" onclick="showModal()">Hapus</button>
        </div>
    <?php endif; ?>
</div>

<!-- Modal Konfirmasi -->
<div id="modalHapus" class="modal">
    <div class="modal-content">
        <p>Apakah Anda yakin ingin menghapus data ini?</p>
        <form method="POST">
            <input type="hidden" name="id_barang" value="<?= $dataDitemukan['id_barang'] ?>">
            <button type="submit" name="hapus" class="btn-danger">Ya, Hapus</button>
            <button type="button" class="btn-secondary" onclick="closeModal()">Batal</button>
        </form>
    </div>
</div>

<script>
    function showModal() {
        document.getElementById("modalHapus").style.display = "block";
    }

    function closeModal() {
        document.getElementById("modalHapus").style.display = "none";
    }

    function resetForm() {
        document.querySelector('select[name="kategori"]').selectedIndex = 0;
        document.querySelector('input[name="keyword"]').value = "";
    }
</script>

</body>
</html>
