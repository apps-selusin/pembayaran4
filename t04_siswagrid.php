<?php

// Create page object
if (!isset($t04_siswa_grid)) $t04_siswa_grid = new ct04_siswa_grid();

// Page init
$t04_siswa_grid->Page_Init();

// Page main
$t04_siswa_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t04_siswa_grid->Page_Render();
?>
<?php if ($t04_siswa->Export == "") { ?>
<script type="text/javascript">

// Form object
var ft04_siswagrid = new ew_Form("ft04_siswagrid", "grid");
ft04_siswagrid.FormKeyCountName = '<?php echo $t04_siswa_grid->FormKeyCountName ?>';

// Validate form
ft04_siswagrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_kelas_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t04_siswa->kelas_id->FldCaption(), $t04_siswa->kelas_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_NIS");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t04_siswa->NIS->FldCaption(), $t04_siswa->NIS->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Nama");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t04_siswa->Nama->FldCaption(), $t04_siswa->Nama->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
ft04_siswagrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "kelas_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "NIS", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Nama", false)) return false;
	return true;
}

// Form_CustomValidate event
ft04_siswagrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft04_siswagrid.ValidateRequired = true;
<?php } else { ?>
ft04_siswagrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft04_siswagrid.Lists["x_kelas_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_Kelas","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t03_kelas"};

// Form object for search
</script>
<?php } ?>
<?php
if ($t04_siswa->CurrentAction == "gridadd") {
	if ($t04_siswa->CurrentMode == "copy") {
		$bSelectLimit = $t04_siswa_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$t04_siswa_grid->TotalRecs = $t04_siswa->SelectRecordCount();
			$t04_siswa_grid->Recordset = $t04_siswa_grid->LoadRecordset($t04_siswa_grid->StartRec-1, $t04_siswa_grid->DisplayRecs);
		} else {
			if ($t04_siswa_grid->Recordset = $t04_siswa_grid->LoadRecordset())
				$t04_siswa_grid->TotalRecs = $t04_siswa_grid->Recordset->RecordCount();
		}
		$t04_siswa_grid->StartRec = 1;
		$t04_siswa_grid->DisplayRecs = $t04_siswa_grid->TotalRecs;
	} else {
		$t04_siswa->CurrentFilter = "0=1";
		$t04_siswa_grid->StartRec = 1;
		$t04_siswa_grid->DisplayRecs = $t04_siswa->GridAddRowCount;
	}
	$t04_siswa_grid->TotalRecs = $t04_siswa_grid->DisplayRecs;
	$t04_siswa_grid->StopRec = $t04_siswa_grid->DisplayRecs;
} else {
	$bSelectLimit = $t04_siswa_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($t04_siswa_grid->TotalRecs <= 0)
			$t04_siswa_grid->TotalRecs = $t04_siswa->SelectRecordCount();
	} else {
		if (!$t04_siswa_grid->Recordset && ($t04_siswa_grid->Recordset = $t04_siswa_grid->LoadRecordset()))
			$t04_siswa_grid->TotalRecs = $t04_siswa_grid->Recordset->RecordCount();
	}
	$t04_siswa_grid->StartRec = 1;
	$t04_siswa_grid->DisplayRecs = $t04_siswa_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$t04_siswa_grid->Recordset = $t04_siswa_grid->LoadRecordset($t04_siswa_grid->StartRec-1, $t04_siswa_grid->DisplayRecs);

	// Set no record found message
	if ($t04_siswa->CurrentAction == "" && $t04_siswa_grid->TotalRecs == 0) {
		if ($t04_siswa_grid->SearchWhere == "0=101")
			$t04_siswa_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$t04_siswa_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$t04_siswa_grid->RenderOtherOptions();
?>
<?php $t04_siswa_grid->ShowPageHeader(); ?>
<?php
$t04_siswa_grid->ShowMessage();
?>
<?php if ($t04_siswa_grid->TotalRecs > 0 || $t04_siswa->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid t04_siswa">
<div id="ft04_siswagrid" class="ewForm form-inline">
<div id="gmp_t04_siswa" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_t04_siswagrid" class="table ewTable">
<?php echo $t04_siswa->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$t04_siswa_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$t04_siswa_grid->RenderListOptions();

// Render list options (header, left)
$t04_siswa_grid->ListOptions->Render("header", "left");
?>
<?php if ($t04_siswa->kelas_id->Visible) { // kelas_id ?>
	<?php if ($t04_siswa->SortUrl($t04_siswa->kelas_id) == "") { ?>
		<th data-name="kelas_id"><div id="elh_t04_siswa_kelas_id" class="t04_siswa_kelas_id"><div class="ewTableHeaderCaption"><?php echo $t04_siswa->kelas_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kelas_id"><div><div id="elh_t04_siswa_kelas_id" class="t04_siswa_kelas_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t04_siswa->kelas_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t04_siswa->kelas_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t04_siswa->kelas_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t04_siswa->NIS->Visible) { // NIS ?>
	<?php if ($t04_siswa->SortUrl($t04_siswa->NIS) == "") { ?>
		<th data-name="NIS"><div id="elh_t04_siswa_NIS" class="t04_siswa_NIS"><div class="ewTableHeaderCaption"><?php echo $t04_siswa->NIS->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="NIS"><div><div id="elh_t04_siswa_NIS" class="t04_siswa_NIS">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t04_siswa->NIS->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t04_siswa->NIS->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t04_siswa->NIS->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t04_siswa->Nama->Visible) { // Nama ?>
	<?php if ($t04_siswa->SortUrl($t04_siswa->Nama) == "") { ?>
		<th data-name="Nama"><div id="elh_t04_siswa_Nama" class="t04_siswa_Nama"><div class="ewTableHeaderCaption"><?php echo $t04_siswa->Nama->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nama"><div><div id="elh_t04_siswa_Nama" class="t04_siswa_Nama">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t04_siswa->Nama->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t04_siswa->Nama->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t04_siswa->Nama->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$t04_siswa_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$t04_siswa_grid->StartRec = 1;
$t04_siswa_grid->StopRec = $t04_siswa_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($t04_siswa_grid->FormKeyCountName) && ($t04_siswa->CurrentAction == "gridadd" || $t04_siswa->CurrentAction == "gridedit" || $t04_siswa->CurrentAction == "F")) {
		$t04_siswa_grid->KeyCount = $objForm->GetValue($t04_siswa_grid->FormKeyCountName);
		$t04_siswa_grid->StopRec = $t04_siswa_grid->StartRec + $t04_siswa_grid->KeyCount - 1;
	}
}
$t04_siswa_grid->RecCnt = $t04_siswa_grid->StartRec - 1;
if ($t04_siswa_grid->Recordset && !$t04_siswa_grid->Recordset->EOF) {
	$t04_siswa_grid->Recordset->MoveFirst();
	$bSelectLimit = $t04_siswa_grid->UseSelectLimit;
	if (!$bSelectLimit && $t04_siswa_grid->StartRec > 1)
		$t04_siswa_grid->Recordset->Move($t04_siswa_grid->StartRec - 1);
} elseif (!$t04_siswa->AllowAddDeleteRow && $t04_siswa_grid->StopRec == 0) {
	$t04_siswa_grid->StopRec = $t04_siswa->GridAddRowCount;
}

// Initialize aggregate
$t04_siswa->RowType = EW_ROWTYPE_AGGREGATEINIT;
$t04_siswa->ResetAttrs();
$t04_siswa_grid->RenderRow();
if ($t04_siswa->CurrentAction == "gridadd")
	$t04_siswa_grid->RowIndex = 0;
if ($t04_siswa->CurrentAction == "gridedit")
	$t04_siswa_grid->RowIndex = 0;
while ($t04_siswa_grid->RecCnt < $t04_siswa_grid->StopRec) {
	$t04_siswa_grid->RecCnt++;
	if (intval($t04_siswa_grid->RecCnt) >= intval($t04_siswa_grid->StartRec)) {
		$t04_siswa_grid->RowCnt++;
		if ($t04_siswa->CurrentAction == "gridadd" || $t04_siswa->CurrentAction == "gridedit" || $t04_siswa->CurrentAction == "F") {
			$t04_siswa_grid->RowIndex++;
			$objForm->Index = $t04_siswa_grid->RowIndex;
			if ($objForm->HasValue($t04_siswa_grid->FormActionName))
				$t04_siswa_grid->RowAction = strval($objForm->GetValue($t04_siswa_grid->FormActionName));
			elseif ($t04_siswa->CurrentAction == "gridadd")
				$t04_siswa_grid->RowAction = "insert";
			else
				$t04_siswa_grid->RowAction = "";
		}

		// Set up key count
		$t04_siswa_grid->KeyCount = $t04_siswa_grid->RowIndex;

		// Init row class and style
		$t04_siswa->ResetAttrs();
		$t04_siswa->CssClass = "";
		if ($t04_siswa->CurrentAction == "gridadd") {
			if ($t04_siswa->CurrentMode == "copy") {
				$t04_siswa_grid->LoadRowValues($t04_siswa_grid->Recordset); // Load row values
				$t04_siswa_grid->SetRecordKey($t04_siswa_grid->RowOldKey, $t04_siswa_grid->Recordset); // Set old record key
			} else {
				$t04_siswa_grid->LoadDefaultValues(); // Load default values
				$t04_siswa_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$t04_siswa_grid->LoadRowValues($t04_siswa_grid->Recordset); // Load row values
		}
		$t04_siswa->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($t04_siswa->CurrentAction == "gridadd") // Grid add
			$t04_siswa->RowType = EW_ROWTYPE_ADD; // Render add
		if ($t04_siswa->CurrentAction == "gridadd" && $t04_siswa->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$t04_siswa_grid->RestoreCurrentRowFormValues($t04_siswa_grid->RowIndex); // Restore form values
		if ($t04_siswa->CurrentAction == "gridedit") { // Grid edit
			if ($t04_siswa->EventCancelled) {
				$t04_siswa_grid->RestoreCurrentRowFormValues($t04_siswa_grid->RowIndex); // Restore form values
			}
			if ($t04_siswa_grid->RowAction == "insert")
				$t04_siswa->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$t04_siswa->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($t04_siswa->CurrentAction == "gridedit" && ($t04_siswa->RowType == EW_ROWTYPE_EDIT || $t04_siswa->RowType == EW_ROWTYPE_ADD) && $t04_siswa->EventCancelled) // Update failed
			$t04_siswa_grid->RestoreCurrentRowFormValues($t04_siswa_grid->RowIndex); // Restore form values
		if ($t04_siswa->RowType == EW_ROWTYPE_EDIT) // Edit row
			$t04_siswa_grid->EditRowCnt++;
		if ($t04_siswa->CurrentAction == "F") // Confirm row
			$t04_siswa_grid->RestoreCurrentRowFormValues($t04_siswa_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$t04_siswa->RowAttrs = array_merge($t04_siswa->RowAttrs, array('data-rowindex'=>$t04_siswa_grid->RowCnt, 'id'=>'r' . $t04_siswa_grid->RowCnt . '_t04_siswa', 'data-rowtype'=>$t04_siswa->RowType));

		// Render row
		$t04_siswa_grid->RenderRow();

		// Render list options
		$t04_siswa_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($t04_siswa_grid->RowAction <> "delete" && $t04_siswa_grid->RowAction <> "insertdelete" && !($t04_siswa_grid->RowAction == "insert" && $t04_siswa->CurrentAction == "F" && $t04_siswa_grid->EmptyRow())) {
?>
	<tr<?php echo $t04_siswa->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t04_siswa_grid->ListOptions->Render("body", "left", $t04_siswa_grid->RowCnt);
?>
	<?php if ($t04_siswa->kelas_id->Visible) { // kelas_id ?>
		<td data-name="kelas_id"<?php echo $t04_siswa->kelas_id->CellAttributes() ?>>
<?php if ($t04_siswa->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($t04_siswa->kelas_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $t04_siswa_grid->RowCnt ?>_t04_siswa_kelas_id" class="form-group t04_siswa_kelas_id">
<span<?php echo $t04_siswa->kelas_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t04_siswa->kelas_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t04_siswa_grid->RowIndex ?>_kelas_id" name="x<?php echo $t04_siswa_grid->RowIndex ?>_kelas_id" value="<?php echo ew_HtmlEncode($t04_siswa->kelas_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $t04_siswa_grid->RowCnt ?>_t04_siswa_kelas_id" class="form-group t04_siswa_kelas_id">
<select data-table="t04_siswa" data-field="x_kelas_id" data-value-separator="<?php echo $t04_siswa->kelas_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $t04_siswa_grid->RowIndex ?>_kelas_id" name="x<?php echo $t04_siswa_grid->RowIndex ?>_kelas_id"<?php echo $t04_siswa->kelas_id->EditAttributes() ?>>
<?php echo $t04_siswa->kelas_id->SelectOptionListHtml("x<?php echo $t04_siswa_grid->RowIndex ?>_kelas_id") ?>
</select>
<input type="hidden" name="s_x<?php echo $t04_siswa_grid->RowIndex ?>_kelas_id" id="s_x<?php echo $t04_siswa_grid->RowIndex ?>_kelas_id" value="<?php echo $t04_siswa->kelas_id->LookupFilterQuery() ?>">
</span>
<?php } ?>
<input type="hidden" data-table="t04_siswa" data-field="x_kelas_id" name="o<?php echo $t04_siswa_grid->RowIndex ?>_kelas_id" id="o<?php echo $t04_siswa_grid->RowIndex ?>_kelas_id" value="<?php echo ew_HtmlEncode($t04_siswa->kelas_id->OldValue) ?>">
<?php } ?>
<?php if ($t04_siswa->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($t04_siswa->kelas_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $t04_siswa_grid->RowCnt ?>_t04_siswa_kelas_id" class="form-group t04_siswa_kelas_id">
<span<?php echo $t04_siswa->kelas_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t04_siswa->kelas_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t04_siswa_grid->RowIndex ?>_kelas_id" name="x<?php echo $t04_siswa_grid->RowIndex ?>_kelas_id" value="<?php echo ew_HtmlEncode($t04_siswa->kelas_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $t04_siswa_grid->RowCnt ?>_t04_siswa_kelas_id" class="form-group t04_siswa_kelas_id">
<select data-table="t04_siswa" data-field="x_kelas_id" data-value-separator="<?php echo $t04_siswa->kelas_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $t04_siswa_grid->RowIndex ?>_kelas_id" name="x<?php echo $t04_siswa_grid->RowIndex ?>_kelas_id"<?php echo $t04_siswa->kelas_id->EditAttributes() ?>>
<?php echo $t04_siswa->kelas_id->SelectOptionListHtml("x<?php echo $t04_siswa_grid->RowIndex ?>_kelas_id") ?>
</select>
<input type="hidden" name="s_x<?php echo $t04_siswa_grid->RowIndex ?>_kelas_id" id="s_x<?php echo $t04_siswa_grid->RowIndex ?>_kelas_id" value="<?php echo $t04_siswa->kelas_id->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } ?>
<?php if ($t04_siswa->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t04_siswa_grid->RowCnt ?>_t04_siswa_kelas_id" class="t04_siswa_kelas_id">
<span<?php echo $t04_siswa->kelas_id->ViewAttributes() ?>>
<?php echo $t04_siswa->kelas_id->ListViewValue() ?></span>
</span>
<?php if ($t04_siswa->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t04_siswa" data-field="x_kelas_id" name="x<?php echo $t04_siswa_grid->RowIndex ?>_kelas_id" id="x<?php echo $t04_siswa_grid->RowIndex ?>_kelas_id" value="<?php echo ew_HtmlEncode($t04_siswa->kelas_id->FormValue) ?>">
<input type="hidden" data-table="t04_siswa" data-field="x_kelas_id" name="o<?php echo $t04_siswa_grid->RowIndex ?>_kelas_id" id="o<?php echo $t04_siswa_grid->RowIndex ?>_kelas_id" value="<?php echo ew_HtmlEncode($t04_siswa->kelas_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t04_siswa" data-field="x_kelas_id" name="ft04_siswagrid$x<?php echo $t04_siswa_grid->RowIndex ?>_kelas_id" id="ft04_siswagrid$x<?php echo $t04_siswa_grid->RowIndex ?>_kelas_id" value="<?php echo ew_HtmlEncode($t04_siswa->kelas_id->FormValue) ?>">
<input type="hidden" data-table="t04_siswa" data-field="x_kelas_id" name="ft04_siswagrid$o<?php echo $t04_siswa_grid->RowIndex ?>_kelas_id" id="ft04_siswagrid$o<?php echo $t04_siswa_grid->RowIndex ?>_kelas_id" value="<?php echo ew_HtmlEncode($t04_siswa->kelas_id->OldValue) ?>">
<?php } ?>
<?php } ?>
<a id="<?php echo $t04_siswa_grid->PageObjName . "_row_" . $t04_siswa_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($t04_siswa->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="t04_siswa" data-field="x_id" name="x<?php echo $t04_siswa_grid->RowIndex ?>_id" id="x<?php echo $t04_siswa_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t04_siswa->id->CurrentValue) ?>">
<input type="hidden" data-table="t04_siswa" data-field="x_id" name="o<?php echo $t04_siswa_grid->RowIndex ?>_id" id="o<?php echo $t04_siswa_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t04_siswa->id->OldValue) ?>">
<?php } ?>
<?php if ($t04_siswa->RowType == EW_ROWTYPE_EDIT || $t04_siswa->CurrentMode == "edit") { ?>
<input type="hidden" data-table="t04_siswa" data-field="x_id" name="x<?php echo $t04_siswa_grid->RowIndex ?>_id" id="x<?php echo $t04_siswa_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t04_siswa->id->CurrentValue) ?>">
<?php } ?>
	<?php if ($t04_siswa->NIS->Visible) { // NIS ?>
		<td data-name="NIS"<?php echo $t04_siswa->NIS->CellAttributes() ?>>
<?php if ($t04_siswa->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t04_siswa_grid->RowCnt ?>_t04_siswa_NIS" class="form-group t04_siswa_NIS">
<input type="text" data-table="t04_siswa" data-field="x_NIS" name="x<?php echo $t04_siswa_grid->RowIndex ?>_NIS" id="x<?php echo $t04_siswa_grid->RowIndex ?>_NIS" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($t04_siswa->NIS->getPlaceHolder()) ?>" value="<?php echo $t04_siswa->NIS->EditValue ?>"<?php echo $t04_siswa->NIS->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t04_siswa" data-field="x_NIS" name="o<?php echo $t04_siswa_grid->RowIndex ?>_NIS" id="o<?php echo $t04_siswa_grid->RowIndex ?>_NIS" value="<?php echo ew_HtmlEncode($t04_siswa->NIS->OldValue) ?>">
<?php } ?>
<?php if ($t04_siswa->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t04_siswa_grid->RowCnt ?>_t04_siswa_NIS" class="form-group t04_siswa_NIS">
<input type="text" data-table="t04_siswa" data-field="x_NIS" name="x<?php echo $t04_siswa_grid->RowIndex ?>_NIS" id="x<?php echo $t04_siswa_grid->RowIndex ?>_NIS" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($t04_siswa->NIS->getPlaceHolder()) ?>" value="<?php echo $t04_siswa->NIS->EditValue ?>"<?php echo $t04_siswa->NIS->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t04_siswa->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t04_siswa_grid->RowCnt ?>_t04_siswa_NIS" class="t04_siswa_NIS">
<span<?php echo $t04_siswa->NIS->ViewAttributes() ?>>
<?php echo $t04_siswa->NIS->ListViewValue() ?></span>
</span>
<?php if ($t04_siswa->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t04_siswa" data-field="x_NIS" name="x<?php echo $t04_siswa_grid->RowIndex ?>_NIS" id="x<?php echo $t04_siswa_grid->RowIndex ?>_NIS" value="<?php echo ew_HtmlEncode($t04_siswa->NIS->FormValue) ?>">
<input type="hidden" data-table="t04_siswa" data-field="x_NIS" name="o<?php echo $t04_siswa_grid->RowIndex ?>_NIS" id="o<?php echo $t04_siswa_grid->RowIndex ?>_NIS" value="<?php echo ew_HtmlEncode($t04_siswa->NIS->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t04_siswa" data-field="x_NIS" name="ft04_siswagrid$x<?php echo $t04_siswa_grid->RowIndex ?>_NIS" id="ft04_siswagrid$x<?php echo $t04_siswa_grid->RowIndex ?>_NIS" value="<?php echo ew_HtmlEncode($t04_siswa->NIS->FormValue) ?>">
<input type="hidden" data-table="t04_siswa" data-field="x_NIS" name="ft04_siswagrid$o<?php echo $t04_siswa_grid->RowIndex ?>_NIS" id="ft04_siswagrid$o<?php echo $t04_siswa_grid->RowIndex ?>_NIS" value="<?php echo ew_HtmlEncode($t04_siswa->NIS->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t04_siswa->Nama->Visible) { // Nama ?>
		<td data-name="Nama"<?php echo $t04_siswa->Nama->CellAttributes() ?>>
<?php if ($t04_siswa->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t04_siswa_grid->RowCnt ?>_t04_siswa_Nama" class="form-group t04_siswa_Nama">
<input type="text" data-table="t04_siswa" data-field="x_Nama" name="x<?php echo $t04_siswa_grid->RowIndex ?>_Nama" id="x<?php echo $t04_siswa_grid->RowIndex ?>_Nama" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($t04_siswa->Nama->getPlaceHolder()) ?>" value="<?php echo $t04_siswa->Nama->EditValue ?>"<?php echo $t04_siswa->Nama->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t04_siswa" data-field="x_Nama" name="o<?php echo $t04_siswa_grid->RowIndex ?>_Nama" id="o<?php echo $t04_siswa_grid->RowIndex ?>_Nama" value="<?php echo ew_HtmlEncode($t04_siswa->Nama->OldValue) ?>">
<?php } ?>
<?php if ($t04_siswa->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t04_siswa_grid->RowCnt ?>_t04_siswa_Nama" class="form-group t04_siswa_Nama">
<input type="text" data-table="t04_siswa" data-field="x_Nama" name="x<?php echo $t04_siswa_grid->RowIndex ?>_Nama" id="x<?php echo $t04_siswa_grid->RowIndex ?>_Nama" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($t04_siswa->Nama->getPlaceHolder()) ?>" value="<?php echo $t04_siswa->Nama->EditValue ?>"<?php echo $t04_siswa->Nama->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t04_siswa->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t04_siswa_grid->RowCnt ?>_t04_siswa_Nama" class="t04_siswa_Nama">
<span<?php echo $t04_siswa->Nama->ViewAttributes() ?>>
<?php echo $t04_siswa->Nama->ListViewValue() ?></span>
</span>
<?php if ($t04_siswa->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t04_siswa" data-field="x_Nama" name="x<?php echo $t04_siswa_grid->RowIndex ?>_Nama" id="x<?php echo $t04_siswa_grid->RowIndex ?>_Nama" value="<?php echo ew_HtmlEncode($t04_siswa->Nama->FormValue) ?>">
<input type="hidden" data-table="t04_siswa" data-field="x_Nama" name="o<?php echo $t04_siswa_grid->RowIndex ?>_Nama" id="o<?php echo $t04_siswa_grid->RowIndex ?>_Nama" value="<?php echo ew_HtmlEncode($t04_siswa->Nama->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t04_siswa" data-field="x_Nama" name="ft04_siswagrid$x<?php echo $t04_siswa_grid->RowIndex ?>_Nama" id="ft04_siswagrid$x<?php echo $t04_siswa_grid->RowIndex ?>_Nama" value="<?php echo ew_HtmlEncode($t04_siswa->Nama->FormValue) ?>">
<input type="hidden" data-table="t04_siswa" data-field="x_Nama" name="ft04_siswagrid$o<?php echo $t04_siswa_grid->RowIndex ?>_Nama" id="ft04_siswagrid$o<?php echo $t04_siswa_grid->RowIndex ?>_Nama" value="<?php echo ew_HtmlEncode($t04_siswa->Nama->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t04_siswa_grid->ListOptions->Render("body", "right", $t04_siswa_grid->RowCnt);
?>
	</tr>
<?php if ($t04_siswa->RowType == EW_ROWTYPE_ADD || $t04_siswa->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ft04_siswagrid.UpdateOpts(<?php echo $t04_siswa_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($t04_siswa->CurrentAction <> "gridadd" || $t04_siswa->CurrentMode == "copy")
		if (!$t04_siswa_grid->Recordset->EOF) $t04_siswa_grid->Recordset->MoveNext();
}
?>
<?php
	if ($t04_siswa->CurrentMode == "add" || $t04_siswa->CurrentMode == "copy" || $t04_siswa->CurrentMode == "edit") {
		$t04_siswa_grid->RowIndex = '$rowindex$';
		$t04_siswa_grid->LoadDefaultValues();

		// Set row properties
		$t04_siswa->ResetAttrs();
		$t04_siswa->RowAttrs = array_merge($t04_siswa->RowAttrs, array('data-rowindex'=>$t04_siswa_grid->RowIndex, 'id'=>'r0_t04_siswa', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($t04_siswa->RowAttrs["class"], "ewTemplate");
		$t04_siswa->RowType = EW_ROWTYPE_ADD;

		// Render row
		$t04_siswa_grid->RenderRow();

		// Render list options
		$t04_siswa_grid->RenderListOptions();
		$t04_siswa_grid->StartRowCnt = 0;
?>
	<tr<?php echo $t04_siswa->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t04_siswa_grid->ListOptions->Render("body", "left", $t04_siswa_grid->RowIndex);
?>
	<?php if ($t04_siswa->kelas_id->Visible) { // kelas_id ?>
		<td data-name="kelas_id">
<?php if ($t04_siswa->CurrentAction <> "F") { ?>
<?php if ($t04_siswa->kelas_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_t04_siswa_kelas_id" class="form-group t04_siswa_kelas_id">
<span<?php echo $t04_siswa->kelas_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t04_siswa->kelas_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t04_siswa_grid->RowIndex ?>_kelas_id" name="x<?php echo $t04_siswa_grid->RowIndex ?>_kelas_id" value="<?php echo ew_HtmlEncode($t04_siswa->kelas_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_t04_siswa_kelas_id" class="form-group t04_siswa_kelas_id">
<select data-table="t04_siswa" data-field="x_kelas_id" data-value-separator="<?php echo $t04_siswa->kelas_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $t04_siswa_grid->RowIndex ?>_kelas_id" name="x<?php echo $t04_siswa_grid->RowIndex ?>_kelas_id"<?php echo $t04_siswa->kelas_id->EditAttributes() ?>>
<?php echo $t04_siswa->kelas_id->SelectOptionListHtml("x<?php echo $t04_siswa_grid->RowIndex ?>_kelas_id") ?>
</select>
<input type="hidden" name="s_x<?php echo $t04_siswa_grid->RowIndex ?>_kelas_id" id="s_x<?php echo $t04_siswa_grid->RowIndex ?>_kelas_id" value="<?php echo $t04_siswa->kelas_id->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_t04_siswa_kelas_id" class="form-group t04_siswa_kelas_id">
<span<?php echo $t04_siswa->kelas_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t04_siswa->kelas_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t04_siswa" data-field="x_kelas_id" name="x<?php echo $t04_siswa_grid->RowIndex ?>_kelas_id" id="x<?php echo $t04_siswa_grid->RowIndex ?>_kelas_id" value="<?php echo ew_HtmlEncode($t04_siswa->kelas_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t04_siswa" data-field="x_kelas_id" name="o<?php echo $t04_siswa_grid->RowIndex ?>_kelas_id" id="o<?php echo $t04_siswa_grid->RowIndex ?>_kelas_id" value="<?php echo ew_HtmlEncode($t04_siswa->kelas_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t04_siswa->NIS->Visible) { // NIS ?>
		<td data-name="NIS">
<?php if ($t04_siswa->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t04_siswa_NIS" class="form-group t04_siswa_NIS">
<input type="text" data-table="t04_siswa" data-field="x_NIS" name="x<?php echo $t04_siswa_grid->RowIndex ?>_NIS" id="x<?php echo $t04_siswa_grid->RowIndex ?>_NIS" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($t04_siswa->NIS->getPlaceHolder()) ?>" value="<?php echo $t04_siswa->NIS->EditValue ?>"<?php echo $t04_siswa->NIS->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t04_siswa_NIS" class="form-group t04_siswa_NIS">
<span<?php echo $t04_siswa->NIS->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t04_siswa->NIS->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t04_siswa" data-field="x_NIS" name="x<?php echo $t04_siswa_grid->RowIndex ?>_NIS" id="x<?php echo $t04_siswa_grid->RowIndex ?>_NIS" value="<?php echo ew_HtmlEncode($t04_siswa->NIS->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t04_siswa" data-field="x_NIS" name="o<?php echo $t04_siswa_grid->RowIndex ?>_NIS" id="o<?php echo $t04_siswa_grid->RowIndex ?>_NIS" value="<?php echo ew_HtmlEncode($t04_siswa->NIS->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t04_siswa->Nama->Visible) { // Nama ?>
		<td data-name="Nama">
<?php if ($t04_siswa->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t04_siswa_Nama" class="form-group t04_siswa_Nama">
<input type="text" data-table="t04_siswa" data-field="x_Nama" name="x<?php echo $t04_siswa_grid->RowIndex ?>_Nama" id="x<?php echo $t04_siswa_grid->RowIndex ?>_Nama" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($t04_siswa->Nama->getPlaceHolder()) ?>" value="<?php echo $t04_siswa->Nama->EditValue ?>"<?php echo $t04_siswa->Nama->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t04_siswa_Nama" class="form-group t04_siswa_Nama">
<span<?php echo $t04_siswa->Nama->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t04_siswa->Nama->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t04_siswa" data-field="x_Nama" name="x<?php echo $t04_siswa_grid->RowIndex ?>_Nama" id="x<?php echo $t04_siswa_grid->RowIndex ?>_Nama" value="<?php echo ew_HtmlEncode($t04_siswa->Nama->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t04_siswa" data-field="x_Nama" name="o<?php echo $t04_siswa_grid->RowIndex ?>_Nama" id="o<?php echo $t04_siswa_grid->RowIndex ?>_Nama" value="<?php echo ew_HtmlEncode($t04_siswa->Nama->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t04_siswa_grid->ListOptions->Render("body", "right", $t04_siswa_grid->RowCnt);
?>
<script type="text/javascript">
ft04_siswagrid.UpdateOpts(<?php echo $t04_siswa_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($t04_siswa->CurrentMode == "add" || $t04_siswa->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $t04_siswa_grid->FormKeyCountName ?>" id="<?php echo $t04_siswa_grid->FormKeyCountName ?>" value="<?php echo $t04_siswa_grid->KeyCount ?>">
<?php echo $t04_siswa_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t04_siswa->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $t04_siswa_grid->FormKeyCountName ?>" id="<?php echo $t04_siswa_grid->FormKeyCountName ?>" value="<?php echo $t04_siswa_grid->KeyCount ?>">
<?php echo $t04_siswa_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t04_siswa->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="ft04_siswagrid">
</div>
<?php

// Close recordset
if ($t04_siswa_grid->Recordset)
	$t04_siswa_grid->Recordset->Close();
?>
<?php if ($t04_siswa_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($t04_siswa_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($t04_siswa_grid->TotalRecs == 0 && $t04_siswa->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t04_siswa_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($t04_siswa->Export == "") { ?>
<script type="text/javascript">
ft04_siswagrid.Init();
</script>
<?php } ?>
<?php
$t04_siswa_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$t04_siswa_grid->Page_Terminate();
?>
