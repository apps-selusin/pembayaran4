<?php

// Create page object
if (!isset($t07_siswarutinbayar_grid)) $t07_siswarutinbayar_grid = new ct07_siswarutinbayar_grid();

// Page init
$t07_siswarutinbayar_grid->Page_Init();

// Page main
$t07_siswarutinbayar_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t07_siswarutinbayar_grid->Page_Render();
?>
<?php if ($t07_siswarutinbayar->Export == "") { ?>
<script type="text/javascript">

// Form object
var ft07_siswarutinbayargrid = new ew_Form("ft07_siswarutinbayargrid", "grid");
ft07_siswarutinbayargrid.FormKeyCountName = '<?php echo $t07_siswarutinbayar_grid->FormKeyCountName ?>';

// Validate form
ft07_siswarutinbayargrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_siswarutin_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t07_siswarutinbayar->siswarutin_id->FldCaption(), $t07_siswarutinbayar->siswarutin_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_siswarutin_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t07_siswarutinbayar->siswarutin_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Bulan");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t07_siswarutinbayar->Bulan->FldCaption(), $t07_siswarutinbayar->Bulan->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Tahun");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t07_siswarutinbayar->Tahun->FldCaption(), $t07_siswarutinbayar->Tahun->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Nilai");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t07_siswarutinbayar->Nilai->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Tanggal_Bayar");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t07_siswarutinbayar->Tanggal_Bayar->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Nilai_Bayar");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t07_siswarutinbayar->Nilai_Bayar->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
ft07_siswarutinbayargrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "siswarutin_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Bulan", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Tahun", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Nilai", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Tanggal_Bayar", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Nilai_Bayar", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Periode", false)) return false;
	return true;
}

// Form_CustomValidate event
ft07_siswarutinbayargrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft07_siswarutinbayargrid.ValidateRequired = true;
<?php } else { ?>
ft07_siswarutinbayargrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft07_siswarutinbayargrid.Lists["x_Bulan"] = {"LinkField":"x_Bulan","Ajax":true,"AutoFill":false,"DisplayFields":["x_Bulan","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t07_siswarutinbayar"};
ft07_siswarutinbayargrid.Lists["x_Tahun"] = {"LinkField":"x_Tahun","Ajax":true,"AutoFill":false,"DisplayFields":["x_Tahun","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t07_siswarutinbayar"};

// Form object for search
</script>
<?php } ?>
<?php
if ($t07_siswarutinbayar->CurrentAction == "gridadd") {
	if ($t07_siswarutinbayar->CurrentMode == "copy") {
		$bSelectLimit = $t07_siswarutinbayar_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$t07_siswarutinbayar_grid->TotalRecs = $t07_siswarutinbayar->SelectRecordCount();
			$t07_siswarutinbayar_grid->Recordset = $t07_siswarutinbayar_grid->LoadRecordset($t07_siswarutinbayar_grid->StartRec-1, $t07_siswarutinbayar_grid->DisplayRecs);
		} else {
			if ($t07_siswarutinbayar_grid->Recordset = $t07_siswarutinbayar_grid->LoadRecordset())
				$t07_siswarutinbayar_grid->TotalRecs = $t07_siswarutinbayar_grid->Recordset->RecordCount();
		}
		$t07_siswarutinbayar_grid->StartRec = 1;
		$t07_siswarutinbayar_grid->DisplayRecs = $t07_siswarutinbayar_grid->TotalRecs;
	} else {
		$t07_siswarutinbayar->CurrentFilter = "0=1";
		$t07_siswarutinbayar_grid->StartRec = 1;
		$t07_siswarutinbayar_grid->DisplayRecs = $t07_siswarutinbayar->GridAddRowCount;
	}
	$t07_siswarutinbayar_grid->TotalRecs = $t07_siswarutinbayar_grid->DisplayRecs;
	$t07_siswarutinbayar_grid->StopRec = $t07_siswarutinbayar_grid->DisplayRecs;
} else {
	$bSelectLimit = $t07_siswarutinbayar_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($t07_siswarutinbayar_grid->TotalRecs <= 0)
			$t07_siswarutinbayar_grid->TotalRecs = $t07_siswarutinbayar->SelectRecordCount();
	} else {
		if (!$t07_siswarutinbayar_grid->Recordset && ($t07_siswarutinbayar_grid->Recordset = $t07_siswarutinbayar_grid->LoadRecordset()))
			$t07_siswarutinbayar_grid->TotalRecs = $t07_siswarutinbayar_grid->Recordset->RecordCount();
	}
	$t07_siswarutinbayar_grid->StartRec = 1;
	$t07_siswarutinbayar_grid->DisplayRecs = $t07_siswarutinbayar_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$t07_siswarutinbayar_grid->Recordset = $t07_siswarutinbayar_grid->LoadRecordset($t07_siswarutinbayar_grid->StartRec-1, $t07_siswarutinbayar_grid->DisplayRecs);

	// Set no record found message
	if ($t07_siswarutinbayar->CurrentAction == "" && $t07_siswarutinbayar_grid->TotalRecs == 0) {
		if ($t07_siswarutinbayar_grid->SearchWhere == "0=101")
			$t07_siswarutinbayar_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$t07_siswarutinbayar_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$t07_siswarutinbayar_grid->RenderOtherOptions();
?>
<?php $t07_siswarutinbayar_grid->ShowPageHeader(); ?>
<?php
$t07_siswarutinbayar_grid->ShowMessage();
?>
<?php if ($t07_siswarutinbayar_grid->TotalRecs > 0 || $t07_siswarutinbayar->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid t07_siswarutinbayar">
<div id="ft07_siswarutinbayargrid" class="ewForm form-inline">
<div id="gmp_t07_siswarutinbayar" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_t07_siswarutinbayargrid" class="table ewTable">
<?php echo $t07_siswarutinbayar->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$t07_siswarutinbayar_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$t07_siswarutinbayar_grid->RenderListOptions();

// Render list options (header, left)
$t07_siswarutinbayar_grid->ListOptions->Render("header", "left");
?>
<?php if ($t07_siswarutinbayar->siswarutin_id->Visible) { // siswarutin_id ?>
	<?php if ($t07_siswarutinbayar->SortUrl($t07_siswarutinbayar->siswarutin_id) == "") { ?>
		<th data-name="siswarutin_id"><div id="elh_t07_siswarutinbayar_siswarutin_id" class="t07_siswarutinbayar_siswarutin_id"><div class="ewTableHeaderCaption"><?php echo $t07_siswarutinbayar->siswarutin_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="siswarutin_id"><div><div id="elh_t07_siswarutinbayar_siswarutin_id" class="t07_siswarutinbayar_siswarutin_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t07_siswarutinbayar->siswarutin_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t07_siswarutinbayar->siswarutin_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t07_siswarutinbayar->siswarutin_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t07_siswarutinbayar->Bulan->Visible) { // Bulan ?>
	<?php if ($t07_siswarutinbayar->SortUrl($t07_siswarutinbayar->Bulan) == "") { ?>
		<th data-name="Bulan"><div id="elh_t07_siswarutinbayar_Bulan" class="t07_siswarutinbayar_Bulan"><div class="ewTableHeaderCaption"><?php echo $t07_siswarutinbayar->Bulan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Bulan"><div><div id="elh_t07_siswarutinbayar_Bulan" class="t07_siswarutinbayar_Bulan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t07_siswarutinbayar->Bulan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t07_siswarutinbayar->Bulan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t07_siswarutinbayar->Bulan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t07_siswarutinbayar->Tahun->Visible) { // Tahun ?>
	<?php if ($t07_siswarutinbayar->SortUrl($t07_siswarutinbayar->Tahun) == "") { ?>
		<th data-name="Tahun"><div id="elh_t07_siswarutinbayar_Tahun" class="t07_siswarutinbayar_Tahun"><div class="ewTableHeaderCaption"><?php echo $t07_siswarutinbayar->Tahun->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Tahun"><div><div id="elh_t07_siswarutinbayar_Tahun" class="t07_siswarutinbayar_Tahun">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t07_siswarutinbayar->Tahun->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t07_siswarutinbayar->Tahun->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t07_siswarutinbayar->Tahun->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t07_siswarutinbayar->Nilai->Visible) { // Nilai ?>
	<?php if ($t07_siswarutinbayar->SortUrl($t07_siswarutinbayar->Nilai) == "") { ?>
		<th data-name="Nilai"><div id="elh_t07_siswarutinbayar_Nilai" class="t07_siswarutinbayar_Nilai"><div class="ewTableHeaderCaption"><?php echo $t07_siswarutinbayar->Nilai->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nilai"><div><div id="elh_t07_siswarutinbayar_Nilai" class="t07_siswarutinbayar_Nilai">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t07_siswarutinbayar->Nilai->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t07_siswarutinbayar->Nilai->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t07_siswarutinbayar->Nilai->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t07_siswarutinbayar->Tanggal_Bayar->Visible) { // Tanggal_Bayar ?>
	<?php if ($t07_siswarutinbayar->SortUrl($t07_siswarutinbayar->Tanggal_Bayar) == "") { ?>
		<th data-name="Tanggal_Bayar"><div id="elh_t07_siswarutinbayar_Tanggal_Bayar" class="t07_siswarutinbayar_Tanggal_Bayar"><div class="ewTableHeaderCaption"><?php echo $t07_siswarutinbayar->Tanggal_Bayar->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Tanggal_Bayar"><div><div id="elh_t07_siswarutinbayar_Tanggal_Bayar" class="t07_siswarutinbayar_Tanggal_Bayar">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t07_siswarutinbayar->Tanggal_Bayar->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t07_siswarutinbayar->Tanggal_Bayar->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t07_siswarutinbayar->Tanggal_Bayar->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t07_siswarutinbayar->Nilai_Bayar->Visible) { // Nilai_Bayar ?>
	<?php if ($t07_siswarutinbayar->SortUrl($t07_siswarutinbayar->Nilai_Bayar) == "") { ?>
		<th data-name="Nilai_Bayar"><div id="elh_t07_siswarutinbayar_Nilai_Bayar" class="t07_siswarutinbayar_Nilai_Bayar"><div class="ewTableHeaderCaption"><?php echo $t07_siswarutinbayar->Nilai_Bayar->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nilai_Bayar"><div><div id="elh_t07_siswarutinbayar_Nilai_Bayar" class="t07_siswarutinbayar_Nilai_Bayar">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t07_siswarutinbayar->Nilai_Bayar->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t07_siswarutinbayar->Nilai_Bayar->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t07_siswarutinbayar->Nilai_Bayar->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t07_siswarutinbayar->Periode->Visible) { // Periode ?>
	<?php if ($t07_siswarutinbayar->SortUrl($t07_siswarutinbayar->Periode) == "") { ?>
		<th data-name="Periode"><div id="elh_t07_siswarutinbayar_Periode" class="t07_siswarutinbayar_Periode"><div class="ewTableHeaderCaption"><?php echo $t07_siswarutinbayar->Periode->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Periode"><div><div id="elh_t07_siswarutinbayar_Periode" class="t07_siswarutinbayar_Periode">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t07_siswarutinbayar->Periode->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t07_siswarutinbayar->Periode->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t07_siswarutinbayar->Periode->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$t07_siswarutinbayar_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$t07_siswarutinbayar_grid->StartRec = 1;
$t07_siswarutinbayar_grid->StopRec = $t07_siswarutinbayar_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($t07_siswarutinbayar_grid->FormKeyCountName) && ($t07_siswarutinbayar->CurrentAction == "gridadd" || $t07_siswarutinbayar->CurrentAction == "gridedit" || $t07_siswarutinbayar->CurrentAction == "F")) {
		$t07_siswarutinbayar_grid->KeyCount = $objForm->GetValue($t07_siswarutinbayar_grid->FormKeyCountName);
		$t07_siswarutinbayar_grid->StopRec = $t07_siswarutinbayar_grid->StartRec + $t07_siswarutinbayar_grid->KeyCount - 1;
	}
}
$t07_siswarutinbayar_grid->RecCnt = $t07_siswarutinbayar_grid->StartRec - 1;
if ($t07_siswarutinbayar_grid->Recordset && !$t07_siswarutinbayar_grid->Recordset->EOF) {
	$t07_siswarutinbayar_grid->Recordset->MoveFirst();
	$bSelectLimit = $t07_siswarutinbayar_grid->UseSelectLimit;
	if (!$bSelectLimit && $t07_siswarutinbayar_grid->StartRec > 1)
		$t07_siswarutinbayar_grid->Recordset->Move($t07_siswarutinbayar_grid->StartRec - 1);
} elseif (!$t07_siswarutinbayar->AllowAddDeleteRow && $t07_siswarutinbayar_grid->StopRec == 0) {
	$t07_siswarutinbayar_grid->StopRec = $t07_siswarutinbayar->GridAddRowCount;
}

// Initialize aggregate
$t07_siswarutinbayar->RowType = EW_ROWTYPE_AGGREGATEINIT;
$t07_siswarutinbayar->ResetAttrs();
$t07_siswarutinbayar_grid->RenderRow();
if ($t07_siswarutinbayar->CurrentAction == "gridadd")
	$t07_siswarutinbayar_grid->RowIndex = 0;
if ($t07_siswarutinbayar->CurrentAction == "gridedit")
	$t07_siswarutinbayar_grid->RowIndex = 0;
while ($t07_siswarutinbayar_grid->RecCnt < $t07_siswarutinbayar_grid->StopRec) {
	$t07_siswarutinbayar_grid->RecCnt++;
	if (intval($t07_siswarutinbayar_grid->RecCnt) >= intval($t07_siswarutinbayar_grid->StartRec)) {
		$t07_siswarutinbayar_grid->RowCnt++;
		if ($t07_siswarutinbayar->CurrentAction == "gridadd" || $t07_siswarutinbayar->CurrentAction == "gridedit" || $t07_siswarutinbayar->CurrentAction == "F") {
			$t07_siswarutinbayar_grid->RowIndex++;
			$objForm->Index = $t07_siswarutinbayar_grid->RowIndex;
			if ($objForm->HasValue($t07_siswarutinbayar_grid->FormActionName))
				$t07_siswarutinbayar_grid->RowAction = strval($objForm->GetValue($t07_siswarutinbayar_grid->FormActionName));
			elseif ($t07_siswarutinbayar->CurrentAction == "gridadd")
				$t07_siswarutinbayar_grid->RowAction = "insert";
			else
				$t07_siswarutinbayar_grid->RowAction = "";
		}

		// Set up key count
		$t07_siswarutinbayar_grid->KeyCount = $t07_siswarutinbayar_grid->RowIndex;

		// Init row class and style
		$t07_siswarutinbayar->ResetAttrs();
		$t07_siswarutinbayar->CssClass = "";
		if ($t07_siswarutinbayar->CurrentAction == "gridadd") {
			if ($t07_siswarutinbayar->CurrentMode == "copy") {
				$t07_siswarutinbayar_grid->LoadRowValues($t07_siswarutinbayar_grid->Recordset); // Load row values
				$t07_siswarutinbayar_grid->SetRecordKey($t07_siswarutinbayar_grid->RowOldKey, $t07_siswarutinbayar_grid->Recordset); // Set old record key
			} else {
				$t07_siswarutinbayar_grid->LoadDefaultValues(); // Load default values
				$t07_siswarutinbayar_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$t07_siswarutinbayar_grid->LoadRowValues($t07_siswarutinbayar_grid->Recordset); // Load row values
		}
		$t07_siswarutinbayar->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($t07_siswarutinbayar->CurrentAction == "gridadd") // Grid add
			$t07_siswarutinbayar->RowType = EW_ROWTYPE_ADD; // Render add
		if ($t07_siswarutinbayar->CurrentAction == "gridadd" && $t07_siswarutinbayar->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$t07_siswarutinbayar_grid->RestoreCurrentRowFormValues($t07_siswarutinbayar_grid->RowIndex); // Restore form values
		if ($t07_siswarutinbayar->CurrentAction == "gridedit") { // Grid edit
			if ($t07_siswarutinbayar->EventCancelled) {
				$t07_siswarutinbayar_grid->RestoreCurrentRowFormValues($t07_siswarutinbayar_grid->RowIndex); // Restore form values
			}
			if ($t07_siswarutinbayar_grid->RowAction == "insert")
				$t07_siswarutinbayar->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$t07_siswarutinbayar->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($t07_siswarutinbayar->CurrentAction == "gridedit" && ($t07_siswarutinbayar->RowType == EW_ROWTYPE_EDIT || $t07_siswarutinbayar->RowType == EW_ROWTYPE_ADD) && $t07_siswarutinbayar->EventCancelled) // Update failed
			$t07_siswarutinbayar_grid->RestoreCurrentRowFormValues($t07_siswarutinbayar_grid->RowIndex); // Restore form values
		if ($t07_siswarutinbayar->RowType == EW_ROWTYPE_EDIT) // Edit row
			$t07_siswarutinbayar_grid->EditRowCnt++;
		if ($t07_siswarutinbayar->CurrentAction == "F") // Confirm row
			$t07_siswarutinbayar_grid->RestoreCurrentRowFormValues($t07_siswarutinbayar_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$t07_siswarutinbayar->RowAttrs = array_merge($t07_siswarutinbayar->RowAttrs, array('data-rowindex'=>$t07_siswarutinbayar_grid->RowCnt, 'id'=>'r' . $t07_siswarutinbayar_grid->RowCnt . '_t07_siswarutinbayar', 'data-rowtype'=>$t07_siswarutinbayar->RowType));

		// Render row
		$t07_siswarutinbayar_grid->RenderRow();

		// Render list options
		$t07_siswarutinbayar_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($t07_siswarutinbayar_grid->RowAction <> "delete" && $t07_siswarutinbayar_grid->RowAction <> "insertdelete" && !($t07_siswarutinbayar_grid->RowAction == "insert" && $t07_siswarutinbayar->CurrentAction == "F" && $t07_siswarutinbayar_grid->EmptyRow())) {
?>
	<tr<?php echo $t07_siswarutinbayar->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t07_siswarutinbayar_grid->ListOptions->Render("body", "left", $t07_siswarutinbayar_grid->RowCnt);
?>
	<?php if ($t07_siswarutinbayar->siswarutin_id->Visible) { // siswarutin_id ?>
		<td data-name="siswarutin_id"<?php echo $t07_siswarutinbayar->siswarutin_id->CellAttributes() ?>>
<?php if ($t07_siswarutinbayar->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($t07_siswarutinbayar->siswarutin_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $t07_siswarutinbayar_grid->RowCnt ?>_t07_siswarutinbayar_siswarutin_id" class="form-group t07_siswarutinbayar_siswarutin_id">
<span<?php echo $t07_siswarutinbayar->siswarutin_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t07_siswarutinbayar->siswarutin_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_siswarutin_id" name="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_siswarutin_id" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->siswarutin_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $t07_siswarutinbayar_grid->RowCnt ?>_t07_siswarutinbayar_siswarutin_id" class="form-group t07_siswarutinbayar_siswarutin_id">
<input type="text" data-table="t07_siswarutinbayar" data-field="x_siswarutin_id" name="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_siswarutin_id" id="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_siswarutin_id" size="30" placeholder="<?php echo ew_HtmlEncode($t07_siswarutinbayar->siswarutin_id->getPlaceHolder()) ?>" value="<?php echo $t07_siswarutinbayar->siswarutin_id->EditValue ?>"<?php echo $t07_siswarutinbayar->siswarutin_id->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_siswarutin_id" name="o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_siswarutin_id" id="o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_siswarutin_id" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->siswarutin_id->OldValue) ?>">
<?php } ?>
<?php if ($t07_siswarutinbayar->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($t07_siswarutinbayar->siswarutin_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $t07_siswarutinbayar_grid->RowCnt ?>_t07_siswarutinbayar_siswarutin_id" class="form-group t07_siswarutinbayar_siswarutin_id">
<span<?php echo $t07_siswarutinbayar->siswarutin_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t07_siswarutinbayar->siswarutin_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_siswarutin_id" name="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_siswarutin_id" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->siswarutin_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $t07_siswarutinbayar_grid->RowCnt ?>_t07_siswarutinbayar_siswarutin_id" class="form-group t07_siswarutinbayar_siswarutin_id">
<input type="text" data-table="t07_siswarutinbayar" data-field="x_siswarutin_id" name="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_siswarutin_id" id="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_siswarutin_id" size="30" placeholder="<?php echo ew_HtmlEncode($t07_siswarutinbayar->siswarutin_id->getPlaceHolder()) ?>" value="<?php echo $t07_siswarutinbayar->siswarutin_id->EditValue ?>"<?php echo $t07_siswarutinbayar->siswarutin_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php } ?>
<?php if ($t07_siswarutinbayar->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t07_siswarutinbayar_grid->RowCnt ?>_t07_siswarutinbayar_siswarutin_id" class="t07_siswarutinbayar_siswarutin_id">
<span<?php echo $t07_siswarutinbayar->siswarutin_id->ViewAttributes() ?>>
<?php echo $t07_siswarutinbayar->siswarutin_id->ListViewValue() ?></span>
</span>
<?php if ($t07_siswarutinbayar->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_siswarutin_id" name="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_siswarutin_id" id="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_siswarutin_id" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->siswarutin_id->FormValue) ?>">
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_siswarutin_id" name="o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_siswarutin_id" id="o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_siswarutin_id" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->siswarutin_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_siswarutin_id" name="ft07_siswarutinbayargrid$x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_siswarutin_id" id="ft07_siswarutinbayargrid$x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_siswarutin_id" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->siswarutin_id->FormValue) ?>">
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_siswarutin_id" name="ft07_siswarutinbayargrid$o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_siswarutin_id" id="ft07_siswarutinbayargrid$o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_siswarutin_id" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->siswarutin_id->OldValue) ?>">
<?php } ?>
<?php } ?>
<a id="<?php echo $t07_siswarutinbayar_grid->PageObjName . "_row_" . $t07_siswarutinbayar_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($t07_siswarutinbayar->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_id" name="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_id" id="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->id->CurrentValue) ?>">
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_id" name="o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_id" id="o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->id->OldValue) ?>">
<?php } ?>
<?php if ($t07_siswarutinbayar->RowType == EW_ROWTYPE_EDIT || $t07_siswarutinbayar->CurrentMode == "edit") { ?>
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_id" name="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_id" id="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->id->CurrentValue) ?>">
<?php } ?>
	<?php if ($t07_siswarutinbayar->Bulan->Visible) { // Bulan ?>
		<td data-name="Bulan"<?php echo $t07_siswarutinbayar->Bulan->CellAttributes() ?>>
<?php if ($t07_siswarutinbayar->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t07_siswarutinbayar_grid->RowCnt ?>_t07_siswarutinbayar_Bulan" class="form-group t07_siswarutinbayar_Bulan">
<select data-table="t07_siswarutinbayar" data-field="x_Bulan" data-value-separator="<?php echo $t07_siswarutinbayar->Bulan->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Bulan" name="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Bulan"<?php echo $t07_siswarutinbayar->Bulan->EditAttributes() ?>>
<?php echo $t07_siswarutinbayar->Bulan->SelectOptionListHtml("x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Bulan") ?>
</select>
<input type="hidden" name="s_x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Bulan" id="s_x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Bulan" value="<?php echo $t07_siswarutinbayar->Bulan->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_Bulan" name="o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Bulan" id="o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Bulan" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Bulan->OldValue) ?>">
<?php } ?>
<?php if ($t07_siswarutinbayar->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t07_siswarutinbayar_grid->RowCnt ?>_t07_siswarutinbayar_Bulan" class="form-group t07_siswarutinbayar_Bulan">
<select data-table="t07_siswarutinbayar" data-field="x_Bulan" data-value-separator="<?php echo $t07_siswarutinbayar->Bulan->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Bulan" name="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Bulan"<?php echo $t07_siswarutinbayar->Bulan->EditAttributes() ?>>
<?php echo $t07_siswarutinbayar->Bulan->SelectOptionListHtml("x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Bulan") ?>
</select>
<input type="hidden" name="s_x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Bulan" id="s_x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Bulan" value="<?php echo $t07_siswarutinbayar->Bulan->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($t07_siswarutinbayar->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t07_siswarutinbayar_grid->RowCnt ?>_t07_siswarutinbayar_Bulan" class="t07_siswarutinbayar_Bulan">
<span<?php echo $t07_siswarutinbayar->Bulan->ViewAttributes() ?>>
<?php echo $t07_siswarutinbayar->Bulan->ListViewValue() ?></span>
</span>
<?php if ($t07_siswarutinbayar->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_Bulan" name="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Bulan" id="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Bulan" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Bulan->FormValue) ?>">
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_Bulan" name="o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Bulan" id="o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Bulan" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Bulan->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_Bulan" name="ft07_siswarutinbayargrid$x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Bulan" id="ft07_siswarutinbayargrid$x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Bulan" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Bulan->FormValue) ?>">
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_Bulan" name="ft07_siswarutinbayargrid$o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Bulan" id="ft07_siswarutinbayargrid$o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Bulan" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Bulan->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t07_siswarutinbayar->Tahun->Visible) { // Tahun ?>
		<td data-name="Tahun"<?php echo $t07_siswarutinbayar->Tahun->CellAttributes() ?>>
<?php if ($t07_siswarutinbayar->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t07_siswarutinbayar_grid->RowCnt ?>_t07_siswarutinbayar_Tahun" class="form-group t07_siswarutinbayar_Tahun">
<select data-table="t07_siswarutinbayar" data-field="x_Tahun" data-value-separator="<?php echo $t07_siswarutinbayar->Tahun->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Tahun" name="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Tahun"<?php echo $t07_siswarutinbayar->Tahun->EditAttributes() ?>>
<?php echo $t07_siswarutinbayar->Tahun->SelectOptionListHtml("x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Tahun") ?>
</select>
<input type="hidden" name="s_x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Tahun" id="s_x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Tahun" value="<?php echo $t07_siswarutinbayar->Tahun->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_Tahun" name="o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Tahun" id="o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Tahun" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Tahun->OldValue) ?>">
<?php } ?>
<?php if ($t07_siswarutinbayar->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t07_siswarutinbayar_grid->RowCnt ?>_t07_siswarutinbayar_Tahun" class="form-group t07_siswarutinbayar_Tahun">
<select data-table="t07_siswarutinbayar" data-field="x_Tahun" data-value-separator="<?php echo $t07_siswarutinbayar->Tahun->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Tahun" name="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Tahun"<?php echo $t07_siswarutinbayar->Tahun->EditAttributes() ?>>
<?php echo $t07_siswarutinbayar->Tahun->SelectOptionListHtml("x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Tahun") ?>
</select>
<input type="hidden" name="s_x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Tahun" id="s_x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Tahun" value="<?php echo $t07_siswarutinbayar->Tahun->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($t07_siswarutinbayar->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t07_siswarutinbayar_grid->RowCnt ?>_t07_siswarutinbayar_Tahun" class="t07_siswarutinbayar_Tahun">
<span<?php echo $t07_siswarutinbayar->Tahun->ViewAttributes() ?>>
<?php echo $t07_siswarutinbayar->Tahun->ListViewValue() ?></span>
</span>
<?php if ($t07_siswarutinbayar->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_Tahun" name="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Tahun" id="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Tahun" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Tahun->FormValue) ?>">
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_Tahun" name="o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Tahun" id="o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Tahun" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Tahun->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_Tahun" name="ft07_siswarutinbayargrid$x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Tahun" id="ft07_siswarutinbayargrid$x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Tahun" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Tahun->FormValue) ?>">
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_Tahun" name="ft07_siswarutinbayargrid$o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Tahun" id="ft07_siswarutinbayargrid$o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Tahun" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Tahun->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t07_siswarutinbayar->Nilai->Visible) { // Nilai ?>
		<td data-name="Nilai"<?php echo $t07_siswarutinbayar->Nilai->CellAttributes() ?>>
<?php if ($t07_siswarutinbayar->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t07_siswarutinbayar_grid->RowCnt ?>_t07_siswarutinbayar_Nilai" class="form-group t07_siswarutinbayar_Nilai">
<input type="text" data-table="t07_siswarutinbayar" data-field="x_Nilai" name="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Nilai" id="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Nilai" size="30" placeholder="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Nilai->getPlaceHolder()) ?>" value="<?php echo $t07_siswarutinbayar->Nilai->EditValue ?>"<?php echo $t07_siswarutinbayar->Nilai->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_Nilai" name="o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Nilai" id="o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Nilai" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Nilai->OldValue) ?>">
<?php } ?>
<?php if ($t07_siswarutinbayar->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t07_siswarutinbayar_grid->RowCnt ?>_t07_siswarutinbayar_Nilai" class="form-group t07_siswarutinbayar_Nilai">
<input type="text" data-table="t07_siswarutinbayar" data-field="x_Nilai" name="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Nilai" id="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Nilai" size="30" placeholder="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Nilai->getPlaceHolder()) ?>" value="<?php echo $t07_siswarutinbayar->Nilai->EditValue ?>"<?php echo $t07_siswarutinbayar->Nilai->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t07_siswarutinbayar->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t07_siswarutinbayar_grid->RowCnt ?>_t07_siswarutinbayar_Nilai" class="t07_siswarutinbayar_Nilai">
<span<?php echo $t07_siswarutinbayar->Nilai->ViewAttributes() ?>>
<?php echo $t07_siswarutinbayar->Nilai->ListViewValue() ?></span>
</span>
<?php if ($t07_siswarutinbayar->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_Nilai" name="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Nilai" id="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Nilai" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Nilai->FormValue) ?>">
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_Nilai" name="o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Nilai" id="o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Nilai" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Nilai->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_Nilai" name="ft07_siswarutinbayargrid$x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Nilai" id="ft07_siswarutinbayargrid$x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Nilai" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Nilai->FormValue) ?>">
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_Nilai" name="ft07_siswarutinbayargrid$o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Nilai" id="ft07_siswarutinbayargrid$o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Nilai" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Nilai->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t07_siswarutinbayar->Tanggal_Bayar->Visible) { // Tanggal_Bayar ?>
		<td data-name="Tanggal_Bayar"<?php echo $t07_siswarutinbayar->Tanggal_Bayar->CellAttributes() ?>>
<?php if ($t07_siswarutinbayar->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t07_siswarutinbayar_grid->RowCnt ?>_t07_siswarutinbayar_Tanggal_Bayar" class="form-group t07_siswarutinbayar_Tanggal_Bayar">
<input type="text" data-table="t07_siswarutinbayar" data-field="x_Tanggal_Bayar" data-format="7" name="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Tanggal_Bayar" id="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Tanggal_Bayar" placeholder="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Tanggal_Bayar->getPlaceHolder()) ?>" value="<?php echo $t07_siswarutinbayar->Tanggal_Bayar->EditValue ?>"<?php echo $t07_siswarutinbayar->Tanggal_Bayar->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_Tanggal_Bayar" name="o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Tanggal_Bayar" id="o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Tanggal_Bayar" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Tanggal_Bayar->OldValue) ?>">
<?php } ?>
<?php if ($t07_siswarutinbayar->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t07_siswarutinbayar_grid->RowCnt ?>_t07_siswarutinbayar_Tanggal_Bayar" class="form-group t07_siswarutinbayar_Tanggal_Bayar">
<input type="text" data-table="t07_siswarutinbayar" data-field="x_Tanggal_Bayar" data-format="7" name="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Tanggal_Bayar" id="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Tanggal_Bayar" placeholder="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Tanggal_Bayar->getPlaceHolder()) ?>" value="<?php echo $t07_siswarutinbayar->Tanggal_Bayar->EditValue ?>"<?php echo $t07_siswarutinbayar->Tanggal_Bayar->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t07_siswarutinbayar->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t07_siswarutinbayar_grid->RowCnt ?>_t07_siswarutinbayar_Tanggal_Bayar" class="t07_siswarutinbayar_Tanggal_Bayar">
<span<?php echo $t07_siswarutinbayar->Tanggal_Bayar->ViewAttributes() ?>>
<?php echo $t07_siswarutinbayar->Tanggal_Bayar->ListViewValue() ?></span>
</span>
<?php if ($t07_siswarutinbayar->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_Tanggal_Bayar" name="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Tanggal_Bayar" id="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Tanggal_Bayar" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Tanggal_Bayar->FormValue) ?>">
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_Tanggal_Bayar" name="o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Tanggal_Bayar" id="o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Tanggal_Bayar" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Tanggal_Bayar->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_Tanggal_Bayar" name="ft07_siswarutinbayargrid$x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Tanggal_Bayar" id="ft07_siswarutinbayargrid$x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Tanggal_Bayar" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Tanggal_Bayar->FormValue) ?>">
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_Tanggal_Bayar" name="ft07_siswarutinbayargrid$o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Tanggal_Bayar" id="ft07_siswarutinbayargrid$o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Tanggal_Bayar" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Tanggal_Bayar->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t07_siswarutinbayar->Nilai_Bayar->Visible) { // Nilai_Bayar ?>
		<td data-name="Nilai_Bayar"<?php echo $t07_siswarutinbayar->Nilai_Bayar->CellAttributes() ?>>
<?php if ($t07_siswarutinbayar->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t07_siswarutinbayar_grid->RowCnt ?>_t07_siswarutinbayar_Nilai_Bayar" class="form-group t07_siswarutinbayar_Nilai_Bayar">
<input type="text" data-table="t07_siswarutinbayar" data-field="x_Nilai_Bayar" name="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Nilai_Bayar" id="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Nilai_Bayar" size="30" placeholder="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Nilai_Bayar->getPlaceHolder()) ?>" value="<?php echo $t07_siswarutinbayar->Nilai_Bayar->EditValue ?>"<?php echo $t07_siswarutinbayar->Nilai_Bayar->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_Nilai_Bayar" name="o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Nilai_Bayar" id="o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Nilai_Bayar" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Nilai_Bayar->OldValue) ?>">
<?php } ?>
<?php if ($t07_siswarutinbayar->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t07_siswarutinbayar_grid->RowCnt ?>_t07_siswarutinbayar_Nilai_Bayar" class="form-group t07_siswarutinbayar_Nilai_Bayar">
<input type="text" data-table="t07_siswarutinbayar" data-field="x_Nilai_Bayar" name="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Nilai_Bayar" id="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Nilai_Bayar" size="30" placeholder="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Nilai_Bayar->getPlaceHolder()) ?>" value="<?php echo $t07_siswarutinbayar->Nilai_Bayar->EditValue ?>"<?php echo $t07_siswarutinbayar->Nilai_Bayar->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t07_siswarutinbayar->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t07_siswarutinbayar_grid->RowCnt ?>_t07_siswarutinbayar_Nilai_Bayar" class="t07_siswarutinbayar_Nilai_Bayar">
<span<?php echo $t07_siswarutinbayar->Nilai_Bayar->ViewAttributes() ?>>
<?php echo $t07_siswarutinbayar->Nilai_Bayar->ListViewValue() ?></span>
</span>
<?php if ($t07_siswarutinbayar->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_Nilai_Bayar" name="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Nilai_Bayar" id="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Nilai_Bayar" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Nilai_Bayar->FormValue) ?>">
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_Nilai_Bayar" name="o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Nilai_Bayar" id="o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Nilai_Bayar" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Nilai_Bayar->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_Nilai_Bayar" name="ft07_siswarutinbayargrid$x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Nilai_Bayar" id="ft07_siswarutinbayargrid$x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Nilai_Bayar" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Nilai_Bayar->FormValue) ?>">
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_Nilai_Bayar" name="ft07_siswarutinbayargrid$o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Nilai_Bayar" id="ft07_siswarutinbayargrid$o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Nilai_Bayar" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Nilai_Bayar->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t07_siswarutinbayar->Periode->Visible) { // Periode ?>
		<td data-name="Periode"<?php echo $t07_siswarutinbayar->Periode->CellAttributes() ?>>
<?php if ($t07_siswarutinbayar->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t07_siswarutinbayar_grid->RowCnt ?>_t07_siswarutinbayar_Periode" class="form-group t07_siswarutinbayar_Periode">
<input type="text" data-table="t07_siswarutinbayar" data-field="x_Periode" name="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Periode" id="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Periode" size="30" maxlength="6" placeholder="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Periode->getPlaceHolder()) ?>" value="<?php echo $t07_siswarutinbayar->Periode->EditValue ?>"<?php echo $t07_siswarutinbayar->Periode->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_Periode" name="o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Periode" id="o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Periode" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Periode->OldValue) ?>">
<?php } ?>
<?php if ($t07_siswarutinbayar->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t07_siswarutinbayar_grid->RowCnt ?>_t07_siswarutinbayar_Periode" class="form-group t07_siswarutinbayar_Periode">
<input type="text" data-table="t07_siswarutinbayar" data-field="x_Periode" name="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Periode" id="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Periode" size="30" maxlength="6" placeholder="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Periode->getPlaceHolder()) ?>" value="<?php echo $t07_siswarutinbayar->Periode->EditValue ?>"<?php echo $t07_siswarutinbayar->Periode->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t07_siswarutinbayar->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t07_siswarutinbayar_grid->RowCnt ?>_t07_siswarutinbayar_Periode" class="t07_siswarutinbayar_Periode">
<span<?php echo $t07_siswarutinbayar->Periode->ViewAttributes() ?>>
<?php echo $t07_siswarutinbayar->Periode->ListViewValue() ?></span>
</span>
<?php if ($t07_siswarutinbayar->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_Periode" name="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Periode" id="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Periode" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Periode->FormValue) ?>">
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_Periode" name="o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Periode" id="o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Periode" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Periode->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_Periode" name="ft07_siswarutinbayargrid$x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Periode" id="ft07_siswarutinbayargrid$x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Periode" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Periode->FormValue) ?>">
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_Periode" name="ft07_siswarutinbayargrid$o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Periode" id="ft07_siswarutinbayargrid$o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Periode" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Periode->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t07_siswarutinbayar_grid->ListOptions->Render("body", "right", $t07_siswarutinbayar_grid->RowCnt);
?>
	</tr>
<?php if ($t07_siswarutinbayar->RowType == EW_ROWTYPE_ADD || $t07_siswarutinbayar->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ft07_siswarutinbayargrid.UpdateOpts(<?php echo $t07_siswarutinbayar_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($t07_siswarutinbayar->CurrentAction <> "gridadd" || $t07_siswarutinbayar->CurrentMode == "copy")
		if (!$t07_siswarutinbayar_grid->Recordset->EOF) $t07_siswarutinbayar_grid->Recordset->MoveNext();
}
?>
<?php
	if ($t07_siswarutinbayar->CurrentMode == "add" || $t07_siswarutinbayar->CurrentMode == "copy" || $t07_siswarutinbayar->CurrentMode == "edit") {
		$t07_siswarutinbayar_grid->RowIndex = '$rowindex$';
		$t07_siswarutinbayar_grid->LoadDefaultValues();

		// Set row properties
		$t07_siswarutinbayar->ResetAttrs();
		$t07_siswarutinbayar->RowAttrs = array_merge($t07_siswarutinbayar->RowAttrs, array('data-rowindex'=>$t07_siswarutinbayar_grid->RowIndex, 'id'=>'r0_t07_siswarutinbayar', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($t07_siswarutinbayar->RowAttrs["class"], "ewTemplate");
		$t07_siswarutinbayar->RowType = EW_ROWTYPE_ADD;

		// Render row
		$t07_siswarutinbayar_grid->RenderRow();

		// Render list options
		$t07_siswarutinbayar_grid->RenderListOptions();
		$t07_siswarutinbayar_grid->StartRowCnt = 0;
?>
	<tr<?php echo $t07_siswarutinbayar->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t07_siswarutinbayar_grid->ListOptions->Render("body", "left", $t07_siswarutinbayar_grid->RowIndex);
?>
	<?php if ($t07_siswarutinbayar->siswarutin_id->Visible) { // siswarutin_id ?>
		<td data-name="siswarutin_id">
<?php if ($t07_siswarutinbayar->CurrentAction <> "F") { ?>
<?php if ($t07_siswarutinbayar->siswarutin_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_t07_siswarutinbayar_siswarutin_id" class="form-group t07_siswarutinbayar_siswarutin_id">
<span<?php echo $t07_siswarutinbayar->siswarutin_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t07_siswarutinbayar->siswarutin_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_siswarutin_id" name="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_siswarutin_id" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->siswarutin_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_t07_siswarutinbayar_siswarutin_id" class="form-group t07_siswarutinbayar_siswarutin_id">
<input type="text" data-table="t07_siswarutinbayar" data-field="x_siswarutin_id" name="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_siswarutin_id" id="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_siswarutin_id" size="30" placeholder="<?php echo ew_HtmlEncode($t07_siswarutinbayar->siswarutin_id->getPlaceHolder()) ?>" value="<?php echo $t07_siswarutinbayar->siswarutin_id->EditValue ?>"<?php echo $t07_siswarutinbayar->siswarutin_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_t07_siswarutinbayar_siswarutin_id" class="form-group t07_siswarutinbayar_siswarutin_id">
<span<?php echo $t07_siswarutinbayar->siswarutin_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t07_siswarutinbayar->siswarutin_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_siswarutin_id" name="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_siswarutin_id" id="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_siswarutin_id" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->siswarutin_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_siswarutin_id" name="o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_siswarutin_id" id="o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_siswarutin_id" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->siswarutin_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t07_siswarutinbayar->Bulan->Visible) { // Bulan ?>
		<td data-name="Bulan">
<?php if ($t07_siswarutinbayar->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t07_siswarutinbayar_Bulan" class="form-group t07_siswarutinbayar_Bulan">
<select data-table="t07_siswarutinbayar" data-field="x_Bulan" data-value-separator="<?php echo $t07_siswarutinbayar->Bulan->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Bulan" name="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Bulan"<?php echo $t07_siswarutinbayar->Bulan->EditAttributes() ?>>
<?php echo $t07_siswarutinbayar->Bulan->SelectOptionListHtml("x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Bulan") ?>
</select>
<input type="hidden" name="s_x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Bulan" id="s_x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Bulan" value="<?php echo $t07_siswarutinbayar->Bulan->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_t07_siswarutinbayar_Bulan" class="form-group t07_siswarutinbayar_Bulan">
<span<?php echo $t07_siswarutinbayar->Bulan->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t07_siswarutinbayar->Bulan->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_Bulan" name="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Bulan" id="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Bulan" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Bulan->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_Bulan" name="o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Bulan" id="o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Bulan" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Bulan->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t07_siswarutinbayar->Tahun->Visible) { // Tahun ?>
		<td data-name="Tahun">
<?php if ($t07_siswarutinbayar->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t07_siswarutinbayar_Tahun" class="form-group t07_siswarutinbayar_Tahun">
<select data-table="t07_siswarutinbayar" data-field="x_Tahun" data-value-separator="<?php echo $t07_siswarutinbayar->Tahun->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Tahun" name="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Tahun"<?php echo $t07_siswarutinbayar->Tahun->EditAttributes() ?>>
<?php echo $t07_siswarutinbayar->Tahun->SelectOptionListHtml("x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Tahun") ?>
</select>
<input type="hidden" name="s_x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Tahun" id="s_x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Tahun" value="<?php echo $t07_siswarutinbayar->Tahun->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_t07_siswarutinbayar_Tahun" class="form-group t07_siswarutinbayar_Tahun">
<span<?php echo $t07_siswarutinbayar->Tahun->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t07_siswarutinbayar->Tahun->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_Tahun" name="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Tahun" id="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Tahun" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Tahun->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_Tahun" name="o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Tahun" id="o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Tahun" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Tahun->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t07_siswarutinbayar->Nilai->Visible) { // Nilai ?>
		<td data-name="Nilai">
<?php if ($t07_siswarutinbayar->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t07_siswarutinbayar_Nilai" class="form-group t07_siswarutinbayar_Nilai">
<input type="text" data-table="t07_siswarutinbayar" data-field="x_Nilai" name="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Nilai" id="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Nilai" size="30" placeholder="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Nilai->getPlaceHolder()) ?>" value="<?php echo $t07_siswarutinbayar->Nilai->EditValue ?>"<?php echo $t07_siswarutinbayar->Nilai->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t07_siswarutinbayar_Nilai" class="form-group t07_siswarutinbayar_Nilai">
<span<?php echo $t07_siswarutinbayar->Nilai->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t07_siswarutinbayar->Nilai->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_Nilai" name="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Nilai" id="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Nilai" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Nilai->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_Nilai" name="o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Nilai" id="o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Nilai" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Nilai->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t07_siswarutinbayar->Tanggal_Bayar->Visible) { // Tanggal_Bayar ?>
		<td data-name="Tanggal_Bayar">
<?php if ($t07_siswarutinbayar->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t07_siswarutinbayar_Tanggal_Bayar" class="form-group t07_siswarutinbayar_Tanggal_Bayar">
<input type="text" data-table="t07_siswarutinbayar" data-field="x_Tanggal_Bayar" data-format="7" name="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Tanggal_Bayar" id="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Tanggal_Bayar" placeholder="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Tanggal_Bayar->getPlaceHolder()) ?>" value="<?php echo $t07_siswarutinbayar->Tanggal_Bayar->EditValue ?>"<?php echo $t07_siswarutinbayar->Tanggal_Bayar->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t07_siswarutinbayar_Tanggal_Bayar" class="form-group t07_siswarutinbayar_Tanggal_Bayar">
<span<?php echo $t07_siswarutinbayar->Tanggal_Bayar->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t07_siswarutinbayar->Tanggal_Bayar->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_Tanggal_Bayar" name="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Tanggal_Bayar" id="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Tanggal_Bayar" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Tanggal_Bayar->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_Tanggal_Bayar" name="o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Tanggal_Bayar" id="o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Tanggal_Bayar" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Tanggal_Bayar->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t07_siswarutinbayar->Nilai_Bayar->Visible) { // Nilai_Bayar ?>
		<td data-name="Nilai_Bayar">
<?php if ($t07_siswarutinbayar->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t07_siswarutinbayar_Nilai_Bayar" class="form-group t07_siswarutinbayar_Nilai_Bayar">
<input type="text" data-table="t07_siswarutinbayar" data-field="x_Nilai_Bayar" name="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Nilai_Bayar" id="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Nilai_Bayar" size="30" placeholder="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Nilai_Bayar->getPlaceHolder()) ?>" value="<?php echo $t07_siswarutinbayar->Nilai_Bayar->EditValue ?>"<?php echo $t07_siswarutinbayar->Nilai_Bayar->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t07_siswarutinbayar_Nilai_Bayar" class="form-group t07_siswarutinbayar_Nilai_Bayar">
<span<?php echo $t07_siswarutinbayar->Nilai_Bayar->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t07_siswarutinbayar->Nilai_Bayar->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_Nilai_Bayar" name="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Nilai_Bayar" id="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Nilai_Bayar" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Nilai_Bayar->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_Nilai_Bayar" name="o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Nilai_Bayar" id="o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Nilai_Bayar" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Nilai_Bayar->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t07_siswarutinbayar->Periode->Visible) { // Periode ?>
		<td data-name="Periode">
<?php if ($t07_siswarutinbayar->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t07_siswarutinbayar_Periode" class="form-group t07_siswarutinbayar_Periode">
<input type="text" data-table="t07_siswarutinbayar" data-field="x_Periode" name="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Periode" id="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Periode" size="30" maxlength="6" placeholder="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Periode->getPlaceHolder()) ?>" value="<?php echo $t07_siswarutinbayar->Periode->EditValue ?>"<?php echo $t07_siswarutinbayar->Periode->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t07_siswarutinbayar_Periode" class="form-group t07_siswarutinbayar_Periode">
<span<?php echo $t07_siswarutinbayar->Periode->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t07_siswarutinbayar->Periode->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_Periode" name="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Periode" id="x<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Periode" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Periode->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t07_siswarutinbayar" data-field="x_Periode" name="o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Periode" id="o<?php echo $t07_siswarutinbayar_grid->RowIndex ?>_Periode" value="<?php echo ew_HtmlEncode($t07_siswarutinbayar->Periode->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t07_siswarutinbayar_grid->ListOptions->Render("body", "right", $t07_siswarutinbayar_grid->RowCnt);
?>
<script type="text/javascript">
ft07_siswarutinbayargrid.UpdateOpts(<?php echo $t07_siswarutinbayar_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($t07_siswarutinbayar->CurrentMode == "add" || $t07_siswarutinbayar->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $t07_siswarutinbayar_grid->FormKeyCountName ?>" id="<?php echo $t07_siswarutinbayar_grid->FormKeyCountName ?>" value="<?php echo $t07_siswarutinbayar_grid->KeyCount ?>">
<?php echo $t07_siswarutinbayar_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t07_siswarutinbayar->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $t07_siswarutinbayar_grid->FormKeyCountName ?>" id="<?php echo $t07_siswarutinbayar_grid->FormKeyCountName ?>" value="<?php echo $t07_siswarutinbayar_grid->KeyCount ?>">
<?php echo $t07_siswarutinbayar_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t07_siswarutinbayar->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="ft07_siswarutinbayargrid">
</div>
<?php

// Close recordset
if ($t07_siswarutinbayar_grid->Recordset)
	$t07_siswarutinbayar_grid->Recordset->Close();
?>
<?php if ($t07_siswarutinbayar_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($t07_siswarutinbayar_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($t07_siswarutinbayar_grid->TotalRecs == 0 && $t07_siswarutinbayar->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t07_siswarutinbayar_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($t07_siswarutinbayar->Export == "") { ?>
<script type="text/javascript">
ft07_siswarutinbayargrid.Init();
</script>
<?php } ?>
<?php
$t07_siswarutinbayar_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$t07_siswarutinbayar_grid->Page_Terminate();
?>
