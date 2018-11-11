<?php

// Create page object
if (!isset($t03_kelas_grid)) $t03_kelas_grid = new ct03_kelas_grid();

// Page init
$t03_kelas_grid->Page_Init();

// Page main
$t03_kelas_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t03_kelas_grid->Page_Render();
?>
<?php if ($t03_kelas->Export == "") { ?>
<script type="text/javascript">

// Form object
var ft03_kelasgrid = new ew_Form("ft03_kelasgrid", "grid");
ft03_kelasgrid.FormKeyCountName = '<?php echo $t03_kelas_grid->FormKeyCountName ?>';

// Validate form
ft03_kelasgrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_sekolah_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t03_kelas->sekolah_id->FldCaption(), $t03_kelas->sekolah_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Kelas");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t03_kelas->Kelas->FldCaption(), $t03_kelas->Kelas->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
ft03_kelasgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "sekolah_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Kelas", false)) return false;
	return true;
}

// Form_CustomValidate event
ft03_kelasgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft03_kelasgrid.ValidateRequired = true;
<?php } else { ?>
ft03_kelasgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft03_kelasgrid.Lists["x_sekolah_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_Sekolah","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t02_sekolah"};

// Form object for search
</script>
<?php } ?>
<?php
if ($t03_kelas->CurrentAction == "gridadd") {
	if ($t03_kelas->CurrentMode == "copy") {
		$bSelectLimit = $t03_kelas_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$t03_kelas_grid->TotalRecs = $t03_kelas->SelectRecordCount();
			$t03_kelas_grid->Recordset = $t03_kelas_grid->LoadRecordset($t03_kelas_grid->StartRec-1, $t03_kelas_grid->DisplayRecs);
		} else {
			if ($t03_kelas_grid->Recordset = $t03_kelas_grid->LoadRecordset())
				$t03_kelas_grid->TotalRecs = $t03_kelas_grid->Recordset->RecordCount();
		}
		$t03_kelas_grid->StartRec = 1;
		$t03_kelas_grid->DisplayRecs = $t03_kelas_grid->TotalRecs;
	} else {
		$t03_kelas->CurrentFilter = "0=1";
		$t03_kelas_grid->StartRec = 1;
		$t03_kelas_grid->DisplayRecs = $t03_kelas->GridAddRowCount;
	}
	$t03_kelas_grid->TotalRecs = $t03_kelas_grid->DisplayRecs;
	$t03_kelas_grid->StopRec = $t03_kelas_grid->DisplayRecs;
} else {
	$bSelectLimit = $t03_kelas_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($t03_kelas_grid->TotalRecs <= 0)
			$t03_kelas_grid->TotalRecs = $t03_kelas->SelectRecordCount();
	} else {
		if (!$t03_kelas_grid->Recordset && ($t03_kelas_grid->Recordset = $t03_kelas_grid->LoadRecordset()))
			$t03_kelas_grid->TotalRecs = $t03_kelas_grid->Recordset->RecordCount();
	}
	$t03_kelas_grid->StartRec = 1;
	$t03_kelas_grid->DisplayRecs = $t03_kelas_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$t03_kelas_grid->Recordset = $t03_kelas_grid->LoadRecordset($t03_kelas_grid->StartRec-1, $t03_kelas_grid->DisplayRecs);

	// Set no record found message
	if ($t03_kelas->CurrentAction == "" && $t03_kelas_grid->TotalRecs == 0) {
		if ($t03_kelas_grid->SearchWhere == "0=101")
			$t03_kelas_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$t03_kelas_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$t03_kelas_grid->RenderOtherOptions();
?>
<?php $t03_kelas_grid->ShowPageHeader(); ?>
<?php
$t03_kelas_grid->ShowMessage();
?>
<?php if ($t03_kelas_grid->TotalRecs > 0 || $t03_kelas->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid t03_kelas">
<div id="ft03_kelasgrid" class="ewForm form-inline">
<div id="gmp_t03_kelas" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_t03_kelasgrid" class="table ewTable">
<?php echo $t03_kelas->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$t03_kelas_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$t03_kelas_grid->RenderListOptions();

// Render list options (header, left)
$t03_kelas_grid->ListOptions->Render("header", "left");
?>
<?php if ($t03_kelas->sekolah_id->Visible) { // sekolah_id ?>
	<?php if ($t03_kelas->SortUrl($t03_kelas->sekolah_id) == "") { ?>
		<th data-name="sekolah_id"><div id="elh_t03_kelas_sekolah_id" class="t03_kelas_sekolah_id"><div class="ewTableHeaderCaption"><?php echo $t03_kelas->sekolah_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="sekolah_id"><div><div id="elh_t03_kelas_sekolah_id" class="t03_kelas_sekolah_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t03_kelas->sekolah_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t03_kelas->sekolah_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t03_kelas->sekolah_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t03_kelas->Kelas->Visible) { // Kelas ?>
	<?php if ($t03_kelas->SortUrl($t03_kelas->Kelas) == "") { ?>
		<th data-name="Kelas"><div id="elh_t03_kelas_Kelas" class="t03_kelas_Kelas"><div class="ewTableHeaderCaption"><?php echo $t03_kelas->Kelas->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Kelas"><div><div id="elh_t03_kelas_Kelas" class="t03_kelas_Kelas">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t03_kelas->Kelas->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t03_kelas->Kelas->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t03_kelas->Kelas->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$t03_kelas_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$t03_kelas_grid->StartRec = 1;
$t03_kelas_grid->StopRec = $t03_kelas_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($t03_kelas_grid->FormKeyCountName) && ($t03_kelas->CurrentAction == "gridadd" || $t03_kelas->CurrentAction == "gridedit" || $t03_kelas->CurrentAction == "F")) {
		$t03_kelas_grid->KeyCount = $objForm->GetValue($t03_kelas_grid->FormKeyCountName);
		$t03_kelas_grid->StopRec = $t03_kelas_grid->StartRec + $t03_kelas_grid->KeyCount - 1;
	}
}
$t03_kelas_grid->RecCnt = $t03_kelas_grid->StartRec - 1;
if ($t03_kelas_grid->Recordset && !$t03_kelas_grid->Recordset->EOF) {
	$t03_kelas_grid->Recordset->MoveFirst();
	$bSelectLimit = $t03_kelas_grid->UseSelectLimit;
	if (!$bSelectLimit && $t03_kelas_grid->StartRec > 1)
		$t03_kelas_grid->Recordset->Move($t03_kelas_grid->StartRec - 1);
} elseif (!$t03_kelas->AllowAddDeleteRow && $t03_kelas_grid->StopRec == 0) {
	$t03_kelas_grid->StopRec = $t03_kelas->GridAddRowCount;
}

// Initialize aggregate
$t03_kelas->RowType = EW_ROWTYPE_AGGREGATEINIT;
$t03_kelas->ResetAttrs();
$t03_kelas_grid->RenderRow();
if ($t03_kelas->CurrentAction == "gridadd")
	$t03_kelas_grid->RowIndex = 0;
if ($t03_kelas->CurrentAction == "gridedit")
	$t03_kelas_grid->RowIndex = 0;
while ($t03_kelas_grid->RecCnt < $t03_kelas_grid->StopRec) {
	$t03_kelas_grid->RecCnt++;
	if (intval($t03_kelas_grid->RecCnt) >= intval($t03_kelas_grid->StartRec)) {
		$t03_kelas_grid->RowCnt++;
		if ($t03_kelas->CurrentAction == "gridadd" || $t03_kelas->CurrentAction == "gridedit" || $t03_kelas->CurrentAction == "F") {
			$t03_kelas_grid->RowIndex++;
			$objForm->Index = $t03_kelas_grid->RowIndex;
			if ($objForm->HasValue($t03_kelas_grid->FormActionName))
				$t03_kelas_grid->RowAction = strval($objForm->GetValue($t03_kelas_grid->FormActionName));
			elseif ($t03_kelas->CurrentAction == "gridadd")
				$t03_kelas_grid->RowAction = "insert";
			else
				$t03_kelas_grid->RowAction = "";
		}

		// Set up key count
		$t03_kelas_grid->KeyCount = $t03_kelas_grid->RowIndex;

		// Init row class and style
		$t03_kelas->ResetAttrs();
		$t03_kelas->CssClass = "";
		if ($t03_kelas->CurrentAction == "gridadd") {
			if ($t03_kelas->CurrentMode == "copy") {
				$t03_kelas_grid->LoadRowValues($t03_kelas_grid->Recordset); // Load row values
				$t03_kelas_grid->SetRecordKey($t03_kelas_grid->RowOldKey, $t03_kelas_grid->Recordset); // Set old record key
			} else {
				$t03_kelas_grid->LoadDefaultValues(); // Load default values
				$t03_kelas_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$t03_kelas_grid->LoadRowValues($t03_kelas_grid->Recordset); // Load row values
		}
		$t03_kelas->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($t03_kelas->CurrentAction == "gridadd") // Grid add
			$t03_kelas->RowType = EW_ROWTYPE_ADD; // Render add
		if ($t03_kelas->CurrentAction == "gridadd" && $t03_kelas->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$t03_kelas_grid->RestoreCurrentRowFormValues($t03_kelas_grid->RowIndex); // Restore form values
		if ($t03_kelas->CurrentAction == "gridedit") { // Grid edit
			if ($t03_kelas->EventCancelled) {
				$t03_kelas_grid->RestoreCurrentRowFormValues($t03_kelas_grid->RowIndex); // Restore form values
			}
			if ($t03_kelas_grid->RowAction == "insert")
				$t03_kelas->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$t03_kelas->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($t03_kelas->CurrentAction == "gridedit" && ($t03_kelas->RowType == EW_ROWTYPE_EDIT || $t03_kelas->RowType == EW_ROWTYPE_ADD) && $t03_kelas->EventCancelled) // Update failed
			$t03_kelas_grid->RestoreCurrentRowFormValues($t03_kelas_grid->RowIndex); // Restore form values
		if ($t03_kelas->RowType == EW_ROWTYPE_EDIT) // Edit row
			$t03_kelas_grid->EditRowCnt++;
		if ($t03_kelas->CurrentAction == "F") // Confirm row
			$t03_kelas_grid->RestoreCurrentRowFormValues($t03_kelas_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$t03_kelas->RowAttrs = array_merge($t03_kelas->RowAttrs, array('data-rowindex'=>$t03_kelas_grid->RowCnt, 'id'=>'r' . $t03_kelas_grid->RowCnt . '_t03_kelas', 'data-rowtype'=>$t03_kelas->RowType));

		// Render row
		$t03_kelas_grid->RenderRow();

		// Render list options
		$t03_kelas_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($t03_kelas_grid->RowAction <> "delete" && $t03_kelas_grid->RowAction <> "insertdelete" && !($t03_kelas_grid->RowAction == "insert" && $t03_kelas->CurrentAction == "F" && $t03_kelas_grid->EmptyRow())) {
?>
	<tr<?php echo $t03_kelas->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t03_kelas_grid->ListOptions->Render("body", "left", $t03_kelas_grid->RowCnt);
?>
	<?php if ($t03_kelas->sekolah_id->Visible) { // sekolah_id ?>
		<td data-name="sekolah_id"<?php echo $t03_kelas->sekolah_id->CellAttributes() ?>>
<?php if ($t03_kelas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($t03_kelas->sekolah_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $t03_kelas_grid->RowCnt ?>_t03_kelas_sekolah_id" class="form-group t03_kelas_sekolah_id">
<span<?php echo $t03_kelas->sekolah_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t03_kelas->sekolah_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t03_kelas_grid->RowIndex ?>_sekolah_id" name="x<?php echo $t03_kelas_grid->RowIndex ?>_sekolah_id" value="<?php echo ew_HtmlEncode($t03_kelas->sekolah_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $t03_kelas_grid->RowCnt ?>_t03_kelas_sekolah_id" class="form-group t03_kelas_sekolah_id">
<select data-table="t03_kelas" data-field="x_sekolah_id" data-value-separator="<?php echo $t03_kelas->sekolah_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $t03_kelas_grid->RowIndex ?>_sekolah_id" name="x<?php echo $t03_kelas_grid->RowIndex ?>_sekolah_id"<?php echo $t03_kelas->sekolah_id->EditAttributes() ?>>
<?php echo $t03_kelas->sekolah_id->SelectOptionListHtml("x<?php echo $t03_kelas_grid->RowIndex ?>_sekolah_id") ?>
</select>
<input type="hidden" name="s_x<?php echo $t03_kelas_grid->RowIndex ?>_sekolah_id" id="s_x<?php echo $t03_kelas_grid->RowIndex ?>_sekolah_id" value="<?php echo $t03_kelas->sekolah_id->LookupFilterQuery() ?>">
</span>
<?php } ?>
<input type="hidden" data-table="t03_kelas" data-field="x_sekolah_id" name="o<?php echo $t03_kelas_grid->RowIndex ?>_sekolah_id" id="o<?php echo $t03_kelas_grid->RowIndex ?>_sekolah_id" value="<?php echo ew_HtmlEncode($t03_kelas->sekolah_id->OldValue) ?>">
<?php } ?>
<?php if ($t03_kelas->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($t03_kelas->sekolah_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $t03_kelas_grid->RowCnt ?>_t03_kelas_sekolah_id" class="form-group t03_kelas_sekolah_id">
<span<?php echo $t03_kelas->sekolah_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t03_kelas->sekolah_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t03_kelas_grid->RowIndex ?>_sekolah_id" name="x<?php echo $t03_kelas_grid->RowIndex ?>_sekolah_id" value="<?php echo ew_HtmlEncode($t03_kelas->sekolah_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $t03_kelas_grid->RowCnt ?>_t03_kelas_sekolah_id" class="form-group t03_kelas_sekolah_id">
<select data-table="t03_kelas" data-field="x_sekolah_id" data-value-separator="<?php echo $t03_kelas->sekolah_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $t03_kelas_grid->RowIndex ?>_sekolah_id" name="x<?php echo $t03_kelas_grid->RowIndex ?>_sekolah_id"<?php echo $t03_kelas->sekolah_id->EditAttributes() ?>>
<?php echo $t03_kelas->sekolah_id->SelectOptionListHtml("x<?php echo $t03_kelas_grid->RowIndex ?>_sekolah_id") ?>
</select>
<input type="hidden" name="s_x<?php echo $t03_kelas_grid->RowIndex ?>_sekolah_id" id="s_x<?php echo $t03_kelas_grid->RowIndex ?>_sekolah_id" value="<?php echo $t03_kelas->sekolah_id->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } ?>
<?php if ($t03_kelas->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t03_kelas_grid->RowCnt ?>_t03_kelas_sekolah_id" class="t03_kelas_sekolah_id">
<span<?php echo $t03_kelas->sekolah_id->ViewAttributes() ?>>
<?php echo $t03_kelas->sekolah_id->ListViewValue() ?></span>
</span>
<?php if ($t03_kelas->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t03_kelas" data-field="x_sekolah_id" name="x<?php echo $t03_kelas_grid->RowIndex ?>_sekolah_id" id="x<?php echo $t03_kelas_grid->RowIndex ?>_sekolah_id" value="<?php echo ew_HtmlEncode($t03_kelas->sekolah_id->FormValue) ?>">
<input type="hidden" data-table="t03_kelas" data-field="x_sekolah_id" name="o<?php echo $t03_kelas_grid->RowIndex ?>_sekolah_id" id="o<?php echo $t03_kelas_grid->RowIndex ?>_sekolah_id" value="<?php echo ew_HtmlEncode($t03_kelas->sekolah_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t03_kelas" data-field="x_sekolah_id" name="ft03_kelasgrid$x<?php echo $t03_kelas_grid->RowIndex ?>_sekolah_id" id="ft03_kelasgrid$x<?php echo $t03_kelas_grid->RowIndex ?>_sekolah_id" value="<?php echo ew_HtmlEncode($t03_kelas->sekolah_id->FormValue) ?>">
<input type="hidden" data-table="t03_kelas" data-field="x_sekolah_id" name="ft03_kelasgrid$o<?php echo $t03_kelas_grid->RowIndex ?>_sekolah_id" id="ft03_kelasgrid$o<?php echo $t03_kelas_grid->RowIndex ?>_sekolah_id" value="<?php echo ew_HtmlEncode($t03_kelas->sekolah_id->OldValue) ?>">
<?php } ?>
<?php } ?>
<a id="<?php echo $t03_kelas_grid->PageObjName . "_row_" . $t03_kelas_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($t03_kelas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="t03_kelas" data-field="x_id" name="x<?php echo $t03_kelas_grid->RowIndex ?>_id" id="x<?php echo $t03_kelas_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t03_kelas->id->CurrentValue) ?>">
<input type="hidden" data-table="t03_kelas" data-field="x_id" name="o<?php echo $t03_kelas_grid->RowIndex ?>_id" id="o<?php echo $t03_kelas_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t03_kelas->id->OldValue) ?>">
<?php } ?>
<?php if ($t03_kelas->RowType == EW_ROWTYPE_EDIT || $t03_kelas->CurrentMode == "edit") { ?>
<input type="hidden" data-table="t03_kelas" data-field="x_id" name="x<?php echo $t03_kelas_grid->RowIndex ?>_id" id="x<?php echo $t03_kelas_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t03_kelas->id->CurrentValue) ?>">
<?php } ?>
	<?php if ($t03_kelas->Kelas->Visible) { // Kelas ?>
		<td data-name="Kelas"<?php echo $t03_kelas->Kelas->CellAttributes() ?>>
<?php if ($t03_kelas->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t03_kelas_grid->RowCnt ?>_t03_kelas_Kelas" class="form-group t03_kelas_Kelas">
<input type="text" data-table="t03_kelas" data-field="x_Kelas" name="x<?php echo $t03_kelas_grid->RowIndex ?>_Kelas" id="x<?php echo $t03_kelas_grid->RowIndex ?>_Kelas" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($t03_kelas->Kelas->getPlaceHolder()) ?>" value="<?php echo $t03_kelas->Kelas->EditValue ?>"<?php echo $t03_kelas->Kelas->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t03_kelas" data-field="x_Kelas" name="o<?php echo $t03_kelas_grid->RowIndex ?>_Kelas" id="o<?php echo $t03_kelas_grid->RowIndex ?>_Kelas" value="<?php echo ew_HtmlEncode($t03_kelas->Kelas->OldValue) ?>">
<?php } ?>
<?php if ($t03_kelas->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t03_kelas_grid->RowCnt ?>_t03_kelas_Kelas" class="form-group t03_kelas_Kelas">
<input type="text" data-table="t03_kelas" data-field="x_Kelas" name="x<?php echo $t03_kelas_grid->RowIndex ?>_Kelas" id="x<?php echo $t03_kelas_grid->RowIndex ?>_Kelas" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($t03_kelas->Kelas->getPlaceHolder()) ?>" value="<?php echo $t03_kelas->Kelas->EditValue ?>"<?php echo $t03_kelas->Kelas->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t03_kelas->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t03_kelas_grid->RowCnt ?>_t03_kelas_Kelas" class="t03_kelas_Kelas">
<span<?php echo $t03_kelas->Kelas->ViewAttributes() ?>>
<?php echo $t03_kelas->Kelas->ListViewValue() ?></span>
</span>
<?php if ($t03_kelas->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t03_kelas" data-field="x_Kelas" name="x<?php echo $t03_kelas_grid->RowIndex ?>_Kelas" id="x<?php echo $t03_kelas_grid->RowIndex ?>_Kelas" value="<?php echo ew_HtmlEncode($t03_kelas->Kelas->FormValue) ?>">
<input type="hidden" data-table="t03_kelas" data-field="x_Kelas" name="o<?php echo $t03_kelas_grid->RowIndex ?>_Kelas" id="o<?php echo $t03_kelas_grid->RowIndex ?>_Kelas" value="<?php echo ew_HtmlEncode($t03_kelas->Kelas->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t03_kelas" data-field="x_Kelas" name="ft03_kelasgrid$x<?php echo $t03_kelas_grid->RowIndex ?>_Kelas" id="ft03_kelasgrid$x<?php echo $t03_kelas_grid->RowIndex ?>_Kelas" value="<?php echo ew_HtmlEncode($t03_kelas->Kelas->FormValue) ?>">
<input type="hidden" data-table="t03_kelas" data-field="x_Kelas" name="ft03_kelasgrid$o<?php echo $t03_kelas_grid->RowIndex ?>_Kelas" id="ft03_kelasgrid$o<?php echo $t03_kelas_grid->RowIndex ?>_Kelas" value="<?php echo ew_HtmlEncode($t03_kelas->Kelas->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t03_kelas_grid->ListOptions->Render("body", "right", $t03_kelas_grid->RowCnt);
?>
	</tr>
<?php if ($t03_kelas->RowType == EW_ROWTYPE_ADD || $t03_kelas->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ft03_kelasgrid.UpdateOpts(<?php echo $t03_kelas_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($t03_kelas->CurrentAction <> "gridadd" || $t03_kelas->CurrentMode == "copy")
		if (!$t03_kelas_grid->Recordset->EOF) $t03_kelas_grid->Recordset->MoveNext();
}
?>
<?php
	if ($t03_kelas->CurrentMode == "add" || $t03_kelas->CurrentMode == "copy" || $t03_kelas->CurrentMode == "edit") {
		$t03_kelas_grid->RowIndex = '$rowindex$';
		$t03_kelas_grid->LoadDefaultValues();

		// Set row properties
		$t03_kelas->ResetAttrs();
		$t03_kelas->RowAttrs = array_merge($t03_kelas->RowAttrs, array('data-rowindex'=>$t03_kelas_grid->RowIndex, 'id'=>'r0_t03_kelas', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($t03_kelas->RowAttrs["class"], "ewTemplate");
		$t03_kelas->RowType = EW_ROWTYPE_ADD;

		// Render row
		$t03_kelas_grid->RenderRow();

		// Render list options
		$t03_kelas_grid->RenderListOptions();
		$t03_kelas_grid->StartRowCnt = 0;
?>
	<tr<?php echo $t03_kelas->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t03_kelas_grid->ListOptions->Render("body", "left", $t03_kelas_grid->RowIndex);
?>
	<?php if ($t03_kelas->sekolah_id->Visible) { // sekolah_id ?>
		<td data-name="sekolah_id">
<?php if ($t03_kelas->CurrentAction <> "F") { ?>
<?php if ($t03_kelas->sekolah_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_t03_kelas_sekolah_id" class="form-group t03_kelas_sekolah_id">
<span<?php echo $t03_kelas->sekolah_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t03_kelas->sekolah_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t03_kelas_grid->RowIndex ?>_sekolah_id" name="x<?php echo $t03_kelas_grid->RowIndex ?>_sekolah_id" value="<?php echo ew_HtmlEncode($t03_kelas->sekolah_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_t03_kelas_sekolah_id" class="form-group t03_kelas_sekolah_id">
<select data-table="t03_kelas" data-field="x_sekolah_id" data-value-separator="<?php echo $t03_kelas->sekolah_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $t03_kelas_grid->RowIndex ?>_sekolah_id" name="x<?php echo $t03_kelas_grid->RowIndex ?>_sekolah_id"<?php echo $t03_kelas->sekolah_id->EditAttributes() ?>>
<?php echo $t03_kelas->sekolah_id->SelectOptionListHtml("x<?php echo $t03_kelas_grid->RowIndex ?>_sekolah_id") ?>
</select>
<input type="hidden" name="s_x<?php echo $t03_kelas_grid->RowIndex ?>_sekolah_id" id="s_x<?php echo $t03_kelas_grid->RowIndex ?>_sekolah_id" value="<?php echo $t03_kelas->sekolah_id->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_t03_kelas_sekolah_id" class="form-group t03_kelas_sekolah_id">
<span<?php echo $t03_kelas->sekolah_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t03_kelas->sekolah_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t03_kelas" data-field="x_sekolah_id" name="x<?php echo $t03_kelas_grid->RowIndex ?>_sekolah_id" id="x<?php echo $t03_kelas_grid->RowIndex ?>_sekolah_id" value="<?php echo ew_HtmlEncode($t03_kelas->sekolah_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t03_kelas" data-field="x_sekolah_id" name="o<?php echo $t03_kelas_grid->RowIndex ?>_sekolah_id" id="o<?php echo $t03_kelas_grid->RowIndex ?>_sekolah_id" value="<?php echo ew_HtmlEncode($t03_kelas->sekolah_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t03_kelas->Kelas->Visible) { // Kelas ?>
		<td data-name="Kelas">
<?php if ($t03_kelas->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t03_kelas_Kelas" class="form-group t03_kelas_Kelas">
<input type="text" data-table="t03_kelas" data-field="x_Kelas" name="x<?php echo $t03_kelas_grid->RowIndex ?>_Kelas" id="x<?php echo $t03_kelas_grid->RowIndex ?>_Kelas" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($t03_kelas->Kelas->getPlaceHolder()) ?>" value="<?php echo $t03_kelas->Kelas->EditValue ?>"<?php echo $t03_kelas->Kelas->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t03_kelas_Kelas" class="form-group t03_kelas_Kelas">
<span<?php echo $t03_kelas->Kelas->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t03_kelas->Kelas->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t03_kelas" data-field="x_Kelas" name="x<?php echo $t03_kelas_grid->RowIndex ?>_Kelas" id="x<?php echo $t03_kelas_grid->RowIndex ?>_Kelas" value="<?php echo ew_HtmlEncode($t03_kelas->Kelas->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t03_kelas" data-field="x_Kelas" name="o<?php echo $t03_kelas_grid->RowIndex ?>_Kelas" id="o<?php echo $t03_kelas_grid->RowIndex ?>_Kelas" value="<?php echo ew_HtmlEncode($t03_kelas->Kelas->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t03_kelas_grid->ListOptions->Render("body", "right", $t03_kelas_grid->RowCnt);
?>
<script type="text/javascript">
ft03_kelasgrid.UpdateOpts(<?php echo $t03_kelas_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($t03_kelas->CurrentMode == "add" || $t03_kelas->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $t03_kelas_grid->FormKeyCountName ?>" id="<?php echo $t03_kelas_grid->FormKeyCountName ?>" value="<?php echo $t03_kelas_grid->KeyCount ?>">
<?php echo $t03_kelas_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t03_kelas->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $t03_kelas_grid->FormKeyCountName ?>" id="<?php echo $t03_kelas_grid->FormKeyCountName ?>" value="<?php echo $t03_kelas_grid->KeyCount ?>">
<?php echo $t03_kelas_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t03_kelas->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="ft03_kelasgrid">
</div>
<?php

// Close recordset
if ($t03_kelas_grid->Recordset)
	$t03_kelas_grid->Recordset->Close();
?>
<?php if ($t03_kelas_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($t03_kelas_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($t03_kelas_grid->TotalRecs == 0 && $t03_kelas->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t03_kelas_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($t03_kelas->Export == "") { ?>
<script type="text/javascript">
ft03_kelasgrid.Init();
</script>
<?php } ?>
<?php
$t03_kelas_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$t03_kelas_grid->Page_Terminate();
?>
