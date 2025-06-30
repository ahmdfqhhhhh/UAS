<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "belajar";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die(showMessage("❌ Koneksi gagal: " . $conn->connect_error, "error"));
}

$search_by = $_POST['search_by'];
$id_barang = trim($_POST['id_barang'] ?? '');
$nama_barang = trim($_POST['nama_barang'] ?? '');
$jumlah_tambah = intval($_POST['jumlah']);

if ($jumlah_tambah <= 0) {
    die(showMessage("⚠️ Jumlah harus lebih dari 0.", "warning"));
}

// Cari data berdasarkan pilihan
if ($search_by === "id_barang" && $id_barang !== "") {
    $sql = "SELECT stok FROM barang WHERE id_barang = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id_barang);
} elseif ($search_by === "nama_barang" && $nama_barang !== "") {
    $sql = "SELECT stok, id_barang FROM barang WHERE nama_barang = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nama_barang);
} else {
    die(showMessage("⚠️ Data tidak lengkap.", "warning"));
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
    $stok_lama = $data['stok'];
    $id_barang_final = $data['id_barang'] ?? $id_barang;

    $stok_baru = $stok_lama + $jumlah_tambah;

    $update = $conn->prepare("UPDATE barang SET stok = ? WHERE id_barang = ?");
    $update->bind_param("is", $stok_baru, $id_barang_final);

    if ($update->execute()) {
        echo showMessage("✅ <strong>Stok berhasil ditambah</strong><br>ID Barang: <strong>{$id_barang_final}</strong><br>Stok baru: <strong>{$stok_baru}</strong>", "success");
    } else {
        echo showMessage("❌ Gagal menambah stok.", "error");
    }

    $update->close();
} else {
    echo showMessage("❌ Barang tidak ditemukan.", "error");
}

$stmt->close();
$conn->close();

// Fungsi tampilkan hasil dalam gaya HTML
function showMessage($message, $type = "info") {
    $colors = [
        "success" => "#D1FAE5",
        "error"   => "#FEE2E2",
        "warning" => "#FEF3C7",
        "info"    => "#DBEAFE"
    ];
    
    $textColors = [
        "success" => "#065F46",
        "error"   => "#991B1B",
        "warning" => "#92400E",
        "info"    => "#1E3A8A"
    ];
    
    $bg = $colors[$type] ?? "#E5E7EB";
    $text = $textColors[$type] ?? "#111827";
    
    return "
    <!DOCTYPE html>
    <html lang='id'>
    <head>
        <meta charset='UTF-8'>
        <title>Hasil Tambah Stok</title>
        <style>
            body {
                font-family: 'Segoe UI', sans-serif;
                background-color: #f1f5f9;
                display: flex;
                align-items: center;
                justify-content: center;
                height: 100vh;
                margin: 0;
            }
            .message-box {
                background-color: {$bg};
                color: {$text};
                padding: 20px 25px;
                border-radius: 12px;
                box-shadow: 0 8px 18px rgba(0,0,0,0.1);
                font-size: 1.1rem;
                text-align: center;
                max-width: 450px;
            }
            .message-box a {
                display: inline-block;
                margin-top: 15px;
                text-decoration: none;
                background: #2563eb;
                color: white;
                padding: 8px 16px;
                border-radius: 8px;
                transition: background 0.3s;
            }
            .message-box a:hover {
                background: #1d4ed8;
            }
        </style>
    </head>
    <body>
        <div class='message-box'>
            {$message}
            <br><a href='tambahstokbarang.html'>← Kembali</a>
        </div>
    </body>
    </html>
    ";
}
?>
