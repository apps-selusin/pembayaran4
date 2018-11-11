<?php

// siswa_id
// rutin_id
// Nilai

?>
<?php if ($t06_siswarutin->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $t06_siswarutin->TableCaption() ?></h4> -->
<table id="tbl_t06_siswarutinmaster" class="table table-bordered table-striped ewViewTable">
<?php echo $t06_siswarutin->TableCustomInnerHtml ?>
	<tbody>
<?php if ($t06_siswarutin->siswa_id->Visible) { // siswa_id ?>
		<tr id="r_siswa_id">
			<td><?php echo $t06_siswarutin->siswa_id->FldCaption() ?></td>
			<td<?php echo $t06_siswarutin->siswa_id->CellAttributes() ?>>
<span id="el_t06_siswarutin_siswa_id">
<span<?php echo $t06_siswarutin->siswa_id->ViewAttributes() ?>>
<?php echo $t06_siswarutin->siswa_id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t06_siswarutin->rutin_id->Visible) { // rutin_id ?>
		<tr id="r_rutin_id">
			<td><?php echo $t06_siswarutin->rutin_id->FldCaption() ?></td>
			<td<?php echo $t06_siswarutin->rutin_id->CellAttributes() ?>>
<span id="el_t06_siswarutin_rutin_id">
<span<?php echo $t06_siswarutin->rutin_id->ViewAttributes() ?>>
<?php echo $t06_siswarutin->rutin_id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t06_siswarutin->Nilai->Visible) { // Nilai ?>
		<tr id="r_Nilai">
			<td><?php echo $t06_siswarutin->Nilai->FldCaption() ?></td>
			<td<?php echo $t06_siswarutin->Nilai->CellAttributes() ?>>
<span id="el_t06_siswarutin_Nilai">
<span<?php echo $t06_siswarutin->Nilai->ViewAttributes() ?>>
<?php echo $t06_siswarutin->Nilai->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
