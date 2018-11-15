<?php

// Create page object
if (!isset($t09_siswanonrutintemp_grid)) $t09_siswanonrutintemp_grid = new ct09_siswanonrutintemp_grid();

// Page init
$t09_siswanonrutintemp_grid->Page_Init();

// Page main
$t09_siswanonrutintemp_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t09_siswanonrutintemp_grid->Page_Render();
?>
<?php if ($t09_siswanonrutintemp->Export == "") { ?>
<script type="text/javascript">

// Form object
var ft09_siswanonrutintempgrid = new ew_Form("ft09_siswanonrutintempgrid", "grid");
ft09_siswanonrutintempgrid.FormKeyCountName = '<?php echo $t09_siswanonrutintemp_grid->FormKeyCountName ?>';

// Validate form
ft09_siswanonrutintempgrid.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t09_siswanonrutintemp->siswa_id->FldCaption(), $t09_siswanonrutintemp->siswa_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nonrutin_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t09_siswanonrutintemp->nonrutin_id->FldCaption(), $t09_siswanonrutintemp->nonrutin_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_siswanonrutin_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t09_siswanonrutintemp->siswanonrutin_id->FldCaption(), $t09_siswanonrutintemp->siswanonrutin_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_siswanonrutin_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t09_siswanonrutintemp->siswanonrutin_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Nilai");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t09_siswanonrutintemp->Nilai->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
ft09_siswanonrutintempgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "siswa_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "nonrutin_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "siswanonrutin_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Periode_Awal", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Periode_Akhir", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Nilai", false)) return false;
	return true;
}

// Form_CustomValidate event
ft09_siswanonrutintempgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft09_siswanonrutintempgrid.ValidateRequired = true;
<?php } else { ?>
ft09_siswanonrutintempgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft09_siswanonrutintempgrid.Lists["x_nonrutin_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_Jenis","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t08_nonrutin"};
ft09_siswanonrutintempgrid.Lists["x_Periode_Awal"] = {"LinkField":"x_Periode_Tahun_Bulan","Ajax":true,"AutoFill":false,"DisplayFields":["x_Periode_Text","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t10_siswanonrutinbayar"};
ft09_siswanonrutintempgrid.Lists["x_Periode_Akhir"] = {"LinkField":"x_Periode_Tahun_Bulan","Ajax":true,"AutoFill":false,"DisplayFields":["x_Periode_Text","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t10_siswanonrutinbayar"};

// Form object for search
</script>
<?php } ?>
<?php
if ($t09_siswanonrutintemp->CurrentAction == "gridadd") {
	if ($t09_siswanonrutintemp->CurrentMode == "copy") {
		$bSelectLimit = $t09_siswanonrutintemp_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$t09_siswanonrutintemp_grid->TotalRecs = $t09_siswanonrutintemp->SelectRecordCount();
			$t09_siswanonrutintemp_grid->Recordset = $t09_siswanonrutintemp_grid->LoadRecordset($t09_siswanonrutintemp_grid->StartRec-1, $t09_siswanonrutintemp_grid->DisplayRecs);
		} else {
			if ($t09_siswanonrutintemp_grid->Recordset = $t09_siswanonrutintemp_grid->LoadRecordset())
				$t09_siswanonrutintemp_grid->TotalRecs = $t09_siswanonrutintemp_grid->Recordset->RecordCount();
		}
		$t09_siswanonrutintemp_grid->StartRec = 1;
		$t09_siswanonrutintemp_grid->DisplayRecs = $t09_siswanonrutintemp_grid->TotalRecs;
	} else {
		$t09_siswanonrutintemp->CurrentFilter = "0=1";
		$t09_siswanonrutintemp_grid->StartRec = 1;
		$t09_siswanonrutintemp_grid->DisplayRecs = $t09_siswanonrutintemp->GridAddRowCount;
	}
	$t09_siswanonrutintemp_grid->TotalRecs = $t09_siswanonrutintemp_grid->DisplayRecs;
	$t09_siswanonrutintemp_grid->StopRec = $t09_siswanonrutintemp_grid->DisplayRecs;
} else {
	$bSelectLimit = $t09_siswanonrutintemp_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($t09_siswanonrutintemp_grid->TotalRecs <= 0)
			$t09_siswanonrutintemp_grid->TotalRecs = $t09_siswanonrutintemp->SelectRecordCount();
	} else {
		if (!$t09_siswanonrutintemp_grid->Recordset && ($t09_siswanonrutintemp_grid->Recordset = $t09_siswanonrutintemp_grid->LoadRecordset()))
			$t09_siswanonrutintemp_grid->TotalRecs = $t09_siswanonrutintemp_grid->Recordset->RecordCount();
	}
	$t09_siswanonrutintemp_grid->StartRec = 1;
	$t09_siswanonrutintemp_grid->DisplayRecs = $t09_siswanonrutintemp_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$t09_siswanonrutintemp_grid->Recordset = $t09_siswanonrutintemp_grid->LoadRecordset($t09_siswanonrutintemp_grid->StartRec-1, $t09_siswanonrutintemp_grid->DisplayRecs);

	// Set no record found message
	if ($t09_siswanonrutintemp->CurrentAction == "" && $t09_siswanonrutintemp_grid->TotalRecs == 0) {
		if ($t09_siswanonrutintemp_grid->SearchWhere == "0=101")
			$t09_siswanonrutintemp_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$t09_siswanonrutintemp_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$t09_siswanonrutintemp_grid->RenderOtherOptions();
?>
<?php $t09_siswanonrutintemp_grid->ShowPageHeader(); ?>
<?php
$t09_siswanonrutintemp_grid->ShowMessage();
?>
<?php if ($t09_siswanonrutintemp_grid->TotalRecs > 0 || $t09_siswanonrutintemp->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid t09_siswanonrutintemp">
<div id="ft09_siswanonrutintempgrid" class="ewForm form-inline">
<div id="gmp_t09_siswanonrutintemp" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_t09_siswanonrutintempgrid" class="table ewTable">
<?php echo $t09_siswanonrutintemp->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$t09_siswanonrutintemp_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$t09_siswanonrutintemp_grid->RenderListOptions();

// Render list options (header, left)
$t09_siswanonrutintemp_grid->ListOptions->Render("header", "left");
?>
<?php if ($t09_siswanonrutintemp->siswa_id->Visible) { // siswa_id ?>
	<?php if ($t09_siswanonrutintemp->SortUrl($t09_siswanonrutintemp->siswa_id) == "") { ?>
		<th data-name="siswa_id"><div id="elh_t09_siswanonrutintemp_siswa_id" class="t09_siswanonrutintemp_siswa_id"><div class="ewTableHeaderCaption"><?php echo $t09_siswanonrutintemp->siswa_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="siswa_id"><div><div id="elh_t09_siswanonrutintemp_siswa_id" class="t09_siswanonrutintemp_siswa_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t09_siswanonrutintemp->siswa_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t09_siswanonrutintemp->siswa_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t09_siswanonrutintemp->siswa_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t09_siswanonrutintemp->nonrutin_id->Visible) { // nonrutin_id ?>
	<?php if ($t09_siswanonrutintemp->SortUrl($t09_siswanonrutintemp->nonrutin_id) == "") { ?>
		<th data-name="nonrutin_id"><div id="elh_t09_siswanonrutintemp_nonrutin_id" class="t09_siswanonrutintemp_nonrutin_id"><div class="ewTableHeaderCaption"><?php echo $t09_siswanonrutintemp->nonrutin_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nonrutin_id"><div><div id="elh_t09_siswanonrutintemp_nonrutin_id" class="t09_siswanonrutintemp_nonrutin_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t09_siswanonrutintemp->nonrutin_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t09_siswanonrutintemp->nonrutin_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t09_siswanonrutintemp->nonrutin_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t09_siswanonrutintemp->siswanonrutin_id->Visible) { // siswanonrutin_id ?>
	<?php if ($t09_siswanonrutintemp->SortUrl($t09_siswanonrutintemp->siswanonrutin_id) == "") { ?>
		<th data-name="siswanonrutin_id"><div id="elh_t09_siswanonrutintemp_siswanonrutin_id" class="t09_siswanonrutintemp_siswanonrutin_id"><div class="ewTableHeaderCaption"><?php echo $t09_siswanonrutintemp->siswanonrutin_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="siswanonrutin_id"><div><div id="elh_t09_siswanonrutintemp_siswanonrutin_id" class="t09_siswanonrutintemp_siswanonrutin_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t09_siswanonrutintemp->siswanonrutin_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t09_siswanonrutintemp->siswanonrutin_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t09_siswanonrutintemp->siswanonrutin_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t09_siswanonrutintemp->Periode_Awal->Visible) { // Periode_Awal ?>
	<?php if ($t09_siswanonrutintemp->SortUrl($t09_siswanonrutintemp->Periode_Awal) == "") { ?>
		<th data-name="Periode_Awal"><div id="elh_t09_siswanonrutintemp_Periode_Awal" class="t09_siswanonrutintemp_Periode_Awal"><div class="ewTableHeaderCaption"><?php echo $t09_siswanonrutintemp->Periode_Awal->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Periode_Awal"><div><div id="elh_t09_siswanonrutintemp_Periode_Awal" class="t09_siswanonrutintemp_Periode_Awal">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t09_siswanonrutintemp->Periode_Awal->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t09_siswanonrutintemp->Periode_Awal->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t09_siswanonrutintemp->Periode_Awal->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t09_siswanonrutintemp->Periode_Akhir->Visible) { // Periode_Akhir ?>
	<?php if ($t09_siswanonrutintemp->SortUrl($t09_siswanonrutintemp->Periode_Akhir) == "") { ?>
		<th data-name="Periode_Akhir"><div id="elh_t09_siswanonrutintemp_Periode_Akhir" class="t09_siswanonrutintemp_Periode_Akhir"><div class="ewTableHeaderCaption"><?php echo $t09_siswanonrutintemp->Periode_Akhir->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Periode_Akhir"><div><div id="elh_t09_siswanonrutintemp_Periode_Akhir" class="t09_siswanonrutintemp_Periode_Akhir">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t09_siswanonrutintemp->Periode_Akhir->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t09_siswanonrutintemp->Periode_Akhir->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t09_siswanonrutintemp->Periode_Akhir->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t09_siswanonrutintemp->Nilai->Visible) { // Nilai ?>
	<?php if ($t09_siswanonrutintemp->SortUrl($t09_siswanonrutintemp->Nilai) == "") { ?>
		<th data-name="Nilai"><div id="elh_t09_siswanonrutintemp_Nilai" class="t09_siswanonrutintemp_Nilai"><div class="ewTableHeaderCaption"><?php echo $t09_siswanonrutintemp->Nilai->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nilai"><div><div id="elh_t09_siswanonrutintemp_Nilai" class="t09_siswanonrutintemp_Nilai">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t09_siswanonrutintemp->Nilai->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t09_siswanonrutintemp->Nilai->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t09_siswanonrutintemp->Nilai->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$t09_siswanonrutintemp_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$t09_siswanonrutintemp_grid->StartRec = 1;
$t09_siswanonrutintemp_grid->StopRec = $t09_siswanonrutintemp_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($t09_siswanonrutintemp_grid->FormKeyCountName) && ($t09_siswanonrutintemp->CurrentAction == "gridadd" || $t09_siswanonrutintemp->CurrentAction == "gridedit" || $t09_siswanonrutintemp->CurrentAction == "F")) {
		$t09_siswanonrutintemp_grid->KeyCount = $objForm->GetValue($t09_siswanonrutintemp_grid->FormKeyCountName);
		$t09_siswanonrutintemp_grid->StopRec = $t09_siswanonrutintemp_grid->StartRec + $t09_siswanonrutintemp_grid->KeyCount - 1;
	}
}
$t09_siswanonrutintemp_grid->RecCnt = $t09_siswanonrutintemp_grid->StartRec - 1;
if ($t09_siswanonrutintemp_grid->Recordset && !$t09_siswanonrutintemp_grid->Recordset->EOF) {
	$t09_siswanonrutintemp_grid->Recordset->MoveFirst();
	$bSelectLimit = $t09_siswanonrutintemp_grid->UseSelectLimit;
	if (!$bSelectLimit && $t09_siswanonrutintemp_grid->StartRec > 1)
		$t09_siswanonrutintemp_grid->Recordset->Move($t09_siswanonrutintemp_grid->StartRec - 1);
} elseif (!$t09_siswanonrutintemp->AllowAddDeleteRow && $t09_siswanonrutintemp_grid->StopRec == 0) {
	$t09_siswanonrutintemp_grid->StopRec = $t09_siswanonrutintemp->GridAddRowCount;
}

// Initialize aggregate
$t09_siswanonrutintemp->RowType = EW_ROWTYPE_AGGREGATEINIT;
$t09_siswanonrutintemp->ResetAttrs();
$t09_siswanonrutintemp_grid->RenderRow();
if ($t09_siswanonrutintemp->CurrentAction == "gridadd")
	$t09_siswanonrutintemp_grid->RowIndex = 0;
if ($t09_siswanonrutintemp->CurrentAction == "gridedit")
	$t09_siswanonrutintemp_grid->RowIndex = 0;
while ($t09_siswanonrutintemp_grid->RecCnt < $t09_siswanonrutintemp_grid->StopRec) {
	$t09_siswanonrutintemp_grid->RecCnt++;
	if (intval($t09_siswanonrutintemp_grid->RecCnt) >= intval($t09_siswanonrutintemp_grid->StartRec)) {
		$t09_siswanonrutintemp_grid->RowCnt++;
		if ($t09_siswanonrutintemp->CurrentAction == "gridadd" || $t09_siswanonrutintemp->CurrentAction == "gridedit" || $t09_siswanonrutintemp->CurrentAction == "F") {
			$t09_siswanonrutintemp_grid->RowIndex++;
			$objForm->Index = $t09_siswanonrutintemp_grid->RowIndex;
			if ($objForm->HasValue($t09_siswanonrutintemp_grid->FormActionName))
				$t09_siswanonrutintemp_grid->RowAction = strval($objForm->GetValue($t09_siswanonrutintemp_grid->FormActionName));
			elseif ($t09_siswanonrutintemp->CurrentAction == "gridadd")
				$t09_siswanonrutintemp_grid->RowAction = "insert";
			else
				$t09_siswanonrutintemp_grid->RowAction = "";
		}

		// Set up key count
		$t09_siswanonrutintemp_grid->KeyCount = $t09_siswanonrutintemp_grid->RowIndex;

		// Init row class and style
		$t09_siswanonrutintemp->ResetAttrs();
		$t09_siswanonrutintemp->CssClass = "";
		if ($t09_siswanonrutintemp->CurrentAction == "gridadd") {
			if ($t09_siswanonrutintemp->CurrentMode == "copy") {
				$t09_siswanonrutintemp_grid->LoadRowValues($t09_siswanonrutintemp_grid->Recordset); // Load row values
				$t09_siswanonrutintemp_grid->SetRecordKey($t09_siswanonrutintemp_grid->RowOldKey, $t09_siswanonrutintemp_grid->Recordset); // Set old record key
			} else {
				$t09_siswanonrutintemp_grid->LoadDefaultValues(); // Load default values
				$t09_siswanonrutintemp_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$t09_siswanonrutintemp_grid->LoadRowValues($t09_siswanonrutintemp_grid->Recordset); // Load row values
		}
		$t09_siswanonrutintemp->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($t09_siswanonrutintemp->CurrentAction == "gridadd") // Grid add
			$t09_siswanonrutintemp->RowType = EW_ROWTYPE_ADD; // Render add
		if ($t09_siswanonrutintemp->CurrentAction == "gridadd" && $t09_siswanonrutintemp->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$t09_siswanonrutintemp_grid->RestoreCurrentRowFormValues($t09_siswanonrutintemp_grid->RowIndex); // Restore form values
		if ($t09_siswanonrutintemp->CurrentAction == "gridedit") { // Grid edit
			if ($t09_siswanonrutintemp->EventCancelled) {
				$t09_siswanonrutintemp_grid->RestoreCurrentRowFormValues($t09_siswanonrutintemp_grid->RowIndex); // Restore form values
			}
			if ($t09_siswanonrutintemp_grid->RowAction == "insert")
				$t09_siswanonrutintemp->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$t09_siswanonrutintemp->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($t09_siswanonrutintemp->CurrentAction == "gridedit" && ($t09_siswanonrutintemp->RowType == EW_ROWTYPE_EDIT || $t09_siswanonrutintemp->RowType == EW_ROWTYPE_ADD) && $t09_siswanonrutintemp->EventCancelled) // Update failed
			$t09_siswanonrutintemp_grid->RestoreCurrentRowFormValues($t09_siswanonrutintemp_grid->RowIndex); // Restore form values
		if ($t09_siswanonrutintemp->RowType == EW_ROWTYPE_EDIT) // Edit row
			$t09_siswanonrutintemp_grid->EditRowCnt++;
		if ($t09_siswanonrutintemp->CurrentAction == "F") // Confirm row
			$t09_siswanonrutintemp_grid->RestoreCurrentRowFormValues($t09_siswanonrutintemp_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$t09_siswanonrutintemp->RowAttrs = array_merge($t09_siswanonrutintemp->RowAttrs, array('data-rowindex'=>$t09_siswanonrutintemp_grid->RowCnt, 'id'=>'r' . $t09_siswanonrutintemp_grid->RowCnt . '_t09_siswanonrutintemp', 'data-rowtype'=>$t09_siswanonrutintemp->RowType));

		// Render row
		$t09_siswanonrutintemp_grid->RenderRow();

		// Render list options
		$t09_siswanonrutintemp_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($t09_siswanonrutintemp_grid->RowAction <> "delete" && $t09_siswanonrutintemp_grid->RowAction <> "insertdelete" && !($t09_siswanonrutintemp_grid->RowAction == "insert" && $t09_siswanonrutintemp->CurrentAction == "F" && $t09_siswanonrutintemp_grid->EmptyRow())) {
?>
	<tr<?php echo $t09_siswanonrutintemp->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t09_siswanonrutintemp_grid->ListOptions->Render("body", "left", $t09_siswanonrutintemp_grid->RowCnt);
?>
	<?php if ($t09_siswanonrutintemp->siswa_id->Visible) { // siswa_id ?>
		<td data-name="siswa_id"<?php echo $t09_siswanonrutintemp->siswa_id->CellAttributes() ?>>
<?php if ($t09_siswanonrutintemp->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($t09_siswanonrutintemp->siswa_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $t09_siswanonrutintemp_grid->RowCnt ?>_t09_siswanonrutintemp_siswa_id" class="form-group t09_siswanonrutintemp_siswa_id">
<span<?php echo $t09_siswanonrutintemp->siswa_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t09_siswanonrutintemp->siswa_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_siswa_id" name="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_siswa_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->siswa_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $t09_siswanonrutintemp_grid->RowCnt ?>_t09_siswanonrutintemp_siswa_id" class="form-group t09_siswanonrutintemp_siswa_id">
<input type="text" data-table="t09_siswanonrutintemp" data-field="x_siswa_id" name="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_siswa_id" id="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_siswa_id" size="30" placeholder="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->siswa_id->getPlaceHolder()) ?>" value="<?php echo $t09_siswanonrutintemp->siswa_id->EditValue ?>"<?php echo $t09_siswanonrutintemp->siswa_id->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_siswa_id" name="o<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_siswa_id" id="o<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_siswa_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->siswa_id->OldValue) ?>">
<?php } ?>
<?php if ($t09_siswanonrutintemp->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t09_siswanonrutintemp_grid->RowCnt ?>_t09_siswanonrutintemp_siswa_id" class="form-group t09_siswanonrutintemp_siswa_id">
<span<?php echo $t09_siswanonrutintemp->siswa_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t09_siswanonrutintemp->siswa_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_siswa_id" name="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_siswa_id" id="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_siswa_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->siswa_id->CurrentValue) ?>">
<?php } ?>
<?php if ($t09_siswanonrutintemp->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t09_siswanonrutintemp_grid->RowCnt ?>_t09_siswanonrutintemp_siswa_id" class="t09_siswanonrutintemp_siswa_id">
<span<?php echo $t09_siswanonrutintemp->siswa_id->ViewAttributes() ?>>
<?php echo $t09_siswanonrutintemp->siswa_id->ListViewValue() ?></span>
</span>
<?php if ($t09_siswanonrutintemp->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_siswa_id" name="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_siswa_id" id="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_siswa_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->siswa_id->FormValue) ?>">
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_siswa_id" name="o<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_siswa_id" id="o<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_siswa_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->siswa_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_siswa_id" name="ft09_siswanonrutintempgrid$x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_siswa_id" id="ft09_siswanonrutintempgrid$x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_siswa_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->siswa_id->FormValue) ?>">
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_siswa_id" name="ft09_siswanonrutintempgrid$o<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_siswa_id" id="ft09_siswanonrutintempgrid$o<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_siswa_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->siswa_id->OldValue) ?>">
<?php } ?>
<?php } ?>
<a id="<?php echo $t09_siswanonrutintemp_grid->PageObjName . "_row_" . $t09_siswanonrutintemp_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($t09_siswanonrutintemp->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_id" name="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_id" id="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->id->CurrentValue) ?>">
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_id" name="o<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_id" id="o<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->id->OldValue) ?>">
<?php } ?>
<?php if ($t09_siswanonrutintemp->RowType == EW_ROWTYPE_EDIT || $t09_siswanonrutintemp->CurrentMode == "edit") { ?>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_id" name="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_id" id="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->id->CurrentValue) ?>">
<?php } ?>
	<?php if ($t09_siswanonrutintemp->nonrutin_id->Visible) { // nonrutin_id ?>
		<td data-name="nonrutin_id"<?php echo $t09_siswanonrutintemp->nonrutin_id->CellAttributes() ?>>
<?php if ($t09_siswanonrutintemp->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t09_siswanonrutintemp_grid->RowCnt ?>_t09_siswanonrutintemp_nonrutin_id" class="form-group t09_siswanonrutintemp_nonrutin_id">
<?php
$wrkonchange = trim(" " . @$t09_siswanonrutintemp->nonrutin_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t09_siswanonrutintemp->nonrutin_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_nonrutin_id" style="white-space: nowrap; z-index: <?php echo (9000 - $t09_siswanonrutintemp_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_nonrutin_id" id="sv_x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_nonrutin_id" value="<?php echo $t09_siswanonrutintemp->nonrutin_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->nonrutin_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->nonrutin_id->getPlaceHolder()) ?>"<?php echo $t09_siswanonrutintemp->nonrutin_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_nonrutin_id" data-value-separator="<?php echo $t09_siswanonrutintemp->nonrutin_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_nonrutin_id" id="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_nonrutin_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->nonrutin_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_nonrutin_id" id="q_x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_nonrutin_id" value="<?php echo $t09_siswanonrutintemp->nonrutin_id->LookupFilterQuery(true) ?>">
<script type="text/javascript">
ft09_siswanonrutintempgrid.CreateAutoSuggest({"id":"x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_nonrutin_id","forceSelect":false});
</script>
</span>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_nonrutin_id" name="o<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_nonrutin_id" id="o<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_nonrutin_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->nonrutin_id->OldValue) ?>">
<?php } ?>
<?php if ($t09_siswanonrutintemp->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t09_siswanonrutintemp_grid->RowCnt ?>_t09_siswanonrutintemp_nonrutin_id" class="form-group t09_siswanonrutintemp_nonrutin_id">
<span<?php echo $t09_siswanonrutintemp->nonrutin_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t09_siswanonrutintemp->nonrutin_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_nonrutin_id" name="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_nonrutin_id" id="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_nonrutin_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->nonrutin_id->CurrentValue) ?>">
<?php } ?>
<?php if ($t09_siswanonrutintemp->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t09_siswanonrutintemp_grid->RowCnt ?>_t09_siswanonrutintemp_nonrutin_id" class="t09_siswanonrutintemp_nonrutin_id">
<span<?php echo $t09_siswanonrutintemp->nonrutin_id->ViewAttributes() ?>>
<?php echo $t09_siswanonrutintemp->nonrutin_id->ListViewValue() ?></span>
</span>
<?php if ($t09_siswanonrutintemp->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_nonrutin_id" name="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_nonrutin_id" id="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_nonrutin_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->nonrutin_id->FormValue) ?>">
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_nonrutin_id" name="o<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_nonrutin_id" id="o<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_nonrutin_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->nonrutin_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_nonrutin_id" name="ft09_siswanonrutintempgrid$x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_nonrutin_id" id="ft09_siswanonrutintempgrid$x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_nonrutin_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->nonrutin_id->FormValue) ?>">
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_nonrutin_id" name="ft09_siswanonrutintempgrid$o<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_nonrutin_id" id="ft09_siswanonrutintempgrid$o<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_nonrutin_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->nonrutin_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t09_siswanonrutintemp->siswanonrutin_id->Visible) { // siswanonrutin_id ?>
		<td data-name="siswanonrutin_id"<?php echo $t09_siswanonrutintemp->siswanonrutin_id->CellAttributes() ?>>
<?php if ($t09_siswanonrutintemp->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t09_siswanonrutintemp_grid->RowCnt ?>_t09_siswanonrutintemp_siswanonrutin_id" class="form-group t09_siswanonrutintemp_siswanonrutin_id">
<input type="text" data-table="t09_siswanonrutintemp" data-field="x_siswanonrutin_id" name="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_siswanonrutin_id" id="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_siswanonrutin_id" size="30" placeholder="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->siswanonrutin_id->getPlaceHolder()) ?>" value="<?php echo $t09_siswanonrutintemp->siswanonrutin_id->EditValue ?>"<?php echo $t09_siswanonrutintemp->siswanonrutin_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_siswanonrutin_id" name="o<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_siswanonrutin_id" id="o<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_siswanonrutin_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->siswanonrutin_id->OldValue) ?>">
<?php } ?>
<?php if ($t09_siswanonrutintemp->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t09_siswanonrutintemp_grid->RowCnt ?>_t09_siswanonrutintemp_siswanonrutin_id" class="form-group t09_siswanonrutintemp_siswanonrutin_id">
<input type="text" data-table="t09_siswanonrutintemp" data-field="x_siswanonrutin_id" name="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_siswanonrutin_id" id="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_siswanonrutin_id" size="30" placeholder="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->siswanonrutin_id->getPlaceHolder()) ?>" value="<?php echo $t09_siswanonrutintemp->siswanonrutin_id->EditValue ?>"<?php echo $t09_siswanonrutintemp->siswanonrutin_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t09_siswanonrutintemp->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t09_siswanonrutintemp_grid->RowCnt ?>_t09_siswanonrutintemp_siswanonrutin_id" class="t09_siswanonrutintemp_siswanonrutin_id">
<span<?php echo $t09_siswanonrutintemp->siswanonrutin_id->ViewAttributes() ?>>
<?php echo $t09_siswanonrutintemp->siswanonrutin_id->ListViewValue() ?></span>
</span>
<?php if ($t09_siswanonrutintemp->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_siswanonrutin_id" name="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_siswanonrutin_id" id="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_siswanonrutin_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->siswanonrutin_id->FormValue) ?>">
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_siswanonrutin_id" name="o<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_siswanonrutin_id" id="o<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_siswanonrutin_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->siswanonrutin_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_siswanonrutin_id" name="ft09_siswanonrutintempgrid$x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_siswanonrutin_id" id="ft09_siswanonrutintempgrid$x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_siswanonrutin_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->siswanonrutin_id->FormValue) ?>">
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_siswanonrutin_id" name="ft09_siswanonrutintempgrid$o<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_siswanonrutin_id" id="ft09_siswanonrutintempgrid$o<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_siswanonrutin_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->siswanonrutin_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t09_siswanonrutintemp->Periode_Awal->Visible) { // Periode_Awal ?>
		<td data-name="Periode_Awal"<?php echo $t09_siswanonrutintemp->Periode_Awal->CellAttributes() ?>>
<?php if ($t09_siswanonrutintemp->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t09_siswanonrutintemp_grid->RowCnt ?>_t09_siswanonrutintemp_Periode_Awal" class="form-group t09_siswanonrutintemp_Periode_Awal">
<select data-table="t09_siswanonrutintemp" data-field="x_Periode_Awal" data-value-separator="<?php echo $t09_siswanonrutintemp->Periode_Awal->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Awal" name="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Awal"<?php echo $t09_siswanonrutintemp->Periode_Awal->EditAttributes() ?>>
<?php echo $t09_siswanonrutintemp->Periode_Awal->SelectOptionListHtml("x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Awal") ?>
</select>
<input type="hidden" name="s_x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Awal" id="s_x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Awal" value="<?php echo $t09_siswanonrutintemp->Periode_Awal->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_Periode_Awal" name="o<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Awal" id="o<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Awal" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->Periode_Awal->OldValue) ?>">
<?php } ?>
<?php if ($t09_siswanonrutintemp->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t09_siswanonrutintemp_grid->RowCnt ?>_t09_siswanonrutintemp_Periode_Awal" class="form-group t09_siswanonrutintemp_Periode_Awal">
<select data-table="t09_siswanonrutintemp" data-field="x_Periode_Awal" data-value-separator="<?php echo $t09_siswanonrutintemp->Periode_Awal->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Awal" name="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Awal"<?php echo $t09_siswanonrutintemp->Periode_Awal->EditAttributes() ?>>
<?php echo $t09_siswanonrutintemp->Periode_Awal->SelectOptionListHtml("x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Awal") ?>
</select>
<input type="hidden" name="s_x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Awal" id="s_x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Awal" value="<?php echo $t09_siswanonrutintemp->Periode_Awal->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($t09_siswanonrutintemp->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t09_siswanonrutintemp_grid->RowCnt ?>_t09_siswanonrutintemp_Periode_Awal" class="t09_siswanonrutintemp_Periode_Awal">
<span<?php echo $t09_siswanonrutintemp->Periode_Awal->ViewAttributes() ?>>
<?php echo $t09_siswanonrutintemp->Periode_Awal->ListViewValue() ?></span>
</span>
<?php if ($t09_siswanonrutintemp->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_Periode_Awal" name="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Awal" id="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Awal" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->Periode_Awal->FormValue) ?>">
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_Periode_Awal" name="o<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Awal" id="o<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Awal" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->Periode_Awal->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_Periode_Awal" name="ft09_siswanonrutintempgrid$x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Awal" id="ft09_siswanonrutintempgrid$x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Awal" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->Periode_Awal->FormValue) ?>">
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_Periode_Awal" name="ft09_siswanonrutintempgrid$o<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Awal" id="ft09_siswanonrutintempgrid$o<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Awal" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->Periode_Awal->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t09_siswanonrutintemp->Periode_Akhir->Visible) { // Periode_Akhir ?>
		<td data-name="Periode_Akhir"<?php echo $t09_siswanonrutintemp->Periode_Akhir->CellAttributes() ?>>
<?php if ($t09_siswanonrutintemp->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t09_siswanonrutintemp_grid->RowCnt ?>_t09_siswanonrutintemp_Periode_Akhir" class="form-group t09_siswanonrutintemp_Periode_Akhir">
<select data-table="t09_siswanonrutintemp" data-field="x_Periode_Akhir" data-value-separator="<?php echo $t09_siswanonrutintemp->Periode_Akhir->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Akhir" name="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Akhir"<?php echo $t09_siswanonrutintemp->Periode_Akhir->EditAttributes() ?>>
<?php echo $t09_siswanonrutintemp->Periode_Akhir->SelectOptionListHtml("x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Akhir") ?>
</select>
<input type="hidden" name="s_x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Akhir" id="s_x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Akhir" value="<?php echo $t09_siswanonrutintemp->Periode_Akhir->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_Periode_Akhir" name="o<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Akhir" id="o<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Akhir" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->Periode_Akhir->OldValue) ?>">
<?php } ?>
<?php if ($t09_siswanonrutintemp->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t09_siswanonrutintemp_grid->RowCnt ?>_t09_siswanonrutintemp_Periode_Akhir" class="form-group t09_siswanonrutintemp_Periode_Akhir">
<select data-table="t09_siswanonrutintemp" data-field="x_Periode_Akhir" data-value-separator="<?php echo $t09_siswanonrutintemp->Periode_Akhir->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Akhir" name="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Akhir"<?php echo $t09_siswanonrutintemp->Periode_Akhir->EditAttributes() ?>>
<?php echo $t09_siswanonrutintemp->Periode_Akhir->SelectOptionListHtml("x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Akhir") ?>
</select>
<input type="hidden" name="s_x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Akhir" id="s_x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Akhir" value="<?php echo $t09_siswanonrutintemp->Periode_Akhir->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($t09_siswanonrutintemp->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t09_siswanonrutintemp_grid->RowCnt ?>_t09_siswanonrutintemp_Periode_Akhir" class="t09_siswanonrutintemp_Periode_Akhir">
<span<?php echo $t09_siswanonrutintemp->Periode_Akhir->ViewAttributes() ?>>
<?php echo $t09_siswanonrutintemp->Periode_Akhir->ListViewValue() ?></span>
</span>
<?php if ($t09_siswanonrutintemp->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_Periode_Akhir" name="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Akhir" id="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Akhir" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->Periode_Akhir->FormValue) ?>">
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_Periode_Akhir" name="o<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Akhir" id="o<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Akhir" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->Periode_Akhir->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_Periode_Akhir" name="ft09_siswanonrutintempgrid$x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Akhir" id="ft09_siswanonrutintempgrid$x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Akhir" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->Periode_Akhir->FormValue) ?>">
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_Periode_Akhir" name="ft09_siswanonrutintempgrid$o<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Akhir" id="ft09_siswanonrutintempgrid$o<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Akhir" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->Periode_Akhir->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t09_siswanonrutintemp->Nilai->Visible) { // Nilai ?>
		<td data-name="Nilai"<?php echo $t09_siswanonrutintemp->Nilai->CellAttributes() ?>>
<?php if ($t09_siswanonrutintemp->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t09_siswanonrutintemp_grid->RowCnt ?>_t09_siswanonrutintemp_Nilai" class="form-group t09_siswanonrutintemp_Nilai">
<input type="text" data-table="t09_siswanonrutintemp" data-field="x_Nilai" name="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Nilai" id="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Nilai" size="30" placeholder="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->Nilai->getPlaceHolder()) ?>" value="<?php echo $t09_siswanonrutintemp->Nilai->EditValue ?>"<?php echo $t09_siswanonrutintemp->Nilai->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_Nilai" name="o<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Nilai" id="o<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Nilai" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->Nilai->OldValue) ?>">
<?php } ?>
<?php if ($t09_siswanonrutintemp->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t09_siswanonrutintemp_grid->RowCnt ?>_t09_siswanonrutintemp_Nilai" class="form-group t09_siswanonrutintemp_Nilai">
<input type="text" data-table="t09_siswanonrutintemp" data-field="x_Nilai" name="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Nilai" id="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Nilai" size="30" placeholder="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->Nilai->getPlaceHolder()) ?>" value="<?php echo $t09_siswanonrutintemp->Nilai->EditValue ?>"<?php echo $t09_siswanonrutintemp->Nilai->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t09_siswanonrutintemp->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t09_siswanonrutintemp_grid->RowCnt ?>_t09_siswanonrutintemp_Nilai" class="t09_siswanonrutintemp_Nilai">
<span<?php echo $t09_siswanonrutintemp->Nilai->ViewAttributes() ?>>
<?php echo $t09_siswanonrutintemp->Nilai->ListViewValue() ?></span>
</span>
<?php if ($t09_siswanonrutintemp->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_Nilai" name="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Nilai" id="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Nilai" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->Nilai->FormValue) ?>">
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_Nilai" name="o<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Nilai" id="o<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Nilai" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->Nilai->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_Nilai" name="ft09_siswanonrutintempgrid$x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Nilai" id="ft09_siswanonrutintempgrid$x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Nilai" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->Nilai->FormValue) ?>">
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_Nilai" name="ft09_siswanonrutintempgrid$o<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Nilai" id="ft09_siswanonrutintempgrid$o<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Nilai" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->Nilai->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t09_siswanonrutintemp_grid->ListOptions->Render("body", "right", $t09_siswanonrutintemp_grid->RowCnt);
?>
	</tr>
<?php if ($t09_siswanonrutintemp->RowType == EW_ROWTYPE_ADD || $t09_siswanonrutintemp->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ft09_siswanonrutintempgrid.UpdateOpts(<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($t09_siswanonrutintemp->CurrentAction <> "gridadd" || $t09_siswanonrutintemp->CurrentMode == "copy")
		if (!$t09_siswanonrutintemp_grid->Recordset->EOF) $t09_siswanonrutintemp_grid->Recordset->MoveNext();
}
?>
<?php
	if ($t09_siswanonrutintemp->CurrentMode == "add" || $t09_siswanonrutintemp->CurrentMode == "copy" || $t09_siswanonrutintemp->CurrentMode == "edit") {
		$t09_siswanonrutintemp_grid->RowIndex = '$rowindex$';
		$t09_siswanonrutintemp_grid->LoadDefaultValues();

		// Set row properties
		$t09_siswanonrutintemp->ResetAttrs();
		$t09_siswanonrutintemp->RowAttrs = array_merge($t09_siswanonrutintemp->RowAttrs, array('data-rowindex'=>$t09_siswanonrutintemp_grid->RowIndex, 'id'=>'r0_t09_siswanonrutintemp', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($t09_siswanonrutintemp->RowAttrs["class"], "ewTemplate");
		$t09_siswanonrutintemp->RowType = EW_ROWTYPE_ADD;

		// Render row
		$t09_siswanonrutintemp_grid->RenderRow();

		// Render list options
		$t09_siswanonrutintemp_grid->RenderListOptions();
		$t09_siswanonrutintemp_grid->StartRowCnt = 0;
?>
	<tr<?php echo $t09_siswanonrutintemp->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t09_siswanonrutintemp_grid->ListOptions->Render("body", "left", $t09_siswanonrutintemp_grid->RowIndex);
?>
	<?php if ($t09_siswanonrutintemp->siswa_id->Visible) { // siswa_id ?>
		<td data-name="siswa_id">
<?php if ($t09_siswanonrutintemp->CurrentAction <> "F") { ?>
<?php if ($t09_siswanonrutintemp->siswa_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_t09_siswanonrutintemp_siswa_id" class="form-group t09_siswanonrutintemp_siswa_id">
<span<?php echo $t09_siswanonrutintemp->siswa_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t09_siswanonrutintemp->siswa_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_siswa_id" name="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_siswa_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->siswa_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_t09_siswanonrutintemp_siswa_id" class="form-group t09_siswanonrutintemp_siswa_id">
<input type="text" data-table="t09_siswanonrutintemp" data-field="x_siswa_id" name="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_siswa_id" id="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_siswa_id" size="30" placeholder="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->siswa_id->getPlaceHolder()) ?>" value="<?php echo $t09_siswanonrutintemp->siswa_id->EditValue ?>"<?php echo $t09_siswanonrutintemp->siswa_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_t09_siswanonrutintemp_siswa_id" class="form-group t09_siswanonrutintemp_siswa_id">
<span<?php echo $t09_siswanonrutintemp->siswa_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t09_siswanonrutintemp->siswa_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_siswa_id" name="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_siswa_id" id="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_siswa_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->siswa_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_siswa_id" name="o<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_siswa_id" id="o<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_siswa_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->siswa_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t09_siswanonrutintemp->nonrutin_id->Visible) { // nonrutin_id ?>
		<td data-name="nonrutin_id">
<?php if ($t09_siswanonrutintemp->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t09_siswanonrutintemp_nonrutin_id" class="form-group t09_siswanonrutintemp_nonrutin_id">
<?php
$wrkonchange = trim(" " . @$t09_siswanonrutintemp->nonrutin_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t09_siswanonrutintemp->nonrutin_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_nonrutin_id" style="white-space: nowrap; z-index: <?php echo (9000 - $t09_siswanonrutintemp_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_nonrutin_id" id="sv_x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_nonrutin_id" value="<?php echo $t09_siswanonrutintemp->nonrutin_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->nonrutin_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->nonrutin_id->getPlaceHolder()) ?>"<?php echo $t09_siswanonrutintemp->nonrutin_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_nonrutin_id" data-value-separator="<?php echo $t09_siswanonrutintemp->nonrutin_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_nonrutin_id" id="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_nonrutin_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->nonrutin_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_nonrutin_id" id="q_x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_nonrutin_id" value="<?php echo $t09_siswanonrutintemp->nonrutin_id->LookupFilterQuery(true) ?>">
<script type="text/javascript">
ft09_siswanonrutintempgrid.CreateAutoSuggest({"id":"x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_nonrutin_id","forceSelect":false});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_t09_siswanonrutintemp_nonrutin_id" class="form-group t09_siswanonrutintemp_nonrutin_id">
<span<?php echo $t09_siswanonrutintemp->nonrutin_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t09_siswanonrutintemp->nonrutin_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_nonrutin_id" name="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_nonrutin_id" id="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_nonrutin_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->nonrutin_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_nonrutin_id" name="o<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_nonrutin_id" id="o<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_nonrutin_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->nonrutin_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t09_siswanonrutintemp->siswanonrutin_id->Visible) { // siswanonrutin_id ?>
		<td data-name="siswanonrutin_id">
<?php if ($t09_siswanonrutintemp->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t09_siswanonrutintemp_siswanonrutin_id" class="form-group t09_siswanonrutintemp_siswanonrutin_id">
<input type="text" data-table="t09_siswanonrutintemp" data-field="x_siswanonrutin_id" name="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_siswanonrutin_id" id="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_siswanonrutin_id" size="30" placeholder="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->siswanonrutin_id->getPlaceHolder()) ?>" value="<?php echo $t09_siswanonrutintemp->siswanonrutin_id->EditValue ?>"<?php echo $t09_siswanonrutintemp->siswanonrutin_id->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t09_siswanonrutintemp_siswanonrutin_id" class="form-group t09_siswanonrutintemp_siswanonrutin_id">
<span<?php echo $t09_siswanonrutintemp->siswanonrutin_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t09_siswanonrutintemp->siswanonrutin_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_siswanonrutin_id" name="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_siswanonrutin_id" id="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_siswanonrutin_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->siswanonrutin_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_siswanonrutin_id" name="o<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_siswanonrutin_id" id="o<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_siswanonrutin_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->siswanonrutin_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t09_siswanonrutintemp->Periode_Awal->Visible) { // Periode_Awal ?>
		<td data-name="Periode_Awal">
<?php if ($t09_siswanonrutintemp->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t09_siswanonrutintemp_Periode_Awal" class="form-group t09_siswanonrutintemp_Periode_Awal">
<select data-table="t09_siswanonrutintemp" data-field="x_Periode_Awal" data-value-separator="<?php echo $t09_siswanonrutintemp->Periode_Awal->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Awal" name="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Awal"<?php echo $t09_siswanonrutintemp->Periode_Awal->EditAttributes() ?>>
<?php echo $t09_siswanonrutintemp->Periode_Awal->SelectOptionListHtml("x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Awal") ?>
</select>
<input type="hidden" name="s_x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Awal" id="s_x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Awal" value="<?php echo $t09_siswanonrutintemp->Periode_Awal->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_t09_siswanonrutintemp_Periode_Awal" class="form-group t09_siswanonrutintemp_Periode_Awal">
<span<?php echo $t09_siswanonrutintemp->Periode_Awal->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t09_siswanonrutintemp->Periode_Awal->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_Periode_Awal" name="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Awal" id="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Awal" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->Periode_Awal->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_Periode_Awal" name="o<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Awal" id="o<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Awal" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->Periode_Awal->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t09_siswanonrutintemp->Periode_Akhir->Visible) { // Periode_Akhir ?>
		<td data-name="Periode_Akhir">
<?php if ($t09_siswanonrutintemp->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t09_siswanonrutintemp_Periode_Akhir" class="form-group t09_siswanonrutintemp_Periode_Akhir">
<select data-table="t09_siswanonrutintemp" data-field="x_Periode_Akhir" data-value-separator="<?php echo $t09_siswanonrutintemp->Periode_Akhir->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Akhir" name="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Akhir"<?php echo $t09_siswanonrutintemp->Periode_Akhir->EditAttributes() ?>>
<?php echo $t09_siswanonrutintemp->Periode_Akhir->SelectOptionListHtml("x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Akhir") ?>
</select>
<input type="hidden" name="s_x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Akhir" id="s_x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Akhir" value="<?php echo $t09_siswanonrutintemp->Periode_Akhir->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_t09_siswanonrutintemp_Periode_Akhir" class="form-group t09_siswanonrutintemp_Periode_Akhir">
<span<?php echo $t09_siswanonrutintemp->Periode_Akhir->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t09_siswanonrutintemp->Periode_Akhir->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_Periode_Akhir" name="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Akhir" id="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Akhir" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->Periode_Akhir->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_Periode_Akhir" name="o<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Akhir" id="o<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Periode_Akhir" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->Periode_Akhir->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t09_siswanonrutintemp->Nilai->Visible) { // Nilai ?>
		<td data-name="Nilai">
<?php if ($t09_siswanonrutintemp->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t09_siswanonrutintemp_Nilai" class="form-group t09_siswanonrutintemp_Nilai">
<input type="text" data-table="t09_siswanonrutintemp" data-field="x_Nilai" name="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Nilai" id="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Nilai" size="30" placeholder="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->Nilai->getPlaceHolder()) ?>" value="<?php echo $t09_siswanonrutintemp->Nilai->EditValue ?>"<?php echo $t09_siswanonrutintemp->Nilai->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t09_siswanonrutintemp_Nilai" class="form-group t09_siswanonrutintemp_Nilai">
<span<?php echo $t09_siswanonrutintemp->Nilai->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t09_siswanonrutintemp->Nilai->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_Nilai" name="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Nilai" id="x<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Nilai" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->Nilai->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_Nilai" name="o<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Nilai" id="o<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>_Nilai" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->Nilai->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t09_siswanonrutintemp_grid->ListOptions->Render("body", "right", $t09_siswanonrutintemp_grid->RowCnt);
?>
<script type="text/javascript">
ft09_siswanonrutintempgrid.UpdateOpts(<?php echo $t09_siswanonrutintemp_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($t09_siswanonrutintemp->CurrentMode == "add" || $t09_siswanonrutintemp->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $t09_siswanonrutintemp_grid->FormKeyCountName ?>" id="<?php echo $t09_siswanonrutintemp_grid->FormKeyCountName ?>" value="<?php echo $t09_siswanonrutintemp_grid->KeyCount ?>">
<?php echo $t09_siswanonrutintemp_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t09_siswanonrutintemp->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $t09_siswanonrutintemp_grid->FormKeyCountName ?>" id="<?php echo $t09_siswanonrutintemp_grid->FormKeyCountName ?>" value="<?php echo $t09_siswanonrutintemp_grid->KeyCount ?>">
<?php echo $t09_siswanonrutintemp_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t09_siswanonrutintemp->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="ft09_siswanonrutintempgrid">
</div>
<?php

// Close recordset
if ($t09_siswanonrutintemp_grid->Recordset)
	$t09_siswanonrutintemp_grid->Recordset->Close();
?>
<?php if ($t09_siswanonrutintemp_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($t09_siswanonrutintemp_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($t09_siswanonrutintemp_grid->TotalRecs == 0 && $t09_siswanonrutintemp->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t09_siswanonrutintemp_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($t09_siswanonrutintemp->Export == "") { ?>
<script type="text/javascript">
ft09_siswanonrutintempgrid.Init();
</script>
<?php } ?>
<?php
$t09_siswanonrutintemp_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$t09_siswanonrutintemp_grid->Page_Terminate();
?>
