<?php

// sekolah_id
// Kelas

?>
<?php if ($t03_kelas->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $t03_kelas->TableCaption() ?></h4> -->
<table id="tbl_t03_kelasmaster" class="table table-bordered table-striped ewViewTable">
<?php echo $t03_kelas->TableCustomInnerHtml ?>
	<tbody>
<?php if ($t03_kelas->sekolah_id->Visible) { // sekolah_id ?>
		<tr id="r_sekolah_id">
			<td><?php echo $t03_kelas->sekolah_id->FldCaption() ?></td>
			<td<?php echo $t03_kelas->sekolah_id->CellAttributes() ?>>
<span id="el_t03_kelas_sekolah_id">
<span<?php echo $t03_kelas->sekolah_id->ViewAttributes() ?>>
<?php echo $t03_kelas->sekolah_id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t03_kelas->Kelas->Visible) { // Kelas ?>
		<tr id="r_Kelas">
			<td><?php echo $t03_kelas->Kelas->FldCaption() ?></td>
			<td<?php echo $t03_kelas->Kelas->CellAttributes() ?>>
<span id="el_t03_kelas_Kelas">
<span<?php echo $t03_kelas->Kelas->ViewAttributes() ?>>
<?php echo $t03_kelas->Kelas->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
