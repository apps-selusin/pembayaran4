<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "t01_tahunajaraninfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$t01_tahunajaran_delete = NULL; // Initialize page object first

class ct01_tahunajaran_delete extends ct01_tahunajaran {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{1437F52B-7E7A-46CA-851B-958195C82267}";

	// Table name
	var $TableName = 't01_tahunajaran';

	// Page object name
	var $PageObjName = 't01_tahunajaran_delete';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Methods to clear message
	function ClearMessage() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
	}

	function ClearFailureMessage() {
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
	}

	function ClearSuccessMessage() {
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
	}

	function ClearWarningMessage() {
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	function ClearMessages() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $TokenTimeout = 0;
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsHttpPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME], $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (t01_tahunajaran)
		if (!isset($GLOBALS["t01_tahunajaran"]) || get_class($GLOBALS["t01_tahunajaran"]) == "ct01_tahunajaran") {
			$GLOBALS["t01_tahunajaran"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t01_tahunajaran"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't01_tahunajaran', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->Awal_Bulan->SetVisibility();
		$this->Awal_Tahun->SetVisibility();
		$this->Akhir_Bulan->SetVisibility();
		$this->Akhir_Tahun->SetVisibility();
		$this->Tahun_Ajaran->SetVisibility();
		$this->Aktif->SetVisibility();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Create Token
		$this->CreateToken();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EW_EXPORT, $t01_tahunajaran;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t01_tahunajaran);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				exit();
			}
		}
		$this->Page_Redirecting($url);

		 // Close connection
		ew_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("t01_tahunajaranlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in t01_tahunajaran class, t01_tahunajaraninfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} elseif (@$_GET["a_delete"] == "1") {
			$this->CurrentAction = "D"; // Delete record directly
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		if ($this->CurrentAction == "D") {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->DeleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			} else { // Delete failed
				$this->CurrentAction = "I"; // Display record
			}
		}
		if ($this->CurrentAction == "I") { // Load records for display
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecs <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->Close();
				$this->Page_Terminate("t01_tahunajaranlist.php"); // Return to list
			}
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->SelectSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())));
			} else {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = ew_LoadRecordset($sSql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
		$this->id->setDbValue($rs->fields('id'));
		$this->Awal_Bulan->setDbValue($rs->fields('Awal_Bulan'));
		$this->Awal_Tahun->setDbValue($rs->fields('Awal_Tahun'));
		$this->Akhir_Bulan->setDbValue($rs->fields('Akhir_Bulan'));
		$this->Akhir_Tahun->setDbValue($rs->fields('Akhir_Tahun'));
		$this->Tahun_Ajaran->setDbValue($rs->fields('Tahun_Ajaran'));
		$this->Aktif->setDbValue($rs->fields('Aktif'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->Awal_Bulan->DbValue = $row['Awal_Bulan'];
		$this->Awal_Tahun->DbValue = $row['Awal_Tahun'];
		$this->Akhir_Bulan->DbValue = $row['Akhir_Bulan'];
		$this->Akhir_Tahun->DbValue = $row['Akhir_Tahun'];
		$this->Tahun_Ajaran->DbValue = $row['Tahun_Ajaran'];
		$this->Aktif->DbValue = $row['Aktif'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// Awal_Bulan
		// Awal_Tahun
		// Akhir_Bulan
		// Akhir_Tahun
		// Tahun_Ajaran
		// Aktif

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// Awal_Bulan
		$this->Awal_Bulan->ViewValue = $this->Awal_Bulan->CurrentValue;
		$this->Awal_Bulan->ViewCustomAttributes = "";

		// Awal_Tahun
		$this->Awal_Tahun->ViewValue = $this->Awal_Tahun->CurrentValue;
		$this->Awal_Tahun->ViewCustomAttributes = "";

		// Akhir_Bulan
		$this->Akhir_Bulan->ViewValue = $this->Akhir_Bulan->CurrentValue;
		$this->Akhir_Bulan->ViewCustomAttributes = "";

		// Akhir_Tahun
		$this->Akhir_Tahun->ViewValue = $this->Akhir_Tahun->CurrentValue;
		$this->Akhir_Tahun->ViewCustomAttributes = "";

		// Tahun_Ajaran
		$this->Tahun_Ajaran->ViewValue = $this->Tahun_Ajaran->CurrentValue;
		$this->Tahun_Ajaran->ViewCustomAttributes = "";

		// Aktif
		if (strval($this->Aktif->CurrentValue) <> "") {
			$this->Aktif->ViewValue = $this->Aktif->OptionCaption($this->Aktif->CurrentValue);
		} else {
			$this->Aktif->ViewValue = NULL;
		}
		$this->Aktif->ViewCustomAttributes = "";

			// Awal_Bulan
			$this->Awal_Bulan->LinkCustomAttributes = "";
			$this->Awal_Bulan->HrefValue = "";
			$this->Awal_Bulan->TooltipValue = "";

			// Awal_Tahun
			$this->Awal_Tahun->LinkCustomAttributes = "";
			$this->Awal_Tahun->HrefValue = "";
			$this->Awal_Tahun->TooltipValue = "";

			// Akhir_Bulan
			$this->Akhir_Bulan->LinkCustomAttributes = "";
			$this->Akhir_Bulan->HrefValue = "";
			$this->Akhir_Bulan->TooltipValue = "";

			// Akhir_Tahun
			$this->Akhir_Tahun->LinkCustomAttributes = "";
			$this->Akhir_Tahun->HrefValue = "";
			$this->Akhir_Tahun->TooltipValue = "";

			// Tahun_Ajaran
			$this->Tahun_Ajaran->LinkCustomAttributes = "";
			$this->Tahun_Ajaran->HrefValue = "";
			$this->Tahun_Ajaran->TooltipValue = "";

			// Aktif
			$this->Aktif->LinkCustomAttributes = "";
			$this->Aktif->HrefValue = "";
			$this->Aktif->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;

		//} else {
		//	$this->LoadRowValues($rs); // Load row values

		}
		$rows = ($rs) ? $rs->GetRows() : array();
		$conn->BeginTrans();

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['id'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t01_tahunajaranlist.php"), "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($t01_tahunajaran_delete)) $t01_tahunajaran_delete = new ct01_tahunajaran_delete();

// Page init
$t01_tahunajaran_delete->Page_Init();

// Page main
$t01_tahunajaran_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t01_tahunajaran_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = ft01_tahunajarandelete = new ew_Form("ft01_tahunajarandelete", "delete");

// Form_CustomValidate event
ft01_tahunajarandelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft01_tahunajarandelete.ValidateRequired = true;
<?php } else { ?>
ft01_tahunajarandelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft01_tahunajarandelete.Lists["x_Aktif"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ft01_tahunajarandelete.Lists["x_Aktif"].Options = <?php echo json_encode($t01_tahunajaran->Aktif->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $t01_tahunajaran_delete->ShowPageHeader(); ?>
<?php
$t01_tahunajaran_delete->ShowMessage();
?>
<form name="ft01_tahunajarandelete" id="ft01_tahunajarandelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t01_tahunajaran_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t01_tahunajaran_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t01_tahunajaran">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($t01_tahunajaran_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $t01_tahunajaran->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($t01_tahunajaran->Awal_Bulan->Visible) { // Awal_Bulan ?>
		<th><span id="elh_t01_tahunajaran_Awal_Bulan" class="t01_tahunajaran_Awal_Bulan"><?php echo $t01_tahunajaran->Awal_Bulan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t01_tahunajaran->Awal_Tahun->Visible) { // Awal_Tahun ?>
		<th><span id="elh_t01_tahunajaran_Awal_Tahun" class="t01_tahunajaran_Awal_Tahun"><?php echo $t01_tahunajaran->Awal_Tahun->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t01_tahunajaran->Akhir_Bulan->Visible) { // Akhir_Bulan ?>
		<th><span id="elh_t01_tahunajaran_Akhir_Bulan" class="t01_tahunajaran_Akhir_Bulan"><?php echo $t01_tahunajaran->Akhir_Bulan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t01_tahunajaran->Akhir_Tahun->Visible) { // Akhir_Tahun ?>
		<th><span id="elh_t01_tahunajaran_Akhir_Tahun" class="t01_tahunajaran_Akhir_Tahun"><?php echo $t01_tahunajaran->Akhir_Tahun->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t01_tahunajaran->Tahun_Ajaran->Visible) { // Tahun_Ajaran ?>
		<th><span id="elh_t01_tahunajaran_Tahun_Ajaran" class="t01_tahunajaran_Tahun_Ajaran"><?php echo $t01_tahunajaran->Tahun_Ajaran->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t01_tahunajaran->Aktif->Visible) { // Aktif ?>
		<th><span id="elh_t01_tahunajaran_Aktif" class="t01_tahunajaran_Aktif"><?php echo $t01_tahunajaran->Aktif->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$t01_tahunajaran_delete->RecCnt = 0;
$i = 0;
while (!$t01_tahunajaran_delete->Recordset->EOF) {
	$t01_tahunajaran_delete->RecCnt++;
	$t01_tahunajaran_delete->RowCnt++;

	// Set row properties
	$t01_tahunajaran->ResetAttrs();
	$t01_tahunajaran->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$t01_tahunajaran_delete->LoadRowValues($t01_tahunajaran_delete->Recordset);

	// Render row
	$t01_tahunajaran_delete->RenderRow();
?>
	<tr<?php echo $t01_tahunajaran->RowAttributes() ?>>
<?php if ($t01_tahunajaran->Awal_Bulan->Visible) { // Awal_Bulan ?>
		<td<?php echo $t01_tahunajaran->Awal_Bulan->CellAttributes() ?>>
<span id="el<?php echo $t01_tahunajaran_delete->RowCnt ?>_t01_tahunajaran_Awal_Bulan" class="t01_tahunajaran_Awal_Bulan">
<span<?php echo $t01_tahunajaran->Awal_Bulan->ViewAttributes() ?>>
<?php echo $t01_tahunajaran->Awal_Bulan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t01_tahunajaran->Awal_Tahun->Visible) { // Awal_Tahun ?>
		<td<?php echo $t01_tahunajaran->Awal_Tahun->CellAttributes() ?>>
<span id="el<?php echo $t01_tahunajaran_delete->RowCnt ?>_t01_tahunajaran_Awal_Tahun" class="t01_tahunajaran_Awal_Tahun">
<span<?php echo $t01_tahunajaran->Awal_Tahun->ViewAttributes() ?>>
<?php echo $t01_tahunajaran->Awal_Tahun->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t01_tahunajaran->Akhir_Bulan->Visible) { // Akhir_Bulan ?>
		<td<?php echo $t01_tahunajaran->Akhir_Bulan->CellAttributes() ?>>
<span id="el<?php echo $t01_tahunajaran_delete->RowCnt ?>_t01_tahunajaran_Akhir_Bulan" class="t01_tahunajaran_Akhir_Bulan">
<span<?php echo $t01_tahunajaran->Akhir_Bulan->ViewAttributes() ?>>
<?php echo $t01_tahunajaran->Akhir_Bulan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t01_tahunajaran->Akhir_Tahun->Visible) { // Akhir_Tahun ?>
		<td<?php echo $t01_tahunajaran->Akhir_Tahun->CellAttributes() ?>>
<span id="el<?php echo $t01_tahunajaran_delete->RowCnt ?>_t01_tahunajaran_Akhir_Tahun" class="t01_tahunajaran_Akhir_Tahun">
<span<?php echo $t01_tahunajaran->Akhir_Tahun->ViewAttributes() ?>>
<?php echo $t01_tahunajaran->Akhir_Tahun->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t01_tahunajaran->Tahun_Ajaran->Visible) { // Tahun_Ajaran ?>
		<td<?php echo $t01_tahunajaran->Tahun_Ajaran->CellAttributes() ?>>
<span id="el<?php echo $t01_tahunajaran_delete->RowCnt ?>_t01_tahunajaran_Tahun_Ajaran" class="t01_tahunajaran_Tahun_Ajaran">
<span<?php echo $t01_tahunajaran->Tahun_Ajaran->ViewAttributes() ?>>
<?php echo $t01_tahunajaran->Tahun_Ajaran->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t01_tahunajaran->Aktif->Visible) { // Aktif ?>
		<td<?php echo $t01_tahunajaran->Aktif->CellAttributes() ?>>
<span id="el<?php echo $t01_tahunajaran_delete->RowCnt ?>_t01_tahunajaran_Aktif" class="t01_tahunajaran_Aktif">
<span<?php echo $t01_tahunajaran->Aktif->ViewAttributes() ?>>
<?php echo $t01_tahunajaran->Aktif->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$t01_tahunajaran_delete->Recordset->MoveNext();
}
$t01_tahunajaran_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t01_tahunajaran_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
ft01_tahunajarandelete.Init();
</script>
<?php
$t01_tahunajaran_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t01_tahunajaran_delete->Page_Terminate();
?>
