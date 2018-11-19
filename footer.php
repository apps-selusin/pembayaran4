<?php if (@$gsExport == "") { ?>
<?php if (@!$gbSkipHeaderFooter) { ?>
				<!-- right column (end) -->
				<?php if (isset($gTimer)) $gTimer->Stop() ?>
			</div>
		</div>
	</div>
	<!-- content (end) -->
	<!-- footer (begin) --><!-- ** Note: Only licensed users are allowed to remove or change the following copyright statement. ** -->
	<div id="ewFooterRow" class="ewFooterRow">	
		<div class="ewFooterText"><?php echo $Language->ProjectPhrase("FooterText") ?></div>
		<!-- Place other links, for example, disclaimer, here -->		
	</div>
	<!-- footer (end) -->	
</div>
<?php } ?>
<!-- modal dialog -->
<div id="ewModalDialog" class="modal" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h4 class="modal-title"></h4></div><div class="modal-body"></div><div class="modal-footer"></div></div></div></div>
<!-- message box -->
<div id="ewMsgBox" class="modal" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-body"></div><div class="modal-footer"><button type="button" class="btn btn-primary ewButton" data-dismiss="modal"><?php echo $Language->Phrase("MessageOK") ?></button></div></div></div></div>
<!-- prompt -->
<div id="ewPrompt" class="modal" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-body"></div><div class="modal-footer"><button type="button" class="btn btn-primary ewButton"><?php echo $Language->Phrase("MessageOK") ?></button><button type="button" class="btn btn-default ewButton" data-dismiss="modal"><?php echo $Language->Phrase("CancelBtn") ?></button></div></div></div></div>
<!-- session timer -->
<div id="ewTimer" class="modal" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-body"></div><div class="modal-footer"><button type="button" class="btn btn-primary ewButton" data-dismiss="modal"><?php echo $Language->Phrase("MessageOK") ?></button></div></div></div></div>
<!-- tooltip -->
<div id="ewTooltip"></div>
<?php } ?>
<?php if (@$gsExport == "") { ?>
<script type="text/javascript">
jQuery.get("<?php echo $EW_RELATIVE_PATH ?>phpjs/userevt13.js");
</script>
<script type="text/javascript">

// Write your global startup script here
// document.write("page loaded");
	function f_hitung_nilai_rutin(periode_awal, periode_akhir, nilai) {
		var awal_tahun = 0;
		var awal_bulan = 0;
		var nilai2 = 0;
		while (periode_awal <= periode_akhir) {

			// proses pendefinisian variabel $awal
			awal_tahun = parseInt(periode_awal.substring(0, 4));
			awal_bulan = parseInt(periode_awal.substring(periode_awal.length - 2)) + 1;
			awal_bulan2 = "00" + awal_bulan;
			awal_bulan3 = awal_bulan2.substring(awal_bulan2.length - 2);
			nilai2 += parseFloat(nilai);

			// jika $awal_bulan = 13 maka tahun + 1 dan bulan jadi 1
			if (awal_bulan2 == 13) {
				awal_tahun = awal_tahun + 1;
				awal_bulan3 = "01";
			}
			periode_awal = awal_tahun + awal_bulan3;

			//alert(periode_awal);
		}

		//$row["Nilai"].val(nilai2);
		return nilai2;
	}

	// Table 't06_siswarutintemp' Field 'Periode_Awal, Periode_Akhir'
	$('[data-table=t06_siswarutintemp][data-field=x_Periode_Awal], [data-table=t06_siswarutintemp][data-field=x_Periode_Akhir]').on(
		{ // keys = event types, values = handler functions
			"change keyup": function(e) {
				var $row = $(this).fields();

				//alert($row["siswarutin_id"].val());
				//alert($row["Nilai_Temp"].val());
				//alert($row["Periode_Awal"].val());
				//alert($row["siswa_id"].val());
				//alert("siswa_id: <?php echo $_SESSION['siswa_id']?>");
				//alert("rutin_id: "+$row["rutin_id"].val());

				var periode_awal = $row["Periode_Awal"].val();
				var periode_akhir = $row["Periode_Akhir"].val();
				var nilai = $row["Nilai_Temp"].val();

				//f_hitung_nilai_rutin(periode_awal, periode_akhir, nilai);
				$row["Nilai"].val(f_hitung_nilai_rutin(periode_awal, periode_akhir, nilai));
			}
		}
	);

	// Table 't09_siswanonrutintemp' Field 'Bayar'
	$('[data-table=t09_siswanonrutintemp][data-field=x_Bayar]').on(
		{ // keys = event types, values = handler functions
			"change keyup": function(e) {
				var $row = $(this).fields();

				//alert($row["siswarutin_id"].val());
				//alert($row["Nilai_Temp"].val());
				//alert($row["Periode_Awal"].val());
				//alert($row["siswa_id"].val());
				//alert("siswa_id: <?php echo $_SESSION['siswa_id']?>");
				//alert("rutin_id: "+$row["rutin_id"].val());
				//var periode_awal = $row["Periode_Awal"].val();
				//var periode_akhir = $row["Periode_Akhir"].val();
				//var nilai = $row["Nilai_Temp"].val();

				var nilai = parseFloat($row["Nilai"].val());
				var bayar = parseFloat($row["Bayar"].val());
				var sisa = nilai - bayar;

				//f_hitung_nilai_rutin(periode_awal, periode_akhir, nilai);
				$row["Sisa"].val(sisa);
			}
		}
	);
</script>
<?php } ?>
</body>
</html>
