<?php

// sekolah_id
// kelas_id
// NIS
// Nama

?>
<?php if ($t04_siswa->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $t04_siswa->TableCaption() ?></h4> -->
<table id="tbl_t04_siswamaster" class="table table-bordered table-striped ewViewTable">
<?php echo $t04_siswa->TableCustomInnerHtml ?>
	<tbody>
<?php if ($t04_siswa->sekolah_id->Visible) { // sekolah_id ?>
		<tr id="r_sekolah_id">
			<td><?php echo $t04_siswa->sekolah_id->FldCaption() ?></td>
			<td<?php echo $t04_siswa->sekolah_id->CellAttributes() ?>>
<span id="el_t04_siswa_sekolah_id">
<span<?php echo $t04_siswa->sekolah_id->ViewAttributes() ?>>
<?php echo $t04_siswa->sekolah_id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t04_siswa->kelas_id->Visible) { // kelas_id ?>
		<tr id="r_kelas_id">
			<td><?php echo $t04_siswa->kelas_id->FldCaption() ?></td>
			<td<?php echo $t04_siswa->kelas_id->CellAttributes() ?>>
<span id="el_t04_siswa_kelas_id">
<span<?php echo $t04_siswa->kelas_id->ViewAttributes() ?>>
<?php echo $t04_siswa->kelas_id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t04_siswa->NIS->Visible) { // NIS ?>
		<tr id="r_NIS">
			<td><?php echo $t04_siswa->NIS->FldCaption() ?></td>
			<td<?php echo $t04_siswa->NIS->CellAttributes() ?>>
<span id="el_t04_siswa_NIS">
<span<?php echo $t04_siswa->NIS->ViewAttributes() ?>>
<?php echo $t04_siswa->NIS->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t04_siswa->Nama->Visible) { // Nama ?>
		<tr id="r_Nama">
			<td><?php echo $t04_siswa->Nama->FldCaption() ?></td>
			<td<?php echo $t04_siswa->Nama->CellAttributes() ?>>
<span id="el_t04_siswa_Nama">
<span<?php echo $t04_siswa->Nama->ViewAttributes() ?>>
<?php echo $t04_siswa->Nama->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
