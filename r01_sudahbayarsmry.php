<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start();
?>
<?php include_once "phprptinc/ewrcfg10.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "phprptinc/ewmysql.php") ?>
<?php include_once "phprptinc/ewrfn10.php" ?>
<?php include_once "phprptinc/ewrusrfn10.php" ?>
<?php include_once "r01_sudahbayarsmryinfo.php" ?>
<?php

//
// Page class
//

$r01_sudahbayar_summary = NULL; // Initialize page object first

class crr01_sudahbayar_summary extends crr01_sudahbayar {

	// Page ID
	var $PageID = 'summary';

	// Project ID
	var $ProjectID = "{0BB1DC5C-09DE-419A-9701-F3161918C007}";

	// Page object name
	var $PageObjName = 'r01_sudahbayar_summary';

	// Page name
	function PageName() {
		return ewr_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ewr_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Export URLs
	var $ExportPrintUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportPdfUrl;
	var $ReportTableClass;
	var $ReportTableStyle = "";

	// Custom export
	var $ExportPrintCustom = FALSE;
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Message
	function getMessage() {
		return @$_SESSION[EWR_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ewr_AddMessage($_SESSION[EWR_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EWR_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ewr_AddMessage($_SESSION[EWR_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EWR_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ewr_AddMessage($_SESSION[EWR_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EWR_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ewr_AddMessage($_SESSION[EWR_SESSION_WARNING_MESSAGE], $v);
	}

		// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EWR_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EWR_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EWR_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EWR_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog ewDisplayTable\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") // Header exists, display
			echo $sHeader;
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") // Fotoer exists, display
			echo $sFooter;
	}

	// Validate page request
	function IsPageRequest() {
		if ($this->UseTokenInUrl) {
			if (ewr_IsHttpPost())
				return ($this->TableVar == @$_POST("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == @$_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $CheckToken = EWR_CHECK_TOKEN;
	var $CheckTokenFn = "ewr_CheckToken";
	var $CreateTokenFn = "ewr_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ewr_IsHttpPost())
			return TRUE;
		if (!isset($_POST[EWR_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EWR_TOKEN_NAME]);
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
		global $conn, $ReportLanguage;

		// Language object
		$ReportLanguage = new crLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (r01_sudahbayar)
		if (!isset($GLOBALS["r01_sudahbayar"])) {
			$GLOBALS["r01_sudahbayar"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["r01_sudahbayar"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";

		// Page ID
		if (!defined("EWR_PAGE_ID"))
			define("EWR_PAGE_ID", 'summary', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EWR_TABLE_NAME"))
			define("EWR_TABLE_NAME", 'r01_sudahbayar', TRUE);

		// Start timer
		$GLOBALS["gsTimer"] = new crTimer();

		// Open connection
		if (!isset($conn)) $conn = ewr_Connect($this->DBID);

		// Export options
		$this->ExportOptions = new crListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Search options
		$this->SearchOptions = new crListOptions();
		$this->SearchOptions->Tag = "div";
		$this->SearchOptions->TagClassName = "ewSearchOption";

		// Filter options
		$this->FilterOptions = new crListOptions();
		$this->FilterOptions->Tag = "div";
		$this->FilterOptions->TagClassName = "ewFilterOption fr01_sudahbayarsummary";

		// Generate report options
		$this->GenerateOptions = new crListOptions();
		$this->GenerateOptions->Tag = "div";
		$this->GenerateOptions->TagClassName = "ewGenerateOption";
	}

	//
	// Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $gsEmailContentType, $ReportLanguage, $Security;
		global $gsCustomExport;

		// Get export parameters
		if (@$_GET["export"] <> "")
			$this->Export = strtolower($_GET["export"]);
		elseif (@$_POST["export"] <> "")
			$this->Export = strtolower($_POST["export"]);
		$gsExport = $this->Export; // Get export parameter, used in header
		$gsExportFile = $this->TableVar; // Get export file, used in header
		$gsEmailContentType = @$_POST["contenttype"]; // Get email content type

		// Setup placeholder
		// Setup export options

		$this->SetupExportOptions();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $ReportLanguage->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Create Token
		$this->CreateToken();
	}

	// Set up export options
	function SetupExportOptions() {
		global $Security, $ReportLanguage, $ReportOptions;
		$exportid = session_id();
		$ReportTypes = array();

		// Printer friendly
		$item = &$this->ExportOptions->Add("print");
		$item->Body = "<a title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("PrinterFriendly", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("PrinterFriendly", TRUE)) . "\" href=\"" . $this->ExportPrintUrl . "\">" . $ReportLanguage->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = TRUE;
		$ReportTypes["print"] = $item->Visible ? $ReportLanguage->Phrase("ReportFormPrint") : "";

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToExcel", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToExcel", TRUE)) . "\" href=\"" . $this->ExportExcelUrl . "\">" . $ReportLanguage->Phrase("ExportToExcel") . "</a>";
		$item->Visible = TRUE;
		$ReportTypes["excel"] = $item->Visible ? $ReportLanguage->Phrase("ReportFormExcel") : "";

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToWord", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToWord", TRUE)) . "\" href=\"" . $this->ExportWordUrl . "\">" . $ReportLanguage->Phrase("ExportToWord") . "</a>";

		//$item->Visible = TRUE;
		$item->Visible = TRUE;
		$ReportTypes["word"] = $item->Visible ? $ReportLanguage->Phrase("ReportFormWord") : "";

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToPDF", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToPDF", TRUE)) . "\" href=\"" . $this->ExportPdfUrl . "\">" . $ReportLanguage->Phrase("ExportToPDF") . "</a>";
		$item->Visible = FALSE;

		// Uncomment codes below to show export to Pdf link
//		$item->Visible = TRUE;

		$ReportTypes["pdf"] = $item->Visible ? $ReportLanguage->Phrase("ReportFormPdf") : "";

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$url = $this->PageUrl() . "export=email";
		$item->Body = "<a title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToEmail", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToEmail", TRUE)) . "\" id=\"emf_r01_sudahbayar\" href=\"javascript:void(0);\" onclick=\"ewr_EmailDialogShow({lnk:'emf_r01_sudahbayar',hdr:ewLanguage.Phrase('ExportToEmail'),url:'$url',exportid:'$exportid',el:this});\">" . $ReportLanguage->Phrase("ExportToEmail") . "</a>";
		$item->Visible = FALSE;
		$ReportTypes["email"] = $item->Visible ? $ReportLanguage->Phrase("ReportFormEmail") : "";
		$ReportOptions["ReportTypes"] = $ReportTypes;

		// Drop down button for export
		$this->ExportOptions->UseDropDownButton = FALSE;
		$this->ExportOptions->UseButtonGroup = TRUE;
		$this->ExportOptions->UseImageAndText = $this->ExportOptions->UseDropDownButton;
		$this->ExportOptions->DropDownButtonPhrase = $ReportLanguage->Phrase("ButtonExport");

		// Add group option item
		$item = &$this->ExportOptions->Add($this->ExportOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Filter button
		$item = &$this->FilterOptions->Add("savecurrentfilter");
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fr01_sudahbayarsummary\" href=\"#\">" . $ReportLanguage->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fr01_sudahbayarsummary\" href=\"#\">" . $ReportLanguage->Phrase("DeleteFilter") . "</a>";
		$item->Visible = TRUE;
		$this->FilterOptions->UseDropDownButton = TRUE;
		$this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton; // v8
		$this->FilterOptions->DropDownButtonPhrase = $ReportLanguage->Phrase("Filters");

		// Add group option item
		$item = &$this->FilterOptions->Add($this->FilterOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Set up options (extended)
		$this->SetupExportOptionsExt();

		// Hide options for export
		if ($this->Export <> "") {
			$this->ExportOptions->HideAllOptions();
			$this->FilterOptions->HideAllOptions();
		}

		// Set up table class
		if ($this->Export == "word" || $this->Export == "excel" || $this->Export == "pdf")
			$this->ReportTableClass = "ewTable";
		else
			$this->ReportTableClass = "table ewTable";
	}

	// Set up search options
	function SetupSearchOptions() {
		global $ReportLanguage;

		// Filter panel button
		$item = &$this->SearchOptions->Add("searchtoggle");
		$SearchToggleClass = $this->FilterApplied ? " active" : " active";
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $ReportLanguage->Phrase("SearchBtn", TRUE) . "\" data-caption=\"" . $ReportLanguage->Phrase("SearchBtn", TRUE) . "\" data-toggle=\"button\" data-form=\"fr01_sudahbayarsummary\">" . $ReportLanguage->Phrase("SearchBtn") . "</button>";
		$item->Visible = TRUE;

		// Reset filter
		$item = &$this->SearchOptions->Add("resetfilter");
		$item->Body = "<button type=\"button\" class=\"btn btn-default\" title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ResetAllFilter", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ResetAllFilter", TRUE)) . "\" onclick=\"location='" . ewr_CurrentPage() . "?cmd=reset'\">" . $ReportLanguage->Phrase("ResetAllFilter") . "</button>";
		$item->Visible = TRUE && $this->FilterApplied;

		// Button group for reset filter
		$this->SearchOptions->UseButtonGroup = TRUE;

		// Add group option item
		$item = &$this->SearchOptions->Add($this->SearchOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide options for export
		if ($this->Export <> "")
			$this->SearchOptions->HideAllOptions();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $ReportLanguage, $EWR_EXPORT, $gsExportFile;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		if ($this->Export <> "" && array_key_exists($this->Export, $EWR_EXPORT)) {
			$sContent = ob_get_contents();
			if (ob_get_length())
				ob_end_clean();

			// Remove all <div data-tagid="..." id="orig..." class="hide">...</div> (for customviewtag export, except "googlemaps")
			if (preg_match_all('/<div\s+data-tagid=[\'"]([\s\S]*?)[\'"]\s+id=[\'"]orig([\s\S]*?)[\'"]\s+class\s*=\s*[\'"]hide[\'"]>([\s\S]*?)<\/div\s*>/i', $sContent, $divmatches, PREG_SET_ORDER)) {
				foreach ($divmatches as $divmatch) {
					if ($divmatch[1] <> "googlemaps")
						$sContent = str_replace($divmatch[0], '', $sContent);
				}
			}
			$fn = $EWR_EXPORT[$this->Export];
			if ($this->Export == "email") { // Email
				if (@$this->GenOptions["reporttype"] == "email") {
					$saveResponse = $this->$fn($sContent, $this->GenOptions);
					$this->WriteGenResponse($saveResponse);
				} else {
					echo $this->$fn($sContent, array());
				}
				$url = ""; // Avoid redirect
			} else {
				$saveToFile = $this->$fn($sContent, $this->GenOptions);
				if (@$this->GenOptions["reporttype"] <> "") {
					$saveUrl = ($saveToFile <> "") ? ewr_ConvertFullUrl($saveToFile) : $ReportLanguage->Phrase("GenerateSuccess");
					$this->WriteGenResponse($saveUrl);
					$url = ""; // Avoid redirect
				}
			}
		}

		 // Close connection
		ewr_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EWR_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}

	// Initialize common variables
	var $ExportOptions; // Export options
	var $SearchOptions; // Search options
	var $FilterOptions; // Filter options

	// Paging variables
	var $RecIndex = 0; // Record index
	var $RecCount = 0; // Record count
	var $StartGrp = 0; // Start group
	var $StopGrp = 0; // Stop group
	var $TotalGrps = 0; // Total groups
	var $GrpCount = 0; // Group count
	var $GrpCounter = array(); // Group counter
	var $DisplayGrps = 10; // Groups per page
	var $GrpRange = 10;
	var $Sort = "";
	var $Filter = "";
	var $PageFirstGroupFilter = "";
	var $UserIDFilter = "";
	var $DrillDown = FALSE;
	var $DrillDownInPanel = FALSE;
	var $DrillDownList = "";

	// Clear field for ext filter
	var $ClearExtFilter = "";
	var $PopupName = "";
	var $PopupValue = "";
	var $FilterApplied;
	var $SearchCommand = FALSE;
	var $ShowHeader;
	var $GrpColumnCount = 0;
	var $SubGrpColumnCount = 0;
	var $DtlColumnCount = 0;
	var $Cnt, $Col, $Val, $Smry, $Mn, $Mx, $GrandCnt, $GrandSmry, $GrandMn, $GrandMx;
	var $TotCount;
	var $GrandSummarySetup = FALSE;
	var $GrpIdx;
	var $DetailRows = array();

	//
	// Page main
	//
	function Page_Main() {
		global $rs;
		global $rsgrp;
		global $Security;
		global $gsFormError;
		global $gbDrillDownInPanel;
		global $ReportBreadcrumb;
		global $ReportLanguage;

		// Set field visibility for detail fields
		$this->Periode_Tahun_Bulan->SetVisibility();
		$this->Periode_Text->SetVisibility();
		$this->Nilai->SetVisibility();

		// Aggregate variables
		// 1st dimension = no of groups (level 0 used for grand total)
		// 2nd dimension = no of fields

		$nDtls = 4;
		$nGrps = 6;
		$this->Val = &ewr_InitArray($nDtls, 0);
		$this->Cnt = &ewr_Init2DArray($nGrps, $nDtls, 0);
		$this->Smry = &ewr_Init2DArray($nGrps, $nDtls, 0);
		$this->Mn = &ewr_Init2DArray($nGrps, $nDtls, NULL);
		$this->Mx = &ewr_Init2DArray($nGrps, $nDtls, NULL);
		$this->GrandCnt = &ewr_InitArray($nDtls, 0);
		$this->GrandSmry = &ewr_InitArray($nDtls, 0);
		$this->GrandMn = &ewr_InitArray($nDtls, NULL);
		$this->GrandMx = &ewr_InitArray($nDtls, NULL);

		// Set up array if accumulation required: array(Accum, SkipNullOrZero)
		$this->Col = array(array(FALSE, FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(TRUE,FALSE));

		// Set up groups per page dynamically
		$this->SetUpDisplayGrps();

		// Set up Breadcrumb
		if ($this->Export == "")
			$this->SetupBreadcrumb();

		// Check if search command
		$this->SearchCommand = (@$_GET["cmd"] == "search");

		// Load default filter values
		$this->LoadDefaultFilters();

		// Load custom filters
		$this->Page_FilterLoad();

		// Set up popup filter
		$this->SetupPopup();

		// Load group db values if necessary
		$this->LoadGroupDbValues();

		// Handle Ajax popup
		$this->ProcessAjaxPopup();

		// Extended filter
		$sExtendedFilter = "";

		// Restore filter list
		$this->RestoreFilterList();

		// Build extended filter
		$sExtendedFilter = $this->GetExtendedFilter();
		ewr_AddFilter($this->Filter, $sExtendedFilter);

		// Build popup filter
		$sPopupFilter = $this->GetPopupFilter();

		//ewr_SetDebugMsg("popup filter: " . $sPopupFilter);
		ewr_AddFilter($this->Filter, $sPopupFilter);

		// Check if filter applied
		$this->FilterApplied = $this->CheckFilter();

		// Call Page Selecting event
		$this->Page_Selecting($this->Filter);

		// Requires search criteria
		if (($this->Filter == $this->UserIDFilter || $gsFormError != "") && !$this->DrillDown)
			$this->Filter = "0=101";

		// Search options
		$this->SetupSearchOptions();

		// Get sort
		$this->Sort = $this->GetSort($this->GenOptions);

		// Get total group count
		$sGrpSort = ewr_UpdateSortFields($this->getSqlOrderByGroup(), $this->Sort, 2); // Get grouping field only
		$sSql = ewr_BuildReportSql($this->getSqlSelectGroup(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderByGroup(), $this->Filter, $sGrpSort);
		$this->TotalGrps = $this->GetGrpCnt($sSql);
		if ($this->DisplayGrps <= 0 || $this->DrillDown) // Display all groups
			$this->DisplayGrps = $this->TotalGrps;
		$this->StartGrp = 1;

		// Show header
		$this->ShowHeader = ($this->TotalGrps > 0);

		// Set up start position if not export all
		if ($this->ExportAll && $this->Export <> "")
			$this->DisplayGrps = $this->TotalGrps;
		else
			$this->SetUpStartGroup($this->GenOptions);

		// Set no record found message
		if ($this->TotalGrps == 0) {
				if ($this->Filter == "0=101") {
					$this->setWarningMessage($ReportLanguage->Phrase("EnterSearchCriteria"));
				} else {
					$this->setWarningMessage($ReportLanguage->Phrase("NoRecord"));
				}
		}

		// Hide export options if export
		if ($this->Export <> "")
			$this->ExportOptions->HideAllOptions();

		// Hide search/filter options if export/drilldown
		if ($this->Export <> "" || $this->DrillDown) {
			$this->SearchOptions->HideAllOptions();
			$this->FilterOptions->HideAllOptions();
			$this->GenerateOptions->HideAllOptions();
		}

		// Get current page groups
		$rsgrp = $this->GetGrpRs($sSql, $this->StartGrp, $this->DisplayGrps);

		// Init detail recordset
		$rs = NULL;
		$this->SetupFieldCount();
	}

	// Get summary count
	function GetSummaryCount($lvl, $curValue = TRUE) {
		$cnt = 0;
		foreach ($this->DetailRows as $row) {
			$wrkSekolah = $row["Sekolah"];
			$wrkKelas = $row["Kelas"];
			$wrkNIS = $row["NIS"];
			$wrkNama = $row["Nama"];
			$wrkJenis = $row["Jenis"];
			if ($lvl >= 1) {
				$val = $curValue ? $this->Sekolah->CurrentValue : $this->Sekolah->OldValue;
				$grpval = $curValue ? $this->Sekolah->GroupValue() : $this->Sekolah->GroupOldValue();
				if (is_null($val) && !is_null($wrkSekolah) || !is_null($val) && is_null($wrkSekolah) ||
					$grpval <> $this->Sekolah->getGroupValueBase($wrkSekolah))
				continue;
			}
			if ($lvl >= 2) {
				$val = $curValue ? $this->Kelas->CurrentValue : $this->Kelas->OldValue;
				$grpval = $curValue ? $this->Kelas->GroupValue() : $this->Kelas->GroupOldValue();
				if (is_null($val) && !is_null($wrkKelas) || !is_null($val) && is_null($wrkKelas) ||
					$grpval <> $this->Kelas->getGroupValueBase($wrkKelas))
				continue;
			}
			if ($lvl >= 3) {
				$val = $curValue ? $this->NIS->CurrentValue : $this->NIS->OldValue;
				$grpval = $curValue ? $this->NIS->GroupValue() : $this->NIS->GroupOldValue();
				if (is_null($val) && !is_null($wrkNIS) || !is_null($val) && is_null($wrkNIS) ||
					$grpval <> $this->NIS->getGroupValueBase($wrkNIS))
				continue;
			}
			if ($lvl >= 4) {
				$val = $curValue ? $this->Nama->CurrentValue : $this->Nama->OldValue;
				$grpval = $curValue ? $this->Nama->GroupValue() : $this->Nama->GroupOldValue();
				if (is_null($val) && !is_null($wrkNama) || !is_null($val) && is_null($wrkNama) ||
					$grpval <> $this->Nama->getGroupValueBase($wrkNama))
				continue;
			}
			if ($lvl >= 5) {
				$val = $curValue ? $this->Jenis->CurrentValue : $this->Jenis->OldValue;
				$grpval = $curValue ? $this->Jenis->GroupValue() : $this->Jenis->GroupOldValue();
				if (is_null($val) && !is_null($wrkJenis) || !is_null($val) && is_null($wrkJenis) ||
					$grpval <> $this->Jenis->getGroupValueBase($wrkJenis))
				continue;
			}
			$cnt++;
		}
		return $cnt;
	}

	// Check level break
	function ChkLvlBreak($lvl) {
		switch ($lvl) {
			case 1:
				return (is_null($this->Sekolah->CurrentValue) && !is_null($this->Sekolah->OldValue)) ||
					(!is_null($this->Sekolah->CurrentValue) && is_null($this->Sekolah->OldValue)) ||
					($this->Sekolah->GroupValue() <> $this->Sekolah->GroupOldValue());
			case 2:
				return (is_null($this->Kelas->CurrentValue) && !is_null($this->Kelas->OldValue)) ||
					(!is_null($this->Kelas->CurrentValue) && is_null($this->Kelas->OldValue)) ||
					($this->Kelas->GroupValue() <> $this->Kelas->GroupOldValue()) || $this->ChkLvlBreak(1); // Recurse upper level
			case 3:
				return (is_null($this->NIS->CurrentValue) && !is_null($this->NIS->OldValue)) ||
					(!is_null($this->NIS->CurrentValue) && is_null($this->NIS->OldValue)) ||
					($this->NIS->GroupValue() <> $this->NIS->GroupOldValue()) || $this->ChkLvlBreak(2); // Recurse upper level
			case 4:
				return (is_null($this->Nama->CurrentValue) && !is_null($this->Nama->OldValue)) ||
					(!is_null($this->Nama->CurrentValue) && is_null($this->Nama->OldValue)) ||
					($this->Nama->GroupValue() <> $this->Nama->GroupOldValue()) || $this->ChkLvlBreak(3); // Recurse upper level
			case 5:
				return (is_null($this->Jenis->CurrentValue) && !is_null($this->Jenis->OldValue)) ||
					(!is_null($this->Jenis->CurrentValue) && is_null($this->Jenis->OldValue)) ||
					($this->Jenis->GroupValue() <> $this->Jenis->GroupOldValue()) || $this->ChkLvlBreak(4); // Recurse upper level
		}
	}

	// Accummulate summary
	function AccumulateSummary() {
		$cntx = count($this->Smry);
		for ($ix = 0; $ix < $cntx; $ix++) {
			$cnty = count($this->Smry[$ix]);
			for ($iy = 1; $iy < $cnty; $iy++) {
				if ($this->Col[$iy][0]) { // Accumulate required
					$valwrk = $this->Val[$iy];
					if (is_null($valwrk)) {
						if (!$this->Col[$iy][1])
							$this->Cnt[$ix][$iy]++;
					} else {
						$accum = (!$this->Col[$iy][1] || !is_numeric($valwrk) || $valwrk <> 0);
						if ($accum) {
							$this->Cnt[$ix][$iy]++;
							if (is_numeric($valwrk)) {
								$this->Smry[$ix][$iy] += $valwrk;
								if (is_null($this->Mn[$ix][$iy])) {
									$this->Mn[$ix][$iy] = $valwrk;
									$this->Mx[$ix][$iy] = $valwrk;
								} else {
									if ($this->Mn[$ix][$iy] > $valwrk) $this->Mn[$ix][$iy] = $valwrk;
									if ($this->Mx[$ix][$iy] < $valwrk) $this->Mx[$ix][$iy] = $valwrk;
								}
							}
						}
					}
				}
			}
		}
		$cntx = count($this->Smry);
		for ($ix = 0; $ix < $cntx; $ix++) {
			$this->Cnt[$ix][0]++;
		}
	}

	// Reset level summary
	function ResetLevelSummary($lvl) {

		// Clear summary values
		$cntx = count($this->Smry);
		for ($ix = $lvl; $ix < $cntx; $ix++) {
			$cnty = count($this->Smry[$ix]);
			for ($iy = 1; $iy < $cnty; $iy++) {
				$this->Cnt[$ix][$iy] = 0;
				if ($this->Col[$iy][0]) {
					$this->Smry[$ix][$iy] = 0;
					$this->Mn[$ix][$iy] = NULL;
					$this->Mx[$ix][$iy] = NULL;
				}
			}
		}
		$cntx = count($this->Smry);
		for ($ix = $lvl; $ix < $cntx; $ix++) {
			$this->Cnt[$ix][0] = 0;
		}

		// Reset record count
		$this->RecCount = 0;
	}

	// Accummulate grand summary
	function AccumulateGrandSummary() {
		$this->TotCount++;
		$cntgs = count($this->GrandSmry);
		for ($iy = 1; $iy < $cntgs; $iy++) {
			if ($this->Col[$iy][0]) {
				$valwrk = $this->Val[$iy];
				if (is_null($valwrk) || !is_numeric($valwrk)) {
					if (!$this->Col[$iy][1])
						$this->GrandCnt[$iy]++;
				} else {
					if (!$this->Col[$iy][1] || $valwrk <> 0) {
						$this->GrandCnt[$iy]++;
						$this->GrandSmry[$iy] += $valwrk;
						if (is_null($this->GrandMn[$iy])) {
							$this->GrandMn[$iy] = $valwrk;
							$this->GrandMx[$iy] = $valwrk;
						} else {
							if ($this->GrandMn[$iy] > $valwrk) $this->GrandMn[$iy] = $valwrk;
							if ($this->GrandMx[$iy] < $valwrk) $this->GrandMx[$iy] = $valwrk;
						}
					}
				}
			}
		}
	}

	// Get group count
	function GetGrpCnt($sql) {
		$conn = &$this->Connection();
		$rsgrpcnt = $conn->Execute($sql);
		$grpcnt = ($rsgrpcnt) ? $rsgrpcnt->RecordCount() : 0;
		if ($rsgrpcnt) $rsgrpcnt->Close();
		return $grpcnt;
	}

	// Get group recordset
	function GetGrpRs($wrksql, $start = -1, $grps = -1) {
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EWR_ERROR_FN"];
		$rswrk = $conn->SelectLimit($wrksql, $grps, $start - 1);
		$conn->raiseErrorFn = '';
		return $rswrk;
	}

	// Get group row values
	function GetGrpRow($opt) {
		global $rsgrp;
		if (!$rsgrp)
			return;
		if ($opt == 1) { // Get first group

			//$rsgrp->MoveFirst(); // NOTE: no need to move position
			$this->Sekolah->setDbValue(""); // Init first value
		} else { // Get next group
			$rsgrp->MoveNext();
		}
		if (!$rsgrp->EOF)
			$this->Sekolah->setDbValue($rsgrp->fields[0]);
		if ($rsgrp->EOF) {
			$this->Sekolah->setDbValue("");
		}
	}

	// Get detail recordset
	function GetDetailRs($wrksql) {
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EWR_ERROR_FN"];
		$rswrk = $conn->Execute($wrksql);
		$dbtype = ewr_GetConnectionType($this->DBID);
		if ($dbtype == "MYSQL" || $dbtype == "POSTGRESQL") {
			$this->DetailRows = ($rswrk) ? $rswrk->GetRows() : array();
		} else { // Cannot MoveFirst, use another recordset
			$rstmp = $conn->Execute($wrksql);
			$this->DetailRows = ($rstmp) ? $rstmp->GetRows() : array();
			$rstmp->Close();
		}
		$conn->raiseErrorFn = "";
		return $rswrk;
	}

	// Get row values
	function GetRow($opt) {
		global $rs;
		if (!$rs)
			return;
		if ($opt == 1) { // Get first row
			$rs->MoveFirst(); // Move first
			if ($this->GrpCount == 1) {
				$this->FirstRowData = array();
				$this->FirstRowData['siswarutin_id'] = ewr_Conv($rs->fields('siswarutin_id'), 3);
				$this->FirstRowData['siswa_id'] = ewr_Conv($rs->fields('siswa_id'), 3);
				$this->FirstRowData['rutin_id'] = ewr_Conv($rs->fields('rutin_id'), 3);
				$this->FirstRowData['sekolah_id'] = ewr_Conv($rs->fields('sekolah_id'), 3);
				$this->FirstRowData['kelas_id'] = ewr_Conv($rs->fields('kelas_id'), 3);
				$this->FirstRowData['NIS'] = ewr_Conv($rs->fields('NIS'), 200);
				$this->FirstRowData['Nama'] = ewr_Conv($rs->fields('Nama'), 200);
				$this->FirstRowData['Kelas'] = ewr_Conv($rs->fields('Kelas'), 200);
				$this->FirstRowData['Sekolah'] = ewr_Conv($rs->fields('Sekolah'), 200);
				$this->FirstRowData['Periode_Tahun_Bulan'] = ewr_Conv($rs->fields('Periode_Tahun_Bulan'), 200);
				$this->FirstRowData['Periode_Text'] = ewr_Conv($rs->fields('Periode_Text'), 200);
				$this->FirstRowData['Jenis'] = ewr_Conv($rs->fields('Jenis'), 200);
				$this->FirstRowData['Nilai'] = ewr_Conv($rs->fields('Nilai'), 4);
			}
		} else { // Get next row
			$rs->MoveNext();
		}
		if (!$rs->EOF) {
			$this->siswarutin_id->setDbValue($rs->fields('siswarutin_id'));
			$this->siswa_id->setDbValue($rs->fields('siswa_id'));
			$this->rutin_id->setDbValue($rs->fields('rutin_id'));
			$this->sekolah_id->setDbValue($rs->fields('sekolah_id'));
			$this->kelas_id->setDbValue($rs->fields('kelas_id'));
			$this->NIS->setDbValue($rs->fields('NIS'));
			$this->Nama->setDbValue($rs->fields('Nama'));
			$this->Kelas->setDbValue($rs->fields('Kelas'));
			if ($opt <> 1) {
				if (is_array($this->Sekolah->GroupDbValues))
					$this->Sekolah->setDbValue(@$this->Sekolah->GroupDbValues[$rs->fields('Sekolah')]);
				else
					$this->Sekolah->setDbValue(ewr_GroupValue($this->Sekolah, $rs->fields('Sekolah')));
			}
			$this->Periode_Tahun_Bulan->setDbValue($rs->fields('Periode_Tahun_Bulan'));
			$this->Periode_Text->setDbValue($rs->fields('Periode_Text'));
			$this->Jenis->setDbValue($rs->fields('Jenis'));
			$this->Nilai->setDbValue($rs->fields('Nilai'));
			$this->Val[1] = $this->Periode_Tahun_Bulan->CurrentValue;
			$this->Val[2] = $this->Periode_Text->CurrentValue;
			$this->Val[3] = $this->Nilai->CurrentValue;
		} else {
			$this->siswarutin_id->setDbValue("");
			$this->siswa_id->setDbValue("");
			$this->rutin_id->setDbValue("");
			$this->sekolah_id->setDbValue("");
			$this->kelas_id->setDbValue("");
			$this->NIS->setDbValue("");
			$this->Nama->setDbValue("");
			$this->Kelas->setDbValue("");
			$this->Sekolah->setDbValue("");
			$this->Periode_Tahun_Bulan->setDbValue("");
			$this->Periode_Text->setDbValue("");
			$this->Jenis->setDbValue("");
			$this->Nilai->setDbValue("");
		}
	}

	// Set up starting group
	function SetUpStartGroup($options = array()) {

		// Exit if no groups
		if ($this->DisplayGrps == 0)
			return;
		$startGrp = (@$options["start"] <> "") ? $options["start"] : @$_GET[EWR_TABLE_START_GROUP];
		$pageNo = (@$options["pageno"] <> "") ? $options["pageno"] : @$_GET["pageno"];

		// Check for a 'start' parameter
		if ($startGrp != "") {
			$this->StartGrp = $startGrp;
			$this->setStartGroup($this->StartGrp);
		} elseif ($pageNo != "") {
			$nPageNo = $pageNo;
			if (is_numeric($nPageNo)) {
				$this->StartGrp = ($nPageNo-1)*$this->DisplayGrps+1;
				if ($this->StartGrp <= 0) {
					$this->StartGrp = 1;
				} elseif ($this->StartGrp >= intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1) {
					$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1;
				}
				$this->setStartGroup($this->StartGrp);
			} else {
				$this->StartGrp = $this->getStartGroup();
			}
		} else {
			$this->StartGrp = $this->getStartGroup();
		}

		// Check if correct start group counter
		if (!is_numeric($this->StartGrp) || $this->StartGrp == "") { // Avoid invalid start group counter
			$this->StartGrp = 1; // Reset start group counter
			$this->setStartGroup($this->StartGrp);
		} elseif (intval($this->StartGrp) > intval($this->TotalGrps)) { // Avoid starting group > total groups
			$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to last page first group
			$this->setStartGroup($this->StartGrp);
		} elseif (($this->StartGrp-1) % $this->DisplayGrps <> 0) {
			$this->StartGrp = intval(($this->StartGrp-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to page boundary
			$this->setStartGroup($this->StartGrp);
		}
	}

	// Load group db values if necessary
	function LoadGroupDbValues() {
		$conn = &$this->Connection();
	}

	// Process Ajax popup
	function ProcessAjaxPopup() {
		global $ReportLanguage;
		$conn = &$this->Connection();
		$fld = NULL;
		if (@$_GET["popup"] <> "") {
			$popupname = $_GET["popup"];

			// Check popup name
			// Output data as Json

			if (!is_null($fld)) {
				$jsdb = ewr_GetJsDb($fld, $fld->FldType);
				if (ob_get_length())
					ob_end_clean();
				echo $jsdb;
				exit();
			}
		}
	}

	// Set up popup
	function SetupPopup() {
		global $ReportLanguage;
		$conn = &$this->Connection();
		if ($this->DrillDown)
			return;

		// Process post back form
		if (ewr_IsHttpPost()) {
			$sName = @$_POST["popup"]; // Get popup form name
			if ($sName <> "") {
				$cntValues = (is_array(@$_POST["sel_$sName"])) ? count($_POST["sel_$sName"]) : 0;
				if ($cntValues > 0) {
					$arValues = ewr_StripSlashes($_POST["sel_$sName"]);
					if (trim($arValues[0]) == "") // Select all
						$arValues = EWR_INIT_VALUE;
					$this->PopupName = $sName;
					if (ewr_IsAdvancedFilterValue($arValues) || $arValues == EWR_INIT_VALUE)
						$this->PopupValue = $arValues;
					if (!ewr_MatchedArray($arValues, $_SESSION["sel_$sName"])) {
						if ($this->HasSessionFilterValues($sName))
							$this->ClearExtFilter = $sName; // Clear extended filter for this field
					}
					$_SESSION["sel_$sName"] = $arValues;
					$_SESSION["rf_$sName"] = ewr_StripSlashes(@$_POST["rf_$sName"]);
					$_SESSION["rt_$sName"] = ewr_StripSlashes(@$_POST["rt_$sName"]);
					$this->ResetPager();
				}
			}

		// Get 'reset' command
		} elseif (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];
			if (strtolower($sCmd) == "reset") {
				$this->ResetPager();
			}
		}

		// Load selection criteria to array
	}

	// Reset pager
	function ResetPager() {

		// Reset start position (reset command)
		$this->StartGrp = 1;
		$this->setStartGroup($this->StartGrp);
	}

	// Set up number of groups displayed per page
	function SetUpDisplayGrps() {
		$sWrk = @$_GET[EWR_TABLE_GROUP_PER_PAGE];
		if ($sWrk <> "") {
			if (is_numeric($sWrk)) {
				$this->DisplayGrps = intval($sWrk);
			} else {
				if (strtoupper($sWrk) == "ALL") { // Display all groups
					$this->DisplayGrps = -1;
				} else {
					$this->DisplayGrps = 10; // Non-numeric, load default
				}
			}
			$this->setGroupPerPage($this->DisplayGrps); // Save to session

			// Reset start position (reset command)
			$this->StartGrp = 1;
			$this->setStartGroup($this->StartGrp);
		} else {
			if ($this->getGroupPerPage() <> "") {
				$this->DisplayGrps = $this->getGroupPerPage(); // Restore from session
			} else {
				$this->DisplayGrps = 10; // Load default
			}
		}
	}

	// Render row
	function RenderRow() {
		global $rs, $Security, $ReportLanguage;
		$conn = &$this->Connection();
		if (!$this->GrandSummarySetup) { // Get Grand total
			$bGotCount = FALSE;
			$bGotSummary = FALSE;

			// Get total count from sql directly
			$sSql = ewr_BuildReportSql($this->getSqlSelectCount(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
			$rstot = $conn->Execute($sSql);
			if ($rstot) {
				$this->TotCount = ($rstot->RecordCount()>1) ? $rstot->RecordCount() : $rstot->fields[0];
				$rstot->Close();
				$bGotCount = TRUE;
			} else {
				$this->TotCount = 0;
			}

			// Get total from sql directly
			$sSql = ewr_BuildReportSql($this->getSqlSelectAgg(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
			$sSql = $this->getSqlAggPfx() . $sSql . $this->getSqlAggSfx();
			$rsagg = $conn->Execute($sSql);
			if ($rsagg) {
				$this->GrandCnt[1] = $this->TotCount;
				$this->GrandCnt[2] = $this->TotCount;
				$this->GrandCnt[3] = $this->TotCount;
				$this->GrandSmry[3] = $rsagg->fields("sum_nilai");
				$rsagg->Close();
				$bGotSummary = TRUE;
			}

			// Accumulate grand summary from detail records
			if (!$bGotCount || !$bGotSummary) {
				$sSql = ewr_BuildReportSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
				$rs = $conn->Execute($sSql);
				if ($rs) {
					$this->GetRow(1);
					while (!$rs->EOF) {
						$this->AccumulateGrandSummary();
						$this->GetRow(2);
					}
					$rs->Close();
				}
			}
			$this->GrandSummarySetup = TRUE; // No need to set up again
		}

		// Call Row_Rendering event
		$this->Row_Rendering();

		//
		// Render view codes
		//

		if ($this->RowType == EWR_ROWTYPE_TOTAL && !($this->RowTotalType == EWR_ROWTOTAL_GROUP && $this->RowTotalSubType == EWR_ROWTOTAL_HEADER)) { // Summary row
			ewr_PrependClass($this->RowAttrs["class"], ($this->RowTotalType == EWR_ROWTOTAL_PAGE || $this->RowTotalType == EWR_ROWTOTAL_GRAND) ? "ewRptGrpAggregate" : "ewRptGrpSummary" . $this->RowGroupLevel); // Set up row class
			if ($this->RowTotalType == EWR_ROWTOTAL_GROUP) $this->RowAttrs["data-group"] = $this->Sekolah->GroupOldValue(); // Set up group attribute
			if ($this->RowTotalType == EWR_ROWTOTAL_GROUP && $this->RowGroupLevel >= 2) $this->RowAttrs["data-group-2"] = $this->Kelas->GroupOldValue(); // Set up group attribute 2
			if ($this->RowTotalType == EWR_ROWTOTAL_GROUP && $this->RowGroupLevel >= 3) $this->RowAttrs["data-group-3"] = $this->NIS->GroupOldValue(); // Set up group attribute 3
			if ($this->RowTotalType == EWR_ROWTOTAL_GROUP && $this->RowGroupLevel >= 4) $this->RowAttrs["data-group-4"] = $this->Nama->GroupOldValue(); // Set up group attribute 4
			if ($this->RowTotalType == EWR_ROWTOTAL_GROUP && $this->RowGroupLevel >= 5) $this->RowAttrs["data-group-5"] = $this->Jenis->GroupOldValue(); // Set up group attribute 5

			// Sekolah
			$this->Sekolah->GroupViewValue = $this->Sekolah->GroupOldValue();
			$this->Sekolah->CellAttrs["class"] = ($this->RowGroupLevel == 1) ? "ewRptGrpSummary1" : "ewRptGrpField1";
			$this->Sekolah->GroupViewValue = ewr_DisplayGroupValue($this->Sekolah, $this->Sekolah->GroupViewValue);
			$this->Sekolah->GroupSummaryOldValue = $this->Sekolah->GroupSummaryValue;
			$this->Sekolah->GroupSummaryValue = $this->Sekolah->GroupViewValue;
			$this->Sekolah->GroupSummaryViewValue = ($this->Sekolah->GroupSummaryOldValue <> $this->Sekolah->GroupSummaryValue) ? $this->Sekolah->GroupSummaryValue : "&nbsp;";

			// Kelas
			$this->Kelas->GroupViewValue = $this->Kelas->GroupOldValue();
			$this->Kelas->CellAttrs["class"] = ($this->RowGroupLevel == 2) ? "ewRptGrpSummary2" : "ewRptGrpField2";
			$this->Kelas->GroupViewValue = ewr_DisplayGroupValue($this->Kelas, $this->Kelas->GroupViewValue);
			$this->Kelas->GroupSummaryOldValue = $this->Kelas->GroupSummaryValue;
			$this->Kelas->GroupSummaryValue = $this->Kelas->GroupViewValue;
			$this->Kelas->GroupSummaryViewValue = ($this->Kelas->GroupSummaryOldValue <> $this->Kelas->GroupSummaryValue) ? $this->Kelas->GroupSummaryValue : "&nbsp;";

			// NIS
			$this->NIS->GroupViewValue = $this->NIS->GroupOldValue();
			$this->NIS->CellAttrs["class"] = ($this->RowGroupLevel == 3) ? "ewRptGrpSummary3" : "ewRptGrpField3";
			$this->NIS->GroupViewValue = ewr_DisplayGroupValue($this->NIS, $this->NIS->GroupViewValue);
			$this->NIS->GroupSummaryOldValue = $this->NIS->GroupSummaryValue;
			$this->NIS->GroupSummaryValue = $this->NIS->GroupViewValue;
			$this->NIS->GroupSummaryViewValue = ($this->NIS->GroupSummaryOldValue <> $this->NIS->GroupSummaryValue) ? $this->NIS->GroupSummaryValue : "&nbsp;";

			// Nama
			$this->Nama->GroupViewValue = $this->Nama->GroupOldValue();
			$this->Nama->CellAttrs["class"] = ($this->RowGroupLevel == 4) ? "ewRptGrpSummary4" : "ewRptGrpField4";
			$this->Nama->GroupViewValue = ewr_DisplayGroupValue($this->Nama, $this->Nama->GroupViewValue);
			$this->Nama->GroupSummaryOldValue = $this->Nama->GroupSummaryValue;
			$this->Nama->GroupSummaryValue = $this->Nama->GroupViewValue;
			$this->Nama->GroupSummaryViewValue = ($this->Nama->GroupSummaryOldValue <> $this->Nama->GroupSummaryValue) ? $this->Nama->GroupSummaryValue : "&nbsp;";

			// Jenis
			$this->Jenis->GroupViewValue = $this->Jenis->GroupOldValue();
			$this->Jenis->CellAttrs["class"] = ($this->RowGroupLevel == 5) ? "ewRptGrpSummary5" : "ewRptGrpField5";
			$this->Jenis->GroupViewValue = ewr_DisplayGroupValue($this->Jenis, $this->Jenis->GroupViewValue);
			$this->Jenis->GroupSummaryOldValue = $this->Jenis->GroupSummaryValue;
			$this->Jenis->GroupSummaryValue = $this->Jenis->GroupViewValue;
			$this->Jenis->GroupSummaryViewValue = ($this->Jenis->GroupSummaryOldValue <> $this->Jenis->GroupSummaryValue) ? $this->Jenis->GroupSummaryValue : "&nbsp;";

			// Nilai
			$this->Nilai->SumViewValue = $this->Nilai->SumValue;
			$this->Nilai->SumViewValue = ewr_FormatNumber($this->Nilai->SumViewValue, $this->Nilai->DefaultDecimalPrecision, -1, 0, 0);
			$this->Nilai->CellAttrs["class"] = ($this->RowTotalType == EWR_ROWTOTAL_PAGE || $this->RowTotalType == EWR_ROWTOTAL_GRAND) ? "ewRptGrpAggregate" : "ewRptGrpSummary" . $this->RowGroupLevel;

			// Sekolah
			$this->Sekolah->HrefValue = "";

			// Kelas
			$this->Kelas->HrefValue = "";

			// NIS
			$this->NIS->HrefValue = "";

			// Nama
			$this->Nama->HrefValue = "";

			// Jenis
			$this->Jenis->HrefValue = "";

			// Periode_Tahun_Bulan
			$this->Periode_Tahun_Bulan->HrefValue = "";

			// Periode_Text
			$this->Periode_Text->HrefValue = "";

			// Nilai
			$this->Nilai->HrefValue = "";
		} else {
			if ($this->RowTotalType == EWR_ROWTOTAL_GROUP && $this->RowTotalSubType == EWR_ROWTOTAL_HEADER) {
			$this->RowAttrs["data-group"] = $this->Sekolah->GroupValue(); // Set up group attribute
			if ($this->RowGroupLevel >= 2) $this->RowAttrs["data-group-2"] = $this->Kelas->GroupValue(); // Set up group attribute 2
			if ($this->RowGroupLevel >= 3) $this->RowAttrs["data-group-3"] = $this->NIS->GroupValue(); // Set up group attribute 3
			if ($this->RowGroupLevel >= 4) $this->RowAttrs["data-group-4"] = $this->Nama->GroupValue(); // Set up group attribute 4
			if ($this->RowGroupLevel >= 5) $this->RowAttrs["data-group-5"] = $this->Jenis->GroupValue(); // Set up group attribute 5
			} else {
			$this->RowAttrs["data-group"] = $this->Sekolah->GroupValue(); // Set up group attribute
			$this->RowAttrs["data-group-2"] = $this->Kelas->GroupValue(); // Set up group attribute 2
			$this->RowAttrs["data-group-3"] = $this->NIS->GroupValue(); // Set up group attribute 3
			$this->RowAttrs["data-group-4"] = $this->Nama->GroupValue(); // Set up group attribute 4
			$this->RowAttrs["data-group-5"] = $this->Jenis->GroupValue(); // Set up group attribute 5
			}

			// Sekolah
			$this->Sekolah->GroupViewValue = $this->Sekolah->GroupValue();
			$this->Sekolah->CellAttrs["class"] = "ewRptGrpField1";
			$this->Sekolah->GroupViewValue = ewr_DisplayGroupValue($this->Sekolah, $this->Sekolah->GroupViewValue);
			if ($this->Sekolah->GroupValue() == $this->Sekolah->GroupOldValue() && !$this->ChkLvlBreak(1))
				$this->Sekolah->GroupViewValue = "&nbsp;";

			// Kelas
			$this->Kelas->GroupViewValue = $this->Kelas->GroupValue();
			$this->Kelas->CellAttrs["class"] = "ewRptGrpField2";
			$this->Kelas->GroupViewValue = ewr_DisplayGroupValue($this->Kelas, $this->Kelas->GroupViewValue);
			if ($this->Kelas->GroupValue() == $this->Kelas->GroupOldValue() && !$this->ChkLvlBreak(2))
				$this->Kelas->GroupViewValue = "&nbsp;";

			// NIS
			$this->NIS->GroupViewValue = $this->NIS->GroupValue();
			$this->NIS->CellAttrs["class"] = "ewRptGrpField3";
			$this->NIS->GroupViewValue = ewr_DisplayGroupValue($this->NIS, $this->NIS->GroupViewValue);
			if ($this->NIS->GroupValue() == $this->NIS->GroupOldValue() && !$this->ChkLvlBreak(3))
				$this->NIS->GroupViewValue = "&nbsp;";

			// Nama
			$this->Nama->GroupViewValue = $this->Nama->GroupValue();
			$this->Nama->CellAttrs["class"] = "ewRptGrpField4";
			$this->Nama->GroupViewValue = ewr_DisplayGroupValue($this->Nama, $this->Nama->GroupViewValue);
			if ($this->Nama->GroupValue() == $this->Nama->GroupOldValue() && !$this->ChkLvlBreak(4))
				$this->Nama->GroupViewValue = "&nbsp;";

			// Jenis
			$this->Jenis->GroupViewValue = $this->Jenis->GroupValue();
			$this->Jenis->CellAttrs["class"] = "ewRptGrpField5";
			$this->Jenis->GroupViewValue = ewr_DisplayGroupValue($this->Jenis, $this->Jenis->GroupViewValue);
			if ($this->Jenis->GroupValue() == $this->Jenis->GroupOldValue() && !$this->ChkLvlBreak(5))
				$this->Jenis->GroupViewValue = "&nbsp;";

			// Periode_Tahun_Bulan
			$this->Periode_Tahun_Bulan->ViewValue = $this->Periode_Tahun_Bulan->CurrentValue;
			$this->Periode_Tahun_Bulan->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Periode_Text
			$this->Periode_Text->ViewValue = $this->Periode_Text->CurrentValue;
			$this->Periode_Text->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Nilai
			$this->Nilai->ViewValue = $this->Nilai->CurrentValue;
			$this->Nilai->ViewValue = ewr_FormatNumber($this->Nilai->ViewValue, $this->Nilai->DefaultDecimalPrecision, -1, 0, 0);
			$this->Nilai->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Sekolah
			$this->Sekolah->HrefValue = "";

			// Kelas
			$this->Kelas->HrefValue = "";

			// NIS
			$this->NIS->HrefValue = "";

			// Nama
			$this->Nama->HrefValue = "";

			// Jenis
			$this->Jenis->HrefValue = "";

			// Periode_Tahun_Bulan
			$this->Periode_Tahun_Bulan->HrefValue = "";

			// Periode_Text
			$this->Periode_Text->HrefValue = "";

			// Nilai
			$this->Nilai->HrefValue = "";
		}

		// Call Cell_Rendered event
		if ($this->RowType == EWR_ROWTYPE_TOTAL) { // Summary row

			// Sekolah
			$CurrentValue = $this->Sekolah->GroupViewValue;
			$ViewValue = &$this->Sekolah->GroupViewValue;
			$ViewAttrs = &$this->Sekolah->ViewAttrs;
			$CellAttrs = &$this->Sekolah->CellAttrs;
			$HrefValue = &$this->Sekolah->HrefValue;
			$LinkAttrs = &$this->Sekolah->LinkAttrs;
			$this->Cell_Rendered($this->Sekolah, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// Kelas
			$CurrentValue = $this->Kelas->GroupViewValue;
			$ViewValue = &$this->Kelas->GroupViewValue;
			$ViewAttrs = &$this->Kelas->ViewAttrs;
			$CellAttrs = &$this->Kelas->CellAttrs;
			$HrefValue = &$this->Kelas->HrefValue;
			$LinkAttrs = &$this->Kelas->LinkAttrs;
			$this->Cell_Rendered($this->Kelas, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// NIS
			$CurrentValue = $this->NIS->GroupViewValue;
			$ViewValue = &$this->NIS->GroupViewValue;
			$ViewAttrs = &$this->NIS->ViewAttrs;
			$CellAttrs = &$this->NIS->CellAttrs;
			$HrefValue = &$this->NIS->HrefValue;
			$LinkAttrs = &$this->NIS->LinkAttrs;
			$this->Cell_Rendered($this->NIS, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// Nama
			$CurrentValue = $this->Nama->GroupViewValue;
			$ViewValue = &$this->Nama->GroupViewValue;
			$ViewAttrs = &$this->Nama->ViewAttrs;
			$CellAttrs = &$this->Nama->CellAttrs;
			$HrefValue = &$this->Nama->HrefValue;
			$LinkAttrs = &$this->Nama->LinkAttrs;
			$this->Cell_Rendered($this->Nama, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// Jenis
			$CurrentValue = $this->Jenis->GroupViewValue;
			$ViewValue = &$this->Jenis->GroupViewValue;
			$ViewAttrs = &$this->Jenis->ViewAttrs;
			$CellAttrs = &$this->Jenis->CellAttrs;
			$HrefValue = &$this->Jenis->HrefValue;
			$LinkAttrs = &$this->Jenis->LinkAttrs;
			$this->Cell_Rendered($this->Jenis, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// Nilai
			$CurrentValue = $this->Nilai->SumValue;
			$ViewValue = &$this->Nilai->SumViewValue;
			$ViewAttrs = &$this->Nilai->ViewAttrs;
			$CellAttrs = &$this->Nilai->CellAttrs;
			$HrefValue = &$this->Nilai->HrefValue;
			$LinkAttrs = &$this->Nilai->LinkAttrs;
			$this->Cell_Rendered($this->Nilai, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);
		} else {

			// Sekolah
			$CurrentValue = $this->Sekolah->GroupValue();
			$ViewValue = &$this->Sekolah->GroupViewValue;
			$ViewAttrs = &$this->Sekolah->ViewAttrs;
			$CellAttrs = &$this->Sekolah->CellAttrs;
			$HrefValue = &$this->Sekolah->HrefValue;
			$LinkAttrs = &$this->Sekolah->LinkAttrs;
			$this->Cell_Rendered($this->Sekolah, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// Kelas
			$CurrentValue = $this->Kelas->GroupValue();
			$ViewValue = &$this->Kelas->GroupViewValue;
			$ViewAttrs = &$this->Kelas->ViewAttrs;
			$CellAttrs = &$this->Kelas->CellAttrs;
			$HrefValue = &$this->Kelas->HrefValue;
			$LinkAttrs = &$this->Kelas->LinkAttrs;
			$this->Cell_Rendered($this->Kelas, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// NIS
			$CurrentValue = $this->NIS->GroupValue();
			$ViewValue = &$this->NIS->GroupViewValue;
			$ViewAttrs = &$this->NIS->ViewAttrs;
			$CellAttrs = &$this->NIS->CellAttrs;
			$HrefValue = &$this->NIS->HrefValue;
			$LinkAttrs = &$this->NIS->LinkAttrs;
			$this->Cell_Rendered($this->NIS, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// Nama
			$CurrentValue = $this->Nama->GroupValue();
			$ViewValue = &$this->Nama->GroupViewValue;
			$ViewAttrs = &$this->Nama->ViewAttrs;
			$CellAttrs = &$this->Nama->CellAttrs;
			$HrefValue = &$this->Nama->HrefValue;
			$LinkAttrs = &$this->Nama->LinkAttrs;
			$this->Cell_Rendered($this->Nama, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// Jenis
			$CurrentValue = $this->Jenis->GroupValue();
			$ViewValue = &$this->Jenis->GroupViewValue;
			$ViewAttrs = &$this->Jenis->ViewAttrs;
			$CellAttrs = &$this->Jenis->CellAttrs;
			$HrefValue = &$this->Jenis->HrefValue;
			$LinkAttrs = &$this->Jenis->LinkAttrs;
			$this->Cell_Rendered($this->Jenis, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// Periode_Tahun_Bulan
			$CurrentValue = $this->Periode_Tahun_Bulan->CurrentValue;
			$ViewValue = &$this->Periode_Tahun_Bulan->ViewValue;
			$ViewAttrs = &$this->Periode_Tahun_Bulan->ViewAttrs;
			$CellAttrs = &$this->Periode_Tahun_Bulan->CellAttrs;
			$HrefValue = &$this->Periode_Tahun_Bulan->HrefValue;
			$LinkAttrs = &$this->Periode_Tahun_Bulan->LinkAttrs;
			$this->Cell_Rendered($this->Periode_Tahun_Bulan, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// Periode_Text
			$CurrentValue = $this->Periode_Text->CurrentValue;
			$ViewValue = &$this->Periode_Text->ViewValue;
			$ViewAttrs = &$this->Periode_Text->ViewAttrs;
			$CellAttrs = &$this->Periode_Text->CellAttrs;
			$HrefValue = &$this->Periode_Text->HrefValue;
			$LinkAttrs = &$this->Periode_Text->LinkAttrs;
			$this->Cell_Rendered($this->Periode_Text, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// Nilai
			$CurrentValue = $this->Nilai->CurrentValue;
			$ViewValue = &$this->Nilai->ViewValue;
			$ViewAttrs = &$this->Nilai->ViewAttrs;
			$CellAttrs = &$this->Nilai->CellAttrs;
			$HrefValue = &$this->Nilai->HrefValue;
			$LinkAttrs = &$this->Nilai->LinkAttrs;
			$this->Cell_Rendered($this->Nilai, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);
		}

		// Call Row_Rendered event
		$this->Row_Rendered();
		$this->SetupFieldCount();
	}

	// Setup field count
	function SetupFieldCount() {
		$this->GrpColumnCount = 0;
		$this->SubGrpColumnCount = 0;
		$this->DtlColumnCount = 0;
		if ($this->Sekolah->Visible) $this->GrpColumnCount += 1;
		if ($this->Kelas->Visible) { $this->GrpColumnCount += 1; $this->SubGrpColumnCount += 1; }
		if ($this->NIS->Visible) { $this->GrpColumnCount += 1; $this->SubGrpColumnCount += 1; }
		if ($this->Nama->Visible) { $this->GrpColumnCount += 1; $this->SubGrpColumnCount += 1; }
		if ($this->Jenis->Visible) { $this->GrpColumnCount += 1; $this->SubGrpColumnCount += 1; }
		if ($this->Periode_Tahun_Bulan->Visible) $this->DtlColumnCount += 1;
		if ($this->Periode_Text->Visible) $this->DtlColumnCount += 1;
		if ($this->Nilai->Visible) $this->DtlColumnCount += 1;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $ReportBreadcrumb;
		$ReportBreadcrumb = new crBreadcrumb();
		$url = substr(ewr_CurrentUrl(), strrpos(ewr_CurrentUrl(), "/")+1);
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$ReportBreadcrumb->Add("summary", $this->TableVar, $url, "", $this->TableVar, TRUE);
	}

	function SetupExportOptionsExt() {
		global $ReportLanguage, $ReportOptions;
		$ReportTypes = $ReportOptions["ReportTypes"];
		$item =& $this->ExportOptions->GetItem("pdf");
		$item->Visible = TRUE;
		if ($item->Visible)
			$ReportTypes["pdf"] = $ReportLanguage->Phrase("ReportFormPdf");
		$exportid = session_id();
		$url = $this->ExportPdfUrl;
		$item->Body = "<a title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToPDF", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToPDF", TRUE)) . "\" href=\"javascript:void(0);\" onclick=\"ewr_ExportCharts(this, '" . $url . "', '" . $exportid . "');\">" . $ReportLanguage->Phrase("ExportToPDF") . "</a>";
		$ReportOptions["ReportTypes"] = $ReportTypes;
	}

	// Return extended filter
	function GetExtendedFilter() {
		global $gsFormError;
		$sFilter = "";
		if ($this->DrillDown)
			return "";
		$bPostBack = ewr_IsHttpPost();
		$bRestoreSession = TRUE;
		$bSetupFilter = FALSE;

		// Reset extended filter if filter changed
		if ($bPostBack) {

		// Reset search command
		} elseif (@$_GET["cmd"] == "reset") {

			// Load default values
			$this->SetSessionDropDownValue($this->NIS->DropDownValue, $this->NIS->SearchOperator, 'NIS'); // Field NIS
			$this->SetSessionDropDownValue($this->Nama->DropDownValue, $this->Nama->SearchOperator, 'Nama'); // Field Nama
			$this->SetSessionDropDownValue($this->Kelas->DropDownValue, $this->Kelas->SearchOperator, 'Kelas'); // Field Kelas
			$this->SetSessionDropDownValue($this->Sekolah->DropDownValue, $this->Sekolah->SearchOperator, 'Sekolah'); // Field Sekolah
			$this->SetSessionDropDownValue($this->Periode_Text->DropDownValue, $this->Periode_Text->SearchOperator, 'Periode_Text'); // Field Periode_Text

			//$bSetupFilter = TRUE; // No need to set up, just use default
		} else {
			$bRestoreSession = !$this->SearchCommand;

			// Field NIS
			if ($this->GetDropDownValue($this->NIS)) {
				$bSetupFilter = TRUE;
			} elseif ($this->NIS->DropDownValue <> EWR_INIT_VALUE && !isset($_SESSION['sv_r01_sudahbayar_NIS'])) {
				$bSetupFilter = TRUE;
			}

			// Field Nama
			if ($this->GetDropDownValue($this->Nama)) {
				$bSetupFilter = TRUE;
			} elseif ($this->Nama->DropDownValue <> EWR_INIT_VALUE && !isset($_SESSION['sv_r01_sudahbayar_Nama'])) {
				$bSetupFilter = TRUE;
			}

			// Field Kelas
			if ($this->GetDropDownValue($this->Kelas)) {
				$bSetupFilter = TRUE;
			} elseif ($this->Kelas->DropDownValue <> EWR_INIT_VALUE && !isset($_SESSION['sv_r01_sudahbayar_Kelas'])) {
				$bSetupFilter = TRUE;
			}

			// Field Sekolah
			if ($this->GetDropDownValue($this->Sekolah)) {
				$bSetupFilter = TRUE;
			} elseif ($this->Sekolah->DropDownValue <> EWR_INIT_VALUE && !isset($_SESSION['sv_r01_sudahbayar_Sekolah'])) {
				$bSetupFilter = TRUE;
			}

			// Field Periode_Text
			if ($this->GetDropDownValue($this->Periode_Text)) {
				$bSetupFilter = TRUE;
			} elseif ($this->Periode_Text->DropDownValue <> EWR_INIT_VALUE && !isset($_SESSION['sv_r01_sudahbayar_Periode_Text'])) {
				$bSetupFilter = TRUE;
			}
			if (!$this->ValidateForm()) {
				$this->setFailureMessage($gsFormError);
				return $sFilter;
			}
		}

		// Restore session
		if ($bRestoreSession) {
			$this->GetSessionDropDownValue($this->NIS); // Field NIS
			$this->GetSessionDropDownValue($this->Nama); // Field Nama
			$this->GetSessionDropDownValue($this->Kelas); // Field Kelas
			$this->GetSessionDropDownValue($this->Sekolah); // Field Sekolah
			$this->GetSessionDropDownValue($this->Periode_Text); // Field Periode_Text
		}

		// Call page filter validated event
		$this->Page_FilterValidated();

		// Build SQL
		$this->BuildDropDownFilter($this->NIS, $sFilter, $this->NIS->SearchOperator, FALSE, TRUE); // Field NIS
		$this->BuildDropDownFilter($this->Nama, $sFilter, $this->Nama->SearchOperator, FALSE, TRUE); // Field Nama
		$this->BuildDropDownFilter($this->Kelas, $sFilter, $this->Kelas->SearchOperator, FALSE, TRUE); // Field Kelas
		$this->BuildDropDownFilter($this->Sekolah, $sFilter, $this->Sekolah->SearchOperator, FALSE, TRUE); // Field Sekolah
		$this->BuildDropDownFilter($this->Periode_Text, $sFilter, $this->Periode_Text->SearchOperator, FALSE, TRUE); // Field Periode_Text

		// Save parms to session
		$this->SetSessionDropDownValue($this->NIS->DropDownValue, $this->NIS->SearchOperator, 'NIS'); // Field NIS
		$this->SetSessionDropDownValue($this->Nama->DropDownValue, $this->Nama->SearchOperator, 'Nama'); // Field Nama
		$this->SetSessionDropDownValue($this->Kelas->DropDownValue, $this->Kelas->SearchOperator, 'Kelas'); // Field Kelas
		$this->SetSessionDropDownValue($this->Sekolah->DropDownValue, $this->Sekolah->SearchOperator, 'Sekolah'); // Field Sekolah
		$this->SetSessionDropDownValue($this->Periode_Text->DropDownValue, $this->Periode_Text->SearchOperator, 'Periode_Text'); // Field Periode_Text

		// Setup filter
		if ($bSetupFilter) {
		}

		// Field NIS
		ewr_LoadDropDownList($this->NIS->DropDownList, $this->NIS->DropDownValue);

		// Field Nama
		ewr_LoadDropDownList($this->Nama->DropDownList, $this->Nama->DropDownValue);

		// Field Kelas
		ewr_LoadDropDownList($this->Kelas->DropDownList, $this->Kelas->DropDownValue);

		// Field Sekolah
		ewr_LoadDropDownList($this->Sekolah->DropDownList, $this->Sekolah->DropDownValue);

		// Field Periode_Text
		ewr_LoadDropDownList($this->Periode_Text->DropDownList, $this->Periode_Text->DropDownValue);
		return $sFilter;
	}

	// Build dropdown filter
	function BuildDropDownFilter(&$fld, &$FilterClause, $FldOpr, $Default = FALSE, $SaveFilter = FALSE) {
		$FldVal = ($Default) ? $fld->DefaultDropDownValue : $fld->DropDownValue;
		$sSql = "";
		if (is_array($FldVal)) {
			foreach ($FldVal as $val) {
				$sWrk = $this->GetDropDownFilter($fld, $val, $FldOpr);

				// Call Page Filtering event
				if (substr($val, 0, 2) <> "@@") $this->Page_Filtering($fld, $sWrk, "dropdown", $FldOpr, $val);
				if ($sWrk <> "") {
					if ($sSql <> "")
						$sSql .= " OR " . $sWrk;
					else
						$sSql = $sWrk;
				}
			}
		} else {
			$sSql = $this->GetDropDownFilter($fld, $FldVal, $FldOpr);

			// Call Page Filtering event
			if (substr($FldVal, 0, 2) <> "@@") $this->Page_Filtering($fld, $sSql, "dropdown", $FldOpr, $FldVal);
		}
		if ($sSql <> "") {
			ewr_AddFilter($FilterClause, $sSql);
			if ($SaveFilter) $fld->CurrentFilter = $sSql;
		}
	}

	function GetDropDownFilter(&$fld, $FldVal, $FldOpr) {
		$FldName = $fld->FldName;
		$FldExpression = $fld->FldExpression;
		$FldDataType = $fld->FldDataType;
		$FldDelimiter = $fld->FldDelimiter;
		$FldVal = strval($FldVal);
		if ($FldOpr == "") $FldOpr = "=";
		$sWrk = "";
		if (ewr_SameStr($FldVal, EWR_NULL_VALUE)) {
			$sWrk = $FldExpression . " IS NULL";
		} elseif (ewr_SameStr($FldVal, EWR_NOT_NULL_VALUE)) {
			$sWrk = $FldExpression . " IS NOT NULL";
		} elseif (ewr_SameStr($FldVal, EWR_EMPTY_VALUE)) {
			$sWrk = $FldExpression . " = ''";
		} elseif (ewr_SameStr($FldVal, EWR_ALL_VALUE)) {
			$sWrk = "1 = 1";
		} else {
			if (substr($FldVal, 0, 2) == "@@") {
				$sWrk = $this->GetCustomFilter($fld, $FldVal, $this->DBID);
			} elseif ($FldDelimiter <> "" && trim($FldVal) <> "" && ($FldDataType == EWR_DATATYPE_STRING || $FldDataType == EWR_DATATYPE_MEMO)) {
				$sWrk = ewr_GetMultiSearchSql($FldExpression, trim($FldVal), $this->DBID);
			} else {
				if ($FldVal <> "" && $FldVal <> EWR_INIT_VALUE) {
					if ($FldDataType == EWR_DATATYPE_DATE && $FldOpr <> "") {
						$sWrk = ewr_DateFilterString($FldExpression, $FldOpr, $FldVal, $FldDataType, $this->DBID);
					} else {
						$sWrk = ewr_FilterString($FldOpr, $FldVal, $FldDataType, $this->DBID);
						if ($sWrk <> "") $sWrk = $FldExpression . $sWrk;
					}
				}
			}
		}
		return $sWrk;
	}

	// Get custom filter
	function GetCustomFilter(&$fld, $FldVal, $dbid = 0) {
		$sWrk = "";
		if (is_array($fld->AdvancedFilters)) {
			foreach ($fld->AdvancedFilters as $filter) {
				if ($filter->ID == $FldVal && $filter->Enabled) {
					$sFld = $fld->FldExpression;
					$sFn = $filter->FunctionName;
					$wrkid = (substr($filter->ID,0,2) == "@@") ? substr($filter->ID,2) : $filter->ID;
					if ($sFn <> "")
						$sWrk = $sFn($sFld, $dbid);
					else
						$sWrk = "";
					$this->Page_Filtering($fld, $sWrk, "custom", $wrkid);
					break;
				}
			}
		}
		return $sWrk;
	}

	// Build extended filter
	function BuildExtendedFilter(&$fld, &$FilterClause, $Default = FALSE, $SaveFilter = FALSE) {
		$sWrk = ewr_GetExtendedFilter($fld, $Default, $this->DBID);
		if (!$Default)
			$this->Page_Filtering($fld, $sWrk, "extended", $fld->SearchOperator, $fld->SearchValue, $fld->SearchCondition, $fld->SearchOperator2, $fld->SearchValue2);
		if ($sWrk <> "") {
			ewr_AddFilter($FilterClause, $sWrk);
			if ($SaveFilter) $fld->CurrentFilter = $sWrk;
		}
	}

	// Get drop down value from querystring
	function GetDropDownValue(&$fld) {
		$parm = substr($fld->FldVar, 2);
		if (ewr_IsHttpPost())
			return FALSE; // Skip post back
		if (isset($_GET["so_$parm"]))
			$fld->SearchOperator = ewr_StripSlashes(@$_GET["so_$parm"]);
		if (isset($_GET["sv_$parm"])) {
			$fld->DropDownValue = ewr_StripSlashes(@$_GET["sv_$parm"]);
			return TRUE;
		}
		return FALSE;
	}

	// Get filter values from querystring
	function GetFilterValues(&$fld) {
		$parm = substr($fld->FldVar, 2);
		if (ewr_IsHttpPost())
			return; // Skip post back
		$got = FALSE;
		if (isset($_GET["sv_$parm"])) {
			$fld->SearchValue = ewr_StripSlashes(@$_GET["sv_$parm"]);
			$got = TRUE;
		}
		if (isset($_GET["so_$parm"])) {
			$fld->SearchOperator = ewr_StripSlashes(@$_GET["so_$parm"]);
			$got = TRUE;
		}
		if (isset($_GET["sc_$parm"])) {
			$fld->SearchCondition = ewr_StripSlashes(@$_GET["sc_$parm"]);
			$got = TRUE;
		}
		if (isset($_GET["sv2_$parm"])) {
			$fld->SearchValue2 = ewr_StripSlashes(@$_GET["sv2_$parm"]);
			$got = TRUE;
		}
		if (isset($_GET["so2_$parm"])) {
			$fld->SearchOperator2 = ewr_StripSlashes($_GET["so2_$parm"]);
			$got = TRUE;
		}
		return $got;
	}

	// Set default ext filter
	function SetDefaultExtFilter(&$fld, $so1, $sv1, $sc, $so2, $sv2) {
		$fld->DefaultSearchValue = $sv1; // Default ext filter value 1
		$fld->DefaultSearchValue2 = $sv2; // Default ext filter value 2 (if operator 2 is enabled)
		$fld->DefaultSearchOperator = $so1; // Default search operator 1
		$fld->DefaultSearchOperator2 = $so2; // Default search operator 2 (if operator 2 is enabled)
		$fld->DefaultSearchCondition = $sc; // Default search condition (if operator 2 is enabled)
	}

	// Apply default ext filter
	function ApplyDefaultExtFilter(&$fld) {
		$fld->SearchValue = $fld->DefaultSearchValue;
		$fld->SearchValue2 = $fld->DefaultSearchValue2;
		$fld->SearchOperator = $fld->DefaultSearchOperator;
		$fld->SearchOperator2 = $fld->DefaultSearchOperator2;
		$fld->SearchCondition = $fld->DefaultSearchCondition;
	}

	// Check if Text Filter applied
	function TextFilterApplied(&$fld) {
		return (strval($fld->SearchValue) <> strval($fld->DefaultSearchValue) ||
			strval($fld->SearchValue2) <> strval($fld->DefaultSearchValue2) ||
			(strval($fld->SearchValue) <> "" &&
				strval($fld->SearchOperator) <> strval($fld->DefaultSearchOperator)) ||
			(strval($fld->SearchValue2) <> "" &&
				strval($fld->SearchOperator2) <> strval($fld->DefaultSearchOperator2)) ||
			strval($fld->SearchCondition) <> strval($fld->DefaultSearchCondition));
	}

	// Check if Non-Text Filter applied
	function NonTextFilterApplied(&$fld) {
		if (is_array($fld->DropDownValue)) {
			if (is_array($fld->DefaultDropDownValue)) {
				if (count($fld->DefaultDropDownValue) <> count($fld->DropDownValue))
					return TRUE;
				else
					return (count(array_diff($fld->DefaultDropDownValue, $fld->DropDownValue)) <> 0);
			} else {
				return TRUE;
			}
		} else {
			if (is_array($fld->DefaultDropDownValue))
				return TRUE;
			else
				$v1 = strval($fld->DefaultDropDownValue);
			if ($v1 == EWR_INIT_VALUE)
				$v1 = "";
			$v2 = strval($fld->DropDownValue);
			if ($v2 == EWR_INIT_VALUE || $v2 == EWR_ALL_VALUE)
				$v2 = "";
			return ($v1 <> $v2);
		}
	}

	// Get dropdown value from session
	function GetSessionDropDownValue(&$fld) {
		$parm = substr($fld->FldVar, 2);
		$this->GetSessionValue($fld->DropDownValue, 'sv_r01_sudahbayar_' . $parm);
		$this->GetSessionValue($fld->SearchOperator, 'so_r01_sudahbayar_' . $parm);
	}

	// Get filter values from session
	function GetSessionFilterValues(&$fld) {
		$parm = substr($fld->FldVar, 2);
		$this->GetSessionValue($fld->SearchValue, 'sv_r01_sudahbayar_' . $parm);
		$this->GetSessionValue($fld->SearchOperator, 'so_r01_sudahbayar_' . $parm);
		$this->GetSessionValue($fld->SearchCondition, 'sc_r01_sudahbayar_' . $parm);
		$this->GetSessionValue($fld->SearchValue2, 'sv2_r01_sudahbayar_' . $parm);
		$this->GetSessionValue($fld->SearchOperator2, 'so2_r01_sudahbayar_' . $parm);
	}

	// Get value from session
	function GetSessionValue(&$sv, $sn) {
		if (array_key_exists($sn, $_SESSION))
			$sv = $_SESSION[$sn];
	}

	// Set dropdown value to session
	function SetSessionDropDownValue($sv, $so, $parm) {
		$_SESSION['sv_r01_sudahbayar_' . $parm] = $sv;
		$_SESSION['so_r01_sudahbayar_' . $parm] = $so;
	}

	// Set filter values to session
	function SetSessionFilterValues($sv1, $so1, $sc, $sv2, $so2, $parm) {
		$_SESSION['sv_r01_sudahbayar_' . $parm] = $sv1;
		$_SESSION['so_r01_sudahbayar_' . $parm] = $so1;
		$_SESSION['sc_r01_sudahbayar_' . $parm] = $sc;
		$_SESSION['sv2_r01_sudahbayar_' . $parm] = $sv2;
		$_SESSION['so2_r01_sudahbayar_' . $parm] = $so2;
	}

	// Check if has Session filter values
	function HasSessionFilterValues($parm) {
		return ((@$_SESSION['sv_' . $parm] <> "" && @$_SESSION['sv_' . $parm] <> EWR_INIT_VALUE) ||
			(@$_SESSION['sv_' . $parm] <> "" && @$_SESSION['sv_' . $parm] <> EWR_INIT_VALUE) ||
			(@$_SESSION['sv2_' . $parm] <> "" && @$_SESSION['sv2_' . $parm] <> EWR_INIT_VALUE));
	}

	// Dropdown filter exist
	function DropDownFilterExist(&$fld, $FldOpr) {
		$sWrk = "";
		$this->BuildDropDownFilter($fld, $sWrk, $FldOpr);
		return ($sWrk <> "");
	}

	// Extended filter exist
	function ExtendedFilterExist(&$fld) {
		$sExtWrk = "";
		$this->BuildExtendedFilter($fld, $sExtWrk);
		return ($sExtWrk <> "");
	}

	// Validate form
	function ValidateForm() {
		global $ReportLanguage, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EWR_SERVER_VALIDATE)
			return ($gsFormError == "");

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			$gsFormError .= ($gsFormError <> "") ? "<p>&nbsp;</p>" : "";
			$gsFormError .= $sFormCustomError;
		}
		return $ValidateForm;
	}

	// Clear selection stored in session
	function ClearSessionSelection($parm) {
		$_SESSION["sel_r01_sudahbayar_$parm"] = "";
		$_SESSION["rf_r01_sudahbayar_$parm"] = "";
		$_SESSION["rt_r01_sudahbayar_$parm"] = "";
	}

	// Load selection from session
	function LoadSelectionFromSession($parm) {
		$fld = &$this->FieldByParm($parm);
		$fld->SelectionList = @$_SESSION["sel_r01_sudahbayar_$parm"];
		$fld->RangeFrom = @$_SESSION["rf_r01_sudahbayar_$parm"];
		$fld->RangeTo = @$_SESSION["rt_r01_sudahbayar_$parm"];
	}

	// Load default value for filters
	function LoadDefaultFilters() {
		/**
		* Set up default values for non Text filters
		*/

		// Field NIS
		$this->NIS->DefaultDropDownValue = EWR_INIT_VALUE;
		if (!$this->SearchCommand) $this->NIS->DropDownValue = $this->NIS->DefaultDropDownValue;

		// Field Nama
		$this->Nama->DefaultDropDownValue = EWR_INIT_VALUE;
		if (!$this->SearchCommand) $this->Nama->DropDownValue = $this->Nama->DefaultDropDownValue;

		// Field Kelas
		$this->Kelas->DefaultDropDownValue = EWR_INIT_VALUE;
		if (!$this->SearchCommand) $this->Kelas->DropDownValue = $this->Kelas->DefaultDropDownValue;

		// Field Sekolah
		$this->Sekolah->DefaultDropDownValue = EWR_INIT_VALUE;
		if (!$this->SearchCommand) $this->Sekolah->DropDownValue = $this->Sekolah->DefaultDropDownValue;

		// Field Periode_Text
		$this->Periode_Text->DefaultDropDownValue = EWR_INIT_VALUE;
		if (!$this->SearchCommand) $this->Periode_Text->DropDownValue = $this->Periode_Text->DefaultDropDownValue;
		/**
		* Set up default values for extended filters
		* function SetDefaultExtFilter(&$fld, $so1, $sv1, $sc, $so2, $sv2)
		* Parameters:
		* $fld - Field object
		* $so1 - Default search operator 1
		* $sv1 - Default ext filter value 1
		* $sc - Default search condition (if operator 2 is enabled)
		* $so2 - Default search operator 2 (if operator 2 is enabled)
		* $sv2 - Default ext filter value 2 (if operator 2 is enabled)
		*/
		/**
		* Set up default values for popup filters
		*/
	}

	// Check if filter applied
	function CheckFilter() {

		// Check NIS extended filter
		if ($this->NonTextFilterApplied($this->NIS))
			return TRUE;

		// Check Nama extended filter
		if ($this->NonTextFilterApplied($this->Nama))
			return TRUE;

		// Check Kelas extended filter
		if ($this->NonTextFilterApplied($this->Kelas))
			return TRUE;

		// Check Sekolah extended filter
		if ($this->NonTextFilterApplied($this->Sekolah))
			return TRUE;

		// Check Periode_Text extended filter
		if ($this->NonTextFilterApplied($this->Periode_Text))
			return TRUE;
		return FALSE;
	}

	// Show list of filters
	function ShowFilterList($showDate = FALSE) {
		global $ReportLanguage;

		// Initialize
		$sFilterList = "";

		// Field NIS
		$sExtWrk = "";
		$sWrk = "";
		$this->BuildDropDownFilter($this->NIS, $sExtWrk, $this->NIS->SearchOperator);
		$sFilter = "";
		if ($sExtWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sExtWrk</span>";
		elseif ($sWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sWrk</span>";
		if ($sFilter <> "")
			$sFilterList .= "<div><span class=\"ewFilterCaption\">" . $this->NIS->FldCaption() . "</span>" . $sFilter . "</div>";

		// Field Nama
		$sExtWrk = "";
		$sWrk = "";
		$this->BuildDropDownFilter($this->Nama, $sExtWrk, $this->Nama->SearchOperator);
		$sFilter = "";
		if ($sExtWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sExtWrk</span>";
		elseif ($sWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sWrk</span>";
		if ($sFilter <> "")
			$sFilterList .= "<div><span class=\"ewFilterCaption\">" . $this->Nama->FldCaption() . "</span>" . $sFilter . "</div>";

		// Field Kelas
		$sExtWrk = "";
		$sWrk = "";
		$this->BuildDropDownFilter($this->Kelas, $sExtWrk, $this->Kelas->SearchOperator);
		$sFilter = "";
		if ($sExtWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sExtWrk</span>";
		elseif ($sWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sWrk</span>";
		if ($sFilter <> "")
			$sFilterList .= "<div><span class=\"ewFilterCaption\">" . $this->Kelas->FldCaption() . "</span>" . $sFilter . "</div>";

		// Field Sekolah
		$sExtWrk = "";
		$sWrk = "";
		$this->BuildDropDownFilter($this->Sekolah, $sExtWrk, $this->Sekolah->SearchOperator);
		$sFilter = "";
		if ($sExtWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sExtWrk</span>";
		elseif ($sWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sWrk</span>";
		if ($sFilter <> "")
			$sFilterList .= "<div><span class=\"ewFilterCaption\">" . $this->Sekolah->FldCaption() . "</span>" . $sFilter . "</div>";

		// Field Periode_Text
		$sExtWrk = "";
		$sWrk = "";
		$this->BuildDropDownFilter($this->Periode_Text, $sExtWrk, $this->Periode_Text->SearchOperator);
		$sFilter = "";
		if ($sExtWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sExtWrk</span>";
		elseif ($sWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sWrk</span>";
		if ($sFilter <> "")
			$sFilterList .= "<div><span class=\"ewFilterCaption\">" . $this->Periode_Text->FldCaption() . "</span>" . $sFilter . "</div>";
		$divstyle = "";
		$divdataclass = "";

		// Show Filters
		if ($sFilterList <> "" || $showDate) {
			$sMessage = "<div" . $divstyle . $divdataclass . "><div id=\"ewrFilterList\" class=\"alert alert-info ewDisplayTable\">";
			if ($showDate)
				$sMessage .= "<div id=\"ewrCurrentDate\">" . $ReportLanguage->Phrase("ReportGeneratedDate") . ewr_FormatDateTime(date("Y-m-d H:i:s"), 1) . "</div>";
			if ($sFilterList <> "")
				$sMessage .= "<div id=\"ewrCurrentFilters\">" . $ReportLanguage->Phrase("CurrentFilters") . "</div>" . $sFilterList;
			$sMessage .= "</div></div>";
			$this->Message_Showing($sMessage, "");
			echo $sMessage;
		}
	}

	// Get list of filters
	function GetFilterList() {

		// Initialize
		$sFilterList = "";

		// Field NIS
		$sWrk = "";
		$sWrk = ($this->NIS->DropDownValue <> EWR_INIT_VALUE) ? $this->NIS->DropDownValue : "";
		if (is_array($sWrk))
			$sWrk = implode("||", $sWrk);
		if ($sWrk <> "")
			$sWrk = "\"sv_NIS\":\"" . ewr_JsEncode2($sWrk) . "\"";
		if ($sWrk <> "") {
			if ($sFilterList <> "") $sFilterList .= ",";
			$sFilterList .= $sWrk;
		}

		// Field Nama
		$sWrk = "";
		$sWrk = ($this->Nama->DropDownValue <> EWR_INIT_VALUE) ? $this->Nama->DropDownValue : "";
		if (is_array($sWrk))
			$sWrk = implode("||", $sWrk);
		if ($sWrk <> "")
			$sWrk = "\"sv_Nama\":\"" . ewr_JsEncode2($sWrk) . "\"";
		if ($sWrk <> "") {
			if ($sFilterList <> "") $sFilterList .= ",";
			$sFilterList .= $sWrk;
		}

		// Field Kelas
		$sWrk = "";
		$sWrk = ($this->Kelas->DropDownValue <> EWR_INIT_VALUE) ? $this->Kelas->DropDownValue : "";
		if (is_array($sWrk))
			$sWrk = implode("||", $sWrk);
		if ($sWrk <> "")
			$sWrk = "\"sv_Kelas\":\"" . ewr_JsEncode2($sWrk) . "\"";
		if ($sWrk <> "") {
			if ($sFilterList <> "") $sFilterList .= ",";
			$sFilterList .= $sWrk;
		}

		// Field Sekolah
		$sWrk = "";
		$sWrk = ($this->Sekolah->DropDownValue <> EWR_INIT_VALUE) ? $this->Sekolah->DropDownValue : "";
		if (is_array($sWrk))
			$sWrk = implode("||", $sWrk);
		if ($sWrk <> "")
			$sWrk = "\"sv_Sekolah\":\"" . ewr_JsEncode2($sWrk) . "\"";
		if ($sWrk <> "") {
			if ($sFilterList <> "") $sFilterList .= ",";
			$sFilterList .= $sWrk;
		}

		// Field Periode_Text
		$sWrk = "";
		$sWrk = ($this->Periode_Text->DropDownValue <> EWR_INIT_VALUE) ? $this->Periode_Text->DropDownValue : "";
		if (is_array($sWrk))
			$sWrk = implode("||", $sWrk);
		if ($sWrk <> "")
			$sWrk = "\"sv_Periode_Text\":\"" . ewr_JsEncode2($sWrk) . "\"";
		if ($sWrk <> "") {
			if ($sFilterList <> "") $sFilterList .= ",";
			$sFilterList .= $sWrk;
		}

		// Return filter list in json
		if ($sFilterList <> "")
			return "{" . $sFilterList . "}";
		else
			return "null";
	}

	// Restore list of filters
	function RestoreFilterList() {

		// Return if not reset filter
		if (@$_POST["cmd"] <> "resetfilter")
			return FALSE;
		$filter = json_decode(ewr_StripSlashes(@$_POST["filter"]), TRUE);
		return $this->SetupFilterList($filter);
	}

	// Setup list of filters
	function SetupFilterList($filter) {
		if (!is_array($filter))
			return FALSE;

		// Field NIS
		$bRestoreFilter = FALSE;
		if (array_key_exists("sv_NIS", $filter)) {
			$sWrk = $filter["sv_NIS"];
			if (strpos($sWrk, "||") !== FALSE)
				$sWrk = explode("||", $sWrk);
			$this->SetSessionDropDownValue($sWrk, @$filter["so_NIS"], "NIS");
			$bRestoreFilter = TRUE;
		}
		if (!$bRestoreFilter) { // Clear filter
			$this->SetSessionDropDownValue(EWR_INIT_VALUE, "", "NIS");
		}

		// Field Nama
		$bRestoreFilter = FALSE;
		if (array_key_exists("sv_Nama", $filter)) {
			$sWrk = $filter["sv_Nama"];
			if (strpos($sWrk, "||") !== FALSE)
				$sWrk = explode("||", $sWrk);
			$this->SetSessionDropDownValue($sWrk, @$filter["so_Nama"], "Nama");
			$bRestoreFilter = TRUE;
		}
		if (!$bRestoreFilter) { // Clear filter
			$this->SetSessionDropDownValue(EWR_INIT_VALUE, "", "Nama");
		}

		// Field Kelas
		$bRestoreFilter = FALSE;
		if (array_key_exists("sv_Kelas", $filter)) {
			$sWrk = $filter["sv_Kelas"];
			if (strpos($sWrk, "||") !== FALSE)
				$sWrk = explode("||", $sWrk);
			$this->SetSessionDropDownValue($sWrk, @$filter["so_Kelas"], "Kelas");
			$bRestoreFilter = TRUE;
		}
		if (!$bRestoreFilter) { // Clear filter
			$this->SetSessionDropDownValue(EWR_INIT_VALUE, "", "Kelas");
		}

		// Field Sekolah
		$bRestoreFilter = FALSE;
		if (array_key_exists("sv_Sekolah", $filter)) {
			$sWrk = $filter["sv_Sekolah"];
			if (strpos($sWrk, "||") !== FALSE)
				$sWrk = explode("||", $sWrk);
			$this->SetSessionDropDownValue($sWrk, @$filter["so_Sekolah"], "Sekolah");
			$bRestoreFilter = TRUE;
		}
		if (!$bRestoreFilter) { // Clear filter
			$this->SetSessionDropDownValue(EWR_INIT_VALUE, "", "Sekolah");
		}

		// Field Periode_Text
		$bRestoreFilter = FALSE;
		if (array_key_exists("sv_Periode_Text", $filter)) {
			$sWrk = $filter["sv_Periode_Text"];
			if (strpos($sWrk, "||") !== FALSE)
				$sWrk = explode("||", $sWrk);
			$this->SetSessionDropDownValue($sWrk, @$filter["so_Periode_Text"], "Periode_Text");
			$bRestoreFilter = TRUE;
		}
		if (!$bRestoreFilter) { // Clear filter
			$this->SetSessionDropDownValue(EWR_INIT_VALUE, "", "Periode_Text");
		}
		return TRUE;
	}

	// Return popup filter
	function GetPopupFilter() {
		$sWrk = "";
		if ($this->DrillDown)
			return "";
		return $sWrk;
	}

	//-------------------------------------------------------------------------------
	// Function GetSort
	// - Return Sort parameters based on Sort Links clicked
	// - Variables setup: Session[EWR_TABLE_SESSION_ORDER_BY], Session["sort_Table_Field"]
	function GetSort($options = array()) {
		if ($this->DrillDown)
			return "`Periode_Tahun_Bulan` ASC";
		$bResetSort = @$options["resetsort"] == "1" || @$_GET["cmd"] == "resetsort";
		$orderBy = (@$options["order"] <> "") ? @$options["order"] : ewr_StripSlashes(@$_GET["order"]);
		$orderType = (@$options["ordertype"] <> "") ? @$options["ordertype"] : ewr_StripSlashes(@$_GET["ordertype"]);

		// Check for Ctrl pressed
		$bCtrl = (@$_GET["ctrl"] <> "");

		// Check for a resetsort command
		if ($bResetSort) {
			$this->setOrderBy("");
			$this->setStartGroup(1);
			$this->Sekolah->setSort("");
			$this->Kelas->setSort("");
			$this->NIS->setSort("");
			$this->Nama->setSort("");
			$this->Jenis->setSort("");
			$this->Periode_Tahun_Bulan->setSort("");
			$this->Periode_Text->setSort("");
			$this->Nilai->setSort("");

		// Check for an Order parameter
		} elseif ($orderBy <> "") {
			$this->CurrentOrder = $orderBy;
			$this->CurrentOrderType = $orderType;
			$this->UpdateSort($this->Sekolah, $bCtrl); // Sekolah
			$this->UpdateSort($this->Kelas, $bCtrl); // Kelas
			$this->UpdateSort($this->NIS, $bCtrl); // NIS
			$this->UpdateSort($this->Nama, $bCtrl); // Nama
			$this->UpdateSort($this->Jenis, $bCtrl); // Jenis
			$this->UpdateSort($this->Periode_Tahun_Bulan, $bCtrl); // Periode_Tahun_Bulan
			$this->UpdateSort($this->Periode_Text, $bCtrl); // Periode_Text
			$this->UpdateSort($this->Nilai, $bCtrl); // Nilai
			$sSortSql = $this->SortSql();
			$this->setOrderBy($sSortSql);
			$this->setStartGroup(1);
		}

		// Set up default sort
		if ($this->getOrderBy() == "") {
			$this->setOrderBy("`Periode_Tahun_Bulan` ASC");
			$this->Periode_Tahun_Bulan->setSort("ASC");
		}
		return $this->getOrderBy();
	}

	// Export to HTML
	function ExportHtml($html, $options = array()) {

		//global $gsExportFile;
		//header('Content-Type: text/html' . (EWR_CHARSET <> '' ? ';charset=' . EWR_CHARSET : ''));
		//header('Content-Disposition: attachment; filename=' . $gsExportFile . '.html');

		$folder = @$this->GenOptions["folder"];
		$fileName = @$this->GenOptions["filename"];
		$responseType = @$options["responsetype"];
		$saveToFile = "";

		// Save generate file for print
		if ($folder <> "" && $fileName <> "" && ($responseType == "json" || $responseType == "file" && EWR_REPORT_SAVE_OUTPUT_ON_SERVER)) {
			$baseTag = "<base href=\"" . ewr_BaseUrl() . "\">";
			$html = preg_replace('/<head>/', '<head>' . $baseTag, $html);
			ewr_SaveFile($folder, $fileName, $html);
			$saveToFile = ewr_UploadPathEx(FALSE, $folder) . $fileName;
		}
		if ($saveToFile == "" || $responseType == "file")
			echo $html;
		return $saveToFile;
	}

	// Export to WORD
	function ExportWord($html, $options = array()) {
		global $gsExportFile;
		$folder = @$options["folder"];
		$fileName = @$options["filename"];
		$responseType = @$options["responsetype"];
		$saveToFile = "";
		if ($folder <> "" && $fileName <> "" && ($responseType == "json" || $responseType == "file" && EWR_REPORT_SAVE_OUTPUT_ON_SERVER)) {
		 	ewr_SaveFile(ewr_PathCombine(ewr_AppRoot(), $folder, TRUE), $fileName, $html);
			$saveToFile = ewr_UploadPathEx(FALSE, $folder) . $fileName;
		}
		if ($saveToFile == "" || $responseType == "file") {
			header('Content-Type: application/vnd.ms-word' . (EWR_CHARSET <> '' ? ';charset=' . EWR_CHARSET : ''));
			header('Content-Disposition: attachment; filename=' . $gsExportFile . '.doc');
			echo $html;
		}
		return $saveToFile;
	}

	// Export to EXCEL
	function ExportExcel($html, $options = array()) {
		global $gsExportFile;
		$folder = @$options["folder"];
		$fileName = @$options["filename"];
		$responseType = @$options["responsetype"];
		$saveToFile = "";
		if ($folder <> "" && $fileName <> "" && ($responseType == "json" || $responseType == "file" && EWR_REPORT_SAVE_OUTPUT_ON_SERVER)) {
		 	ewr_SaveFile(ewr_PathCombine(ewr_AppRoot(), $folder, TRUE), $fileName, $html);
			$saveToFile = ewr_UploadPathEx(FALSE, $folder) . $fileName;
		}
		if ($saveToFile == "" || $responseType == "file") {
			header('Content-Type: application/vnd.ms-excel' . (EWR_CHARSET <> '' ? ';charset=' . EWR_CHARSET : ''));
			header('Content-Disposition: attachment; filename=' . $gsExportFile . '.xls');
			echo $html;
		}
		return $saveToFile;
	}

	// Export PDF
	function ExportPdf($html, $options = array()) {
		global $gsExportFile;
		@ini_set("memory_limit", EWR_PDF_MEMORY_LIMIT);
		set_time_limit(EWR_PDF_TIME_LIMIT);
		if (EWR_DEBUG_ENABLED) // Add debug message
			$html = str_replace("</body>", ewr_DebugMsg() . "</body>", $html);
		$dompdf = new \Dompdf\Dompdf(array("pdf_backend" => "Cpdf"));
		$doc = new DOMDocument();
		@$doc->loadHTML('<?xml encoding="uft-8">' . ewr_ConvertToUtf8($html)); // Convert to utf-8
		$spans = $doc->getElementsByTagName("span");
		foreach ($spans as $span) {
			if ($span->getAttribute("class") == "ewFilterCaption")
				$span->parentNode->insertBefore($doc->createElement("span", ":&nbsp;"), $span->nextSibling);
		}
		$html = $doc->saveHTML();
		$html = ewr_ConvertFromUtf8($html);
		$dompdf->load_html($html);
		$dompdf->set_paper("a4", "portrait");
		$dompdf->render();
		$folder = @$options["folder"];
		$fileName = @$options["filename"];
		$responseType = @$options["responsetype"];
		$saveToFile = "";
		if ($folder <> "" && $fileName <> "" && ($responseType == "json" || $responseType == "file" && EWR_REPORT_SAVE_OUTPUT_ON_SERVER)) {
			ewr_SaveFile(ewr_PathCombine(ewr_AppRoot(), $folder, TRUE), $fileName, $dompdf->output());
			$saveToFile = ewr_UploadPathEx(FALSE, $folder) . $fileName;
		}
		if ($saveToFile == "" || $responseType == "file") {
			$sExportFile = strtolower(substr($gsExportFile, -4)) == ".pdf" ? $gsExportFile : $gsExportFile . ".pdf";
			$dompdf->stream($sExportFile, array("Attachment" => 1)); // 0 to open in browser, 1 to download
		}
		ewr_DeleteTmpImages($html);
		return $saveToFile;
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ewr_Header(FALSE) ?>
<?php

// Create page object
if (!isset($r01_sudahbayar_summary)) $r01_sudahbayar_summary = new crr01_sudahbayar_summary();
if (isset($Page)) $OldPage = $Page;
$Page = &$r01_sudahbayar_summary;

// Page init
$Page->Page_Init();

// Page main
$Page->Page_Main();

// Global Page Rendering event (in ewrusrfn*.php)
Page_Rendering();

// Page Rendering event
$Page->Page_Render();
?>
<?php include_once "header.php" ?>
<?php include_once "phprptinc/header.php" ?>
<?php if ($Page->Export == "" || $Page->Export == "print" || $Page->Export == "email" && @$gsEmailContentType == "url") { ?>
<script type="text/javascript">

// Create page object
var r01_sudahbayar_summary = new ewr_Page("r01_sudahbayar_summary");

// Page properties
r01_sudahbayar_summary.PageID = "summary"; // Page ID
var EWR_PAGE_ID = r01_sudahbayar_summary.PageID;

// Extend page with Chart_Rendering function
r01_sudahbayar_summary.Chart_Rendering = 
 function(chart, chartid) { // DO NOT CHANGE THIS LINE!

 	//alert(chartid);
 }

// Extend page with Chart_Rendered function
r01_sudahbayar_summary.Chart_Rendered = 
 function(chart, chartid) { // DO NOT CHANGE THIS LINE!

 	//alert(chartid);
 }
</script>
<?php } ?>
<?php if ($Page->Export == "" && !$Page->DrillDown) { ?>
<script type="text/javascript">

// Form object
var CurrentForm = fr01_sudahbayarsummary = new ewr_Form("fr01_sudahbayarsummary");

// Validate method
fr01_sudahbayarsummary.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);

	// Call Form Custom Validate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}

// Form_CustomValidate method
fr01_sudahbayarsummary.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }
<?php if (EWR_CLIENT_VALIDATE) { ?>
fr01_sudahbayarsummary.ValidateRequired = true; // Uses JavaScript validation
<?php } else { ?>
fr01_sudahbayarsummary.ValidateRequired = false; // No JavaScript validation
<?php } ?>

// Use Ajax
fr01_sudahbayarsummary.Lists["sv_NIS"] = {"LinkField":"sv_NIS","Ajax":true,"DisplayFields":["sv_NIS","","",""],"ParentFields":[],"FilterFields":[],"Options":[],"Template":""};
fr01_sudahbayarsummary.Lists["sv_Nama"] = {"LinkField":"sv_Nama","Ajax":true,"DisplayFields":["sv_Nama","","",""],"ParentFields":[],"FilterFields":[],"Options":[],"Template":""};
fr01_sudahbayarsummary.Lists["sv_Kelas"] = {"LinkField":"sv_Kelas","Ajax":true,"DisplayFields":["sv_Kelas","","",""],"ParentFields":[],"FilterFields":[],"Options":[],"Template":""};
fr01_sudahbayarsummary.Lists["sv_Sekolah"] = {"LinkField":"sv_Sekolah","Ajax":true,"DisplayFields":["sv_Sekolah","","",""],"ParentFields":[],"FilterFields":[],"Options":[],"Template":""};
fr01_sudahbayarsummary.Lists["sv_Periode_Text"] = {"LinkField":"sv_Periode_Text","Ajax":true,"DisplayFields":["sv_Periode_Text","","",""],"ParentFields":[],"FilterFields":[],"Options":[],"Template":""};
</script>
<?php } ?>
<?php if ($Page->Export == "" && !$Page->DrillDown) { ?>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($Page->Export == "") { ?>
<!-- container (begin) -->
<div id="ewContainer" class="ewContainer">
<!-- top container (begin) -->
<div id="ewTop" class="ewTop">
<a id="top"></a>
<?php } ?>
<?php if (@$Page->GenOptions["showfilter"] == "1") { ?>
<?php $Page->ShowFilterList(TRUE) ?>
<?php } ?>
<!-- top slot -->
<div class="ewToolbar">
<?php if ($Page->Export == "" && (!$Page->DrillDown || !$Page->DrillDownInPanel)) { ?>
<?php if ($ReportBreadcrumb) $ReportBreadcrumb->Render(); ?>
<?php } ?>
<?php
if (!$Page->DrillDownInPanel) {
	$Page->ExportOptions->Render("body");
	$Page->SearchOptions->Render("body");
	$Page->FilterOptions->Render("body");
	$Page->GenerateOptions->Render("body");
}
?>
<?php if ($Page->Export == "" && !$Page->DrillDown) { ?>
<?php echo $ReportLanguage->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php $Page->ShowPageHeader(); ?>
<?php $Page->ShowMessage(); ?>
<?php if ($Page->Export == "") { ?>
</div>
<!-- top container (end) -->
	<!-- left container (begin) -->
	<div id="ewLeft" class="ewLeft">
<?php } ?>
	<!-- Left slot -->
<?php if ($Page->Export == "") { ?>
	</div>
	<!-- left container (end) -->
	<!-- center container - report (begin) -->
	<div id="ewCenter" class="ewCenter">
<?php } ?>
	<!-- center slot -->
<!-- summary report starts -->
<?php if ($Page->Export <> "pdf") { ?>
<div id="report_summary">
<?php } ?>
<?php if ($Page->Export == "" && !$Page->DrillDown) { ?>
<!-- Search form (begin) -->
<form name="fr01_sudahbayarsummary" id="fr01_sudahbayarsummary" class="form-inline ewForm ewExtFilterForm" action="<?php echo ewr_CurrentPage() ?>">
<?php $SearchPanelClass = ($Page->Filter <> "") ? " in" : " in"; ?>
<div id="fr01_sudahbayarsummary_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<div id="r_1" class="ewRow">
<div id="c_NIS" class="ewCell form-group">
	<label for="sv_NIS" class="ewSearchCaption ewLabel"><?php echo $Page->NIS->FldCaption() ?></label>
	<span class="ewSearchField">
<?php ewr_PrependClass($Page->NIS->EditAttrs["class"], "form-control"); ?>
<select data-table="r01_sudahbayar" data-field="x_NIS" data-value-separator="<?php echo ewr_HtmlEncode(is_array($Page->NIS->DisplayValueSeparator) ? json_encode($Page->NIS->DisplayValueSeparator) : $Page->NIS->DisplayValueSeparator) ?>" id="sv_NIS" name="sv_NIS"<?php echo $Page->NIS->EditAttributes() ?>>
<option value=""><?php echo $ReportLanguage->Phrase("PleaseSelect") ?></option>
<?php
	$cntf = is_array($Page->NIS->AdvancedFilters) ? count($Page->NIS->AdvancedFilters) : 0;
	$cntd = is_array($Page->NIS->DropDownList) ? count($Page->NIS->DropDownList) : 0;
	$totcnt = $cntf + $cntd;
	$wrkcnt = 0;
	if ($cntf > 0) {
		foreach ($Page->NIS->AdvancedFilters as $filter) {
			if ($filter->Enabled) {
				$selwrk = ewr_MatchedFilterValue($Page->NIS->DropDownValue, $filter->ID) ? " selected" : "";
?>
<option value="<?php echo $filter->ID ?>"<?php echo $selwrk ?>><?php echo $filter->Name ?></option>
<?php
				$wrkcnt += 1;
			}
		}
	}
	for ($i = 0; $i < $cntd; $i++) {
		$selwrk = " selected";
?>
<option value="<?php echo $Page->NIS->DropDownList[$i] ?>"<?php echo $selwrk ?>><?php echo ewr_DropDownDisplayValue($Page->NIS->DropDownList[$i], "", 0) ?></option>
<?php
		$wrkcnt += 1;
	}
?>
</select>
<input type="hidden" name="s_sv_NIS" id="s_sv_NIS" value="<?php echo $Page->NIS->LookupFilterQuery() ?>"></span>
</div>
</div>
<div id="r_2" class="ewRow">
<div id="c_Nama" class="ewCell form-group">
	<label for="sv_Nama" class="ewSearchCaption ewLabel"><?php echo $Page->Nama->FldCaption() ?></label>
	<span class="ewSearchField">
<?php ewr_PrependClass($Page->Nama->EditAttrs["class"], "form-control"); ?>
<select data-table="r01_sudahbayar" data-field="x_Nama" data-value-separator="<?php echo ewr_HtmlEncode(is_array($Page->Nama->DisplayValueSeparator) ? json_encode($Page->Nama->DisplayValueSeparator) : $Page->Nama->DisplayValueSeparator) ?>" id="sv_Nama" name="sv_Nama"<?php echo $Page->Nama->EditAttributes() ?>>
<option value=""><?php echo $ReportLanguage->Phrase("PleaseSelect") ?></option>
<?php
	$cntf = is_array($Page->Nama->AdvancedFilters) ? count($Page->Nama->AdvancedFilters) : 0;
	$cntd = is_array($Page->Nama->DropDownList) ? count($Page->Nama->DropDownList) : 0;
	$totcnt = $cntf + $cntd;
	$wrkcnt = 0;
	if ($cntf > 0) {
		foreach ($Page->Nama->AdvancedFilters as $filter) {
			if ($filter->Enabled) {
				$selwrk = ewr_MatchedFilterValue($Page->Nama->DropDownValue, $filter->ID) ? " selected" : "";
?>
<option value="<?php echo $filter->ID ?>"<?php echo $selwrk ?>><?php echo $filter->Name ?></option>
<?php
				$wrkcnt += 1;
			}
		}
	}
	for ($i = 0; $i < $cntd; $i++) {
		$selwrk = " selected";
?>
<option value="<?php echo $Page->Nama->DropDownList[$i] ?>"<?php echo $selwrk ?>><?php echo ewr_DropDownDisplayValue($Page->Nama->DropDownList[$i], "", 0) ?></option>
<?php
		$wrkcnt += 1;
	}
?>
</select>
<input type="hidden" name="s_sv_Nama" id="s_sv_Nama" value="<?php echo $Page->Nama->LookupFilterQuery() ?>"></span>
</div>
</div>
<div id="r_3" class="ewRow">
<div id="c_Kelas" class="ewCell form-group">
	<label for="sv_Kelas" class="ewSearchCaption ewLabel"><?php echo $Page->Kelas->FldCaption() ?></label>
	<span class="ewSearchField">
<?php ewr_PrependClass($Page->Kelas->EditAttrs["class"], "form-control"); ?>
<select data-table="r01_sudahbayar" data-field="x_Kelas" data-value-separator="<?php echo ewr_HtmlEncode(is_array($Page->Kelas->DisplayValueSeparator) ? json_encode($Page->Kelas->DisplayValueSeparator) : $Page->Kelas->DisplayValueSeparator) ?>" id="sv_Kelas" name="sv_Kelas"<?php echo $Page->Kelas->EditAttributes() ?>>
<option value=""><?php echo $ReportLanguage->Phrase("PleaseSelect") ?></option>
<?php
	$cntf = is_array($Page->Kelas->AdvancedFilters) ? count($Page->Kelas->AdvancedFilters) : 0;
	$cntd = is_array($Page->Kelas->DropDownList) ? count($Page->Kelas->DropDownList) : 0;
	$totcnt = $cntf + $cntd;
	$wrkcnt = 0;
	if ($cntf > 0) {
		foreach ($Page->Kelas->AdvancedFilters as $filter) {
			if ($filter->Enabled) {
				$selwrk = ewr_MatchedFilterValue($Page->Kelas->DropDownValue, $filter->ID) ? " selected" : "";
?>
<option value="<?php echo $filter->ID ?>"<?php echo $selwrk ?>><?php echo $filter->Name ?></option>
<?php
				$wrkcnt += 1;
			}
		}
	}
	for ($i = 0; $i < $cntd; $i++) {
		$selwrk = " selected";
?>
<option value="<?php echo $Page->Kelas->DropDownList[$i] ?>"<?php echo $selwrk ?>><?php echo ewr_DropDownDisplayValue($Page->Kelas->DropDownList[$i], "", 0) ?></option>
<?php
		$wrkcnt += 1;
	}
?>
</select>
<input type="hidden" name="s_sv_Kelas" id="s_sv_Kelas" value="<?php echo $Page->Kelas->LookupFilterQuery() ?>"></span>
</div>
</div>
<div id="r_4" class="ewRow">
<div id="c_Sekolah" class="ewCell form-group">
	<label for="sv_Sekolah" class="ewSearchCaption ewLabel"><?php echo $Page->Sekolah->FldCaption() ?></label>
	<span class="ewSearchField">
<?php ewr_PrependClass($Page->Sekolah->EditAttrs["class"], "form-control"); ?>
<select data-table="r01_sudahbayar" data-field="x_Sekolah" data-value-separator="<?php echo ewr_HtmlEncode(is_array($Page->Sekolah->DisplayValueSeparator) ? json_encode($Page->Sekolah->DisplayValueSeparator) : $Page->Sekolah->DisplayValueSeparator) ?>" id="sv_Sekolah" name="sv_Sekolah"<?php echo $Page->Sekolah->EditAttributes() ?>>
<option value=""><?php echo $ReportLanguage->Phrase("PleaseSelect") ?></option>
<?php
	$cntf = is_array($Page->Sekolah->AdvancedFilters) ? count($Page->Sekolah->AdvancedFilters) : 0;
	$cntd = is_array($Page->Sekolah->DropDownList) ? count($Page->Sekolah->DropDownList) : 0;
	$totcnt = $cntf + $cntd;
	$wrkcnt = 0;
	if ($cntf > 0) {
		foreach ($Page->Sekolah->AdvancedFilters as $filter) {
			if ($filter->Enabled) {
				$selwrk = ewr_MatchedFilterValue($Page->Sekolah->DropDownValue, $filter->ID) ? " selected" : "";
?>
<option value="<?php echo $filter->ID ?>"<?php echo $selwrk ?>><?php echo $filter->Name ?></option>
<?php
				$wrkcnt += 1;
			}
		}
	}
	for ($i = 0; $i < $cntd; $i++) {
		$selwrk = " selected";
?>
<option value="<?php echo $Page->Sekolah->DropDownList[$i] ?>"<?php echo $selwrk ?>><?php echo ewr_DropDownDisplayValue($Page->Sekolah->DropDownList[$i], "", 0) ?></option>
<?php
		$wrkcnt += 1;
	}
?>
</select>
<input type="hidden" name="s_sv_Sekolah" id="s_sv_Sekolah" value="<?php echo $Page->Sekolah->LookupFilterQuery() ?>"></span>
</div>
</div>
<div id="r_5" class="ewRow">
<div id="c_Periode_Text" class="ewCell form-group">
	<label for="sv_Periode_Text" class="ewSearchCaption ewLabel"><?php echo $Page->Periode_Text->FldCaption() ?></label>
	<span class="ewSearchField">
<?php ewr_PrependClass($Page->Periode_Text->EditAttrs["class"], "form-control"); ?>
<select data-table="r01_sudahbayar" data-field="x_Periode_Text" data-value-separator="<?php echo ewr_HtmlEncode(is_array($Page->Periode_Text->DisplayValueSeparator) ? json_encode($Page->Periode_Text->DisplayValueSeparator) : $Page->Periode_Text->DisplayValueSeparator) ?>" id="sv_Periode_Text" name="sv_Periode_Text"<?php echo $Page->Periode_Text->EditAttributes() ?>>
<option value=""><?php echo $ReportLanguage->Phrase("PleaseSelect") ?></option>
<?php
	$cntf = is_array($Page->Periode_Text->AdvancedFilters) ? count($Page->Periode_Text->AdvancedFilters) : 0;
	$cntd = is_array($Page->Periode_Text->DropDownList) ? count($Page->Periode_Text->DropDownList) : 0;
	$totcnt = $cntf + $cntd;
	$wrkcnt = 0;
	if ($cntf > 0) {
		foreach ($Page->Periode_Text->AdvancedFilters as $filter) {
			if ($filter->Enabled) {
				$selwrk = ewr_MatchedFilterValue($Page->Periode_Text->DropDownValue, $filter->ID) ? " selected" : "";
?>
<option value="<?php echo $filter->ID ?>"<?php echo $selwrk ?>><?php echo $filter->Name ?></option>
<?php
				$wrkcnt += 1;
			}
		}
	}
	for ($i = 0; $i < $cntd; $i++) {
		$selwrk = " selected";
?>
<option value="<?php echo $Page->Periode_Text->DropDownList[$i] ?>"<?php echo $selwrk ?>><?php echo ewr_DropDownDisplayValue($Page->Periode_Text->DropDownList[$i], "", 0) ?></option>
<?php
		$wrkcnt += 1;
	}
?>
</select>
<input type="hidden" name="s_sv_Periode_Text" id="s_sv_Periode_Text" value="<?php echo $Page->Periode_Text->LookupFilterQuery() ?>"></span>
</div>
</div>
<div class="ewRow"><input type="submit" name="btnsubmit" id="btnsubmit" class="btn btn-primary" value="<?php echo $ReportLanguage->Phrase("Search") ?>">
<input type="reset" name="btnreset" id="btnreset" class="btn hide" value="<?php echo $ReportLanguage->Phrase("Reset") ?>"></div>
</div>
</form>
<script type="text/javascript">
fr01_sudahbayarsummary.Init();
fr01_sudahbayarsummary.FilterList = <?php echo $Page->GetFilterList() ?>;
</script>
<!-- Search form (end) -->
<?php } ?>
<?php if ($Page->ShowCurrentFilter) { ?>
<?php $Page->ShowFilterList() ?>
<?php } ?>
<?php

// Set the last group to display if not export all
if ($Page->ExportAll && $Page->Export <> "") {
	$Page->StopGrp = $Page->TotalGrps;
} else {
	$Page->StopGrp = $Page->StartGrp + $Page->DisplayGrps - 1;
}

// Stop group <= total number of groups
if (intval($Page->StopGrp) > intval($Page->TotalGrps))
	$Page->StopGrp = $Page->TotalGrps;
$Page->RecCount = 0;
$Page->RecIndex = 0;

// Get first row
if ($Page->TotalGrps > 0) {
	$Page->GetGrpRow(1);
	$Page->GrpCounter[0] = 1;
	$Page->GrpCounter[1] = 1;
	$Page->GrpCounter[2] = 1;
	$Page->GrpCounter[3] = 1;
	$Page->GrpCount = 1;
}
$Page->GrpIdx = ewr_InitArray($Page->StopGrp - $Page->StartGrp + 1, -1);
while ($rsgrp && !$rsgrp->EOF && $Page->GrpCount <= $Page->DisplayGrps || $Page->ShowHeader) {

	// Show dummy header for custom template
	// Show header

	if ($Page->ShowHeader) {
?>
<?php if ($Page->GrpCount > 1) { ?>
</tbody>
</table>
<?php if ($Page->Export <> "pdf") { ?>
</div>
<?php } ?>
<?php if ($Page->Export == "" && !($Page->DrillDown && $Page->TotalGrps > 0)) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php include "r01_sudahbayarsmrypager.php" ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if ($Page->Export <> "pdf") { ?>
</div>
<?php } ?>
<span data-class="tpb<?php echo $Page->GrpCount-1 ?>_r01_sudahbayar"><?php echo $Page->PageBreakContent ?></span>
<?php } ?>
<?php if ($Page->Export <> "pdf") { ?>
<?php if ($Page->Export == "word" || $Page->Export == "excel") { ?>
<div class="ewGrid"<?php echo $Page->ReportTableStyle ?>>
<?php } else { ?>
<div class="panel panel-default ewGrid"<?php echo $Page->ReportTableStyle ?>>
<?php } ?>
<?php } ?>
<!-- Report grid (begin) -->
<?php if ($Page->Export <> "pdf") { ?>
<div class="<?php if (ewr_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php } ?>
<table class="<?php echo $Page->ReportTableClass ?>">
<thead>
	<!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($Page->Sekolah->Visible) { ?>
	<?php if ($Page->Sekolah->ShowGroupHeaderAsRow) { ?>
	<td data-field="Sekolah">&nbsp;</td>
	<?php } else { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="Sekolah"><div class="r01_sudahbayar_Sekolah"><span class="ewTableHeaderCaption"><?php echo $Page->Sekolah->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="Sekolah">
<?php if ($Page->SortUrl($Page->Sekolah) == "") { ?>
		<div class="ewTableHeaderBtn r01_sudahbayar_Sekolah">
			<span class="ewTableHeaderCaption"><?php echo $Page->Sekolah->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer r01_sudahbayar_Sekolah" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->Sekolah) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->Sekolah->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->Sekolah->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->Sekolah->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
	<?php } ?>
<?php } ?>
<?php if ($Page->Kelas->Visible) { ?>
	<?php if ($Page->Kelas->ShowGroupHeaderAsRow) { ?>
	<td data-field="Kelas">&nbsp;</td>
	<?php } else { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="Kelas"><div class="r01_sudahbayar_Kelas"><span class="ewTableHeaderCaption"><?php echo $Page->Kelas->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="Kelas">
<?php if ($Page->SortUrl($Page->Kelas) == "") { ?>
		<div class="ewTableHeaderBtn r01_sudahbayar_Kelas">
			<span class="ewTableHeaderCaption"><?php echo $Page->Kelas->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer r01_sudahbayar_Kelas" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->Kelas) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->Kelas->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->Kelas->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->Kelas->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
	<?php } ?>
<?php } ?>
<?php if ($Page->NIS->Visible) { ?>
	<?php if ($Page->NIS->ShowGroupHeaderAsRow) { ?>
	<td data-field="NIS">&nbsp;</td>
	<?php } else { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="NIS"><div class="r01_sudahbayar_NIS"><span class="ewTableHeaderCaption"><?php echo $Page->NIS->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="NIS">
<?php if ($Page->SortUrl($Page->NIS) == "") { ?>
		<div class="ewTableHeaderBtn r01_sudahbayar_NIS">
			<span class="ewTableHeaderCaption"><?php echo $Page->NIS->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer r01_sudahbayar_NIS" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->NIS) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->NIS->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->NIS->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->NIS->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
	<?php } ?>
<?php } ?>
<?php if ($Page->Nama->Visible) { ?>
	<?php if ($Page->Nama->ShowGroupHeaderAsRow) { ?>
	<td data-field="Nama">&nbsp;</td>
	<?php } else { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="Nama"><div class="r01_sudahbayar_Nama"><span class="ewTableHeaderCaption"><?php echo $Page->Nama->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="Nama">
<?php if ($Page->SortUrl($Page->Nama) == "") { ?>
		<div class="ewTableHeaderBtn r01_sudahbayar_Nama">
			<span class="ewTableHeaderCaption"><?php echo $Page->Nama->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer r01_sudahbayar_Nama" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->Nama) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->Nama->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->Nama->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->Nama->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
	<?php } ?>
<?php } ?>
<?php if ($Page->Jenis->Visible) { ?>
	<?php if ($Page->Jenis->ShowGroupHeaderAsRow) { ?>
	<td data-field="Jenis">&nbsp;</td>
	<?php } else { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="Jenis"><div class="r01_sudahbayar_Jenis"><span class="ewTableHeaderCaption"><?php echo $Page->Jenis->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="Jenis">
<?php if ($Page->SortUrl($Page->Jenis) == "") { ?>
		<div class="ewTableHeaderBtn r01_sudahbayar_Jenis">
			<span class="ewTableHeaderCaption"><?php echo $Page->Jenis->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer r01_sudahbayar_Jenis" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->Jenis) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->Jenis->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->Jenis->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->Jenis->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
	<?php } ?>
<?php } ?>
<?php if ($Page->Periode_Tahun_Bulan->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="Periode_Tahun_Bulan"><div class="r01_sudahbayar_Periode_Tahun_Bulan"><span class="ewTableHeaderCaption"><?php echo $Page->Periode_Tahun_Bulan->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="Periode_Tahun_Bulan">
<?php if ($Page->SortUrl($Page->Periode_Tahun_Bulan) == "") { ?>
		<div class="ewTableHeaderBtn r01_sudahbayar_Periode_Tahun_Bulan">
			<span class="ewTableHeaderCaption"><?php echo $Page->Periode_Tahun_Bulan->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer r01_sudahbayar_Periode_Tahun_Bulan" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->Periode_Tahun_Bulan) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->Periode_Tahun_Bulan->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->Periode_Tahun_Bulan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->Periode_Tahun_Bulan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->Periode_Text->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="Periode_Text"><div class="r01_sudahbayar_Periode_Text"><span class="ewTableHeaderCaption"><?php echo $Page->Periode_Text->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="Periode_Text">
<?php if ($Page->SortUrl($Page->Periode_Text) == "") { ?>
		<div class="ewTableHeaderBtn r01_sudahbayar_Periode_Text">
			<span class="ewTableHeaderCaption"><?php echo $Page->Periode_Text->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer r01_sudahbayar_Periode_Text" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->Periode_Text) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->Periode_Text->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->Periode_Text->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->Periode_Text->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->Nilai->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="Nilai"><div class="r01_sudahbayar_Nilai"><span class="ewTableHeaderCaption"><?php echo $Page->Nilai->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="Nilai">
<?php if ($Page->SortUrl($Page->Nilai) == "") { ?>
		<div class="ewTableHeaderBtn r01_sudahbayar_Nilai">
			<span class="ewTableHeaderCaption"><?php echo $Page->Nilai->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer r01_sudahbayar_Nilai" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->Nilai) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->Nilai->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->Nilai->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->Nilai->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
	</tr>
</thead>
<tbody>
<?php
		if ($Page->TotalGrps == 0) break; // Show header only
		$Page->ShowHeader = FALSE;
	}

	// Build detail SQL
	$sWhere = ewr_DetailFilterSQL($Page->Sekolah, $Page->getSqlFirstGroupField(), $Page->Sekolah->GroupValue(), $Page->DBID);
	if ($Page->PageFirstGroupFilter <> "") $Page->PageFirstGroupFilter .= " OR ";
	$Page->PageFirstGroupFilter .= $sWhere;
	if ($Page->Filter != "")
		$sWhere = "($Page->Filter) AND ($sWhere)";
	$sSql = ewr_BuildReportSql($Page->getSqlSelect(), $Page->getSqlWhere(), $Page->getSqlGroupBy(), $Page->getSqlHaving(), $Page->getSqlOrderBy(), $sWhere, $Page->Sort);
	$rs = $Page->GetDetailRs($sSql);
	$rsdtlcnt = ($rs) ? $rs->RecordCount() : 0;
	if ($rsdtlcnt > 0)
		$Page->GetRow(1);
	$Page->GrpIdx[$Page->GrpCount] = array(-1);
	$Page->GrpIdx[$Page->GrpCount][] = array(-1);
	$Page->GrpIdx[$Page->GrpCount][][] = array(-1);
	$Page->GrpIdx[$Page->GrpCount][][][] = array(-1);
	while ($rs && !$rs->EOF) { // Loop detail records
		$Page->RecCount++;
		$Page->RecIndex++;
?>
<?php if ($Page->Sekolah->Visible && $Page->ChkLvlBreak(1) && $Page->Sekolah->ShowGroupHeaderAsRow) { ?>
<?php

		// Render header row
		$Page->ResetAttrs();
		$Page->RowType = EWR_ROWTYPE_TOTAL;
		$Page->RowTotalType = EWR_ROWTOTAL_GROUP;
		$Page->RowTotalSubType = EWR_ROWTOTAL_HEADER;
		$Page->RowGroupLevel = 1;
		$Page->Sekolah->Count = $Page->GetSummaryCount(1);
		$Page->RenderRow();
?>
	<tr<?php echo $Page->RowAttributes(); ?>>
<?php if ($Page->Sekolah->Visible) { ?>
		<td data-field="Sekolah"<?php echo $Page->Sekolah->CellAttributes(); ?>><span class="ewGroupToggle icon-collapse"></span></td>
<?php } ?>
		<td data-field="Sekolah" colspan="<?php echo ($Page->GrpColumnCount + $Page->DtlColumnCount - 1) ?>"<?php echo $Page->Sekolah->CellAttributes() ?>>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
		<span class="ewSummaryCaption r01_sudahbayar_Sekolah"><span class="ewTableHeaderCaption"><?php echo $Page->Sekolah->FldCaption() ?></span></span>
<?php } else { ?>
	<?php if ($Page->SortUrl($Page->Sekolah) == "") { ?>
		<span class="ewSummaryCaption r01_sudahbayar_Sekolah">
			<span class="ewTableHeaderCaption"><?php echo $Page->Sekolah->FldCaption() ?></span>
		</span>
	<?php } else { ?>
		<span class="ewTableHeaderBtn ewPointer ewSummaryCaption r01_sudahbayar_Sekolah" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->Sekolah) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->Sekolah->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->Sekolah->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->Sekolah->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</span>
	<?php } ?>
<?php } ?>
		<?php echo $ReportLanguage->Phrase("SummaryColon") ?>
<span data-class="tpx<?php echo $Page->GrpCount ?>_r01_sudahbayar_Sekolah"<?php echo $Page->Sekolah->ViewAttributes() ?>><?php echo $Page->Sekolah->GroupViewValue ?></span>
		<span class="ewSummaryCount">(<span class="ewAggregateCaption"><?php echo $ReportLanguage->Phrase("RptCnt") ?></span><?php echo $ReportLanguage->Phrase("AggregateEqual") ?><span class="ewAggregateValue"><?php echo ewr_FormatNumber($Page->Sekolah->Count,0,-2,-2,-2) ?></span>)</span>
		</td>
	</tr>
<?php } ?>
<?php if ($Page->Kelas->Visible && $Page->ChkLvlBreak(2) && $Page->Kelas->ShowGroupHeaderAsRow) { ?>
<?php

		// Render header row
		$Page->ResetAttrs();
		$Page->RowType = EWR_ROWTYPE_TOTAL;
		$Page->RowTotalType = EWR_ROWTOTAL_GROUP;
		$Page->RowTotalSubType = EWR_ROWTOTAL_HEADER;
		$Page->RowGroupLevel = 2;
		$Page->Kelas->Count = $Page->GetSummaryCount(2);
		$Page->RenderRow();
?>
	<tr<?php echo $Page->RowAttributes(); ?>>
<?php if ($Page->Sekolah->Visible) { ?>
		<td data-field="Sekolah"<?php echo $Page->Sekolah->CellAttributes(); ?>></td>
<?php } ?>
<?php if ($Page->Kelas->Visible) { ?>
		<td data-field="Kelas"<?php echo $Page->Kelas->CellAttributes(); ?>><span class="ewGroupToggle icon-collapse"></span></td>
<?php } ?>
		<td data-field="Kelas" colspan="<?php echo ($Page->GrpColumnCount + $Page->DtlColumnCount - 2) ?>"<?php echo $Page->Kelas->CellAttributes() ?>>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
		<span class="ewSummaryCaption r01_sudahbayar_Kelas"><span class="ewTableHeaderCaption"><?php echo $Page->Kelas->FldCaption() ?></span></span>
<?php } else { ?>
	<?php if ($Page->SortUrl($Page->Kelas) == "") { ?>
		<span class="ewSummaryCaption r01_sudahbayar_Kelas">
			<span class="ewTableHeaderCaption"><?php echo $Page->Kelas->FldCaption() ?></span>
		</span>
	<?php } else { ?>
		<span class="ewTableHeaderBtn ewPointer ewSummaryCaption r01_sudahbayar_Kelas" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->Kelas) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->Kelas->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->Kelas->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->Kelas->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</span>
	<?php } ?>
<?php } ?>
		<?php echo $ReportLanguage->Phrase("SummaryColon") ?>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->GrpCounter[0] ?>_r01_sudahbayar_Kelas"<?php echo $Page->Kelas->ViewAttributes() ?>><?php echo $Page->Kelas->GroupViewValue ?></span>
		<span class="ewSummaryCount">(<span class="ewAggregateCaption"><?php echo $ReportLanguage->Phrase("RptCnt") ?></span><?php echo $ReportLanguage->Phrase("AggregateEqual") ?><span class="ewAggregateValue"><?php echo ewr_FormatNumber($Page->Kelas->Count,0,-2,-2,-2) ?></span>)</span>
		</td>
	</tr>
<?php } ?>
<?php if ($Page->NIS->Visible && $Page->ChkLvlBreak(3) && $Page->NIS->ShowGroupHeaderAsRow) { ?>
<?php

		// Render header row
		$Page->ResetAttrs();
		$Page->RowType = EWR_ROWTYPE_TOTAL;
		$Page->RowTotalType = EWR_ROWTOTAL_GROUP;
		$Page->RowTotalSubType = EWR_ROWTOTAL_HEADER;
		$Page->RowGroupLevel = 3;
		$Page->NIS->Count = $Page->GetSummaryCount(3);
		$Page->RenderRow();
?>
	<tr<?php echo $Page->RowAttributes(); ?>>
<?php if ($Page->Sekolah->Visible) { ?>
		<td data-field="Sekolah"<?php echo $Page->Sekolah->CellAttributes(); ?>></td>
<?php } ?>
<?php if ($Page->Kelas->Visible) { ?>
		<td data-field="Kelas"<?php echo $Page->Kelas->CellAttributes(); ?>></td>
<?php } ?>
<?php if ($Page->NIS->Visible) { ?>
		<td data-field="NIS"<?php echo $Page->NIS->CellAttributes(); ?>><span class="ewGroupToggle icon-collapse"></span></td>
<?php } ?>
		<td data-field="NIS" colspan="<?php echo ($Page->GrpColumnCount + $Page->DtlColumnCount - 3) ?>"<?php echo $Page->NIS->CellAttributes() ?>>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
		<span class="ewSummaryCaption r01_sudahbayar_NIS"><span class="ewTableHeaderCaption"><?php echo $Page->NIS->FldCaption() ?></span></span>
<?php } else { ?>
	<?php if ($Page->SortUrl($Page->NIS) == "") { ?>
		<span class="ewSummaryCaption r01_sudahbayar_NIS">
			<span class="ewTableHeaderCaption"><?php echo $Page->NIS->FldCaption() ?></span>
		</span>
	<?php } else { ?>
		<span class="ewTableHeaderBtn ewPointer ewSummaryCaption r01_sudahbayar_NIS" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->NIS) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->NIS->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->NIS->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->NIS->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</span>
	<?php } ?>
<?php } ?>
		<?php echo $ReportLanguage->Phrase("SummaryColon") ?>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->GrpCounter[0] ?>_<?php echo $Page->GrpCounter[1] ?>_r01_sudahbayar_NIS"<?php echo $Page->NIS->ViewAttributes() ?>><?php echo $Page->NIS->GroupViewValue ?></span>
		<span class="ewSummaryCount">(<span class="ewAggregateCaption"><?php echo $ReportLanguage->Phrase("RptCnt") ?></span><?php echo $ReportLanguage->Phrase("AggregateEqual") ?><span class="ewAggregateValue"><?php echo ewr_FormatNumber($Page->NIS->Count,0,-2,-2,-2) ?></span>)</span>
		</td>
	</tr>
<?php } ?>
<?php if ($Page->Nama->Visible && $Page->ChkLvlBreak(4) && $Page->Nama->ShowGroupHeaderAsRow) { ?>
<?php

		// Render header row
		$Page->ResetAttrs();
		$Page->RowType = EWR_ROWTYPE_TOTAL;
		$Page->RowTotalType = EWR_ROWTOTAL_GROUP;
		$Page->RowTotalSubType = EWR_ROWTOTAL_HEADER;
		$Page->RowGroupLevel = 4;
		$Page->Nama->Count = $Page->GetSummaryCount(4);
		$Page->RenderRow();
?>
	<tr<?php echo $Page->RowAttributes(); ?>>
<?php if ($Page->Sekolah->Visible) { ?>
		<td data-field="Sekolah"<?php echo $Page->Sekolah->CellAttributes(); ?>></td>
<?php } ?>
<?php if ($Page->Kelas->Visible) { ?>
		<td data-field="Kelas"<?php echo $Page->Kelas->CellAttributes(); ?>></td>
<?php } ?>
<?php if ($Page->NIS->Visible) { ?>
		<td data-field="NIS"<?php echo $Page->NIS->CellAttributes(); ?>></td>
<?php } ?>
<?php if ($Page->Nama->Visible) { ?>
		<td data-field="Nama"<?php echo $Page->Nama->CellAttributes(); ?>><span class="ewGroupToggle icon-collapse"></span></td>
<?php } ?>
		<td data-field="Nama" colspan="<?php echo ($Page->GrpColumnCount + $Page->DtlColumnCount - 4) ?>"<?php echo $Page->Nama->CellAttributes() ?>>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
		<span class="ewSummaryCaption r01_sudahbayar_Nama"><span class="ewTableHeaderCaption"><?php echo $Page->Nama->FldCaption() ?></span></span>
<?php } else { ?>
	<?php if ($Page->SortUrl($Page->Nama) == "") { ?>
		<span class="ewSummaryCaption r01_sudahbayar_Nama">
			<span class="ewTableHeaderCaption"><?php echo $Page->Nama->FldCaption() ?></span>
		</span>
	<?php } else { ?>
		<span class="ewTableHeaderBtn ewPointer ewSummaryCaption r01_sudahbayar_Nama" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->Nama) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->Nama->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->Nama->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->Nama->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</span>
	<?php } ?>
<?php } ?>
		<?php echo $ReportLanguage->Phrase("SummaryColon") ?>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->GrpCounter[0] ?>_<?php echo $Page->GrpCounter[1] ?>_<?php echo $Page->GrpCounter[2] ?>_r01_sudahbayar_Nama"<?php echo $Page->Nama->ViewAttributes() ?>><?php echo $Page->Nama->GroupViewValue ?></span>
		<span class="ewSummaryCount">(<span class="ewAggregateCaption"><?php echo $ReportLanguage->Phrase("RptCnt") ?></span><?php echo $ReportLanguage->Phrase("AggregateEqual") ?><span class="ewAggregateValue"><?php echo ewr_FormatNumber($Page->Nama->Count,0,-2,-2,-2) ?></span>)</span>
		</td>
	</tr>
<?php } ?>
<?php if ($Page->Jenis->Visible && $Page->ChkLvlBreak(5) && $Page->Jenis->ShowGroupHeaderAsRow) { ?>
<?php

		// Render header row
		$Page->ResetAttrs();
		$Page->RowType = EWR_ROWTYPE_TOTAL;
		$Page->RowTotalType = EWR_ROWTOTAL_GROUP;
		$Page->RowTotalSubType = EWR_ROWTOTAL_HEADER;
		$Page->RowGroupLevel = 5;
		$Page->Jenis->Count = $Page->GetSummaryCount(5);
		$Page->RenderRow();
?>
	<tr<?php echo $Page->RowAttributes(); ?>>
<?php if ($Page->Sekolah->Visible) { ?>
		<td data-field="Sekolah"<?php echo $Page->Sekolah->CellAttributes(); ?>></td>
<?php } ?>
<?php if ($Page->Kelas->Visible) { ?>
		<td data-field="Kelas"<?php echo $Page->Kelas->CellAttributes(); ?>></td>
<?php } ?>
<?php if ($Page->NIS->Visible) { ?>
		<td data-field="NIS"<?php echo $Page->NIS->CellAttributes(); ?>></td>
<?php } ?>
<?php if ($Page->Nama->Visible) { ?>
		<td data-field="Nama"<?php echo $Page->Nama->CellAttributes(); ?>></td>
<?php } ?>
<?php if ($Page->Jenis->Visible) { ?>
		<td data-field="Jenis"<?php echo $Page->Jenis->CellAttributes(); ?>><span class="ewGroupToggle icon-collapse"></span></td>
<?php } ?>
		<td data-field="Jenis" colspan="<?php echo ($Page->GrpColumnCount + $Page->DtlColumnCount - 5) ?>"<?php echo $Page->Jenis->CellAttributes() ?>>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
		<span class="ewSummaryCaption r01_sudahbayar_Jenis"><span class="ewTableHeaderCaption"><?php echo $Page->Jenis->FldCaption() ?></span></span>
<?php } else { ?>
	<?php if ($Page->SortUrl($Page->Jenis) == "") { ?>
		<span class="ewSummaryCaption r01_sudahbayar_Jenis">
			<span class="ewTableHeaderCaption"><?php echo $Page->Jenis->FldCaption() ?></span>
		</span>
	<?php } else { ?>
		<span class="ewTableHeaderBtn ewPointer ewSummaryCaption r01_sudahbayar_Jenis" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->Jenis) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->Jenis->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->Jenis->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->Jenis->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</span>
	<?php } ?>
<?php } ?>
		<?php echo $ReportLanguage->Phrase("SummaryColon") ?>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->GrpCounter[0] ?>_<?php echo $Page->GrpCounter[1] ?>_<?php echo $Page->GrpCounter[2] ?>_<?php echo $Page->GrpCounter[3] ?>_r01_sudahbayar_Jenis"<?php echo $Page->Jenis->ViewAttributes() ?>><?php echo $Page->Jenis->GroupViewValue ?></span>
		<span class="ewSummaryCount">(<span class="ewAggregateCaption"><?php echo $ReportLanguage->Phrase("RptCnt") ?></span><?php echo $ReportLanguage->Phrase("AggregateEqual") ?><span class="ewAggregateValue"><?php echo ewr_FormatNumber($Page->Jenis->Count,0,-2,-2,-2) ?></span>)</span>
		</td>
	</tr>
<?php } ?>
<?php

		// Render detail row
		$Page->ResetAttrs();
		$Page->RowType = EWR_ROWTYPE_DETAIL;
		$Page->RenderRow();
?>
	<tr<?php echo $Page->RowAttributes(); ?>>
<?php if ($Page->Sekolah->Visible) { ?>
	<?php if ($Page->Sekolah->ShowGroupHeaderAsRow) { ?>
		<td data-field="Sekolah"<?php echo $Page->Sekolah->CellAttributes(); ?>>&nbsp;</td>
	<?php } else { ?>
		<td data-field="Sekolah"<?php echo $Page->Sekolah->CellAttributes(); ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_r01_sudahbayar_Sekolah"<?php echo $Page->Sekolah->ViewAttributes() ?>><?php echo $Page->Sekolah->GroupViewValue ?></span></td>
	<?php } ?>
<?php } ?>
<?php if ($Page->Kelas->Visible) { ?>
	<?php if ($Page->Kelas->ShowGroupHeaderAsRow) { ?>
		<td data-field="Kelas"<?php echo $Page->Kelas->CellAttributes(); ?>>&nbsp;</td>
	<?php } else { ?>
		<td data-field="Kelas"<?php echo $Page->Kelas->CellAttributes(); ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->GrpCounter[0] ?>_r01_sudahbayar_Kelas"<?php echo $Page->Kelas->ViewAttributes() ?>><?php echo $Page->Kelas->GroupViewValue ?></span></td>
	<?php } ?>
<?php } ?>
<?php if ($Page->NIS->Visible) { ?>
	<?php if ($Page->NIS->ShowGroupHeaderAsRow) { ?>
		<td data-field="NIS"<?php echo $Page->NIS->CellAttributes(); ?>>&nbsp;</td>
	<?php } else { ?>
		<td data-field="NIS"<?php echo $Page->NIS->CellAttributes(); ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->GrpCounter[0] ?>_<?php echo $Page->GrpCounter[1] ?>_r01_sudahbayar_NIS"<?php echo $Page->NIS->ViewAttributes() ?>><?php echo $Page->NIS->GroupViewValue ?></span></td>
	<?php } ?>
<?php } ?>
<?php if ($Page->Nama->Visible) { ?>
	<?php if ($Page->Nama->ShowGroupHeaderAsRow) { ?>
		<td data-field="Nama"<?php echo $Page->Nama->CellAttributes(); ?>>&nbsp;</td>
	<?php } else { ?>
		<td data-field="Nama"<?php echo $Page->Nama->CellAttributes(); ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->GrpCounter[0] ?>_<?php echo $Page->GrpCounter[1] ?>_<?php echo $Page->GrpCounter[2] ?>_r01_sudahbayar_Nama"<?php echo $Page->Nama->ViewAttributes() ?>><?php echo $Page->Nama->GroupViewValue ?></span></td>
	<?php } ?>
<?php } ?>
<?php if ($Page->Jenis->Visible) { ?>
	<?php if ($Page->Jenis->ShowGroupHeaderAsRow) { ?>
		<td data-field="Jenis"<?php echo $Page->Jenis->CellAttributes(); ?>>&nbsp;</td>
	<?php } else { ?>
		<td data-field="Jenis"<?php echo $Page->Jenis->CellAttributes(); ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->GrpCounter[0] ?>_<?php echo $Page->GrpCounter[1] ?>_<?php echo $Page->GrpCounter[2] ?>_<?php echo $Page->GrpCounter[3] ?>_r01_sudahbayar_Jenis"<?php echo $Page->Jenis->ViewAttributes() ?>><?php echo $Page->Jenis->GroupViewValue ?></span></td>
	<?php } ?>
<?php } ?>
<?php if ($Page->Periode_Tahun_Bulan->Visible) { ?>
		<td data-field="Periode_Tahun_Bulan"<?php echo $Page->Periode_Tahun_Bulan->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->GrpCounter[0] ?>_<?php echo $Page->GrpCounter[1] ?>_<?php echo $Page->GrpCounter[2] ?>_<?php echo $Page->GrpCounter[3] ?>_<?php echo $Page->RecCount ?>_r01_sudahbayar_Periode_Tahun_Bulan"<?php echo $Page->Periode_Tahun_Bulan->ViewAttributes() ?>><?php echo $Page->Periode_Tahun_Bulan->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->Periode_Text->Visible) { ?>
		<td data-field="Periode_Text"<?php echo $Page->Periode_Text->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->GrpCounter[0] ?>_<?php echo $Page->GrpCounter[1] ?>_<?php echo $Page->GrpCounter[2] ?>_<?php echo $Page->GrpCounter[3] ?>_<?php echo $Page->RecCount ?>_r01_sudahbayar_Periode_Text"<?php echo $Page->Periode_Text->ViewAttributes() ?>><?php echo $Page->Periode_Text->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->Nilai->Visible) { ?>
		<td data-field="Nilai"<?php echo $Page->Nilai->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->GrpCounter[0] ?>_<?php echo $Page->GrpCounter[1] ?>_<?php echo $Page->GrpCounter[2] ?>_<?php echo $Page->GrpCounter[3] ?>_<?php echo $Page->RecCount ?>_r01_sudahbayar_Nilai"<?php echo $Page->Nilai->ViewAttributes() ?>><?php echo $Page->Nilai->ListViewValue() ?></span></td>
<?php } ?>
	</tr>
<?php

		// Accumulate page summary
		$Page->AccumulateSummary();

		// Get next record
		$Page->GetRow(2);

		// Show Footers
?>
<?php
		if ($Page->ChkLvlBreak(3) && $Page->NIS->Visible) {
?>
<?php
			$Page->Sekolah->Count = $Page->GetSummaryCount(1, FALSE);
			$Page->Kelas->Count = $Page->GetSummaryCount(2, FALSE);
			$Page->NIS->Count = $Page->GetSummaryCount(3, FALSE);
			$Page->Nama->Count = $Page->GetSummaryCount(4, FALSE);
			$Page->Jenis->Count = $Page->GetSummaryCount(5, FALSE);
			$Page->Nilai->Count = $Page->Cnt[3][3];
			$Page->Nilai->SumValue = $Page->Smry[3][3]; // Load SUM
			$Page->ResetAttrs();
			$Page->RowType = EWR_ROWTYPE_TOTAL;
			$Page->RowTotalType = EWR_ROWTOTAL_GROUP;
			$Page->RowTotalSubType = EWR_ROWTOTAL_FOOTER;
			$Page->RowGroupLevel = 3;
			$Page->RenderRow();
?>
<?php if ($Page->NIS->ShowCompactSummaryFooter) { ?>
	<tr<?php echo $Page->RowAttributes(); ?>>
<?php if ($Page->Sekolah->Visible) { ?>
		<td data-field="Sekolah"<?php echo $Page->Sekolah->CellAttributes() ?>>
	<?php if ($Page->Sekolah->ShowGroupHeaderAsRow) { ?>
		&nbsp;
	<?php } elseif ($Page->RowGroupLevel <> 1) { ?>
		&nbsp;
	<?php } else { ?>
		<span class="ewSummaryCount"><span class="ewAggregateCaption"><?php echo $ReportLanguage->Phrase("RptCnt") ?></span><?php echo $ReportLanguage->Phrase("AggregateEqual") ?><span class="ewAggregateValue"><?php echo ewr_FormatNumber($Page->Sekolah->Count,0,-2,-2,-2) ?></span></span>
	<?php } ?>
		</td>
<?php } ?>
<?php if ($Page->Kelas->Visible) { ?>
		<td data-field="Kelas"<?php echo $Page->Kelas->CellAttributes() ?>>
	<?php if ($Page->Kelas->ShowGroupHeaderAsRow) { ?>
		&nbsp;
	<?php } elseif ($Page->RowGroupLevel <> 2) { ?>
		&nbsp;
	<?php } else { ?>
		<span class="ewSummaryCount"><span class="ewAggregateCaption"><?php echo $ReportLanguage->Phrase("RptCnt") ?></span><?php echo $ReportLanguage->Phrase("AggregateEqual") ?><span class="ewAggregateValue"><?php echo ewr_FormatNumber($Page->Kelas->Count,0,-2,-2,-2) ?></span></span>
	<?php } ?>
		</td>
<?php } ?>
<?php if ($Page->NIS->Visible) { ?>
		<td data-field="NIS"<?php echo $Page->NIS->CellAttributes() ?>>
	<?php if ($Page->NIS->ShowGroupHeaderAsRow) { ?>
		&nbsp;
	<?php } elseif ($Page->RowGroupLevel <> 3) { ?>
		&nbsp;
	<?php } else { ?>
		<span class="ewSummaryCount"><span class="ewAggregateCaption"><?php echo $ReportLanguage->Phrase("RptCnt") ?></span><?php echo $ReportLanguage->Phrase("AggregateEqual") ?><span class="ewAggregateValue"><?php echo ewr_FormatNumber($Page->NIS->Count,0,-2,-2,-2) ?></span></span>
	<?php } ?>
		</td>
<?php } ?>
<?php if ($Page->Nama->Visible) { ?>
		<td data-field="Nama"<?php echo $Page->NIS->CellAttributes() ?>>
	<?php if ($Page->Nama->ShowGroupHeaderAsRow) { ?>
		&nbsp;
	<?php } elseif ($Page->RowGroupLevel <> 4) { ?>
		&nbsp;
	<?php } else { ?>
		<span class="ewSummaryCount"><span class="ewAggregateCaption"><?php echo $ReportLanguage->Phrase("RptCnt") ?></span><?php echo $ReportLanguage->Phrase("AggregateEqual") ?><span class="ewAggregateValue"><?php echo ewr_FormatNumber($Page->Nama->Count,0,-2,-2,-2) ?></span></span>
	<?php } ?>
		</td>
<?php } ?>
<?php if ($Page->Jenis->Visible) { ?>
		<td data-field="Jenis"<?php echo $Page->NIS->CellAttributes() ?>>
	<?php if ($Page->Jenis->ShowGroupHeaderAsRow) { ?>
		&nbsp;
	<?php } elseif ($Page->RowGroupLevel <> 5) { ?>
		&nbsp;
	<?php } else { ?>
		<span class="ewSummaryCount"><span class="ewAggregateCaption"><?php echo $ReportLanguage->Phrase("RptCnt") ?></span><?php echo $ReportLanguage->Phrase("AggregateEqual") ?><span class="ewAggregateValue"><?php echo ewr_FormatNumber($Page->Jenis->Count,0,-2,-2,-2) ?></span></span>
	<?php } ?>
		</td>
<?php } ?>
<?php if ($Page->Periode_Tahun_Bulan->Visible) { ?>
		<td data-field="Periode_Tahun_Bulan"<?php echo $Page->NIS->CellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->Periode_Text->Visible) { ?>
		<td data-field="Periode_Text"<?php echo $Page->NIS->CellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->Nilai->Visible) { ?>
		<td data-field="Nilai"<?php echo $Page->NIS->CellAttributes() ?>><span class="ewAggregateCaption"><?php echo $ReportLanguage->Phrase("RptSum") ?></span><?php echo $ReportLanguage->Phrase("AggregateEqual") ?><span class="ewAggregateValue"><span data-class="tpgs<?php echo $Page->GrpCount ?>_<?php echo $Page->GrpCounter[0] ?>_<?php echo $Page->GrpCounter[1] ?>_r01_sudahbayar_Nilai"<?php echo $Page->Nilai->ViewAttributes() ?>><?php echo $Page->Nilai->SumViewValue ?></span></span></td>
<?php } ?>
	</tr>
<?php } else { ?>
	<tr<?php echo $Page->RowAttributes(); ?>>
<?php if ($Page->Sekolah->Visible) { ?>
		<td data-field="Sekolah"<?php echo $Page->Sekolah->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->Kelas->Visible) { ?>
		<td data-field="Kelas"<?php echo $Page->Kelas->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->SubGrpColumnCount + $Page->DtlColumnCount - 1 > 0) { ?>
		<td colspan="<?php echo ($Page->SubGrpColumnCount + $Page->DtlColumnCount - 1) ?>"<?php echo $Page->Nilai->CellAttributes() ?>><?php echo str_replace(array("%v", "%c"), array($Page->NIS->GroupViewValue, $Page->NIS->FldCaption()), $ReportLanguage->Phrase("RptSumHead")) ?> <span class="ewDirLtr">(<?php echo ewr_FormatNumber($Page->Cnt[3][0],0,-2,-2,-2) ?><?php echo $ReportLanguage->Phrase("RptDtlRec") ?>)</span></td>
<?php } ?>
	</tr>
	<tr<?php echo $Page->RowAttributes(); ?>>
<?php if ($Page->Sekolah->Visible) { ?>
		<td data-field="Sekolah"<?php echo $Page->Sekolah->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->Kelas->Visible) { ?>
		<td data-field="Kelas"<?php echo $Page->Kelas->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->GrpColumnCount > 0) { ?>
		<td colspan="<?php echo ($Page->GrpColumnCount - 2) ?>"<?php echo $Page->NIS->CellAttributes() ?>><?php echo $ReportLanguage->Phrase("RptSum") ?></td>
<?php } ?>
<?php if ($Page->Periode_Tahun_Bulan->Visible) { ?>
		<td data-field="Periode_Tahun_Bulan"<?php echo $Page->NIS->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->Periode_Text->Visible) { ?>
		<td data-field="Periode_Text"<?php echo $Page->NIS->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->Nilai->Visible) { ?>
		<td data-field="Nilai"<?php echo $Page->Nilai->CellAttributes() ?>>
<span data-class="tpgs<?php echo $Page->GrpCount ?>_<?php echo $Page->GrpCounter[0] ?>_<?php echo $Page->GrpCounter[1] ?>_r01_sudahbayar_Nilai"<?php echo $Page->Nilai->ViewAttributes() ?>><?php echo $Page->Nilai->SumViewValue ?></span></td>
<?php } ?>
	</tr>
<?php } ?>
<?php

			// Reset level 3 summary
			$Page->ResetLevelSummary(3);
		} // End show footer check
		if ($Page->ChkLvlBreak(3)) {
			$Page->GrpCounter[1]++;
			if (!$rs->EOF)
				$Page->GrpIdx[$Page->GrpCount][$Page->GrpCounter[1]] = array(-1);
			$Page->GrpCounter[2] = 1;
			if (!$rs->EOF)
				$Page->GrpIdx[$Page->GrpCount][$Page->GrpCounter[1]][$Page->GrpCounter[2]] = array(-1);
			$Page->GrpCounter[3] = 1;
		}
?>
<?php
	} // End detail records loop
?>
<?php

	// Next group
	$Page->GetGrpRow(2);

	// Show header if page break
	if ($Page->Export <> "")
		$Page->ShowHeader = ($Page->ExportPageBreakCount == 0) ? FALSE : ($Page->GrpCount % $Page->ExportPageBreakCount == 0);

	// Page_Breaking server event
	if ($Page->ShowHeader)
		$Page->Page_Breaking($Page->ShowHeader, $Page->PageBreakContent);
	$Page->GrpCount++;
	$Page->GrpCounter[3] = 1;
	$Page->GrpCounter[2] = 1;
	$Page->GrpCounter[1] = 1;
	$Page->GrpCounter[0] = 1;

	// Handle EOF
	if (!$rsgrp || $rsgrp->EOF)
		$Page->ShowHeader = FALSE;
} // End while
?>
<?php if ($Page->TotalGrps > 0) { ?>
</tbody>
<tfoot>
<?php
	$Page->Nilai->Count = $Page->GrandCnt[3];
	$Page->Nilai->SumValue = $Page->GrandSmry[3]; // Load SUM
	$Page->ResetAttrs();
	$Page->RowType = EWR_ROWTYPE_TOTAL;
	$Page->RowTotalType = EWR_ROWTOTAL_GRAND;
	$Page->RowTotalSubType = EWR_ROWTOTAL_FOOTER;
	$Page->RowAttrs["class"] = "ewRptGrandSummary";
	$Page->RenderRow();
?>
<?php if ($Page->NIS->ShowCompactSummaryFooter) { ?>
	<tr<?php echo $Page->RowAttributes() ?>><td colspan="<?php echo ($Page->GrpColumnCount + $Page->DtlColumnCount) ?>"><?php echo $ReportLanguage->Phrase("RptGrandSummary") ?> (<span class="ewAggregateCaption"><?php echo $ReportLanguage->Phrase("RptCnt") ?></span><?php echo $ReportLanguage->Phrase("AggregateEqual") ?><span class="ewAggregateValue"><?php echo ewr_FormatNumber($Page->TotCount,0,-2,-2,-2) ?></span>)</td></tr>
	<tr<?php echo $Page->RowAttributes() ?>>
<?php if ($Page->GrpColumnCount > 0) { ?>
		<td colspan="<?php echo $Page->GrpColumnCount ?>" class="ewRptGrpAggregate">&nbsp;</td>
<?php } ?>
<?php if ($Page->Periode_Tahun_Bulan->Visible) { ?>
		<td data-field="Periode_Tahun_Bulan"<?php echo $Page->Periode_Tahun_Bulan->CellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->Periode_Text->Visible) { ?>
		<td data-field="Periode_Text"<?php echo $Page->Periode_Text->CellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->Nilai->Visible) { ?>
		<td data-field="Nilai"<?php echo $Page->Nilai->CellAttributes() ?>><?php echo $ReportLanguage->Phrase("RptSum") ?>=<span data-class="tpts_r01_sudahbayar_Nilai"<?php echo $Page->Nilai->ViewAttributes() ?>><?php echo $Page->Nilai->SumViewValue ?></span></td>
<?php } ?>
	</tr>
<?php } else { ?>
	<tr<?php echo $Page->RowAttributes() ?>><td colspan="<?php echo ($Page->GrpColumnCount + $Page->DtlColumnCount) ?>"><?php echo $ReportLanguage->Phrase("RptGrandSummary") ?> <span class="ewDirLtr">(<?php echo ewr_FormatNumber($Page->TotCount,0,-2,-2,-2); ?><?php echo $ReportLanguage->Phrase("RptDtlRec") ?>)</span></td></tr>
	<tr<?php echo $Page->RowAttributes() ?>>
<?php if ($Page->GrpColumnCount > 0) { ?>
		<td colspan="<?php echo $Page->GrpColumnCount ?>" class="ewRptGrpAggregate"><?php echo $ReportLanguage->Phrase("RptSum") ?></td>
<?php } ?>
<?php if ($Page->Periode_Tahun_Bulan->Visible) { ?>
		<td data-field="Periode_Tahun_Bulan"<?php echo $Page->Periode_Tahun_Bulan->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->Periode_Text->Visible) { ?>
		<td data-field="Periode_Text"<?php echo $Page->Periode_Text->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->Nilai->Visible) { ?>
		<td data-field="Nilai"<?php echo $Page->Nilai->CellAttributes() ?>>
<span data-class="tpts_r01_sudahbayar_Nilai"<?php echo $Page->Nilai->ViewAttributes() ?>><?php echo $Page->Nilai->SumViewValue ?></span></td>
<?php } ?>
	</tr>
<?php } ?>
	</tfoot>
<?php } elseif (!$Page->ShowHeader && FALSE) { // No header displayed ?>
<?php if ($Page->Export <> "pdf") { ?>
<?php if ($Page->Export == "word" || $Page->Export == "excel") { ?>
<div class="ewGrid"<?php echo $Page->ReportTableStyle ?>>
<?php } else { ?>
<div class="panel panel-default ewGrid"<?php echo $Page->ReportTableStyle ?>>
<?php } ?>
<?php } ?>
<!-- Report grid (begin) -->
<?php if ($Page->Export <> "pdf") { ?>
<div class="<?php if (ewr_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php } ?>
<table class="<?php echo $Page->ReportTableClass ?>">
<?php } ?>
<?php if ($Page->TotalGrps > 0 || FALSE) { // Show footer ?>
</table>
<?php if ($Page->Export <> "pdf") { ?>
</div>
<?php } ?>
<?php if ($Page->Export == "" && !($Page->DrillDown && $Page->TotalGrps > 0)) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php include "r01_sudahbayarsmrypager.php" ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if ($Page->Export <> "pdf") { ?>
</div>
<?php } ?>
<?php } ?>
<?php if ($Page->Export <> "pdf") { ?>
</div>
<?php } ?>
<!-- Summary Report Ends -->
<?php if ($Page->Export == "") { ?>
	</div>
	<!-- center container - report (end) -->
	<!-- right container (begin) -->
	<div id="ewRight" class="ewRight">
<?php } ?>
	<!-- Right slot -->
<?php if ($Page->Export == "") { ?>
	</div>
	<!-- right container (end) -->
<div class="clearfix"></div>
<!-- bottom container (begin) -->
<div id="ewBottom" class="ewBottom">
<?php } ?>
	<!-- Bottom slot -->
<?php if ($Page->Export == "") { ?>
	</div>
<!-- Bottom Container (End) -->
</div>
<!-- Table Container (End) -->
<?php } ?>
<?php $Page->ShowPageFooter(); ?>
<?php if (EWR_DEBUG_ENABLED) echo ewr_DebugMsg(); ?>
<?php

// Close recordsets
if ($rsgrp) $rsgrp->Close();
if ($rs) $rs->Close();
?>
<?php if ($Page->Export == "" && !$Page->DrillDown) { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "phprptinc/footer.php" ?>
<?php include_once "footer.php" ?>
<?php
$Page->Page_Terminate();
if (isset($OldPage)) $Page = $OldPage;
?>
