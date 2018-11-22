<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "t10_siswanonrutinbayarinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$t10_siswanonrutinbayar_view = NULL; // Initialize page object first

class ct10_siswanonrutinbayar_view extends ct10_siswanonrutinbayar {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{64CABE7A-1609-4157-8293-D7242B591905}";

	// Table name
	var $TableName = 't10_siswanonrutinbayar';

	// Page object name
	var $PageObjName = 't10_siswanonrutinbayar_view';

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

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Custom export
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

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

		// Table object (t10_siswanonrutinbayar)
		if (!isset($GLOBALS["t10_siswanonrutinbayar"]) || get_class($GLOBALS["t10_siswanonrutinbayar"]) == "ct10_siswanonrutinbayar") {
			$GLOBALS["t10_siswanonrutinbayar"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t10_siswanonrutinbayar"];
		}
		$KeyUrl = "";
		if (@$_GET["id"] <> "") {
			$this->RecKey["id"] = $_GET["id"];
			$KeyUrl .= "&amp;id=" . urlencode($this->RecKey["id"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't10_siswanonrutinbayar', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->id->SetVisibility();
		$this->id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->siswanonrutin_id->SetVisibility();
		$this->Nilai->SetVisibility();
		$this->Tanggal_Bayar->SetVisibility();
		$this->Bayar->SetVisibility();
		$this->Sisa->SetVisibility();
		$this->Periode_Tahun_Bulan->SetVisibility();
		$this->Periode_Text->SetVisibility();

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
		global $EW_EXPORT, $t10_siswanonrutinbayar;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t10_siswanonrutinbayar);
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

			// Handle modal response
			if ($this->IsModal) {
				$row = array();
				$row["url"] = $url;
				echo ew_ArrayToJson(array($row));
			} else {
				header("Location: " . $url);
			}
		}
		exit();
	}
	var $ExportOptions; // Export options
	var $OtherOptions = array(); // Other options
	var $DisplayRecs = 1;
	var $DbMasterFilter;
	var $DbDetailFilter;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $RecCnt;
	var $RecKey = array();
	var $IsModal = FALSE;
	var $Recordset;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;
		global $gbSkipHeaderFooter;

		// Check modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["id"] <> "") {
				$this->id->setQueryStringValue($_GET["id"]);
				$this->RecKey["id"] = $this->id->QueryStringValue;
			} elseif (@$_POST["id"] <> "") {
				$this->id->setFormValue($_POST["id"]);
				$this->RecKey["id"] = $this->id->FormValue;
			} else {
				$sReturnUrl = "t10_siswanonrutinbayarlist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "t10_siswanonrutinbayarlist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "t10_siswanonrutinbayarlist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Set up Breadcrumb
		if ($this->Export == "")
			$this->SetupBreadcrumb();

		// Render row
		$this->RowType = EW_ROWTYPE_VIEW;
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = &$options["action"];

		// Set up action default
		$option = &$options["action"];
		$option->DropDownButtonPhrase = $Language->Phrase("ButtonActions");
		$option->UseImageAndText = TRUE;
		$option->UseDropDownButton = FALSE;
		$option->UseButtonGroup = TRUE;
		$item = &$option->Add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
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
		if ($this->AuditTrailOnView) $this->WriteAuditTrailOnView($row);
		$this->id->setDbValue($rs->fields('id'));
		$this->siswanonrutin_id->setDbValue($rs->fields('siswanonrutin_id'));
		$this->Nilai->setDbValue($rs->fields('Nilai'));
		$this->Tanggal_Bayar->setDbValue($rs->fields('Tanggal_Bayar'));
		$this->Bayar->setDbValue($rs->fields('Bayar'));
		$this->Sisa->setDbValue($rs->fields('Sisa'));
		$this->Periode_Tahun_Bulan->setDbValue($rs->fields('Periode_Tahun_Bulan'));
		$this->Periode_Text->setDbValue($rs->fields('Periode_Text'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->siswanonrutin_id->DbValue = $row['siswanonrutin_id'];
		$this->Nilai->DbValue = $row['Nilai'];
		$this->Tanggal_Bayar->DbValue = $row['Tanggal_Bayar'];
		$this->Bayar->DbValue = $row['Bayar'];
		$this->Sisa->DbValue = $row['Sisa'];
		$this->Periode_Tahun_Bulan->DbValue = $row['Periode_Tahun_Bulan'];
		$this->Periode_Text->DbValue = $row['Periode_Text'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		$this->AddUrl = $this->GetAddUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();
		$this->ListUrl = $this->GetListUrl();
		$this->SetupOtherOptions();

		// Convert decimal values if posted back
		if ($this->Nilai->FormValue == $this->Nilai->CurrentValue && is_numeric(ew_StrToFloat($this->Nilai->CurrentValue)))
			$this->Nilai->CurrentValue = ew_StrToFloat($this->Nilai->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Bayar->FormValue == $this->Bayar->CurrentValue && is_numeric(ew_StrToFloat($this->Bayar->CurrentValue)))
			$this->Bayar->CurrentValue = ew_StrToFloat($this->Bayar->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Sisa->FormValue == $this->Sisa->CurrentValue && is_numeric(ew_StrToFloat($this->Sisa->CurrentValue)))
			$this->Sisa->CurrentValue = ew_StrToFloat($this->Sisa->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// siswanonrutin_id
		// Nilai
		// Tanggal_Bayar
		// Bayar
		// Sisa
		// Periode_Tahun_Bulan
		// Periode_Text

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// siswanonrutin_id
		$this->siswanonrutin_id->ViewValue = $this->siswanonrutin_id->CurrentValue;
		$this->siswanonrutin_id->ViewCustomAttributes = "";

		// Nilai
		$this->Nilai->ViewValue = $this->Nilai->CurrentValue;
		$this->Nilai->ViewCustomAttributes = "";

		// Tanggal_Bayar
		$this->Tanggal_Bayar->ViewValue = $this->Tanggal_Bayar->CurrentValue;
		$this->Tanggal_Bayar->ViewValue = ew_FormatDateTime($this->Tanggal_Bayar->ViewValue, 0);
		$this->Tanggal_Bayar->ViewCustomAttributes = "";

		// Bayar
		$this->Bayar->ViewValue = $this->Bayar->CurrentValue;
		$this->Bayar->ViewCustomAttributes = "";

		// Sisa
		$this->Sisa->ViewValue = $this->Sisa->CurrentValue;
		$this->Sisa->ViewCustomAttributes = "";

		// Periode_Tahun_Bulan
		$this->Periode_Tahun_Bulan->ViewValue = $this->Periode_Tahun_Bulan->CurrentValue;
		$this->Periode_Tahun_Bulan->ViewCustomAttributes = "";

		// Periode_Text
		$this->Periode_Text->ViewValue = $this->Periode_Text->CurrentValue;
		$this->Periode_Text->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// siswanonrutin_id
			$this->siswanonrutin_id->LinkCustomAttributes = "";
			$this->siswanonrutin_id->HrefValue = "";
			$this->siswanonrutin_id->TooltipValue = "";

			// Nilai
			$this->Nilai->LinkCustomAttributes = "";
			$this->Nilai->HrefValue = "";
			$this->Nilai->TooltipValue = "";

			// Tanggal_Bayar
			$this->Tanggal_Bayar->LinkCustomAttributes = "";
			$this->Tanggal_Bayar->HrefValue = "";
			$this->Tanggal_Bayar->TooltipValue = "";

			// Bayar
			$this->Bayar->LinkCustomAttributes = "";
			$this->Bayar->HrefValue = "";
			$this->Bayar->TooltipValue = "";

			// Sisa
			$this->Sisa->LinkCustomAttributes = "";
			$this->Sisa->HrefValue = "";
			$this->Sisa->TooltipValue = "";

			// Periode_Tahun_Bulan
			$this->Periode_Tahun_Bulan->LinkCustomAttributes = "";
			$this->Periode_Tahun_Bulan->HrefValue = "";
			$this->Periode_Tahun_Bulan->TooltipValue = "";

			// Periode_Text
			$this->Periode_Text->LinkCustomAttributes = "";
			$this->Periode_Text->HrefValue = "";
			$this->Periode_Text->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t10_siswanonrutinbayarlist.php"), "", $this->TableVar, TRUE);
		$PageId = "view";
		$Breadcrumb->Add("view", $PageId, $url);
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

	// Page Exporting event
	// $this->ExportDoc = export document object
	function Page_Exporting() {

		//$this->ExportDoc->Text = "my header"; // Export header
		//return FALSE; // Return FALSE to skip default export and use Row_Export event

		return TRUE; // Return TRUE to use default export and skip Row_Export event
	}

	// Row Export event
	// $this->ExportDoc = export document object
	function Row_Export($rs) {

		//$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
	}

	// Page Exported event
	// $this->ExportDoc = export document object
	function Page_Exported() {

		//$this->ExportDoc->Text .= "my footer"; // Export footer
		//echo $this->ExportDoc->Text;

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($t10_siswanonrutinbayar_view)) $t10_siswanonrutinbayar_view = new ct10_siswanonrutinbayar_view();

// Page init
$t10_siswanonrutinbayar_view->Page_Init();

// Page main
$t10_siswanonrutinbayar_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t10_siswanonrutinbayar_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = ft10_siswanonrutinbayarview = new ew_Form("ft10_siswanonrutinbayarview", "view");

// Form_CustomValidate event
ft10_siswanonrutinbayarview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft10_siswanonrutinbayarview.ValidateRequired = true;
<?php } else { ?>
ft10_siswanonrutinbayarview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php if (!$t10_siswanonrutinbayar_view->IsModal) { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php $t10_siswanonrutinbayar_view->ExportOptions->Render("body") ?>
<?php
	foreach ($t10_siswanonrutinbayar_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php if (!$t10_siswanonrutinbayar_view->IsModal) { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php $t10_siswanonrutinbayar_view->ShowPageHeader(); ?>
<?php
$t10_siswanonrutinbayar_view->ShowMessage();
?>
<form name="ft10_siswanonrutinbayarview" id="ft10_siswanonrutinbayarview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t10_siswanonrutinbayar_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t10_siswanonrutinbayar_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t10_siswanonrutinbayar">
<?php if ($t10_siswanonrutinbayar_view->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<table class="table table-bordered table-striped ewViewTable">
<?php if ($t10_siswanonrutinbayar->id->Visible) { // id ?>
	<tr id="r_id">
		<td><span id="elh_t10_siswanonrutinbayar_id"><?php echo $t10_siswanonrutinbayar->id->FldCaption() ?></span></td>
		<td data-name="id"<?php echo $t10_siswanonrutinbayar->id->CellAttributes() ?>>
<span id="el_t10_siswanonrutinbayar_id">
<span<?php echo $t10_siswanonrutinbayar->id->ViewAttributes() ?>>
<?php echo $t10_siswanonrutinbayar->id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t10_siswanonrutinbayar->siswanonrutin_id->Visible) { // siswanonrutin_id ?>
	<tr id="r_siswanonrutin_id">
		<td><span id="elh_t10_siswanonrutinbayar_siswanonrutin_id"><?php echo $t10_siswanonrutinbayar->siswanonrutin_id->FldCaption() ?></span></td>
		<td data-name="siswanonrutin_id"<?php echo $t10_siswanonrutinbayar->siswanonrutin_id->CellAttributes() ?>>
<span id="el_t10_siswanonrutinbayar_siswanonrutin_id">
<span<?php echo $t10_siswanonrutinbayar->siswanonrutin_id->ViewAttributes() ?>>
<?php echo $t10_siswanonrutinbayar->siswanonrutin_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t10_siswanonrutinbayar->Nilai->Visible) { // Nilai ?>
	<tr id="r_Nilai">
		<td><span id="elh_t10_siswanonrutinbayar_Nilai"><?php echo $t10_siswanonrutinbayar->Nilai->FldCaption() ?></span></td>
		<td data-name="Nilai"<?php echo $t10_siswanonrutinbayar->Nilai->CellAttributes() ?>>
<span id="el_t10_siswanonrutinbayar_Nilai">
<span<?php echo $t10_siswanonrutinbayar->Nilai->ViewAttributes() ?>>
<?php echo $t10_siswanonrutinbayar->Nilai->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t10_siswanonrutinbayar->Tanggal_Bayar->Visible) { // Tanggal_Bayar ?>
	<tr id="r_Tanggal_Bayar">
		<td><span id="elh_t10_siswanonrutinbayar_Tanggal_Bayar"><?php echo $t10_siswanonrutinbayar->Tanggal_Bayar->FldCaption() ?></span></td>
		<td data-name="Tanggal_Bayar"<?php echo $t10_siswanonrutinbayar->Tanggal_Bayar->CellAttributes() ?>>
<span id="el_t10_siswanonrutinbayar_Tanggal_Bayar">
<span<?php echo $t10_siswanonrutinbayar->Tanggal_Bayar->ViewAttributes() ?>>
<?php echo $t10_siswanonrutinbayar->Tanggal_Bayar->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t10_siswanonrutinbayar->Bayar->Visible) { // Bayar ?>
	<tr id="r_Bayar">
		<td><span id="elh_t10_siswanonrutinbayar_Bayar"><?php echo $t10_siswanonrutinbayar->Bayar->FldCaption() ?></span></td>
		<td data-name="Bayar"<?php echo $t10_siswanonrutinbayar->Bayar->CellAttributes() ?>>
<span id="el_t10_siswanonrutinbayar_Bayar">
<span<?php echo $t10_siswanonrutinbayar->Bayar->ViewAttributes() ?>>
<?php echo $t10_siswanonrutinbayar->Bayar->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t10_siswanonrutinbayar->Sisa->Visible) { // Sisa ?>
	<tr id="r_Sisa">
		<td><span id="elh_t10_siswanonrutinbayar_Sisa"><?php echo $t10_siswanonrutinbayar->Sisa->FldCaption() ?></span></td>
		<td data-name="Sisa"<?php echo $t10_siswanonrutinbayar->Sisa->CellAttributes() ?>>
<span id="el_t10_siswanonrutinbayar_Sisa">
<span<?php echo $t10_siswanonrutinbayar->Sisa->ViewAttributes() ?>>
<?php echo $t10_siswanonrutinbayar->Sisa->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t10_siswanonrutinbayar->Periode_Tahun_Bulan->Visible) { // Periode_Tahun_Bulan ?>
	<tr id="r_Periode_Tahun_Bulan">
		<td><span id="elh_t10_siswanonrutinbayar_Periode_Tahun_Bulan"><?php echo $t10_siswanonrutinbayar->Periode_Tahun_Bulan->FldCaption() ?></span></td>
		<td data-name="Periode_Tahun_Bulan"<?php echo $t10_siswanonrutinbayar->Periode_Tahun_Bulan->CellAttributes() ?>>
<span id="el_t10_siswanonrutinbayar_Periode_Tahun_Bulan">
<span<?php echo $t10_siswanonrutinbayar->Periode_Tahun_Bulan->ViewAttributes() ?>>
<?php echo $t10_siswanonrutinbayar->Periode_Tahun_Bulan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t10_siswanonrutinbayar->Periode_Text->Visible) { // Periode_Text ?>
	<tr id="r_Periode_Text">
		<td><span id="elh_t10_siswanonrutinbayar_Periode_Text"><?php echo $t10_siswanonrutinbayar->Periode_Text->FldCaption() ?></span></td>
		<td data-name="Periode_Text"<?php echo $t10_siswanonrutinbayar->Periode_Text->CellAttributes() ?>>
<span id="el_t10_siswanonrutinbayar_Periode_Text">
<span<?php echo $t10_siswanonrutinbayar->Periode_Text->ViewAttributes() ?>>
<?php echo $t10_siswanonrutinbayar->Periode_Text->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<script type="text/javascript">
ft10_siswanonrutinbayarview.Init();
</script>
<?php
$t10_siswanonrutinbayar_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t10_siswanonrutinbayar_view->Page_Terminate();
?>
