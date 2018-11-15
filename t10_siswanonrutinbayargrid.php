<?php

// Create page object
if (!isset($t10_siswanonrutinbayar_grid)) $t10_siswanonrutinbayar_grid = new ct10_siswanonrutinbayar_grid();

// Page init
$t10_siswanonrutinbayar_grid->Page_Init();

// Page main
$t10_siswanonrutinbayar_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t10_siswanonrutinbayar_grid->Page_Render();
?>
<?php if ($t10_siswanonrutinbayar->Export == "") { ?>
<script type="text/javascript">

// Form object
var ft10_siswanonrutinbayargrid = new ew_Form("ft10_siswanonrutinbayargrid", "grid");
ft10_siswanonrutinbayargrid.FormKeyCountName = '<?php echo $t10_siswanonrutinbayar_grid->FormKeyCountName ?>';

// Validate form
ft10_siswanonrutinbayargrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_siswanonrutin_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t10_siswanonrutinbayar->siswanonrutin_id->FldCaption(), $t10_siswanonrutinbayar->siswanonrutin_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_siswanonrutin_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t10_siswanonrutinbayar->siswanonrutin_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Bulan");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t10_siswanonrutinbayar->Bulan->FldCaption(), $t10_siswanonrutinbayar->Bulan->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Bulan");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t10_siswanonrutinbayar->Bulan->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Tahun");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t10_siswanonrutinbayar->Tahun->FldCaption(), $t10_siswanonrutinbayar->Tahun->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Tahun");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t10_siswanonrutinbayar->Tahun->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Nilai");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t10_siswanonrutinbayar->Nilai->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Tanggal_Bayar");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t10_siswanonrutinbayar->Tanggal_Bayar->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Nilai_Bayar");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t10_siswanonrutinbayar->Nilai_Bayar->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
ft10_siswanonrutinbayargrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "siswanonrutin_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Bulan", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Tahun", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Nilai", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Tanggal_Bayar", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Nilai_Bayar", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Periode_Tahun_Bulan", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Periode_Text", false)) return false;
	return true;
}

// Form_CustomValidate event
ft10_siswanonrutinbayargrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft10_siswanonrutinbayargrid.ValidateRequired = true;
<?php } else { ?>
ft10_siswanonrutinbayargrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php
if ($t10_siswanonrutinbayar->CurrentAction == "gridadd") {
	if ($t10_siswanonrutinbayar->CurrentMode == "copy") {
		$bSelectLimit = $t10_siswanonrutinbayar_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$t10_siswanonrutinbayar_grid->TotalRecs = $t10_siswanonrutinbayar->SelectRecordCount();
			$t10_siswanonrutinbayar_grid->Recordset = $t10_siswanonrutinbayar_grid->LoadRecordset($t10_siswanonrutinbayar_grid->StartRec-1, $t10_siswanonrutinbayar_grid->DisplayRecs);
		} else {
			if ($t10_siswanonrutinbayar_grid->Recordset = $t10_siswanonrutinbayar_grid->LoadRecordset())
				$t10_siswanonrutinbayar_grid->TotalRecs = $t10_siswanonrutinbayar_grid->Recordset->RecordCount();
		}
		$t10_siswanonrutinbayar_grid->StartRec = 1;
		$t10_siswanonrutinbayar_grid->DisplayRecs = $t10_siswanonrutinbayar_grid->TotalRecs;
	} else {
		$t10_siswanonrutinbayar->CurrentFilter = "0=1";
		$t10_siswanonrutinbayar_grid->StartRec = 1;
		$t10_siswanonrutinbayar_grid->DisplayRecs = $t10_siswanonrutinbayar->GridAddRowCount;
	}
	$t10_siswanonrutinbayar_grid->TotalRecs = $t10_siswanonrutinbayar_grid->DisplayRecs;
	$t10_siswanonrutinbayar_grid->StopRec = $t10_siswanonrutinbayar_grid->DisplayRecs;
} else {
	$bSelectLimit = $t10_siswanonrutinbayar_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($t10_siswanonrutinbayar_grid->TotalRecs <= 0)
			$t10_siswanonrutinbayar_grid->TotalRecs = $t10_siswanonrutinbayar->SelectRecordCount();
	} else {
		if (!$t10_siswanonrutinbayar_grid->Recordset && ($t10_siswanonrutinbayar_grid->Recordset = $t10_siswanonrutinbayar_grid->LoadRecordset()))
			$t10_siswanonrutinbayar_grid->TotalRecs = $t10_siswanonrutinbayar_grid->Recordset->RecordCount();
	}
	$t10_siswanonrutinbayar_grid->StartRec = 1;
	$t10_siswanonrutinbayar_grid->DisplayRecs = $t10_siswanonrutinbayar_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$t10_siswanonrutinbayar_grid->Recordset = $t10_siswanonrutinbayar_grid->LoadRecordset($t10_siswanonrutinbayar_grid->StartRec-1, $t10_siswanonrutinbayar_grid->DisplayRecs);

	// Set no record found message
	if ($t10_siswanonrutinbayar->CurrentAction == "" && $t10_siswanonrutinbayar_grid->TotalRecs == 0) {
		if ($t10_siswanonrutinbayar_grid->SearchWhere == "0=101")
			$t10_siswanonrutinbayar_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$t10_siswanonrutinbayar_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$t10_siswanonrutinbayar_grid->RenderOtherOptions();
?>
<?php $t10_siswanonrutinbayar_grid->ShowPageHeader(); ?>
<?php
$t10_siswanonrutinbayar_grid->ShowMessage();
?>
<?php if ($t10_siswanonrutinbayar_grid->TotalRecs > 0 || $t10_siswanonrutinbayar->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid t10_siswanonrutinbayar">
<div id="ft10_siswanonrutinbayargrid" class="ewForm form-inline">
<div id="gmp_t10_siswanonrutinbayar" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_t10_siswanonrutinbayargrid" class="table ewTable">
<?php echo $t10_siswanonrutinbayar->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$t10_siswanonrutinbayar_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$t10_siswanonrutinbayar_grid->RenderListOptions();

// Render list options (header, left)
$t10_siswanonrutinbayar_grid->ListOptions->Render("header", "left");
?>
<?php if ($t10_siswanonrutinbayar->id->Visible) { // id ?>
	<?php if ($t10_siswanonrutinbayar->SortUrl($t10_siswanonrutinbayar->id) == "") { ?>
		<th data-name="id"><div id="elh_t10_siswanonrutinbayar_id" class="t10_siswanonrutinbayar_id"><div class="ewTableHeaderCaption"><?php echo $t10_siswanonrutinbayar->id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id"><div><div id="elh_t10_siswanonrutinbayar_id" class="t10_siswanonrutinbayar_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t10_siswanonrutinbayar->id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t10_siswanonrutinbayar->id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t10_siswanonrutinbayar->id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t10_siswanonrutinbayar->siswanonrutin_id->Visible) { // siswanonrutin_id ?>
	<?php if ($t10_siswanonrutinbayar->SortUrl($t10_siswanonrutinbayar->siswanonrutin_id) == "") { ?>
		<th data-name="siswanonrutin_id"><div id="elh_t10_siswanonrutinbayar_siswanonrutin_id" class="t10_siswanonrutinbayar_siswanonrutin_id"><div class="ewTableHeaderCaption"><?php echo $t10_siswanonrutinbayar->siswanonrutin_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="siswanonrutin_id"><div><div id="elh_t10_siswanonrutinbayar_siswanonrutin_id" class="t10_siswanonrutinbayar_siswanonrutin_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t10_siswanonrutinbayar->siswanonrutin_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t10_siswanonrutinbayar->siswanonrutin_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t10_siswanonrutinbayar->siswanonrutin_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t10_siswanonrutinbayar->Bulan->Visible) { // Bulan ?>
	<?php if ($t10_siswanonrutinbayar->SortUrl($t10_siswanonrutinbayar->Bulan) == "") { ?>
		<th data-name="Bulan"><div id="elh_t10_siswanonrutinbayar_Bulan" class="t10_siswanonrutinbayar_Bulan"><div class="ewTableHeaderCaption"><?php echo $t10_siswanonrutinbayar->Bulan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Bulan"><div><div id="elh_t10_siswanonrutinbayar_Bulan" class="t10_siswanonrutinbayar_Bulan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t10_siswanonrutinbayar->Bulan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t10_siswanonrutinbayar->Bulan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t10_siswanonrutinbayar->Bulan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t10_siswanonrutinbayar->Tahun->Visible) { // Tahun ?>
	<?php if ($t10_siswanonrutinbayar->SortUrl($t10_siswanonrutinbayar->Tahun) == "") { ?>
		<th data-name="Tahun"><div id="elh_t10_siswanonrutinbayar_Tahun" class="t10_siswanonrutinbayar_Tahun"><div class="ewTableHeaderCaption"><?php echo $t10_siswanonrutinbayar->Tahun->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Tahun"><div><div id="elh_t10_siswanonrutinbayar_Tahun" class="t10_siswanonrutinbayar_Tahun">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t10_siswanonrutinbayar->Tahun->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t10_siswanonrutinbayar->Tahun->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t10_siswanonrutinbayar->Tahun->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t10_siswanonrutinbayar->Nilai->Visible) { // Nilai ?>
	<?php if ($t10_siswanonrutinbayar->SortUrl($t10_siswanonrutinbayar->Nilai) == "") { ?>
		<th data-name="Nilai"><div id="elh_t10_siswanonrutinbayar_Nilai" class="t10_siswanonrutinbayar_Nilai"><div class="ewTableHeaderCaption"><?php echo $t10_siswanonrutinbayar->Nilai->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nilai"><div><div id="elh_t10_siswanonrutinbayar_Nilai" class="t10_siswanonrutinbayar_Nilai">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t10_siswanonrutinbayar->Nilai->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t10_siswanonrutinbayar->Nilai->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t10_siswanonrutinbayar->Nilai->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t10_siswanonrutinbayar->Tanggal_Bayar->Visible) { // Tanggal_Bayar ?>
	<?php if ($t10_siswanonrutinbayar->SortUrl($t10_siswanonrutinbayar->Tanggal_Bayar) == "") { ?>
		<th data-name="Tanggal_Bayar"><div id="elh_t10_siswanonrutinbayar_Tanggal_Bayar" class="t10_siswanonrutinbayar_Tanggal_Bayar"><div class="ewTableHeaderCaption"><?php echo $t10_siswanonrutinbayar->Tanggal_Bayar->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Tanggal_Bayar"><div><div id="elh_t10_siswanonrutinbayar_Tanggal_Bayar" class="t10_siswanonrutinbayar_Tanggal_Bayar">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t10_siswanonrutinbayar->Tanggal_Bayar->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t10_siswanonrutinbayar->Tanggal_Bayar->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t10_siswanonrutinbayar->Tanggal_Bayar->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t10_siswanonrutinbayar->Nilai_Bayar->Visible) { // Nilai_Bayar ?>
	<?php if ($t10_siswanonrutinbayar->SortUrl($t10_siswanonrutinbayar->Nilai_Bayar) == "") { ?>
		<th data-name="Nilai_Bayar"><div id="elh_t10_siswanonrutinbayar_Nilai_Bayar" class="t10_siswanonrutinbayar_Nilai_Bayar"><div class="ewTableHeaderCaption"><?php echo $t10_siswanonrutinbayar->Nilai_Bayar->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nilai_Bayar"><div><div id="elh_t10_siswanonrutinbayar_Nilai_Bayar" class="t10_siswanonrutinbayar_Nilai_Bayar">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t10_siswanonrutinbayar->Nilai_Bayar->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t10_siswanonrutinbayar->Nilai_Bayar->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t10_siswanonrutinbayar->Nilai_Bayar->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t10_siswanonrutinbayar->Periode_Tahun_Bulan->Visible) { // Periode_Tahun_Bulan ?>
	<?php if ($t10_siswanonrutinbayar->SortUrl($t10_siswanonrutinbayar->Periode_Tahun_Bulan) == "") { ?>
		<th data-name="Periode_Tahun_Bulan"><div id="elh_t10_siswanonrutinbayar_Periode_Tahun_Bulan" class="t10_siswanonrutinbayar_Periode_Tahun_Bulan"><div class="ewTableHeaderCaption"><?php echo $t10_siswanonrutinbayar->Periode_Tahun_Bulan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Periode_Tahun_Bulan"><div><div id="elh_t10_siswanonrutinbayar_Periode_Tahun_Bulan" class="t10_siswanonrutinbayar_Periode_Tahun_Bulan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t10_siswanonrutinbayar->Periode_Tahun_Bulan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t10_siswanonrutinbayar->Periode_Tahun_Bulan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t10_siswanonrutinbayar->Periode_Tahun_Bulan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t10_siswanonrutinbayar->Periode_Text->Visible) { // Periode_Text ?>
	<?php if ($t10_siswanonrutinbayar->SortUrl($t10_siswanonrutinbayar->Periode_Text) == "") { ?>
		<th data-name="Periode_Text"><div id="elh_t10_siswanonrutinbayar_Periode_Text" class="t10_siswanonrutinbayar_Periode_Text"><div class="ewTableHeaderCaption"><?php echo $t10_siswanonrutinbayar->Periode_Text->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Periode_Text"><div><div id="elh_t10_siswanonrutinbayar_Periode_Text" class="t10_siswanonrutinbayar_Periode_Text">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t10_siswanonrutinbayar->Periode_Text->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t10_siswanonrutinbayar->Periode_Text->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t10_siswanonrutinbayar->Periode_Text->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$t10_siswanonrutinbayar_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$t10_siswanonrutinbayar_grid->StartRec = 1;
$t10_siswanonrutinbayar_grid->StopRec = $t10_siswanonrutinbayar_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($t10_siswanonrutinbayar_grid->FormKeyCountName) && ($t10_siswanonrutinbayar->CurrentAction == "gridadd" || $t10_siswanonrutinbayar->CurrentAction == "gridedit" || $t10_siswanonrutinbayar->CurrentAction == "F")) {
		$t10_siswanonrutinbayar_grid->KeyCount = $objForm->GetValue($t10_siswanonrutinbayar_grid->FormKeyCountName);
		$t10_siswanonrutinbayar_grid->StopRec = $t10_siswanonrutinbayar_grid->StartRec + $t10_siswanonrutinbayar_grid->KeyCount - 1;
	}
}
$t10_siswanonrutinbayar_grid->RecCnt = $t10_siswanonrutinbayar_grid->StartRec - 1;
if ($t10_siswanonrutinbayar_grid->Recordset && !$t10_siswanonrutinbayar_grid->Recordset->EOF) {
	$t10_siswanonrutinbayar_grid->Recordset->MoveFirst();
	$bSelectLimit = $t10_siswanonrutinbayar_grid->UseSelectLimit;
	if (!$bSelectLimit && $t10_siswanonrutinbayar_grid->StartRec > 1)
		$t10_siswanonrutinbayar_grid->Recordset->Move($t10_siswanonrutinbayar_grid->StartRec - 1);
} elseif (!$t10_siswanonrutinbayar->AllowAddDeleteRow && $t10_siswanonrutinbayar_grid->StopRec == 0) {
	$t10_siswanonrutinbayar_grid->StopRec = $t10_siswanonrutinbayar->GridAddRowCount;
}

// Initialize aggregate
$t10_siswanonrutinbayar->RowType = EW_ROWTYPE_AGGREGATEINIT;
$t10_siswanonrutinbayar->ResetAttrs();
$t10_siswanonrutinbayar_grid->RenderRow();
if ($t10_siswanonrutinbayar->CurrentAction == "gridadd")
	$t10_siswanonrutinbayar_grid->RowIndex = 0;
if ($t10_siswanonrutinbayar->CurrentAction == "gridedit")
	$t10_siswanonrutinbayar_grid->RowIndex = 0;
while ($t10_siswanonrutinbayar_grid->RecCnt < $t10_siswanonrutinbayar_grid->StopRec) {
	$t10_siswanonrutinbayar_grid->RecCnt++;
	if (intval($t10_siswanonrutinbayar_grid->RecCnt) >= intval($t10_siswanonrutinbayar_grid->StartRec)) {
		$t10_siswanonrutinbayar_grid->RowCnt++;
		if ($t10_siswanonrutinbayar->CurrentAction == "gridadd" || $t10_siswanonrutinbayar->CurrentAction == "gridedit" || $t10_siswanonrutinbayar->CurrentAction == "F") {
			$t10_siswanonrutinbayar_grid->RowIndex++;
			$objForm->Index = $t10_siswanonrutinbayar_grid->RowIndex;
			if ($objForm->HasValue($t10_siswanonrutinbayar_grid->FormActionName))
				$t10_siswanonrutinbayar_grid->RowAction = strval($objForm->GetValue($t10_siswanonrutinbayar_grid->FormActionName));
			elseif ($t10_siswanonrutinbayar->CurrentAction == "gridadd")
				$t10_siswanonrutinbayar_grid->RowAction = "insert";
			else
				$t10_siswanonrutinbayar_grid->RowAction = "";
		}

		// Set up key count
		$t10_siswanonrutinbayar_grid->KeyCount = $t10_siswanonrutinbayar_grid->RowIndex;

		// Init row class and style
		$t10_siswanonrutinbayar->ResetAttrs();
		$t10_siswanonrutinbayar->CssClass = "";
		if ($t10_siswanonrutinbayar->CurrentAction == "gridadd") {
			if ($t10_siswanonrutinbayar->CurrentMode == "copy") {
				$t10_siswanonrutinbayar_grid->LoadRowValues($t10_siswanonrutinbayar_grid->Recordset); // Load row values
				$t10_siswanonrutinbayar_grid->SetRecordKey($t10_siswanonrutinbayar_grid->RowOldKey, $t10_siswanonrutinbayar_grid->Recordset); // Set old record key
			} else {
				$t10_siswanonrutinbayar_grid->LoadDefaultValues(); // Load default values
				$t10_siswanonrutinbayar_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$t10_siswanonrutinbayar_grid->LoadRowValues($t10_siswanonrutinbayar_grid->Recordset); // Load row values
		}
		$t10_siswanonrutinbayar->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($t10_siswanonrutinbayar->CurrentAction == "gridadd") // Grid add
			$t10_siswanonrutinbayar->RowType = EW_ROWTYPE_ADD; // Render add
		if ($t10_siswanonrutinbayar->CurrentAction == "gridadd" && $t10_siswanonrutinbayar->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$t10_siswanonrutinbayar_grid->RestoreCurrentRowFormValues($t10_siswanonrutinbayar_grid->RowIndex); // Restore form values
		if ($t10_siswanonrutinbayar->CurrentAction == "gridedit") { // Grid edit
			if ($t10_siswanonrutinbayar->EventCancelled) {
				$t10_siswanonrutinbayar_grid->RestoreCurrentRowFormValues($t10_siswanonrutinbayar_grid->RowIndex); // Restore form values
			}
			if ($t10_siswanonrutinbayar_grid->RowAction == "insert")
				$t10_siswanonrutinbayar->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$t10_siswanonrutinbayar->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($t10_siswanonrutinbayar->CurrentAction == "gridedit" && ($t10_siswanonrutinbayar->RowType == EW_ROWTYPE_EDIT || $t10_siswanonrutinbayar->RowType == EW_ROWTYPE_ADD) && $t10_siswanonrutinbayar->EventCancelled) // Update failed
			$t10_siswanonrutinbayar_grid->RestoreCurrentRowFormValues($t10_siswanonrutinbayar_grid->RowIndex); // Restore form values
		if ($t10_siswanonrutinbayar->RowType == EW_ROWTYPE_EDIT) // Edit row
			$t10_siswanonrutinbayar_grid->EditRowCnt++;
		if ($t10_siswanonrutinbayar->CurrentAction == "F") // Confirm row
			$t10_siswanonrutinbayar_grid->RestoreCurrentRowFormValues($t10_siswanonrutinbayar_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$t10_siswanonrutinbayar->RowAttrs = array_merge($t10_siswanonrutinbayar->RowAttrs, array('data-rowindex'=>$t10_siswanonrutinbayar_grid->RowCnt, 'id'=>'r' . $t10_siswanonrutinbayar_grid->RowCnt . '_t10_siswanonrutinbayar', 'data-rowtype'=>$t10_siswanonrutinbayar->RowType));

		// Render row
		$t10_siswanonrutinbayar_grid->RenderRow();

		// Render list options
		$t10_siswanonrutinbayar_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($t10_siswanonrutinbayar_grid->RowAction <> "delete" && $t10_siswanonrutinbayar_grid->RowAction <> "insertdelete" && !($t10_siswanonrutinbayar_grid->RowAction == "insert" && $t10_siswanonrutinbayar->CurrentAction == "F" && $t10_siswanonrutinbayar_grid->EmptyRow())) {
?>
	<tr<?php echo $t10_siswanonrutinbayar->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t10_siswanonrutinbayar_grid->ListOptions->Render("body", "left", $t10_siswanonrutinbayar_grid->RowCnt);
?>
	<?php if ($t10_siswanonrutinbayar->id->Visible) { // id ?>
		<td data-name="id"<?php echo $t10_siswanonrutinbayar->id->CellAttributes() ?>>
<?php if ($t10_siswanonrutinbayar->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_id" name="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_id" id="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->id->OldValue) ?>">
<?php } ?>
<?php if ($t10_siswanonrutinbayar->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t10_siswanonrutinbayar_grid->RowCnt ?>_t10_siswanonrutinbayar_id" class="form-group t10_siswanonrutinbayar_id">
<span<?php echo $t10_siswanonrutinbayar->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t10_siswanonrutinbayar->id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_id" name="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_id" id="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->id->CurrentValue) ?>">
<?php } ?>
<?php if ($t10_siswanonrutinbayar->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t10_siswanonrutinbayar_grid->RowCnt ?>_t10_siswanonrutinbayar_id" class="t10_siswanonrutinbayar_id">
<span<?php echo $t10_siswanonrutinbayar->id->ViewAttributes() ?>>
<?php echo $t10_siswanonrutinbayar->id->ListViewValue() ?></span>
</span>
<?php if ($t10_siswanonrutinbayar->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_id" name="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_id" id="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->id->FormValue) ?>">
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_id" name="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_id" id="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_id" name="ft10_siswanonrutinbayargrid$x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_id" id="ft10_siswanonrutinbayargrid$x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->id->FormValue) ?>">
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_id" name="ft10_siswanonrutinbayargrid$o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_id" id="ft10_siswanonrutinbayargrid$o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->id->OldValue) ?>">
<?php } ?>
<?php } ?>
<a id="<?php echo $t10_siswanonrutinbayar_grid->PageObjName . "_row_" . $t10_siswanonrutinbayar_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($t10_siswanonrutinbayar->siswanonrutin_id->Visible) { // siswanonrutin_id ?>
		<td data-name="siswanonrutin_id"<?php echo $t10_siswanonrutinbayar->siswanonrutin_id->CellAttributes() ?>>
<?php if ($t10_siswanonrutinbayar->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($t10_siswanonrutinbayar->siswanonrutin_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $t10_siswanonrutinbayar_grid->RowCnt ?>_t10_siswanonrutinbayar_siswanonrutin_id" class="form-group t10_siswanonrutinbayar_siswanonrutin_id">
<span<?php echo $t10_siswanonrutinbayar->siswanonrutin_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t10_siswanonrutinbayar->siswanonrutin_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_siswanonrutin_id" name="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_siswanonrutin_id" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->siswanonrutin_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $t10_siswanonrutinbayar_grid->RowCnt ?>_t10_siswanonrutinbayar_siswanonrutin_id" class="form-group t10_siswanonrutinbayar_siswanonrutin_id">
<input type="text" data-table="t10_siswanonrutinbayar" data-field="x_siswanonrutin_id" name="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_siswanonrutin_id" id="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_siswanonrutin_id" size="30" placeholder="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->siswanonrutin_id->getPlaceHolder()) ?>" value="<?php echo $t10_siswanonrutinbayar->siswanonrutin_id->EditValue ?>"<?php echo $t10_siswanonrutinbayar->siswanonrutin_id->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_siswanonrutin_id" name="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_siswanonrutin_id" id="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_siswanonrutin_id" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->siswanonrutin_id->OldValue) ?>">
<?php } ?>
<?php if ($t10_siswanonrutinbayar->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($t10_siswanonrutinbayar->siswanonrutin_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $t10_siswanonrutinbayar_grid->RowCnt ?>_t10_siswanonrutinbayar_siswanonrutin_id" class="form-group t10_siswanonrutinbayar_siswanonrutin_id">
<span<?php echo $t10_siswanonrutinbayar->siswanonrutin_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t10_siswanonrutinbayar->siswanonrutin_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_siswanonrutin_id" name="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_siswanonrutin_id" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->siswanonrutin_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $t10_siswanonrutinbayar_grid->RowCnt ?>_t10_siswanonrutinbayar_siswanonrutin_id" class="form-group t10_siswanonrutinbayar_siswanonrutin_id">
<input type="text" data-table="t10_siswanonrutinbayar" data-field="x_siswanonrutin_id" name="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_siswanonrutin_id" id="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_siswanonrutin_id" size="30" placeholder="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->siswanonrutin_id->getPlaceHolder()) ?>" value="<?php echo $t10_siswanonrutinbayar->siswanonrutin_id->EditValue ?>"<?php echo $t10_siswanonrutinbayar->siswanonrutin_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php } ?>
<?php if ($t10_siswanonrutinbayar->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t10_siswanonrutinbayar_grid->RowCnt ?>_t10_siswanonrutinbayar_siswanonrutin_id" class="t10_siswanonrutinbayar_siswanonrutin_id">
<span<?php echo $t10_siswanonrutinbayar->siswanonrutin_id->ViewAttributes() ?>>
<?php echo $t10_siswanonrutinbayar->siswanonrutin_id->ListViewValue() ?></span>
</span>
<?php if ($t10_siswanonrutinbayar->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_siswanonrutin_id" name="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_siswanonrutin_id" id="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_siswanonrutin_id" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->siswanonrutin_id->FormValue) ?>">
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_siswanonrutin_id" name="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_siswanonrutin_id" id="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_siswanonrutin_id" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->siswanonrutin_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_siswanonrutin_id" name="ft10_siswanonrutinbayargrid$x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_siswanonrutin_id" id="ft10_siswanonrutinbayargrid$x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_siswanonrutin_id" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->siswanonrutin_id->FormValue) ?>">
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_siswanonrutin_id" name="ft10_siswanonrutinbayargrid$o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_siswanonrutin_id" id="ft10_siswanonrutinbayargrid$o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_siswanonrutin_id" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->siswanonrutin_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t10_siswanonrutinbayar->Bulan->Visible) { // Bulan ?>
		<td data-name="Bulan"<?php echo $t10_siswanonrutinbayar->Bulan->CellAttributes() ?>>
<?php if ($t10_siswanonrutinbayar->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t10_siswanonrutinbayar_grid->RowCnt ?>_t10_siswanonrutinbayar_Bulan" class="form-group t10_siswanonrutinbayar_Bulan">
<input type="text" data-table="t10_siswanonrutinbayar" data-field="x_Bulan" name="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Bulan" id="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Bulan" size="30" placeholder="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Bulan->getPlaceHolder()) ?>" value="<?php echo $t10_siswanonrutinbayar->Bulan->EditValue ?>"<?php echo $t10_siswanonrutinbayar->Bulan->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_Bulan" name="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Bulan" id="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Bulan" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Bulan->OldValue) ?>">
<?php } ?>
<?php if ($t10_siswanonrutinbayar->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t10_siswanonrutinbayar_grid->RowCnt ?>_t10_siswanonrutinbayar_Bulan" class="form-group t10_siswanonrutinbayar_Bulan">
<input type="text" data-table="t10_siswanonrutinbayar" data-field="x_Bulan" name="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Bulan" id="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Bulan" size="30" placeholder="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Bulan->getPlaceHolder()) ?>" value="<?php echo $t10_siswanonrutinbayar->Bulan->EditValue ?>"<?php echo $t10_siswanonrutinbayar->Bulan->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t10_siswanonrutinbayar->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t10_siswanonrutinbayar_grid->RowCnt ?>_t10_siswanonrutinbayar_Bulan" class="t10_siswanonrutinbayar_Bulan">
<span<?php echo $t10_siswanonrutinbayar->Bulan->ViewAttributes() ?>>
<?php echo $t10_siswanonrutinbayar->Bulan->ListViewValue() ?></span>
</span>
<?php if ($t10_siswanonrutinbayar->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_Bulan" name="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Bulan" id="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Bulan" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Bulan->FormValue) ?>">
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_Bulan" name="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Bulan" id="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Bulan" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Bulan->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_Bulan" name="ft10_siswanonrutinbayargrid$x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Bulan" id="ft10_siswanonrutinbayargrid$x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Bulan" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Bulan->FormValue) ?>">
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_Bulan" name="ft10_siswanonrutinbayargrid$o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Bulan" id="ft10_siswanonrutinbayargrid$o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Bulan" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Bulan->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t10_siswanonrutinbayar->Tahun->Visible) { // Tahun ?>
		<td data-name="Tahun"<?php echo $t10_siswanonrutinbayar->Tahun->CellAttributes() ?>>
<?php if ($t10_siswanonrutinbayar->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t10_siswanonrutinbayar_grid->RowCnt ?>_t10_siswanonrutinbayar_Tahun" class="form-group t10_siswanonrutinbayar_Tahun">
<input type="text" data-table="t10_siswanonrutinbayar" data-field="x_Tahun" name="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Tahun" id="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Tahun" size="30" placeholder="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Tahun->getPlaceHolder()) ?>" value="<?php echo $t10_siswanonrutinbayar->Tahun->EditValue ?>"<?php echo $t10_siswanonrutinbayar->Tahun->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_Tahun" name="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Tahun" id="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Tahun" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Tahun->OldValue) ?>">
<?php } ?>
<?php if ($t10_siswanonrutinbayar->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t10_siswanonrutinbayar_grid->RowCnt ?>_t10_siswanonrutinbayar_Tahun" class="form-group t10_siswanonrutinbayar_Tahun">
<input type="text" data-table="t10_siswanonrutinbayar" data-field="x_Tahun" name="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Tahun" id="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Tahun" size="30" placeholder="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Tahun->getPlaceHolder()) ?>" value="<?php echo $t10_siswanonrutinbayar->Tahun->EditValue ?>"<?php echo $t10_siswanonrutinbayar->Tahun->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t10_siswanonrutinbayar->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t10_siswanonrutinbayar_grid->RowCnt ?>_t10_siswanonrutinbayar_Tahun" class="t10_siswanonrutinbayar_Tahun">
<span<?php echo $t10_siswanonrutinbayar->Tahun->ViewAttributes() ?>>
<?php echo $t10_siswanonrutinbayar->Tahun->ListViewValue() ?></span>
</span>
<?php if ($t10_siswanonrutinbayar->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_Tahun" name="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Tahun" id="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Tahun" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Tahun->FormValue) ?>">
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_Tahun" name="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Tahun" id="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Tahun" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Tahun->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_Tahun" name="ft10_siswanonrutinbayargrid$x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Tahun" id="ft10_siswanonrutinbayargrid$x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Tahun" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Tahun->FormValue) ?>">
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_Tahun" name="ft10_siswanonrutinbayargrid$o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Tahun" id="ft10_siswanonrutinbayargrid$o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Tahun" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Tahun->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t10_siswanonrutinbayar->Nilai->Visible) { // Nilai ?>
		<td data-name="Nilai"<?php echo $t10_siswanonrutinbayar->Nilai->CellAttributes() ?>>
<?php if ($t10_siswanonrutinbayar->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t10_siswanonrutinbayar_grid->RowCnt ?>_t10_siswanonrutinbayar_Nilai" class="form-group t10_siswanonrutinbayar_Nilai">
<input type="text" data-table="t10_siswanonrutinbayar" data-field="x_Nilai" name="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Nilai" id="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Nilai" size="30" placeholder="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Nilai->getPlaceHolder()) ?>" value="<?php echo $t10_siswanonrutinbayar->Nilai->EditValue ?>"<?php echo $t10_siswanonrutinbayar->Nilai->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_Nilai" name="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Nilai" id="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Nilai" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Nilai->OldValue) ?>">
<?php } ?>
<?php if ($t10_siswanonrutinbayar->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t10_siswanonrutinbayar_grid->RowCnt ?>_t10_siswanonrutinbayar_Nilai" class="form-group t10_siswanonrutinbayar_Nilai">
<input type="text" data-table="t10_siswanonrutinbayar" data-field="x_Nilai" name="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Nilai" id="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Nilai" size="30" placeholder="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Nilai->getPlaceHolder()) ?>" value="<?php echo $t10_siswanonrutinbayar->Nilai->EditValue ?>"<?php echo $t10_siswanonrutinbayar->Nilai->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t10_siswanonrutinbayar->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t10_siswanonrutinbayar_grid->RowCnt ?>_t10_siswanonrutinbayar_Nilai" class="t10_siswanonrutinbayar_Nilai">
<span<?php echo $t10_siswanonrutinbayar->Nilai->ViewAttributes() ?>>
<?php echo $t10_siswanonrutinbayar->Nilai->ListViewValue() ?></span>
</span>
<?php if ($t10_siswanonrutinbayar->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_Nilai" name="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Nilai" id="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Nilai" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Nilai->FormValue) ?>">
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_Nilai" name="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Nilai" id="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Nilai" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Nilai->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_Nilai" name="ft10_siswanonrutinbayargrid$x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Nilai" id="ft10_siswanonrutinbayargrid$x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Nilai" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Nilai->FormValue) ?>">
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_Nilai" name="ft10_siswanonrutinbayargrid$o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Nilai" id="ft10_siswanonrutinbayargrid$o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Nilai" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Nilai->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t10_siswanonrutinbayar->Tanggal_Bayar->Visible) { // Tanggal_Bayar ?>
		<td data-name="Tanggal_Bayar"<?php echo $t10_siswanonrutinbayar->Tanggal_Bayar->CellAttributes() ?>>
<?php if ($t10_siswanonrutinbayar->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t10_siswanonrutinbayar_grid->RowCnt ?>_t10_siswanonrutinbayar_Tanggal_Bayar" class="form-group t10_siswanonrutinbayar_Tanggal_Bayar">
<input type="text" data-table="t10_siswanonrutinbayar" data-field="x_Tanggal_Bayar" name="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Tanggal_Bayar" id="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Tanggal_Bayar" placeholder="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Tanggal_Bayar->getPlaceHolder()) ?>" value="<?php echo $t10_siswanonrutinbayar->Tanggal_Bayar->EditValue ?>"<?php echo $t10_siswanonrutinbayar->Tanggal_Bayar->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_Tanggal_Bayar" name="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Tanggal_Bayar" id="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Tanggal_Bayar" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Tanggal_Bayar->OldValue) ?>">
<?php } ?>
<?php if ($t10_siswanonrutinbayar->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t10_siswanonrutinbayar_grid->RowCnt ?>_t10_siswanonrutinbayar_Tanggal_Bayar" class="form-group t10_siswanonrutinbayar_Tanggal_Bayar">
<input type="text" data-table="t10_siswanonrutinbayar" data-field="x_Tanggal_Bayar" name="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Tanggal_Bayar" id="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Tanggal_Bayar" placeholder="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Tanggal_Bayar->getPlaceHolder()) ?>" value="<?php echo $t10_siswanonrutinbayar->Tanggal_Bayar->EditValue ?>"<?php echo $t10_siswanonrutinbayar->Tanggal_Bayar->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t10_siswanonrutinbayar->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t10_siswanonrutinbayar_grid->RowCnt ?>_t10_siswanonrutinbayar_Tanggal_Bayar" class="t10_siswanonrutinbayar_Tanggal_Bayar">
<span<?php echo $t10_siswanonrutinbayar->Tanggal_Bayar->ViewAttributes() ?>>
<?php echo $t10_siswanonrutinbayar->Tanggal_Bayar->ListViewValue() ?></span>
</span>
<?php if ($t10_siswanonrutinbayar->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_Tanggal_Bayar" name="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Tanggal_Bayar" id="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Tanggal_Bayar" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Tanggal_Bayar->FormValue) ?>">
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_Tanggal_Bayar" name="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Tanggal_Bayar" id="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Tanggal_Bayar" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Tanggal_Bayar->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_Tanggal_Bayar" name="ft10_siswanonrutinbayargrid$x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Tanggal_Bayar" id="ft10_siswanonrutinbayargrid$x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Tanggal_Bayar" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Tanggal_Bayar->FormValue) ?>">
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_Tanggal_Bayar" name="ft10_siswanonrutinbayargrid$o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Tanggal_Bayar" id="ft10_siswanonrutinbayargrid$o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Tanggal_Bayar" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Tanggal_Bayar->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t10_siswanonrutinbayar->Nilai_Bayar->Visible) { // Nilai_Bayar ?>
		<td data-name="Nilai_Bayar"<?php echo $t10_siswanonrutinbayar->Nilai_Bayar->CellAttributes() ?>>
<?php if ($t10_siswanonrutinbayar->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t10_siswanonrutinbayar_grid->RowCnt ?>_t10_siswanonrutinbayar_Nilai_Bayar" class="form-group t10_siswanonrutinbayar_Nilai_Bayar">
<input type="text" data-table="t10_siswanonrutinbayar" data-field="x_Nilai_Bayar" name="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Nilai_Bayar" id="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Nilai_Bayar" size="30" placeholder="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Nilai_Bayar->getPlaceHolder()) ?>" value="<?php echo $t10_siswanonrutinbayar->Nilai_Bayar->EditValue ?>"<?php echo $t10_siswanonrutinbayar->Nilai_Bayar->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_Nilai_Bayar" name="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Nilai_Bayar" id="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Nilai_Bayar" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Nilai_Bayar->OldValue) ?>">
<?php } ?>
<?php if ($t10_siswanonrutinbayar->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t10_siswanonrutinbayar_grid->RowCnt ?>_t10_siswanonrutinbayar_Nilai_Bayar" class="form-group t10_siswanonrutinbayar_Nilai_Bayar">
<input type="text" data-table="t10_siswanonrutinbayar" data-field="x_Nilai_Bayar" name="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Nilai_Bayar" id="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Nilai_Bayar" size="30" placeholder="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Nilai_Bayar->getPlaceHolder()) ?>" value="<?php echo $t10_siswanonrutinbayar->Nilai_Bayar->EditValue ?>"<?php echo $t10_siswanonrutinbayar->Nilai_Bayar->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t10_siswanonrutinbayar->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t10_siswanonrutinbayar_grid->RowCnt ?>_t10_siswanonrutinbayar_Nilai_Bayar" class="t10_siswanonrutinbayar_Nilai_Bayar">
<span<?php echo $t10_siswanonrutinbayar->Nilai_Bayar->ViewAttributes() ?>>
<?php echo $t10_siswanonrutinbayar->Nilai_Bayar->ListViewValue() ?></span>
</span>
<?php if ($t10_siswanonrutinbayar->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_Nilai_Bayar" name="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Nilai_Bayar" id="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Nilai_Bayar" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Nilai_Bayar->FormValue) ?>">
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_Nilai_Bayar" name="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Nilai_Bayar" id="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Nilai_Bayar" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Nilai_Bayar->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_Nilai_Bayar" name="ft10_siswanonrutinbayargrid$x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Nilai_Bayar" id="ft10_siswanonrutinbayargrid$x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Nilai_Bayar" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Nilai_Bayar->FormValue) ?>">
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_Nilai_Bayar" name="ft10_siswanonrutinbayargrid$o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Nilai_Bayar" id="ft10_siswanonrutinbayargrid$o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Nilai_Bayar" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Nilai_Bayar->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t10_siswanonrutinbayar->Periode_Tahun_Bulan->Visible) { // Periode_Tahun_Bulan ?>
		<td data-name="Periode_Tahun_Bulan"<?php echo $t10_siswanonrutinbayar->Periode_Tahun_Bulan->CellAttributes() ?>>
<?php if ($t10_siswanonrutinbayar->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t10_siswanonrutinbayar_grid->RowCnt ?>_t10_siswanonrutinbayar_Periode_Tahun_Bulan" class="form-group t10_siswanonrutinbayar_Periode_Tahun_Bulan">
<input type="text" data-table="t10_siswanonrutinbayar" data-field="x_Periode_Tahun_Bulan" name="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Periode_Tahun_Bulan" id="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Periode_Tahun_Bulan" size="30" maxlength="6" placeholder="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Periode_Tahun_Bulan->getPlaceHolder()) ?>" value="<?php echo $t10_siswanonrutinbayar->Periode_Tahun_Bulan->EditValue ?>"<?php echo $t10_siswanonrutinbayar->Periode_Tahun_Bulan->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_Periode_Tahun_Bulan" name="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Periode_Tahun_Bulan" id="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Periode_Tahun_Bulan" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Periode_Tahun_Bulan->OldValue) ?>">
<?php } ?>
<?php if ($t10_siswanonrutinbayar->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t10_siswanonrutinbayar_grid->RowCnt ?>_t10_siswanonrutinbayar_Periode_Tahun_Bulan" class="form-group t10_siswanonrutinbayar_Periode_Tahun_Bulan">
<input type="text" data-table="t10_siswanonrutinbayar" data-field="x_Periode_Tahun_Bulan" name="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Periode_Tahun_Bulan" id="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Periode_Tahun_Bulan" size="30" maxlength="6" placeholder="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Periode_Tahun_Bulan->getPlaceHolder()) ?>" value="<?php echo $t10_siswanonrutinbayar->Periode_Tahun_Bulan->EditValue ?>"<?php echo $t10_siswanonrutinbayar->Periode_Tahun_Bulan->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t10_siswanonrutinbayar->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t10_siswanonrutinbayar_grid->RowCnt ?>_t10_siswanonrutinbayar_Periode_Tahun_Bulan" class="t10_siswanonrutinbayar_Periode_Tahun_Bulan">
<span<?php echo $t10_siswanonrutinbayar->Periode_Tahun_Bulan->ViewAttributes() ?>>
<?php echo $t10_siswanonrutinbayar->Periode_Tahun_Bulan->ListViewValue() ?></span>
</span>
<?php if ($t10_siswanonrutinbayar->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_Periode_Tahun_Bulan" name="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Periode_Tahun_Bulan" id="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Periode_Tahun_Bulan" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Periode_Tahun_Bulan->FormValue) ?>">
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_Periode_Tahun_Bulan" name="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Periode_Tahun_Bulan" id="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Periode_Tahun_Bulan" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Periode_Tahun_Bulan->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_Periode_Tahun_Bulan" name="ft10_siswanonrutinbayargrid$x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Periode_Tahun_Bulan" id="ft10_siswanonrutinbayargrid$x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Periode_Tahun_Bulan" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Periode_Tahun_Bulan->FormValue) ?>">
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_Periode_Tahun_Bulan" name="ft10_siswanonrutinbayargrid$o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Periode_Tahun_Bulan" id="ft10_siswanonrutinbayargrid$o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Periode_Tahun_Bulan" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Periode_Tahun_Bulan->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t10_siswanonrutinbayar->Periode_Text->Visible) { // Periode_Text ?>
		<td data-name="Periode_Text"<?php echo $t10_siswanonrutinbayar->Periode_Text->CellAttributes() ?>>
<?php if ($t10_siswanonrutinbayar->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t10_siswanonrutinbayar_grid->RowCnt ?>_t10_siswanonrutinbayar_Periode_Text" class="form-group t10_siswanonrutinbayar_Periode_Text">
<input type="text" data-table="t10_siswanonrutinbayar" data-field="x_Periode_Text" name="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Periode_Text" id="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Periode_Text" size="30" maxlength="14" placeholder="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Periode_Text->getPlaceHolder()) ?>" value="<?php echo $t10_siswanonrutinbayar->Periode_Text->EditValue ?>"<?php echo $t10_siswanonrutinbayar->Periode_Text->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_Periode_Text" name="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Periode_Text" id="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Periode_Text" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Periode_Text->OldValue) ?>">
<?php } ?>
<?php if ($t10_siswanonrutinbayar->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t10_siswanonrutinbayar_grid->RowCnt ?>_t10_siswanonrutinbayar_Periode_Text" class="form-group t10_siswanonrutinbayar_Periode_Text">
<input type="text" data-table="t10_siswanonrutinbayar" data-field="x_Periode_Text" name="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Periode_Text" id="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Periode_Text" size="30" maxlength="14" placeholder="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Periode_Text->getPlaceHolder()) ?>" value="<?php echo $t10_siswanonrutinbayar->Periode_Text->EditValue ?>"<?php echo $t10_siswanonrutinbayar->Periode_Text->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t10_siswanonrutinbayar->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t10_siswanonrutinbayar_grid->RowCnt ?>_t10_siswanonrutinbayar_Periode_Text" class="t10_siswanonrutinbayar_Periode_Text">
<span<?php echo $t10_siswanonrutinbayar->Periode_Text->ViewAttributes() ?>>
<?php echo $t10_siswanonrutinbayar->Periode_Text->ListViewValue() ?></span>
</span>
<?php if ($t10_siswanonrutinbayar->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_Periode_Text" name="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Periode_Text" id="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Periode_Text" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Periode_Text->FormValue) ?>">
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_Periode_Text" name="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Periode_Text" id="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Periode_Text" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Periode_Text->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_Periode_Text" name="ft10_siswanonrutinbayargrid$x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Periode_Text" id="ft10_siswanonrutinbayargrid$x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Periode_Text" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Periode_Text->FormValue) ?>">
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_Periode_Text" name="ft10_siswanonrutinbayargrid$o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Periode_Text" id="ft10_siswanonrutinbayargrid$o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Periode_Text" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Periode_Text->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t10_siswanonrutinbayar_grid->ListOptions->Render("body", "right", $t10_siswanonrutinbayar_grid->RowCnt);
?>
	</tr>
<?php if ($t10_siswanonrutinbayar->RowType == EW_ROWTYPE_ADD || $t10_siswanonrutinbayar->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ft10_siswanonrutinbayargrid.UpdateOpts(<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($t10_siswanonrutinbayar->CurrentAction <> "gridadd" || $t10_siswanonrutinbayar->CurrentMode == "copy")
		if (!$t10_siswanonrutinbayar_grid->Recordset->EOF) $t10_siswanonrutinbayar_grid->Recordset->MoveNext();
}
?>
<?php
	if ($t10_siswanonrutinbayar->CurrentMode == "add" || $t10_siswanonrutinbayar->CurrentMode == "copy" || $t10_siswanonrutinbayar->CurrentMode == "edit") {
		$t10_siswanonrutinbayar_grid->RowIndex = '$rowindex$';
		$t10_siswanonrutinbayar_grid->LoadDefaultValues();

		// Set row properties
		$t10_siswanonrutinbayar->ResetAttrs();
		$t10_siswanonrutinbayar->RowAttrs = array_merge($t10_siswanonrutinbayar->RowAttrs, array('data-rowindex'=>$t10_siswanonrutinbayar_grid->RowIndex, 'id'=>'r0_t10_siswanonrutinbayar', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($t10_siswanonrutinbayar->RowAttrs["class"], "ewTemplate");
		$t10_siswanonrutinbayar->RowType = EW_ROWTYPE_ADD;

		// Render row
		$t10_siswanonrutinbayar_grid->RenderRow();

		// Render list options
		$t10_siswanonrutinbayar_grid->RenderListOptions();
		$t10_siswanonrutinbayar_grid->StartRowCnt = 0;
?>
	<tr<?php echo $t10_siswanonrutinbayar->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t10_siswanonrutinbayar_grid->ListOptions->Render("body", "left", $t10_siswanonrutinbayar_grid->RowIndex);
?>
	<?php if ($t10_siswanonrutinbayar->id->Visible) { // id ?>
		<td data-name="id">
<?php if ($t10_siswanonrutinbayar->CurrentAction <> "F") { ?>
<?php } else { ?>
<span id="el$rowindex$_t10_siswanonrutinbayar_id" class="form-group t10_siswanonrutinbayar_id">
<span<?php echo $t10_siswanonrutinbayar->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t10_siswanonrutinbayar->id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_id" name="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_id" id="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_id" name="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_id" id="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t10_siswanonrutinbayar->siswanonrutin_id->Visible) { // siswanonrutin_id ?>
		<td data-name="siswanonrutin_id">
<?php if ($t10_siswanonrutinbayar->CurrentAction <> "F") { ?>
<?php if ($t10_siswanonrutinbayar->siswanonrutin_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_t10_siswanonrutinbayar_siswanonrutin_id" class="form-group t10_siswanonrutinbayar_siswanonrutin_id">
<span<?php echo $t10_siswanonrutinbayar->siswanonrutin_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t10_siswanonrutinbayar->siswanonrutin_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_siswanonrutin_id" name="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_siswanonrutin_id" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->siswanonrutin_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_t10_siswanonrutinbayar_siswanonrutin_id" class="form-group t10_siswanonrutinbayar_siswanonrutin_id">
<input type="text" data-table="t10_siswanonrutinbayar" data-field="x_siswanonrutin_id" name="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_siswanonrutin_id" id="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_siswanonrutin_id" size="30" placeholder="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->siswanonrutin_id->getPlaceHolder()) ?>" value="<?php echo $t10_siswanonrutinbayar->siswanonrutin_id->EditValue ?>"<?php echo $t10_siswanonrutinbayar->siswanonrutin_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_t10_siswanonrutinbayar_siswanonrutin_id" class="form-group t10_siswanonrutinbayar_siswanonrutin_id">
<span<?php echo $t10_siswanonrutinbayar->siswanonrutin_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t10_siswanonrutinbayar->siswanonrutin_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_siswanonrutin_id" name="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_siswanonrutin_id" id="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_siswanonrutin_id" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->siswanonrutin_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_siswanonrutin_id" name="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_siswanonrutin_id" id="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_siswanonrutin_id" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->siswanonrutin_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t10_siswanonrutinbayar->Bulan->Visible) { // Bulan ?>
		<td data-name="Bulan">
<?php if ($t10_siswanonrutinbayar->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t10_siswanonrutinbayar_Bulan" class="form-group t10_siswanonrutinbayar_Bulan">
<input type="text" data-table="t10_siswanonrutinbayar" data-field="x_Bulan" name="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Bulan" id="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Bulan" size="30" placeholder="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Bulan->getPlaceHolder()) ?>" value="<?php echo $t10_siswanonrutinbayar->Bulan->EditValue ?>"<?php echo $t10_siswanonrutinbayar->Bulan->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t10_siswanonrutinbayar_Bulan" class="form-group t10_siswanonrutinbayar_Bulan">
<span<?php echo $t10_siswanonrutinbayar->Bulan->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t10_siswanonrutinbayar->Bulan->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_Bulan" name="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Bulan" id="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Bulan" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Bulan->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_Bulan" name="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Bulan" id="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Bulan" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Bulan->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t10_siswanonrutinbayar->Tahun->Visible) { // Tahun ?>
		<td data-name="Tahun">
<?php if ($t10_siswanonrutinbayar->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t10_siswanonrutinbayar_Tahun" class="form-group t10_siswanonrutinbayar_Tahun">
<input type="text" data-table="t10_siswanonrutinbayar" data-field="x_Tahun" name="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Tahun" id="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Tahun" size="30" placeholder="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Tahun->getPlaceHolder()) ?>" value="<?php echo $t10_siswanonrutinbayar->Tahun->EditValue ?>"<?php echo $t10_siswanonrutinbayar->Tahun->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t10_siswanonrutinbayar_Tahun" class="form-group t10_siswanonrutinbayar_Tahun">
<span<?php echo $t10_siswanonrutinbayar->Tahun->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t10_siswanonrutinbayar->Tahun->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_Tahun" name="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Tahun" id="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Tahun" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Tahun->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_Tahun" name="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Tahun" id="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Tahun" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Tahun->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t10_siswanonrutinbayar->Nilai->Visible) { // Nilai ?>
		<td data-name="Nilai">
<?php if ($t10_siswanonrutinbayar->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t10_siswanonrutinbayar_Nilai" class="form-group t10_siswanonrutinbayar_Nilai">
<input type="text" data-table="t10_siswanonrutinbayar" data-field="x_Nilai" name="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Nilai" id="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Nilai" size="30" placeholder="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Nilai->getPlaceHolder()) ?>" value="<?php echo $t10_siswanonrutinbayar->Nilai->EditValue ?>"<?php echo $t10_siswanonrutinbayar->Nilai->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t10_siswanonrutinbayar_Nilai" class="form-group t10_siswanonrutinbayar_Nilai">
<span<?php echo $t10_siswanonrutinbayar->Nilai->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t10_siswanonrutinbayar->Nilai->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_Nilai" name="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Nilai" id="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Nilai" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Nilai->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_Nilai" name="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Nilai" id="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Nilai" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Nilai->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t10_siswanonrutinbayar->Tanggal_Bayar->Visible) { // Tanggal_Bayar ?>
		<td data-name="Tanggal_Bayar">
<?php if ($t10_siswanonrutinbayar->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t10_siswanonrutinbayar_Tanggal_Bayar" class="form-group t10_siswanonrutinbayar_Tanggal_Bayar">
<input type="text" data-table="t10_siswanonrutinbayar" data-field="x_Tanggal_Bayar" name="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Tanggal_Bayar" id="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Tanggal_Bayar" placeholder="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Tanggal_Bayar->getPlaceHolder()) ?>" value="<?php echo $t10_siswanonrutinbayar->Tanggal_Bayar->EditValue ?>"<?php echo $t10_siswanonrutinbayar->Tanggal_Bayar->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t10_siswanonrutinbayar_Tanggal_Bayar" class="form-group t10_siswanonrutinbayar_Tanggal_Bayar">
<span<?php echo $t10_siswanonrutinbayar->Tanggal_Bayar->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t10_siswanonrutinbayar->Tanggal_Bayar->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_Tanggal_Bayar" name="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Tanggal_Bayar" id="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Tanggal_Bayar" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Tanggal_Bayar->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_Tanggal_Bayar" name="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Tanggal_Bayar" id="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Tanggal_Bayar" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Tanggal_Bayar->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t10_siswanonrutinbayar->Nilai_Bayar->Visible) { // Nilai_Bayar ?>
		<td data-name="Nilai_Bayar">
<?php if ($t10_siswanonrutinbayar->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t10_siswanonrutinbayar_Nilai_Bayar" class="form-group t10_siswanonrutinbayar_Nilai_Bayar">
<input type="text" data-table="t10_siswanonrutinbayar" data-field="x_Nilai_Bayar" name="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Nilai_Bayar" id="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Nilai_Bayar" size="30" placeholder="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Nilai_Bayar->getPlaceHolder()) ?>" value="<?php echo $t10_siswanonrutinbayar->Nilai_Bayar->EditValue ?>"<?php echo $t10_siswanonrutinbayar->Nilai_Bayar->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t10_siswanonrutinbayar_Nilai_Bayar" class="form-group t10_siswanonrutinbayar_Nilai_Bayar">
<span<?php echo $t10_siswanonrutinbayar->Nilai_Bayar->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t10_siswanonrutinbayar->Nilai_Bayar->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_Nilai_Bayar" name="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Nilai_Bayar" id="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Nilai_Bayar" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Nilai_Bayar->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_Nilai_Bayar" name="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Nilai_Bayar" id="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Nilai_Bayar" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Nilai_Bayar->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t10_siswanonrutinbayar->Periode_Tahun_Bulan->Visible) { // Periode_Tahun_Bulan ?>
		<td data-name="Periode_Tahun_Bulan">
<?php if ($t10_siswanonrutinbayar->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t10_siswanonrutinbayar_Periode_Tahun_Bulan" class="form-group t10_siswanonrutinbayar_Periode_Tahun_Bulan">
<input type="text" data-table="t10_siswanonrutinbayar" data-field="x_Periode_Tahun_Bulan" name="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Periode_Tahun_Bulan" id="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Periode_Tahun_Bulan" size="30" maxlength="6" placeholder="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Periode_Tahun_Bulan->getPlaceHolder()) ?>" value="<?php echo $t10_siswanonrutinbayar->Periode_Tahun_Bulan->EditValue ?>"<?php echo $t10_siswanonrutinbayar->Periode_Tahun_Bulan->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t10_siswanonrutinbayar_Periode_Tahun_Bulan" class="form-group t10_siswanonrutinbayar_Periode_Tahun_Bulan">
<span<?php echo $t10_siswanonrutinbayar->Periode_Tahun_Bulan->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t10_siswanonrutinbayar->Periode_Tahun_Bulan->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_Periode_Tahun_Bulan" name="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Periode_Tahun_Bulan" id="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Periode_Tahun_Bulan" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Periode_Tahun_Bulan->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_Periode_Tahun_Bulan" name="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Periode_Tahun_Bulan" id="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Periode_Tahun_Bulan" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Periode_Tahun_Bulan->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t10_siswanonrutinbayar->Periode_Text->Visible) { // Periode_Text ?>
		<td data-name="Periode_Text">
<?php if ($t10_siswanonrutinbayar->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t10_siswanonrutinbayar_Periode_Text" class="form-group t10_siswanonrutinbayar_Periode_Text">
<input type="text" data-table="t10_siswanonrutinbayar" data-field="x_Periode_Text" name="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Periode_Text" id="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Periode_Text" size="30" maxlength="14" placeholder="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Periode_Text->getPlaceHolder()) ?>" value="<?php echo $t10_siswanonrutinbayar->Periode_Text->EditValue ?>"<?php echo $t10_siswanonrutinbayar->Periode_Text->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t10_siswanonrutinbayar_Periode_Text" class="form-group t10_siswanonrutinbayar_Periode_Text">
<span<?php echo $t10_siswanonrutinbayar->Periode_Text->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t10_siswanonrutinbayar->Periode_Text->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_Periode_Text" name="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Periode_Text" id="x<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Periode_Text" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Periode_Text->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t10_siswanonrutinbayar" data-field="x_Periode_Text" name="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Periode_Text" id="o<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>_Periode_Text" value="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Periode_Text->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t10_siswanonrutinbayar_grid->ListOptions->Render("body", "right", $t10_siswanonrutinbayar_grid->RowCnt);
?>
<script type="text/javascript">
ft10_siswanonrutinbayargrid.UpdateOpts(<?php echo $t10_siswanonrutinbayar_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($t10_siswanonrutinbayar->CurrentMode == "add" || $t10_siswanonrutinbayar->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $t10_siswanonrutinbayar_grid->FormKeyCountName ?>" id="<?php echo $t10_siswanonrutinbayar_grid->FormKeyCountName ?>" value="<?php echo $t10_siswanonrutinbayar_grid->KeyCount ?>">
<?php echo $t10_siswanonrutinbayar_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t10_siswanonrutinbayar->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $t10_siswanonrutinbayar_grid->FormKeyCountName ?>" id="<?php echo $t10_siswanonrutinbayar_grid->FormKeyCountName ?>" value="<?php echo $t10_siswanonrutinbayar_grid->KeyCount ?>">
<?php echo $t10_siswanonrutinbayar_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t10_siswanonrutinbayar->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="ft10_siswanonrutinbayargrid">
</div>
<?php

// Close recordset
if ($t10_siswanonrutinbayar_grid->Recordset)
	$t10_siswanonrutinbayar_grid->Recordset->Close();
?>
<?php if ($t10_siswanonrutinbayar_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($t10_siswanonrutinbayar_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($t10_siswanonrutinbayar_grid->TotalRecs == 0 && $t10_siswanonrutinbayar->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t10_siswanonrutinbayar_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($t10_siswanonrutinbayar->Export == "") { ?>
<script type="text/javascript">
ft10_siswanonrutinbayargrid.Init();
</script>
<?php } ?>
<?php
$t10_siswanonrutinbayar_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$t10_siswanonrutinbayar_grid->Page_Terminate();
?>
