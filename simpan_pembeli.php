<?php
$koneksi = new mysqli("localhost", "root", "", "belajar");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Ambil data dari form
$username    = $_POST['username']; // diketik manual oleh admin
$alamat      = $_POST['alamat'];
$no_hp       = $_POST['no_hp'];
$jumlah      = $_POST['jumlah'];
$harga       = $_POST['harga'];
$id_barang   = $_POST['id_barang'];
$uang_bayar  = (int)$_POST['uang_bayar'];
$tanggal     = date("Y-m-d H:i:s");

$total = 0;

// Mulai struk
echo "<div style='width: 300px; margin: auto; font-family: monospace; background: #fff; padding: 15px;'>";

// Header toko
echo "<div style='text-align: center; margin-bottom: 10px;'>";
echo "<b>TOKO AF-TECH</b><br>";
echo "Jl. pemotongan pasar, Sumpiuh, Banyumas<br>";
echo "Telp: 0895-1399-7672<br>";
echo str_repeat('=', 43) . "<br>";
echo "Tanggal : " . date("d/m/Y H:i:s") . "<br>";
echo str_repeat('=', 43) . "<br>";
echo "</div>";

// Info pembeli
echo "Nama Pembeli : $username<br>";
echo "Alamat       : $alamat<br>";
echo "No HP        : $no_hp<br>";
echo str_repeat('=', 43) . "<br>";

// Daftar belanja
for ($i = 0; $i < count($id_barang); $i++) {
    $jml = (int)$jumlah[$i];
    $hrg = (int)$harga[$i];
    $id  = (int)$id_barang[$i];
    $sub = $jml * $hrg;
    $total += $sub;

    // Ambil nama barang
    $barangQuery = $koneksi->query("SELECT nama_barang FROM barang WHERE id_barang = '$id' LIMIT 1");
    $barangRow = $barangQuery->fetch_assoc();
    $nama_barang = strtoupper($barangRow['nama_barang'] ?? 'Barang Tidak Ditemukan');

    // Update stok
    $koneksi->query("UPDATE barang SET stok = stok - $jml WHERE id_barang = '$id'");

    // Simpan ke tabel pembeli
    $koneksi->query("INSERT INTO pembeli (username, id_barang, alamat, no_hp, jumlah, harga, tanggal)
                     VALUES ('$username', '$id', '$alamat', '$no_hp', '$jml', '$hrg', '$tanggal')");

    // Cetak item
    echo "<b>$nama_barang</b><br>";
    echo "{$jml} x Rp" . number_format($hrg, 0, ',', '.') . " = Rp" . number_format($sub, 0, ',', '.') . "<br><br>";
}

echo str_repeat('-', 41) . "<br>";

// Format total, bayar, kembali
function formatBaris($label, $angka) {
    $label = str_pad($label, 10, " ", STR_PAD_RIGHT);
    $nilai = "Rp" . number_format($angka, 0, ',', '.');
    $nilai = str_pad($nilai, 15, " ", STR_PAD_LEFT);
    return $label . " : " . $nilai . "<br>";
}

$kembalian = $uang_bayar - $total;
echo "<pre style='font-family: monospace;'>";
echo formatBaris("Total", $total);
echo formatBaris("Bayar", $uang_bayar);
echo formatBaris("Kembali", $kembalian);
echo "</pre>";

echo str_repeat('=', 43) . "<br>";

// Footer
echo "<div style='text-align: center; font-size: 12px; margin-top: 10px;'>";
echo "Terima kasih telah berbelanja<br>";
echo "Barang yang sudah dibeli tidak dapat ditukar<br>";
echo "- AF-TECH -";
echo "</div>";
echo "</div>";
?>
