<?php

// Sekolah
?>
<?php if ($t02_sekolah->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $t02_sekolah->TableCaption() ?></h4> -->
<table id="tbl_t02_sekolahmaster" class="table table-bordered table-striped ewViewTable">
<?php echo $t02_sekolah->TableCustomInnerHtml ?>
	<tbody>
<?php if ($t02_sekolah->Sekolah->Visible) { // Sekolah ?>
		<tr id="r_Sekolah">
			<td><?php echo $t02_sekolah->Sekolah->FldCaption() ?></td>
			<td<?php echo $t02_sekolah->Sekolah->CellAttributes() ?>>
<span id="el_t02_sekolah_Sekolah">
<span<?php echo $t02_sekolah->Sekolah->ViewAttributes() ?>>
<?php echo $t02_sekolah->Sekolah->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
