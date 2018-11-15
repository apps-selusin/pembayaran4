<?php

// siswa_id
// nonrutin_id
// Nilai

?>
<?php if ($t09_siswanonrutin->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $t09_siswanonrutin->TableCaption() ?></h4> -->
<table id="tbl_t09_siswanonrutinmaster" class="table table-bordered table-striped ewViewTable">
<?php echo $t09_siswanonrutin->TableCustomInnerHtml ?>
	<tbody>
<?php if ($t09_siswanonrutin->siswa_id->Visible) { // siswa_id ?>
		<tr id="r_siswa_id">
			<td><?php echo $t09_siswanonrutin->siswa_id->FldCaption() ?></td>
			<td<?php echo $t09_siswanonrutin->siswa_id->CellAttributes() ?>>
<span id="el_t09_siswanonrutin_siswa_id">
<span<?php echo $t09_siswanonrutin->siswa_id->ViewAttributes() ?>>
<?php echo $t09_siswanonrutin->siswa_id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t09_siswanonrutin->nonrutin_id->Visible) { // nonrutin_id ?>
		<tr id="r_nonrutin_id">
			<td><?php echo $t09_siswanonrutin->nonrutin_id->FldCaption() ?></td>
			<td<?php echo $t09_siswanonrutin->nonrutin_id->CellAttributes() ?>>
<span id="el_t09_siswanonrutin_nonrutin_id">
<span<?php echo $t09_siswanonrutin->nonrutin_id->ViewAttributes() ?>>
<?php echo $t09_siswanonrutin->nonrutin_id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t09_siswanonrutin->Nilai->Visible) { // Nilai ?>
		<tr id="r_Nilai">
			<td><?php echo $t09_siswanonrutin->Nilai->FldCaption() ?></td>
			<td<?php echo $t09_siswanonrutin->Nilai->CellAttributes() ?>>
<span id="el_t09_siswanonrutin_Nilai">
<span<?php echo $t09_siswanonrutin->Nilai->ViewAttributes() ?>>
<?php echo $t09_siswanonrutin->Nilai->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
