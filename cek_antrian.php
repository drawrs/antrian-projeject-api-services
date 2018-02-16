<?php
// Include koneksi php
require "koneksi.php";

$query = $conn->query("SELECT * FROM tb_antrian ORDER BY id DESC");
$data_antrian =  $query->fetch_assoc();

$status_antrian = $data_antrian['status_antrian'];
$nomor_antrian = $data_antrian['nomor_antrian'];
$id_antrian_terakhir = $data_antrian['id'];

// Cek nomor antrianya statusnya open / close
if ($status_antrian == "open") {
	// kalau nomor antrian terakhir itu statusnya = open
	// langsung tampilkankan
	$data_akhir = $data_antrian;
} else {
	// tapi kalau antriannya udah close
	// ya kita tambahin dulu

	/* AWAL PERINTAH BUAT INSERT DATA ANTRIAN*/
	// INSERT DATA 
	$id_user = "1";
	$nomor_baru = $id_antrian_terakhir + 1;
	if ($nomor_baru <= 9) {
		$nomor_antrian_fix = "00". $nomor_baru; // 009
	} else if ($nomor_baru <= 99) {
		$nomor_antrian_fix = "0" . $nomor_baru; // 099
	} else {
		$nomor_antrian_fix = $nomor_baru; // 100 >
	}
	// printah SQL nya
	$sql_insert_data = "INSERT INTO tb_antrian (id_user, nomor_antrian, status_antrian) 
					VALUES ('$id_user', '$nomor_antrian_fix', 'open')";
	// Eksekusi Query
	$query_insert = $conn->query($sql_insert_data); // ngga di masukin variable gapap karena ngga kita olah lagi
	/*AKHIR PERINTAH BUAT INSERT DATA ANTRIAN*/
	// Setelah ditambah, Select data lagi 
	// tampilin
	$query = $conn->query("SELECT * FROM tb_antrian ORDER BY id DESC");
	$data_antrian =  $query->fetch_assoc();

	$data_akhir = $data_antrian;
}

header('Content-Type: application/json'); 
echo json_encode($data_akhir)
