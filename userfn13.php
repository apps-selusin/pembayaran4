<?php

// Global user functions
// Page Loading event
function Page_Loading() {

	//echo "Page Loading";
}

// Page Rendering event
function Page_Rendering() {

	//echo "Page Rendering";
}

// Page Unloaded event
function Page_Unloaded() {

	//echo "Page Unloaded";
}

function f_update_bayar_nonrutin($rsold, $rsnew) {

	// update pembayaran ke tabel t07_siswarutinbayar
	$awal  = $_SESSION["nonrutin_Periode_Awal"]; // 201807
	$akhir = $_SESSION["nonrutin_Periode_Akhir"]; // 201906
	while ($awal <= $akhir) {

		// proses update data
		$q = "
			update
				t10_siswanonrutinbayar
			set
				Tanggal_Bayar = '".date("Y-m-d")."',
				Nilai_Bayar = Nilai
			where
				Periode_Tahun_Bulan = '".$awal."'
				and siswanonrutin_id = ".$rsold["siswanonrutin_id"]."
			";
		Conn()->Execute($q);

		// proses pendefinisian variabel $awal
		$awal_tahun = substr($awal, 0, 4);
		$awal_bulan = substr("00".(substr($awal, -2) + 1), -2);

		// jika $awal_bulan = 13 maka tahun + 1 dan bulan jadi 1
		if ($awal_bulan == 13) {
			$awal_tahun = $awal_tahun + 1;
			$awal_bulan = "01";
		}
		$awal = $awal_tahun.$awal_bulan;
	}
}

function f_update_bayar_rutin($rsold, $rsnew) {

	// update pembayaran ke tabel t07_siswarutinbayar
	$awal  = $_SESSION["rutin_Periode_Awal"]; // 201807
	$akhir = $_SESSION["rutin_Periode_Akhir"]; // 201906
	while ($awal <= $akhir) {

		// proses update data
		$q = "
			update
				t07_siswarutinbayar
			set
				Tanggal_Bayar = '".date("Y-m-d")."',
				Nilai_Bayar = Nilai
			where
				Periode_Tahun_Bulan = '".$awal."'
				and siswarutin_id = ".$rsold["siswarutin_id"]."
			";
		Conn()->Execute($q);

		// proses pendefinisian variabel $awal
		$awal_tahun = substr($awal, 0, 4);
		$awal_bulan = substr("00".(substr($awal, -2) + 1), -2);

		// jika $awal_bulan = 13 maka tahun + 1 dan bulan jadi 1
		if ($awal_bulan == 13) {
			$awal_tahun = $awal_tahun + 1;
			$awal_bulan = "01";
		}
		$awal = $awal_tahun.$awal_bulan;
	}
}

// -----------------------------------------------------------
function f_buat_rincian_pembayaran_non_rutin($rsold, $rsnew) {

// -----------------------------------------------------------
	// ambil data tahun ajaran dan diloop selama satu periode tahun ajaran
	// mulai awal tahun ajaran hingga akhir tahun ajaran

	$q = "select * from t01_tahunajaran";
	$r = Conn()->Execute($q);
	$awal  = $r->fields["Awal_Bulan"].$r->fields["Awal_Tahun"]; // 72018
	$akhir = $r->fields["Akhir_Bulan"].$r->fields["Akhir_Tahun"]; // 62019
	$bulan = $r->fields["Awal_Bulan"] - 1;
	$tahun = $r->fields["Awal_Tahun"];
	$abulan = array("",
		"Januari",
		"Februari",
		"Maret",
		"April",
		"Mei",
		"Juni",
		"Juli",
		"Agustus",
		"September",
		"Oktober",
		"November",
		"Desember"
		);

	// simpan data di tabel rincian pembayaran non-rutin t10_siswanonrutinbayar
	while ($awal != $akhir) {
		$bulan++;
		if ($bulan == 13) {
			$bulan = 1;
			$tahun++;
		}
		$q = "insert into
			t10_siswanonrutinbayar (
				siswanonrutin_id,
				Bulan,
				Tahun,
				Nilai,
				Periode_Tahun_Bulan,
				Periode_Text
			) values (
			".$rsnew["id"].",
			".$bulan.",
			".$tahun.",
			".$rsnew["Nilai"].",
			'".$tahun.substr("00".$bulan, -2)."',
			'".$abulan[$bulan]." ".$tahun."'
			)";
		Conn()->Execute($q);
		$awal = $bulan.$tahun;
	}

	// simpan data di tabel t09_siswanonrutintemp
	$q = "insert into
		t09_siswanonrutintemp (
			siswa_id,
			nonrutin_id,
			siswanonrutin_id
		) values (
		".$rsnew["siswa_id"].",
		".$rsnew["nonrutin_id"].",
		".$rsnew["id"]."
		)
		";
	Conn()->Execute($q);
}

// ---------------------------------------------------
// end of function f_buat_rincian_pembayaran_non_rutin
// ---------------------------------------------------
// -------------------------------------------------
function f_buat_rincian_pembayaran($rsold, $rsnew) {

// -------------------------------------------------
	// ambil data tahun ajaran dan diloop selama satu periode tahun ajaran
	// mulai awal tahun ajaran hingga akhir tahun ajaran

	$q = "select * from t01_tahunajaran";
	$r = Conn()->Execute($q);
	$awal  = $r->fields["Awal_Bulan"].$r->fields["Awal_Tahun"]; // 72018
	$akhir = $r->fields["Akhir_Bulan"].$r->fields["Akhir_Tahun"]; // 62019
	$bulan = $r->fields["Awal_Bulan"] - 1;
	$tahun = $r->fields["Awal_Tahun"];
	/*

	// simpan data di tabel [temporary pembayaran rutin]
	$q = "insert into
		t07_siswarutinbayar (
			siswarutin_id,
			Nilai
		) values (
		".$rsnew["id"].",
		".$rsnew["Nilai"]."
		)";
	Conn()->Execute($q);
	*/
	$abulan = array("",
		"Januari",
		"Februari",
		"Maret",
		"April",
		"Mei",
		"Juni",
		"Juli",
		"Agustus",
		"September",
		"Oktober",
		"November",
		"Desember"
		);

	// simpan data di tabel rincian pembayaran rutin t07_siswarutinbayar
	while ($awal != $akhir) {
		$bulan++;
		if ($bulan == 13) {
			$bulan = 1;
			$tahun++;
		}
		$q = "insert into
			t07_siswarutinbayar (
				siswarutin_id,
				Bulan,
				Tahun,
				Nilai,
				Periode_Tahun_Bulan,
				Periode_Text
			) values (
			".$rsnew["id"].",
			".$bulan.",
			".$tahun.",
			".$rsnew["Nilai"].",
			'".$tahun.substr("00".$bulan, -2)."',
			'".$abulan[$bulan]." ".$tahun."'
			)";
		Conn()->Execute($q);
		$awal = $bulan.$tahun;
	}

	// simpan data di tabel t06_siswarutintemp
	$q = "insert into
		t06_siswarutintemp (
			siswa_id,
			rutin_id,
			siswarutin_id
		) values (
		".$rsnew["siswa_id"].",
		".$rsnew["rutin_id"].",
		".$rsnew["id"]."
		)
		";
	Conn()->Execute($q);
}

// -----------------------------------------
// end of function f_buat_rincian_pembayaran
// -----------------------------------------

?>
