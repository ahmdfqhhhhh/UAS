<?php
$koneksi = new mysqli("localhost", "root", "", "belajar");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

$tanggal = isset($_POST['tanggal']) ? $_POST['tanggal'] : "";

$data = null;
if (!empty($tanggal)) {
    $data = $koneksi->query("
        SELECT pembeli.*, barang.nama_barang 
        FROM pembeli 
        LEFT JOIN barang ON pembeli.id_barang = barang.id_barang 
        WHERE DATE(pembeli.tanggal) = '$tanggal' 
        ORDER BY pembeli.tanggal DESC
    ");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <link rel="icon" type="image/png" href="logostruk.png">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to bottom right, #e3f2fd, #ffffff);
            padding: 30px;
            color: #333;
        }

        h2, h3 {
            text-align: center;
            color: #0d47a1;
        }

        form {
            text-align: center;
            margin-bottom: 30px;
        }

        input[type="date"] {
            padding: 10px;
            width: 220px;
            border: 1px solid #90caf9;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="submit"], a.button {
            padding: 10px 20px;
            background-color: #0d47a1;
            color: white;
            border: none;
            text-decoration: none;
            border-radius: 5px;
            font-size: 15px;
            cursor: pointer;
            margin: 5px;
            transition: background 0.3s ease;
        }

        input[type="submit"]:hover, a.button:hover {
            background-color: #1565c0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }

        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: center;
        }

        th {
            background-color: #1976d2;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f1f1f1;
        }

        .nav-links {
            text-align: center;
            margin-top: 40px;
        }

        .nav-links a {
            margin: 0 15px;
            text-decoration: none;
            color: #0d47a1;
            font-weight: bold;
        }

        .nav-links a:hover {
            text-decoration: underline;
        }

        @media screen and (max-width: 600px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }
            th {
                background-color: #1565c0;
                text-align: left;
            }
            td {
                text-align: right;
                padding-left: 50%;
                position: relative;
            }
            td::before {
                content: attr(data-label);
                position: absolute;
                left: 10px;
                font-weight: bold;
                text-align: left;
            }
        }
    </style>
</head>
<body>
    <h2>📊 Laporan Penjualan Barang</h2>

    <form method="POST" action="">
        <input type="date" name="tanggal" value="<?= htmlspecialchars($tanggal) ?>">
        <input type="submit" value="Cari">
        <a class="button" href="laporan_penjualan.php">Reset</a>
    </form>

    <?php if (!empty($tanggal)): ?>
        <h3>📄 Detail Transaksi - Tanggal <?= htmlspecialchars($tanggal) ?></h3>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pembeli</th>
                    <th>Alamat</th>
                    <th>No HP</th>
                    <th>Barang Dibeli</th>
                    <th>Jumlah</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($data && $data->num_rows > 0) {
                    $no = 1;
                    while ($row = $data->fetch_assoc()) {
                        echo "<tr>
                                <td>{$no}</td>
                                <td>{$row['username']}</td>
                                <td>{$row['alamat']}</td>
                                <td>{$row['no_hp']}</td>
                                <td>{$row['nama_barang']}</td>
                                <td>{$row['jumlah']}</td>
                                <td>{$row['tanggal']}</td>
                              </tr>";
                        $no++;
                    }
                } else {
                    echo "<tr><td colspan='7'>Tidak ada data ditemukan pada tanggal tersebut.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    <?php endif; ?>

    <div class="nav-links">
        <a href="form_pembelian.php">🛒 Kembali ke Form Pembelian</a> |
        <a href="databarang.php">📦 Lihat Stok Barang</a>
    </div>
</body>
</html>

<?php $koneksi->close(); ?>
