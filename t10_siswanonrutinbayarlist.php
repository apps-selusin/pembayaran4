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

$t10_siswanonrutinbayar_list = NULL; // Initialize page object first

class ct10_siswanonrutinbayar_list extends ct10_siswanonrutinbayar {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{64CABE7A-1609-4157-8293-D7242B591905}";

	// Table name
	var $TableName = 't10_siswanonrutinbayar';

	// Page object name
	var $PageObjName = 't10_siswanonrutinbayar_list';

	// Grid form hidden field names
	var $FormName = 'ft10_siswanonrutinbayarlist';
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

		// Table object (t10_siswanonrutinbayar)
		if (!isset($GLOBALS["t10_siswanonrutinbayar"]) || get_class($GLOBALS["t10_siswanonrutinbayar"]) == "ct10_siswanonrutinbayar") {
			$GLOBALS["t10_siswanonrutinbayar"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t10_siswanonrutinbayar"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "t10_siswanonrutinbayaradd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "t10_siswanonrutinbayardelete.php";
		$this->MultiUpdateUrl = "t10_siswanonrutinbayarupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't10_siswanonrutinbayar', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption ft10_siswanonrutinbayarlistsrch";

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
		$this->id->SetVisibility();
		$this->id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->siswanonrutin_id->SetVisibility();
		$this->Bulan->SetVisibility();
		$this->Tahun->SetVisibility();
		$this->Nilai->SetVisibility();
		$this->Tanggal_Bayar->SetVisibility();
		$this->Nilai_Bayar->SetVisibility();
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

			// Set up sorting order
			$this->SetUpSortOrder();
		}

		// Restore display records
		if ($this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

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
		if (count($arrKeyFlds) >= 1) {
			$this->id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->id->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for Ctrl pressed
		$bCtrl = (@$_GET["ctrl"] <> "");

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->id, $bCtrl); // id
			$this->UpdateSort($this->siswanonrutin_id, $bCtrl); // siswanonrutin_id
			$this->UpdateSort($this->Bulan, $bCtrl); // Bulan
			$this->UpdateSort($this->Tahun, $bCtrl); // Tahun
			$this->UpdateSort($this->Nilai, $bCtrl); // Nilai
			$this->UpdateSort($this->Tanggal_Bayar, $bCtrl); // Tanggal_Bayar
			$this->UpdateSort($this->Nilai_Bayar, $bCtrl); // Nilai_Bayar
			$this->UpdateSort($this->Periode_Tahun_Bulan, $bCtrl); // Periode_Tahun_Bulan
			$this->UpdateSort($this->Periode_Text, $bCtrl); // Periode_Text
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

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->id->setSort("");
				$this->siswanonrutin_id->setSort("");
				$this->Bulan->setSort("");
				$this->Tahun->setSort("");
				$this->Nilai->setSort("");
				$this->Tanggal_Bayar->setSort("");
				$this->Nilai_Bayar->setSort("");
				$this->Periode_Tahun_Bulan->setSort("");
				$this->Periode_Text->setSort("");
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

		// "view"
		$item = &$this->ListOptions->Add("view");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = TRUE;
		$item->OnLeft = TRUE;

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

		// "sequence"
		$item = &$this->ListOptions->Add("sequence");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = TRUE;
		$item->OnLeft = TRUE; // Always on left
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

		// "sequence"
		$oListOpt = &$this->ListOptions->Items["sequence"];
		$oListOpt->Body = ew_FormatSeqNo($this->RecCnt);

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		$viewcaption = ew_HtmlTitle($Language->Phrase("ViewLink"));
		if (TRUE) {
			$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

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
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->id->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"ft10_siswanonrutinbayarlistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = FALSE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"ft10_siswanonrutinbayarlistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
		$item->Visible = FALSE;
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.ft10_siswanonrutinbayarlist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$this->siswanonrutin_id->setDbValue($rs->fields('siswanonrutin_id'));
		$this->Bulan->setDbValue($rs->fields('Bulan'));
		$this->Tahun->setDbValue($rs->fields('Tahun'));
		$this->Nilai->setDbValue($rs->fields('Nilai'));
		$this->Tanggal_Bayar->setDbValue($rs->fields('Tanggal_Bayar'));
		$this->Nilai_Bayar->setDbValue($rs->fields('Nilai_Bayar'));
		$this->Periode_Tahun_Bulan->setDbValue($rs->fields('Periode_Tahun_Bulan'));
		$this->Periode_Text->setDbValue($rs->fields('Periode_Text'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->siswanonrutin_id->DbValue = $row['siswanonrutin_id'];
		$this->Bulan->DbValue = $row['Bulan'];
		$this->Tahun->DbValue = $row['Tahun'];
		$this->Nilai->DbValue = $row['Nilai'];
		$this->Tanggal_Bayar->DbValue = $row['Tanggal_Bayar'];
		$this->Nilai_Bayar->DbValue = $row['Nilai_Bayar'];
		$this->Periode_Tahun_Bulan->DbValue = $row['Periode_Tahun_Bulan'];
		$this->Periode_Text->DbValue = $row['Periode_Text'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("id")) <> "")
			$this->id->CurrentValue = $this->getKey("id"); // id
		else
			$bValidKey = FALSE;

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
		if ($this->Nilai_Bayar->FormValue == $this->Nilai_Bayar->CurrentValue && is_numeric(ew_StrToFloat($this->Nilai_Bayar->CurrentValue)))
			$this->Nilai_Bayar->CurrentValue = ew_StrToFloat($this->Nilai_Bayar->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// siswanonrutin_id
		// Bulan
		// Tahun
		// Nilai
		// Tanggal_Bayar
		// Nilai_Bayar
		// Periode_Tahun_Bulan
		// Periode_Text

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// siswanonrutin_id
		$this->siswanonrutin_id->ViewValue = $this->siswanonrutin_id->CurrentValue;
		$this->siswanonrutin_id->ViewCustomAttributes = "";

		// Bulan
		$this->Bulan->ViewValue = $this->Bulan->CurrentValue;
		$this->Bulan->ViewCustomAttributes = "";

		// Tahun
		$this->Tahun->ViewValue = $this->Tahun->CurrentValue;
		$this->Tahun->ViewCustomAttributes = "";

		// Nilai
		$this->Nilai->ViewValue = $this->Nilai->CurrentValue;
		$this->Nilai->ViewCustomAttributes = "";

		// Tanggal_Bayar
		$this->Tanggal_Bayar->ViewValue = $this->Tanggal_Bayar->CurrentValue;
		$this->Tanggal_Bayar->ViewValue = ew_FormatDateTime($this->Tanggal_Bayar->ViewValue, 0);
		$this->Tanggal_Bayar->ViewCustomAttributes = "";

		// Nilai_Bayar
		$this->Nilai_Bayar->ViewValue = $this->Nilai_Bayar->CurrentValue;
		$this->Nilai_Bayar->ViewCustomAttributes = "";

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

			// Bulan
			$this->Bulan->LinkCustomAttributes = "";
			$this->Bulan->HrefValue = "";
			$this->Bulan->TooltipValue = "";

			// Tahun
			$this->Tahun->LinkCustomAttributes = "";
			$this->Tahun->HrefValue = "";
			$this->Tahun->TooltipValue = "";

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
if (!isset($t10_siswanonrutinbayar_list)) $t10_siswanonrutinbayar_list = new ct10_siswanonrutinbayar_list();

// Page init
$t10_siswanonrutinbayar_list->Page_Init();

// Page main
$t10_siswanonrutinbayar_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t10_siswanonrutinbayar_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = ft10_siswanonrutinbayarlist = new ew_Form("ft10_siswanonrutinbayarlist", "list");
ft10_siswanonrutinbayarlist.FormKeyCountName = '<?php echo $t10_siswanonrutinbayar_list->FormKeyCountName ?>';

// Form_CustomValidate event
ft10_siswanonrutinbayarlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft10_siswanonrutinbayarlist.ValidateRequired = true;
<?php } else { ?>
ft10_siswanonrutinbayarlist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php if ($t10_siswanonrutinbayar_list->TotalRecs > 0 && $t10_siswanonrutinbayar_list->ExportOptions->Visible()) { ?>
<?php $t10_siswanonrutinbayar_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php
	$bSelectLimit = $t10_siswanonrutinbayar_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($t10_siswanonrutinbayar_list->TotalRecs <= 0)
			$t10_siswanonrutinbayar_list->TotalRecs = $t10_siswanonrutinbayar->SelectRecordCount();
	} else {
		if (!$t10_siswanonrutinbayar_list->Recordset && ($t10_siswanonrutinbayar_list->Recordset = $t10_siswanonrutinbayar_list->LoadRecordset()))
			$t10_siswanonrutinbayar_list->TotalRecs = $t10_siswanonrutinbayar_list->Recordset->RecordCount();
	}
	$t10_siswanonrutinbayar_list->StartRec = 1;
	if ($t10_siswanonrutinbayar_list->DisplayRecs <= 0 || ($t10_siswanonrutinbayar->Export <> "" && $t10_siswanonrutinbayar->ExportAll)) // Display all records
		$t10_siswanonrutinbayar_list->DisplayRecs = $t10_siswanonrutinbayar_list->TotalRecs;
	if (!($t10_siswanonrutinbayar->Export <> "" && $t10_siswanonrutinbayar->ExportAll))
		$t10_siswanonrutinbayar_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$t10_siswanonrutinbayar_list->Recordset = $t10_siswanonrutinbayar_list->LoadRecordset($t10_siswanonrutinbayar_list->StartRec-1, $t10_siswanonrutinbayar_list->DisplayRecs);

	// Set no record found message
	if ($t10_siswanonrutinbayar->CurrentAction == "" && $t10_siswanonrutinbayar_list->TotalRecs == 0) {
		if ($t10_siswanonrutinbayar_list->SearchWhere == "0=101")
			$t10_siswanonrutinbayar_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$t10_siswanonrutinbayar_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$t10_siswanonrutinbayar_list->RenderOtherOptions();
?>
<?php $t10_siswanonrutinbayar_list->ShowPageHeader(); ?>
<?php
$t10_siswanonrutinbayar_list->ShowMessage();
?>
<?php if ($t10_siswanonrutinbayar_list->TotalRecs > 0 || $t10_siswanonrutinbayar->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid t10_siswanonrutinbayar">
<form name="ft10_siswanonrutinbayarlist" id="ft10_siswanonrutinbayarlist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t10_siswanonrutinbayar_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t10_siswanonrutinbayar_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t10_siswanonrutinbayar">
<div id="gmp_t10_siswanonrutinbayar" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($t10_siswanonrutinbayar_list->TotalRecs > 0 || $t10_siswanonrutinbayar->CurrentAction == "gridedit") { ?>
<table id="tbl_t10_siswanonrutinbayarlist" class="table ewTable">
<?php echo $t10_siswanonrutinbayar->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$t10_siswanonrutinbayar_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$t10_siswanonrutinbayar_list->RenderListOptions();

// Render list options (header, left)
$t10_siswanonrutinbayar_list->ListOptions->Render("header", "left");
?>
<?php if ($t10_siswanonrutinbayar->id->Visible) { // id ?>
	<?php if ($t10_siswanonrutinbayar->SortUrl($t10_siswanonrutinbayar->id) == "") { ?>
		<th data-name="id"><div id="elh_t10_siswanonrutinbayar_id" class="t10_siswanonrutinbayar_id"><div class="ewTableHeaderCaption"><?php echo $t10_siswanonrutinbayar->id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t10_siswanonrutinbayar->SortUrl($t10_siswanonrutinbayar->id) ?>',2);"><div id="elh_t10_siswanonrutinbayar_id" class="t10_siswanonrutinbayar_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t10_siswanonrutinbayar->id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t10_siswanonrutinbayar->id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t10_siswanonrutinbayar->id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t10_siswanonrutinbayar->siswanonrutin_id->Visible) { // siswanonrutin_id ?>
	<?php if ($t10_siswanonrutinbayar->SortUrl($t10_siswanonrutinbayar->siswanonrutin_id) == "") { ?>
		<th data-name="siswanonrutin_id"><div id="elh_t10_siswanonrutinbayar_siswanonrutin_id" class="t10_siswanonrutinbayar_siswanonrutin_id"><div class="ewTableHeaderCaption"><?php echo $t10_siswanonrutinbayar->siswanonrutin_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="siswanonrutin_id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t10_siswanonrutinbayar->SortUrl($t10_siswanonrutinbayar->siswanonrutin_id) ?>',2);"><div id="elh_t10_siswanonrutinbayar_siswanonrutin_id" class="t10_siswanonrutinbayar_siswanonrutin_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t10_siswanonrutinbayar->siswanonrutin_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t10_siswanonrutinbayar->siswanonrutin_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t10_siswanonrutinbayar->siswanonrutin_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t10_siswanonrutinbayar->Bulan->Visible) { // Bulan ?>
	<?php if ($t10_siswanonrutinbayar->SortUrl($t10_siswanonrutinbayar->Bulan) == "") { ?>
		<th data-name="Bulan"><div id="elh_t10_siswanonrutinbayar_Bulan" class="t10_siswanonrutinbayar_Bulan"><div class="ewTableHeaderCaption"><?php echo $t10_siswanonrutinbayar->Bulan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Bulan"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t10_siswanonrutinbayar->SortUrl($t10_siswanonrutinbayar->Bulan) ?>',2);"><div id="elh_t10_siswanonrutinbayar_Bulan" class="t10_siswanonrutinbayar_Bulan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t10_siswanonrutinbayar->Bulan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t10_siswanonrutinbayar->Bulan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t10_siswanonrutinbayar->Bulan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t10_siswanonrutinbayar->Tahun->Visible) { // Tahun ?>
	<?php if ($t10_siswanonrutinbayar->SortUrl($t10_siswanonrutinbayar->Tahun) == "") { ?>
		<th data-name="Tahun"><div id="elh_t10_siswanonrutinbayar_Tahun" class="t10_siswanonrutinbayar_Tahun"><div class="ewTableHeaderCaption"><?php echo $t10_siswanonrutinbayar->Tahun->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Tahun"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t10_siswanonrutinbayar->SortUrl($t10_siswanonrutinbayar->Tahun) ?>',2);"><div id="elh_t10_siswanonrutinbayar_Tahun" class="t10_siswanonrutinbayar_Tahun">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t10_siswanonrutinbayar->Tahun->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t10_siswanonrutinbayar->Tahun->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t10_siswanonrutinbayar->Tahun->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t10_siswanonrutinbayar->Nilai->Visible) { // Nilai ?>
	<?php if ($t10_siswanonrutinbayar->SortUrl($t10_siswanonrutinbayar->Nilai) == "") { ?>
		<th data-name="Nilai"><div id="elh_t10_siswanonrutinbayar_Nilai" class="t10_siswanonrutinbayar_Nilai"><div class="ewTableHeaderCaption"><?php echo $t10_siswanonrutinbayar->Nilai->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nilai"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t10_siswanonrutinbayar->SortUrl($t10_siswanonrutinbayar->Nilai) ?>',2);"><div id="elh_t10_siswanonrutinbayar_Nilai" class="t10_siswanonrutinbayar_Nilai">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t10_siswanonrutinbayar->Nilai->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t10_siswanonrutinbayar->Nilai->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t10_siswanonrutinbayar->Nilai->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t10_siswanonrutinbayar->Tanggal_Bayar->Visible) { // Tanggal_Bayar ?>
	<?php if ($t10_siswanonrutinbayar->SortUrl($t10_siswanonrutinbayar->Tanggal_Bayar) == "") { ?>
		<th data-name="Tanggal_Bayar"><div id="elh_t10_siswanonrutinbayar_Tanggal_Bayar" class="t10_siswanonrutinbayar_Tanggal_Bayar"><div class="ewTableHeaderCaption"><?php echo $t10_siswanonrutinbayar->Tanggal_Bayar->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Tanggal_Bayar"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t10_siswanonrutinbayar->SortUrl($t10_siswanonrutinbayar->Tanggal_Bayar) ?>',2);"><div id="elh_t10_siswanonrutinbayar_Tanggal_Bayar" class="t10_siswanonrutinbayar_Tanggal_Bayar">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t10_siswanonrutinbayar->Tanggal_Bayar->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t10_siswanonrutinbayar->Tanggal_Bayar->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t10_siswanonrutinbayar->Tanggal_Bayar->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t10_siswanonrutinbayar->Nilai_Bayar->Visible) { // Nilai_Bayar ?>
	<?php if ($t10_siswanonrutinbayar->SortUrl($t10_siswanonrutinbayar->Nilai_Bayar) == "") { ?>
		<th data-name="Nilai_Bayar"><div id="elh_t10_siswanonrutinbayar_Nilai_Bayar" class="t10_siswanonrutinbayar_Nilai_Bayar"><div class="ewTableHeaderCaption"><?php echo $t10_siswanonrutinbayar->Nilai_Bayar->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nilai_Bayar"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t10_siswanonrutinbayar->SortUrl($t10_siswanonrutinbayar->Nilai_Bayar) ?>',2);"><div id="elh_t10_siswanonrutinbayar_Nilai_Bayar" class="t10_siswanonrutinbayar_Nilai_Bayar">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t10_siswanonrutinbayar->Nilai_Bayar->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t10_siswanonrutinbayar->Nilai_Bayar->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t10_siswanonrutinbayar->Nilai_Bayar->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t10_siswanonrutinbayar->Periode_Tahun_Bulan->Visible) { // Periode_Tahun_Bulan ?>
	<?php if ($t10_siswanonrutinbayar->SortUrl($t10_siswanonrutinbayar->Periode_Tahun_Bulan) == "") { ?>
		<th data-name="Periode_Tahun_Bulan"><div id="elh_t10_siswanonrutinbayar_Periode_Tahun_Bulan" class="t10_siswanonrutinbayar_Periode_Tahun_Bulan"><div class="ewTableHeaderCaption"><?php echo $t10_siswanonrutinbayar->Periode_Tahun_Bulan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Periode_Tahun_Bulan"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t10_siswanonrutinbayar->SortUrl($t10_siswanonrutinbayar->Periode_Tahun_Bulan) ?>',2);"><div id="elh_t10_siswanonrutinbayar_Periode_Tahun_Bulan" class="t10_siswanonrutinbayar_Periode_Tahun_Bulan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t10_siswanonrutinbayar->Periode_Tahun_Bulan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t10_siswanonrutinbayar->Periode_Tahun_Bulan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t10_siswanonrutinbayar->Periode_Tahun_Bulan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t10_siswanonrutinbayar->Periode_Text->Visible) { // Periode_Text ?>
	<?php if ($t10_siswanonrutinbayar->SortUrl($t10_siswanonrutinbayar->Periode_Text) == "") { ?>
		<th data-name="Periode_Text"><div id="elh_t10_siswanonrutinbayar_Periode_Text" class="t10_siswanonrutinbayar_Periode_Text"><div class="ewTableHeaderCaption"><?php echo $t10_siswanonrutinbayar->Periode_Text->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Periode_Text"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t10_siswanonrutinbayar->SortUrl($t10_siswanonrutinbayar->Periode_Text) ?>',2);"><div id="elh_t10_siswanonrutinbayar_Periode_Text" class="t10_siswanonrutinbayar_Periode_Text">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t10_siswanonrutinbayar->Periode_Text->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t10_siswanonrutinbayar->Periode_Text->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t10_siswanonrutinbayar->Periode_Text->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$t10_siswanonrutinbayar_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($t10_siswanonrutinbayar->ExportAll && $t10_siswanonrutinbayar->Export <> "") {
	$t10_siswanonrutinbayar_list->StopRec = $t10_siswanonrutinbayar_list->TotalRecs;
} else {

	// Set the last record to display
	if ($t10_siswanonrutinbayar_list->TotalRecs > $t10_siswanonrutinbayar_list->StartRec + $t10_siswanonrutinbayar_list->DisplayRecs - 1)
		$t10_siswanonrutinbayar_list->StopRec = $t10_siswanonrutinbayar_list->StartRec + $t10_siswanonrutinbayar_list->DisplayRecs - 1;
	else
		$t10_siswanonrutinbayar_list->StopRec = $t10_siswanonrutinbayar_list->TotalRecs;
}
$t10_siswanonrutinbayar_list->RecCnt = $t10_siswanonrutinbayar_list->StartRec - 1;
if ($t10_siswanonrutinbayar_list->Recordset && !$t10_siswanonrutinbayar_list->Recordset->EOF) {
	$t10_siswanonrutinbayar_list->Recordset->MoveFirst();
	$bSelectLimit = $t10_siswanonrutinbayar_list->UseSelectLimit;
	if (!$bSelectLimit && $t10_siswanonrutinbayar_list->StartRec > 1)
		$t10_siswanonrutinbayar_list->Recordset->Move($t10_siswanonrutinbayar_list->StartRec - 1);
} elseif (!$t10_siswanonrutinbayar->AllowAddDeleteRow && $t10_siswanonrutinbayar_list->StopRec == 0) {
	$t10_siswanonrutinbayar_list->StopRec = $t10_siswanonrutinbayar->GridAddRowCount;
}

// Initialize aggregate
$t10_siswanonrutinbayar->RowType = EW_ROWTYPE_AGGREGATEINIT;
$t10_siswanonrutinbayar->ResetAttrs();
$t10_siswanonrutinbayar_list->RenderRow();
while ($t10_siswanonrutinbayar_list->RecCnt < $t10_siswanonrutinbayar_list->StopRec) {
	$t10_siswanonrutinbayar_list->RecCnt++;
	if (intval($t10_siswanonrutinbayar_list->RecCnt) >= intval($t10_siswanonrutinbayar_list->StartRec)) {
		$t10_siswanonrutinbayar_list->RowCnt++;

		// Set up key count
		$t10_siswanonrutinbayar_list->KeyCount = $t10_siswanonrutinbayar_list->RowIndex;

		// Init row class and style
		$t10_siswanonrutinbayar->ResetAttrs();
		$t10_siswanonrutinbayar->CssClass = "";
		if ($t10_siswanonrutinbayar->CurrentAction == "gridadd") {
		} else {
			$t10_siswanonrutinbayar_list->LoadRowValues($t10_siswanonrutinbayar_list->Recordset); // Load row values
		}
		$t10_siswanonrutinbayar->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$t10_siswanonrutinbayar->RowAttrs = array_merge($t10_siswanonrutinbayar->RowAttrs, array('data-rowindex'=>$t10_siswanonrutinbayar_list->RowCnt, 'id'=>'r' . $t10_siswanonrutinbayar_list->RowCnt . '_t10_siswanonrutinbayar', 'data-rowtype'=>$t10_siswanonrutinbayar->RowType));

		// Render row
		$t10_siswanonrutinbayar_list->RenderRow();

		// Render list options
		$t10_siswanonrutinbayar_list->RenderListOptions();
?>
	<tr<?php echo $t10_siswanonrutinbayar->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t10_siswanonrutinbayar_list->ListOptions->Render("body", "left", $t10_siswanonrutinbayar_list->RowCnt);
?>
	<?php if ($t10_siswanonrutinbayar->id->Visible) { // id ?>
		<td data-name="id"<?php echo $t10_siswanonrutinbayar->id->CellAttributes() ?>>
<span id="el<?php echo $t10_siswanonrutinbayar_list->RowCnt ?>_t10_siswanonrutinbayar_id" class="t10_siswanonrutinbayar_id">
<span<?php echo $t10_siswanonrutinbayar->id->ViewAttributes() ?>>
<?php echo $t10_siswanonrutinbayar->id->ListViewValue() ?></span>
</span>
<a id="<?php echo $t10_siswanonrutinbayar_list->PageObjName . "_row_" . $t10_siswanonrutinbayar_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($t10_siswanonrutinbayar->siswanonrutin_id->Visible) { // siswanonrutin_id ?>
		<td data-name="siswanonrutin_id"<?php echo $t10_siswanonrutinbayar->siswanonrutin_id->CellAttributes() ?>>
<span id="el<?php echo $t10_siswanonrutinbayar_list->RowCnt ?>_t10_siswanonrutinbayar_siswanonrutin_id" class="t10_siswanonrutinbayar_siswanonrutin_id">
<span<?php echo $t10_siswanonrutinbayar->siswanonrutin_id->ViewAttributes() ?>>
<?php echo $t10_siswanonrutinbayar->siswanonrutin_id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t10_siswanonrutinbayar->Bulan->Visible) { // Bulan ?>
		<td data-name="Bulan"<?php echo $t10_siswanonrutinbayar->Bulan->CellAttributes() ?>>
<span id="el<?php echo $t10_siswanonrutinbayar_list->RowCnt ?>_t10_siswanonrutinbayar_Bulan" class="t10_siswanonrutinbayar_Bulan">
<span<?php echo $t10_siswanonrutinbayar->Bulan->ViewAttributes() ?>>
<?php echo $t10_siswanonrutinbayar->Bulan->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t10_siswanonrutinbayar->Tahun->Visible) { // Tahun ?>
		<td data-name="Tahun"<?php echo $t10_siswanonrutinbayar->Tahun->CellAttributes() ?>>
<span id="el<?php echo $t10_siswanonrutinbayar_list->RowCnt ?>_t10_siswanonrutinbayar_Tahun" class="t10_siswanonrutinbayar_Tahun">
<span<?php echo $t10_siswanonrutinbayar->Tahun->ViewAttributes() ?>>
<?php echo $t10_siswanonrutinbayar->Tahun->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t10_siswanonrutinbayar->Nilai->Visible) { // Nilai ?>
		<td data-name="Nilai"<?php echo $t10_siswanonrutinbayar->Nilai->CellAttributes() ?>>
<span id="el<?php echo $t10_siswanonrutinbayar_list->RowCnt ?>_t10_siswanonrutinbayar_Nilai" class="t10_siswanonrutinbayar_Nilai">
<span<?php echo $t10_siswanonrutinbayar->Nilai->ViewAttributes() ?>>
<?php echo $t10_siswanonrutinbayar->Nilai->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t10_siswanonrutinbayar->Tanggal_Bayar->Visible) { // Tanggal_Bayar ?>
		<td data-name="Tanggal_Bayar"<?php echo $t10_siswanonrutinbayar->Tanggal_Bayar->CellAttributes() ?>>
<span id="el<?php echo $t10_siswanonrutinbayar_list->RowCnt ?>_t10_siswanonrutinbayar_Tanggal_Bayar" class="t10_siswanonrutinbayar_Tanggal_Bayar">
<span<?php echo $t10_siswanonrutinbayar->Tanggal_Bayar->ViewAttributes() ?>>
<?php echo $t10_siswanonrutinbayar->Tanggal_Bayar->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t10_siswanonrutinbayar->Nilai_Bayar->Visible) { // Nilai_Bayar ?>
		<td data-name="Nilai_Bayar"<?php echo $t10_siswanonrutinbayar->Nilai_Bayar->CellAttributes() ?>>
<span id="el<?php echo $t10_siswanonrutinbayar_list->RowCnt ?>_t10_siswanonrutinbayar_Nilai_Bayar" class="t10_siswanonrutinbayar_Nilai_Bayar">
<span<?php echo $t10_siswanonrutinbayar->Nilai_Bayar->ViewAttributes() ?>>
<?php echo $t10_siswanonrutinbayar->Nilai_Bayar->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t10_siswanonrutinbayar->Periode_Tahun_Bulan->Visible) { // Periode_Tahun_Bulan ?>
		<td data-name="Periode_Tahun_Bulan"<?php echo $t10_siswanonrutinbayar->Periode_Tahun_Bulan->CellAttributes() ?>>
<span id="el<?php echo $t10_siswanonrutinbayar_list->RowCnt ?>_t10_siswanonrutinbayar_Periode_Tahun_Bulan" class="t10_siswanonrutinbayar_Periode_Tahun_Bulan">
<span<?php echo $t10_siswanonrutinbayar->Periode_Tahun_Bulan->ViewAttributes() ?>>
<?php echo $t10_siswanonrutinbayar->Periode_Tahun_Bulan->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t10_siswanonrutinbayar->Periode_Text->Visible) { // Periode_Text ?>
		<td data-name="Periode_Text"<?php echo $t10_siswanonrutinbayar->Periode_Text->CellAttributes() ?>>
<span id="el<?php echo $t10_siswanonrutinbayar_list->RowCnt ?>_t10_siswanonrutinbayar_Periode_Text" class="t10_siswanonrutinbayar_Periode_Text">
<span<?php echo $t10_siswanonrutinbayar->Periode_Text->ViewAttributes() ?>>
<?php echo $t10_siswanonrutinbayar->Periode_Text->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t10_siswanonrutinbayar_list->ListOptions->Render("body", "right", $t10_siswanonrutinbayar_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($t10_siswanonrutinbayar->CurrentAction <> "gridadd")
		$t10_siswanonrutinbayar_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($t10_siswanonrutinbayar->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($t10_siswanonrutinbayar_list->Recordset)
	$t10_siswanonrutinbayar_list->Recordset->Close();
?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($t10_siswanonrutinbayar->CurrentAction <> "gridadd" && $t10_siswanonrutinbayar->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($t10_siswanonrutinbayar_list->Pager)) $t10_siswanonrutinbayar_list->Pager = new cPrevNextPager($t10_siswanonrutinbayar_list->StartRec, $t10_siswanonrutinbayar_list->DisplayRecs, $t10_siswanonrutinbayar_list->TotalRecs) ?>
<?php if ($t10_siswanonrutinbayar_list->Pager->RecordCount > 0 && $t10_siswanonrutinbayar_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($t10_siswanonrutinbayar_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $t10_siswanonrutinbayar_list->PageUrl() ?>start=<?php echo $t10_siswanonrutinbayar_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($t10_siswanonrutinbayar_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $t10_siswanonrutinbayar_list->PageUrl() ?>start=<?php echo $t10_siswanonrutinbayar_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $t10_siswanonrutinbayar_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($t10_siswanonrutinbayar_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $t10_siswanonrutinbayar_list->PageUrl() ?>start=<?php echo $t10_siswanonrutinbayar_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($t10_siswanonrutinbayar_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $t10_siswanonrutinbayar_list->PageUrl() ?>start=<?php echo $t10_siswanonrutinbayar_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $t10_siswanonrutinbayar_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $t10_siswanonrutinbayar_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $t10_siswanonrutinbayar_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $t10_siswanonrutinbayar_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t10_siswanonrutinbayar_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($t10_siswanonrutinbayar_list->TotalRecs == 0 && $t10_siswanonrutinbayar->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t10_siswanonrutinbayar_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
ft10_siswanonrutinbayarlist.Init();
</script>
<?php
$t10_siswanonrutinbayar_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t10_siswanonrutinbayar_list->Page_Terminate();
?>
