<?php

// NIS
// Nama
// kelas_id
// sekolah_id

?>
<?php if ($v01_siswa->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $v01_siswa->TableCaption() ?></h4> -->
<table id="tbl_v01_siswamaster" class="table table-bordered table-striped ewViewTable">
<?php echo $v01_siswa->TableCustomInnerHtml ?>
	<tbody>
<?php if ($v01_siswa->NIS->Visible) { // NIS ?>
		<tr id="r_NIS">
			<td><?php echo $v01_siswa->NIS->FldCaption() ?></td>
			<td<?php echo $v01_siswa->NIS->CellAttributes() ?>>
<span id="el_v01_siswa_NIS">
<span<?php echo $v01_siswa->NIS->ViewAttributes() ?>>
<?php echo $v01_siswa->NIS->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($v01_siswa->Nama->Visible) { // Nama ?>
		<tr id="r_Nama">
			<td><?php echo $v01_siswa->Nama->FldCaption() ?></td>
			<td<?php echo $v01_siswa->Nama->CellAttributes() ?>>
<span id="el_v01_siswa_Nama">
<span<?php echo $v01_siswa->Nama->ViewAttributes() ?>>
<?php echo $v01_siswa->Nama->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($v01_siswa->kelas_id->Visible) { // kelas_id ?>
		<tr id="r_kelas_id">
			<td><?php echo $v01_siswa->kelas_id->FldCaption() ?></td>
			<td<?php echo $v01_siswa->kelas_id->CellAttributes() ?>>
<span id="el_v01_siswa_kelas_id">
<span<?php echo $v01_siswa->kelas_id->ViewAttributes() ?>>
<?php echo $v01_siswa->kelas_id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($v01_siswa->sekolah_id->Visible) { // sekolah_id ?>
		<tr id="r_sekolah_id">
			<td><?php echo $v01_siswa->sekolah_id->FldCaption() ?></td>
			<td<?php echo $v01_siswa->sekolah_id->CellAttributes() ?>>
<span id="el_v01_siswa_sekolah_id">
<span<?php echo $v01_siswa->sekolah_id->ViewAttributes() ?>>
<?php echo $v01_siswa->sekolah_id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
