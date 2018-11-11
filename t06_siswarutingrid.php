<?php

// Create page object
if (!isset($t06_siswarutin_grid)) $t06_siswarutin_grid = new ct06_siswarutin_grid();

// Page init
$t06_siswarutin_grid->Page_Init();

// Page main
$t06_siswarutin_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t06_siswarutin_grid->Page_Render();
?>
<?php if ($t06_siswarutin->Export == "") { ?>
<script type="text/javascript">

// Form object
var ft06_siswarutingrid = new ew_Form("ft06_siswarutingrid", "grid");
ft06_siswarutingrid.FormKeyCountName = '<?php echo $t06_siswarutin_grid->FormKeyCountName ?>';

// Validate form
ft06_siswarutingrid.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t06_siswarutin->siswa_id->FldCaption(), $t06_siswarutin->siswa_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_siswa_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t06_siswarutin->siswa_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_rutin_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t06_siswarutin->rutin_id->FldCaption(), $t06_siswarutin->rutin_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Nilai");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t06_siswarutin->Nilai->FldCaption(), $t06_siswarutin->Nilai->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Nilai");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t06_siswarutin->Nilai->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
ft06_siswarutingrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "siswa_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "rutin_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Nilai", false)) return false;
	return true;
}

// Form_CustomValidate event
ft06_siswarutingrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft06_siswarutingrid.ValidateRequired = true;
<?php } else { ?>
ft06_siswarutingrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft06_siswarutingrid.Lists["x_rutin_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_Jenis","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t05_rutin"};

// Form object for search
</script>
<?php } ?>
<?php
if ($t06_siswarutin->CurrentAction == "gridadd") {
	if ($t06_siswarutin->CurrentMode == "copy") {
		$bSelectLimit = $t06_siswarutin_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$t06_siswarutin_grid->TotalRecs = $t06_siswarutin->SelectRecordCount();
			$t06_siswarutin_grid->Recordset = $t06_siswarutin_grid->LoadRecordset($t06_siswarutin_grid->StartRec-1, $t06_siswarutin_grid->DisplayRecs);
		} else {
			if ($t06_siswarutin_grid->Recordset = $t06_siswarutin_grid->LoadRecordset())
				$t06_siswarutin_grid->TotalRecs = $t06_siswarutin_grid->Recordset->RecordCount();
		}
		$t06_siswarutin_grid->StartRec = 1;
		$t06_siswarutin_grid->DisplayRecs = $t06_siswarutin_grid->TotalRecs;
	} else {
		$t06_siswarutin->CurrentFilter = "0=1";
		$t06_siswarutin_grid->StartRec = 1;
		$t06_siswarutin_grid->DisplayRecs = $t06_siswarutin->GridAddRowCount;
	}
	$t06_siswarutin_grid->TotalRecs = $t06_siswarutin_grid->DisplayRecs;
	$t06_siswarutin_grid->StopRec = $t06_siswarutin_grid->DisplayRecs;
} else {
	$bSelectLimit = $t06_siswarutin_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($t06_siswarutin_grid->TotalRecs <= 0)
			$t06_siswarutin_grid->TotalRecs = $t06_siswarutin->SelectRecordCount();
	} else {
		if (!$t06_siswarutin_grid->Recordset && ($t06_siswarutin_grid->Recordset = $t06_siswarutin_grid->LoadRecordset()))
			$t06_siswarutin_grid->TotalRecs = $t06_siswarutin_grid->Recordset->RecordCount();
	}
	$t06_siswarutin_grid->StartRec = 1;
	$t06_siswarutin_grid->DisplayRecs = $t06_siswarutin_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$t06_siswarutin_grid->Recordset = $t06_siswarutin_grid->LoadRecordset($t06_siswarutin_grid->StartRec-1, $t06_siswarutin_grid->DisplayRecs);

	// Set no record found message
	if ($t06_siswarutin->CurrentAction == "" && $t06_siswarutin_grid->TotalRecs == 0) {
		if ($t06_siswarutin_grid->SearchWhere == "0=101")
			$t06_siswarutin_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$t06_siswarutin_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$t06_siswarutin_grid->RenderOtherOptions();
?>
<?php $t06_siswarutin_grid->ShowPageHeader(); ?>
<?php
$t06_siswarutin_grid->ShowMessage();
?>
<?php if ($t06_siswarutin_grid->TotalRecs > 0 || $t06_siswarutin->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid t06_siswarutin">
<div id="ft06_siswarutingrid" class="ewForm form-inline">
<div id="gmp_t06_siswarutin" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_t06_siswarutingrid" class="table ewTable">
<?php echo $t06_siswarutin->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$t06_siswarutin_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$t06_siswarutin_grid->RenderListOptions();

// Render list options (header, left)
$t06_siswarutin_grid->ListOptions->Render("header", "left");
?>
<?php if ($t06_siswarutin->siswa_id->Visible) { // siswa_id ?>
	<?php if ($t06_siswarutin->SortUrl($t06_siswarutin->siswa_id) == "") { ?>
		<th data-name="siswa_id"><div id="elh_t06_siswarutin_siswa_id" class="t06_siswarutin_siswa_id"><div class="ewTableHeaderCaption"><?php echo $t06_siswarutin->siswa_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="siswa_id"><div><div id="elh_t06_siswarutin_siswa_id" class="t06_siswarutin_siswa_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t06_siswarutin->siswa_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t06_siswarutin->siswa_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t06_siswarutin->siswa_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t06_siswarutin->rutin_id->Visible) { // rutin_id ?>
	<?php if ($t06_siswarutin->SortUrl($t06_siswarutin->rutin_id) == "") { ?>
		<th data-name="rutin_id"><div id="elh_t06_siswarutin_rutin_id" class="t06_siswarutin_rutin_id"><div class="ewTableHeaderCaption"><?php echo $t06_siswarutin->rutin_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="rutin_id"><div><div id="elh_t06_siswarutin_rutin_id" class="t06_siswarutin_rutin_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t06_siswarutin->rutin_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t06_siswarutin->rutin_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t06_siswarutin->rutin_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t06_siswarutin->Nilai->Visible) { // Nilai ?>
	<?php if ($t06_siswarutin->SortUrl($t06_siswarutin->Nilai) == "") { ?>
		<th data-name="Nilai"><div id="elh_t06_siswarutin_Nilai" class="t06_siswarutin_Nilai"><div class="ewTableHeaderCaption"><?php echo $t06_siswarutin->Nilai->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nilai"><div><div id="elh_t06_siswarutin_Nilai" class="t06_siswarutin_Nilai">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t06_siswarutin->Nilai->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t06_siswarutin->Nilai->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t06_siswarutin->Nilai->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$t06_siswarutin_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$t06_siswarutin_grid->StartRec = 1;
$t06_siswarutin_grid->StopRec = $t06_siswarutin_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($t06_siswarutin_grid->FormKeyCountName) && ($t06_siswarutin->CurrentAction == "gridadd" || $t06_siswarutin->CurrentAction == "gridedit" || $t06_siswarutin->CurrentAction == "F")) {
		$t06_siswarutin_grid->KeyCount = $objForm->GetValue($t06_siswarutin_grid->FormKeyCountName);
		$t06_siswarutin_grid->StopRec = $t06_siswarutin_grid->StartRec + $t06_siswarutin_grid->KeyCount - 1;
	}
}
$t06_siswarutin_grid->RecCnt = $t06_siswarutin_grid->StartRec - 1;
if ($t06_siswarutin_grid->Recordset && !$t06_siswarutin_grid->Recordset->EOF) {
	$t06_siswarutin_grid->Recordset->MoveFirst();
	$bSelectLimit = $t06_siswarutin_grid->UseSelectLimit;
	if (!$bSelectLimit && $t06_siswarutin_grid->StartRec > 1)
		$t06_siswarutin_grid->Recordset->Move($t06_siswarutin_grid->StartRec - 1);
} elseif (!$t06_siswarutin->AllowAddDeleteRow && $t06_siswarutin_grid->StopRec == 0) {
	$t06_siswarutin_grid->StopRec = $t06_siswarutin->GridAddRowCount;
}

// Initialize aggregate
$t06_siswarutin->RowType = EW_ROWTYPE_AGGREGATEINIT;
$t06_siswarutin->ResetAttrs();
$t06_siswarutin_grid->RenderRow();
if ($t06_siswarutin->CurrentAction == "gridadd")
	$t06_siswarutin_grid->RowIndex = 0;
if ($t06_siswarutin->CurrentAction == "gridedit")
	$t06_siswarutin_grid->RowIndex = 0;
while ($t06_siswarutin_grid->RecCnt < $t06_siswarutin_grid->StopRec) {
	$t06_siswarutin_grid->RecCnt++;
	if (intval($t06_siswarutin_grid->RecCnt) >= intval($t06_siswarutin_grid->StartRec)) {
		$t06_siswarutin_grid->RowCnt++;
		if ($t06_siswarutin->CurrentAction == "gridadd" || $t06_siswarutin->CurrentAction == "gridedit" || $t06_siswarutin->CurrentAction == "F") {
			$t06_siswarutin_grid->RowIndex++;
			$objForm->Index = $t06_siswarutin_grid->RowIndex;
			if ($objForm->HasValue($t06_siswarutin_grid->FormActionName))
				$t06_siswarutin_grid->RowAction = strval($objForm->GetValue($t06_siswarutin_grid->FormActionName));
			elseif ($t06_siswarutin->CurrentAction == "gridadd")
				$t06_siswarutin_grid->RowAction = "insert";
			else
				$t06_siswarutin_grid->RowAction = "";
		}

		// Set up key count
		$t06_siswarutin_grid->KeyCount = $t06_siswarutin_grid->RowIndex;

		// Init row class and style
		$t06_siswarutin->ResetAttrs();
		$t06_siswarutin->CssClass = "";
		if ($t06_siswarutin->CurrentAction == "gridadd") {
			if ($t06_siswarutin->CurrentMode == "copy") {
				$t06_siswarutin_grid->LoadRowValues($t06_siswarutin_grid->Recordset); // Load row values
				$t06_siswarutin_grid->SetRecordKey($t06_siswarutin_grid->RowOldKey, $t06_siswarutin_grid->Recordset); // Set old record key
			} else {
				$t06_siswarutin_grid->LoadDefaultValues(); // Load default values
				$t06_siswarutin_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$t06_siswarutin_grid->LoadRowValues($t06_siswarutin_grid->Recordset); // Load row values
		}
		$t06_siswarutin->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($t06_siswarutin->CurrentAction == "gridadd") // Grid add
			$t06_siswarutin->RowType = EW_ROWTYPE_ADD; // Render add
		if ($t06_siswarutin->CurrentAction == "gridadd" && $t06_siswarutin->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$t06_siswarutin_grid->RestoreCurrentRowFormValues($t06_siswarutin_grid->RowIndex); // Restore form values
		if ($t06_siswarutin->CurrentAction == "gridedit") { // Grid edit
			if ($t06_siswarutin->EventCancelled) {
				$t06_siswarutin_grid->RestoreCurrentRowFormValues($t06_siswarutin_grid->RowIndex); // Restore form values
			}
			if ($t06_siswarutin_grid->RowAction == "insert")
				$t06_siswarutin->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$t06_siswarutin->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($t06_siswarutin->CurrentAction == "gridedit" && ($t06_siswarutin->RowType == EW_ROWTYPE_EDIT || $t06_siswarutin->RowType == EW_ROWTYPE_ADD) && $t06_siswarutin->EventCancelled) // Update failed
			$t06_siswarutin_grid->RestoreCurrentRowFormValues($t06_siswarutin_grid->RowIndex); // Restore form values
		if ($t06_siswarutin->RowType == EW_ROWTYPE_EDIT) // Edit row
			$t06_siswarutin_grid->EditRowCnt++;
		if ($t06_siswarutin->CurrentAction == "F") // Confirm row
			$t06_siswarutin_grid->RestoreCurrentRowFormValues($t06_siswarutin_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$t06_siswarutin->RowAttrs = array_merge($t06_siswarutin->RowAttrs, array('data-rowindex'=>$t06_siswarutin_grid->RowCnt, 'id'=>'r' . $t06_siswarutin_grid->RowCnt . '_t06_siswarutin', 'data-rowtype'=>$t06_siswarutin->RowType));

		// Render row
		$t06_siswarutin_grid->RenderRow();

		// Render list options
		$t06_siswarutin_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($t06_siswarutin_grid->RowAction <> "delete" && $t06_siswarutin_grid->RowAction <> "insertdelete" && !($t06_siswarutin_grid->RowAction == "insert" && $t06_siswarutin->CurrentAction == "F" && $t06_siswarutin_grid->EmptyRow())) {
?>
	<tr<?php echo $t06_siswarutin->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t06_siswarutin_grid->ListOptions->Render("body", "left", $t06_siswarutin_grid->RowCnt);
?>
	<?php if ($t06_siswarutin->siswa_id->Visible) { // siswa_id ?>
		<td data-name="siswa_id"<?php echo $t06_siswarutin->siswa_id->CellAttributes() ?>>
<?php if ($t06_siswarutin->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($t06_siswarutin->siswa_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $t06_siswarutin_grid->RowCnt ?>_t06_siswarutin_siswa_id" class="form-group t06_siswarutin_siswa_id">
<span<?php echo $t06_siswarutin->siswa_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t06_siswarutin->siswa_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t06_siswarutin_grid->RowIndex ?>_siswa_id" name="x<?php echo $t06_siswarutin_grid->RowIndex ?>_siswa_id" value="<?php echo ew_HtmlEncode($t06_siswarutin->siswa_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $t06_siswarutin_grid->RowCnt ?>_t06_siswarutin_siswa_id" class="form-group t06_siswarutin_siswa_id">
<input type="text" data-table="t06_siswarutin" data-field="x_siswa_id" name="x<?php echo $t06_siswarutin_grid->RowIndex ?>_siswa_id" id="x<?php echo $t06_siswarutin_grid->RowIndex ?>_siswa_id" size="30" placeholder="<?php echo ew_HtmlEncode($t06_siswarutin->siswa_id->getPlaceHolder()) ?>" value="<?php echo $t06_siswarutin->siswa_id->EditValue ?>"<?php echo $t06_siswarutin->siswa_id->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="t06_siswarutin" data-field="x_siswa_id" name="o<?php echo $t06_siswarutin_grid->RowIndex ?>_siswa_id" id="o<?php echo $t06_siswarutin_grid->RowIndex ?>_siswa_id" value="<?php echo ew_HtmlEncode($t06_siswarutin->siswa_id->OldValue) ?>">
<?php } ?>
<?php if ($t06_siswarutin->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($t06_siswarutin->siswa_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $t06_siswarutin_grid->RowCnt ?>_t06_siswarutin_siswa_id" class="form-group t06_siswarutin_siswa_id">
<span<?php echo $t06_siswarutin->siswa_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t06_siswarutin->siswa_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t06_siswarutin_grid->RowIndex ?>_siswa_id" name="x<?php echo $t06_siswarutin_grid->RowIndex ?>_siswa_id" value="<?php echo ew_HtmlEncode($t06_siswarutin->siswa_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $t06_siswarutin_grid->RowCnt ?>_t06_siswarutin_siswa_id" class="form-group t06_siswarutin_siswa_id">
<input type="text" data-table="t06_siswarutin" data-field="x_siswa_id" name="x<?php echo $t06_siswarutin_grid->RowIndex ?>_siswa_id" id="x<?php echo $t06_siswarutin_grid->RowIndex ?>_siswa_id" size="30" placeholder="<?php echo ew_HtmlEncode($t06_siswarutin->siswa_id->getPlaceHolder()) ?>" value="<?php echo $t06_siswarutin->siswa_id->EditValue ?>"<?php echo $t06_siswarutin->siswa_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php } ?>
<?php if ($t06_siswarutin->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t06_siswarutin_grid->RowCnt ?>_t06_siswarutin_siswa_id" class="t06_siswarutin_siswa_id">
<span<?php echo $t06_siswarutin->siswa_id->ViewAttributes() ?>>
<?php echo $t06_siswarutin->siswa_id->ListViewValue() ?></span>
</span>
<?php if ($t06_siswarutin->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t06_siswarutin" data-field="x_siswa_id" name="x<?php echo $t06_siswarutin_grid->RowIndex ?>_siswa_id" id="x<?php echo $t06_siswarutin_grid->RowIndex ?>_siswa_id" value="<?php echo ew_HtmlEncode($t06_siswarutin->siswa_id->FormValue) ?>">
<input type="hidden" data-table="t06_siswarutin" data-field="x_siswa_id" name="o<?php echo $t06_siswarutin_grid->RowIndex ?>_siswa_id" id="o<?php echo $t06_siswarutin_grid->RowIndex ?>_siswa_id" value="<?php echo ew_HtmlEncode($t06_siswarutin->siswa_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t06_siswarutin" data-field="x_siswa_id" name="ft06_siswarutingrid$x<?php echo $t06_siswarutin_grid->RowIndex ?>_siswa_id" id="ft06_siswarutingrid$x<?php echo $t06_siswarutin_grid->RowIndex ?>_siswa_id" value="<?php echo ew_HtmlEncode($t06_siswarutin->siswa_id->FormValue) ?>">
<input type="hidden" data-table="t06_siswarutin" data-field="x_siswa_id" name="ft06_siswarutingrid$o<?php echo $t06_siswarutin_grid->RowIndex ?>_siswa_id" id="ft06_siswarutingrid$o<?php echo $t06_siswarutin_grid->RowIndex ?>_siswa_id" value="<?php echo ew_HtmlEncode($t06_siswarutin->siswa_id->OldValue) ?>">
<?php } ?>
<?php } ?>
<a id="<?php echo $t06_siswarutin_grid->PageObjName . "_row_" . $t06_siswarutin_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($t06_siswarutin->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="t06_siswarutin" data-field="x_id" name="x<?php echo $t06_siswarutin_grid->RowIndex ?>_id" id="x<?php echo $t06_siswarutin_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t06_siswarutin->id->CurrentValue) ?>">
<input type="hidden" data-table="t06_siswarutin" data-field="x_id" name="o<?php echo $t06_siswarutin_grid->RowIndex ?>_id" id="o<?php echo $t06_siswarutin_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t06_siswarutin->id->OldValue) ?>">
<?php } ?>
<?php if ($t06_siswarutin->RowType == EW_ROWTYPE_EDIT || $t06_siswarutin->CurrentMode == "edit") { ?>
<input type="hidden" data-table="t06_siswarutin" data-field="x_id" name="x<?php echo $t06_siswarutin_grid->RowIndex ?>_id" id="x<?php echo $t06_siswarutin_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t06_siswarutin->id->CurrentValue) ?>">
<?php } ?>
	<?php if ($t06_siswarutin->rutin_id->Visible) { // rutin_id ?>
		<td data-name="rutin_id"<?php echo $t06_siswarutin->rutin_id->CellAttributes() ?>>
<?php if ($t06_siswarutin->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t06_siswarutin_grid->RowCnt ?>_t06_siswarutin_rutin_id" class="form-group t06_siswarutin_rutin_id">
<select data-table="t06_siswarutin" data-field="x_rutin_id" data-value-separator="<?php echo $t06_siswarutin->rutin_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $t06_siswarutin_grid->RowIndex ?>_rutin_id" name="x<?php echo $t06_siswarutin_grid->RowIndex ?>_rutin_id"<?php echo $t06_siswarutin->rutin_id->EditAttributes() ?>>
<?php echo $t06_siswarutin->rutin_id->SelectOptionListHtml("x<?php echo $t06_siswarutin_grid->RowIndex ?>_rutin_id") ?>
</select>
<input type="hidden" name="s_x<?php echo $t06_siswarutin_grid->RowIndex ?>_rutin_id" id="s_x<?php echo $t06_siswarutin_grid->RowIndex ?>_rutin_id" value="<?php echo $t06_siswarutin->rutin_id->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="t06_siswarutin" data-field="x_rutin_id" name="o<?php echo $t06_siswarutin_grid->RowIndex ?>_rutin_id" id="o<?php echo $t06_siswarutin_grid->RowIndex ?>_rutin_id" value="<?php echo ew_HtmlEncode($t06_siswarutin->rutin_id->OldValue) ?>">
<?php } ?>
<?php if ($t06_siswarutin->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t06_siswarutin_grid->RowCnt ?>_t06_siswarutin_rutin_id" class="form-group t06_siswarutin_rutin_id">
<select data-table="t06_siswarutin" data-field="x_rutin_id" data-value-separator="<?php echo $t06_siswarutin->rutin_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $t06_siswarutin_grid->RowIndex ?>_rutin_id" name="x<?php echo $t06_siswarutin_grid->RowIndex ?>_rutin_id"<?php echo $t06_siswarutin->rutin_id->EditAttributes() ?>>
<?php echo $t06_siswarutin->rutin_id->SelectOptionListHtml("x<?php echo $t06_siswarutin_grid->RowIndex ?>_rutin_id") ?>
</select>
<input type="hidden" name="s_x<?php echo $t06_siswarutin_grid->RowIndex ?>_rutin_id" id="s_x<?php echo $t06_siswarutin_grid->RowIndex ?>_rutin_id" value="<?php echo $t06_siswarutin->rutin_id->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($t06_siswarutin->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t06_siswarutin_grid->RowCnt ?>_t06_siswarutin_rutin_id" class="t06_siswarutin_rutin_id">
<span<?php echo $t06_siswarutin->rutin_id->ViewAttributes() ?>>
<?php echo $t06_siswarutin->rutin_id->ListViewValue() ?></span>
</span>
<?php if ($t06_siswarutin->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t06_siswarutin" data-field="x_rutin_id" name="x<?php echo $t06_siswarutin_grid->RowIndex ?>_rutin_id" id="x<?php echo $t06_siswarutin_grid->RowIndex ?>_rutin_id" value="<?php echo ew_HtmlEncode($t06_siswarutin->rutin_id->FormValue) ?>">
<input type="hidden" data-table="t06_siswarutin" data-field="x_rutin_id" name="o<?php echo $t06_siswarutin_grid->RowIndex ?>_rutin_id" id="o<?php echo $t06_siswarutin_grid->RowIndex ?>_rutin_id" value="<?php echo ew_HtmlEncode($t06_siswarutin->rutin_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t06_siswarutin" data-field="x_rutin_id" name="ft06_siswarutingrid$x<?php echo $t06_siswarutin_grid->RowIndex ?>_rutin_id" id="ft06_siswarutingrid$x<?php echo $t06_siswarutin_grid->RowIndex ?>_rutin_id" value="<?php echo ew_HtmlEncode($t06_siswarutin->rutin_id->FormValue) ?>">
<input type="hidden" data-table="t06_siswarutin" data-field="x_rutin_id" name="ft06_siswarutingrid$o<?php echo $t06_siswarutin_grid->RowIndex ?>_rutin_id" id="ft06_siswarutingrid$o<?php echo $t06_siswarutin_grid->RowIndex ?>_rutin_id" value="<?php echo ew_HtmlEncode($t06_siswarutin->rutin_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t06_siswarutin->Nilai->Visible) { // Nilai ?>
		<td data-name="Nilai"<?php echo $t06_siswarutin->Nilai->CellAttributes() ?>>
<?php if ($t06_siswarutin->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t06_siswarutin_grid->RowCnt ?>_t06_siswarutin_Nilai" class="form-group t06_siswarutin_Nilai">
<input type="text" data-table="t06_siswarutin" data-field="x_Nilai" name="x<?php echo $t06_siswarutin_grid->RowIndex ?>_Nilai" id="x<?php echo $t06_siswarutin_grid->RowIndex ?>_Nilai" size="30" placeholder="<?php echo ew_HtmlEncode($t06_siswarutin->Nilai->getPlaceHolder()) ?>" value="<?php echo $t06_siswarutin->Nilai->EditValue ?>"<?php echo $t06_siswarutin->Nilai->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t06_siswarutin" data-field="x_Nilai" name="o<?php echo $t06_siswarutin_grid->RowIndex ?>_Nilai" id="o<?php echo $t06_siswarutin_grid->RowIndex ?>_Nilai" value="<?php echo ew_HtmlEncode($t06_siswarutin->Nilai->OldValue) ?>">
<?php } ?>
<?php if ($t06_siswarutin->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t06_siswarutin_grid->RowCnt ?>_t06_siswarutin_Nilai" class="form-group t06_siswarutin_Nilai">
<input type="text" data-table="t06_siswarutin" data-field="x_Nilai" name="x<?php echo $t06_siswarutin_grid->RowIndex ?>_Nilai" id="x<?php echo $t06_siswarutin_grid->RowIndex ?>_Nilai" size="30" placeholder="<?php echo ew_HtmlEncode($t06_siswarutin->Nilai->getPlaceHolder()) ?>" value="<?php echo $t06_siswarutin->Nilai->EditValue ?>"<?php echo $t06_siswarutin->Nilai->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t06_siswarutin->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t06_siswarutin_grid->RowCnt ?>_t06_siswarutin_Nilai" class="t06_siswarutin_Nilai">
<span<?php echo $t06_siswarutin->Nilai->ViewAttributes() ?>>
<?php echo $t06_siswarutin->Nilai->ListViewValue() ?></span>
</span>
<?php if ($t06_siswarutin->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t06_siswarutin" data-field="x_Nilai" name="x<?php echo $t06_siswarutin_grid->RowIndex ?>_Nilai" id="x<?php echo $t06_siswarutin_grid->RowIndex ?>_Nilai" value="<?php echo ew_HtmlEncode($t06_siswarutin->Nilai->FormValue) ?>">
<input type="hidden" data-table="t06_siswarutin" data-field="x_Nilai" name="o<?php echo $t06_siswarutin_grid->RowIndex ?>_Nilai" id="o<?php echo $t06_siswarutin_grid->RowIndex ?>_Nilai" value="<?php echo ew_HtmlEncode($t06_siswarutin->Nilai->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t06_siswarutin" data-field="x_Nilai" name="ft06_siswarutingrid$x<?php echo $t06_siswarutin_grid->RowIndex ?>_Nilai" id="ft06_siswarutingrid$x<?php echo $t06_siswarutin_grid->RowIndex ?>_Nilai" value="<?php echo ew_HtmlEncode($t06_siswarutin->Nilai->FormValue) ?>">
<input type="hidden" data-table="t06_siswarutin" data-field="x_Nilai" name="ft06_siswarutingrid$o<?php echo $t06_siswarutin_grid->RowIndex ?>_Nilai" id="ft06_siswarutingrid$o<?php echo $t06_siswarutin_grid->RowIndex ?>_Nilai" value="<?php echo ew_HtmlEncode($t06_siswarutin->Nilai->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t06_siswarutin_grid->ListOptions->Render("body", "right", $t06_siswarutin_grid->RowCnt);
?>
	</tr>
<?php if ($t06_siswarutin->RowType == EW_ROWTYPE_ADD || $t06_siswarutin->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ft06_siswarutingrid.UpdateOpts(<?php echo $t06_siswarutin_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($t06_siswarutin->CurrentAction <> "gridadd" || $t06_siswarutin->CurrentMode == "copy")
		if (!$t06_siswarutin_grid->Recordset->EOF) $t06_siswarutin_grid->Recordset->MoveNext();
}
?>
<?php
	if ($t06_siswarutin->CurrentMode == "add" || $t06_siswarutin->CurrentMode == "copy" || $t06_siswarutin->CurrentMode == "edit") {
		$t06_siswarutin_grid->RowIndex = '$rowindex$';
		$t06_siswarutin_grid->LoadDefaultValues();

		// Set row properties
		$t06_siswarutin->ResetAttrs();
		$t06_siswarutin->RowAttrs = array_merge($t06_siswarutin->RowAttrs, array('data-rowindex'=>$t06_siswarutin_grid->RowIndex, 'id'=>'r0_t06_siswarutin', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($t06_siswarutin->RowAttrs["class"], "ewTemplate");
		$t06_siswarutin->RowType = EW_ROWTYPE_ADD;

		// Render row
		$t06_siswarutin_grid->RenderRow();

		// Render list options
		$t06_siswarutin_grid->RenderListOptions();
		$t06_siswarutin_grid->StartRowCnt = 0;
?>
	<tr<?php echo $t06_siswarutin->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t06_siswarutin_grid->ListOptions->Render("body", "left", $t06_siswarutin_grid->RowIndex);
?>
	<?php if ($t06_siswarutin->siswa_id->Visible) { // siswa_id ?>
		<td data-name="siswa_id">
<?php if ($t06_siswarutin->CurrentAction <> "F") { ?>
<?php if ($t06_siswarutin->siswa_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_t06_siswarutin_siswa_id" class="form-group t06_siswarutin_siswa_id">
<span<?php echo $t06_siswarutin->siswa_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t06_siswarutin->siswa_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t06_siswarutin_grid->RowIndex ?>_siswa_id" name="x<?php echo $t06_siswarutin_grid->RowIndex ?>_siswa_id" value="<?php echo ew_HtmlEncode($t06_siswarutin->siswa_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_t06_siswarutin_siswa_id" class="form-group t06_siswarutin_siswa_id">
<input type="text" data-table="t06_siswarutin" data-field="x_siswa_id" name="x<?php echo $t06_siswarutin_grid->RowIndex ?>_siswa_id" id="x<?php echo $t06_siswarutin_grid->RowIndex ?>_siswa_id" size="30" placeholder="<?php echo ew_HtmlEncode($t06_siswarutin->siswa_id->getPlaceHolder()) ?>" value="<?php echo $t06_siswarutin->siswa_id->EditValue ?>"<?php echo $t06_siswarutin->siswa_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_t06_siswarutin_siswa_id" class="form-group t06_siswarutin_siswa_id">
<span<?php echo $t06_siswarutin->siswa_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t06_siswarutin->siswa_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t06_siswarutin" data-field="x_siswa_id" name="x<?php echo $t06_siswarutin_grid->RowIndex ?>_siswa_id" id="x<?php echo $t06_siswarutin_grid->RowIndex ?>_siswa_id" value="<?php echo ew_HtmlEncode($t06_siswarutin->siswa_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t06_siswarutin" data-field="x_siswa_id" name="o<?php echo $t06_siswarutin_grid->RowIndex ?>_siswa_id" id="o<?php echo $t06_siswarutin_grid->RowIndex ?>_siswa_id" value="<?php echo ew_HtmlEncode($t06_siswarutin->siswa_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t06_siswarutin->rutin_id->Visible) { // rutin_id ?>
		<td data-name="rutin_id">
<?php if ($t06_siswarutin->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t06_siswarutin_rutin_id" class="form-group t06_siswarutin_rutin_id">
<select data-table="t06_siswarutin" data-field="x_rutin_id" data-value-separator="<?php echo $t06_siswarutin->rutin_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $t06_siswarutin_grid->RowIndex ?>_rutin_id" name="x<?php echo $t06_siswarutin_grid->RowIndex ?>_rutin_id"<?php echo $t06_siswarutin->rutin_id->EditAttributes() ?>>
<?php echo $t06_siswarutin->rutin_id->SelectOptionListHtml("x<?php echo $t06_siswarutin_grid->RowIndex ?>_rutin_id") ?>
</select>
<input type="hidden" name="s_x<?php echo $t06_siswarutin_grid->RowIndex ?>_rutin_id" id="s_x<?php echo $t06_siswarutin_grid->RowIndex ?>_rutin_id" value="<?php echo $t06_siswarutin->rutin_id->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_t06_siswarutin_rutin_id" class="form-group t06_siswarutin_rutin_id">
<span<?php echo $t06_siswarutin->rutin_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t06_siswarutin->rutin_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t06_siswarutin" data-field="x_rutin_id" name="x<?php echo $t06_siswarutin_grid->RowIndex ?>_rutin_id" id="x<?php echo $t06_siswarutin_grid->RowIndex ?>_rutin_id" value="<?php echo ew_HtmlEncode($t06_siswarutin->rutin_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t06_siswarutin" data-field="x_rutin_id" name="o<?php echo $t06_siswarutin_grid->RowIndex ?>_rutin_id" id="o<?php echo $t06_siswarutin_grid->RowIndex ?>_rutin_id" value="<?php echo ew_HtmlEncode($t06_siswarutin->rutin_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t06_siswarutin->Nilai->Visible) { // Nilai ?>
		<td data-name="Nilai">
<?php if ($t06_siswarutin->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t06_siswarutin_Nilai" class="form-group t06_siswarutin_Nilai">
<input type="text" data-table="t06_siswarutin" data-field="x_Nilai" name="x<?php echo $t06_siswarutin_grid->RowIndex ?>_Nilai" id="x<?php echo $t06_siswarutin_grid->RowIndex ?>_Nilai" size="30" placeholder="<?php echo ew_HtmlEncode($t06_siswarutin->Nilai->getPlaceHolder()) ?>" value="<?php echo $t06_siswarutin->Nilai->EditValue ?>"<?php echo $t06_siswarutin->Nilai->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t06_siswarutin_Nilai" class="form-group t06_siswarutin_Nilai">
<span<?php echo $t06_siswarutin->Nilai->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t06_siswarutin->Nilai->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t06_siswarutin" data-field="x_Nilai" name="x<?php echo $t06_siswarutin_grid->RowIndex ?>_Nilai" id="x<?php echo $t06_siswarutin_grid->RowIndex ?>_Nilai" value="<?php echo ew_HtmlEncode($t06_siswarutin->Nilai->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t06_siswarutin" data-field="x_Nilai" name="o<?php echo $t06_siswarutin_grid->RowIndex ?>_Nilai" id="o<?php echo $t06_siswarutin_grid->RowIndex ?>_Nilai" value="<?php echo ew_HtmlEncode($t06_siswarutin->Nilai->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t06_siswarutin_grid->ListOptions->Render("body", "right", $t06_siswarutin_grid->RowCnt);
?>
<script type="text/javascript">
ft06_siswarutingrid.UpdateOpts(<?php echo $t06_siswarutin_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($t06_siswarutin->CurrentMode == "add" || $t06_siswarutin->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $t06_siswarutin_grid->FormKeyCountName ?>" id="<?php echo $t06_siswarutin_grid->FormKeyCountName ?>" value="<?php echo $t06_siswarutin_grid->KeyCount ?>">
<?php echo $t06_siswarutin_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t06_siswarutin->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $t06_siswarutin_grid->FormKeyCountName ?>" id="<?php echo $t06_siswarutin_grid->FormKeyCountName ?>" value="<?php echo $t06_siswarutin_grid->KeyCount ?>">
<?php echo $t06_siswarutin_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t06_siswarutin->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="ft06_siswarutingrid">
</div>
<?php

// Close recordset
if ($t06_siswarutin_grid->Recordset)
	$t06_siswarutin_grid->Recordset->Close();
?>
<?php if ($t06_siswarutin_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($t06_siswarutin_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($t06_siswarutin_grid->TotalRecs == 0 && $t06_siswarutin->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t06_siswarutin_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($t06_siswarutin->Export == "") { ?>
<script type="text/javascript">
ft06_siswarutingrid.Init();
</script>
<?php } ?>
<?php
$t06_siswarutin_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$t06_siswarutin_grid->Page_Terminate();
?>
