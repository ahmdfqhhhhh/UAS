<?php
// Hindari output sebelum header
ob_start();

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Koneksi database
$host = "localhost";
$user = "root";
$password = "";
$database = "belajar";

$conn = mysqli_connect($host, $user, $password, $database);
if (!$conn) {
    http_response_code(500);
    die("Koneksi ke database gagal.");
}

// Ambil data
$query = "SELECT * FROM barang";
$result = mysqli_query($conn, $query);

// Inisialisasi spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Header kolom
$sheet->setCellValue('A1', 'ID Barang')
      ->setCellValue('B1', 'Nama Barang')
      ->setCellValue('C1', 'Harga')
      ->setCellValue('D1', 'Stok');

// Isi data
$rowNum = 2;
while ($row = mysqli_fetch_assoc($result)) {
    $sheet->setCellValue('A' . $rowNum, $row['id_barang']);
    $sheet->setCellValue('B' . $rowNum, $row['nama_barang']);
    $sheet->setCellValue('C' . $rowNum, $row['harga']);
    $sheet->setCellValue('D' . $rowNum, $row['stok']);
    $rowNum++;
}

mysqli_close($conn);

// Hapus semua buffer output sebelum mengirim file
ob_end_clean();

// Header Excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="data_barang.xlsx"');
header('Cache-Control: max-age=0');

// Tulis file ke output
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
