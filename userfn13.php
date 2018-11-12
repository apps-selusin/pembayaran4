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

function f_buat_rincian_pembayaran($rsold, $rsnew) {

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
				Nilai
			) values (
			".$rsnew["id"].",
			".$bulan.",
			".$tahun.",
			".$rsnew["Nilai"]."
			)";
		Conn()->Execute($q);
		$awal = $bulan.$tahun;
	}
}
?>
