<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "v04_uang_masukinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$v04_uang_masuk_list = NULL; // Initialize page object first

class cv04_uang_masuk_list extends cv04_uang_masuk {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{64CABE7A-1609-4157-8293-D7242B591905}";

	// Table name
	var $TableName = 'v04_uang_masuk';

	// Page object name
	var $PageObjName = 'v04_uang_masuk_list';

	// Grid form hidden field names
	var $FormName = 'fv04_uang_masuklist';
	var $FormActionName = 'k_action';
	var $FormKeyName = 'k_key';
	var $FormOldKeyName = 'k_oldkey';
	var $FormBlankRowName = 'k_blankrow';
	var $FormKeyCountName = 'key_count';

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

		// Table object (v04_uang_masuk)
		if (!isset($GLOBALS["v04_uang_masuk"]) || get_class($GLOBALS["v04_uang_masuk"]) == "cv04_uang_masuk") {
			$GLOBALS["v04_uang_masuk"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["v04_uang_masuk"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "v04_uang_masukadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "v04_uang_masukdelete.php";
		$this->MultiUpdateUrl = "v04_uang_masukupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'v04_uang_masuk', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "div";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";

		// Filter options
		$this->FilterOptions = new cListOptions();
		$this->FilterOptions->Tag = "div";
		$this->FilterOptions->TagClassName = "ewFilterOption fv04_uang_masuklistsrch";

		// List actions
		$this->ListActions = new cListActions();
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();
		$this->siswanonrutin_id->SetVisibility();
		$this->siswa_id->SetVisibility();
		$this->nonrutin_id->SetVisibility();
		$this->sekolah_id->SetVisibility();
		$this->kelas_id->SetVisibility();
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

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
		}

		// Create Token
		$this->CreateToken();

		// Setup other options
		$this->SetupOtherOptions();

		// Set up custom action (compatible with old version)
		foreach ($this->CustomActions as $name => $action)
			$this->ListActions->Add($name, $action);

		// Show checkbox column if multiple action
		foreach ($this->ListActions->Items as $listaction) {
			if ($listaction->Select == EW_ACTION_MULTIPLE && $listaction->Allow) {
				$this->ListOptions->Items["checkbox"]->Visible = TRUE;
				break;
			}
		}
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
		global $EW_EXPORT, $v04_uang_masuk;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($v04_uang_masuk);
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

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $SearchOptions; // Search options
	var $OtherOptions = array(); // Other options
	var $FilterOptions; // Filter options
	var $ListActions; // List actions
	var $SelectedCount = 0;
	var $SelectedIndex = 0;
	var $DisplayRecs = 20;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $DefaultSearchWhere = ""; // Default search WHERE clause
	var $SearchWhere = ""; // Search WHERE clause
	var $RecCnt = 0; // Record count
	var $EditRowCnt;
	var $StartRowCnt = 1;
	var $RowCnt = 0;
	var $Attrs = array(); // Row attributes and cell attributes
	var $RowIndex = 0; // Row index
	var $KeyCount = 0; // Key count
	var $RowAction = ""; // Row action
	var $RowOldKey = ""; // Row old key (for copy)
	var $RecPerRow = 0;
	var $MultiColumnClass;
	var $MultiColumnEditClass = "col-sm-12";
	var $MultiColumnCnt = 12;
	var $MultiColumnEditCnt = 12;
	var $GridCnt = 0;
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;	
	var $MultiSelectKey;
	var $Command;
	var $RestoreSearch = FALSE;
	var $DetailPages;
	var $Recordset;
	var $OldRecordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";

		// Get command
		$this->Command = strtolower(@$_GET["cmd"]);
		if ($this->IsPageRequest()) { // Validate request

			// Process list action first
			if ($this->ProcessListAction()) // Ajax request
				$this->Page_Terminate();

			// Handle reset command
			$this->ResetCmd();

			// Set up Breadcrumb
			if ($this->Export == "")
				$this->SetupBreadcrumb();

			// Hide list options
			if ($this->Export <> "") {
				$this->ListOptions->HideAllOptions(array("sequence"));
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			} elseif ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			}

			// Hide options
			if ($this->Export <> "" || $this->CurrentAction <> "") {
				$this->ExportOptions->HideAllOptions();
				$this->FilterOptions->HideAllOptions();
			}

			// Hide other options
			if ($this->Export <> "") {
				foreach ($this->OtherOptions as &$option)
					$option->HideAllOptions();
			}

			// Get default search criteria
			ew_AddFilter($this->DefaultSearchWhere, $this->BasicSearchWhere(TRUE));

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Process filter list
			$this->ProcessFilterList();

			// Restore search parms from Session if not searching / reset / export
			if (($this->Export <> "" || $this->Command <> "search" && $this->Command <> "reset" && $this->Command <> "resetall") && $this->CheckSearchParms())
				$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$this->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Restore display records
		if ($this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Load search default if no existing search criteria
		if (!$this->CheckSearchParms()) {

			// Load basic search from default
			$this->BasicSearch->LoadDefault();
			if ($this->BasicSearch->Keyword != "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$this->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->Command == "search" && !$this->RestoreSearch) {
			$this->setSearchWhere($this->SearchWhere); // Save to Session
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} else {
			$this->SearchWhere = $this->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Set up filter in session
		$this->setSessionWhere($sFilter);
		$this->CurrentFilter = "";

		// Load record count first
		if (!$this->IsAddOrEdit()) {
			$bSelectLimit = $this->UseSelectLimit;
			if ($bSelectLimit) {
				$this->TotalRecs = $this->SelectRecordCount();
			} else {
				if ($this->Recordset = $this->LoadRecordset())
					$this->TotalRecs = $this->Recordset->RecordCount();
			}
		}

		// Search options
		$this->SetupSearchOptions();
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $this->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // Next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		$arrKeyFlds = explode($GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"], $key);
		if (count($arrKeyFlds) >= 0) {
		}
		return TRUE;
	}

	// Get list of filters
	function GetFilterList() {
		global $UserProfile;

		// Load server side filters
		if (EW_SEARCH_FILTER_OPTION == "Server") {
			$sSavedFilterList = isset($UserProfile) ? $UserProfile->GetSearchFilters(CurrentUserName(), "fv04_uang_masuklistsrch") : "";
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->siswanonrutin_id->AdvancedSearch->ToJSON(), ","); // Field siswanonrutin_id
		$sFilterList = ew_Concat($sFilterList, $this->siswa_id->AdvancedSearch->ToJSON(), ","); // Field siswa_id
		$sFilterList = ew_Concat($sFilterList, $this->nonrutin_id->AdvancedSearch->ToJSON(), ","); // Field nonrutin_id
		$sFilterList = ew_Concat($sFilterList, $this->sekolah_id->AdvancedSearch->ToJSON(), ","); // Field sekolah_id
		$sFilterList = ew_Concat($sFilterList, $this->kelas_id->AdvancedSearch->ToJSON(), ","); // Field kelas_id
		$sFilterList = ew_Concat($sFilterList, $this->NIS->AdvancedSearch->ToJSON(), ","); // Field NIS
		$sFilterList = ew_Concat($sFilterList, $this->Nama->AdvancedSearch->ToJSON(), ","); // Field Nama
		$sFilterList = ew_Concat($sFilterList, $this->Jenis->AdvancedSearch->ToJSON(), ","); // Field Jenis
		$sFilterList = ew_Concat($sFilterList, $this->Nilai->AdvancedSearch->ToJSON(), ","); // Field Nilai
		$sFilterList = ew_Concat($sFilterList, $this->Kelas->AdvancedSearch->ToJSON(), ","); // Field Kelas
		$sFilterList = ew_Concat($sFilterList, $this->Sekolah->AdvancedSearch->ToJSON(), ","); // Field Sekolah
		$sFilterList = ew_Concat($sFilterList, $this->Periode_Tahun_Bulan->AdvancedSearch->ToJSON(), ","); // Field Periode_Tahun_Bulan
		$sFilterList = ew_Concat($sFilterList, $this->Periode_Text->AdvancedSearch->ToJSON(), ","); // Field Periode_Text
		$sFilterList = ew_Concat($sFilterList, $this->Bayar->AdvancedSearch->ToJSON(), ","); // Field Bayar
		$sFilterList = ew_Concat($sFilterList, $this->Per_Thn_Bln_Byr->AdvancedSearch->ToJSON(), ","); // Field Per_Thn_Bln_Byr
		$sFilterList = ew_Concat($sFilterList, $this->Per_Thn_Bln_Byr_Text->AdvancedSearch->ToJSON(), ","); // Field Per_Thn_Bln_Byr_Text
		if ($this->BasicSearch->Keyword <> "") {
			$sWrk = "\"" . EW_TABLE_BASIC_SEARCH . "\":\"" . ew_JsEncode2($this->BasicSearch->Keyword) . "\",\"" . EW_TABLE_BASIC_SEARCH_TYPE . "\":\"" . ew_JsEncode2($this->BasicSearch->Type) . "\"";
			$sFilterList = ew_Concat($sFilterList, $sWrk, ",");
		}
		$sFilterList = preg_replace('/,$/', "", $sFilterList);

		// Return filter list in json
		if ($sFilterList <> "")
			$sFilterList = "\"data\":{" . $sFilterList . "}";
		if ($sSavedFilterList <> "") {
			if ($sFilterList <> "")
				$sFilterList .= ",";
			$sFilterList .= "\"filters\":" . $sSavedFilterList;
		}
		return ($sFilterList <> "") ? "{" . $sFilterList . "}" : "null";
	}

	// Process filter list
	function ProcessFilterList() {
		global $UserProfile;
		if (@$_POST["ajax"] == "savefilters") { // Save filter request (Ajax)
			$filters = ew_StripSlashes(@$_POST["filters"]);
			$UserProfile->SetSearchFilters(CurrentUserName(), "fv04_uang_masuklistsrch", $filters);

			// Clean output buffer
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			echo ew_ArrayToJson(array(array("success" => TRUE))); // Success
			$this->Page_Terminate();
			exit();
		} elseif (@$_POST["cmd"] == "resetfilter") {
			$this->RestoreFilterList();
		}
	}

	// Restore list of filters
	function RestoreFilterList() {

		// Return if not reset filter
		if (@$_POST["cmd"] <> "resetfilter")
			return FALSE;
		$filter = json_decode(ew_StripSlashes(@$_POST["filter"]), TRUE);
		$this->Command = "search";

		// Field siswanonrutin_id
		$this->siswanonrutin_id->AdvancedSearch->SearchValue = @$filter["x_siswanonrutin_id"];
		$this->siswanonrutin_id->AdvancedSearch->SearchOperator = @$filter["z_siswanonrutin_id"];
		$this->siswanonrutin_id->AdvancedSearch->SearchCondition = @$filter["v_siswanonrutin_id"];
		$this->siswanonrutin_id->AdvancedSearch->SearchValue2 = @$filter["y_siswanonrutin_id"];
		$this->siswanonrutin_id->AdvancedSearch->SearchOperator2 = @$filter["w_siswanonrutin_id"];
		$this->siswanonrutin_id->AdvancedSearch->Save();

		// Field siswa_id
		$this->siswa_id->AdvancedSearch->SearchValue = @$filter["x_siswa_id"];
		$this->siswa_id->AdvancedSearch->SearchOperator = @$filter["z_siswa_id"];
		$this->siswa_id->AdvancedSearch->SearchCondition = @$filter["v_siswa_id"];
		$this->siswa_id->AdvancedSearch->SearchValue2 = @$filter["y_siswa_id"];
		$this->siswa_id->AdvancedSearch->SearchOperator2 = @$filter["w_siswa_id"];
		$this->siswa_id->AdvancedSearch->Save();

		// Field nonrutin_id
		$this->nonrutin_id->AdvancedSearch->SearchValue = @$filter["x_nonrutin_id"];
		$this->nonrutin_id->AdvancedSearch->SearchOperator = @$filter["z_nonrutin_id"];
		$this->nonrutin_id->AdvancedSearch->SearchCondition = @$filter["v_nonrutin_id"];
		$this->nonrutin_id->AdvancedSearch->SearchValue2 = @$filter["y_nonrutin_id"];
		$this->nonrutin_id->AdvancedSearch->SearchOperator2 = @$filter["w_nonrutin_id"];
		$this->nonrutin_id->AdvancedSearch->Save();

		// Field sekolah_id
		$this->sekolah_id->AdvancedSearch->SearchValue = @$filter["x_sekolah_id"];
		$this->sekolah_id->AdvancedSearch->SearchOperator = @$filter["z_sekolah_id"];
		$this->sekolah_id->AdvancedSearch->SearchCondition = @$filter["v_sekolah_id"];
		$this->sekolah_id->AdvancedSearch->SearchValue2 = @$filter["y_sekolah_id"];
		$this->sekolah_id->AdvancedSearch->SearchOperator2 = @$filter["w_sekolah_id"];
		$this->sekolah_id->AdvancedSearch->Save();

		// Field kelas_id
		$this->kelas_id->AdvancedSearch->SearchValue = @$filter["x_kelas_id"];
		$this->kelas_id->AdvancedSearch->SearchOperator = @$filter["z_kelas_id"];
		$this->kelas_id->AdvancedSearch->SearchCondition = @$filter["v_kelas_id"];
		$this->kelas_id->AdvancedSearch->SearchValue2 = @$filter["y_kelas_id"];
		$this->kelas_id->AdvancedSearch->SearchOperator2 = @$filter["w_kelas_id"];
		$this->kelas_id->AdvancedSearch->Save();

		// Field NIS
		$this->NIS->AdvancedSearch->SearchValue = @$filter["x_NIS"];
		$this->NIS->AdvancedSearch->SearchOperator = @$filter["z_NIS"];
		$this->NIS->AdvancedSearch->SearchCondition = @$filter["v_NIS"];
		$this->NIS->AdvancedSearch->SearchValue2 = @$filter["y_NIS"];
		$this->NIS->AdvancedSearch->SearchOperator2 = @$filter["w_NIS"];
		$this->NIS->AdvancedSearch->Save();

		// Field Nama
		$this->Nama->AdvancedSearch->SearchValue = @$filter["x_Nama"];
		$this->Nama->AdvancedSearch->SearchOperator = @$filter["z_Nama"];
		$this->Nama->AdvancedSearch->SearchCondition = @$filter["v_Nama"];
		$this->Nama->AdvancedSearch->SearchValue2 = @$filter["y_Nama"];
		$this->Nama->AdvancedSearch->SearchOperator2 = @$filter["w_Nama"];
		$this->Nama->AdvancedSearch->Save();

		// Field Jenis
		$this->Jenis->AdvancedSearch->SearchValue = @$filter["x_Jenis"];
		$this->Jenis->AdvancedSearch->SearchOperator = @$filter["z_Jenis"];
		$this->Jenis->AdvancedSearch->SearchCondition = @$filter["v_Jenis"];
		$this->Jenis->AdvancedSearch->SearchValue2 = @$filter["y_Jenis"];
		$this->Jenis->AdvancedSearch->SearchOperator2 = @$filter["w_Jenis"];
		$this->Jenis->AdvancedSearch->Save();

		// Field Nilai
		$this->Nilai->AdvancedSearch->SearchValue = @$filter["x_Nilai"];
		$this->Nilai->AdvancedSearch->SearchOperator = @$filter["z_Nilai"];
		$this->Nilai->AdvancedSearch->SearchCondition = @$filter["v_Nilai"];
		$this->Nilai->AdvancedSearch->SearchValue2 = @$filter["y_Nilai"];
		$this->Nilai->AdvancedSearch->SearchOperator2 = @$filter["w_Nilai"];
		$this->Nilai->AdvancedSearch->Save();

		// Field Kelas
		$this->Kelas->AdvancedSearch->SearchValue = @$filter["x_Kelas"];
		$this->Kelas->AdvancedSearch->SearchOperator = @$filter["z_Kelas"];
		$this->Kelas->AdvancedSearch->SearchCondition = @$filter["v_Kelas"];
		$this->Kelas->AdvancedSearch->SearchValue2 = @$filter["y_Kelas"];
		$this->Kelas->AdvancedSearch->SearchOperator2 = @$filter["w_Kelas"];
		$this->Kelas->AdvancedSearch->Save();

		// Field Sekolah
		$this->Sekolah->AdvancedSearch->SearchValue = @$filter["x_Sekolah"];
		$this->Sekolah->AdvancedSearch->SearchOperator = @$filter["z_Sekolah"];
		$this->Sekolah->AdvancedSearch->SearchCondition = @$filter["v_Sekolah"];
		$this->Sekolah->AdvancedSearch->SearchValue2 = @$filter["y_Sekolah"];
		$this->Sekolah->AdvancedSearch->SearchOperator2 = @$filter["w_Sekolah"];
		$this->Sekolah->AdvancedSearch->Save();

		// Field Periode_Tahun_Bulan
		$this->Periode_Tahun_Bulan->AdvancedSearch->SearchValue = @$filter["x_Periode_Tahun_Bulan"];
		$this->Periode_Tahun_Bulan->AdvancedSearch->SearchOperator = @$filter["z_Periode_Tahun_Bulan"];
		$this->Periode_Tahun_Bulan->AdvancedSearch->SearchCondition = @$filter["v_Periode_Tahun_Bulan"];
		$this->Periode_Tahun_Bulan->AdvancedSearch->SearchValue2 = @$filter["y_Periode_Tahun_Bulan"];
		$this->Periode_Tahun_Bulan->AdvancedSearch->SearchOperator2 = @$filter["w_Periode_Tahun_Bulan"];
		$this->Periode_Tahun_Bulan->AdvancedSearch->Save();

		// Field Periode_Text
		$this->Periode_Text->AdvancedSearch->SearchValue = @$filter["x_Periode_Text"];
		$this->Periode_Text->AdvancedSearch->SearchOperator = @$filter["z_Periode_Text"];
		$this->Periode_Text->AdvancedSearch->SearchCondition = @$filter["v_Periode_Text"];
		$this->Periode_Text->AdvancedSearch->SearchValue2 = @$filter["y_Periode_Text"];
		$this->Periode_Text->AdvancedSearch->SearchOperator2 = @$filter["w_Periode_Text"];
		$this->Periode_Text->AdvancedSearch->Save();

		// Field Bayar
		$this->Bayar->AdvancedSearch->SearchValue = @$filter["x_Bayar"];
		$this->Bayar->AdvancedSearch->SearchOperator = @$filter["z_Bayar"];
		$this->Bayar->AdvancedSearch->SearchCondition = @$filter["v_Bayar"];
		$this->Bayar->AdvancedSearch->SearchValue2 = @$filter["y_Bayar"];
		$this->Bayar->AdvancedSearch->SearchOperator2 = @$filter["w_Bayar"];
		$this->Bayar->AdvancedSearch->Save();

		// Field Per_Thn_Bln_Byr
		$this->Per_Thn_Bln_Byr->AdvancedSearch->SearchValue = @$filter["x_Per_Thn_Bln_Byr"];
		$this->Per_Thn_Bln_Byr->AdvancedSearch->SearchOperator = @$filter["z_Per_Thn_Bln_Byr"];
		$this->Per_Thn_Bln_Byr->AdvancedSearch->SearchCondition = @$filter["v_Per_Thn_Bln_Byr"];
		$this->Per_Thn_Bln_Byr->AdvancedSearch->SearchValue2 = @$filter["y_Per_Thn_Bln_Byr"];
		$this->Per_Thn_Bln_Byr->AdvancedSearch->SearchOperator2 = @$filter["w_Per_Thn_Bln_Byr"];
		$this->Per_Thn_Bln_Byr->AdvancedSearch->Save();

		// Field Per_Thn_Bln_Byr_Text
		$this->Per_Thn_Bln_Byr_Text->AdvancedSearch->SearchValue = @$filter["x_Per_Thn_Bln_Byr_Text"];
		$this->Per_Thn_Bln_Byr_Text->AdvancedSearch->SearchOperator = @$filter["z_Per_Thn_Bln_Byr_Text"];
		$this->Per_Thn_Bln_Byr_Text->AdvancedSearch->SearchCondition = @$filter["v_Per_Thn_Bln_Byr_Text"];
		$this->Per_Thn_Bln_Byr_Text->AdvancedSearch->SearchValue2 = @$filter["y_Per_Thn_Bln_Byr_Text"];
		$this->Per_Thn_Bln_Byr_Text->AdvancedSearch->SearchOperator2 = @$filter["w_Per_Thn_Bln_Byr_Text"];
		$this->Per_Thn_Bln_Byr_Text->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->NIS, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Nama, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Jenis, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Kelas, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Sekolah, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Periode_Tahun_Bulan, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Periode_Text, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Per_Thn_Bln_Byr, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Per_Thn_Bln_Byr_Text, $arKeywords, $type);
		return $sWhere;
	}

	// Build basic search SQL
	function BuildBasicSearchSQL(&$Where, &$Fld, $arKeywords, $type) {
		global $EW_BASIC_SEARCH_IGNORE_PATTERN;
		$sDefCond = ($type == "OR") ? "OR" : "AND";
		$arSQL = array(); // Array for SQL parts
		$arCond = array(); // Array for search conditions
		$cnt = count($arKeywords);
		$j = 0; // Number of SQL parts
		for ($i = 0; $i < $cnt; $i++) {
			$Keyword = $arKeywords[$i];
			$Keyword = trim($Keyword);
			if ($EW_BASIC_SEARCH_IGNORE_PATTERN <> "") {
				$Keyword = preg_replace($EW_BASIC_SEARCH_IGNORE_PATTERN, "\\", $Keyword);
				$ar = explode("\\", $Keyword);
			} else {
				$ar = array($Keyword);
			}
			foreach ($ar as $Keyword) {
				if ($Keyword <> "") {
					$sWrk = "";
					if ($Keyword == "OR" && $type == "") {
						if ($j > 0)
							$arCond[$j-1] = "OR";
					} elseif ($Keyword == EW_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NULL";
					} elseif ($Keyword == EW_NOT_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NOT NULL";
					} elseif ($Fld->FldIsVirtual) {
						$sWrk = $Fld->FldVirtualExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					} elseif ($Fld->FldDataType != EW_DATATYPE_NUMBER || is_numeric($Keyword)) {
						$sWrk = $Fld->FldBasicSearchExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					}
					if ($sWrk <> "") {
						$arSQL[$j] = $sWrk;
						$arCond[$j] = $sDefCond;
						$j += 1;
					}
				}
			}
		}
		$cnt = count($arSQL);
		$bQuoted = FALSE;
		$sSql = "";
		if ($cnt > 0) {
			for ($i = 0; $i < $cnt-1; $i++) {
				if ($arCond[$i] == "OR") {
					if (!$bQuoted) $sSql .= "(";
					$bQuoted = TRUE;
				}
				$sSql .= $arSQL[$i];
				if ($bQuoted && $arCond[$i] <> "OR") {
					$sSql .= ")";
					$bQuoted = FALSE;
				}
				$sSql .= " " . $arCond[$i] . " ";
			}
			$sSql .= $arSQL[$cnt-1];
			if ($bQuoted)
				$sSql .= ")";
		}
		if ($sSql <> "") {
			if ($Where <> "") $Where .= " OR ";
			$Where .=  "(" . $sSql . ")";
		}
	}

	// Return basic search WHERE clause based on search keyword and type
	function BasicSearchWhere($Default = FALSE) {
		global $Security;
		$sSearchStr = "";
		$sSearchKeyword = ($Default) ? $this->BasicSearch->KeywordDefault : $this->BasicSearch->Keyword;
		$sSearchType = ($Default) ? $this->BasicSearch->TypeDefault : $this->BasicSearch->Type;
		if ($sSearchKeyword <> "") {
			$sSearch = trim($sSearchKeyword);
			if ($sSearchType <> "=") {
				$ar = array();

				// Match quoted keywords (i.e.: "...")
				if (preg_match_all('/"([^"]*)"/i', $sSearch, $matches, PREG_SET_ORDER)) {
					foreach ($matches as $match) {
						$p = strpos($sSearch, $match[0]);
						$str = substr($sSearch, 0, $p);
						$sSearch = substr($sSearch, $p + strlen($match[0]));
						if (strlen(trim($str)) > 0)
							$ar = array_merge($ar, explode(" ", trim($str)));
						$ar[] = $match[1]; // Save quoted keyword
					}
				}

				// Match individual keywords
				if (strlen(trim($sSearch)) > 0)
					$ar = array_merge($ar, explode(" ", trim($sSearch)));

				// Search keyword in any fields
				if (($sSearchType == "OR" || $sSearchType == "AND") && $this->BasicSearch->BasicSearchAnyFields) {
					foreach ($ar as $sKeyword) {
						if ($sKeyword <> "") {
							if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
							$sSearchStr .= "(" . $this->BasicSearchSQL(array($sKeyword), $sSearchType) . ")";
						}
					}
				} else {
					$sSearchStr = $this->BasicSearchSQL($ar, $sSearchType);
				}
			} else {
				$sSearchStr = $this->BasicSearchSQL(array($sSearch), $sSearchType);
			}
			if (!$Default) $this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->BasicSearch->setKeyword($sSearchKeyword);
			$this->BasicSearch->setType($sSearchType);
		}
		return $sSearchStr;
	}

	// Check if search parm exists
	function CheckSearchParms() {

		// Check basic search
		if ($this->BasicSearch->IssetSession())
			return TRUE;
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for Ctrl pressed
		$bCtrl = (@$_GET["ctrl"] <> "");

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->siswanonrutin_id, $bCtrl); // siswanonrutin_id
			$this->UpdateSort($this->siswa_id, $bCtrl); // siswa_id
			$this->UpdateSort($this->nonrutin_id, $bCtrl); // nonrutin_id
			$this->UpdateSort($this->sekolah_id, $bCtrl); // sekolah_id
			$this->UpdateSort($this->kelas_id, $bCtrl); // kelas_id
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
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		$sOrderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($this->getSqlOrderBy() <> "") {
				$sOrderBy = $this->getSqlOrderBy();
				$this->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// - cmd=reset (Reset search parameters)
	// - cmd=resetall (Reset search and master/detail parameters)
	// - cmd=resetsort (Reset sort parameters)
	function ResetCmd() {

		// Check if reset command
		if (substr($this->Command,0,5) == "reset") {

			// Reset search criteria
			if ($this->Command == "reset" || $this->Command == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->siswanonrutin_id->setSort("");
				$this->siswa_id->setSort("");
				$this->nonrutin_id->setSort("");
				$this->sekolah_id->setSort("");
				$this->kelas_id->setSort("");
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
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;

		// List actions
		$item = &$this->ListOptions->Add("listactions");
		$item->CssStyle = "white-space: nowrap;";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;
		$item->ShowInButtonGroup = FALSE;
		$item->ShowInDropDown = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = FALSE;
		$item->OnLeft = TRUE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\">";
		$item->MoveTo(0);
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseImageAndText = TRUE;
		$this->ListOptions->UseDropDownButton = FALSE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = FALSE;
		if ($this->ListOptions->UseButtonGroup && ew_IsMobile())
			$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->ButtonClass = "btn-sm"; // Class for button group

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		$this->SetupListOptionsExt();
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// Set up list action buttons
		$oListOpt = &$this->ListOptions->GetItem("listactions");
		if ($oListOpt && $this->Export == "" && $this->CurrentAction == "") {
			$body = "";
			$links = array();
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_SINGLE && $listaction->Allow) {
					$action = $listaction->Action;
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode(str_replace(" ewIcon", "", $listaction->Icon)) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\"></span> " : "";
					$links[] = "<li><a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . $listaction->Caption . "</a></li>";
					if (count($links) == 1) // Single button
						$body = "<a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $Language->Phrase("ListActionButton") . "</a>";
				}
			}
			if (count($links) > 1) { // More than one buttons, use dropdown
				$body = "<button class=\"dropdown-toggle btn btn-default btn-sm ewActions\" title=\"" . ew_HtmlTitle($Language->Phrase("ListActionButton")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("ListActionButton") . "<b class=\"caret\"></b></button>";
				$content = "";
				foreach ($links as $link)
					$content .= "<li>" . $link . "</li>";
				$body .= "<ul class=\"dropdown-menu" . ($oListOpt->OnLeft ? "" : " dropdown-menu-right") . "\">". $content . "</ul>";
				$body = "<div class=\"btn-group\">" . $body . "</div>";
			}
			if (count($links) > 0) {
				$oListOpt->Body = $body;
				$oListOpt->Visible = TRUE;
			}
		}

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["action"];

		// Set up options default
		foreach ($options as &$option) {
			$option->UseImageAndText = TRUE;
			$option->UseDropDownButton = FALSE;
			$option->UseButtonGroup = TRUE;
			$option->ButtonClass = "btn-sm"; // Class for button group
			$item = &$option->Add($option->GroupOptionName);
			$item->Body = "";
			$item->Visible = FALSE;
		}
		$options["addedit"]->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$options["action"]->DropDownButtonPhrase = $Language->Phrase("ButtonActions");

		// Filter button
		$item = &$this->FilterOptions->Add("savecurrentfilter");
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fv04_uang_masuklistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fv04_uang_masuklistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
		$item->Visible = TRUE;
		$this->FilterOptions->UseDropDownButton = TRUE;
		$this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
		$this->FilterOptions->DropDownButtonPhrase = $Language->Phrase("Filters");

		// Add group option item
		$item = &$this->FilterOptions->Add($this->FilterOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fv04_uang_masuklist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
					$item->Visible = $listaction->Allow;
				}
			}

			// Hide grid edit and other options
			if ($this->TotalRecs <= 0) {
				$option = &$options["addedit"];
				$item = &$option->GetItem("gridedit");
				if ($item) $item->Visible = FALSE;
				$option = &$options["action"];
				$option->HideAllOptions();
			}
	}

	// Process list action
	function ProcessListAction() {
		global $Language, $Security;
		$userlist = "";
		$user = "";
		$sFilter = $this->GetKeyFilter();
		$UserAction = @$_POST["useraction"];
		if ($sFilter <> "" && $UserAction <> "") {

			// Check permission first
			$ActionCaption = $UserAction;
			if (array_key_exists($UserAction, $this->ListActions->Items)) {
				$ActionCaption = $this->ListActions->Items[$UserAction]->Caption;
				if (!$this->ListActions->Items[$UserAction]->Allow) {
					$errmsg = str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionNotAllowed"));
					if (@$_POST["ajax"] == $UserAction) // Ajax
						echo "<p class=\"text-danger\">" . $errmsg . "</p>";
					else
						$this->setFailureMessage($errmsg);
					return FALSE;
				}
			}
			$this->CurrentFilter = $sFilter;
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rs = $conn->Execute($sSql);
			$conn->raiseErrorFn = '';
			$this->CurrentAction = $UserAction;

			// Call row action event
			if ($rs && !$rs->EOF) {
				$conn->BeginTrans();
				$this->SelectedCount = $rs->RecordCount();
				$this->SelectedIndex = 0;
				while (!$rs->EOF) {
					$this->SelectedIndex++;
					$row = $rs->fields;
					$Processed = $this->Row_CustomAction($UserAction, $row);
					if (!$Processed) break;
					$rs->MoveNext();
				}
				if ($Processed) {
					$conn->CommitTrans(); // Commit the changes
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionCompleted"))); // Set up success message
				} else {
					$conn->RollbackTrans(); // Rollback changes

					// Set up error message
					if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

						// Use the message, do nothing
					} elseif ($this->CancelMessage <> "") {
						$this->setFailureMessage($this->CancelMessage);
						$this->CancelMessage = "";
					} else {
						$this->setFailureMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionFailed")));
					}
				}
			}
			if ($rs)
				$rs->Close();
			$this->CurrentAction = ""; // Clear action
			if (@$_POST["ajax"] == $UserAction) { // Ajax
				if ($this->getSuccessMessage() <> "") {
					echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
					$this->ClearSuccessMessage(); // Clear message
				}
				if ($this->getFailureMessage() <> "") {
					echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
					$this->ClearFailureMessage(); // Clear message
				}
				return TRUE;
			}
		}
		return FALSE; // Not ajax request
	}

	// Set up search options
	function SetupSearchOptions() {
		global $Language;
		$this->SearchOptions = new cListOptions();
		$this->SearchOptions->Tag = "div";
		$this->SearchOptions->TagClassName = "ewSearchOption";

		// Search button
		$item = &$this->SearchOptions->Add("searchtoggle");
		$SearchToggleClass = ($this->SearchWhere <> "") ? " active" : " active";
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fv04_uang_masuklistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

		// Button group for search
		$this->SearchOptions->UseDropDownButton = FALSE;
		$this->SearchOptions->UseImageAndText = TRUE;
		$this->SearchOptions->UseButtonGroup = TRUE;
		$this->SearchOptions->DropDownButtonPhrase = $Language->Phrase("ButtonSearch");

		// Add group option item
		$item = &$this->SearchOptions->Add($this->SearchOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide search options
		if ($this->Export <> "" || $this->CurrentAction <> "")
			$this->SearchOptions->HideAllOptions();
	}

	function SetupListOptionsExt() {
		global $Security, $Language;
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
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

	// Load basic search values
	function LoadBasicSearchValues() {
		$this->BasicSearch->Keyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		if ($this->BasicSearch->Keyword <> "") $this->Command = "search";
		$this->BasicSearch->Type = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
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
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->siswanonrutin_id->DbValue = $row['siswanonrutin_id'];
		$this->siswa_id->DbValue = $row['siswa_id'];
		$this->nonrutin_id->DbValue = $row['nonrutin_id'];
		$this->sekolah_id->DbValue = $row['sekolah_id'];
		$this->kelas_id->DbValue = $row['kelas_id'];
		$this->NIS->DbValue = $row['NIS'];
		$this->Nama->DbValue = $row['Nama'];
		$this->Jenis->DbValue = $row['Jenis'];
		$this->Nilai->DbValue = $row['Nilai'];
		$this->Kelas->DbValue = $row['Kelas'];
		$this->Sekolah->DbValue = $row['Sekolah'];
		$this->Periode_Tahun_Bulan->DbValue = $row['Periode_Tahun_Bulan'];
		$this->Periode_Text->DbValue = $row['Periode_Text'];
		$this->Bayar->DbValue = $row['Bayar'];
		$this->Per_Thn_Bln_Byr->DbValue = $row['Per_Thn_Bln_Byr'];
		$this->Per_Thn_Bln_Byr_Text->DbValue = $row['Per_Thn_Bln_Byr_Text'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;

		// Load old recordset
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$this->OldRecordset = ew_LoadRecordset($sSql, $conn);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		} else {
			$this->OldRecordset = NULL;
		}
		return $bValidKey;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

		// Convert decimal values if posted back
		if ($this->Nilai->FormValue == $this->Nilai->CurrentValue && is_numeric(ew_StrToFloat($this->Nilai->CurrentValue)))
			$this->Nilai->CurrentValue = ew_StrToFloat($this->Nilai->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Bayar->FormValue == $this->Bayar->CurrentValue && is_numeric(ew_StrToFloat($this->Bayar->CurrentValue)))
			$this->Bayar->CurrentValue = ew_StrToFloat($this->Bayar->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// siswanonrutin_id
		// siswa_id
		// nonrutin_id
		// sekolah_id
		// kelas_id
		// NIS
		// Nama
		// Jenis
		// Nilai
		// Kelas
		// Sekolah
		// Periode_Tahun_Bulan
		// Periode_Text
		// Bayar
		// Per_Thn_Bln_Byr
		// Per_Thn_Bln_Byr_Text

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// siswanonrutin_id
		$this->siswanonrutin_id->ViewValue = $this->siswanonrutin_id->CurrentValue;
		$this->siswanonrutin_id->ViewCustomAttributes = "";

		// siswa_id
		$this->siswa_id->ViewValue = $this->siswa_id->CurrentValue;
		$this->siswa_id->ViewCustomAttributes = "";

		// nonrutin_id
		$this->nonrutin_id->ViewValue = $this->nonrutin_id->CurrentValue;
		$this->nonrutin_id->ViewCustomAttributes = "";

		// sekolah_id
		$this->sekolah_id->ViewValue = $this->sekolah_id->CurrentValue;
		$this->sekolah_id->ViewCustomAttributes = "";

		// kelas_id
		$this->kelas_id->ViewValue = $this->kelas_id->CurrentValue;
		$this->kelas_id->ViewCustomAttributes = "";

		// NIS
		$this->NIS->ViewValue = $this->NIS->CurrentValue;
		$this->NIS->ViewCustomAttributes = "";

		// Nama
		$this->Nama->ViewValue = $this->Nama->CurrentValue;
		$this->Nama->ViewCustomAttributes = "";

		// Jenis
		$this->Jenis->ViewValue = $this->Jenis->CurrentValue;
		$this->Jenis->ViewCustomAttributes = "";

		// Nilai
		$this->Nilai->ViewValue = $this->Nilai->CurrentValue;
		$this->Nilai->ViewCustomAttributes = "";

		// Kelas
		$this->Kelas->ViewValue = $this->Kelas->CurrentValue;
		$this->Kelas->ViewCustomAttributes = "";

		// Sekolah
		$this->Sekolah->ViewValue = $this->Sekolah->CurrentValue;
		$this->Sekolah->ViewCustomAttributes = "";

		// Periode_Tahun_Bulan
		$this->Periode_Tahun_Bulan->ViewValue = $this->Periode_Tahun_Bulan->CurrentValue;
		$this->Periode_Tahun_Bulan->ViewCustomAttributes = "";

		// Periode_Text
		$this->Periode_Text->ViewValue = $this->Periode_Text->CurrentValue;
		$this->Periode_Text->ViewCustomAttributes = "";

		// Bayar
		$this->Bayar->ViewValue = $this->Bayar->CurrentValue;
		$this->Bayar->ViewCustomAttributes = "";

		// Per_Thn_Bln_Byr
		$this->Per_Thn_Bln_Byr->ViewValue = $this->Per_Thn_Bln_Byr->CurrentValue;
		$this->Per_Thn_Bln_Byr->ViewCustomAttributes = "";

		// Per_Thn_Bln_Byr_Text
		$this->Per_Thn_Bln_Byr_Text->ViewValue = $this->Per_Thn_Bln_Byr_Text->CurrentValue;
		$this->Per_Thn_Bln_Byr_Text->ViewCustomAttributes = "";

			// siswanonrutin_id
			$this->siswanonrutin_id->LinkCustomAttributes = "";
			$this->siswanonrutin_id->HrefValue = "";
			$this->siswanonrutin_id->TooltipValue = "";

			// siswa_id
			$this->siswa_id->LinkCustomAttributes = "";
			$this->siswa_id->HrefValue = "";
			$this->siswa_id->TooltipValue = "";

			// nonrutin_id
			$this->nonrutin_id->LinkCustomAttributes = "";
			$this->nonrutin_id->HrefValue = "";
			$this->nonrutin_id->TooltipValue = "";

			// sekolah_id
			$this->sekolah_id->LinkCustomAttributes = "";
			$this->sekolah_id->HrefValue = "";
			$this->sekolah_id->TooltipValue = "";

			// kelas_id
			$this->kelas_id->LinkCustomAttributes = "";
			$this->kelas_id->HrefValue = "";
			$this->kelas_id->TooltipValue = "";

			// NIS
			$this->NIS->LinkCustomAttributes = "";
			$this->NIS->HrefValue = "";
			$this->NIS->TooltipValue = "";

			// Nama
			$this->Nama->LinkCustomAttributes = "";
			$this->Nama->HrefValue = "";
			$this->Nama->TooltipValue = "";

			// Jenis
			$this->Jenis->LinkCustomAttributes = "";
			$this->Jenis->HrefValue = "";
			$this->Jenis->TooltipValue = "";

			// Nilai
			$this->Nilai->LinkCustomAttributes = "";
			$this->Nilai->HrefValue = "";
			$this->Nilai->TooltipValue = "";

			// Kelas
			$this->Kelas->LinkCustomAttributes = "";
			$this->Kelas->HrefValue = "";
			$this->Kelas->TooltipValue = "";

			// Sekolah
			$this->Sekolah->LinkCustomAttributes = "";
			$this->Sekolah->HrefValue = "";
			$this->Sekolah->TooltipValue = "";

			// Periode_Tahun_Bulan
			$this->Periode_Tahun_Bulan->LinkCustomAttributes = "";
			$this->Periode_Tahun_Bulan->HrefValue = "";
			$this->Periode_Tahun_Bulan->TooltipValue = "";

			// Periode_Text
			$this->Periode_Text->LinkCustomAttributes = "";
			$this->Periode_Text->HrefValue = "";
			$this->Periode_Text->TooltipValue = "";

			// Bayar
			$this->Bayar->LinkCustomAttributes = "";
			$this->Bayar->HrefValue = "";
			$this->Bayar->TooltipValue = "";

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
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", $this->TableVar, $url, "", $this->TableVar, TRUE);
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example: 
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}

	// Row Custom Action event
	function Row_CustomAction($action, $row) {

		// Return FALSE to abort
		return TRUE;
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
if (!isset($v04_uang_masuk_list)) $v04_uang_masuk_list = new cv04_uang_masuk_list();

// Page init
$v04_uang_masuk_list->Page_Init();

// Page main
$v04_uang_masuk_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$v04_uang_masuk_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fv04_uang_masuklist = new ew_Form("fv04_uang_masuklist", "list");
fv04_uang_masuklist.FormKeyCountName = '<?php echo $v04_uang_masuk_list->FormKeyCountName ?>';

// Form_CustomValidate event
fv04_uang_masuklist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fv04_uang_masuklist.ValidateRequired = true;
<?php } else { ?>
fv04_uang_masuklist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

var CurrentSearchForm = fv04_uang_masuklistsrch = new ew_Form("fv04_uang_masuklistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php if ($v04_uang_masuk_list->TotalRecs > 0 && $v04_uang_masuk_list->ExportOptions->Visible()) { ?>
<?php $v04_uang_masuk_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($v04_uang_masuk_list->SearchOptions->Visible()) { ?>
<?php $v04_uang_masuk_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($v04_uang_masuk_list->FilterOptions->Visible()) { ?>
<?php $v04_uang_masuk_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php
	$bSelectLimit = $v04_uang_masuk_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($v04_uang_masuk_list->TotalRecs <= 0)
			$v04_uang_masuk_list->TotalRecs = $v04_uang_masuk->SelectRecordCount();
	} else {
		if (!$v04_uang_masuk_list->Recordset && ($v04_uang_masuk_list->Recordset = $v04_uang_masuk_list->LoadRecordset()))
			$v04_uang_masuk_list->TotalRecs = $v04_uang_masuk_list->Recordset->RecordCount();
	}
	$v04_uang_masuk_list->StartRec = 1;
	if ($v04_uang_masuk_list->DisplayRecs <= 0 || ($v04_uang_masuk->Export <> "" && $v04_uang_masuk->ExportAll)) // Display all records
		$v04_uang_masuk_list->DisplayRecs = $v04_uang_masuk_list->TotalRecs;
	if (!($v04_uang_masuk->Export <> "" && $v04_uang_masuk->ExportAll))
		$v04_uang_masuk_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$v04_uang_masuk_list->Recordset = $v04_uang_masuk_list->LoadRecordset($v04_uang_masuk_list->StartRec-1, $v04_uang_masuk_list->DisplayRecs);

	// Set no record found message
	if ($v04_uang_masuk->CurrentAction == "" && $v04_uang_masuk_list->TotalRecs == 0) {
		if ($v04_uang_masuk_list->SearchWhere == "0=101")
			$v04_uang_masuk_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$v04_uang_masuk_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$v04_uang_masuk_list->RenderOtherOptions();
?>
<?php if ($v04_uang_masuk->Export == "" && $v04_uang_masuk->CurrentAction == "") { ?>
<form name="fv04_uang_masuklistsrch" id="fv04_uang_masuklistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($v04_uang_masuk_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fv04_uang_masuklistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="v04_uang_masuk">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($v04_uang_masuk_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($v04_uang_masuk_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $v04_uang_masuk_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($v04_uang_masuk_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($v04_uang_masuk_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($v04_uang_masuk_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($v04_uang_masuk_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
		</ul>
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("QuickSearchBtn") ?></button>
	</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php $v04_uang_masuk_list->ShowPageHeader(); ?>
<?php
$v04_uang_masuk_list->ShowMessage();
?>
<?php if ($v04_uang_masuk_list->TotalRecs > 0 || $v04_uang_masuk->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid v04_uang_masuk">
<form name="fv04_uang_masuklist" id="fv04_uang_masuklist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($v04_uang_masuk_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $v04_uang_masuk_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="v04_uang_masuk">
<div id="gmp_v04_uang_masuk" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($v04_uang_masuk_list->TotalRecs > 0 || $v04_uang_masuk->CurrentAction == "gridedit") { ?>
<table id="tbl_v04_uang_masuklist" class="table ewTable">
<?php echo $v04_uang_masuk->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$v04_uang_masuk_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$v04_uang_masuk_list->RenderListOptions();

// Render list options (header, left)
$v04_uang_masuk_list->ListOptions->Render("header", "left");
?>
<?php if ($v04_uang_masuk->siswanonrutin_id->Visible) { // siswanonrutin_id ?>
	<?php if ($v04_uang_masuk->SortUrl($v04_uang_masuk->siswanonrutin_id) == "") { ?>
		<th data-name="siswanonrutin_id"><div id="elh_v04_uang_masuk_siswanonrutin_id" class="v04_uang_masuk_siswanonrutin_id"><div class="ewTableHeaderCaption"><?php echo $v04_uang_masuk->siswanonrutin_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="siswanonrutin_id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v04_uang_masuk->SortUrl($v04_uang_masuk->siswanonrutin_id) ?>',2);"><div id="elh_v04_uang_masuk_siswanonrutin_id" class="v04_uang_masuk_siswanonrutin_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v04_uang_masuk->siswanonrutin_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v04_uang_masuk->siswanonrutin_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v04_uang_masuk->siswanonrutin_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($v04_uang_masuk->siswa_id->Visible) { // siswa_id ?>
	<?php if ($v04_uang_masuk->SortUrl($v04_uang_masuk->siswa_id) == "") { ?>
		<th data-name="siswa_id"><div id="elh_v04_uang_masuk_siswa_id" class="v04_uang_masuk_siswa_id"><div class="ewTableHeaderCaption"><?php echo $v04_uang_masuk->siswa_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="siswa_id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v04_uang_masuk->SortUrl($v04_uang_masuk->siswa_id) ?>',2);"><div id="elh_v04_uang_masuk_siswa_id" class="v04_uang_masuk_siswa_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v04_uang_masuk->siswa_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v04_uang_masuk->siswa_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v04_uang_masuk->siswa_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($v04_uang_masuk->nonrutin_id->Visible) { // nonrutin_id ?>
	<?php if ($v04_uang_masuk->SortUrl($v04_uang_masuk->nonrutin_id) == "") { ?>
		<th data-name="nonrutin_id"><div id="elh_v04_uang_masuk_nonrutin_id" class="v04_uang_masuk_nonrutin_id"><div class="ewTableHeaderCaption"><?php echo $v04_uang_masuk->nonrutin_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nonrutin_id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v04_uang_masuk->SortUrl($v04_uang_masuk->nonrutin_id) ?>',2);"><div id="elh_v04_uang_masuk_nonrutin_id" class="v04_uang_masuk_nonrutin_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v04_uang_masuk->nonrutin_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v04_uang_masuk->nonrutin_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v04_uang_masuk->nonrutin_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($v04_uang_masuk->sekolah_id->Visible) { // sekolah_id ?>
	<?php if ($v04_uang_masuk->SortUrl($v04_uang_masuk->sekolah_id) == "") { ?>
		<th data-name="sekolah_id"><div id="elh_v04_uang_masuk_sekolah_id" class="v04_uang_masuk_sekolah_id"><div class="ewTableHeaderCaption"><?php echo $v04_uang_masuk->sekolah_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="sekolah_id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v04_uang_masuk->SortUrl($v04_uang_masuk->sekolah_id) ?>',2);"><div id="elh_v04_uang_masuk_sekolah_id" class="v04_uang_masuk_sekolah_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v04_uang_masuk->sekolah_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v04_uang_masuk->sekolah_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v04_uang_masuk->sekolah_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($v04_uang_masuk->kelas_id->Visible) { // kelas_id ?>
	<?php if ($v04_uang_masuk->SortUrl($v04_uang_masuk->kelas_id) == "") { ?>
		<th data-name="kelas_id"><div id="elh_v04_uang_masuk_kelas_id" class="v04_uang_masuk_kelas_id"><div class="ewTableHeaderCaption"><?php echo $v04_uang_masuk->kelas_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kelas_id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v04_uang_masuk->SortUrl($v04_uang_masuk->kelas_id) ?>',2);"><div id="elh_v04_uang_masuk_kelas_id" class="v04_uang_masuk_kelas_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v04_uang_masuk->kelas_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v04_uang_masuk->kelas_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v04_uang_masuk->kelas_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($v04_uang_masuk->NIS->Visible) { // NIS ?>
	<?php if ($v04_uang_masuk->SortUrl($v04_uang_masuk->NIS) == "") { ?>
		<th data-name="NIS"><div id="elh_v04_uang_masuk_NIS" class="v04_uang_masuk_NIS"><div class="ewTableHeaderCaption"><?php echo $v04_uang_masuk->NIS->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="NIS"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v04_uang_masuk->SortUrl($v04_uang_masuk->NIS) ?>',2);"><div id="elh_v04_uang_masuk_NIS" class="v04_uang_masuk_NIS">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v04_uang_masuk->NIS->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($v04_uang_masuk->NIS->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v04_uang_masuk->NIS->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($v04_uang_masuk->Nama->Visible) { // Nama ?>
	<?php if ($v04_uang_masuk->SortUrl($v04_uang_masuk->Nama) == "") { ?>
		<th data-name="Nama"><div id="elh_v04_uang_masuk_Nama" class="v04_uang_masuk_Nama"><div class="ewTableHeaderCaption"><?php echo $v04_uang_masuk->Nama->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nama"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v04_uang_masuk->SortUrl($v04_uang_masuk->Nama) ?>',2);"><div id="elh_v04_uang_masuk_Nama" class="v04_uang_masuk_Nama">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v04_uang_masuk->Nama->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($v04_uang_masuk->Nama->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v04_uang_masuk->Nama->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($v04_uang_masuk->Jenis->Visible) { // Jenis ?>
	<?php if ($v04_uang_masuk->SortUrl($v04_uang_masuk->Jenis) == "") { ?>
		<th data-name="Jenis"><div id="elh_v04_uang_masuk_Jenis" class="v04_uang_masuk_Jenis"><div class="ewTableHeaderCaption"><?php echo $v04_uang_masuk->Jenis->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Jenis"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v04_uang_masuk->SortUrl($v04_uang_masuk->Jenis) ?>',2);"><div id="elh_v04_uang_masuk_Jenis" class="v04_uang_masuk_Jenis">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v04_uang_masuk->Jenis->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($v04_uang_masuk->Jenis->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v04_uang_masuk->Jenis->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($v04_uang_masuk->Nilai->Visible) { // Nilai ?>
	<?php if ($v04_uang_masuk->SortUrl($v04_uang_masuk->Nilai) == "") { ?>
		<th data-name="Nilai"><div id="elh_v04_uang_masuk_Nilai" class="v04_uang_masuk_Nilai"><div class="ewTableHeaderCaption"><?php echo $v04_uang_masuk->Nilai->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nilai"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v04_uang_masuk->SortUrl($v04_uang_masuk->Nilai) ?>',2);"><div id="elh_v04_uang_masuk_Nilai" class="v04_uang_masuk_Nilai">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v04_uang_masuk->Nilai->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v04_uang_masuk->Nilai->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v04_uang_masuk->Nilai->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($v04_uang_masuk->Kelas->Visible) { // Kelas ?>
	<?php if ($v04_uang_masuk->SortUrl($v04_uang_masuk->Kelas) == "") { ?>
		<th data-name="Kelas"><div id="elh_v04_uang_masuk_Kelas" class="v04_uang_masuk_Kelas"><div class="ewTableHeaderCaption"><?php echo $v04_uang_masuk->Kelas->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Kelas"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v04_uang_masuk->SortUrl($v04_uang_masuk->Kelas) ?>',2);"><div id="elh_v04_uang_masuk_Kelas" class="v04_uang_masuk_Kelas">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v04_uang_masuk->Kelas->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($v04_uang_masuk->Kelas->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v04_uang_masuk->Kelas->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($v04_uang_masuk->Sekolah->Visible) { // Sekolah ?>
	<?php if ($v04_uang_masuk->SortUrl($v04_uang_masuk->Sekolah) == "") { ?>
		<th data-name="Sekolah"><div id="elh_v04_uang_masuk_Sekolah" class="v04_uang_masuk_Sekolah"><div class="ewTableHeaderCaption"><?php echo $v04_uang_masuk->Sekolah->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Sekolah"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v04_uang_masuk->SortUrl($v04_uang_masuk->Sekolah) ?>',2);"><div id="elh_v04_uang_masuk_Sekolah" class="v04_uang_masuk_Sekolah">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v04_uang_masuk->Sekolah->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($v04_uang_masuk->Sekolah->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v04_uang_masuk->Sekolah->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($v04_uang_masuk->Periode_Tahun_Bulan->Visible) { // Periode_Tahun_Bulan ?>
	<?php if ($v04_uang_masuk->SortUrl($v04_uang_masuk->Periode_Tahun_Bulan) == "") { ?>
		<th data-name="Periode_Tahun_Bulan"><div id="elh_v04_uang_masuk_Periode_Tahun_Bulan" class="v04_uang_masuk_Periode_Tahun_Bulan"><div class="ewTableHeaderCaption"><?php echo $v04_uang_masuk->Periode_Tahun_Bulan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Periode_Tahun_Bulan"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v04_uang_masuk->SortUrl($v04_uang_masuk->Periode_Tahun_Bulan) ?>',2);"><div id="elh_v04_uang_masuk_Periode_Tahun_Bulan" class="v04_uang_masuk_Periode_Tahun_Bulan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v04_uang_masuk->Periode_Tahun_Bulan->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($v04_uang_masuk->Periode_Tahun_Bulan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v04_uang_masuk->Periode_Tahun_Bulan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($v04_uang_masuk->Periode_Text->Visible) { // Periode_Text ?>
	<?php if ($v04_uang_masuk->SortUrl($v04_uang_masuk->Periode_Text) == "") { ?>
		<th data-name="Periode_Text"><div id="elh_v04_uang_masuk_Periode_Text" class="v04_uang_masuk_Periode_Text"><div class="ewTableHeaderCaption"><?php echo $v04_uang_masuk->Periode_Text->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Periode_Text"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v04_uang_masuk->SortUrl($v04_uang_masuk->Periode_Text) ?>',2);"><div id="elh_v04_uang_masuk_Periode_Text" class="v04_uang_masuk_Periode_Text">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v04_uang_masuk->Periode_Text->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($v04_uang_masuk->Periode_Text->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v04_uang_masuk->Periode_Text->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($v04_uang_masuk->Bayar->Visible) { // Bayar ?>
	<?php if ($v04_uang_masuk->SortUrl($v04_uang_masuk->Bayar) == "") { ?>
		<th data-name="Bayar"><div id="elh_v04_uang_masuk_Bayar" class="v04_uang_masuk_Bayar"><div class="ewTableHeaderCaption"><?php echo $v04_uang_masuk->Bayar->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Bayar"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v04_uang_masuk->SortUrl($v04_uang_masuk->Bayar) ?>',2);"><div id="elh_v04_uang_masuk_Bayar" class="v04_uang_masuk_Bayar">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v04_uang_masuk->Bayar->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v04_uang_masuk->Bayar->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v04_uang_masuk->Bayar->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($v04_uang_masuk->Per_Thn_Bln_Byr->Visible) { // Per_Thn_Bln_Byr ?>
	<?php if ($v04_uang_masuk->SortUrl($v04_uang_masuk->Per_Thn_Bln_Byr) == "") { ?>
		<th data-name="Per_Thn_Bln_Byr"><div id="elh_v04_uang_masuk_Per_Thn_Bln_Byr" class="v04_uang_masuk_Per_Thn_Bln_Byr"><div class="ewTableHeaderCaption"><?php echo $v04_uang_masuk->Per_Thn_Bln_Byr->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Per_Thn_Bln_Byr"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v04_uang_masuk->SortUrl($v04_uang_masuk->Per_Thn_Bln_Byr) ?>',2);"><div id="elh_v04_uang_masuk_Per_Thn_Bln_Byr" class="v04_uang_masuk_Per_Thn_Bln_Byr">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v04_uang_masuk->Per_Thn_Bln_Byr->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($v04_uang_masuk->Per_Thn_Bln_Byr->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v04_uang_masuk->Per_Thn_Bln_Byr->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($v04_uang_masuk->Per_Thn_Bln_Byr_Text->Visible) { // Per_Thn_Bln_Byr_Text ?>
	<?php if ($v04_uang_masuk->SortUrl($v04_uang_masuk->Per_Thn_Bln_Byr_Text) == "") { ?>
		<th data-name="Per_Thn_Bln_Byr_Text"><div id="elh_v04_uang_masuk_Per_Thn_Bln_Byr_Text" class="v04_uang_masuk_Per_Thn_Bln_Byr_Text"><div class="ewTableHeaderCaption"><?php echo $v04_uang_masuk->Per_Thn_Bln_Byr_Text->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Per_Thn_Bln_Byr_Text"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v04_uang_masuk->SortUrl($v04_uang_masuk->Per_Thn_Bln_Byr_Text) ?>',2);"><div id="elh_v04_uang_masuk_Per_Thn_Bln_Byr_Text" class="v04_uang_masuk_Per_Thn_Bln_Byr_Text">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v04_uang_masuk->Per_Thn_Bln_Byr_Text->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($v04_uang_masuk->Per_Thn_Bln_Byr_Text->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v04_uang_masuk->Per_Thn_Bln_Byr_Text->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$v04_uang_masuk_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($v04_uang_masuk->ExportAll && $v04_uang_masuk->Export <> "") {
	$v04_uang_masuk_list->StopRec = $v04_uang_masuk_list->TotalRecs;
} else {

	// Set the last record to display
	if ($v04_uang_masuk_list->TotalRecs > $v04_uang_masuk_list->StartRec + $v04_uang_masuk_list->DisplayRecs - 1)
		$v04_uang_masuk_list->StopRec = $v04_uang_masuk_list->StartRec + $v04_uang_masuk_list->DisplayRecs - 1;
	else
		$v04_uang_masuk_list->StopRec = $v04_uang_masuk_list->TotalRecs;
}
$v04_uang_masuk_list->RecCnt = $v04_uang_masuk_list->StartRec - 1;
if ($v04_uang_masuk_list->Recordset && !$v04_uang_masuk_list->Recordset->EOF) {
	$v04_uang_masuk_list->Recordset->MoveFirst();
	$bSelectLimit = $v04_uang_masuk_list->UseSelectLimit;
	if (!$bSelectLimit && $v04_uang_masuk_list->StartRec > 1)
		$v04_uang_masuk_list->Recordset->Move($v04_uang_masuk_list->StartRec - 1);
} elseif (!$v04_uang_masuk->AllowAddDeleteRow && $v04_uang_masuk_list->StopRec == 0) {
	$v04_uang_masuk_list->StopRec = $v04_uang_masuk->GridAddRowCount;
}

// Initialize aggregate
$v04_uang_masuk->RowType = EW_ROWTYPE_AGGREGATEINIT;
$v04_uang_masuk->ResetAttrs();
$v04_uang_masuk_list->RenderRow();
while ($v04_uang_masuk_list->RecCnt < $v04_uang_masuk_list->StopRec) {
	$v04_uang_masuk_list->RecCnt++;
	if (intval($v04_uang_masuk_list->RecCnt) >= intval($v04_uang_masuk_list->StartRec)) {
		$v04_uang_masuk_list->RowCnt++;

		// Set up key count
		$v04_uang_masuk_list->KeyCount = $v04_uang_masuk_list->RowIndex;

		// Init row class and style
		$v04_uang_masuk->ResetAttrs();
		$v04_uang_masuk->CssClass = "";
		if ($v04_uang_masuk->CurrentAction == "gridadd") {
		} else {
			$v04_uang_masuk_list->LoadRowValues($v04_uang_masuk_list->Recordset); // Load row values
		}
		$v04_uang_masuk->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$v04_uang_masuk->RowAttrs = array_merge($v04_uang_masuk->RowAttrs, array('data-rowindex'=>$v04_uang_masuk_list->RowCnt, 'id'=>'r' . $v04_uang_masuk_list->RowCnt . '_v04_uang_masuk', 'data-rowtype'=>$v04_uang_masuk->RowType));

		// Render row
		$v04_uang_masuk_list->RenderRow();

		// Render list options
		$v04_uang_masuk_list->RenderListOptions();
?>
	<tr<?php echo $v04_uang_masuk->RowAttributes() ?>>
<?php

// Render list options (body, left)
$v04_uang_masuk_list->ListOptions->Render("body", "left", $v04_uang_masuk_list->RowCnt);
?>
	<?php if ($v04_uang_masuk->siswanonrutin_id->Visible) { // siswanonrutin_id ?>
		<td data-name="siswanonrutin_id"<?php echo $v04_uang_masuk->siswanonrutin_id->CellAttributes() ?>>
<span id="el<?php echo $v04_uang_masuk_list->RowCnt ?>_v04_uang_masuk_siswanonrutin_id" class="v04_uang_masuk_siswanonrutin_id">
<span<?php echo $v04_uang_masuk->siswanonrutin_id->ViewAttributes() ?>>
<?php echo $v04_uang_masuk->siswanonrutin_id->ListViewValue() ?></span>
</span>
<a id="<?php echo $v04_uang_masuk_list->PageObjName . "_row_" . $v04_uang_masuk_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($v04_uang_masuk->siswa_id->Visible) { // siswa_id ?>
		<td data-name="siswa_id"<?php echo $v04_uang_masuk->siswa_id->CellAttributes() ?>>
<span id="el<?php echo $v04_uang_masuk_list->RowCnt ?>_v04_uang_masuk_siswa_id" class="v04_uang_masuk_siswa_id">
<span<?php echo $v04_uang_masuk->siswa_id->ViewAttributes() ?>>
<?php echo $v04_uang_masuk->siswa_id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v04_uang_masuk->nonrutin_id->Visible) { // nonrutin_id ?>
		<td data-name="nonrutin_id"<?php echo $v04_uang_masuk->nonrutin_id->CellAttributes() ?>>
<span id="el<?php echo $v04_uang_masuk_list->RowCnt ?>_v04_uang_masuk_nonrutin_id" class="v04_uang_masuk_nonrutin_id">
<span<?php echo $v04_uang_masuk->nonrutin_id->ViewAttributes() ?>>
<?php echo $v04_uang_masuk->nonrutin_id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v04_uang_masuk->sekolah_id->Visible) { // sekolah_id ?>
		<td data-name="sekolah_id"<?php echo $v04_uang_masuk->sekolah_id->CellAttributes() ?>>
<span id="el<?php echo $v04_uang_masuk_list->RowCnt ?>_v04_uang_masuk_sekolah_id" class="v04_uang_masuk_sekolah_id">
<span<?php echo $v04_uang_masuk->sekolah_id->ViewAttributes() ?>>
<?php echo $v04_uang_masuk->sekolah_id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v04_uang_masuk->kelas_id->Visible) { // kelas_id ?>
		<td data-name="kelas_id"<?php echo $v04_uang_masuk->kelas_id->CellAttributes() ?>>
<span id="el<?php echo $v04_uang_masuk_list->RowCnt ?>_v04_uang_masuk_kelas_id" class="v04_uang_masuk_kelas_id">
<span<?php echo $v04_uang_masuk->kelas_id->ViewAttributes() ?>>
<?php echo $v04_uang_masuk->kelas_id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v04_uang_masuk->NIS->Visible) { // NIS ?>
		<td data-name="NIS"<?php echo $v04_uang_masuk->NIS->CellAttributes() ?>>
<span id="el<?php echo $v04_uang_masuk_list->RowCnt ?>_v04_uang_masuk_NIS" class="v04_uang_masuk_NIS">
<span<?php echo $v04_uang_masuk->NIS->ViewAttributes() ?>>
<?php echo $v04_uang_masuk->NIS->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v04_uang_masuk->Nama->Visible) { // Nama ?>
		<td data-name="Nama"<?php echo $v04_uang_masuk->Nama->CellAttributes() ?>>
<span id="el<?php echo $v04_uang_masuk_list->RowCnt ?>_v04_uang_masuk_Nama" class="v04_uang_masuk_Nama">
<span<?php echo $v04_uang_masuk->Nama->ViewAttributes() ?>>
<?php echo $v04_uang_masuk->Nama->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v04_uang_masuk->Jenis->Visible) { // Jenis ?>
		<td data-name="Jenis"<?php echo $v04_uang_masuk->Jenis->CellAttributes() ?>>
<span id="el<?php echo $v04_uang_masuk_list->RowCnt ?>_v04_uang_masuk_Jenis" class="v04_uang_masuk_Jenis">
<span<?php echo $v04_uang_masuk->Jenis->ViewAttributes() ?>>
<?php echo $v04_uang_masuk->Jenis->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v04_uang_masuk->Nilai->Visible) { // Nilai ?>
		<td data-name="Nilai"<?php echo $v04_uang_masuk->Nilai->CellAttributes() ?>>
<span id="el<?php echo $v04_uang_masuk_list->RowCnt ?>_v04_uang_masuk_Nilai" class="v04_uang_masuk_Nilai">
<span<?php echo $v04_uang_masuk->Nilai->ViewAttributes() ?>>
<?php echo $v04_uang_masuk->Nilai->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v04_uang_masuk->Kelas->Visible) { // Kelas ?>
		<td data-name="Kelas"<?php echo $v04_uang_masuk->Kelas->CellAttributes() ?>>
<span id="el<?php echo $v04_uang_masuk_list->RowCnt ?>_v04_uang_masuk_Kelas" class="v04_uang_masuk_Kelas">
<span<?php echo $v04_uang_masuk->Kelas->ViewAttributes() ?>>
<?php echo $v04_uang_masuk->Kelas->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v04_uang_masuk->Sekolah->Visible) { // Sekolah ?>
		<td data-name="Sekolah"<?php echo $v04_uang_masuk->Sekolah->CellAttributes() ?>>
<span id="el<?php echo $v04_uang_masuk_list->RowCnt ?>_v04_uang_masuk_Sekolah" class="v04_uang_masuk_Sekolah">
<span<?php echo $v04_uang_masuk->Sekolah->ViewAttributes() ?>>
<?php echo $v04_uang_masuk->Sekolah->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v04_uang_masuk->Periode_Tahun_Bulan->Visible) { // Periode_Tahun_Bulan ?>
		<td data-name="Periode_Tahun_Bulan"<?php echo $v04_uang_masuk->Periode_Tahun_Bulan->CellAttributes() ?>>
<span id="el<?php echo $v04_uang_masuk_list->RowCnt ?>_v04_uang_masuk_Periode_Tahun_Bulan" class="v04_uang_masuk_Periode_Tahun_Bulan">
<span<?php echo $v04_uang_masuk->Periode_Tahun_Bulan->ViewAttributes() ?>>
<?php echo $v04_uang_masuk->Periode_Tahun_Bulan->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v04_uang_masuk->Periode_Text->Visible) { // Periode_Text ?>
		<td data-name="Periode_Text"<?php echo $v04_uang_masuk->Periode_Text->CellAttributes() ?>>
<span id="el<?php echo $v04_uang_masuk_list->RowCnt ?>_v04_uang_masuk_Periode_Text" class="v04_uang_masuk_Periode_Text">
<span<?php echo $v04_uang_masuk->Periode_Text->ViewAttributes() ?>>
<?php echo $v04_uang_masuk->Periode_Text->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v04_uang_masuk->Bayar->Visible) { // Bayar ?>
		<td data-name="Bayar"<?php echo $v04_uang_masuk->Bayar->CellAttributes() ?>>
<span id="el<?php echo $v04_uang_masuk_list->RowCnt ?>_v04_uang_masuk_Bayar" class="v04_uang_masuk_Bayar">
<span<?php echo $v04_uang_masuk->Bayar->ViewAttributes() ?>>
<?php echo $v04_uang_masuk->Bayar->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v04_uang_masuk->Per_Thn_Bln_Byr->Visible) { // Per_Thn_Bln_Byr ?>
		<td data-name="Per_Thn_Bln_Byr"<?php echo $v04_uang_masuk->Per_Thn_Bln_Byr->CellAttributes() ?>>
<span id="el<?php echo $v04_uang_masuk_list->RowCnt ?>_v04_uang_masuk_Per_Thn_Bln_Byr" class="v04_uang_masuk_Per_Thn_Bln_Byr">
<span<?php echo $v04_uang_masuk->Per_Thn_Bln_Byr->ViewAttributes() ?>>
<?php echo $v04_uang_masuk->Per_Thn_Bln_Byr->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v04_uang_masuk->Per_Thn_Bln_Byr_Text->Visible) { // Per_Thn_Bln_Byr_Text ?>
		<td data-name="Per_Thn_Bln_Byr_Text"<?php echo $v04_uang_masuk->Per_Thn_Bln_Byr_Text->CellAttributes() ?>>
<span id="el<?php echo $v04_uang_masuk_list->RowCnt ?>_v04_uang_masuk_Per_Thn_Bln_Byr_Text" class="v04_uang_masuk_Per_Thn_Bln_Byr_Text">
<span<?php echo $v04_uang_masuk->Per_Thn_Bln_Byr_Text->ViewAttributes() ?>>
<?php echo $v04_uang_masuk->Per_Thn_Bln_Byr_Text->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$v04_uang_masuk_list->ListOptions->Render("body", "right", $v04_uang_masuk_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($v04_uang_masuk->CurrentAction <> "gridadd")
		$v04_uang_masuk_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($v04_uang_masuk->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($v04_uang_masuk_list->Recordset)
	$v04_uang_masuk_list->Recordset->Close();
?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($v04_uang_masuk->CurrentAction <> "gridadd" && $v04_uang_masuk->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($v04_uang_masuk_list->Pager)) $v04_uang_masuk_list->Pager = new cPrevNextPager($v04_uang_masuk_list->StartRec, $v04_uang_masuk_list->DisplayRecs, $v04_uang_masuk_list->TotalRecs) ?>
<?php if ($v04_uang_masuk_list->Pager->RecordCount > 0 && $v04_uang_masuk_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($v04_uang_masuk_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $v04_uang_masuk_list->PageUrl() ?>start=<?php echo $v04_uang_masuk_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($v04_uang_masuk_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $v04_uang_masuk_list->PageUrl() ?>start=<?php echo $v04_uang_masuk_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $v04_uang_masuk_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($v04_uang_masuk_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $v04_uang_masuk_list->PageUrl() ?>start=<?php echo $v04_uang_masuk_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($v04_uang_masuk_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $v04_uang_masuk_list->PageUrl() ?>start=<?php echo $v04_uang_masuk_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $v04_uang_masuk_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $v04_uang_masuk_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $v04_uang_masuk_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $v04_uang_masuk_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($v04_uang_masuk_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($v04_uang_masuk_list->TotalRecs == 0 && $v04_uang_masuk->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($v04_uang_masuk_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
fv04_uang_masuklistsrch.FilterList = <?php echo $v04_uang_masuk_list->GetFilterList() ?>;
fv04_uang_masuklistsrch.Init();
fv04_uang_masuklist.Init();
</script>
<?php
$v04_uang_masuk_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$v04_uang_masuk_list->Page_Terminate();
?>
