<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "t07_siswarutinbayarinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$t07_siswarutinbayar_view = NULL; // Initialize page object first

class ct07_siswarutinbayar_view extends ct07_siswarutinbayar {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{64CABE7A-1609-4157-8293-D7242B591905}";

	// Table name
	var $TableName = 't07_siswarutinbayar';

	// Page object name
	var $PageObjName = 't07_siswarutinbayar_view';

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

		// Table object (t07_siswarutinbayar)
		if (!isset($GLOBALS["t07_siswarutinbayar"]) || get_class($GLOBALS["t07_siswarutinbayar"]) == "ct07_siswarutinbayar") {
			$GLOBALS["t07_siswarutinbayar"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t07_siswarutinbayar"];
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
			define("EW_TABLE_NAME", 't07_siswarutinbayar', TRUE);

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
		$this->siswarutin_id->SetVisibility();
		$this->Periode_Tahun_Bulan->SetVisibility();
		$this->Nilai->SetVisibility();
		$this->Tanggal_Bayar->SetVisibility();
		$this->Nilai_Bayar->SetVisibility();
		$this->Bulan->SetVisibility();
		$this->Tahun->SetVisibility();
		$this->Periode_Text->SetVisibility();
		$this->Per_Thn_Bln_Byr->SetVisibility();
		$this->Per_Thn_Bln_Byr_Text->SetVisibility();

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
		global $EW_EXPORT, $t07_siswarutinbayar;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t07_siswarutinbayar);
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
				$sReturnUrl = "t07_siswarutinbayarlist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "t07_siswarutinbayarlist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "t07_siswarutinbayarlist.php"; // Not page request, return to list
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
		$this->siswarutin_id->setDbValue($rs->fields('siswarutin_id'));
		$this->Periode_Tahun_Bulan->setDbValue($rs->fields('Periode_Tahun_Bulan'));
		$this->Nilai->setDbValue($rs->fields('Nilai'));
		$this->Tanggal_Bayar->setDbValue($rs->fields('Tanggal_Bayar'));
		$this->Nilai_Bayar->setDbValue($rs->fields('Nilai_Bayar'));
		$this->Bulan->setDbValue($rs->fields('Bulan'));
		$this->Tahun->setDbValue($rs->fields('Tahun'));
		$this->Periode_Text->setDbValue($rs->fields('Periode_Text'));
		$this->Per_Thn_Bln_Byr->setDbValue($rs->fields('Per_Thn_Bln_Byr'));
		$this->Per_Thn_Bln_Byr_Text->setDbValue($rs->fields('Per_Thn_Bln_Byr_Text'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->siswarutin_id->DbValue = $row['siswarutin_id'];
		$this->Periode_Tahun_Bulan->DbValue = $row['Periode_Tahun_Bulan'];
		$this->Nilai->DbValue = $row['Nilai'];
		$this->Tanggal_Bayar->DbValue = $row['Tanggal_Bayar'];
		$this->Nilai_Bayar->DbValue = $row['Nilai_Bayar'];
		$this->Bulan->DbValue = $row['Bulan'];
		$this->Tahun->DbValue = $row['Tahun'];
		$this->Periode_Text->DbValue = $row['Periode_Text'];
		$this->Per_Thn_Bln_Byr->DbValue = $row['Per_Thn_Bln_Byr'];
		$this->Per_Thn_Bln_Byr_Text->DbValue = $row['Per_Thn_Bln_Byr_Text'];
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
		if ($this->Nilai_Bayar->FormValue == $this->Nilai_Bayar->CurrentValue && is_numeric(ew_StrToFloat($this->Nilai_Bayar->CurrentValue)))
			$this->Nilai_Bayar->CurrentValue = ew_StrToFloat($this->Nilai_Bayar->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// siswarutin_id
		// Periode_Tahun_Bulan
		// Nilai
		// Tanggal_Bayar
		// Nilai_Bayar
		// Bulan
		// Tahun
		// Periode_Text
		// Per_Thn_Bln_Byr
		// Per_Thn_Bln_Byr_Text

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// siswarutin_id
		$this->siswarutin_id->ViewValue = $this->siswarutin_id->CurrentValue;
		$this->siswarutin_id->ViewCustomAttributes = "";

		// Periode_Tahun_Bulan
		if (strval($this->Periode_Tahun_Bulan->CurrentValue) <> "") {
			$sFilterWrk = "`Periode_Tahun_Bulan`" . ew_SearchString("=", $this->Periode_Tahun_Bulan->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Periode_Tahun_Bulan`, `Periode_Text` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t07_siswarutinbayar`";
		$sWhereWrk = "";
		$this->Periode_Tahun_Bulan->LookupFilters = array();
		$lookuptblfilter = "siswarutin_id = ".$this->siswarutin_id->CurrentValue;
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Periode_Tahun_Bulan, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Periode_Tahun_Bulan->ViewValue = $this->Periode_Tahun_Bulan->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Periode_Tahun_Bulan->ViewValue = $this->Periode_Tahun_Bulan->CurrentValue;
			}
		} else {
			$this->Periode_Tahun_Bulan->ViewValue = NULL;
		}
		$this->Periode_Tahun_Bulan->ViewCustomAttributes = "";

		// Nilai
		$this->Nilai->ViewValue = $this->Nilai->CurrentValue;
		$this->Nilai->ViewValue = ew_FormatNumber($this->Nilai->ViewValue, 2, -2, -2, -2);
		$this->Nilai->CellCssStyle .= "text-align: right;";
		$this->Nilai->ViewCustomAttributes = "";

		// Tanggal_Bayar
		$this->Tanggal_Bayar->ViewValue = $this->Tanggal_Bayar->CurrentValue;
		$this->Tanggal_Bayar->ViewValue = ew_FormatDateTime($this->Tanggal_Bayar->ViewValue, 7);
		$this->Tanggal_Bayar->ViewCustomAttributes = "";

		// Nilai_Bayar
		$this->Nilai_Bayar->ViewValue = $this->Nilai_Bayar->CurrentValue;
		$this->Nilai_Bayar->ViewValue = ew_FormatNumber($this->Nilai_Bayar->ViewValue, 2, -2, -2, -2);
		$this->Nilai_Bayar->CellCssStyle .= "text-align: right;";
		$this->Nilai_Bayar->ViewCustomAttributes = "";

		// Bulan
		if (strval($this->Bulan->CurrentValue) <> "") {
			$sFilterWrk = "`Bulan`" . ew_SearchString("=", $this->Bulan->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Bulan`, `Bulan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t07_siswarutinbayar`";
		$sWhereWrk = "";
		$this->Bulan->LookupFilters = array();
		$lookuptblfilter = "siswarutin_id = ".$this->siswarutin_id->CurrentValue;
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Bulan, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Bulan->ViewValue = $this->Bulan->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Bulan->ViewValue = $this->Bulan->CurrentValue;
			}
		} else {
			$this->Bulan->ViewValue = NULL;
		}
		$this->Bulan->ViewCustomAttributes = "";

		// Tahun
		if (strval($this->Tahun->CurrentValue) <> "") {
			$sFilterWrk = "`Tahun`" . ew_SearchString("=", $this->Tahun->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Tahun`, `Tahun` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t07_siswarutinbayar`";
		$sWhereWrk = "";
		$this->Tahun->LookupFilters = array();
		$lookuptblfilter = "siswarutin_id = ".$this->siswarutin_id->CurrentValue;
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Tahun, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Tahun->ViewValue = $this->Tahun->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Tahun->ViewValue = $this->Tahun->CurrentValue;
			}
		} else {
			$this->Tahun->ViewValue = NULL;
		}
		$this->Tahun->ViewCustomAttributes = "";

		// Periode_Text
		if (strval($this->Periode_Text->CurrentValue) <> "") {
			$sFilterWrk = "`Periode_Text`" . ew_SearchString("=", $this->Periode_Text->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Periode_Text`, `Periode_Text` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t07_siswarutinbayar`";
		$sWhereWrk = "";
		$this->Periode_Text->LookupFilters = array();
		$lookuptblfilter = "siswarutin_id = ".$this->siswarutin_id->CurrentValue;
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Periode_Text, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Periode_Text->ViewValue = $this->Periode_Text->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Periode_Text->ViewValue = $this->Periode_Text->CurrentValue;
			}
		} else {
			$this->Periode_Text->ViewValue = NULL;
		}
		$this->Periode_Text->ViewCustomAttributes = "";

		// Per_Thn_Bln_Byr
		$this->Per_Thn_Bln_Byr->ViewValue = $this->Per_Thn_Bln_Byr->CurrentValue;
		$this->Per_Thn_Bln_Byr->ViewCustomAttributes = "";

		// Per_Thn_Bln_Byr_Text
		$this->Per_Thn_Bln_Byr_Text->ViewValue = $this->Per_Thn_Bln_Byr_Text->CurrentValue;
		$this->Per_Thn_Bln_Byr_Text->ViewCustomAttributes = "";

			// siswarutin_id
			$this->siswarutin_id->LinkCustomAttributes = "";
			$this->siswarutin_id->HrefValue = "";
			$this->siswarutin_id->TooltipValue = "";

			// Periode_Tahun_Bulan
			$this->Periode_Tahun_Bulan->LinkCustomAttributes = "";
			$this->Periode_Tahun_Bulan->HrefValue = "";
			$this->Periode_Tahun_Bulan->TooltipValue = "";

			// Nilai
			$this->Nilai->LinkCustomAttributes = "";
			$this->Nilai->HrefValue = "";
			$this->Nilai->TooltipValue = "";

			// Tanggal_Bayar
			$this->Tanggal_Bayar->LinkCustomAttributes = "";
			$this->Tanggal_Bayar->HrefValue = "";
			$this->Tanggal_Bayar->TooltipValue = "";

			// Nilai_Bayar
			$this->Nilai_Bayar->LinkCustomAttributes = "";
			$this->Nilai_Bayar->HrefValue = "";
			$this->Nilai_Bayar->TooltipValue = "";

			// Bulan
			$this->Bulan->LinkCustomAttributes = "";
			$this->Bulan->HrefValue = "";
			$this->Bulan->TooltipValue = "";

			// Tahun
			$this->Tahun->LinkCustomAttributes = "";
			$this->Tahun->HrefValue = "";
			$this->Tahun->TooltipValue = "";

			// Periode_Text
			$this->Periode_Text->LinkCustomAttributes = "";
			$this->Periode_Text->HrefValue = "";
			$this->Periode_Text->TooltipValue = "";

			// Per_Thn_Bln_Byr
			$this->Per_Thn_Bln_Byr->LinkCustomAttributes = "";
			$this->Per_Thn_Bln_Byr->HrefValue = "";
			$this->Per_Thn_Bln_Byr->TooltipValue = "";

			// Per_Thn_Bln_Byr_Text
			$this->Per_Thn_Bln_Byr_Text->LinkCustomAttributes = "";
			$this->Per_Thn_Bln_Byr_Text->HrefValue = "";
			$this->Per_Thn_Bln_Byr_Text->TooltipValue = "";
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t07_siswarutinbayarlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($t07_siswarutinbayar_view)) $t07_siswarutinbayar_view = new ct07_siswarutinbayar_view();

// Page init
$t07_siswarutinbayar_view->Page_Init();

// Page main
$t07_siswarutinbayar_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t07_siswarutinbayar_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = ft07_siswarutinbayarview = new ew_Form("ft07_siswarutinbayarview", "view");

// Form_CustomValidate event
ft07_siswarutinbayarview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft07_siswarutinbayarview.ValidateRequired = true;
<?php } else { ?>
ft07_siswarutinbayarview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft07_siswarutinbayarview.Lists["x_Periode_Tahun_Bulan"] = {"LinkField":"x_Periode_Tahun_Bulan","Ajax":true,"AutoFill":false,"DisplayFields":["x_Periode_Text","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t07_siswarutinbayar"};
ft07_siswarutinbayarview.Lists["x_Bulan"] = {"LinkField":"x_Bulan","Ajax":true,"AutoFill":false,"DisplayFields":["x_Bulan","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t07_siswarutinbayar"};
ft07_siswarutinbayarview.Lists["x_Tahun"] = {"LinkField":"x_Tahun","Ajax":true,"AutoFill":false,"DisplayFields":["x_Tahun","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t07_siswarutinbayar"};
ft07_siswarutinbayarview.Lists["x_Periode_Text"] = {"LinkField":"x_Periode_Text","Ajax":true,"AutoFill":false,"DisplayFields":["x_Periode_Text","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t07_siswarutinbayar"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php if (!$t07_siswarutinbayar_view->IsModal) { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php $t07_siswarutinbayar_view->ExportOptions->Render("body") ?>
<?php
	foreach ($t07_siswarutinbayar_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php if (!$t07_siswarutinbayar_view->IsModal) { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php $t07_siswarutinbayar_view->ShowPageHeader(); ?>
<?php
$t07_siswarutinbayar_view->ShowMessage();
?>
<form name="ft07_siswarutinbayarview" id="ft07_siswarutinbayarview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t07_siswarutinbayar_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t07_siswarutinbayar_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t07_siswarutinbayar">
<?php if ($t07_siswarutinbayar_view->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<table class="table table-bordered table-striped ewViewTable">
<?php if ($t07_siswarutinbayar->siswarutin_id->Visible) { // siswarutin_id ?>
	<tr id="r_siswarutin_id">
		<td><span id="elh_t07_siswarutinbayar_siswarutin_id"><?php echo $t07_siswarutinbayar->siswarutin_id->FldCaption() ?></span></td>
		<td data-name="siswarutin_id"<?php echo $t07_siswarutinbayar->siswarutin_id->CellAttributes() ?>>
<span id="el_t07_siswarutinbayar_siswarutin_id">
<span<?php echo $t07_siswarutinbayar->siswarutin_id->ViewAttributes() ?>>
<?php echo $t07_siswarutinbayar->siswarutin_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t07_siswarutinbayar->Periode_Tahun_Bulan->Visible) { // Periode_Tahun_Bulan ?>
	<tr id="r_Periode_Tahun_Bulan">
		<td><span id="elh_t07_siswarutinbayar_Periode_Tahun_Bulan"><?php echo $t07_siswarutinbayar->Periode_Tahun_Bulan->FldCaption() ?></span></td>
		<td data-name="Periode_Tahun_Bulan"<?php echo $t07_siswarutinbayar->Periode_Tahun_Bulan->CellAttributes() ?>>
<span id="el_t07_siswarutinbayar_Periode_Tahun_Bulan">
<span<?php echo $t07_siswarutinbayar->Periode_Tahun_Bulan->ViewAttributes() ?>>
<?php echo $t07_siswarutinbayar->Periode_Tahun_Bulan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t07_siswarutinbayar->Nilai->Visible) { // Nilai ?>
	<tr id="r_Nilai">
		<td><span id="elh_t07_siswarutinbayar_Nilai"><?php echo $t07_siswarutinbayar->Nilai->FldCaption() ?></span></td>
		<td data-name="Nilai"<?php echo $t07_siswarutinbayar->Nilai->CellAttributes() ?>>
<span id="el_t07_siswarutinbayar_Nilai">
<span<?php echo $t07_siswarutinbayar->Nilai->ViewAttributes() ?>>
<?php echo $t07_siswarutinbayar->Nilai->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t07_siswarutinbayar->Tanggal_Bayar->Visible) { // Tanggal_Bayar ?>
	<tr id="r_Tanggal_Bayar">
		<td><span id="elh_t07_siswarutinbayar_Tanggal_Bayar"><?php echo $t07_siswarutinbayar->Tanggal_Bayar->FldCaption() ?></span></td>
		<td data-name="Tanggal_Bayar"<?php echo $t07_siswarutinbayar->Tanggal_Bayar->CellAttributes() ?>>
<span id="el_t07_siswarutinbayar_Tanggal_Bayar">
<span<?php echo $t07_siswarutinbayar->Tanggal_Bayar->ViewAttributes() ?>>
<?php echo $t07_siswarutinbayar->Tanggal_Bayar->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t07_siswarutinbayar->Nilai_Bayar->Visible) { // Nilai_Bayar ?>
	<tr id="r_Nilai_Bayar">
		<td><span id="elh_t07_siswarutinbayar_Nilai_Bayar"><?php echo $t07_siswarutinbayar->Nilai_Bayar->FldCaption() ?></span></td>
		<td data-name="Nilai_Bayar"<?php echo $t07_siswarutinbayar->Nilai_Bayar->CellAttributes() ?>>
<span id="el_t07_siswarutinbayar_Nilai_Bayar">
<span<?php echo $t07_siswarutinbayar->Nilai_Bayar->ViewAttributes() ?>>
<?php echo $t07_siswarutinbayar->Nilai_Bayar->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t07_siswarutinbayar->Bulan->Visible) { // Bulan ?>
	<tr id="r_Bulan">
		<td><span id="elh_t07_siswarutinbayar_Bulan"><?php echo $t07_siswarutinbayar->Bulan->FldCaption() ?></span></td>
		<td data-name="Bulan"<?php echo $t07_siswarutinbayar->Bulan->CellAttributes() ?>>
<span id="el_t07_siswarutinbayar_Bulan">
<span<?php echo $t07_siswarutinbayar->Bulan->ViewAttributes() ?>>
<?php echo $t07_siswarutinbayar->Bulan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t07_siswarutinbayar->Tahun->Visible) { // Tahun ?>
	<tr id="r_Tahun">
		<td><span id="elh_t07_siswarutinbayar_Tahun"><?php echo $t07_siswarutinbayar->Tahun->FldCaption() ?></span></td>
		<td data-name="Tahun"<?php echo $t07_siswarutinbayar->Tahun->CellAttributes() ?>>
<span id="el_t07_siswarutinbayar_Tahun">
<span<?php echo $t07_siswarutinbayar->Tahun->ViewAttributes() ?>>
<?php echo $t07_siswarutinbayar->Tahun->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t07_siswarutinbayar->Periode_Text->Visible) { // Periode_Text ?>
	<tr id="r_Periode_Text">
		<td><span id="elh_t07_siswarutinbayar_Periode_Text"><?php echo $t07_siswarutinbayar->Periode_Text->FldCaption() ?></span></td>
		<td data-name="Periode_Text"<?php echo $t07_siswarutinbayar->Periode_Text->CellAttributes() ?>>
<span id="el_t07_siswarutinbayar_Periode_Text">
<span<?php echo $t07_siswarutinbayar->Periode_Text->ViewAttributes() ?>>
<?php echo $t07_siswarutinbayar->Periode_Text->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t07_siswarutinbayar->Per_Thn_Bln_Byr->Visible) { // Per_Thn_Bln_Byr ?>
	<tr id="r_Per_Thn_Bln_Byr">
		<td><span id="elh_t07_siswarutinbayar_Per_Thn_Bln_Byr"><?php echo $t07_siswarutinbayar->Per_Thn_Bln_Byr->FldCaption() ?></span></td>
		<td data-name="Per_Thn_Bln_Byr"<?php echo $t07_siswarutinbayar->Per_Thn_Bln_Byr->CellAttributes() ?>>
<span id="el_t07_siswarutinbayar_Per_Thn_Bln_Byr">
<span<?php echo $t07_siswarutinbayar->Per_Thn_Bln_Byr->ViewAttributes() ?>>
<?php echo $t07_siswarutinbayar->Per_Thn_Bln_Byr->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t07_siswarutinbayar->Per_Thn_Bln_Byr_Text->Visible) { // Per_Thn_Bln_Byr_Text ?>
	<tr id="r_Per_Thn_Bln_Byr_Text">
		<td><span id="elh_t07_siswarutinbayar_Per_Thn_Bln_Byr_Text"><?php echo $t07_siswarutinbayar->Per_Thn_Bln_Byr_Text->FldCaption() ?></span></td>
		<td data-name="Per_Thn_Bln_Byr_Text"<?php echo $t07_siswarutinbayar->Per_Thn_Bln_Byr_Text->CellAttributes() ?>>
<span id="el_t07_siswarutinbayar_Per_Thn_Bln_Byr_Text">
<span<?php echo $t07_siswarutinbayar->Per_Thn_Bln_Byr_Text->ViewAttributes() ?>>
<?php echo $t07_siswarutinbayar->Per_Thn_Bln_Byr_Text->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<script type="text/javascript">
ft07_siswarutinbayarview.Init();
</script>
<?php
$t07_siswarutinbayar_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t07_siswarutinbayar_view->Page_Terminate();
?>
