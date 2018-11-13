<?php

// Create page object
if (!isset($t09_siswanonrutin_grid)) $t09_siswanonrutin_grid = new ct09_siswanonrutin_grid();

// Page init
$t09_siswanonrutin_grid->Page_Init();

// Page main
$t09_siswanonrutin_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t09_siswanonrutin_grid->Page_Render();
?>
<?php if ($t09_siswanonrutin->Export == "") { ?>
<script type="text/javascript">

// Form object
var ft09_siswanonrutingrid = new ew_Form("ft09_siswanonrutingrid", "grid");
ft09_siswanonrutingrid.FormKeyCountName = '<?php echo $t09_siswanonrutin_grid->FormKeyCountName ?>';

// Validate form
ft09_siswanonrutingrid.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t09_siswanonrutin->siswa_id->FldCaption(), $t09_siswanonrutin->siswa_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_siswa_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t09_siswanonrutin->siswa_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_nonrutin_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t09_siswanonrutin->nonrutin_id->FldCaption(), $t09_siswanonrutin->nonrutin_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Nilai");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t09_siswanonrutin->Nilai->FldCaption(), $t09_siswanonrutin->Nilai->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Nilai");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t09_siswanonrutin->Nilai->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
ft09_siswanonrutingrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "siswa_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "nonrutin_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Nilai", false)) return false;
	return true;
}

// Form_CustomValidate event
ft09_siswanonrutingrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft09_siswanonrutingrid.ValidateRequired = true;
<?php } else { ?>
ft09_siswanonrutingrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft09_siswanonrutingrid.Lists["x_nonrutin_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_Jenis","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t08_nonrutin"};

// Form object for search
</script>
<?php } ?>
<?php
if ($t09_siswanonrutin->CurrentAction == "gridadd") {
	if ($t09_siswanonrutin->CurrentMode == "copy") {
		$bSelectLimit = $t09_siswanonrutin_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$t09_siswanonrutin_grid->TotalRecs = $t09_siswanonrutin->SelectRecordCount();
			$t09_siswanonrutin_grid->Recordset = $t09_siswanonrutin_grid->LoadRecordset($t09_siswanonrutin_grid->StartRec-1, $t09_siswanonrutin_grid->DisplayRecs);
		} else {
			if ($t09_siswanonrutin_grid->Recordset = $t09_siswanonrutin_grid->LoadRecordset())
				$t09_siswanonrutin_grid->TotalRecs = $t09_siswanonrutin_grid->Recordset->RecordCount();
		}
		$t09_siswanonrutin_grid->StartRec = 1;
		$t09_siswanonrutin_grid->DisplayRecs = $t09_siswanonrutin_grid->TotalRecs;
	} else {
		$t09_siswanonrutin->CurrentFilter = "0=1";
		$t09_siswanonrutin_grid->StartRec = 1;
		$t09_siswanonrutin_grid->DisplayRecs = $t09_siswanonrutin->GridAddRowCount;
	}
	$t09_siswanonrutin_grid->TotalRecs = $t09_siswanonrutin_grid->DisplayRecs;
	$t09_siswanonrutin_grid->StopRec = $t09_siswanonrutin_grid->DisplayRecs;
} else {
	$bSelectLimit = $t09_siswanonrutin_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($t09_siswanonrutin_grid->TotalRecs <= 0)
			$t09_siswanonrutin_grid->TotalRecs = $t09_siswanonrutin->SelectRecordCount();
	} else {
		if (!$t09_siswanonrutin_grid->Recordset && ($t09_siswanonrutin_grid->Recordset = $t09_siswanonrutin_grid->LoadRecordset()))
			$t09_siswanonrutin_grid->TotalRecs = $t09_siswanonrutin_grid->Recordset->RecordCount();
	}
	$t09_siswanonrutin_grid->StartRec = 1;
	$t09_siswanonrutin_grid->DisplayRecs = $t09_siswanonrutin_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$t09_siswanonrutin_grid->Recordset = $t09_siswanonrutin_grid->LoadRecordset($t09_siswanonrutin_grid->StartRec-1, $t09_siswanonrutin_grid->DisplayRecs);

	// Set no record found message
	if ($t09_siswanonrutin->CurrentAction == "" && $t09_siswanonrutin_grid->TotalRecs == 0) {
		if ($t09_siswanonrutin_grid->SearchWhere == "0=101")
			$t09_siswanonrutin_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$t09_siswanonrutin_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$t09_siswanonrutin_grid->RenderOtherOptions();
?>
<?php $t09_siswanonrutin_grid->ShowPageHeader(); ?>
<?php
$t09_siswanonrutin_grid->ShowMessage();
?>
<?php if ($t09_siswanonrutin_grid->TotalRecs > 0 || $t09_siswanonrutin->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid t09_siswanonrutin">
<div id="ft09_siswanonrutingrid" class="ewForm form-inline">
<div id="gmp_t09_siswanonrutin" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_t09_siswanonrutingrid" class="table ewTable">
<?php echo $t09_siswanonrutin->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$t09_siswanonrutin_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$t09_siswanonrutin_grid->RenderListOptions();

// Render list options (header, left)
$t09_siswanonrutin_grid->ListOptions->Render("header", "left");
?>
<?php if ($t09_siswanonrutin->siswa_id->Visible) { // siswa_id ?>
	<?php if ($t09_siswanonrutin->SortUrl($t09_siswanonrutin->siswa_id) == "") { ?>
		<th data-name="siswa_id"><div id="elh_t09_siswanonrutin_siswa_id" class="t09_siswanonrutin_siswa_id"><div class="ewTableHeaderCaption"><?php echo $t09_siswanonrutin->siswa_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="siswa_id"><div><div id="elh_t09_siswanonrutin_siswa_id" class="t09_siswanonrutin_siswa_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t09_siswanonrutin->siswa_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t09_siswanonrutin->siswa_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t09_siswanonrutin->siswa_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t09_siswanonrutin->nonrutin_id->Visible) { // nonrutin_id ?>
	<?php if ($t09_siswanonrutin->SortUrl($t09_siswanonrutin->nonrutin_id) == "") { ?>
		<th data-name="nonrutin_id"><div id="elh_t09_siswanonrutin_nonrutin_id" class="t09_siswanonrutin_nonrutin_id"><div class="ewTableHeaderCaption"><?php echo $t09_siswanonrutin->nonrutin_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nonrutin_id"><div><div id="elh_t09_siswanonrutin_nonrutin_id" class="t09_siswanonrutin_nonrutin_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t09_siswanonrutin->nonrutin_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t09_siswanonrutin->nonrutin_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t09_siswanonrutin->nonrutin_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t09_siswanonrutin->Nilai->Visible) { // Nilai ?>
	<?php if ($t09_siswanonrutin->SortUrl($t09_siswanonrutin->Nilai) == "") { ?>
		<th data-name="Nilai"><div id="elh_t09_siswanonrutin_Nilai" class="t09_siswanonrutin_Nilai"><div class="ewTableHeaderCaption"><?php echo $t09_siswanonrutin->Nilai->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nilai"><div><div id="elh_t09_siswanonrutin_Nilai" class="t09_siswanonrutin_Nilai">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t09_siswanonrutin->Nilai->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t09_siswanonrutin->Nilai->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t09_siswanonrutin->Nilai->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$t09_siswanonrutin_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$t09_siswanonrutin_grid->StartRec = 1;
$t09_siswanonrutin_grid->StopRec = $t09_siswanonrutin_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($t09_siswanonrutin_grid->FormKeyCountName) && ($t09_siswanonrutin->CurrentAction == "gridadd" || $t09_siswanonrutin->CurrentAction == "gridedit" || $t09_siswanonrutin->CurrentAction == "F")) {
		$t09_siswanonrutin_grid->KeyCount = $objForm->GetValue($t09_siswanonrutin_grid->FormKeyCountName);
		$t09_siswanonrutin_grid->StopRec = $t09_siswanonrutin_grid->StartRec + $t09_siswanonrutin_grid->KeyCount - 1;
	}
}
$t09_siswanonrutin_grid->RecCnt = $t09_siswanonrutin_grid->StartRec - 1;
if ($t09_siswanonrutin_grid->Recordset && !$t09_siswanonrutin_grid->Recordset->EOF) {
	$t09_siswanonrutin_grid->Recordset->MoveFirst();
	$bSelectLimit = $t09_siswanonrutin_grid->UseSelectLimit;
	if (!$bSelectLimit && $t09_siswanonrutin_grid->StartRec > 1)
		$t09_siswanonrutin_grid->Recordset->Move($t09_siswanonrutin_grid->StartRec - 1);
} elseif (!$t09_siswanonrutin->AllowAddDeleteRow && $t09_siswanonrutin_grid->StopRec == 0) {
	$t09_siswanonrutin_grid->StopRec = $t09_siswanonrutin->GridAddRowCount;
}

// Initialize aggregate
$t09_siswanonrutin->RowType = EW_ROWTYPE_AGGREGATEINIT;
$t09_siswanonrutin->ResetAttrs();
$t09_siswanonrutin_grid->RenderRow();
if ($t09_siswanonrutin->CurrentAction == "gridadd")
	$t09_siswanonrutin_grid->RowIndex = 0;
if ($t09_siswanonrutin->CurrentAction == "gridedit")
	$t09_siswanonrutin_grid->RowIndex = 0;
while ($t09_siswanonrutin_grid->RecCnt < $t09_siswanonrutin_grid->StopRec) {
	$t09_siswanonrutin_grid->RecCnt++;
	if (intval($t09_siswanonrutin_grid->RecCnt) >= intval($t09_siswanonrutin_grid->StartRec)) {
		$t09_siswanonrutin_grid->RowCnt++;
		if ($t09_siswanonrutin->CurrentAction == "gridadd" || $t09_siswanonrutin->CurrentAction == "gridedit" || $t09_siswanonrutin->CurrentAction == "F") {
			$t09_siswanonrutin_grid->RowIndex++;
			$objForm->Index = $t09_siswanonrutin_grid->RowIndex;
			if ($objForm->HasValue($t09_siswanonrutin_grid->FormActionName))
				$t09_siswanonrutin_grid->RowAction = strval($objForm->GetValue($t09_siswanonrutin_grid->FormActionName));
			elseif ($t09_siswanonrutin->CurrentAction == "gridadd")
				$t09_siswanonrutin_grid->RowAction = "insert";
			else
				$t09_siswanonrutin_grid->RowAction = "";
		}

		// Set up key count
		$t09_siswanonrutin_grid->KeyCount = $t09_siswanonrutin_grid->RowIndex;

		// Init row class and style
		$t09_siswanonrutin->ResetAttrs();
		$t09_siswanonrutin->CssClass = "";
		if ($t09_siswanonrutin->CurrentAction == "gridadd") {
			if ($t09_siswanonrutin->CurrentMode == "copy") {
				$t09_siswanonrutin_grid->LoadRowValues($t09_siswanonrutin_grid->Recordset); // Load row values
				$t09_siswanonrutin_grid->SetRecordKey($t09_siswanonrutin_grid->RowOldKey, $t09_siswanonrutin_grid->Recordset); // Set old record key
			} else {
				$t09_siswanonrutin_grid->LoadDefaultValues(); // Load default values
				$t09_siswanonrutin_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$t09_siswanonrutin_grid->LoadRowValues($t09_siswanonrutin_grid->Recordset); // Load row values
		}
		$t09_siswanonrutin->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($t09_siswanonrutin->CurrentAction == "gridadd") // Grid add
			$t09_siswanonrutin->RowType = EW_ROWTYPE_ADD; // Render add
		if ($t09_siswanonrutin->CurrentAction == "gridadd" && $t09_siswanonrutin->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$t09_siswanonrutin_grid->RestoreCurrentRowFormValues($t09_siswanonrutin_grid->RowIndex); // Restore form values
		if ($t09_siswanonrutin->CurrentAction == "gridedit") { // Grid edit
			if ($t09_siswanonrutin->EventCancelled) {
				$t09_siswanonrutin_grid->RestoreCurrentRowFormValues($t09_siswanonrutin_grid->RowIndex); // Restore form values
			}
			if ($t09_siswanonrutin_grid->RowAction == "insert")
				$t09_siswanonrutin->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$t09_siswanonrutin->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($t09_siswanonrutin->CurrentAction == "gridedit" && ($t09_siswanonrutin->RowType == EW_ROWTYPE_EDIT || $t09_siswanonrutin->RowType == EW_ROWTYPE_ADD) && $t09_siswanonrutin->EventCancelled) // Update failed
			$t09_siswanonrutin_grid->RestoreCurrentRowFormValues($t09_siswanonrutin_grid->RowIndex); // Restore form values
		if ($t09_siswanonrutin->RowType == EW_ROWTYPE_EDIT) // Edit row
			$t09_siswanonrutin_grid->EditRowCnt++;
		if ($t09_siswanonrutin->CurrentAction == "F") // Confirm row
			$t09_siswanonrutin_grid->RestoreCurrentRowFormValues($t09_siswanonrutin_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$t09_siswanonrutin->RowAttrs = array_merge($t09_siswanonrutin->RowAttrs, array('data-rowindex'=>$t09_siswanonrutin_grid->RowCnt, 'id'=>'r' . $t09_siswanonrutin_grid->RowCnt . '_t09_siswanonrutin', 'data-rowtype'=>$t09_siswanonrutin->RowType));

		// Render row
		$t09_siswanonrutin_grid->RenderRow();

		// Render list options
		$t09_siswanonrutin_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($t09_siswanonrutin_grid->RowAction <> "delete" && $t09_siswanonrutin_grid->RowAction <> "insertdelete" && !($t09_siswanonrutin_grid->RowAction == "insert" && $t09_siswanonrutin->CurrentAction == "F" && $t09_siswanonrutin_grid->EmptyRow())) {
?>
	<tr<?php echo $t09_siswanonrutin->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t09_siswanonrutin_grid->ListOptions->Render("body", "left", $t09_siswanonrutin_grid->RowCnt);
?>
	<?php if ($t09_siswanonrutin->siswa_id->Visible) { // siswa_id ?>
		<td data-name="siswa_id"<?php echo $t09_siswanonrutin->siswa_id->CellAttributes() ?>>
<?php if ($t09_siswanonrutin->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($t09_siswanonrutin->siswa_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $t09_siswanonrutin_grid->RowCnt ?>_t09_siswanonrutin_siswa_id" class="form-group t09_siswanonrutin_siswa_id">
<span<?php echo $t09_siswanonrutin->siswa_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t09_siswanonrutin->siswa_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_siswa_id" name="x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_siswa_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutin->siswa_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $t09_siswanonrutin_grid->RowCnt ?>_t09_siswanonrutin_siswa_id" class="form-group t09_siswanonrutin_siswa_id">
<input type="text" data-table="t09_siswanonrutin" data-field="x_siswa_id" name="x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_siswa_id" id="x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_siswa_id" size="30" placeholder="<?php echo ew_HtmlEncode($t09_siswanonrutin->siswa_id->getPlaceHolder()) ?>" value="<?php echo $t09_siswanonrutin->siswa_id->EditValue ?>"<?php echo $t09_siswanonrutin->siswa_id->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="t09_siswanonrutin" data-field="x_siswa_id" name="o<?php echo $t09_siswanonrutin_grid->RowIndex ?>_siswa_id" id="o<?php echo $t09_siswanonrutin_grid->RowIndex ?>_siswa_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutin->siswa_id->OldValue) ?>">
<?php } ?>
<?php if ($t09_siswanonrutin->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($t09_siswanonrutin->siswa_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $t09_siswanonrutin_grid->RowCnt ?>_t09_siswanonrutin_siswa_id" class="form-group t09_siswanonrutin_siswa_id">
<span<?php echo $t09_siswanonrutin->siswa_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t09_siswanonrutin->siswa_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_siswa_id" name="x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_siswa_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutin->siswa_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $t09_siswanonrutin_grid->RowCnt ?>_t09_siswanonrutin_siswa_id" class="form-group t09_siswanonrutin_siswa_id">
<input type="text" data-table="t09_siswanonrutin" data-field="x_siswa_id" name="x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_siswa_id" id="x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_siswa_id" size="30" placeholder="<?php echo ew_HtmlEncode($t09_siswanonrutin->siswa_id->getPlaceHolder()) ?>" value="<?php echo $t09_siswanonrutin->siswa_id->EditValue ?>"<?php echo $t09_siswanonrutin->siswa_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php } ?>
<?php if ($t09_siswanonrutin->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t09_siswanonrutin_grid->RowCnt ?>_t09_siswanonrutin_siswa_id" class="t09_siswanonrutin_siswa_id">
<span<?php echo $t09_siswanonrutin->siswa_id->ViewAttributes() ?>>
<?php echo $t09_siswanonrutin->siswa_id->ListViewValue() ?></span>
</span>
<?php if ($t09_siswanonrutin->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t09_siswanonrutin" data-field="x_siswa_id" name="x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_siswa_id" id="x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_siswa_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutin->siswa_id->FormValue) ?>">
<input type="hidden" data-table="t09_siswanonrutin" data-field="x_siswa_id" name="o<?php echo $t09_siswanonrutin_grid->RowIndex ?>_siswa_id" id="o<?php echo $t09_siswanonrutin_grid->RowIndex ?>_siswa_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutin->siswa_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t09_siswanonrutin" data-field="x_siswa_id" name="ft09_siswanonrutingrid$x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_siswa_id" id="ft09_siswanonrutingrid$x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_siswa_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutin->siswa_id->FormValue) ?>">
<input type="hidden" data-table="t09_siswanonrutin" data-field="x_siswa_id" name="ft09_siswanonrutingrid$o<?php echo $t09_siswanonrutin_grid->RowIndex ?>_siswa_id" id="ft09_siswanonrutingrid$o<?php echo $t09_siswanonrutin_grid->RowIndex ?>_siswa_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutin->siswa_id->OldValue) ?>">
<?php } ?>
<?php } ?>
<a id="<?php echo $t09_siswanonrutin_grid->PageObjName . "_row_" . $t09_siswanonrutin_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($t09_siswanonrutin->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="t09_siswanonrutin" data-field="x_id" name="x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_id" id="x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutin->id->CurrentValue) ?>">
<input type="hidden" data-table="t09_siswanonrutin" data-field="x_id" name="o<?php echo $t09_siswanonrutin_grid->RowIndex ?>_id" id="o<?php echo $t09_siswanonrutin_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutin->id->OldValue) ?>">
<?php } ?>
<?php if ($t09_siswanonrutin->RowType == EW_ROWTYPE_EDIT || $t09_siswanonrutin->CurrentMode == "edit") { ?>
<input type="hidden" data-table="t09_siswanonrutin" data-field="x_id" name="x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_id" id="x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutin->id->CurrentValue) ?>">
<?php } ?>
	<?php if ($t09_siswanonrutin->nonrutin_id->Visible) { // nonrutin_id ?>
		<td data-name="nonrutin_id"<?php echo $t09_siswanonrutin->nonrutin_id->CellAttributes() ?>>
<?php if ($t09_siswanonrutin->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t09_siswanonrutin_grid->RowCnt ?>_t09_siswanonrutin_nonrutin_id" class="form-group t09_siswanonrutin_nonrutin_id">
<select data-table="t09_siswanonrutin" data-field="x_nonrutin_id" data-value-separator="<?php echo $t09_siswanonrutin->nonrutin_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_nonrutin_id" name="x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_nonrutin_id"<?php echo $t09_siswanonrutin->nonrutin_id->EditAttributes() ?>>
<?php echo $t09_siswanonrutin->nonrutin_id->SelectOptionListHtml("x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_nonrutin_id") ?>
</select>
<input type="hidden" name="s_x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_nonrutin_id" id="s_x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_nonrutin_id" value="<?php echo $t09_siswanonrutin->nonrutin_id->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="t09_siswanonrutin" data-field="x_nonrutin_id" name="o<?php echo $t09_siswanonrutin_grid->RowIndex ?>_nonrutin_id" id="o<?php echo $t09_siswanonrutin_grid->RowIndex ?>_nonrutin_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutin->nonrutin_id->OldValue) ?>">
<?php } ?>
<?php if ($t09_siswanonrutin->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t09_siswanonrutin_grid->RowCnt ?>_t09_siswanonrutin_nonrutin_id" class="form-group t09_siswanonrutin_nonrutin_id">
<select data-table="t09_siswanonrutin" data-field="x_nonrutin_id" data-value-separator="<?php echo $t09_siswanonrutin->nonrutin_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_nonrutin_id" name="x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_nonrutin_id"<?php echo $t09_siswanonrutin->nonrutin_id->EditAttributes() ?>>
<?php echo $t09_siswanonrutin->nonrutin_id->SelectOptionListHtml("x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_nonrutin_id") ?>
</select>
<input type="hidden" name="s_x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_nonrutin_id" id="s_x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_nonrutin_id" value="<?php echo $t09_siswanonrutin->nonrutin_id->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($t09_siswanonrutin->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t09_siswanonrutin_grid->RowCnt ?>_t09_siswanonrutin_nonrutin_id" class="t09_siswanonrutin_nonrutin_id">
<span<?php echo $t09_siswanonrutin->nonrutin_id->ViewAttributes() ?>>
<?php echo $t09_siswanonrutin->nonrutin_id->ListViewValue() ?></span>
</span>
<?php if ($t09_siswanonrutin->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t09_siswanonrutin" data-field="x_nonrutin_id" name="x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_nonrutin_id" id="x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_nonrutin_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutin->nonrutin_id->FormValue) ?>">
<input type="hidden" data-table="t09_siswanonrutin" data-field="x_nonrutin_id" name="o<?php echo $t09_siswanonrutin_grid->RowIndex ?>_nonrutin_id" id="o<?php echo $t09_siswanonrutin_grid->RowIndex ?>_nonrutin_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutin->nonrutin_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t09_siswanonrutin" data-field="x_nonrutin_id" name="ft09_siswanonrutingrid$x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_nonrutin_id" id="ft09_siswanonrutingrid$x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_nonrutin_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutin->nonrutin_id->FormValue) ?>">
<input type="hidden" data-table="t09_siswanonrutin" data-field="x_nonrutin_id" name="ft09_siswanonrutingrid$o<?php echo $t09_siswanonrutin_grid->RowIndex ?>_nonrutin_id" id="ft09_siswanonrutingrid$o<?php echo $t09_siswanonrutin_grid->RowIndex ?>_nonrutin_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutin->nonrutin_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t09_siswanonrutin->Nilai->Visible) { // Nilai ?>
		<td data-name="Nilai"<?php echo $t09_siswanonrutin->Nilai->CellAttributes() ?>>
<?php if ($t09_siswanonrutin->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t09_siswanonrutin_grid->RowCnt ?>_t09_siswanonrutin_Nilai" class="form-group t09_siswanonrutin_Nilai">
<input type="text" data-table="t09_siswanonrutin" data-field="x_Nilai" name="x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_Nilai" id="x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_Nilai" size="30" placeholder="<?php echo ew_HtmlEncode($t09_siswanonrutin->Nilai->getPlaceHolder()) ?>" value="<?php echo $t09_siswanonrutin->Nilai->EditValue ?>"<?php echo $t09_siswanonrutin->Nilai->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t09_siswanonrutin" data-field="x_Nilai" name="o<?php echo $t09_siswanonrutin_grid->RowIndex ?>_Nilai" id="o<?php echo $t09_siswanonrutin_grid->RowIndex ?>_Nilai" value="<?php echo ew_HtmlEncode($t09_siswanonrutin->Nilai->OldValue) ?>">
<?php } ?>
<?php if ($t09_siswanonrutin->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t09_siswanonrutin_grid->RowCnt ?>_t09_siswanonrutin_Nilai" class="form-group t09_siswanonrutin_Nilai">
<input type="text" data-table="t09_siswanonrutin" data-field="x_Nilai" name="x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_Nilai" id="x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_Nilai" size="30" placeholder="<?php echo ew_HtmlEncode($t09_siswanonrutin->Nilai->getPlaceHolder()) ?>" value="<?php echo $t09_siswanonrutin->Nilai->EditValue ?>"<?php echo $t09_siswanonrutin->Nilai->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t09_siswanonrutin->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t09_siswanonrutin_grid->RowCnt ?>_t09_siswanonrutin_Nilai" class="t09_siswanonrutin_Nilai">
<span<?php echo $t09_siswanonrutin->Nilai->ViewAttributes() ?>>
<?php echo $t09_siswanonrutin->Nilai->ListViewValue() ?></span>
</span>
<?php if ($t09_siswanonrutin->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t09_siswanonrutin" data-field="x_Nilai" name="x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_Nilai" id="x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_Nilai" value="<?php echo ew_HtmlEncode($t09_siswanonrutin->Nilai->FormValue) ?>">
<input type="hidden" data-table="t09_siswanonrutin" data-field="x_Nilai" name="o<?php echo $t09_siswanonrutin_grid->RowIndex ?>_Nilai" id="o<?php echo $t09_siswanonrutin_grid->RowIndex ?>_Nilai" value="<?php echo ew_HtmlEncode($t09_siswanonrutin->Nilai->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t09_siswanonrutin" data-field="x_Nilai" name="ft09_siswanonrutingrid$x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_Nilai" id="ft09_siswanonrutingrid$x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_Nilai" value="<?php echo ew_HtmlEncode($t09_siswanonrutin->Nilai->FormValue) ?>">
<input type="hidden" data-table="t09_siswanonrutin" data-field="x_Nilai" name="ft09_siswanonrutingrid$o<?php echo $t09_siswanonrutin_grid->RowIndex ?>_Nilai" id="ft09_siswanonrutingrid$o<?php echo $t09_siswanonrutin_grid->RowIndex ?>_Nilai" value="<?php echo ew_HtmlEncode($t09_siswanonrutin->Nilai->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t09_siswanonrutin_grid->ListOptions->Render("body", "right", $t09_siswanonrutin_grid->RowCnt);
?>
	</tr>
<?php if ($t09_siswanonrutin->RowType == EW_ROWTYPE_ADD || $t09_siswanonrutin->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ft09_siswanonrutingrid.UpdateOpts(<?php echo $t09_siswanonrutin_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($t09_siswanonrutin->CurrentAction <> "gridadd" || $t09_siswanonrutin->CurrentMode == "copy")
		if (!$t09_siswanonrutin_grid->Recordset->EOF) $t09_siswanonrutin_grid->Recordset->MoveNext();
}
?>
<?php
	if ($t09_siswanonrutin->CurrentMode == "add" || $t09_siswanonrutin->CurrentMode == "copy" || $t09_siswanonrutin->CurrentMode == "edit") {
		$t09_siswanonrutin_grid->RowIndex = '$rowindex$';
		$t09_siswanonrutin_grid->LoadDefaultValues();

		// Set row properties
		$t09_siswanonrutin->ResetAttrs();
		$t09_siswanonrutin->RowAttrs = array_merge($t09_siswanonrutin->RowAttrs, array('data-rowindex'=>$t09_siswanonrutin_grid->RowIndex, 'id'=>'r0_t09_siswanonrutin', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($t09_siswanonrutin->RowAttrs["class"], "ewTemplate");
		$t09_siswanonrutin->RowType = EW_ROWTYPE_ADD;

		// Render row
		$t09_siswanonrutin_grid->RenderRow();

		// Render list options
		$t09_siswanonrutin_grid->RenderListOptions();
		$t09_siswanonrutin_grid->StartRowCnt = 0;
?>
	<tr<?php echo $t09_siswanonrutin->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t09_siswanonrutin_grid->ListOptions->Render("body", "left", $t09_siswanonrutin_grid->RowIndex);
?>
	<?php if ($t09_siswanonrutin->siswa_id->Visible) { // siswa_id ?>
		<td data-name="siswa_id">
<?php if ($t09_siswanonrutin->CurrentAction <> "F") { ?>
<?php if ($t09_siswanonrutin->siswa_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_t09_siswanonrutin_siswa_id" class="form-group t09_siswanonrutin_siswa_id">
<span<?php echo $t09_siswanonrutin->siswa_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t09_siswanonrutin->siswa_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_siswa_id" name="x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_siswa_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutin->siswa_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_t09_siswanonrutin_siswa_id" class="form-group t09_siswanonrutin_siswa_id">
<input type="text" data-table="t09_siswanonrutin" data-field="x_siswa_id" name="x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_siswa_id" id="x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_siswa_id" size="30" placeholder="<?php echo ew_HtmlEncode($t09_siswanonrutin->siswa_id->getPlaceHolder()) ?>" value="<?php echo $t09_siswanonrutin->siswa_id->EditValue ?>"<?php echo $t09_siswanonrutin->siswa_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_t09_siswanonrutin_siswa_id" class="form-group t09_siswanonrutin_siswa_id">
<span<?php echo $t09_siswanonrutin->siswa_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t09_siswanonrutin->siswa_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t09_siswanonrutin" data-field="x_siswa_id" name="x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_siswa_id" id="x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_siswa_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutin->siswa_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t09_siswanonrutin" data-field="x_siswa_id" name="o<?php echo $t09_siswanonrutin_grid->RowIndex ?>_siswa_id" id="o<?php echo $t09_siswanonrutin_grid->RowIndex ?>_siswa_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutin->siswa_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t09_siswanonrutin->nonrutin_id->Visible) { // nonrutin_id ?>
		<td data-name="nonrutin_id">
<?php if ($t09_siswanonrutin->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t09_siswanonrutin_nonrutin_id" class="form-group t09_siswanonrutin_nonrutin_id">
<select data-table="t09_siswanonrutin" data-field="x_nonrutin_id" data-value-separator="<?php echo $t09_siswanonrutin->nonrutin_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_nonrutin_id" name="x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_nonrutin_id"<?php echo $t09_siswanonrutin->nonrutin_id->EditAttributes() ?>>
<?php echo $t09_siswanonrutin->nonrutin_id->SelectOptionListHtml("x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_nonrutin_id") ?>
</select>
<input type="hidden" name="s_x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_nonrutin_id" id="s_x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_nonrutin_id" value="<?php echo $t09_siswanonrutin->nonrutin_id->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_t09_siswanonrutin_nonrutin_id" class="form-group t09_siswanonrutin_nonrutin_id">
<span<?php echo $t09_siswanonrutin->nonrutin_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t09_siswanonrutin->nonrutin_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t09_siswanonrutin" data-field="x_nonrutin_id" name="x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_nonrutin_id" id="x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_nonrutin_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutin->nonrutin_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t09_siswanonrutin" data-field="x_nonrutin_id" name="o<?php echo $t09_siswanonrutin_grid->RowIndex ?>_nonrutin_id" id="o<?php echo $t09_siswanonrutin_grid->RowIndex ?>_nonrutin_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutin->nonrutin_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t09_siswanonrutin->Nilai->Visible) { // Nilai ?>
		<td data-name="Nilai">
<?php if ($t09_siswanonrutin->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t09_siswanonrutin_Nilai" class="form-group t09_siswanonrutin_Nilai">
<input type="text" data-table="t09_siswanonrutin" data-field="x_Nilai" name="x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_Nilai" id="x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_Nilai" size="30" placeholder="<?php echo ew_HtmlEncode($t09_siswanonrutin->Nilai->getPlaceHolder()) ?>" value="<?php echo $t09_siswanonrutin->Nilai->EditValue ?>"<?php echo $t09_siswanonrutin->Nilai->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t09_siswanonrutin_Nilai" class="form-group t09_siswanonrutin_Nilai">
<span<?php echo $t09_siswanonrutin->Nilai->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t09_siswanonrutin->Nilai->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t09_siswanonrutin" data-field="x_Nilai" name="x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_Nilai" id="x<?php echo $t09_siswanonrutin_grid->RowIndex ?>_Nilai" value="<?php echo ew_HtmlEncode($t09_siswanonrutin->Nilai->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t09_siswanonrutin" data-field="x_Nilai" name="o<?php echo $t09_siswanonrutin_grid->RowIndex ?>_Nilai" id="o<?php echo $t09_siswanonrutin_grid->RowIndex ?>_Nilai" value="<?php echo ew_HtmlEncode($t09_siswanonrutin->Nilai->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t09_siswanonrutin_grid->ListOptions->Render("body", "right", $t09_siswanonrutin_grid->RowCnt);
?>
<script type="text/javascript">
ft09_siswanonrutingrid.UpdateOpts(<?php echo $t09_siswanonrutin_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($t09_siswanonrutin->CurrentMode == "add" || $t09_siswanonrutin->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $t09_siswanonrutin_grid->FormKeyCountName ?>" id="<?php echo $t09_siswanonrutin_grid->FormKeyCountName ?>" value="<?php echo $t09_siswanonrutin_grid->KeyCount ?>">
<?php echo $t09_siswanonrutin_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t09_siswanonrutin->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $t09_siswanonrutin_grid->FormKeyCountName ?>" id="<?php echo $t09_siswanonrutin_grid->FormKeyCountName ?>" value="<?php echo $t09_siswanonrutin_grid->KeyCount ?>">
<?php echo $t09_siswanonrutin_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t09_siswanonrutin->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="ft09_siswanonrutingrid">
</div>
<?php

// Close recordset
if ($t09_siswanonrutin_grid->Recordset)
	$t09_siswanonrutin_grid->Recordset->Close();
?>
<?php if ($t09_siswanonrutin_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($t09_siswanonrutin_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($t09_siswanonrutin_grid->TotalRecs == 0 && $t09_siswanonrutin->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t09_siswanonrutin_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($t09_siswanonrutin->Export == "") { ?>
<script type="text/javascript">
ft09_siswanonrutingrid.Init();
</script>
<?php } ?>
<?php
$t09_siswanonrutin_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$t09_siswanonrutin_grid->Page_Terminate();
?>
