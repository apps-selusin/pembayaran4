<?php

// Create page object
if (!isset($t06_siswarutintemp_grid)) $t06_siswarutintemp_grid = new ct06_siswarutintemp_grid();

// Page init
$t06_siswarutintemp_grid->Page_Init();

// Page main
$t06_siswarutintemp_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t06_siswarutintemp_grid->Page_Render();
?>
<?php if ($t06_siswarutintemp->Export == "") { ?>
<script type="text/javascript">

// Form object
var ft06_siswarutintempgrid = new ew_Form("ft06_siswarutintempgrid", "grid");
ft06_siswarutintempgrid.FormKeyCountName = '<?php echo $t06_siswarutintemp_grid->FormKeyCountName ?>';

// Validate form
ft06_siswarutintempgrid.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
		var checkrow = (gridinsert) ? !this.EmptyRow(infix) : true;
		if (checkrow) {
			addcnt++;
			elm = this.GetElements("x" + infix + "_siswa_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t06_siswarutintemp->siswa_id->FldCaption(), $t06_siswarutintemp->siswa_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_rutin_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t06_siswarutintemp->rutin_id->FldCaption(), $t06_siswarutintemp->rutin_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Nilai");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t06_siswarutintemp->Nilai->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
ft06_siswarutintempgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "siswa_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "rutin_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Periode_Awal", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Periode_Akhir", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Nilai", false)) return false;
	return true;
}

// Form_CustomValidate event
ft06_siswarutintempgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft06_siswarutintempgrid.ValidateRequired = true;
<?php } else { ?>
ft06_siswarutintempgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft06_siswarutintempgrid.Lists["x_siswa_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_NIS","x_Nama","x_kelas_id","x_sekolah_id"],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t04_siswa"};
ft06_siswarutintempgrid.Lists["x_rutin_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_Jenis","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t05_rutin"};
ft06_siswarutintempgrid.Lists["x_Periode_Awal"] = {"LinkField":"x_Periode_Tahun_Bulan","Ajax":true,"AutoFill":false,"DisplayFields":["x_Periode_Text","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t07_siswarutinbayar"};
ft06_siswarutintempgrid.Lists["x_Periode_Akhir"] = {"LinkField":"x_Periode_Tahun_Bulan","Ajax":true,"AutoFill":false,"DisplayFields":["x_Periode_Text","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t07_siswarutinbayar"};

// Form object for search
</script>
<?php } ?>
<?php
if ($t06_siswarutintemp->CurrentAction == "gridadd") {
	if ($t06_siswarutintemp->CurrentMode == "copy") {
		$bSelectLimit = $t06_siswarutintemp_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$t06_siswarutintemp_grid->TotalRecs = $t06_siswarutintemp->SelectRecordCount();
			$t06_siswarutintemp_grid->Recordset = $t06_siswarutintemp_grid->LoadRecordset($t06_siswarutintemp_grid->StartRec-1, $t06_siswarutintemp_grid->DisplayRecs);
		} else {
			if ($t06_siswarutintemp_grid->Recordset = $t06_siswarutintemp_grid->LoadRecordset())
				$t06_siswarutintemp_grid->TotalRecs = $t06_siswarutintemp_grid->Recordset->RecordCount();
		}
		$t06_siswarutintemp_grid->StartRec = 1;
		$t06_siswarutintemp_grid->DisplayRecs = $t06_siswarutintemp_grid->TotalRecs;
	} else {
		$t06_siswarutintemp->CurrentFilter = "0=1";
		$t06_siswarutintemp_grid->StartRec = 1;
		$t06_siswarutintemp_grid->DisplayRecs = $t06_siswarutintemp->GridAddRowCount;
	}
	$t06_siswarutintemp_grid->TotalRecs = $t06_siswarutintemp_grid->DisplayRecs;
	$t06_siswarutintemp_grid->StopRec = $t06_siswarutintemp_grid->DisplayRecs;
} else {
	$bSelectLimit = $t06_siswarutintemp_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($t06_siswarutintemp_grid->TotalRecs <= 0)
			$t06_siswarutintemp_grid->TotalRecs = $t06_siswarutintemp->SelectRecordCount();
	} else {
		if (!$t06_siswarutintemp_grid->Recordset && ($t06_siswarutintemp_grid->Recordset = $t06_siswarutintemp_grid->LoadRecordset()))
			$t06_siswarutintemp_grid->TotalRecs = $t06_siswarutintemp_grid->Recordset->RecordCount();
	}
	$t06_siswarutintemp_grid->StartRec = 1;
	$t06_siswarutintemp_grid->DisplayRecs = $t06_siswarutintemp_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$t06_siswarutintemp_grid->Recordset = $t06_siswarutintemp_grid->LoadRecordset($t06_siswarutintemp_grid->StartRec-1, $t06_siswarutintemp_grid->DisplayRecs);

	// Set no record found message
	if ($t06_siswarutintemp->CurrentAction == "" && $t06_siswarutintemp_grid->TotalRecs == 0) {
		if ($t06_siswarutintemp_grid->SearchWhere == "0=101")
			$t06_siswarutintemp_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$t06_siswarutintemp_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$t06_siswarutintemp_grid->RenderOtherOptions();
?>
<?php $t06_siswarutintemp_grid->ShowPageHeader(); ?>
<?php
$t06_siswarutintemp_grid->ShowMessage();
?>
<?php if ($t06_siswarutintemp_grid->TotalRecs > 0 || $t06_siswarutintemp->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid t06_siswarutintemp">
<div id="ft06_siswarutintempgrid" class="ewForm form-inline">
<div id="gmp_t06_siswarutintemp" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_t06_siswarutintempgrid" class="table ewTable">
<?php echo $t06_siswarutintemp->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$t06_siswarutintemp_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$t06_siswarutintemp_grid->RenderListOptions();

// Render list options (header, left)
$t06_siswarutintemp_grid->ListOptions->Render("header", "left");
?>
<?php if ($t06_siswarutintemp->siswa_id->Visible) { // siswa_id ?>
	<?php if ($t06_siswarutintemp->SortUrl($t06_siswarutintemp->siswa_id) == "") { ?>
		<th data-name="siswa_id"><div id="elh_t06_siswarutintemp_siswa_id" class="t06_siswarutintemp_siswa_id"><div class="ewTableHeaderCaption"><?php echo $t06_siswarutintemp->siswa_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="siswa_id"><div><div id="elh_t06_siswarutintemp_siswa_id" class="t06_siswarutintemp_siswa_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t06_siswarutintemp->siswa_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t06_siswarutintemp->siswa_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t06_siswarutintemp->siswa_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t06_siswarutintemp->rutin_id->Visible) { // rutin_id ?>
	<?php if ($t06_siswarutintemp->SortUrl($t06_siswarutintemp->rutin_id) == "") { ?>
		<th data-name="rutin_id"><div id="elh_t06_siswarutintemp_rutin_id" class="t06_siswarutintemp_rutin_id"><div class="ewTableHeaderCaption"><?php echo $t06_siswarutintemp->rutin_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="rutin_id"><div><div id="elh_t06_siswarutintemp_rutin_id" class="t06_siswarutintemp_rutin_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t06_siswarutintemp->rutin_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t06_siswarutintemp->rutin_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t06_siswarutintemp->rutin_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t06_siswarutintemp->Periode_Awal->Visible) { // Periode_Awal ?>
	<?php if ($t06_siswarutintemp->SortUrl($t06_siswarutintemp->Periode_Awal) == "") { ?>
		<th data-name="Periode_Awal"><div id="elh_t06_siswarutintemp_Periode_Awal" class="t06_siswarutintemp_Periode_Awal"><div class="ewTableHeaderCaption"><?php echo $t06_siswarutintemp->Periode_Awal->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Periode_Awal"><div><div id="elh_t06_siswarutintemp_Periode_Awal" class="t06_siswarutintemp_Periode_Awal">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t06_siswarutintemp->Periode_Awal->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t06_siswarutintemp->Periode_Awal->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t06_siswarutintemp->Periode_Awal->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t06_siswarutintemp->Periode_Akhir->Visible) { // Periode_Akhir ?>
	<?php if ($t06_siswarutintemp->SortUrl($t06_siswarutintemp->Periode_Akhir) == "") { ?>
		<th data-name="Periode_Akhir"><div id="elh_t06_siswarutintemp_Periode_Akhir" class="t06_siswarutintemp_Periode_Akhir"><div class="ewTableHeaderCaption"><?php echo $t06_siswarutintemp->Periode_Akhir->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Periode_Akhir"><div><div id="elh_t06_siswarutintemp_Periode_Akhir" class="t06_siswarutintemp_Periode_Akhir">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t06_siswarutintemp->Periode_Akhir->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t06_siswarutintemp->Periode_Akhir->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t06_siswarutintemp->Periode_Akhir->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t06_siswarutintemp->Nilai->Visible) { // Nilai ?>
	<?php if ($t06_siswarutintemp->SortUrl($t06_siswarutintemp->Nilai) == "") { ?>
		<th data-name="Nilai"><div id="elh_t06_siswarutintemp_Nilai" class="t06_siswarutintemp_Nilai"><div class="ewTableHeaderCaption"><?php echo $t06_siswarutintemp->Nilai->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nilai"><div><div id="elh_t06_siswarutintemp_Nilai" class="t06_siswarutintemp_Nilai">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t06_siswarutintemp->Nilai->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t06_siswarutintemp->Nilai->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t06_siswarutintemp->Nilai->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$t06_siswarutintemp_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$t06_siswarutintemp_grid->StartRec = 1;
$t06_siswarutintemp_grid->StopRec = $t06_siswarutintemp_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($t06_siswarutintemp_grid->FormKeyCountName) && ($t06_siswarutintemp->CurrentAction == "gridadd" || $t06_siswarutintemp->CurrentAction == "gridedit" || $t06_siswarutintemp->CurrentAction == "F")) {
		$t06_siswarutintemp_grid->KeyCount = $objForm->GetValue($t06_siswarutintemp_grid->FormKeyCountName);
		$t06_siswarutintemp_grid->StopRec = $t06_siswarutintemp_grid->StartRec + $t06_siswarutintemp_grid->KeyCount - 1;
	}
}
$t06_siswarutintemp_grid->RecCnt = $t06_siswarutintemp_grid->StartRec - 1;
if ($t06_siswarutintemp_grid->Recordset && !$t06_siswarutintemp_grid->Recordset->EOF) {
	$t06_siswarutintemp_grid->Recordset->MoveFirst();
	$bSelectLimit = $t06_siswarutintemp_grid->UseSelectLimit;
	if (!$bSelectLimit && $t06_siswarutintemp_grid->StartRec > 1)
		$t06_siswarutintemp_grid->Recordset->Move($t06_siswarutintemp_grid->StartRec - 1);
} elseif (!$t06_siswarutintemp->AllowAddDeleteRow && $t06_siswarutintemp_grid->StopRec == 0) {
	$t06_siswarutintemp_grid->StopRec = $t06_siswarutintemp->GridAddRowCount;
}

// Initialize aggregate
$t06_siswarutintemp->RowType = EW_ROWTYPE_AGGREGATEINIT;
$t06_siswarutintemp->ResetAttrs();
$t06_siswarutintemp_grid->RenderRow();
if ($t06_siswarutintemp->CurrentAction == "gridadd")
	$t06_siswarutintemp_grid->RowIndex = 0;
if ($t06_siswarutintemp->CurrentAction == "gridedit")
	$t06_siswarutintemp_grid->RowIndex = 0;
while ($t06_siswarutintemp_grid->RecCnt < $t06_siswarutintemp_grid->StopRec) {
	$t06_siswarutintemp_grid->RecCnt++;
	if (intval($t06_siswarutintemp_grid->RecCnt) >= intval($t06_siswarutintemp_grid->StartRec)) {
		$t06_siswarutintemp_grid->RowCnt++;
		if ($t06_siswarutintemp->CurrentAction == "gridadd" || $t06_siswarutintemp->CurrentAction == "gridedit" || $t06_siswarutintemp->CurrentAction == "F") {
			$t06_siswarutintemp_grid->RowIndex++;
			$objForm->Index = $t06_siswarutintemp_grid->RowIndex;
			if ($objForm->HasValue($t06_siswarutintemp_grid->FormActionName))
				$t06_siswarutintemp_grid->RowAction = strval($objForm->GetValue($t06_siswarutintemp_grid->FormActionName));
			elseif ($t06_siswarutintemp->CurrentAction == "gridadd")
				$t06_siswarutintemp_grid->RowAction = "insert";
			else
				$t06_siswarutintemp_grid->RowAction = "";
		}

		// Set up key count
		$t06_siswarutintemp_grid->KeyCount = $t06_siswarutintemp_grid->RowIndex;

		// Init row class and style
		$t06_siswarutintemp->ResetAttrs();
		$t06_siswarutintemp->CssClass = "";
		if ($t06_siswarutintemp->CurrentAction == "gridadd") {
			if ($t06_siswarutintemp->CurrentMode == "copy") {
				$t06_siswarutintemp_grid->LoadRowValues($t06_siswarutintemp_grid->Recordset); // Load row values
				$t06_siswarutintemp_grid->SetRecordKey($t06_siswarutintemp_grid->RowOldKey, $t06_siswarutintemp_grid->Recordset); // Set old record key
			} else {
				$t06_siswarutintemp_grid->LoadDefaultValues(); // Load default values
				$t06_siswarutintemp_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$t06_siswarutintemp_grid->LoadRowValues($t06_siswarutintemp_grid->Recordset); // Load row values
		}
		$t06_siswarutintemp->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($t06_siswarutintemp->CurrentAction == "gridadd") // Grid add
			$t06_siswarutintemp->RowType = EW_ROWTYPE_ADD; // Render add
		if ($t06_siswarutintemp->CurrentAction == "gridadd" && $t06_siswarutintemp->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$t06_siswarutintemp_grid->RestoreCurrentRowFormValues($t06_siswarutintemp_grid->RowIndex); // Restore form values
		if ($t06_siswarutintemp->CurrentAction == "gridedit") { // Grid edit
			if ($t06_siswarutintemp->EventCancelled) {
				$t06_siswarutintemp_grid->RestoreCurrentRowFormValues($t06_siswarutintemp_grid->RowIndex); // Restore form values
			}
			if ($t06_siswarutintemp_grid->RowAction == "insert")
				$t06_siswarutintemp->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$t06_siswarutintemp->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($t06_siswarutintemp->CurrentAction == "gridedit" && ($t06_siswarutintemp->RowType == EW_ROWTYPE_EDIT || $t06_siswarutintemp->RowType == EW_ROWTYPE_ADD) && $t06_siswarutintemp->EventCancelled) // Update failed
			$t06_siswarutintemp_grid->RestoreCurrentRowFormValues($t06_siswarutintemp_grid->RowIndex); // Restore form values
		if ($t06_siswarutintemp->RowType == EW_ROWTYPE_EDIT) // Edit row
			$t06_siswarutintemp_grid->EditRowCnt++;
		if ($t06_siswarutintemp->CurrentAction == "F") // Confirm row
			$t06_siswarutintemp_grid->RestoreCurrentRowFormValues($t06_siswarutintemp_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$t06_siswarutintemp->RowAttrs = array_merge($t06_siswarutintemp->RowAttrs, array('data-rowindex'=>$t06_siswarutintemp_grid->RowCnt, 'id'=>'r' . $t06_siswarutintemp_grid->RowCnt . '_t06_siswarutintemp', 'data-rowtype'=>$t06_siswarutintemp->RowType));

		// Render row
		$t06_siswarutintemp_grid->RenderRow();

		// Render list options
		$t06_siswarutintemp_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($t06_siswarutintemp_grid->RowAction <> "delete" && $t06_siswarutintemp_grid->RowAction <> "insertdelete" && !($t06_siswarutintemp_grid->RowAction == "insert" && $t06_siswarutintemp->CurrentAction == "F" && $t06_siswarutintemp_grid->EmptyRow())) {
?>
	<tr<?php echo $t06_siswarutintemp->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t06_siswarutintemp_grid->ListOptions->Render("body", "left", $t06_siswarutintemp_grid->RowCnt);
?>
	<?php if ($t06_siswarutintemp->siswa_id->Visible) { // siswa_id ?>
		<td data-name="siswa_id"<?php echo $t06_siswarutintemp->siswa_id->CellAttributes() ?>>
<?php if ($t06_siswarutintemp->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($t06_siswarutintemp->siswa_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $t06_siswarutintemp_grid->RowCnt ?>_t06_siswarutintemp_siswa_id" class="form-group t06_siswarutintemp_siswa_id">
<span<?php echo $t06_siswarutintemp->siswa_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t06_siswarutintemp->siswa_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_siswa_id" name="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_siswa_id" value="<?php echo ew_HtmlEncode($t06_siswarutintemp->siswa_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $t06_siswarutintemp_grid->RowCnt ?>_t06_siswarutintemp_siswa_id" class="form-group t06_siswarutintemp_siswa_id">
<?php
$wrkonchange = trim(" " . @$t06_siswarutintemp->siswa_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t06_siswarutintemp->siswa_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_siswa_id" style="white-space: nowrap; z-index: <?php echo (9000 - $t06_siswarutintemp_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_siswa_id" id="sv_x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_siswa_id" value="<?php echo $t06_siswarutintemp->siswa_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($t06_siswarutintemp->siswa_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t06_siswarutintemp->siswa_id->getPlaceHolder()) ?>"<?php echo $t06_siswarutintemp->siswa_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t06_siswarutintemp" data-field="x_siswa_id" data-value-separator="<?php echo $t06_siswarutintemp->siswa_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_siswa_id" id="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_siswa_id" value="<?php echo ew_HtmlEncode($t06_siswarutintemp->siswa_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_siswa_id" id="q_x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_siswa_id" value="<?php echo $t06_siswarutintemp->siswa_id->LookupFilterQuery(true) ?>">
<script type="text/javascript">
ft06_siswarutintempgrid.CreateAutoSuggest({"id":"x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_siswa_id","forceSelect":false});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="t06_siswarutintemp" data-field="x_siswa_id" name="o<?php echo $t06_siswarutintemp_grid->RowIndex ?>_siswa_id" id="o<?php echo $t06_siswarutintemp_grid->RowIndex ?>_siswa_id" value="<?php echo ew_HtmlEncode($t06_siswarutintemp->siswa_id->OldValue) ?>">
<?php } ?>
<?php if ($t06_siswarutintemp->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t06_siswarutintemp_grid->RowCnt ?>_t06_siswarutintemp_siswa_id" class="form-group t06_siswarutintemp_siswa_id">
<span<?php echo $t06_siswarutintemp->siswa_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t06_siswarutintemp->siswa_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="t06_siswarutintemp" data-field="x_siswa_id" name="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_siswa_id" id="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_siswa_id" value="<?php echo ew_HtmlEncode($t06_siswarutintemp->siswa_id->CurrentValue) ?>">
<?php } ?>
<?php if ($t06_siswarutintemp->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t06_siswarutintemp_grid->RowCnt ?>_t06_siswarutintemp_siswa_id" class="t06_siswarutintemp_siswa_id">
<span<?php echo $t06_siswarutintemp->siswa_id->ViewAttributes() ?>>
<?php echo $t06_siswarutintemp->siswa_id->ListViewValue() ?></span>
</span>
<?php if ($t06_siswarutintemp->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t06_siswarutintemp" data-field="x_siswa_id" name="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_siswa_id" id="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_siswa_id" value="<?php echo ew_HtmlEncode($t06_siswarutintemp->siswa_id->FormValue) ?>">
<input type="hidden" data-table="t06_siswarutintemp" data-field="x_siswa_id" name="o<?php echo $t06_siswarutintemp_grid->RowIndex ?>_siswa_id" id="o<?php echo $t06_siswarutintemp_grid->RowIndex ?>_siswa_id" value="<?php echo ew_HtmlEncode($t06_siswarutintemp->siswa_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t06_siswarutintemp" data-field="x_siswa_id" name="ft06_siswarutintempgrid$x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_siswa_id" id="ft06_siswarutintempgrid$x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_siswa_id" value="<?php echo ew_HtmlEncode($t06_siswarutintemp->siswa_id->FormValue) ?>">
<input type="hidden" data-table="t06_siswarutintemp" data-field="x_siswa_id" name="ft06_siswarutintempgrid$o<?php echo $t06_siswarutintemp_grid->RowIndex ?>_siswa_id" id="ft06_siswarutintempgrid$o<?php echo $t06_siswarutintemp_grid->RowIndex ?>_siswa_id" value="<?php echo ew_HtmlEncode($t06_siswarutintemp->siswa_id->OldValue) ?>">
<?php } ?>
<?php } ?>
<a id="<?php echo $t06_siswarutintemp_grid->PageObjName . "_row_" . $t06_siswarutintemp_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($t06_siswarutintemp->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="t06_siswarutintemp" data-field="x_id" name="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_id" id="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t06_siswarutintemp->id->CurrentValue) ?>">
<input type="hidden" data-table="t06_siswarutintemp" data-field="x_id" name="o<?php echo $t06_siswarutintemp_grid->RowIndex ?>_id" id="o<?php echo $t06_siswarutintemp_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t06_siswarutintemp->id->OldValue) ?>">
<?php } ?>
<?php if ($t06_siswarutintemp->RowType == EW_ROWTYPE_EDIT || $t06_siswarutintemp->CurrentMode == "edit") { ?>
<input type="hidden" data-table="t06_siswarutintemp" data-field="x_id" name="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_id" id="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t06_siswarutintemp->id->CurrentValue) ?>">
<?php } ?>
	<?php if ($t06_siswarutintemp->rutin_id->Visible) { // rutin_id ?>
		<td data-name="rutin_id"<?php echo $t06_siswarutintemp->rutin_id->CellAttributes() ?>>
<?php if ($t06_siswarutintemp->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t06_siswarutintemp_grid->RowCnt ?>_t06_siswarutintemp_rutin_id" class="form-group t06_siswarutintemp_rutin_id">
<?php
$wrkonchange = trim(" " . @$t06_siswarutintemp->rutin_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t06_siswarutintemp->rutin_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_rutin_id" style="white-space: nowrap; z-index: <?php echo (9000 - $t06_siswarutintemp_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_rutin_id" id="sv_x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_rutin_id" value="<?php echo $t06_siswarutintemp->rutin_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($t06_siswarutintemp->rutin_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t06_siswarutintemp->rutin_id->getPlaceHolder()) ?>"<?php echo $t06_siswarutintemp->rutin_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t06_siswarutintemp" data-field="x_rutin_id" data-value-separator="<?php echo $t06_siswarutintemp->rutin_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_rutin_id" id="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_rutin_id" value="<?php echo ew_HtmlEncode($t06_siswarutintemp->rutin_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_rutin_id" id="q_x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_rutin_id" value="<?php echo $t06_siswarutintemp->rutin_id->LookupFilterQuery(true) ?>">
<script type="text/javascript">
ft06_siswarutintempgrid.CreateAutoSuggest({"id":"x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_rutin_id","forceSelect":false});
</script>
</span>
<input type="hidden" data-table="t06_siswarutintemp" data-field="x_rutin_id" name="o<?php echo $t06_siswarutintemp_grid->RowIndex ?>_rutin_id" id="o<?php echo $t06_siswarutintemp_grid->RowIndex ?>_rutin_id" value="<?php echo ew_HtmlEncode($t06_siswarutintemp->rutin_id->OldValue) ?>">
<?php } ?>
<?php if ($t06_siswarutintemp->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t06_siswarutintemp_grid->RowCnt ?>_t06_siswarutintemp_rutin_id" class="form-group t06_siswarutintemp_rutin_id">
<span<?php echo $t06_siswarutintemp->rutin_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t06_siswarutintemp->rutin_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="t06_siswarutintemp" data-field="x_rutin_id" name="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_rutin_id" id="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_rutin_id" value="<?php echo ew_HtmlEncode($t06_siswarutintemp->rutin_id->CurrentValue) ?>">
<?php } ?>
<?php if ($t06_siswarutintemp->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t06_siswarutintemp_grid->RowCnt ?>_t06_siswarutintemp_rutin_id" class="t06_siswarutintemp_rutin_id">
<span<?php echo $t06_siswarutintemp->rutin_id->ViewAttributes() ?>>
<?php echo $t06_siswarutintemp->rutin_id->ListViewValue() ?></span>
</span>
<?php if ($t06_siswarutintemp->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t06_siswarutintemp" data-field="x_rutin_id" name="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_rutin_id" id="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_rutin_id" value="<?php echo ew_HtmlEncode($t06_siswarutintemp->rutin_id->FormValue) ?>">
<input type="hidden" data-table="t06_siswarutintemp" data-field="x_rutin_id" name="o<?php echo $t06_siswarutintemp_grid->RowIndex ?>_rutin_id" id="o<?php echo $t06_siswarutintemp_grid->RowIndex ?>_rutin_id" value="<?php echo ew_HtmlEncode($t06_siswarutintemp->rutin_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t06_siswarutintemp" data-field="x_rutin_id" name="ft06_siswarutintempgrid$x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_rutin_id" id="ft06_siswarutintempgrid$x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_rutin_id" value="<?php echo ew_HtmlEncode($t06_siswarutintemp->rutin_id->FormValue) ?>">
<input type="hidden" data-table="t06_siswarutintemp" data-field="x_rutin_id" name="ft06_siswarutintempgrid$o<?php echo $t06_siswarutintemp_grid->RowIndex ?>_rutin_id" id="ft06_siswarutintempgrid$o<?php echo $t06_siswarutintemp_grid->RowIndex ?>_rutin_id" value="<?php echo ew_HtmlEncode($t06_siswarutintemp->rutin_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t06_siswarutintemp->Periode_Awal->Visible) { // Periode_Awal ?>
		<td data-name="Periode_Awal"<?php echo $t06_siswarutintemp->Periode_Awal->CellAttributes() ?>>
<?php if ($t06_siswarutintemp->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t06_siswarutintemp_grid->RowCnt ?>_t06_siswarutintemp_Periode_Awal" class="form-group t06_siswarutintemp_Periode_Awal">
<select data-table="t06_siswarutintemp" data-field="x_Periode_Awal" data-value-separator="<?php echo $t06_siswarutintemp->Periode_Awal->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Awal" name="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Awal"<?php echo $t06_siswarutintemp->Periode_Awal->EditAttributes() ?>>
<?php echo $t06_siswarutintemp->Periode_Awal->SelectOptionListHtml("x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Awal") ?>
</select>
<input type="hidden" name="s_x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Awal" id="s_x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Awal" value="<?php echo $t06_siswarutintemp->Periode_Awal->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="t06_siswarutintemp" data-field="x_Periode_Awal" name="o<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Awal" id="o<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Awal" value="<?php echo ew_HtmlEncode($t06_siswarutintemp->Periode_Awal->OldValue) ?>">
<?php } ?>
<?php if ($t06_siswarutintemp->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t06_siswarutintemp_grid->RowCnt ?>_t06_siswarutintemp_Periode_Awal" class="form-group t06_siswarutintemp_Periode_Awal">
<select data-table="t06_siswarutintemp" data-field="x_Periode_Awal" data-value-separator="<?php echo $t06_siswarutintemp->Periode_Awal->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Awal" name="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Awal"<?php echo $t06_siswarutintemp->Periode_Awal->EditAttributes() ?>>
<?php echo $t06_siswarutintemp->Periode_Awal->SelectOptionListHtml("x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Awal") ?>
</select>
<input type="hidden" name="s_x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Awal" id="s_x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Awal" value="<?php echo $t06_siswarutintemp->Periode_Awal->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($t06_siswarutintemp->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t06_siswarutintemp_grid->RowCnt ?>_t06_siswarutintemp_Periode_Awal" class="t06_siswarutintemp_Periode_Awal">
<span<?php echo $t06_siswarutintemp->Periode_Awal->ViewAttributes() ?>>
<?php echo $t06_siswarutintemp->Periode_Awal->ListViewValue() ?></span>
</span>
<?php if ($t06_siswarutintemp->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t06_siswarutintemp" data-field="x_Periode_Awal" name="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Awal" id="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Awal" value="<?php echo ew_HtmlEncode($t06_siswarutintemp->Periode_Awal->FormValue) ?>">
<input type="hidden" data-table="t06_siswarutintemp" data-field="x_Periode_Awal" name="o<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Awal" id="o<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Awal" value="<?php echo ew_HtmlEncode($t06_siswarutintemp->Periode_Awal->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t06_siswarutintemp" data-field="x_Periode_Awal" name="ft06_siswarutintempgrid$x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Awal" id="ft06_siswarutintempgrid$x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Awal" value="<?php echo ew_HtmlEncode($t06_siswarutintemp->Periode_Awal->FormValue) ?>">
<input type="hidden" data-table="t06_siswarutintemp" data-field="x_Periode_Awal" name="ft06_siswarutintempgrid$o<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Awal" id="ft06_siswarutintempgrid$o<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Awal" value="<?php echo ew_HtmlEncode($t06_siswarutintemp->Periode_Awal->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t06_siswarutintemp->Periode_Akhir->Visible) { // Periode_Akhir ?>
		<td data-name="Periode_Akhir"<?php echo $t06_siswarutintemp->Periode_Akhir->CellAttributes() ?>>
<?php if ($t06_siswarutintemp->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t06_siswarutintemp_grid->RowCnt ?>_t06_siswarutintemp_Periode_Akhir" class="form-group t06_siswarutintemp_Periode_Akhir">
<select data-table="t06_siswarutintemp" data-field="x_Periode_Akhir" data-value-separator="<?php echo $t06_siswarutintemp->Periode_Akhir->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Akhir" name="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Akhir"<?php echo $t06_siswarutintemp->Periode_Akhir->EditAttributes() ?>>
<?php echo $t06_siswarutintemp->Periode_Akhir->SelectOptionListHtml("x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Akhir") ?>
</select>
<input type="hidden" name="s_x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Akhir" id="s_x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Akhir" value="<?php echo $t06_siswarutintemp->Periode_Akhir->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="t06_siswarutintemp" data-field="x_Periode_Akhir" name="o<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Akhir" id="o<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Akhir" value="<?php echo ew_HtmlEncode($t06_siswarutintemp->Periode_Akhir->OldValue) ?>">
<?php } ?>
<?php if ($t06_siswarutintemp->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t06_siswarutintemp_grid->RowCnt ?>_t06_siswarutintemp_Periode_Akhir" class="form-group t06_siswarutintemp_Periode_Akhir">
<select data-table="t06_siswarutintemp" data-field="x_Periode_Akhir" data-value-separator="<?php echo $t06_siswarutintemp->Periode_Akhir->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Akhir" name="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Akhir"<?php echo $t06_siswarutintemp->Periode_Akhir->EditAttributes() ?>>
<?php echo $t06_siswarutintemp->Periode_Akhir->SelectOptionListHtml("x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Akhir") ?>
</select>
<input type="hidden" name="s_x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Akhir" id="s_x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Akhir" value="<?php echo $t06_siswarutintemp->Periode_Akhir->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($t06_siswarutintemp->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t06_siswarutintemp_grid->RowCnt ?>_t06_siswarutintemp_Periode_Akhir" class="t06_siswarutintemp_Periode_Akhir">
<span<?php echo $t06_siswarutintemp->Periode_Akhir->ViewAttributes() ?>>
<?php echo $t06_siswarutintemp->Periode_Akhir->ListViewValue() ?></span>
</span>
<?php if ($t06_siswarutintemp->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t06_siswarutintemp" data-field="x_Periode_Akhir" name="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Akhir" id="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Akhir" value="<?php echo ew_HtmlEncode($t06_siswarutintemp->Periode_Akhir->FormValue) ?>">
<input type="hidden" data-table="t06_siswarutintemp" data-field="x_Periode_Akhir" name="o<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Akhir" id="o<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Akhir" value="<?php echo ew_HtmlEncode($t06_siswarutintemp->Periode_Akhir->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t06_siswarutintemp" data-field="x_Periode_Akhir" name="ft06_siswarutintempgrid$x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Akhir" id="ft06_siswarutintempgrid$x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Akhir" value="<?php echo ew_HtmlEncode($t06_siswarutintemp->Periode_Akhir->FormValue) ?>">
<input type="hidden" data-table="t06_siswarutintemp" data-field="x_Periode_Akhir" name="ft06_siswarutintempgrid$o<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Akhir" id="ft06_siswarutintempgrid$o<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Akhir" value="<?php echo ew_HtmlEncode($t06_siswarutintemp->Periode_Akhir->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t06_siswarutintemp->Nilai->Visible) { // Nilai ?>
		<td data-name="Nilai"<?php echo $t06_siswarutintemp->Nilai->CellAttributes() ?>>
<?php if ($t06_siswarutintemp->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t06_siswarutintemp_grid->RowCnt ?>_t06_siswarutintemp_Nilai" class="form-group t06_siswarutintemp_Nilai">
<input type="text" data-table="t06_siswarutintemp" data-field="x_Nilai" name="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Nilai" id="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Nilai" size="30" placeholder="<?php echo ew_HtmlEncode($t06_siswarutintemp->Nilai->getPlaceHolder()) ?>" value="<?php echo $t06_siswarutintemp->Nilai->EditValue ?>"<?php echo $t06_siswarutintemp->Nilai->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t06_siswarutintemp" data-field="x_Nilai" name="o<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Nilai" id="o<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Nilai" value="<?php echo ew_HtmlEncode($t06_siswarutintemp->Nilai->OldValue) ?>">
<?php } ?>
<?php if ($t06_siswarutintemp->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t06_siswarutintemp_grid->RowCnt ?>_t06_siswarutintemp_Nilai" class="form-group t06_siswarutintemp_Nilai">
<input type="text" data-table="t06_siswarutintemp" data-field="x_Nilai" name="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Nilai" id="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Nilai" size="30" placeholder="<?php echo ew_HtmlEncode($t06_siswarutintemp->Nilai->getPlaceHolder()) ?>" value="<?php echo $t06_siswarutintemp->Nilai->EditValue ?>"<?php echo $t06_siswarutintemp->Nilai->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t06_siswarutintemp->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t06_siswarutintemp_grid->RowCnt ?>_t06_siswarutintemp_Nilai" class="t06_siswarutintemp_Nilai">
<span<?php echo $t06_siswarutintemp->Nilai->ViewAttributes() ?>>
<?php echo $t06_siswarutintemp->Nilai->ListViewValue() ?></span>
</span>
<?php if ($t06_siswarutintemp->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t06_siswarutintemp" data-field="x_Nilai" name="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Nilai" id="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Nilai" value="<?php echo ew_HtmlEncode($t06_siswarutintemp->Nilai->FormValue) ?>">
<input type="hidden" data-table="t06_siswarutintemp" data-field="x_Nilai" name="o<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Nilai" id="o<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Nilai" value="<?php echo ew_HtmlEncode($t06_siswarutintemp->Nilai->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t06_siswarutintemp" data-field="x_Nilai" name="ft06_siswarutintempgrid$x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Nilai" id="ft06_siswarutintempgrid$x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Nilai" value="<?php echo ew_HtmlEncode($t06_siswarutintemp->Nilai->FormValue) ?>">
<input type="hidden" data-table="t06_siswarutintemp" data-field="x_Nilai" name="ft06_siswarutintempgrid$o<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Nilai" id="ft06_siswarutintempgrid$o<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Nilai" value="<?php echo ew_HtmlEncode($t06_siswarutintemp->Nilai->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t06_siswarutintemp_grid->ListOptions->Render("body", "right", $t06_siswarutintemp_grid->RowCnt);
?>
	</tr>
<?php if ($t06_siswarutintemp->RowType == EW_ROWTYPE_ADD || $t06_siswarutintemp->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ft06_siswarutintempgrid.UpdateOpts(<?php echo $t06_siswarutintemp_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($t06_siswarutintemp->CurrentAction <> "gridadd" || $t06_siswarutintemp->CurrentMode == "copy")
		if (!$t06_siswarutintemp_grid->Recordset->EOF) $t06_siswarutintemp_grid->Recordset->MoveNext();
}
?>
<?php
	if ($t06_siswarutintemp->CurrentMode == "add" || $t06_siswarutintemp->CurrentMode == "copy" || $t06_siswarutintemp->CurrentMode == "edit") {
		$t06_siswarutintemp_grid->RowIndex = '$rowindex$';
		$t06_siswarutintemp_grid->LoadDefaultValues();

		// Set row properties
		$t06_siswarutintemp->ResetAttrs();
		$t06_siswarutintemp->RowAttrs = array_merge($t06_siswarutintemp->RowAttrs, array('data-rowindex'=>$t06_siswarutintemp_grid->RowIndex, 'id'=>'r0_t06_siswarutintemp', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($t06_siswarutintemp->RowAttrs["class"], "ewTemplate");
		$t06_siswarutintemp->RowType = EW_ROWTYPE_ADD;

		// Render row
		$t06_siswarutintemp_grid->RenderRow();

		// Render list options
		$t06_siswarutintemp_grid->RenderListOptions();
		$t06_siswarutintemp_grid->StartRowCnt = 0;
?>
	<tr<?php echo $t06_siswarutintemp->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t06_siswarutintemp_grid->ListOptions->Render("body", "left", $t06_siswarutintemp_grid->RowIndex);
?>
	<?php if ($t06_siswarutintemp->siswa_id->Visible) { // siswa_id ?>
		<td data-name="siswa_id">
<?php if ($t06_siswarutintemp->CurrentAction <> "F") { ?>
<?php if ($t06_siswarutintemp->siswa_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_t06_siswarutintemp_siswa_id" class="form-group t06_siswarutintemp_siswa_id">
<span<?php echo $t06_siswarutintemp->siswa_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t06_siswarutintemp->siswa_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_siswa_id" name="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_siswa_id" value="<?php echo ew_HtmlEncode($t06_siswarutintemp->siswa_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_t06_siswarutintemp_siswa_id" class="form-group t06_siswarutintemp_siswa_id">
<?php
$wrkonchange = trim(" " . @$t06_siswarutintemp->siswa_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t06_siswarutintemp->siswa_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_siswa_id" style="white-space: nowrap; z-index: <?php echo (9000 - $t06_siswarutintemp_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_siswa_id" id="sv_x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_siswa_id" value="<?php echo $t06_siswarutintemp->siswa_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($t06_siswarutintemp->siswa_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t06_siswarutintemp->siswa_id->getPlaceHolder()) ?>"<?php echo $t06_siswarutintemp->siswa_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t06_siswarutintemp" data-field="x_siswa_id" data-value-separator="<?php echo $t06_siswarutintemp->siswa_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_siswa_id" id="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_siswa_id" value="<?php echo ew_HtmlEncode($t06_siswarutintemp->siswa_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_siswa_id" id="q_x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_siswa_id" value="<?php echo $t06_siswarutintemp->siswa_id->LookupFilterQuery(true) ?>">
<script type="text/javascript">
ft06_siswarutintempgrid.CreateAutoSuggest({"id":"x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_siswa_id","forceSelect":false});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_t06_siswarutintemp_siswa_id" class="form-group t06_siswarutintemp_siswa_id">
<span<?php echo $t06_siswarutintemp->siswa_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t06_siswarutintemp->siswa_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t06_siswarutintemp" data-field="x_siswa_id" name="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_siswa_id" id="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_siswa_id" value="<?php echo ew_HtmlEncode($t06_siswarutintemp->siswa_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t06_siswarutintemp" data-field="x_siswa_id" name="o<?php echo $t06_siswarutintemp_grid->RowIndex ?>_siswa_id" id="o<?php echo $t06_siswarutintemp_grid->RowIndex ?>_siswa_id" value="<?php echo ew_HtmlEncode($t06_siswarutintemp->siswa_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t06_siswarutintemp->rutin_id->Visible) { // rutin_id ?>
		<td data-name="rutin_id">
<?php if ($t06_siswarutintemp->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t06_siswarutintemp_rutin_id" class="form-group t06_siswarutintemp_rutin_id">
<?php
$wrkonchange = trim(" " . @$t06_siswarutintemp->rutin_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t06_siswarutintemp->rutin_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_rutin_id" style="white-space: nowrap; z-index: <?php echo (9000 - $t06_siswarutintemp_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_rutin_id" id="sv_x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_rutin_id" value="<?php echo $t06_siswarutintemp->rutin_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($t06_siswarutintemp->rutin_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t06_siswarutintemp->rutin_id->getPlaceHolder()) ?>"<?php echo $t06_siswarutintemp->rutin_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t06_siswarutintemp" data-field="x_rutin_id" data-value-separator="<?php echo $t06_siswarutintemp->rutin_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_rutin_id" id="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_rutin_id" value="<?php echo ew_HtmlEncode($t06_siswarutintemp->rutin_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_rutin_id" id="q_x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_rutin_id" value="<?php echo $t06_siswarutintemp->rutin_id->LookupFilterQuery(true) ?>">
<script type="text/javascript">
ft06_siswarutintempgrid.CreateAutoSuggest({"id":"x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_rutin_id","forceSelect":false});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_t06_siswarutintemp_rutin_id" class="form-group t06_siswarutintemp_rutin_id">
<span<?php echo $t06_siswarutintemp->rutin_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t06_siswarutintemp->rutin_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t06_siswarutintemp" data-field="x_rutin_id" name="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_rutin_id" id="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_rutin_id" value="<?php echo ew_HtmlEncode($t06_siswarutintemp->rutin_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t06_siswarutintemp" data-field="x_rutin_id" name="o<?php echo $t06_siswarutintemp_grid->RowIndex ?>_rutin_id" id="o<?php echo $t06_siswarutintemp_grid->RowIndex ?>_rutin_id" value="<?php echo ew_HtmlEncode($t06_siswarutintemp->rutin_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t06_siswarutintemp->Periode_Awal->Visible) { // Periode_Awal ?>
		<td data-name="Periode_Awal">
<?php if ($t06_siswarutintemp->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t06_siswarutintemp_Periode_Awal" class="form-group t06_siswarutintemp_Periode_Awal">
<select data-table="t06_siswarutintemp" data-field="x_Periode_Awal" data-value-separator="<?php echo $t06_siswarutintemp->Periode_Awal->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Awal" name="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Awal"<?php echo $t06_siswarutintemp->Periode_Awal->EditAttributes() ?>>
<?php echo $t06_siswarutintemp->Periode_Awal->SelectOptionListHtml("x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Awal") ?>
</select>
<input type="hidden" name="s_x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Awal" id="s_x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Awal" value="<?php echo $t06_siswarutintemp->Periode_Awal->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_t06_siswarutintemp_Periode_Awal" class="form-group t06_siswarutintemp_Periode_Awal">
<span<?php echo $t06_siswarutintemp->Periode_Awal->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t06_siswarutintemp->Periode_Awal->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t06_siswarutintemp" data-field="x_Periode_Awal" name="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Awal" id="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Awal" value="<?php echo ew_HtmlEncode($t06_siswarutintemp->Periode_Awal->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t06_siswarutintemp" data-field="x_Periode_Awal" name="o<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Awal" id="o<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Awal" value="<?php echo ew_HtmlEncode($t06_siswarutintemp->Periode_Awal->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t06_siswarutintemp->Periode_Akhir->Visible) { // Periode_Akhir ?>
		<td data-name="Periode_Akhir">
<?php if ($t06_siswarutintemp->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t06_siswarutintemp_Periode_Akhir" class="form-group t06_siswarutintemp_Periode_Akhir">
<select data-table="t06_siswarutintemp" data-field="x_Periode_Akhir" data-value-separator="<?php echo $t06_siswarutintemp->Periode_Akhir->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Akhir" name="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Akhir"<?php echo $t06_siswarutintemp->Periode_Akhir->EditAttributes() ?>>
<?php echo $t06_siswarutintemp->Periode_Akhir->SelectOptionListHtml("x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Akhir") ?>
</select>
<input type="hidden" name="s_x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Akhir" id="s_x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Akhir" value="<?php echo $t06_siswarutintemp->Periode_Akhir->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_t06_siswarutintemp_Periode_Akhir" class="form-group t06_siswarutintemp_Periode_Akhir">
<span<?php echo $t06_siswarutintemp->Periode_Akhir->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t06_siswarutintemp->Periode_Akhir->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t06_siswarutintemp" data-field="x_Periode_Akhir" name="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Akhir" id="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Akhir" value="<?php echo ew_HtmlEncode($t06_siswarutintemp->Periode_Akhir->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t06_siswarutintemp" data-field="x_Periode_Akhir" name="o<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Akhir" id="o<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Periode_Akhir" value="<?php echo ew_HtmlEncode($t06_siswarutintemp->Periode_Akhir->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t06_siswarutintemp->Nilai->Visible) { // Nilai ?>
		<td data-name="Nilai">
<?php if ($t06_siswarutintemp->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t06_siswarutintemp_Nilai" class="form-group t06_siswarutintemp_Nilai">
<input type="text" data-table="t06_siswarutintemp" data-field="x_Nilai" name="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Nilai" id="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Nilai" size="30" placeholder="<?php echo ew_HtmlEncode($t06_siswarutintemp->Nilai->getPlaceHolder()) ?>" value="<?php echo $t06_siswarutintemp->Nilai->EditValue ?>"<?php echo $t06_siswarutintemp->Nilai->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t06_siswarutintemp_Nilai" class="form-group t06_siswarutintemp_Nilai">
<span<?php echo $t06_siswarutintemp->Nilai->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t06_siswarutintemp->Nilai->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t06_siswarutintemp" data-field="x_Nilai" name="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Nilai" id="x<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Nilai" value="<?php echo ew_HtmlEncode($t06_siswarutintemp->Nilai->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t06_siswarutintemp" data-field="x_Nilai" name="o<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Nilai" id="o<?php echo $t06_siswarutintemp_grid->RowIndex ?>_Nilai" value="<?php echo ew_HtmlEncode($t06_siswarutintemp->Nilai->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t06_siswarutintemp_grid->ListOptions->Render("body", "right", $t06_siswarutintemp_grid->RowCnt);
?>
<script type="text/javascript">
ft06_siswarutintempgrid.UpdateOpts(<?php echo $t06_siswarutintemp_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($t06_siswarutintemp->CurrentMode == "add" || $t06_siswarutintemp->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $t06_siswarutintemp_grid->FormKeyCountName ?>" id="<?php echo $t06_siswarutintemp_grid->FormKeyCountName ?>" value="<?php echo $t06_siswarutintemp_grid->KeyCount ?>">
<?php echo $t06_siswarutintemp_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t06_siswarutintemp->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $t06_siswarutintemp_grid->FormKeyCountName ?>" id="<?php echo $t06_siswarutintemp_grid->FormKeyCountName ?>" value="<?php echo $t06_siswarutintemp_grid->KeyCount ?>">
<?php echo $t06_siswarutintemp_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t06_siswarutintemp->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="ft06_siswarutintempgrid">
</div>
<?php

// Close recordset
if ($t06_siswarutintemp_grid->Recordset)
	$t06_siswarutintemp_grid->Recordset->Close();
?>
<?php if ($t06_siswarutintemp_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($t06_siswarutintemp_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($t06_siswarutintemp_grid->TotalRecs == 0 && $t06_siswarutintemp->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t06_siswarutintemp_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($t06_siswarutintemp->Export == "") { ?>
<script type="text/javascript">
ft06_siswarutintempgrid.Init();
</script>
<?php } ?>
<?php
$t06_siswarutintemp_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$t06_siswarutintemp_grid->Page_Terminate();
?>
