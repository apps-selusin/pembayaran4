<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start();
?>
<?php include_once "phprptinc/ewrcfg10.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "phprptinc/ewmysql.php") ?>
<?php include_once "phprptinc/ewrfn10.php" ?>
<?php include_once "phprptinc/ewrusrfn10.php" ?>
<?php include_once "v04_uang_masukrptinfo.php" ?>
<?php

//
// Page class
//

$v04_uang_masuk_rpt = NULL; // Initialize page object first

class crv04_uang_masuk_rpt extends crv04_uang_masuk {

	// Page ID
	var $PageID = 'rpt';

	// Project ID
	var $ProjectID = "{0BB1DC5C-09DE-419A-9701-F3161918C007}";

	// Page object name
	var $PageObjName = 'v04_uang_masuk_rpt';

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

		// Table object (v04_uang_masuk)
		if (!isset($GLOBALS["v04_uang_masuk"])) {
			$GLOBALS["v04_uang_masuk"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["v04_uang_masuk"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";

		// Page ID
		if (!defined("EWR_PAGE_ID"))
			define("EWR_PAGE_ID", 'rpt', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EWR_TABLE_NAME"))
			define("EWR_TABLE_NAME", 'v04_uang_masuk', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fv04_uang_masukrpt";

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
		$item->Body = "<a title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToEmail", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToEmail", TRUE)) . "\" id=\"emf_v04_uang_masuk\" href=\"javascript:void(0);\" onclick=\"ewr_EmailDialogShow({lnk:'emf_v04_uang_masuk',hdr:ewLanguage.Phrase('ExportToEmail'),url:'$url',exportid:'$exportid',el:this});\">" . $ReportLanguage->Phrase("ExportToEmail") . "</a>";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fv04_uang_masukrpt\" href=\"#\">" . $ReportLanguage->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fv04_uang_masukrpt\" href=\"#\">" . $ReportLanguage->Phrase("DeleteFilter") . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $ReportLanguage->Phrase("SearchBtn", TRUE) . "\" data-caption=\"" . $ReportLanguage->Phrase("SearchBtn", TRUE) . "\" data-toggle=\"button\" data-form=\"fv04_uang_masukrpt\">" . $ReportLanguage->Phrase("SearchBtn") . "</button>";
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
		$this->NIS->SetVisibility();
		$this->Nama->SetVisibility();
		$this->Jenis->SetVisibility();
		$this->Nilai->SetVisibility();
		$this->Kelas->SetVisibility();
		$this->Sekolah->SetVisibility();
		$this->Periode_Tahun_Bulan->SetVisibility();
		$this->Periode_Text->SetVisibility();
		$this->Bayar->SetVisibility();
		$this->Per_Thn_Bln_Byr->SetVisibility();
		$this->Per_Thn_Bln_Byr_Text->SetVisibility();

		// Aggregate variables
		// 1st dimension = no of groups (level 0 used for grand total)
		// 2nd dimension = no of fields

		$nDtls = 12;
		$nGrps = 1;
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
		$this->Col = array(array(FALSE, FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE));

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

		// Get total count
		$sSql = ewr_BuildReportSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(), $this->Filter, $this->Sort);
		$this->TotalGrps = $this->GetCnt($sSql);
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

		// Get current page records
		$rs = $this->GetRs($sSql, $this->StartGrp, $this->DisplayGrps);
		$this->SetupFieldCount();
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

	// Get count
	function GetCnt($sql) {
		$conn = &$this->Connection();
		$rscnt = $conn->Execute($sql);
		$cnt = ($rscnt) ? $rscnt->RecordCount() : 0;
		if ($rscnt) $rscnt->Close();
		return $cnt;
	}

	// Get recordset
	function GetRs($wrksql, $start, $grps) {
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EWR_ERROR_FN"];
		$rswrk = $conn->SelectLimit($wrksql, $grps, $start - 1);
		$conn->raiseErrorFn = '';
		return $rswrk;
	}

	// Get row values
	function GetRow($opt) {
		global $rs;
		if (!$rs)
			return;
		if ($opt == 1) { // Get first row
				$this->FirstRowData = array();
				$this->FirstRowData['siswanonrutin_id'] = ewr_Conv($rs->fields('siswanonrutin_id'), 3);
				$this->FirstRowData['siswa_id'] = ewr_Conv($rs->fields('siswa_id'), 3);
				$this->FirstRowData['nonrutin_id'] = ewr_Conv($rs->fields('nonrutin_id'), 3);
				$this->FirstRowData['sekolah_id'] = ewr_Conv($rs->fields('sekolah_id'), 3);
				$this->FirstRowData['kelas_id'] = ewr_Conv($rs->fields('kelas_id'), 3);
				$this->FirstRowData['NIS'] = ewr_Conv($rs->fields('NIS'), 200);
				$this->FirstRowData['Nama'] = ewr_Conv($rs->fields('Nama'), 200);
				$this->FirstRowData['Jenis'] = ewr_Conv($rs->fields('Jenis'), 200);
				$this->FirstRowData['Nilai'] = ewr_Conv($rs->fields('Nilai'), 4);
				$this->FirstRowData['Kelas'] = ewr_Conv($rs->fields('Kelas'), 200);
				$this->FirstRowData['Sekolah'] = ewr_Conv($rs->fields('Sekolah'), 200);
				$this->FirstRowData['Periode_Tahun_Bulan'] = ewr_Conv($rs->fields('Periode_Tahun_Bulan'), 200);
				$this->FirstRowData['Periode_Text'] = ewr_Conv($rs->fields('Periode_Text'), 200);
				$this->FirstRowData['Bayar'] = ewr_Conv($rs->fields('Bayar'), 4);
				$this->FirstRowData['Per_Thn_Bln_Byr'] = ewr_Conv($rs->fields('Per_Thn_Bln_Byr'), 200);
				$this->FirstRowData['Per_Thn_Bln_Byr_Text'] = ewr_Conv($rs->fields('Per_Thn_Bln_Byr_Text'), 200);
		} else { // Get next row
			$rs->MoveNext();
		}
		if (!$rs->EOF) {
			$this->siswanonrutin_id->setDbValue($rs->fields('siswanonrutin_id'));
			$this->siswa_id->setDbValue($rs->fields('siswa_id'));
			$this->nonrutin_id->setDbValue($rs->fields('nonrutin_id'));
			$this->sekolah_id->setDbValue($rs->fields('sekolah_id'));
			$this->kelas_id->setDbValue($rs->fields('kelas_id'));
			$this->NIS->setDbValue($rs->fields('NIS'));
			$this->Nama->setDbValue($rs->fields('Nama'));
			$this->Jenis->setDbValue($rs->fields('Jenis'));
			$this->Nilai->setDbValue($rs->fields('Nilai'));
			$this->Kelas->setDbValue($rs->fields('Kelas'));
			$this->Sekolah->setDbValue($rs->fields('Sekolah'));
			$this->Periode_Tahun_Bulan->setDbValue($rs->fields('Periode_Tahun_Bulan'));
			$this->Periode_Text->setDbValue($rs->fields('Periode_Text'));
			$this->Bayar->setDbValue($rs->fields('Bayar'));
			$this->Per_Thn_Bln_Byr->setDbValue($rs->fields('Per_Thn_Bln_Byr'));
			$this->Per_Thn_Bln_Byr_Text->setDbValue($rs->fields('Per_Thn_Bln_Byr_Text'));
			$this->Val[1] = $this->NIS->CurrentValue;
			$this->Val[2] = $this->Nama->CurrentValue;
			$this->Val[3] = $this->Jenis->CurrentValue;
			$this->Val[4] = $this->Nilai->CurrentValue;
			$this->Val[5] = $this->Kelas->CurrentValue;
			$this->Val[6] = $this->Sekolah->CurrentValue;
			$this->Val[7] = $this->Periode_Tahun_Bulan->CurrentValue;
			$this->Val[8] = $this->Periode_Text->CurrentValue;
			$this->Val[9] = $this->Bayar->CurrentValue;
			$this->Val[10] = $this->Per_Thn_Bln_Byr->CurrentValue;
			$this->Val[11] = $this->Per_Thn_Bln_Byr_Text->CurrentValue;
		} else {
			$this->siswanonrutin_id->setDbValue("");
			$this->siswa_id->setDbValue("");
			$this->nonrutin_id->setDbValue("");
			$this->sekolah_id->setDbValue("");
			$this->kelas_id->setDbValue("");
			$this->NIS->setDbValue("");
			$this->Nama->setDbValue("");
			$this->Jenis->setDbValue("");
			$this->Nilai->setDbValue("");
			$this->Kelas->setDbValue("");
			$this->Sekolah->setDbValue("");
			$this->Periode_Tahun_Bulan->setDbValue("");
			$this->Periode_Text->setDbValue("");
			$this->Bayar->setDbValue("");
			$this->Per_Thn_Bln_Byr->setDbValue("");
			$this->Per_Thn_Bln_Byr_Text->setDbValue("");
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
		$bGotSummary = TRUE;

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

			// NIS
			$this->NIS->HrefValue = "";

			// Nama
			$this->Nama->HrefValue = "";

			// Jenis
			$this->Jenis->HrefValue = "";

			// Nilai
			$this->Nilai->HrefValue = "";

			// Kelas
			$this->Kelas->HrefValue = "";

			// Sekolah
			$this->Sekolah->HrefValue = "";

			// Periode_Tahun_Bulan
			$this->Periode_Tahun_Bulan->HrefValue = "";

			// Periode_Text
			$this->Periode_Text->HrefValue = "";

			// Bayar
			$this->Bayar->HrefValue = "";

			// Per_Thn_Bln_Byr
			$this->Per_Thn_Bln_Byr->HrefValue = "";

			// Per_Thn_Bln_Byr_Text
			$this->Per_Thn_Bln_Byr_Text->HrefValue = "";
		} else {
			if ($this->RowTotalType == EWR_ROWTOTAL_GROUP && $this->RowTotalSubType == EWR_ROWTOTAL_HEADER) {
			} else {
			}

			// NIS
			$this->NIS->ViewValue = $this->NIS->CurrentValue;
			$this->NIS->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Nama
			$this->Nama->ViewValue = $this->Nama->CurrentValue;
			$this->Nama->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Jenis
			$this->Jenis->ViewValue = $this->Jenis->CurrentValue;
			$this->Jenis->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Nilai
			$this->Nilai->ViewValue = $this->Nilai->CurrentValue;
			$this->Nilai->ViewValue = ewr_FormatNumber($this->Nilai->ViewValue, $this->Nilai->DefaultDecimalPrecision, -1, 0, 0);
			$this->Nilai->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Kelas
			$this->Kelas->ViewValue = $this->Kelas->CurrentValue;
			$this->Kelas->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Sekolah
			$this->Sekolah->ViewValue = $this->Sekolah->CurrentValue;
			$this->Sekolah->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Periode_Tahun_Bulan
			$this->Periode_Tahun_Bulan->ViewValue = $this->Periode_Tahun_Bulan->CurrentValue;
			$this->Periode_Tahun_Bulan->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Periode_Text
			$this->Periode_Text->ViewValue = $this->Periode_Text->CurrentValue;
			$this->Periode_Text->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Bayar
			$this->Bayar->ViewValue = $this->Bayar->CurrentValue;
			$this->Bayar->ViewValue = ewr_FormatNumber($this->Bayar->ViewValue, $this->Bayar->DefaultDecimalPrecision, -1, 0, 0);
			$this->Bayar->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Per_Thn_Bln_Byr
			$this->Per_Thn_Bln_Byr->ViewValue = $this->Per_Thn_Bln_Byr->CurrentValue;
			$this->Per_Thn_Bln_Byr->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Per_Thn_Bln_Byr_Text
			$this->Per_Thn_Bln_Byr_Text->ViewValue = $this->Per_Thn_Bln_Byr_Text->CurrentValue;
			$this->Per_Thn_Bln_Byr_Text->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// NIS
			$this->NIS->HrefValue = "";

			// Nama
			$this->Nama->HrefValue = "";

			// Jenis
			$this->Jenis->HrefValue = "";

			// Nilai
			$this->Nilai->HrefValue = "";

			// Kelas
			$this->Kelas->HrefValue = "";

			// Sekolah
			$this->Sekolah->HrefValue = "";

			// Periode_Tahun_Bulan
			$this->Periode_Tahun_Bulan->HrefValue = "";

			// Periode_Text
			$this->Periode_Text->HrefValue = "";

			// Bayar
			$this->Bayar->HrefValue = "";

			// Per_Thn_Bln_Byr
			$this->Per_Thn_Bln_Byr->HrefValue = "";

			// Per_Thn_Bln_Byr_Text
			$this->Per_Thn_Bln_Byr_Text->HrefValue = "";
		}

		// Call Cell_Rendered event
		if ($this->RowType == EWR_ROWTYPE_TOTAL) { // Summary row
		} else {

			// NIS
			$CurrentValue = $this->NIS->CurrentValue;
			$ViewValue = &$this->NIS->ViewValue;
			$ViewAttrs = &$this->NIS->ViewAttrs;
			$CellAttrs = &$this->NIS->CellAttrs;
			$HrefValue = &$this->NIS->HrefValue;
			$LinkAttrs = &$this->NIS->LinkAttrs;
			$this->Cell_Rendered($this->NIS, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// Nama
			$CurrentValue = $this->Nama->CurrentValue;
			$ViewValue = &$this->Nama->ViewValue;
			$ViewAttrs = &$this->Nama->ViewAttrs;
			$CellAttrs = &$this->Nama->CellAttrs;
			$HrefValue = &$this->Nama->HrefValue;
			$LinkAttrs = &$this->Nama->LinkAttrs;
			$this->Cell_Rendered($this->Nama, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// Jenis
			$CurrentValue = $this->Jenis->CurrentValue;
			$ViewValue = &$this->Jenis->ViewValue;
			$ViewAttrs = &$this->Jenis->ViewAttrs;
			$CellAttrs = &$this->Jenis->CellAttrs;
			$HrefValue = &$this->Jenis->HrefValue;
			$LinkAttrs = &$this->Jenis->LinkAttrs;
			$this->Cell_Rendered($this->Jenis, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// Nilai
			$CurrentValue = $this->Nilai->CurrentValue;
			$ViewValue = &$this->Nilai->ViewValue;
			$ViewAttrs = &$this->Nilai->ViewAttrs;
			$CellAttrs = &$this->Nilai->CellAttrs;
			$HrefValue = &$this->Nilai->HrefValue;
			$LinkAttrs = &$this->Nilai->LinkAttrs;
			$this->Cell_Rendered($this->Nilai, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// Kelas
			$CurrentValue = $this->Kelas->CurrentValue;
			$ViewValue = &$this->Kelas->ViewValue;
			$ViewAttrs = &$this->Kelas->ViewAttrs;
			$CellAttrs = &$this->Kelas->CellAttrs;
			$HrefValue = &$this->Kelas->HrefValue;
			$LinkAttrs = &$this->Kelas->LinkAttrs;
			$this->Cell_Rendered($this->Kelas, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// Sekolah
			$CurrentValue = $this->Sekolah->CurrentValue;
			$ViewValue = &$this->Sekolah->ViewValue;
			$ViewAttrs = &$this->Sekolah->ViewAttrs;
			$CellAttrs = &$this->Sekolah->CellAttrs;
			$HrefValue = &$this->Sekolah->HrefValue;
			$LinkAttrs = &$this->Sekolah->LinkAttrs;
			$this->Cell_Rendered($this->Sekolah, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

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

			// Bayar
			$CurrentValue = $this->Bayar->CurrentValue;
			$ViewValue = &$this->Bayar->ViewValue;
			$ViewAttrs = &$this->Bayar->ViewAttrs;
			$CellAttrs = &$this->Bayar->CellAttrs;
			$HrefValue = &$this->Bayar->HrefValue;
			$LinkAttrs = &$this->Bayar->LinkAttrs;
			$this->Cell_Rendered($this->Bayar, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// Per_Thn_Bln_Byr
			$CurrentValue = $this->Per_Thn_Bln_Byr->CurrentValue;
			$ViewValue = &$this->Per_Thn_Bln_Byr->ViewValue;
			$ViewAttrs = &$this->Per_Thn_Bln_Byr->ViewAttrs;
			$CellAttrs = &$this->Per_Thn_Bln_Byr->CellAttrs;
			$HrefValue = &$this->Per_Thn_Bln_Byr->HrefValue;
			$LinkAttrs = &$this->Per_Thn_Bln_Byr->LinkAttrs;
			$this->Cell_Rendered($this->Per_Thn_Bln_Byr, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// Per_Thn_Bln_Byr_Text
			$CurrentValue = $this->Per_Thn_Bln_Byr_Text->CurrentValue;
			$ViewValue = &$this->Per_Thn_Bln_Byr_Text->ViewValue;
			$ViewAttrs = &$this->Per_Thn_Bln_Byr_Text->ViewAttrs;
			$CellAttrs = &$this->Per_Thn_Bln_Byr_Text->CellAttrs;
			$HrefValue = &$this->Per_Thn_Bln_Byr_Text->HrefValue;
			$LinkAttrs = &$this->Per_Thn_Bln_Byr_Text->LinkAttrs;
			$this->Cell_Rendered($this->Per_Thn_Bln_Byr_Text, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);
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
		if ($this->NIS->Visible) $this->DtlColumnCount += 1;
		if ($this->Nama->Visible) $this->DtlColumnCount += 1;
		if ($this->Jenis->Visible) $this->DtlColumnCount += 1;
		if ($this->Nilai->Visible) $this->DtlColumnCount += 1;
		if ($this->Kelas->Visible) $this->DtlColumnCount += 1;
		if ($this->Sekolah->Visible) $this->DtlColumnCount += 1;
		if ($this->Periode_Tahun_Bulan->Visible) $this->DtlColumnCount += 1;
		if ($this->Periode_Text->Visible) $this->DtlColumnCount += 1;
		if ($this->Bayar->Visible) $this->DtlColumnCount += 1;
		if ($this->Per_Thn_Bln_Byr->Visible) $this->DtlColumnCount += 1;
		if ($this->Per_Thn_Bln_Byr_Text->Visible) $this->DtlColumnCount += 1;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $ReportBreadcrumb;
		$ReportBreadcrumb = new crBreadcrumb();
		$url = substr(ewr_CurrentUrl(), strrpos(ewr_CurrentUrl(), "/")+1);
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$ReportBreadcrumb->Add("rpt", $this->TableVar, $url, "", $this->TableVar, TRUE);
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
			$this->SetSessionDropDownValue($this->Jenis->DropDownValue, $this->Jenis->SearchOperator, 'Jenis'); // Field Jenis
			$this->SetSessionDropDownValue($this->Kelas->DropDownValue, $this->Kelas->SearchOperator, 'Kelas'); // Field Kelas
			$this->SetSessionDropDownValue($this->Sekolah->DropDownValue, $this->Sekolah->SearchOperator, 'Sekolah'); // Field Sekolah
			$this->SetSessionDropDownValue($this->Per_Thn_Bln_Byr_Text->DropDownValue, $this->Per_Thn_Bln_Byr_Text->SearchOperator, 'Per_Thn_Bln_Byr_Text'); // Field Per_Thn_Bln_Byr_Text

			//$bSetupFilter = TRUE; // No need to set up, just use default
		} else {
			$bRestoreSession = !$this->SearchCommand;

			// Field NIS
			if ($this->GetDropDownValue($this->NIS)) {
				$bSetupFilter = TRUE;
			} elseif ($this->NIS->DropDownValue <> EWR_INIT_VALUE && !isset($_SESSION['sv_v04_uang_masuk_NIS'])) {
				$bSetupFilter = TRUE;
			}

			// Field Nama
			if ($this->GetDropDownValue($this->Nama)) {
				$bSetupFilter = TRUE;
			} elseif ($this->Nama->DropDownValue <> EWR_INIT_VALUE && !isset($_SESSION['sv_v04_uang_masuk_Nama'])) {
				$bSetupFilter = TRUE;
			}

			// Field Jenis
			if ($this->GetDropDownValue($this->Jenis)) {
				$bSetupFilter = TRUE;
			} elseif ($this->Jenis->DropDownValue <> EWR_INIT_VALUE && !isset($_SESSION['sv_v04_uang_masuk_Jenis'])) {
				$bSetupFilter = TRUE;
			}

			// Field Kelas
			if ($this->GetDropDownValue($this->Kelas)) {
				$bSetupFilter = TRUE;
			} elseif ($this->Kelas->DropDownValue <> EWR_INIT_VALUE && !isset($_SESSION['sv_v04_uang_masuk_Kelas'])) {
				$bSetupFilter = TRUE;
			}

			// Field Sekolah
			if ($this->GetDropDownValue($this->Sekolah)) {
				$bSetupFilter = TRUE;
			} elseif ($this->Sekolah->DropDownValue <> EWR_INIT_VALUE && !isset($_SESSION['sv_v04_uang_masuk_Sekolah'])) {
				$bSetupFilter = TRUE;
			}

			// Field Per_Thn_Bln_Byr_Text
			if ($this->GetDropDownValue($this->Per_Thn_Bln_Byr_Text)) {
				$bSetupFilter = TRUE;
			} elseif ($this->Per_Thn_Bln_Byr_Text->DropDownValue <> EWR_INIT_VALUE && !isset($_SESSION['sv_v04_uang_masuk_Per_Thn_Bln_Byr_Text'])) {
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
			$this->GetSessionDropDownValue($this->Jenis); // Field Jenis
			$this->GetSessionDropDownValue($this->Kelas); // Field Kelas
			$this->GetSessionDropDownValue($this->Sekolah); // Field Sekolah
			$this->GetSessionDropDownValue($this->Per_Thn_Bln_Byr_Text); // Field Per_Thn_Bln_Byr_Text
		}

		// Call page filter validated event
		$this->Page_FilterValidated();

		// Build SQL
		$this->BuildDropDownFilter($this->NIS, $sFilter, $this->NIS->SearchOperator, FALSE, TRUE); // Field NIS
		$this->BuildDropDownFilter($this->Nama, $sFilter, $this->Nama->SearchOperator, FALSE, TRUE); // Field Nama
		$this->BuildDropDownFilter($this->Jenis, $sFilter, $this->Jenis->SearchOperator, FALSE, TRUE); // Field Jenis
		$this->BuildDropDownFilter($this->Kelas, $sFilter, $this->Kelas->SearchOperator, FALSE, TRUE); // Field Kelas
		$this->BuildDropDownFilter($this->Sekolah, $sFilter, $this->Sekolah->SearchOperator, FALSE, TRUE); // Field Sekolah
		$this->BuildDropDownFilter($this->Per_Thn_Bln_Byr_Text, $sFilter, $this->Per_Thn_Bln_Byr_Text->SearchOperator, FALSE, TRUE); // Field Per_Thn_Bln_Byr_Text

		// Save parms to session
		$this->SetSessionDropDownValue($this->NIS->DropDownValue, $this->NIS->SearchOperator, 'NIS'); // Field NIS
		$this->SetSessionDropDownValue($this->Nama->DropDownValue, $this->Nama->SearchOperator, 'Nama'); // Field Nama
		$this->SetSessionDropDownValue($this->Jenis->DropDownValue, $this->Jenis->SearchOperator, 'Jenis'); // Field Jenis
		$this->SetSessionDropDownValue($this->Kelas->DropDownValue, $this->Kelas->SearchOperator, 'Kelas'); // Field Kelas
		$this->SetSessionDropDownValue($this->Sekolah->DropDownValue, $this->Sekolah->SearchOperator, 'Sekolah'); // Field Sekolah
		$this->SetSessionDropDownValue($this->Per_Thn_Bln_Byr_Text->DropDownValue, $this->Per_Thn_Bln_Byr_Text->SearchOperator, 'Per_Thn_Bln_Byr_Text'); // Field Per_Thn_Bln_Byr_Text

		// Setup filter
		if ($bSetupFilter) {
		}

		// Field NIS
		ewr_LoadDropDownList($this->NIS->DropDownList, $this->NIS->DropDownValue);

		// Field Nama
		ewr_LoadDropDownList($this->Nama->DropDownList, $this->Nama->DropDownValue);

		// Field Jenis
		ewr_LoadDropDownList($this->Jenis->DropDownList, $this->Jenis->DropDownValue);

		// Field Kelas
		ewr_LoadDropDownList($this->Kelas->DropDownList, $this->Kelas->DropDownValue);

		// Field Sekolah
		ewr_LoadDropDownList($this->Sekolah->DropDownList, $this->Sekolah->DropDownValue);

		// Field Per_Thn_Bln_Byr_Text
		ewr_LoadDropDownList($this->Per_Thn_Bln_Byr_Text->DropDownList, $this->Per_Thn_Bln_Byr_Text->DropDownValue);
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
		$this->GetSessionValue($fld->DropDownValue, 'sv_v04_uang_masuk_' . $parm);
		$this->GetSessionValue($fld->SearchOperator, 'so_v04_uang_masuk_' . $parm);
	}

	// Get filter values from session
	function GetSessionFilterValues(&$fld) {
		$parm = substr($fld->FldVar, 2);
		$this->GetSessionValue($fld->SearchValue, 'sv_v04_uang_masuk_' . $parm);
		$this->GetSessionValue($fld->SearchOperator, 'so_v04_uang_masuk_' . $parm);
		$this->GetSessionValue($fld->SearchCondition, 'sc_v04_uang_masuk_' . $parm);
		$this->GetSessionValue($fld->SearchValue2, 'sv2_v04_uang_masuk_' . $parm);
		$this->GetSessionValue($fld->SearchOperator2, 'so2_v04_uang_masuk_' . $parm);
	}

	// Get value from session
	function GetSessionValue(&$sv, $sn) {
		if (array_key_exists($sn, $_SESSION))
			$sv = $_SESSION[$sn];
	}

	// Set dropdown value to session
	function SetSessionDropDownValue($sv, $so, $parm) {
		$_SESSION['sv_v04_uang_masuk_' . $parm] = $sv;
		$_SESSION['so_v04_uang_masuk_' . $parm] = $so;
	}

	// Set filter values to session
	function SetSessionFilterValues($sv1, $so1, $sc, $sv2, $so2, $parm) {
		$_SESSION['sv_v04_uang_masuk_' . $parm] = $sv1;
		$_SESSION['so_v04_uang_masuk_' . $parm] = $so1;
		$_SESSION['sc_v04_uang_masuk_' . $parm] = $sc;
		$_SESSION['sv2_v04_uang_masuk_' . $parm] = $sv2;
		$_SESSION['so2_v04_uang_masuk_' . $parm] = $so2;
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
		$_SESSION["sel_v04_uang_masuk_$parm"] = "";
		$_SESSION["rf_v04_uang_masuk_$parm"] = "";
		$_SESSION["rt_v04_uang_masuk_$parm"] = "";
	}

	// Load selection from session
	function LoadSelectionFromSession($parm) {
		$fld = &$this->FieldByParm($parm);
		$fld->SelectionList = @$_SESSION["sel_v04_uang_masuk_$parm"];
		$fld->RangeFrom = @$_SESSION["rf_v04_uang_masuk_$parm"];
		$fld->RangeTo = @$_SESSION["rt_v04_uang_masuk_$parm"];
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

		// Field Jenis
		$this->Jenis->DefaultDropDownValue = EWR_INIT_VALUE;
		if (!$this->SearchCommand) $this->Jenis->DropDownValue = $this->Jenis->DefaultDropDownValue;

		// Field Kelas
		$this->Kelas->DefaultDropDownValue = EWR_INIT_VALUE;
		if (!$this->SearchCommand) $this->Kelas->DropDownValue = $this->Kelas->DefaultDropDownValue;

		// Field Sekolah
		$this->Sekolah->DefaultDropDownValue = EWR_INIT_VALUE;
		if (!$this->SearchCommand) $this->Sekolah->DropDownValue = $this->Sekolah->DefaultDropDownValue;

		// Field Per_Thn_Bln_Byr_Text
		$this->Per_Thn_Bln_Byr_Text->DefaultDropDownValue = EWR_INIT_VALUE;
		if (!$this->SearchCommand) $this->Per_Thn_Bln_Byr_Text->DropDownValue = $this->Per_Thn_Bln_Byr_Text->DefaultDropDownValue;
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

		// Check Jenis extended filter
		if ($this->NonTextFilterApplied($this->Jenis))
			return TRUE;

		// Check Kelas extended filter
		if ($this->NonTextFilterApplied($this->Kelas))
			return TRUE;

		// Check Sekolah extended filter
		if ($this->NonTextFilterApplied($this->Sekolah))
			return TRUE;

		// Check Per_Thn_Bln_Byr_Text extended filter
		if ($this->NonTextFilterApplied($this->Per_Thn_Bln_Byr_Text))
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

		// Field Jenis
		$sExtWrk = "";
		$sWrk = "";
		$this->BuildDropDownFilter($this->Jenis, $sExtWrk, $this->Jenis->SearchOperator);
		$sFilter = "";
		if ($sExtWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sExtWrk</span>";
		elseif ($sWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sWrk</span>";
		if ($sFilter <> "")
			$sFilterList .= "<div><span class=\"ewFilterCaption\">" . $this->Jenis->FldCaption() . "</span>" . $sFilter . "</div>";

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

		// Field Per_Thn_Bln_Byr_Text
		$sExtWrk = "";
		$sWrk = "";
		$this->BuildDropDownFilter($this->Per_Thn_Bln_Byr_Text, $sExtWrk, $this->Per_Thn_Bln_Byr_Text->SearchOperator);
		$sFilter = "";
		if ($sExtWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sExtWrk</span>";
		elseif ($sWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sWrk</span>";
		if ($sFilter <> "")
			$sFilterList .= "<div><span class=\"ewFilterCaption\">" . $this->Per_Thn_Bln_Byr_Text->FldCaption() . "</span>" . $sFilter . "</div>";
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

		// Field Jenis
		$sWrk = "";
		$sWrk = ($this->Jenis->DropDownValue <> EWR_INIT_VALUE) ? $this->Jenis->DropDownValue : "";
		if (is_array($sWrk))
			$sWrk = implode("||", $sWrk);
		if ($sWrk <> "")
			$sWrk = "\"sv_Jenis\":\"" . ewr_JsEncode2($sWrk) . "\"";
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

		// Field Per_Thn_Bln_Byr_Text
		$sWrk = "";
		$sWrk = ($this->Per_Thn_Bln_Byr_Text->DropDownValue <> EWR_INIT_VALUE) ? $this->Per_Thn_Bln_Byr_Text->DropDownValue : "";
		if (is_array($sWrk))
			$sWrk = implode("||", $sWrk);
		if ($sWrk <> "")
			$sWrk = "\"sv_Per_Thn_Bln_Byr_Text\":\"" . ewr_JsEncode2($sWrk) . "\"";
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

		// Field Jenis
		$bRestoreFilter = FALSE;
		if (array_key_exists("sv_Jenis", $filter)) {
			$sWrk = $filter["sv_Jenis"];
			if (strpos($sWrk, "||") !== FALSE)
				$sWrk = explode("||", $sWrk);
			$this->SetSessionDropDownValue($sWrk, @$filter["so_Jenis"], "Jenis");
			$bRestoreFilter = TRUE;
		}
		if (!$bRestoreFilter) { // Clear filter
			$this->SetSessionDropDownValue(EWR_INIT_VALUE, "", "Jenis");
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

		// Field Per_Thn_Bln_Byr_Text
		$bRestoreFilter = FALSE;
		if (array_key_exists("sv_Per_Thn_Bln_Byr_Text", $filter)) {
			$sWrk = $filter["sv_Per_Thn_Bln_Byr_Text"];
			if (strpos($sWrk, "||") !== FALSE)
				$sWrk = explode("||", $sWrk);
			$this->SetSessionDropDownValue($sWrk, @$filter["so_Per_Thn_Bln_Byr_Text"], "Per_Thn_Bln_Byr_Text");
			$bRestoreFilter = TRUE;
		}
		if (!$bRestoreFilter) { // Clear filter
			$this->SetSessionDropDownValue(EWR_INIT_VALUE, "", "Per_Thn_Bln_Byr_Text");
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
			return "";
		$bResetSort = @$options["resetsort"] == "1" || @$_GET["cmd"] == "resetsort";
		$orderBy = (@$options["order"] <> "") ? @$options["order"] : ewr_StripSlashes(@$_GET["order"]);
		$orderType = (@$options["ordertype"] <> "") ? @$options["ordertype"] : ewr_StripSlashes(@$_GET["ordertype"]);

		// Check for Ctrl pressed
		$bCtrl = (@$_GET["ctrl"] <> "");

		// Check for a resetsort command
		if ($bResetSort) {
			$this->setOrderBy("");
			$this->setStartGroup(1);
			$this->NIS->setSort("");
			$this->Nama->setSort("");
			$this->Jenis->setSort("");
			$this->Nilai->setSort("");
			$this->Kelas->setSort("");
			$this->Sekolah->setSort("");
			$this->Periode_Tahun_Bulan->setSort("");
			$this->Periode_Text->setSort("");
			$this->Bayar->setSort("");
			$this->Per_Thn_Bln_Byr->setSort("");
			$this->Per_Thn_Bln_Byr_Text->setSort("");

		// Check for an Order parameter
		} elseif ($orderBy <> "") {
			$this->CurrentOrder = $orderBy;
			$this->CurrentOrderType = $orderType;
			$this->UpdateSort($this->NIS, $bCtrl); // NIS
			$this->UpdateSort($this->Nama, $bCtrl); // Nama
			$this->UpdateSort($this->Jenis, $bCtrl); // Jenis
			$this->UpdateSort($this->Nilai, $bCtrl); // Nilai
			$this->UpdateSort($this->Kelas, $bCtrl); // Kelas
			$this->UpdateSort($this->Sekolah, $bCtrl); // Sekolah
			$this->UpdateSort($this->Periode_Tahun_Bulan, $bCtrl); // Periode_Tahun_Bulan
			$this->UpdateSort($this->Periode_Text, $bCtrl); // Periode_Text
			$this->UpdateSort($this->Bayar, $bCtrl); // Bayar
			$this->UpdateSort($this->Per_Thn_Bln_Byr, $bCtrl); // Per_Thn_Bln_Byr
			$this->UpdateSort($this->Per_Thn_Bln_Byr_Text, $bCtrl); // Per_Thn_Bln_Byr_Text
			$sSortSql = $this->SortSql();
			$this->setOrderBy($sSortSql);
			$this->setStartGroup(1);
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
if (!isset($v04_uang_masuk_rpt)) $v04_uang_masuk_rpt = new crv04_uang_masuk_rpt();
if (isset($Page)) $OldPage = $Page;
$Page = &$v04_uang_masuk_rpt;

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
var v04_uang_masuk_rpt = new ewr_Page("v04_uang_masuk_rpt");

// Page properties
v04_uang_masuk_rpt.PageID = "rpt"; // Page ID
var EWR_PAGE_ID = v04_uang_masuk_rpt.PageID;

// Extend page with Chart_Rendering function
v04_uang_masuk_rpt.Chart_Rendering = 
 function(chart, chartid) { // DO NOT CHANGE THIS LINE!

 	//alert(chartid);
 }

// Extend page with Chart_Rendered function
v04_uang_masuk_rpt.Chart_Rendered = 
 function(chart, chartid) { // DO NOT CHANGE THIS LINE!

 	//alert(chartid);
 }
</script>
<?php } ?>
<?php if ($Page->Export == "" && !$Page->DrillDown) { ?>
<script type="text/javascript">

// Form object
var CurrentForm = fv04_uang_masukrpt = new ewr_Form("fv04_uang_masukrpt");

// Validate method
fv04_uang_masukrpt.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);

	// Call Form Custom Validate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}

// Form_CustomValidate method
fv04_uang_masukrpt.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }
<?php if (EWR_CLIENT_VALIDATE) { ?>
fv04_uang_masukrpt.ValidateRequired = true; // Uses JavaScript validation
<?php } else { ?>
fv04_uang_masukrpt.ValidateRequired = false; // No JavaScript validation
<?php } ?>

// Use Ajax
fv04_uang_masukrpt.Lists["sv_NIS"] = {"LinkField":"sv_NIS","Ajax":true,"DisplayFields":["sv_NIS","","",""],"ParentFields":[],"FilterFields":[],"Options":[],"Template":""};
fv04_uang_masukrpt.Lists["sv_Nama"] = {"LinkField":"sv_Nama","Ajax":true,"DisplayFields":["sv_Nama","","",""],"ParentFields":[],"FilterFields":[],"Options":[],"Template":""};
fv04_uang_masukrpt.Lists["sv_Jenis"] = {"LinkField":"sv_Jenis","Ajax":true,"DisplayFields":["sv_Jenis","","",""],"ParentFields":[],"FilterFields":[],"Options":[],"Template":""};
fv04_uang_masukrpt.Lists["sv_Kelas"] = {"LinkField":"sv_Kelas","Ajax":true,"DisplayFields":["sv_Kelas","","",""],"ParentFields":[],"FilterFields":[],"Options":[],"Template":""};
fv04_uang_masukrpt.Lists["sv_Sekolah"] = {"LinkField":"sv_Sekolah","Ajax":true,"DisplayFields":["sv_Sekolah","","",""],"ParentFields":[],"FilterFields":[],"Options":[],"Template":""};
fv04_uang_masukrpt.Lists["sv_Per_Thn_Bln_Byr_Text"] = {"LinkField":"sv_Per_Thn_Bln_Byr_Text","Ajax":true,"DisplayFields":["sv_Per_Thn_Bln_Byr_Text","","",""],"ParentFields":[],"FilterFields":[],"Options":[],"Template":""};
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
<form name="fv04_uang_masukrpt" id="fv04_uang_masukrpt" class="form-inline ewForm ewExtFilterForm" action="<?php echo ewr_CurrentPage() ?>">
<?php $SearchPanelClass = ($Page->Filter <> "") ? " in" : " in"; ?>
<div id="fv04_uang_masukrpt_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<div id="r_1" class="ewRow">
<div id="c_NIS" class="ewCell form-group">
	<label for="sv_NIS" class="ewSearchCaption ewLabel"><?php echo $Page->NIS->FldCaption() ?></label>
	<span class="ewSearchField">
<?php ewr_PrependClass($Page->NIS->EditAttrs["class"], "form-control"); ?>
<select data-table="v04_uang_masuk" data-field="x_NIS" data-value-separator="<?php echo ewr_HtmlEncode(is_array($Page->NIS->DisplayValueSeparator) ? json_encode($Page->NIS->DisplayValueSeparator) : $Page->NIS->DisplayValueSeparator) ?>" id="sv_NIS" name="sv_NIS"<?php echo $Page->NIS->EditAttributes() ?>>
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
<select data-table="v04_uang_masuk" data-field="x_Nama" data-value-separator="<?php echo ewr_HtmlEncode(is_array($Page->Nama->DisplayValueSeparator) ? json_encode($Page->Nama->DisplayValueSeparator) : $Page->Nama->DisplayValueSeparator) ?>" id="sv_Nama" name="sv_Nama"<?php echo $Page->Nama->EditAttributes() ?>>
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
<div id="c_Jenis" class="ewCell form-group">
	<label for="sv_Jenis" class="ewSearchCaption ewLabel"><?php echo $Page->Jenis->FldCaption() ?></label>
	<span class="ewSearchField">
<?php ewr_PrependClass($Page->Jenis->EditAttrs["class"], "form-control"); ?>
<select data-table="v04_uang_masuk" data-field="x_Jenis" data-value-separator="<?php echo ewr_HtmlEncode(is_array($Page->Jenis->DisplayValueSeparator) ? json_encode($Page->Jenis->DisplayValueSeparator) : $Page->Jenis->DisplayValueSeparator) ?>" id="sv_Jenis" name="sv_Jenis"<?php echo $Page->Jenis->EditAttributes() ?>>
<option value=""><?php echo $ReportLanguage->Phrase("PleaseSelect") ?></option>
<?php
	$cntf = is_array($Page->Jenis->AdvancedFilters) ? count($Page->Jenis->AdvancedFilters) : 0;
	$cntd = is_array($Page->Jenis->DropDownList) ? count($Page->Jenis->DropDownList) : 0;
	$totcnt = $cntf + $cntd;
	$wrkcnt = 0;
	if ($cntf > 0) {
		foreach ($Page->Jenis->AdvancedFilters as $filter) {
			if ($filter->Enabled) {
				$selwrk = ewr_MatchedFilterValue($Page->Jenis->DropDownValue, $filter->ID) ? " selected" : "";
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
<option value="<?php echo $Page->Jenis->DropDownList[$i] ?>"<?php echo $selwrk ?>><?php echo ewr_DropDownDisplayValue($Page->Jenis->DropDownList[$i], "", 0) ?></option>
<?php
		$wrkcnt += 1;
	}
?>
</select>
<input type="hidden" name="s_sv_Jenis" id="s_sv_Jenis" value="<?php echo $Page->Jenis->LookupFilterQuery() ?>"></span>
</div>
</div>
<div id="r_4" class="ewRow">
<div id="c_Kelas" class="ewCell form-group">
	<label for="sv_Kelas" class="ewSearchCaption ewLabel"><?php echo $Page->Kelas->FldCaption() ?></label>
	<span class="ewSearchField">
<?php ewr_PrependClass($Page->Kelas->EditAttrs["class"], "form-control"); ?>
<select data-table="v04_uang_masuk" data-field="x_Kelas" data-value-separator="<?php echo ewr_HtmlEncode(is_array($Page->Kelas->DisplayValueSeparator) ? json_encode($Page->Kelas->DisplayValueSeparator) : $Page->Kelas->DisplayValueSeparator) ?>" id="sv_Kelas" name="sv_Kelas"<?php echo $Page->Kelas->EditAttributes() ?>>
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
<div id="r_5" class="ewRow">
<div id="c_Sekolah" class="ewCell form-group">
	<label for="sv_Sekolah" class="ewSearchCaption ewLabel"><?php echo $Page->Sekolah->FldCaption() ?></label>
	<span class="ewSearchField">
<?php ewr_PrependClass($Page->Sekolah->EditAttrs["class"], "form-control"); ?>
<select data-table="v04_uang_masuk" data-field="x_Sekolah" data-value-separator="<?php echo ewr_HtmlEncode(is_array($Page->Sekolah->DisplayValueSeparator) ? json_encode($Page->Sekolah->DisplayValueSeparator) : $Page->Sekolah->DisplayValueSeparator) ?>" id="sv_Sekolah" name="sv_Sekolah"<?php echo $Page->Sekolah->EditAttributes() ?>>
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
<div id="r_6" class="ewRow">
<div id="c_Per_Thn_Bln_Byr_Text" class="ewCell form-group">
	<label for="sv_Per_Thn_Bln_Byr_Text" class="ewSearchCaption ewLabel"><?php echo $Page->Per_Thn_Bln_Byr_Text->FldCaption() ?></label>
	<span class="ewSearchField">
<?php ewr_PrependClass($Page->Per_Thn_Bln_Byr_Text->EditAttrs["class"], "form-control"); ?>
<select data-table="v04_uang_masuk" data-field="x_Per_Thn_Bln_Byr_Text" data-value-separator="<?php echo ewr_HtmlEncode(is_array($Page->Per_Thn_Bln_Byr_Text->DisplayValueSeparator) ? json_encode($Page->Per_Thn_Bln_Byr_Text->DisplayValueSeparator) : $Page->Per_Thn_Bln_Byr_Text->DisplayValueSeparator) ?>" id="sv_Per_Thn_Bln_Byr_Text" name="sv_Per_Thn_Bln_Byr_Text"<?php echo $Page->Per_Thn_Bln_Byr_Text->EditAttributes() ?>>
<option value=""><?php echo $ReportLanguage->Phrase("PleaseSelect") ?></option>
<?php
	$cntf = is_array($Page->Per_Thn_Bln_Byr_Text->AdvancedFilters) ? count($Page->Per_Thn_Bln_Byr_Text->AdvancedFilters) : 0;
	$cntd = is_array($Page->Per_Thn_Bln_Byr_Text->DropDownList) ? count($Page->Per_Thn_Bln_Byr_Text->DropDownList) : 0;
	$totcnt = $cntf + $cntd;
	$wrkcnt = 0;
	if ($cntf > 0) {
		foreach ($Page->Per_Thn_Bln_Byr_Text->AdvancedFilters as $filter) {
			if ($filter->Enabled) {
				$selwrk = ewr_MatchedFilterValue($Page->Per_Thn_Bln_Byr_Text->DropDownValue, $filter->ID) ? " selected" : "";
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
<option value="<?php echo $Page->Per_Thn_Bln_Byr_Text->DropDownList[$i] ?>"<?php echo $selwrk ?>><?php echo ewr_DropDownDisplayValue($Page->Per_Thn_Bln_Byr_Text->DropDownList[$i], "", 0) ?></option>
<?php
		$wrkcnt += 1;
	}
?>
</select>
<input type="hidden" name="s_sv_Per_Thn_Bln_Byr_Text" id="s_sv_Per_Thn_Bln_Byr_Text" value="<?php echo $Page->Per_Thn_Bln_Byr_Text->LookupFilterQuery() ?>"></span>
</div>
</div>
<div class="ewRow"><input type="submit" name="btnsubmit" id="btnsubmit" class="btn btn-primary" value="<?php echo $ReportLanguage->Phrase("Search") ?>">
<input type="reset" name="btnreset" id="btnreset" class="btn hide" value="<?php echo $ReportLanguage->Phrase("Reset") ?>"></div>
</div>
</form>
<script type="text/javascript">
fv04_uang_masukrpt.Init();
fv04_uang_masukrpt.FilterList = <?php echo $Page->GetFilterList() ?>;
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
	$Page->GetRow(1);
	$Page->GrpCount = 1;
}
$Page->GrpIdx = ewr_InitArray(2, -1);
$Page->GrpIdx[0] = -1;
$Page->GrpIdx[1] = $Page->StopGrp - $Page->StartGrp + 1;
while ($rs && !$rs->EOF && $Page->GrpCount <= $Page->DisplayGrps || $Page->ShowHeader) {

	// Show dummy header for custom template
	// Show header

	if ($Page->ShowHeader) {
?>
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
<?php if ($Page->NIS->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="NIS"><div class="v04_uang_masuk_NIS"><span class="ewTableHeaderCaption"><?php echo $Page->NIS->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="NIS">
<?php if ($Page->SortUrl($Page->NIS) == "") { ?>
		<div class="ewTableHeaderBtn v04_uang_masuk_NIS">
			<span class="ewTableHeaderCaption"><?php echo $Page->NIS->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer v04_uang_masuk_NIS" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->NIS) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->NIS->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->NIS->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->NIS->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->Nama->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="Nama"><div class="v04_uang_masuk_Nama"><span class="ewTableHeaderCaption"><?php echo $Page->Nama->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="Nama">
<?php if ($Page->SortUrl($Page->Nama) == "") { ?>
		<div class="ewTableHeaderBtn v04_uang_masuk_Nama">
			<span class="ewTableHeaderCaption"><?php echo $Page->Nama->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer v04_uang_masuk_Nama" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->Nama) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->Nama->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->Nama->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->Nama->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->Jenis->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="Jenis"><div class="v04_uang_masuk_Jenis"><span class="ewTableHeaderCaption"><?php echo $Page->Jenis->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="Jenis">
<?php if ($Page->SortUrl($Page->Jenis) == "") { ?>
		<div class="ewTableHeaderBtn v04_uang_masuk_Jenis">
			<span class="ewTableHeaderCaption"><?php echo $Page->Jenis->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer v04_uang_masuk_Jenis" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->Jenis) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->Jenis->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->Jenis->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->Jenis->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->Nilai->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="Nilai"><div class="v04_uang_masuk_Nilai"><span class="ewTableHeaderCaption"><?php echo $Page->Nilai->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="Nilai">
<?php if ($Page->SortUrl($Page->Nilai) == "") { ?>
		<div class="ewTableHeaderBtn v04_uang_masuk_Nilai">
			<span class="ewTableHeaderCaption"><?php echo $Page->Nilai->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer v04_uang_masuk_Nilai" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->Nilai) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->Nilai->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->Nilai->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->Nilai->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->Kelas->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="Kelas"><div class="v04_uang_masuk_Kelas"><span class="ewTableHeaderCaption"><?php echo $Page->Kelas->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="Kelas">
<?php if ($Page->SortUrl($Page->Kelas) == "") { ?>
		<div class="ewTableHeaderBtn v04_uang_masuk_Kelas">
			<span class="ewTableHeaderCaption"><?php echo $Page->Kelas->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer v04_uang_masuk_Kelas" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->Kelas) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->Kelas->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->Kelas->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->Kelas->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->Sekolah->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="Sekolah"><div class="v04_uang_masuk_Sekolah"><span class="ewTableHeaderCaption"><?php echo $Page->Sekolah->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="Sekolah">
<?php if ($Page->SortUrl($Page->Sekolah) == "") { ?>
		<div class="ewTableHeaderBtn v04_uang_masuk_Sekolah">
			<span class="ewTableHeaderCaption"><?php echo $Page->Sekolah->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer v04_uang_masuk_Sekolah" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->Sekolah) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->Sekolah->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->Sekolah->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->Sekolah->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->Periode_Tahun_Bulan->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="Periode_Tahun_Bulan"><div class="v04_uang_masuk_Periode_Tahun_Bulan"><span class="ewTableHeaderCaption"><?php echo $Page->Periode_Tahun_Bulan->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="Periode_Tahun_Bulan">
<?php if ($Page->SortUrl($Page->Periode_Tahun_Bulan) == "") { ?>
		<div class="ewTableHeaderBtn v04_uang_masuk_Periode_Tahun_Bulan">
			<span class="ewTableHeaderCaption"><?php echo $Page->Periode_Tahun_Bulan->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer v04_uang_masuk_Periode_Tahun_Bulan" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->Periode_Tahun_Bulan) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->Periode_Tahun_Bulan->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->Periode_Tahun_Bulan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->Periode_Tahun_Bulan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->Periode_Text->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="Periode_Text"><div class="v04_uang_masuk_Periode_Text"><span class="ewTableHeaderCaption"><?php echo $Page->Periode_Text->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="Periode_Text">
<?php if ($Page->SortUrl($Page->Periode_Text) == "") { ?>
		<div class="ewTableHeaderBtn v04_uang_masuk_Periode_Text">
			<span class="ewTableHeaderCaption"><?php echo $Page->Periode_Text->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer v04_uang_masuk_Periode_Text" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->Periode_Text) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->Periode_Text->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->Periode_Text->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->Periode_Text->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->Bayar->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="Bayar"><div class="v04_uang_masuk_Bayar"><span class="ewTableHeaderCaption"><?php echo $Page->Bayar->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="Bayar">
<?php if ($Page->SortUrl($Page->Bayar) == "") { ?>
		<div class="ewTableHeaderBtn v04_uang_masuk_Bayar">
			<span class="ewTableHeaderCaption"><?php echo $Page->Bayar->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer v04_uang_masuk_Bayar" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->Bayar) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->Bayar->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->Bayar->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->Bayar->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->Per_Thn_Bln_Byr->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="Per_Thn_Bln_Byr"><div class="v04_uang_masuk_Per_Thn_Bln_Byr"><span class="ewTableHeaderCaption"><?php echo $Page->Per_Thn_Bln_Byr->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="Per_Thn_Bln_Byr">
<?php if ($Page->SortUrl($Page->Per_Thn_Bln_Byr) == "") { ?>
		<div class="ewTableHeaderBtn v04_uang_masuk_Per_Thn_Bln_Byr">
			<span class="ewTableHeaderCaption"><?php echo $Page->Per_Thn_Bln_Byr->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer v04_uang_masuk_Per_Thn_Bln_Byr" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->Per_Thn_Bln_Byr) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->Per_Thn_Bln_Byr->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->Per_Thn_Bln_Byr->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->Per_Thn_Bln_Byr->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->Per_Thn_Bln_Byr_Text->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="Per_Thn_Bln_Byr_Text"><div class="v04_uang_masuk_Per_Thn_Bln_Byr_Text"><span class="ewTableHeaderCaption"><?php echo $Page->Per_Thn_Bln_Byr_Text->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="Per_Thn_Bln_Byr_Text">
<?php if ($Page->SortUrl($Page->Per_Thn_Bln_Byr_Text) == "") { ?>
		<div class="ewTableHeaderBtn v04_uang_masuk_Per_Thn_Bln_Byr_Text">
			<span class="ewTableHeaderCaption"><?php echo $Page->Per_Thn_Bln_Byr_Text->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer v04_uang_masuk_Per_Thn_Bln_Byr_Text" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->Per_Thn_Bln_Byr_Text) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->Per_Thn_Bln_Byr_Text->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->Per_Thn_Bln_Byr_Text->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->Per_Thn_Bln_Byr_Text->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
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
	$Page->RecCount++;
	$Page->RecIndex++;
?>
<?php

		// Render detail row
		$Page->ResetAttrs();
		$Page->RowType = EWR_ROWTYPE_DETAIL;
		$Page->RenderRow();
?>
	<tr<?php echo $Page->RowAttributes(); ?>>
<?php if ($Page->NIS->Visible) { ?>
		<td data-field="NIS"<?php echo $Page->NIS->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_v04_uang_masuk_NIS"<?php echo $Page->NIS->ViewAttributes() ?>><?php echo $Page->NIS->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->Nama->Visible) { ?>
		<td data-field="Nama"<?php echo $Page->Nama->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_v04_uang_masuk_Nama"<?php echo $Page->Nama->ViewAttributes() ?>><?php echo $Page->Nama->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->Jenis->Visible) { ?>
		<td data-field="Jenis"<?php echo $Page->Jenis->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_v04_uang_masuk_Jenis"<?php echo $Page->Jenis->ViewAttributes() ?>><?php echo $Page->Jenis->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->Nilai->Visible) { ?>
		<td data-field="Nilai"<?php echo $Page->Nilai->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_v04_uang_masuk_Nilai"<?php echo $Page->Nilai->ViewAttributes() ?>><?php echo $Page->Nilai->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->Kelas->Visible) { ?>
		<td data-field="Kelas"<?php echo $Page->Kelas->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_v04_uang_masuk_Kelas"<?php echo $Page->Kelas->ViewAttributes() ?>><?php echo $Page->Kelas->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->Sekolah->Visible) { ?>
		<td data-field="Sekolah"<?php echo $Page->Sekolah->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_v04_uang_masuk_Sekolah"<?php echo $Page->Sekolah->ViewAttributes() ?>><?php echo $Page->Sekolah->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->Periode_Tahun_Bulan->Visible) { ?>
		<td data-field="Periode_Tahun_Bulan"<?php echo $Page->Periode_Tahun_Bulan->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_v04_uang_masuk_Periode_Tahun_Bulan"<?php echo $Page->Periode_Tahun_Bulan->ViewAttributes() ?>><?php echo $Page->Periode_Tahun_Bulan->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->Periode_Text->Visible) { ?>
		<td data-field="Periode_Text"<?php echo $Page->Periode_Text->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_v04_uang_masuk_Periode_Text"<?php echo $Page->Periode_Text->ViewAttributes() ?>><?php echo $Page->Periode_Text->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->Bayar->Visible) { ?>
		<td data-field="Bayar"<?php echo $Page->Bayar->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_v04_uang_masuk_Bayar"<?php echo $Page->Bayar->ViewAttributes() ?>><?php echo $Page->Bayar->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->Per_Thn_Bln_Byr->Visible) { ?>
		<td data-field="Per_Thn_Bln_Byr"<?php echo $Page->Per_Thn_Bln_Byr->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_v04_uang_masuk_Per_Thn_Bln_Byr"<?php echo $Page->Per_Thn_Bln_Byr->ViewAttributes() ?>><?php echo $Page->Per_Thn_Bln_Byr->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->Per_Thn_Bln_Byr_Text->Visible) { ?>
		<td data-field="Per_Thn_Bln_Byr_Text"<?php echo $Page->Per_Thn_Bln_Byr_Text->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_v04_uang_masuk_Per_Thn_Bln_Byr_Text"<?php echo $Page->Per_Thn_Bln_Byr_Text->ViewAttributes() ?>><?php echo $Page->Per_Thn_Bln_Byr_Text->ListViewValue() ?></span></td>
<?php } ?>
	</tr>
<?php

		// Accumulate page summary
		$Page->AccumulateSummary();

		// Get next record
		$Page->GetRow(2);
	$Page->GrpCount++;
} // End while
?>
<?php if ($Page->TotalGrps > 0) { ?>
</tbody>
<tfoot>
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
<?php include "v04_uang_masukrptpager.php" ?>
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
