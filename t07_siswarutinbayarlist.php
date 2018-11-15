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

$t07_siswarutinbayar_list = NULL; // Initialize page object first

class ct07_siswarutinbayar_list extends ct07_siswarutinbayar {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{64CABE7A-1609-4157-8293-D7242B591905}";

	// Table name
	var $TableName = 't07_siswarutinbayar';

	// Page object name
	var $PageObjName = 't07_siswarutinbayar_list';

	// Grid form hidden field names
	var $FormName = 'ft07_siswarutinbayarlist';
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

		// Table object (t07_siswarutinbayar)
		if (!isset($GLOBALS["t07_siswarutinbayar"]) || get_class($GLOBALS["t07_siswarutinbayar"]) == "ct07_siswarutinbayar") {
			$GLOBALS["t07_siswarutinbayar"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t07_siswarutinbayar"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "t07_siswarutinbayaradd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "t07_siswarutinbayardelete.php";
		$this->MultiUpdateUrl = "t07_siswarutinbayarupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't07_siswarutinbayar', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption ft07_siswarutinbayarlistsrch";

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
		$this->siswarutin_id->SetVisibility();
		$this->Periode_Tahun_Bulan->SetVisibility();
		$this->Nilai->SetVisibility();
		$this->Tanggal_Bayar->SetVisibility();
		$this->Nilai_Bayar->SetVisibility();
		$this->Bulan->SetVisibility();
		$this->Tahun->SetVisibility();
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
			$this->UpdateSort($this->siswarutin_id, $bCtrl); // siswarutin_id
			$this->UpdateSort($this->Periode_Tahun_Bulan, $bCtrl); // Periode_Tahun_Bulan
			$this->UpdateSort($this->Nilai, $bCtrl); // Nilai
			$this->UpdateSort($this->Tanggal_Bayar, $bCtrl); // Tanggal_Bayar
			$this->UpdateSort($this->Nilai_Bayar, $bCtrl); // Nilai_Bayar
			$this->UpdateSort($this->Bulan, $bCtrl); // Bulan
			$this->UpdateSort($this->Tahun, $bCtrl); // Tahun
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
				$this->siswarutin_id->setSort("");
				$this->Periode_Tahun_Bulan->setSort("");
				$this->Nilai->setSort("");
				$this->Tanggal_Bayar->setSort("");
				$this->Nilai_Bayar->setSort("");
				$this->Bulan->setSort("");
				$this->Tahun->setSort("");
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"ft07_siswarutinbayarlistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = FALSE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"ft07_siswarutinbayarlistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.ft07_siswarutinbayarlist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$this->siswarutin_id->setDbValue($rs->fields('siswarutin_id'));
		$this->Periode_Tahun_Bulan->setDbValue($rs->fields('Periode_Tahun_Bulan'));
		$this->Nilai->setDbValue($rs->fields('Nilai'));
		$this->Tanggal_Bayar->setDbValue($rs->fields('Tanggal_Bayar'));
		$this->Nilai_Bayar->setDbValue($rs->fields('Nilai_Bayar'));
		$this->Bulan->setDbValue($rs->fields('Bulan'));
		$this->Tahun->setDbValue($rs->fields('Tahun'));
		$this->Periode_Text->setDbValue($rs->fields('Periode_Text'));
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
		// siswarutin_id
		// Periode_Tahun_Bulan
		// Nilai
		// Tanggal_Bayar
		// Nilai_Bayar
		// Bulan
		// Tahun
		// Periode_Text

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
		//if (isset($_GET[EW_TABLE_SHOW_MASTER]) == "t06_siswarutin") {

		$this->siswarutin_id->Visible = false;
		$this->Bulan->Visible = false;
		$this->Tahun->Visible = false;
		$this->Periode_Text->Visible = false;

		//}
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
if (!isset($t07_siswarutinbayar_list)) $t07_siswarutinbayar_list = new ct07_siswarutinbayar_list();

// Page init
$t07_siswarutinbayar_list->Page_Init();

// Page main
$t07_siswarutinbayar_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t07_siswarutinbayar_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = ft07_siswarutinbayarlist = new ew_Form("ft07_siswarutinbayarlist", "list");
ft07_siswarutinbayarlist.FormKeyCountName = '<?php echo $t07_siswarutinbayar_list->FormKeyCountName ?>';

// Form_CustomValidate event
ft07_siswarutinbayarlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft07_siswarutinbayarlist.ValidateRequired = true;
<?php } else { ?>
ft07_siswarutinbayarlist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft07_siswarutinbayarlist.Lists["x_Periode_Tahun_Bulan"] = {"LinkField":"x_Periode_Tahun_Bulan","Ajax":true,"AutoFill":false,"DisplayFields":["x_Periode_Text","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t07_siswarutinbayar"};
ft07_siswarutinbayarlist.Lists["x_Bulan"] = {"LinkField":"x_Bulan","Ajax":true,"AutoFill":false,"DisplayFields":["x_Bulan","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t07_siswarutinbayar"};
ft07_siswarutinbayarlist.Lists["x_Tahun"] = {"LinkField":"x_Tahun","Ajax":true,"AutoFill":false,"DisplayFields":["x_Tahun","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t07_siswarutinbayar"};
ft07_siswarutinbayarlist.Lists["x_Periode_Text"] = {"LinkField":"x_Periode_Text","Ajax":true,"AutoFill":false,"DisplayFields":["x_Periode_Text","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t07_siswarutinbayar"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php if ($t07_siswarutinbayar_list->TotalRecs > 0 && $t07_siswarutinbayar_list->ExportOptions->Visible()) { ?>
<?php $t07_siswarutinbayar_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php
	$bSelectLimit = $t07_siswarutinbayar_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($t07_siswarutinbayar_list->TotalRecs <= 0)
			$t07_siswarutinbayar_list->TotalRecs = $t07_siswarutinbayar->SelectRecordCount();
	} else {
		if (!$t07_siswarutinbayar_list->Recordset && ($t07_siswarutinbayar_list->Recordset = $t07_siswarutinbayar_list->LoadRecordset()))
			$t07_siswarutinbayar_list->TotalRecs = $t07_siswarutinbayar_list->Recordset->RecordCount();
	}
	$t07_siswarutinbayar_list->StartRec = 1;
	if ($t07_siswarutinbayar_list->DisplayRecs <= 0 || ($t07_siswarutinbayar->Export <> "" && $t07_siswarutinbayar->ExportAll)) // Display all records
		$t07_siswarutinbayar_list->DisplayRecs = $t07_siswarutinbayar_list->TotalRecs;
	if (!($t07_siswarutinbayar->Export <> "" && $t07_siswarutinbayar->ExportAll))
		$t07_siswarutinbayar_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$t07_siswarutinbayar_list->Recordset = $t07_siswarutinbayar_list->LoadRecordset($t07_siswarutinbayar_list->StartRec-1, $t07_siswarutinbayar_list->DisplayRecs);

	// Set no record found message
	if ($t07_siswarutinbayar->CurrentAction == "" && $t07_siswarutinbayar_list->TotalRecs == 0) {
		if ($t07_siswarutinbayar_list->SearchWhere == "0=101")
			$t07_siswarutinbayar_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$t07_siswarutinbayar_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$t07_siswarutinbayar_list->RenderOtherOptions();
?>
<?php $t07_siswarutinbayar_list->ShowPageHeader(); ?>
<?php
$t07_siswarutinbayar_list->ShowMessage();
?>
<?php if ($t07_siswarutinbayar_list->TotalRecs > 0 || $t07_siswarutinbayar->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid t07_siswarutinbayar">
<form name="ft07_siswarutinbayarlist" id="ft07_siswarutinbayarlist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t07_siswarutinbayar_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t07_siswarutinbayar_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t07_siswarutinbayar">
<div id="gmp_t07_siswarutinbayar" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($t07_siswarutinbayar_list->TotalRecs > 0 || $t07_siswarutinbayar->CurrentAction == "gridedit") { ?>
<table id="tbl_t07_siswarutinbayarlist" class="table ewTable">
<?php echo $t07_siswarutinbayar->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$t07_siswarutinbayar_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$t07_siswarutinbayar_list->RenderListOptions();

// Render list options (header, left)
$t07_siswarutinbayar_list->ListOptions->Render("header", "left");
?>
<?php if ($t07_siswarutinbayar->siswarutin_id->Visible) { // siswarutin_id ?>
	<?php if ($t07_siswarutinbayar->SortUrl($t07_siswarutinbayar->siswarutin_id) == "") { ?>
		<th data-name="siswarutin_id"><div id="elh_t07_siswarutinbayar_siswarutin_id" class="t07_siswarutinbayar_siswarutin_id"><div class="ewTableHeaderCaption"><?php echo $t07_siswarutinbayar->siswarutin_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="siswarutin_id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t07_siswarutinbayar->SortUrl($t07_siswarutinbayar->siswarutin_id) ?>',2);"><div id="elh_t07_siswarutinbayar_siswarutin_id" class="t07_siswarutinbayar_siswarutin_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t07_siswarutinbayar->siswarutin_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t07_siswarutinbayar->siswarutin_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t07_siswarutinbayar->siswarutin_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t07_siswarutinbayar->Periode_Tahun_Bulan->Visible) { // Periode_Tahun_Bulan ?>
	<?php if ($t07_siswarutinbayar->SortUrl($t07_siswarutinbayar->Periode_Tahun_Bulan) == "") { ?>
		<th data-name="Periode_Tahun_Bulan"><div id="elh_t07_siswarutinbayar_Periode_Tahun_Bulan" class="t07_siswarutinbayar_Periode_Tahun_Bulan"><div class="ewTableHeaderCaption"><?php echo $t07_siswarutinbayar->Periode_Tahun_Bulan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Periode_Tahun_Bulan"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t07_siswarutinbayar->SortUrl($t07_siswarutinbayar->Periode_Tahun_Bulan) ?>',2);"><div id="elh_t07_siswarutinbayar_Periode_Tahun_Bulan" class="t07_siswarutinbayar_Periode_Tahun_Bulan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t07_siswarutinbayar->Periode_Tahun_Bulan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t07_siswarutinbayar->Periode_Tahun_Bulan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t07_siswarutinbayar->Periode_Tahun_Bulan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t07_siswarutinbayar->Nilai->Visible) { // Nilai ?>
	<?php if ($t07_siswarutinbayar->SortUrl($t07_siswarutinbayar->Nilai) == "") { ?>
		<th data-name="Nilai"><div id="elh_t07_siswarutinbayar_Nilai" class="t07_siswarutinbayar_Nilai"><div class="ewTableHeaderCaption"><?php echo $t07_siswarutinbayar->Nilai->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nilai"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t07_siswarutinbayar->SortUrl($t07_siswarutinbayar->Nilai) ?>',2);"><div id="elh_t07_siswarutinbayar_Nilai" class="t07_siswarutinbayar_Nilai">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t07_siswarutinbayar->Nilai->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t07_siswarutinbayar->Nilai->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t07_siswarutinbayar->Nilai->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t07_siswarutinbayar->Tanggal_Bayar->Visible) { // Tanggal_Bayar ?>
	<?php if ($t07_siswarutinbayar->SortUrl($t07_siswarutinbayar->Tanggal_Bayar) == "") { ?>
		<th data-name="Tanggal_Bayar"><div id="elh_t07_siswarutinbayar_Tanggal_Bayar" class="t07_siswarutinbayar_Tanggal_Bayar"><div class="ewTableHeaderCaption"><?php echo $t07_siswarutinbayar->Tanggal_Bayar->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Tanggal_Bayar"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t07_siswarutinbayar->SortUrl($t07_siswarutinbayar->Tanggal_Bayar) ?>',2);"><div id="elh_t07_siswarutinbayar_Tanggal_Bayar" class="t07_siswarutinbayar_Tanggal_Bayar">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t07_siswarutinbayar->Tanggal_Bayar->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t07_siswarutinbayar->Tanggal_Bayar->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t07_siswarutinbayar->Tanggal_Bayar->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t07_siswarutinbayar->Nilai_Bayar->Visible) { // Nilai_Bayar ?>
	<?php if ($t07_siswarutinbayar->SortUrl($t07_siswarutinbayar->Nilai_Bayar) == "") { ?>
		<th data-name="Nilai_Bayar"><div id="elh_t07_siswarutinbayar_Nilai_Bayar" class="t07_siswarutinbayar_Nilai_Bayar"><div class="ewTableHeaderCaption"><?php echo $t07_siswarutinbayar->Nilai_Bayar->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nilai_Bayar"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t07_siswarutinbayar->SortUrl($t07_siswarutinbayar->Nilai_Bayar) ?>',2);"><div id="elh_t07_siswarutinbayar_Nilai_Bayar" class="t07_siswarutinbayar_Nilai_Bayar">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t07_siswarutinbayar->Nilai_Bayar->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t07_siswarutinbayar->Nilai_Bayar->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t07_siswarutinbayar->Nilai_Bayar->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t07_siswarutinbayar->Bulan->Visible) { // Bulan ?>
	<?php if ($t07_siswarutinbayar->SortUrl($t07_siswarutinbayar->Bulan) == "") { ?>
		<th data-name="Bulan"><div id="elh_t07_siswarutinbayar_Bulan" class="t07_siswarutinbayar_Bulan"><div class="ewTableHeaderCaption"><?php echo $t07_siswarutinbayar->Bulan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Bulan"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t07_siswarutinbayar->SortUrl($t07_siswarutinbayar->Bulan) ?>',2);"><div id="elh_t07_siswarutinbayar_Bulan" class="t07_siswarutinbayar_Bulan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t07_siswarutinbayar->Bulan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t07_siswarutinbayar->Bulan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t07_siswarutinbayar->Bulan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t07_siswarutinbayar->Tahun->Visible) { // Tahun ?>
	<?php if ($t07_siswarutinbayar->SortUrl($t07_siswarutinbayar->Tahun) == "") { ?>
		<th data-name="Tahun"><div id="elh_t07_siswarutinbayar_Tahun" class="t07_siswarutinbayar_Tahun"><div class="ewTableHeaderCaption"><?php echo $t07_siswarutinbayar->Tahun->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Tahun"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t07_siswarutinbayar->SortUrl($t07_siswarutinbayar->Tahun) ?>',2);"><div id="elh_t07_siswarutinbayar_Tahun" class="t07_siswarutinbayar_Tahun">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t07_siswarutinbayar->Tahun->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t07_siswarutinbayar->Tahun->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t07_siswarutinbayar->Tahun->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t07_siswarutinbayar->Periode_Text->Visible) { // Periode_Text ?>
	<?php if ($t07_siswarutinbayar->SortUrl($t07_siswarutinbayar->Periode_Text) == "") { ?>
		<th data-name="Periode_Text"><div id="elh_t07_siswarutinbayar_Periode_Text" class="t07_siswarutinbayar_Periode_Text"><div class="ewTableHeaderCaption"><?php echo $t07_siswarutinbayar->Periode_Text->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Periode_Text"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t07_siswarutinbayar->SortUrl($t07_siswarutinbayar->Periode_Text) ?>',2);"><div id="elh_t07_siswarutinbayar_Periode_Text" class="t07_siswarutinbayar_Periode_Text">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t07_siswarutinbayar->Periode_Text->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t07_siswarutinbayar->Periode_Text->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t07_siswarutinbayar->Periode_Text->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$t07_siswarutinbayar_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($t07_siswarutinbayar->ExportAll && $t07_siswarutinbayar->Export <> "") {
	$t07_siswarutinbayar_list->StopRec = $t07_siswarutinbayar_list->TotalRecs;
} else {

	// Set the last record to display
	if ($t07_siswarutinbayar_list->TotalRecs > $t07_siswarutinbayar_list->StartRec + $t07_siswarutinbayar_list->DisplayRecs - 1)
		$t07_siswarutinbayar_list->StopRec = $t07_siswarutinbayar_list->StartRec + $t07_siswarutinbayar_list->DisplayRecs - 1;
	else
		$t07_siswarutinbayar_list->StopRec = $t07_siswarutinbayar_list->TotalRecs;
}
$t07_siswarutinbayar_list->RecCnt = $t07_siswarutinbayar_list->StartRec - 1;
if ($t07_siswarutinbayar_list->Recordset && !$t07_siswarutinbayar_list->Recordset->EOF) {
	$t07_siswarutinbayar_list->Recordset->MoveFirst();
	$bSelectLimit = $t07_siswarutinbayar_list->UseSelectLimit;
	if (!$bSelectLimit && $t07_siswarutinbayar_list->StartRec > 1)
		$t07_siswarutinbayar_list->Recordset->Move($t07_siswarutinbayar_list->StartRec - 1);
} elseif (!$t07_siswarutinbayar->AllowAddDeleteRow && $t07_siswarutinbayar_list->StopRec == 0) {
	$t07_siswarutinbayar_list->StopRec = $t07_siswarutinbayar->GridAddRowCount;
}

// Initialize aggregate
$t07_siswarutinbayar->RowType = EW_ROWTYPE_AGGREGATEINIT;
$t07_siswarutinbayar->ResetAttrs();
$t07_siswarutinbayar_list->RenderRow();
while ($t07_siswarutinbayar_list->RecCnt < $t07_siswarutinbayar_list->StopRec) {
	$t07_siswarutinbayar_list->RecCnt++;
	if (intval($t07_siswarutinbayar_list->RecCnt) >= intval($t07_siswarutinbayar_list->StartRec)) {
		$t07_siswarutinbayar_list->RowCnt++;

		// Set up key count
		$t07_siswarutinbayar_list->KeyCount = $t07_siswarutinbayar_list->RowIndex;

		// Init row class and style
		$t07_siswarutinbayar->ResetAttrs();
		$t07_siswarutinbayar->CssClass = "";
		if ($t07_siswarutinbayar->CurrentAction == "gridadd") {
		} else {
			$t07_siswarutinbayar_list->LoadRowValues($t07_siswarutinbayar_list->Recordset); // Load row values
		}
		$t07_siswarutinbayar->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$t07_siswarutinbayar->RowAttrs = array_merge($t07_siswarutinbayar->RowAttrs, array('data-rowindex'=>$t07_siswarutinbayar_list->RowCnt, 'id'=>'r' . $t07_siswarutinbayar_list->RowCnt . '_t07_siswarutinbayar', 'data-rowtype'=>$t07_siswarutinbayar->RowType));

		// Render row
		$t07_siswarutinbayar_list->RenderRow();

		// Render list options
		$t07_siswarutinbayar_list->RenderListOptions();
?>
	<tr<?php echo $t07_siswarutinbayar->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t07_siswarutinbayar_list->ListOptions->Render("body", "left", $t07_siswarutinbayar_list->RowCnt);
?>
	<?php if ($t07_siswarutinbayar->siswarutin_id->Visible) { // siswarutin_id ?>
		<td data-name="siswarutin_id"<?php echo $t07_siswarutinbayar->siswarutin_id->CellAttributes() ?>>
<span id="el<?php echo $t07_siswarutinbayar_list->RowCnt ?>_t07_siswarutinbayar_siswarutin_id" class="t07_siswarutinbayar_siswarutin_id">
<span<?php echo $t07_siswarutinbayar->siswarutin_id->ViewAttributes() ?>>
<?php echo $t07_siswarutinbayar->siswarutin_id->ListViewValue() ?></span>
</span>
<a id="<?php echo $t07_siswarutinbayar_list->PageObjName . "_row_" . $t07_siswarutinbayar_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($t07_siswarutinbayar->Periode_Tahun_Bulan->Visible) { // Periode_Tahun_Bulan ?>
		<td data-name="Periode_Tahun_Bulan"<?php echo $t07_siswarutinbayar->Periode_Tahun_Bulan->CellAttributes() ?>>
<span id="el<?php echo $t07_siswarutinbayar_list->RowCnt ?>_t07_siswarutinbayar_Periode_Tahun_Bulan" class="t07_siswarutinbayar_Periode_Tahun_Bulan">
<span<?php echo $t07_siswarutinbayar->Periode_Tahun_Bulan->ViewAttributes() ?>>
<?php echo $t07_siswarutinbayar->Periode_Tahun_Bulan->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t07_siswarutinbayar->Nilai->Visible) { // Nilai ?>
		<td data-name="Nilai"<?php echo $t07_siswarutinbayar->Nilai->CellAttributes() ?>>
<span id="el<?php echo $t07_siswarutinbayar_list->RowCnt ?>_t07_siswarutinbayar_Nilai" class="t07_siswarutinbayar_Nilai">
<span<?php echo $t07_siswarutinbayar->Nilai->ViewAttributes() ?>>
<?php echo $t07_siswarutinbayar->Nilai->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t07_siswarutinbayar->Tanggal_Bayar->Visible) { // Tanggal_Bayar ?>
		<td data-name="Tanggal_Bayar"<?php echo $t07_siswarutinbayar->Tanggal_Bayar->CellAttributes() ?>>
<span id="el<?php echo $t07_siswarutinbayar_list->RowCnt ?>_t07_siswarutinbayar_Tanggal_Bayar" class="t07_siswarutinbayar_Tanggal_Bayar">
<span<?php echo $t07_siswarutinbayar->Tanggal_Bayar->ViewAttributes() ?>>
<?php echo $t07_siswarutinbayar->Tanggal_Bayar->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t07_siswarutinbayar->Nilai_Bayar->Visible) { // Nilai_Bayar ?>
		<td data-name="Nilai_Bayar"<?php echo $t07_siswarutinbayar->Nilai_Bayar->CellAttributes() ?>>
<span id="el<?php echo $t07_siswarutinbayar_list->RowCnt ?>_t07_siswarutinbayar_Nilai_Bayar" class="t07_siswarutinbayar_Nilai_Bayar">
<span<?php echo $t07_siswarutinbayar->Nilai_Bayar->ViewAttributes() ?>>
<?php echo $t07_siswarutinbayar->Nilai_Bayar->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t07_siswarutinbayar->Bulan->Visible) { // Bulan ?>
		<td data-name="Bulan"<?php echo $t07_siswarutinbayar->Bulan->CellAttributes() ?>>
<span id="el<?php echo $t07_siswarutinbayar_list->RowCnt ?>_t07_siswarutinbayar_Bulan" class="t07_siswarutinbayar_Bulan">
<span<?php echo $t07_siswarutinbayar->Bulan->ViewAttributes() ?>>
<?php echo $t07_siswarutinbayar->Bulan->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t07_siswarutinbayar->Tahun->Visible) { // Tahun ?>
		<td data-name="Tahun"<?php echo $t07_siswarutinbayar->Tahun->CellAttributes() ?>>
<span id="el<?php echo $t07_siswarutinbayar_list->RowCnt ?>_t07_siswarutinbayar_Tahun" class="t07_siswarutinbayar_Tahun">
<span<?php echo $t07_siswarutinbayar->Tahun->ViewAttributes() ?>>
<?php echo $t07_siswarutinbayar->Tahun->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t07_siswarutinbayar->Periode_Text->Visible) { // Periode_Text ?>
		<td data-name="Periode_Text"<?php echo $t07_siswarutinbayar->Periode_Text->CellAttributes() ?>>
<span id="el<?php echo $t07_siswarutinbayar_list->RowCnt ?>_t07_siswarutinbayar_Periode_Text" class="t07_siswarutinbayar_Periode_Text">
<span<?php echo $t07_siswarutinbayar->Periode_Text->ViewAttributes() ?>>
<?php echo $t07_siswarutinbayar->Periode_Text->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t07_siswarutinbayar_list->ListOptions->Render("body", "right", $t07_siswarutinbayar_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($t07_siswarutinbayar->CurrentAction <> "gridadd")
		$t07_siswarutinbayar_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($t07_siswarutinbayar->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($t07_siswarutinbayar_list->Recordset)
	$t07_siswarutinbayar_list->Recordset->Close();
?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($t07_siswarutinbayar->CurrentAction <> "gridadd" && $t07_siswarutinbayar->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($t07_siswarutinbayar_list->Pager)) $t07_siswarutinbayar_list->Pager = new cPrevNextPager($t07_siswarutinbayar_list->StartRec, $t07_siswarutinbayar_list->DisplayRecs, $t07_siswarutinbayar_list->TotalRecs) ?>
<?php if ($t07_siswarutinbayar_list->Pager->RecordCount > 0 && $t07_siswarutinbayar_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($t07_siswarutinbayar_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $t07_siswarutinbayar_list->PageUrl() ?>start=<?php echo $t07_siswarutinbayar_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($t07_siswarutinbayar_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $t07_siswarutinbayar_list->PageUrl() ?>start=<?php echo $t07_siswarutinbayar_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $t07_siswarutinbayar_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($t07_siswarutinbayar_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $t07_siswarutinbayar_list->PageUrl() ?>start=<?php echo $t07_siswarutinbayar_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($t07_siswarutinbayar_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $t07_siswarutinbayar_list->PageUrl() ?>start=<?php echo $t07_siswarutinbayar_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $t07_siswarutinbayar_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $t07_siswarutinbayar_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $t07_siswarutinbayar_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $t07_siswarutinbayar_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t07_siswarutinbayar_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($t07_siswarutinbayar_list->TotalRecs == 0 && $t07_siswarutinbayar->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t07_siswarutinbayar_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
ft07_siswarutinbayarlist.Init();
</script>
<?php
$t07_siswarutinbayar_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t07_siswarutinbayar_list->Page_Terminate();
?>
