<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "t09_siswanonrutintempinfo.php" ?>
<?php include_once "v01_siswainfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$t09_siswanonrutintemp_list = NULL; // Initialize page object first

class ct09_siswanonrutintemp_list extends ct09_siswanonrutintemp {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{64CABE7A-1609-4157-8293-D7242B591905}";

	// Table name
	var $TableName = 't09_siswanonrutintemp';

	// Page object name
	var $PageObjName = 't09_siswanonrutintemp_list';

	// Grid form hidden field names
	var $FormName = 'ft09_siswanonrutintemplist';
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

		// Table object (t09_siswanonrutintemp)
		if (!isset($GLOBALS["t09_siswanonrutintemp"]) || get_class($GLOBALS["t09_siswanonrutintemp"]) == "ct09_siswanonrutintemp") {
			$GLOBALS["t09_siswanonrutintemp"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t09_siswanonrutintemp"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "t09_siswanonrutintempadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "t09_siswanonrutintempdelete.php";
		$this->MultiUpdateUrl = "t09_siswanonrutintempupdate.php";

		// Table object (v01_siswa)
		if (!isset($GLOBALS['v01_siswa'])) $GLOBALS['v01_siswa'] = new cv01_siswa();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't09_siswanonrutintemp', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption ft09_siswanonrutintemplistsrch";

		// List actions
		$this->ListActions = new cListActions();
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();
		$this->siswa_id->SetVisibility();
		$this->nonrutin_id->SetVisibility();
		$this->siswanonrutin_id->SetVisibility();
		$this->Nilai->SetVisibility();
		$this->Bayar->SetVisibility();
		$this->Sisa->SetVisibility();

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

		// Set up master detail parameters
		$this->SetUpMasterParms();

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
		global $EW_EXPORT, $t09_siswanonrutintemp;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t09_siswanonrutintemp);
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

			// Check QueryString parameters
			if (@$_GET["a"] <> "") {
				$this->CurrentAction = $_GET["a"];

				// Clear inline mode
				if ($this->CurrentAction == "cancel")
					$this->ClearInlineMode();

				// Switch to grid edit mode
				if ($this->CurrentAction == "gridedit")
					$this->GridEditMode();
			} else {
				if (@$_POST["a_list"] <> "") {
					$this->CurrentAction = $_POST["a_list"]; // Get action

					// Grid Update
					if (($this->CurrentAction == "gridupdate" || $this->CurrentAction == "gridoverwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridedit") {
						if ($this->ValidateGridForm()) {
							$bGridUpdate = $this->GridUpdate();
						} else {
							$bGridUpdate = FALSE;
							$this->setFailureMessage($gsFormError);
						}
						if (!$bGridUpdate) {
							$this->EventCancelled = TRUE;
							$this->CurrentAction = "gridedit"; // Stay in Grid Edit mode
						}
					}
				}
			}

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

			// Show grid delete link for grid add / grid edit
			if ($this->AllowAddDeleteRow) {
				if ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
					$item = $this->ListOptions->GetItem("griddelete");
					if ($item) $item->Visible = TRUE;
				}
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

		// Restore master/detail filter
		$this->DbMasterFilter = $this->GetMasterFilter(); // Restore master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Restore detail filter
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Load master record
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "v01_siswa") {
			global $v01_siswa;
			$rsmaster = $v01_siswa->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("v01_siswalist.php"); // Return to master page
			} else {
				$v01_siswa->LoadListRowValues($rsmaster);
				$v01_siswa->RowType = EW_ROWTYPE_MASTER; // Master row
				$v01_siswa->RenderListRow();
				$rsmaster->Close();
			}
		}

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

	//  Exit inline mode
	function ClearInlineMode() {
		$this->Nilai->FormValue = ""; // Clear form value
		$this->Bayar->FormValue = ""; // Clear form value
		$this->Sisa->FormValue = ""; // Clear form value
		$this->LastAction = $this->CurrentAction; // Save last action
		$this->CurrentAction = ""; // Clear action
		$_SESSION[EW_SESSION_INLINE_MODE] = ""; // Clear inline mode
	}

	// Switch to Grid Edit mode
	function GridEditMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridedit"; // Enable grid edit
	}

	// Perform update to grid
	function GridUpdate() {
		global $Language, $objForm, $gsFormError;
		$bGridUpdate = TRUE;

		// Get old recordset
		$this->CurrentFilter = $this->BuildKeyFilter();
		if ($this->CurrentFilter == "")
			$this->CurrentFilter = "0=1";
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sSql)) {
			$rsold = $rs->GetRows();
			$rs->Close();
		}

		// Call Grid Updating event
		if (!$this->Grid_Updating($rsold)) {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("GridEditCancelled")); // Set grid edit cancelled message
			return FALSE;
		}

		// Begin transaction
		$conn->BeginTrans();
		if ($this->AuditTrailOnEdit) $this->WriteAuditTrailDummy($Language->Phrase("BatchUpdateBegin")); // Batch update begin
		$sKey = "";

		// Update row index and get row key
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Update all rows based on key
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
			$objForm->Index = $rowindex;
			$rowkey = strval($objForm->GetValue($this->FormKeyName));
			$rowaction = strval($objForm->GetValue($this->FormActionName));

			// Load all values and keys
			if ($rowaction <> "insertdelete") { // Skip insert then deleted rows
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "" || $rowaction == "edit" || $rowaction == "delete") {
					$bGridUpdate = $this->SetupKeyValues($rowkey); // Set up key values
				} else {
					$bGridUpdate = TRUE;
				}

				// Skip empty row
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// No action required
				// Validate form and insert/update/delete record

				} elseif ($bGridUpdate) {
					if ($rowaction == "delete") {
						$this->CurrentFilter = $this->KeyFilter();
						$bGridUpdate = $this->DeleteRows(); // Delete this row
					} else if (!$this->ValidateForm()) {
						$bGridUpdate = FALSE; // Form error, reset action
						$this->setFailureMessage($gsFormError);
					} else {
						if ($rowaction == "insert") {
							$bGridUpdate = $this->AddRow(); // Insert this row
						} else {
							if ($rowkey <> "") {
								$this->SendEmail = FALSE; // Do not send email on update success
								$bGridUpdate = $this->EditRow(); // Update this row
							}
						} // End update
					}
				}
				if ($bGridUpdate) {
					if ($sKey <> "") $sKey .= ", ";
					$sKey .= $rowkey;
				} else {
					break;
				}
			}
		}
		if ($bGridUpdate) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}

			// Call Grid_Updated event
			$this->Grid_Updated($rsold, $rsnew);
			if ($this->AuditTrailOnEdit) $this->WriteAuditTrailDummy($Language->Phrase("BatchUpdateSuccess")); // Batch update success
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up update success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($this->AuditTrailOnEdit) $this->WriteAuditTrailDummy($Language->Phrase("BatchUpdateRollback")); // Batch update rollback
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("UpdateFailed")); // Set update failed message
		}
		return $bGridUpdate;
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

	// Check if empty row
	function EmptyRow() {
		global $objForm;
		if ($objForm->HasValue("x_siswa_id") && $objForm->HasValue("o_siswa_id") && $this->siswa_id->CurrentValue <> $this->siswa_id->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_nonrutin_id") && $objForm->HasValue("o_nonrutin_id") && $this->nonrutin_id->CurrentValue <> $this->nonrutin_id->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_siswanonrutin_id") && $objForm->HasValue("o_siswanonrutin_id") && $this->siswanonrutin_id->CurrentValue <> $this->siswanonrutin_id->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Nilai") && $objForm->HasValue("o_Nilai") && $this->Nilai->CurrentValue <> $this->Nilai->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Bayar") && $objForm->HasValue("o_Bayar") && $this->Bayar->CurrentValue <> $this->Bayar->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Sisa") && $objForm->HasValue("o_Sisa") && $this->Sisa->CurrentValue <> $this->Sisa->OldValue)
			return FALSE;
		return TRUE;
	}

	// Validate grid form
	function ValidateGridForm() {
		global $objForm;

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Validate all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "delete" && $rowaction <> "insertdelete") {
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// Ignore
				} else if (!$this->ValidateForm()) {
					return FALSE;
				}
			}
		}
		return TRUE;
	}

	// Get all form values of the grid
	function GetGridFormValues() {
		global $objForm;

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;
		$rows = array();

		// Loop through all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "delete" && $rowaction <> "insertdelete") {
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// Ignore
				} else {
					$rows[] = $this->GetFieldValues("FormValue"); // Return row as array
				}
			}
		}
		return $rows; // Return as array of array
	}

	// Restore form values for current row
	function RestoreCurrentRowFormValues($idx) {
		global $objForm;

		// Get row based on current index
		$objForm->Index = $idx;
		$this->LoadFormValues(); // Load form values
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for Ctrl pressed
		$bCtrl = (@$_GET["ctrl"] <> "");

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->siswa_id, $bCtrl); // siswa_id
			$this->UpdateSort($this->nonrutin_id, $bCtrl); // nonrutin_id
			$this->UpdateSort($this->siswanonrutin_id, $bCtrl); // siswanonrutin_id
			$this->UpdateSort($this->Nilai, $bCtrl); // Nilai
			$this->UpdateSort($this->Bayar, $bCtrl); // Bayar
			$this->UpdateSort($this->Sisa, $bCtrl); // Sisa
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

			// Reset master/detail keys
			if ($this->Command == "resetall") {
				$this->setCurrentMasterTable(""); // Clear master table
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
				$this->siswa_id->setSessionValue("");
			}

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->siswa_id->setSort("");
				$this->nonrutin_id->setSort("");
				$this->siswanonrutin_id->setSort("");
				$this->Nilai->setSort("");
				$this->Bayar->setSort("");
				$this->Sisa->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// "griddelete"
		if ($this->AllowAddDeleteRow) {
			$item = &$this->ListOptions->Add("griddelete");
			$item->CssStyle = "white-space: nowrap;";
			$item->OnLeft = TRUE;
			$item->Visible = FALSE; // Default hidden
		}

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

		// Set up row action and key
		if (is_numeric($this->RowIndex) && $this->CurrentMode <> "view") {
			$objForm->Index = $this->RowIndex;
			$ActionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
			$OldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormOldKeyName);
			$KeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormKeyName);
			$BlankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
			if ($this->RowAction <> "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $ActionName . "\" id=\"" . $ActionName . "\" value=\"" . $this->RowAction . "\">";
			if ($this->RowAction == "delete") {
				$rowkey = $objForm->GetValue($this->FormKeyName);
				$this->SetupKeyValues($rowkey);
			}
			if ($this->RowAction == "insert" && $this->CurrentAction == "F" && $this->EmptyRow())
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $BlankRowName . "\" id=\"" . $BlankRowName . "\" value=\"1\">";
		}

		// "delete"
		if ($this->AllowAddDeleteRow) {
			if ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$option = &$this->ListOptions;
				$option->UseButtonGroup = TRUE; // Use button group for grid delete button
				$option->UseImageAndText = TRUE; // Use image and text for grid delete button
				$oListOpt = &$option->Items["griddelete"];
				if (is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
					$oListOpt->Body = "&nbsp;";
				} else {
					$oListOpt->Body = "<a class=\"ewGridLink ewGridDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" onclick=\"return ew_DeleteGridRow(this, " . $this->RowIndex . ");\">" . $Language->Phrase("DeleteLink") . "</a>";
				}
			}
		}

		// "sequence"
		$oListOpt = &$this->ListOptions->Items["sequence"];
		$oListOpt->Body = ew_FormatSeqNo($this->RecCnt);

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
		if ($this->CurrentAction == "gridedit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $KeyName . "\" id=\"" . $KeyName . "\" value=\"" . $this->id->CurrentValue . "\">";
		}
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;

		// Add grid edit
		$option = $options["addedit"];
		$item = &$option->Add("gridedit");
		$item->Body = "<a class=\"ewAddEdit ewGridEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("GridEditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GridEditUrl) . "\">" . $Language->Phrase("GridEditLink") . "</a>";
		$item->Visible = ($this->GridEditUrl <> "");
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"ft09_siswanonrutintemplistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = FALSE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"ft09_siswanonrutintemplistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "gridedit") { // Not grid add/edit mode
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.ft09_siswanonrutintemplist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		} else { // Grid add/edit mode

			// Hide all options first
			foreach ($options as &$option)
				$option->HideAllOptions();
			if ($this->CurrentAction == "gridedit") {
				if ($this->AllowAddDeleteRow) {

					// Add add blank row
					$option = &$options["addedit"];
					$option->UseDropDownButton = FALSE;
					$option->UseImageAndText = TRUE;
					$item = &$option->Add("addblankrow");
					$item->Body = "<a class=\"ewAddEdit ewAddBlankRow\" title=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" href=\"javascript:void(0);\" onclick=\"ew_AddGridRow(this);\">" . $Language->Phrase("AddBlankRow") . "</a>";
					$item->Visible = FALSE;
				}
				$option = &$options["action"];
				$option->UseDropDownButton = FALSE;
				$option->UseImageAndText = TRUE;
					$item = &$option->Add("gridsave");
					$item->Body = "<a class=\"ewAction ewGridSave\" title=\"" . ew_HtmlTitle($Language->Phrase("GridSaveLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridSaveLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . $this->PageName() . "');\">" . $Language->Phrase("GridSaveLink") . "</a>";
					$item = &$option->Add("gridcancel");
					$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
					$item->Body = "<a class=\"ewAction ewGridCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("GridCancelLink") . "</a>";
			}
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

	// Load default values
	function LoadDefaultValues() {
		$this->siswa_id->CurrentValue = NULL;
		$this->siswa_id->OldValue = $this->siswa_id->CurrentValue;
		$this->nonrutin_id->CurrentValue = NULL;
		$this->nonrutin_id->OldValue = $this->nonrutin_id->CurrentValue;
		$this->siswanonrutin_id->CurrentValue = NULL;
		$this->siswanonrutin_id->OldValue = $this->siswanonrutin_id->CurrentValue;
		$this->Nilai->CurrentValue = 0.00;
		$this->Nilai->OldValue = $this->Nilai->CurrentValue;
		$this->Bayar->CurrentValue = 0.00;
		$this->Bayar->OldValue = $this->Bayar->CurrentValue;
		$this->Sisa->CurrentValue = 0.00;
		$this->Sisa->OldValue = $this->Sisa->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->siswa_id->FldIsDetailKey) {
			$this->siswa_id->setFormValue($objForm->GetValue("x_siswa_id"));
		}
		if (!$this->nonrutin_id->FldIsDetailKey) {
			$this->nonrutin_id->setFormValue($objForm->GetValue("x_nonrutin_id"));
		}
		if (!$this->siswanonrutin_id->FldIsDetailKey) {
			$this->siswanonrutin_id->setFormValue($objForm->GetValue("x_siswanonrutin_id"));
		}
		if (!$this->Nilai->FldIsDetailKey) {
			$this->Nilai->setFormValue($objForm->GetValue("x_Nilai"));
		}
		if (!$this->Bayar->FldIsDetailKey) {
			$this->Bayar->setFormValue($objForm->GetValue("x_Bayar"));
		}
		if (!$this->Sisa->FldIsDetailKey) {
			$this->Sisa->setFormValue($objForm->GetValue("x_Sisa"));
		}
		if (!$this->id->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->id->setFormValue($objForm->GetValue("x_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->id->CurrentValue = $this->id->FormValue;
		$this->siswa_id->CurrentValue = $this->siswa_id->FormValue;
		$this->nonrutin_id->CurrentValue = $this->nonrutin_id->FormValue;
		$this->siswanonrutin_id->CurrentValue = $this->siswanonrutin_id->FormValue;
		$this->Nilai->CurrentValue = $this->Nilai->FormValue;
		$this->Bayar->CurrentValue = $this->Bayar->FormValue;
		$this->Sisa->CurrentValue = $this->Sisa->FormValue;
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
		$this->siswa_id->setDbValue($rs->fields('siswa_id'));
		$this->nonrutin_id->setDbValue($rs->fields('nonrutin_id'));
		$this->siswanonrutin_id->setDbValue($rs->fields('siswanonrutin_id'));
		$this->Nilai->setDbValue($rs->fields('Nilai'));
		$this->Bayar->setDbValue($rs->fields('Bayar'));
		$this->Sisa->setDbValue($rs->fields('Sisa'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->siswa_id->DbValue = $row['siswa_id'];
		$this->nonrutin_id->DbValue = $row['nonrutin_id'];
		$this->siswanonrutin_id->DbValue = $row['siswanonrutin_id'];
		$this->Nilai->DbValue = $row['Nilai'];
		$this->Bayar->DbValue = $row['Bayar'];
		$this->Sisa->DbValue = $row['Sisa'];
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
		if ($this->Bayar->FormValue == $this->Bayar->CurrentValue && is_numeric(ew_StrToFloat($this->Bayar->CurrentValue)))
			$this->Bayar->CurrentValue = ew_StrToFloat($this->Bayar->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Sisa->FormValue == $this->Sisa->CurrentValue && is_numeric(ew_StrToFloat($this->Sisa->CurrentValue)))
			$this->Sisa->CurrentValue = ew_StrToFloat($this->Sisa->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// siswa_id
		// nonrutin_id
		// siswanonrutin_id
		// Nilai
		// Bayar
		// Sisa

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// siswa_id
		$this->siswa_id->ViewValue = $this->siswa_id->CurrentValue;
		$this->siswa_id->ViewCustomAttributes = "";

		// nonrutin_id
		$this->nonrutin_id->ViewValue = $this->nonrutin_id->CurrentValue;
		if (strval($this->nonrutin_id->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->nonrutin_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `Jenis` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t08_nonrutin`";
		$sWhereWrk = "";
		$this->nonrutin_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->nonrutin_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->nonrutin_id->ViewValue = $this->nonrutin_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->nonrutin_id->ViewValue = $this->nonrutin_id->CurrentValue;
			}
		} else {
			$this->nonrutin_id->ViewValue = NULL;
		}
		$this->nonrutin_id->ViewCustomAttributes = "";

		// siswanonrutin_id
		$this->siswanonrutin_id->ViewValue = $this->siswanonrutin_id->CurrentValue;
		$this->siswanonrutin_id->ViewCustomAttributes = "";

		// Nilai
		$this->Nilai->ViewValue = $this->Nilai->CurrentValue;
		$this->Nilai->ViewValue = ew_FormatNumber($this->Nilai->ViewValue, 2, -2, -2, -2);
		$this->Nilai->CellCssStyle .= "text-align: right;";
		$this->Nilai->ViewCustomAttributes = "";

		// Bayar
		$this->Bayar->ViewValue = $this->Bayar->CurrentValue;
		$this->Bayar->ViewValue = ew_FormatNumber($this->Bayar->ViewValue, 2, -2, -2, -2);
		$this->Bayar->CellCssStyle .= "text-align: right;";
		$this->Bayar->ViewCustomAttributes = "";

		// Sisa
		$this->Sisa->ViewValue = $this->Sisa->CurrentValue;
		$this->Sisa->ViewValue = ew_FormatNumber($this->Sisa->ViewValue, 2, -2, -2, -2);
		$this->Sisa->CellCssStyle .= "text-align: right;";
		$this->Sisa->ViewCustomAttributes = "";

			// siswa_id
			$this->siswa_id->LinkCustomAttributes = "";
			$this->siswa_id->HrefValue = "";
			$this->siswa_id->TooltipValue = "";

			// nonrutin_id
			$this->nonrutin_id->LinkCustomAttributes = "";
			$this->nonrutin_id->HrefValue = "";
			$this->nonrutin_id->TooltipValue = "";

			// siswanonrutin_id
			$this->siswanonrutin_id->LinkCustomAttributes = "";
			$this->siswanonrutin_id->HrefValue = "";
			$this->siswanonrutin_id->TooltipValue = "";

			// Nilai
			$this->Nilai->LinkCustomAttributes = "";
			$this->Nilai->HrefValue = "";
			$this->Nilai->TooltipValue = "";

			// Bayar
			$this->Bayar->LinkCustomAttributes = "";
			$this->Bayar->HrefValue = "";
			$this->Bayar->TooltipValue = "";

			// Sisa
			$this->Sisa->LinkCustomAttributes = "";
			$this->Sisa->HrefValue = "";
			$this->Sisa->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// siswa_id
			$this->siswa_id->EditAttrs["class"] = "form-control";
			$this->siswa_id->EditCustomAttributes = "";
			if ($this->siswa_id->getSessionValue() <> "") {
				$this->siswa_id->CurrentValue = $this->siswa_id->getSessionValue();
			$this->siswa_id->ViewValue = $this->siswa_id->CurrentValue;
			$this->siswa_id->ViewCustomAttributes = "";
			} else {
			$this->siswa_id->EditValue = ew_HtmlEncode($this->siswa_id->CurrentValue);
			$this->siswa_id->PlaceHolder = ew_RemoveHtml($this->siswa_id->FldCaption());
			}

			// nonrutin_id
			$this->nonrutin_id->EditAttrs["class"] = "form-control";
			$this->nonrutin_id->EditCustomAttributes = "";
			$this->nonrutin_id->EditValue = ew_HtmlEncode($this->nonrutin_id->CurrentValue);
			if (strval($this->nonrutin_id->CurrentValue) <> "") {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->nonrutin_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `id`, `Jenis` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t08_nonrutin`";
			$sWhereWrk = "";
			$this->nonrutin_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->nonrutin_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->nonrutin_id->EditValue = $this->nonrutin_id->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->nonrutin_id->EditValue = ew_HtmlEncode($this->nonrutin_id->CurrentValue);
				}
			} else {
				$this->nonrutin_id->EditValue = NULL;
			}
			$this->nonrutin_id->PlaceHolder = ew_RemoveHtml($this->nonrutin_id->FldCaption());

			// siswanonrutin_id
			$this->siswanonrutin_id->EditAttrs["class"] = "form-control";
			$this->siswanonrutin_id->EditCustomAttributes = "";
			$this->siswanonrutin_id->EditValue = ew_HtmlEncode($this->siswanonrutin_id->CurrentValue);
			$this->siswanonrutin_id->PlaceHolder = ew_RemoveHtml($this->siswanonrutin_id->FldCaption());

			// Nilai
			$this->Nilai->EditAttrs["class"] = "form-control";
			$this->Nilai->EditCustomAttributes = "";
			$this->Nilai->EditValue = ew_HtmlEncode($this->Nilai->CurrentValue);
			$this->Nilai->PlaceHolder = ew_RemoveHtml($this->Nilai->FldCaption());
			if (strval($this->Nilai->EditValue) <> "" && is_numeric($this->Nilai->EditValue)) $this->Nilai->EditValue = ew_FormatNumber($this->Nilai->EditValue, -2, -2, -2, -2);

			// Bayar
			$this->Bayar->EditAttrs["class"] = "form-control";
			$this->Bayar->EditCustomAttributes = "";
			$this->Bayar->EditValue = ew_HtmlEncode($this->Bayar->CurrentValue);
			$this->Bayar->PlaceHolder = ew_RemoveHtml($this->Bayar->FldCaption());
			if (strval($this->Bayar->EditValue) <> "" && is_numeric($this->Bayar->EditValue)) $this->Bayar->EditValue = ew_FormatNumber($this->Bayar->EditValue, -2, -2, -2, -2);

			// Sisa
			$this->Sisa->EditAttrs["class"] = "form-control";
			$this->Sisa->EditCustomAttributes = "";
			$this->Sisa->EditValue = ew_HtmlEncode($this->Sisa->CurrentValue);
			$this->Sisa->PlaceHolder = ew_RemoveHtml($this->Sisa->FldCaption());
			if (strval($this->Sisa->EditValue) <> "" && is_numeric($this->Sisa->EditValue)) $this->Sisa->EditValue = ew_FormatNumber($this->Sisa->EditValue, -2, -2, -2, -2);

			// Add refer script
			// siswa_id

			$this->siswa_id->LinkCustomAttributes = "";
			$this->siswa_id->HrefValue = "";

			// nonrutin_id
			$this->nonrutin_id->LinkCustomAttributes = "";
			$this->nonrutin_id->HrefValue = "";

			// siswanonrutin_id
			$this->siswanonrutin_id->LinkCustomAttributes = "";
			$this->siswanonrutin_id->HrefValue = "";

			// Nilai
			$this->Nilai->LinkCustomAttributes = "";
			$this->Nilai->HrefValue = "";

			// Bayar
			$this->Bayar->LinkCustomAttributes = "";
			$this->Bayar->HrefValue = "";

			// Sisa
			$this->Sisa->LinkCustomAttributes = "";
			$this->Sisa->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// siswa_id
			$this->siswa_id->EditAttrs["class"] = "form-control";
			$this->siswa_id->EditCustomAttributes = "";
			$this->siswa_id->EditValue = $this->siswa_id->CurrentValue;
			$this->siswa_id->ViewCustomAttributes = "";

			// nonrutin_id
			$this->nonrutin_id->EditAttrs["class"] = "form-control";
			$this->nonrutin_id->EditCustomAttributes = "";
			$this->nonrutin_id->EditValue = $this->nonrutin_id->CurrentValue;
			if (strval($this->nonrutin_id->CurrentValue) <> "") {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->nonrutin_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `id`, `Jenis` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t08_nonrutin`";
			$sWhereWrk = "";
			$this->nonrutin_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->nonrutin_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('DispFld');
					$this->nonrutin_id->EditValue = $this->nonrutin_id->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->nonrutin_id->EditValue = $this->nonrutin_id->CurrentValue;
				}
			} else {
				$this->nonrutin_id->EditValue = NULL;
			}
			$this->nonrutin_id->ViewCustomAttributes = "";

			// siswanonrutin_id
			$this->siswanonrutin_id->EditAttrs["class"] = "form-control";
			$this->siswanonrutin_id->EditCustomAttributes = "";

			// Nilai
			$this->Nilai->EditAttrs["class"] = "form-control";
			$this->Nilai->EditCustomAttributes = "";
			$this->Nilai->EditValue = $this->Nilai->CurrentValue;
			$this->Nilai->EditValue = ew_FormatNumber($this->Nilai->EditValue, 2, -2, -2, -2);
			$this->Nilai->CellCssStyle .= "text-align: right;";
			$this->Nilai->ViewCustomAttributes = "";

			// Bayar
			$this->Bayar->EditAttrs["class"] = "form-control";
			$this->Bayar->EditCustomAttributes = "";
			$this->Bayar->EditValue = ew_HtmlEncode($this->Bayar->CurrentValue);
			$this->Bayar->PlaceHolder = ew_RemoveHtml($this->Bayar->FldCaption());
			if (strval($this->Bayar->EditValue) <> "" && is_numeric($this->Bayar->EditValue)) $this->Bayar->EditValue = ew_FormatNumber($this->Bayar->EditValue, -2, -2, -2, -2);

			// Sisa
			$this->Sisa->EditAttrs["class"] = "form-control";
			$this->Sisa->EditCustomAttributes = "";
			$this->Sisa->EditValue = ew_HtmlEncode($this->Sisa->CurrentValue);
			$this->Sisa->PlaceHolder = ew_RemoveHtml($this->Sisa->FldCaption());
			if (strval($this->Sisa->EditValue) <> "" && is_numeric($this->Sisa->EditValue)) $this->Sisa->EditValue = ew_FormatNumber($this->Sisa->EditValue, -2, -2, -2, -2);

			// Edit refer script
			// siswa_id

			$this->siswa_id->LinkCustomAttributes = "";
			$this->siswa_id->HrefValue = "";
			$this->siswa_id->TooltipValue = "";

			// nonrutin_id
			$this->nonrutin_id->LinkCustomAttributes = "";
			$this->nonrutin_id->HrefValue = "";
			$this->nonrutin_id->TooltipValue = "";

			// siswanonrutin_id
			$this->siswanonrutin_id->LinkCustomAttributes = "";
			$this->siswanonrutin_id->HrefValue = "";

			// Nilai
			$this->Nilai->LinkCustomAttributes = "";
			$this->Nilai->HrefValue = "";
			$this->Nilai->TooltipValue = "";

			// Bayar
			$this->Bayar->LinkCustomAttributes = "";
			$this->Bayar->HrefValue = "";

			// Sisa
			$this->Sisa->LinkCustomAttributes = "";
			$this->Sisa->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD ||
			$this->RowType == EW_ROWTYPE_EDIT ||
			$this->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$this->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->siswa_id->FldIsDetailKey && !is_null($this->siswa_id->FormValue) && $this->siswa_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->siswa_id->FldCaption(), $this->siswa_id->ReqErrMsg));
		}
		if (!$this->nonrutin_id->FldIsDetailKey && !is_null($this->nonrutin_id->FormValue) && $this->nonrutin_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nonrutin_id->FldCaption(), $this->nonrutin_id->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->Bayar->FormValue)) {
			ew_AddMessage($gsFormError, $this->Bayar->FldErrMsg());
		}
		if (!ew_CheckNumber($this->Sisa->FormValue)) {
			ew_AddMessage($gsFormError, $this->Sisa->FldErrMsg());
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
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
		if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteBegin")); // Batch delete begin

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
			if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteSuccess")); // Batch delete success
		} else {
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Update record based on key values
	function EditRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// siswanonrutin_id
			$this->siswanonrutin_id->SetDbValueDef($rsnew, $this->siswanonrutin_id->CurrentValue, 0, $this->siswanonrutin_id->ReadOnly);

			// Bayar
			$this->Bayar->SetDbValueDef($rsnew, $this->Bayar->CurrentValue, NULL, $this->Bayar->ReadOnly);

			// Sisa
			$this->Sisa->SetDbValueDef($rsnew, $this->Sisa->CurrentValue, NULL, $this->Sisa->ReadOnly);

			// Check referential integrity for master table 'v01_siswa'
			$bValidMasterRecord = TRUE;
			$sMasterFilter = $this->SqlMasterFilter_v01_siswa();
			$KeyValue = isset($rsnew['siswa_id']) ? $rsnew['siswa_id'] : $rsold['siswa_id'];
			if (strval($KeyValue) <> "") {
				$sMasterFilter = str_replace("@id@", ew_AdjustSql($KeyValue), $sMasterFilter);
			} else {
				$bValidMasterRecord = FALSE;
			}
			if ($bValidMasterRecord) {
				if (!isset($GLOBALS["v01_siswa"])) $GLOBALS["v01_siswa"] = new cv01_siswa();
				$rsmaster = $GLOBALS["v01_siswa"]->LoadRs($sMasterFilter);
				$bValidMasterRecord = ($rsmaster && !$rsmaster->EOF);
				$rsmaster->Close();
			}
			if (!$bValidMasterRecord) {
				$sRelatedRecordMsg = str_replace("%t", "v01_siswa", $Language->Phrase("RelatedRecordRequired"));
				$this->setFailureMessage($sRelatedRecordMsg);
				$rs->Close();
				return FALSE;
			}

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;

		// Check referential integrity for master table 'v01_siswa'
		$bValidMasterRecord = TRUE;
		$sMasterFilter = $this->SqlMasterFilter_v01_siswa();
		if (strval($this->siswa_id->CurrentValue) <> "") {
			$sMasterFilter = str_replace("@id@", ew_AdjustSql($this->siswa_id->CurrentValue, "DB"), $sMasterFilter);
		} else {
			$bValidMasterRecord = FALSE;
		}
		if ($bValidMasterRecord) {
			if (!isset($GLOBALS["v01_siswa"])) $GLOBALS["v01_siswa"] = new cv01_siswa();
			$rsmaster = $GLOBALS["v01_siswa"]->LoadRs($sMasterFilter);
			$bValidMasterRecord = ($rsmaster && !$rsmaster->EOF);
			$rsmaster->Close();
		}
		if (!$bValidMasterRecord) {
			$sRelatedRecordMsg = str_replace("%t", "v01_siswa", $Language->Phrase("RelatedRecordRequired"));
			$this->setFailureMessage($sRelatedRecordMsg);
			return FALSE;
		}
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// siswa_id
		$this->siswa_id->SetDbValueDef($rsnew, $this->siswa_id->CurrentValue, 0, FALSE);

		// nonrutin_id
		$this->nonrutin_id->SetDbValueDef($rsnew, $this->nonrutin_id->CurrentValue, 0, FALSE);

		// siswanonrutin_id
		$this->siswanonrutin_id->SetDbValueDef($rsnew, $this->siswanonrutin_id->CurrentValue, 0, FALSE);

		// Nilai
		$this->Nilai->SetDbValueDef($rsnew, $this->Nilai->CurrentValue, NULL, strval($this->Nilai->CurrentValue) == "");

		// Bayar
		$this->Bayar->SetDbValueDef($rsnew, $this->Bayar->CurrentValue, NULL, strval($this->Bayar->CurrentValue) == "");

		// Sisa
		$this->Sisa->SetDbValueDef($rsnew, $this->Sisa->CurrentValue, NULL, strval($this->Sisa->CurrentValue) == "");

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up master/detail based on QueryString
	function SetUpMasterParms() {
		$bValidMaster = FALSE;

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "v01_siswa") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_id"] <> "") {
					$GLOBALS["v01_siswa"]->id->setQueryStringValue($_GET["fk_id"]);
					$this->siswa_id->setQueryStringValue($GLOBALS["v01_siswa"]->id->QueryStringValue);
					$this->siswa_id->setSessionValue($this->siswa_id->QueryStringValue);
					if (!is_numeric($GLOBALS["v01_siswa"]->id->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		} elseif (isset($_POST[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_POST[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "v01_siswa") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_id"] <> "") {
					$GLOBALS["v01_siswa"]->id->setFormValue($_POST["fk_id"]);
					$this->siswa_id->setFormValue($GLOBALS["v01_siswa"]->id->FormValue);
					$this->siswa_id->setSessionValue($this->siswa_id->FormValue);
					if (!is_numeric($GLOBALS["v01_siswa"]->id->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Update URL
			$this->AddUrl = $this->AddMasterUrl($this->AddUrl);
			$this->InlineAddUrl = $this->AddMasterUrl($this->InlineAddUrl);
			$this->GridAddUrl = $this->AddMasterUrl($this->GridAddUrl);
			$this->GridEditUrl = $this->AddMasterUrl($this->GridEditUrl);

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "v01_siswa") {
				if ($this->siswa_id->CurrentValue == "") $this->siswa_id->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
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
		case "x_nonrutin_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `Jenis` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t08_nonrutin`";
			$sWhereWrk = "{filter}";
			$this->nonrutin_id->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->nonrutin_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_nonrutin_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id`, `Jenis` AS `DispFld` FROM `t08_nonrutin`";
			$sWhereWrk = "`Jenis` LIKE '{query_value}%'";
			$this->nonrutin_id->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->nonrutin_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
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
if (!isset($t09_siswanonrutintemp_list)) $t09_siswanonrutintemp_list = new ct09_siswanonrutintemp_list();

// Page init
$t09_siswanonrutintemp_list->Page_Init();

// Page main
$t09_siswanonrutintemp_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t09_siswanonrutintemp_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = ft09_siswanonrutintemplist = new ew_Form("ft09_siswanonrutintemplist", "list");
ft09_siswanonrutintemplist.FormKeyCountName = '<?php echo $t09_siswanonrutintemp_list->FormKeyCountName ?>';

// Validate form
ft09_siswanonrutintemplist.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_siswa_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t09_siswanonrutintemp->siswa_id->FldCaption(), $t09_siswanonrutintemp->siswa_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nonrutin_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t09_siswanonrutintemp->nonrutin_id->FldCaption(), $t09_siswanonrutintemp->nonrutin_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Bayar");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t09_siswanonrutintemp->Bayar->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Sisa");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t09_siswanonrutintemp->Sisa->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}
	return true;
}

// Form_CustomValidate event
ft09_siswanonrutintemplist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft09_siswanonrutintemplist.ValidateRequired = true;
<?php } else { ?>
ft09_siswanonrutintemplist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft09_siswanonrutintemplist.Lists["x_nonrutin_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_Jenis","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t08_nonrutin"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php if ($t09_siswanonrutintemp_list->TotalRecs > 0 && $t09_siswanonrutintemp_list->ExportOptions->Visible()) { ?>
<?php $t09_siswanonrutintemp_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php if (($t09_siswanonrutintemp->Export == "") || (EW_EXPORT_MASTER_RECORD && $t09_siswanonrutintemp->Export == "print")) { ?>
<?php
if ($t09_siswanonrutintemp_list->DbMasterFilter <> "" && $t09_siswanonrutintemp->getCurrentMasterTable() == "v01_siswa") {
	if ($t09_siswanonrutintemp_list->MasterRecordExists) {
?>
<?php include_once "v01_siswamaster.php" ?>
<?php
	}
}
?>
<?php } ?>
<?php
	$bSelectLimit = $t09_siswanonrutintemp_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($t09_siswanonrutintemp_list->TotalRecs <= 0)
			$t09_siswanonrutintemp_list->TotalRecs = $t09_siswanonrutintemp->SelectRecordCount();
	} else {
		if (!$t09_siswanonrutintemp_list->Recordset && ($t09_siswanonrutintemp_list->Recordset = $t09_siswanonrutintemp_list->LoadRecordset()))
			$t09_siswanonrutintemp_list->TotalRecs = $t09_siswanonrutintemp_list->Recordset->RecordCount();
	}
	$t09_siswanonrutintemp_list->StartRec = 1;
	if ($t09_siswanonrutintemp_list->DisplayRecs <= 0 || ($t09_siswanonrutintemp->Export <> "" && $t09_siswanonrutintemp->ExportAll)) // Display all records
		$t09_siswanonrutintemp_list->DisplayRecs = $t09_siswanonrutintemp_list->TotalRecs;
	if (!($t09_siswanonrutintemp->Export <> "" && $t09_siswanonrutintemp->ExportAll))
		$t09_siswanonrutintemp_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$t09_siswanonrutintemp_list->Recordset = $t09_siswanonrutintemp_list->LoadRecordset($t09_siswanonrutintemp_list->StartRec-1, $t09_siswanonrutintemp_list->DisplayRecs);

	// Set no record found message
	if ($t09_siswanonrutintemp->CurrentAction == "" && $t09_siswanonrutintemp_list->TotalRecs == 0) {
		if ($t09_siswanonrutintemp_list->SearchWhere == "0=101")
			$t09_siswanonrutintemp_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$t09_siswanonrutintemp_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$t09_siswanonrutintemp_list->RenderOtherOptions();
?>
<?php $t09_siswanonrutintemp_list->ShowPageHeader(); ?>
<?php
$t09_siswanonrutintemp_list->ShowMessage();
?>
<?php if ($t09_siswanonrutintemp_list->TotalRecs > 0 || $t09_siswanonrutintemp->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid t09_siswanonrutintemp">
<form name="ft09_siswanonrutintemplist" id="ft09_siswanonrutintemplist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t09_siswanonrutintemp_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t09_siswanonrutintemp_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t09_siswanonrutintemp">
<?php if ($t09_siswanonrutintemp->getCurrentMasterTable() == "v01_siswa" && $t09_siswanonrutintemp->CurrentAction <> "") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="v01_siswa">
<input type="hidden" name="fk_id" value="<?php echo $t09_siswanonrutintemp->siswa_id->getSessionValue() ?>">
<?php } ?>
<div id="gmp_t09_siswanonrutintemp" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($t09_siswanonrutintemp_list->TotalRecs > 0 || $t09_siswanonrutintemp->CurrentAction == "gridedit") { ?>
<table id="tbl_t09_siswanonrutintemplist" class="table ewTable">
<?php echo $t09_siswanonrutintemp->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$t09_siswanonrutintemp_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$t09_siswanonrutintemp_list->RenderListOptions();

// Render list options (header, left)
$t09_siswanonrutintemp_list->ListOptions->Render("header", "left");
?>
<?php if ($t09_siswanonrutintemp->siswa_id->Visible) { // siswa_id ?>
	<?php if ($t09_siswanonrutintemp->SortUrl($t09_siswanonrutintemp->siswa_id) == "") { ?>
		<th data-name="siswa_id"><div id="elh_t09_siswanonrutintemp_siswa_id" class="t09_siswanonrutintemp_siswa_id"><div class="ewTableHeaderCaption"><?php echo $t09_siswanonrutintemp->siswa_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="siswa_id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t09_siswanonrutintemp->SortUrl($t09_siswanonrutintemp->siswa_id) ?>',2);"><div id="elh_t09_siswanonrutintemp_siswa_id" class="t09_siswanonrutintemp_siswa_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t09_siswanonrutintemp->siswa_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t09_siswanonrutintemp->siswa_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t09_siswanonrutintemp->siswa_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t09_siswanonrutintemp->nonrutin_id->Visible) { // nonrutin_id ?>
	<?php if ($t09_siswanonrutintemp->SortUrl($t09_siswanonrutintemp->nonrutin_id) == "") { ?>
		<th data-name="nonrutin_id"><div id="elh_t09_siswanonrutintemp_nonrutin_id" class="t09_siswanonrutintemp_nonrutin_id"><div class="ewTableHeaderCaption"><?php echo $t09_siswanonrutintemp->nonrutin_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nonrutin_id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t09_siswanonrutintemp->SortUrl($t09_siswanonrutintemp->nonrutin_id) ?>',2);"><div id="elh_t09_siswanonrutintemp_nonrutin_id" class="t09_siswanonrutintemp_nonrutin_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t09_siswanonrutintemp->nonrutin_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t09_siswanonrutintemp->nonrutin_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t09_siswanonrutintemp->nonrutin_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t09_siswanonrutintemp->siswanonrutin_id->Visible) { // siswanonrutin_id ?>
	<?php if ($t09_siswanonrutintemp->SortUrl($t09_siswanonrutintemp->siswanonrutin_id) == "") { ?>
		<th data-name="siswanonrutin_id"><div id="elh_t09_siswanonrutintemp_siswanonrutin_id" class="t09_siswanonrutintemp_siswanonrutin_id"><div class="ewTableHeaderCaption"><?php echo $t09_siswanonrutintemp->siswanonrutin_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="siswanonrutin_id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t09_siswanonrutintemp->SortUrl($t09_siswanonrutintemp->siswanonrutin_id) ?>',2);"><div id="elh_t09_siswanonrutintemp_siswanonrutin_id" class="t09_siswanonrutintemp_siswanonrutin_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t09_siswanonrutintemp->siswanonrutin_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t09_siswanonrutintemp->siswanonrutin_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t09_siswanonrutintemp->siswanonrutin_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t09_siswanonrutintemp->Nilai->Visible) { // Nilai ?>
	<?php if ($t09_siswanonrutintemp->SortUrl($t09_siswanonrutintemp->Nilai) == "") { ?>
		<th data-name="Nilai"><div id="elh_t09_siswanonrutintemp_Nilai" class="t09_siswanonrutintemp_Nilai"><div class="ewTableHeaderCaption"><?php echo $t09_siswanonrutintemp->Nilai->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nilai"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t09_siswanonrutintemp->SortUrl($t09_siswanonrutintemp->Nilai) ?>',2);"><div id="elh_t09_siswanonrutintemp_Nilai" class="t09_siswanonrutintemp_Nilai">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t09_siswanonrutintemp->Nilai->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t09_siswanonrutintemp->Nilai->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t09_siswanonrutintemp->Nilai->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t09_siswanonrutintemp->Bayar->Visible) { // Bayar ?>
	<?php if ($t09_siswanonrutintemp->SortUrl($t09_siswanonrutintemp->Bayar) == "") { ?>
		<th data-name="Bayar"><div id="elh_t09_siswanonrutintemp_Bayar" class="t09_siswanonrutintemp_Bayar"><div class="ewTableHeaderCaption"><?php echo $t09_siswanonrutintemp->Bayar->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Bayar"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t09_siswanonrutintemp->SortUrl($t09_siswanonrutintemp->Bayar) ?>',2);"><div id="elh_t09_siswanonrutintemp_Bayar" class="t09_siswanonrutintemp_Bayar">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t09_siswanonrutintemp->Bayar->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t09_siswanonrutintemp->Bayar->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t09_siswanonrutintemp->Bayar->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t09_siswanonrutintemp->Sisa->Visible) { // Sisa ?>
	<?php if ($t09_siswanonrutintemp->SortUrl($t09_siswanonrutintemp->Sisa) == "") { ?>
		<th data-name="Sisa"><div id="elh_t09_siswanonrutintemp_Sisa" class="t09_siswanonrutintemp_Sisa"><div class="ewTableHeaderCaption"><?php echo $t09_siswanonrutintemp->Sisa->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Sisa"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t09_siswanonrutintemp->SortUrl($t09_siswanonrutintemp->Sisa) ?>',2);"><div id="elh_t09_siswanonrutintemp_Sisa" class="t09_siswanonrutintemp_Sisa">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t09_siswanonrutintemp->Sisa->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t09_siswanonrutintemp->Sisa->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t09_siswanonrutintemp->Sisa->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$t09_siswanonrutintemp_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($t09_siswanonrutintemp->ExportAll && $t09_siswanonrutintemp->Export <> "") {
	$t09_siswanonrutintemp_list->StopRec = $t09_siswanonrutintemp_list->TotalRecs;
} else {

	// Set the last record to display
	if ($t09_siswanonrutintemp_list->TotalRecs > $t09_siswanonrutintemp_list->StartRec + $t09_siswanonrutintemp_list->DisplayRecs - 1)
		$t09_siswanonrutintemp_list->StopRec = $t09_siswanonrutintemp_list->StartRec + $t09_siswanonrutintemp_list->DisplayRecs - 1;
	else
		$t09_siswanonrutintemp_list->StopRec = $t09_siswanonrutintemp_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($t09_siswanonrutintemp_list->FormKeyCountName) && ($t09_siswanonrutintemp->CurrentAction == "gridadd" || $t09_siswanonrutintemp->CurrentAction == "gridedit" || $t09_siswanonrutintemp->CurrentAction == "F")) {
		$t09_siswanonrutintemp_list->KeyCount = $objForm->GetValue($t09_siswanonrutintemp_list->FormKeyCountName);
		$t09_siswanonrutintemp_list->StopRec = $t09_siswanonrutintemp_list->StartRec + $t09_siswanonrutintemp_list->KeyCount - 1;
	}
}
$t09_siswanonrutintemp_list->RecCnt = $t09_siswanonrutintemp_list->StartRec - 1;
if ($t09_siswanonrutintemp_list->Recordset && !$t09_siswanonrutintemp_list->Recordset->EOF) {
	$t09_siswanonrutintemp_list->Recordset->MoveFirst();
	$bSelectLimit = $t09_siswanonrutintemp_list->UseSelectLimit;
	if (!$bSelectLimit && $t09_siswanonrutintemp_list->StartRec > 1)
		$t09_siswanonrutintemp_list->Recordset->Move($t09_siswanonrutintemp_list->StartRec - 1);
} elseif (!$t09_siswanonrutintemp->AllowAddDeleteRow && $t09_siswanonrutintemp_list->StopRec == 0) {
	$t09_siswanonrutintemp_list->StopRec = $t09_siswanonrutintemp->GridAddRowCount;
}

// Initialize aggregate
$t09_siswanonrutintemp->RowType = EW_ROWTYPE_AGGREGATEINIT;
$t09_siswanonrutintemp->ResetAttrs();
$t09_siswanonrutintemp_list->RenderRow();
if ($t09_siswanonrutintemp->CurrentAction == "gridedit")
	$t09_siswanonrutintemp_list->RowIndex = 0;
while ($t09_siswanonrutintemp_list->RecCnt < $t09_siswanonrutintemp_list->StopRec) {
	$t09_siswanonrutintemp_list->RecCnt++;
	if (intval($t09_siswanonrutintemp_list->RecCnt) >= intval($t09_siswanonrutintemp_list->StartRec)) {
		$t09_siswanonrutintemp_list->RowCnt++;
		if ($t09_siswanonrutintemp->CurrentAction == "gridadd" || $t09_siswanonrutintemp->CurrentAction == "gridedit" || $t09_siswanonrutintemp->CurrentAction == "F") {
			$t09_siswanonrutintemp_list->RowIndex++;
			$objForm->Index = $t09_siswanonrutintemp_list->RowIndex;
			if ($objForm->HasValue($t09_siswanonrutintemp_list->FormActionName))
				$t09_siswanonrutintemp_list->RowAction = strval($objForm->GetValue($t09_siswanonrutintemp_list->FormActionName));
			elseif ($t09_siswanonrutintemp->CurrentAction == "gridadd")
				$t09_siswanonrutintemp_list->RowAction = "insert";
			else
				$t09_siswanonrutintemp_list->RowAction = "";
		}

		// Set up key count
		$t09_siswanonrutintemp_list->KeyCount = $t09_siswanonrutintemp_list->RowIndex;

		// Init row class and style
		$t09_siswanonrutintemp->ResetAttrs();
		$t09_siswanonrutintemp->CssClass = "";
		if ($t09_siswanonrutintemp->CurrentAction == "gridadd") {
			$t09_siswanonrutintemp_list->LoadDefaultValues(); // Load default values
		} else {
			$t09_siswanonrutintemp_list->LoadRowValues($t09_siswanonrutintemp_list->Recordset); // Load row values
		}
		$t09_siswanonrutintemp->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($t09_siswanonrutintemp->CurrentAction == "gridedit") { // Grid edit
			if ($t09_siswanonrutintemp->EventCancelled) {
				$t09_siswanonrutintemp_list->RestoreCurrentRowFormValues($t09_siswanonrutintemp_list->RowIndex); // Restore form values
			}
			if ($t09_siswanonrutintemp_list->RowAction == "insert")
				$t09_siswanonrutintemp->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$t09_siswanonrutintemp->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($t09_siswanonrutintemp->CurrentAction == "gridedit" && ($t09_siswanonrutintemp->RowType == EW_ROWTYPE_EDIT || $t09_siswanonrutintemp->RowType == EW_ROWTYPE_ADD) && $t09_siswanonrutintemp->EventCancelled) // Update failed
			$t09_siswanonrutintemp_list->RestoreCurrentRowFormValues($t09_siswanonrutintemp_list->RowIndex); // Restore form values
		if ($t09_siswanonrutintemp->RowType == EW_ROWTYPE_EDIT) // Edit row
			$t09_siswanonrutintemp_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$t09_siswanonrutintemp->RowAttrs = array_merge($t09_siswanonrutintemp->RowAttrs, array('data-rowindex'=>$t09_siswanonrutintemp_list->RowCnt, 'id'=>'r' . $t09_siswanonrutintemp_list->RowCnt . '_t09_siswanonrutintemp', 'data-rowtype'=>$t09_siswanonrutintemp->RowType));

		// Render row
		$t09_siswanonrutintemp_list->RenderRow();

		// Render list options
		$t09_siswanonrutintemp_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($t09_siswanonrutintemp_list->RowAction <> "delete" && $t09_siswanonrutintemp_list->RowAction <> "insertdelete" && !($t09_siswanonrutintemp_list->RowAction == "insert" && $t09_siswanonrutintemp->CurrentAction == "F" && $t09_siswanonrutintemp_list->EmptyRow())) {
?>
	<tr<?php echo $t09_siswanonrutintemp->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t09_siswanonrutintemp_list->ListOptions->Render("body", "left", $t09_siswanonrutintemp_list->RowCnt);
?>
	<?php if ($t09_siswanonrutintemp->siswa_id->Visible) { // siswa_id ?>
		<td data-name="siswa_id"<?php echo $t09_siswanonrutintemp->siswa_id->CellAttributes() ?>>
<?php if ($t09_siswanonrutintemp->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($t09_siswanonrutintemp->siswa_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $t09_siswanonrutintemp_list->RowCnt ?>_t09_siswanonrutintemp_siswa_id" class="form-group t09_siswanonrutintemp_siswa_id">
<span<?php echo $t09_siswanonrutintemp->siswa_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t09_siswanonrutintemp->siswa_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_siswa_id" name="x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_siswa_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->siswa_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $t09_siswanonrutintemp_list->RowCnt ?>_t09_siswanonrutintemp_siswa_id" class="form-group t09_siswanonrutintemp_siswa_id">
<input type="text" data-table="t09_siswanonrutintemp" data-field="x_siswa_id" name="x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_siswa_id" id="x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_siswa_id" size="30" placeholder="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->siswa_id->getPlaceHolder()) ?>" value="<?php echo $t09_siswanonrutintemp->siswa_id->EditValue ?>"<?php echo $t09_siswanonrutintemp->siswa_id->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_siswa_id" name="o<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_siswa_id" id="o<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_siswa_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->siswa_id->OldValue) ?>">
<?php } ?>
<?php if ($t09_siswanonrutintemp->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t09_siswanonrutintemp_list->RowCnt ?>_t09_siswanonrutintemp_siswa_id" class="form-group t09_siswanonrutintemp_siswa_id">
<span<?php echo $t09_siswanonrutintemp->siswa_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t09_siswanonrutintemp->siswa_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_siswa_id" name="x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_siswa_id" id="x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_siswa_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->siswa_id->CurrentValue) ?>">
<?php } ?>
<?php if ($t09_siswanonrutintemp->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t09_siswanonrutintemp_list->RowCnt ?>_t09_siswanonrutintemp_siswa_id" class="t09_siswanonrutintemp_siswa_id">
<span<?php echo $t09_siswanonrutintemp->siswa_id->ViewAttributes() ?>>
<?php echo $t09_siswanonrutintemp->siswa_id->ListViewValue() ?></span>
</span>
<?php } ?>
<a id="<?php echo $t09_siswanonrutintemp_list->PageObjName . "_row_" . $t09_siswanonrutintemp_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($t09_siswanonrutintemp->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_id" name="x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_id" id="x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->id->CurrentValue) ?>">
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_id" name="o<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_id" id="o<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->id->OldValue) ?>">
<?php } ?>
<?php if ($t09_siswanonrutintemp->RowType == EW_ROWTYPE_EDIT || $t09_siswanonrutintemp->CurrentMode == "edit") { ?>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_id" name="x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_id" id="x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->id->CurrentValue) ?>">
<?php } ?>
	<?php if ($t09_siswanonrutintemp->nonrutin_id->Visible) { // nonrutin_id ?>
		<td data-name="nonrutin_id"<?php echo $t09_siswanonrutintemp->nonrutin_id->CellAttributes() ?>>
<?php if ($t09_siswanonrutintemp->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t09_siswanonrutintemp_list->RowCnt ?>_t09_siswanonrutintemp_nonrutin_id" class="form-group t09_siswanonrutintemp_nonrutin_id">
<?php
$wrkonchange = trim(" " . @$t09_siswanonrutintemp->nonrutin_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t09_siswanonrutintemp->nonrutin_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_nonrutin_id" style="white-space: nowrap; z-index: <?php echo (9000 - $t09_siswanonrutintemp_list->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_nonrutin_id" id="sv_x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_nonrutin_id" value="<?php echo $t09_siswanonrutintemp->nonrutin_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->nonrutin_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->nonrutin_id->getPlaceHolder()) ?>"<?php echo $t09_siswanonrutintemp->nonrutin_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_nonrutin_id" data-value-separator="<?php echo $t09_siswanonrutintemp->nonrutin_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_nonrutin_id" id="x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_nonrutin_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->nonrutin_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_nonrutin_id" id="q_x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_nonrutin_id" value="<?php echo $t09_siswanonrutintemp->nonrutin_id->LookupFilterQuery(true) ?>">
<script type="text/javascript">
ft09_siswanonrutintemplist.CreateAutoSuggest({"id":"x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_nonrutin_id","forceSelect":false});
</script>
</span>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_nonrutin_id" name="o<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_nonrutin_id" id="o<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_nonrutin_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->nonrutin_id->OldValue) ?>">
<?php } ?>
<?php if ($t09_siswanonrutintemp->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t09_siswanonrutintemp_list->RowCnt ?>_t09_siswanonrutintemp_nonrutin_id" class="form-group t09_siswanonrutintemp_nonrutin_id">
<span<?php echo $t09_siswanonrutintemp->nonrutin_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t09_siswanonrutintemp->nonrutin_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_nonrutin_id" name="x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_nonrutin_id" id="x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_nonrutin_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->nonrutin_id->CurrentValue) ?>">
<?php } ?>
<?php if ($t09_siswanonrutintemp->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t09_siswanonrutintemp_list->RowCnt ?>_t09_siswanonrutintemp_nonrutin_id" class="t09_siswanonrutintemp_nonrutin_id">
<span<?php echo $t09_siswanonrutintemp->nonrutin_id->ViewAttributes() ?>>
<?php echo $t09_siswanonrutintemp->nonrutin_id->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t09_siswanonrutintemp->siswanonrutin_id->Visible) { // siswanonrutin_id ?>
		<td data-name="siswanonrutin_id"<?php echo $t09_siswanonrutintemp->siswanonrutin_id->CellAttributes() ?>>
<?php if ($t09_siswanonrutintemp->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t09_siswanonrutintemp_list->RowCnt ?>_t09_siswanonrutintemp_siswanonrutin_id" class="form-group t09_siswanonrutintemp_siswanonrutin_id">
<input type="text" data-table="t09_siswanonrutintemp" data-field="x_siswanonrutin_id" name="x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_siswanonrutin_id" id="x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_siswanonrutin_id" size="30" placeholder="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->siswanonrutin_id->getPlaceHolder()) ?>" value="<?php echo $t09_siswanonrutintemp->siswanonrutin_id->EditValue ?>"<?php echo $t09_siswanonrutintemp->siswanonrutin_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_siswanonrutin_id" name="o<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_siswanonrutin_id" id="o<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_siswanonrutin_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->siswanonrutin_id->OldValue) ?>">
<?php } ?>
<?php if ($t09_siswanonrutintemp->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t09_siswanonrutintemp_list->RowCnt ?>_t09_siswanonrutintemp_siswanonrutin_id" class="form-group t09_siswanonrutintemp_siswanonrutin_id">
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_siswanonrutin_id" name="x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_siswanonrutin_id" id="x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_siswanonrutin_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->siswanonrutin_id->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($t09_siswanonrutintemp->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t09_siswanonrutintemp_list->RowCnt ?>_t09_siswanonrutintemp_siswanonrutin_id" class="t09_siswanonrutintemp_siswanonrutin_id">
<span<?php echo $t09_siswanonrutintemp->siswanonrutin_id->ViewAttributes() ?>>
<?php echo $t09_siswanonrutintemp->siswanonrutin_id->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t09_siswanonrutintemp->Nilai->Visible) { // Nilai ?>
		<td data-name="Nilai"<?php echo $t09_siswanonrutintemp->Nilai->CellAttributes() ?>>
<?php if ($t09_siswanonrutintemp->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t09_siswanonrutintemp_list->RowCnt ?>_t09_siswanonrutintemp_Nilai" class="form-group t09_siswanonrutintemp_Nilai">
<input type="text" data-table="t09_siswanonrutintemp" data-field="x_Nilai" name="x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_Nilai" id="x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_Nilai" size="30" placeholder="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->Nilai->getPlaceHolder()) ?>" value="<?php echo $t09_siswanonrutintemp->Nilai->EditValue ?>"<?php echo $t09_siswanonrutintemp->Nilai->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_Nilai" name="o<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_Nilai" id="o<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_Nilai" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->Nilai->OldValue) ?>">
<?php } ?>
<?php if ($t09_siswanonrutintemp->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t09_siswanonrutintemp_list->RowCnt ?>_t09_siswanonrutintemp_Nilai" class="form-group t09_siswanonrutintemp_Nilai">
<span<?php echo $t09_siswanonrutintemp->Nilai->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t09_siswanonrutintemp->Nilai->EditValue ?></p></span>
</span>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_Nilai" name="x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_Nilai" id="x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_Nilai" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->Nilai->CurrentValue) ?>">
<?php } ?>
<?php if ($t09_siswanonrutintemp->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t09_siswanonrutintemp_list->RowCnt ?>_t09_siswanonrutintemp_Nilai" class="t09_siswanonrutintemp_Nilai">
<span<?php echo $t09_siswanonrutintemp->Nilai->ViewAttributes() ?>>
<?php echo $t09_siswanonrutintemp->Nilai->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t09_siswanonrutintemp->Bayar->Visible) { // Bayar ?>
		<td data-name="Bayar"<?php echo $t09_siswanonrutintemp->Bayar->CellAttributes() ?>>
<?php if ($t09_siswanonrutintemp->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t09_siswanonrutintemp_list->RowCnt ?>_t09_siswanonrutintemp_Bayar" class="form-group t09_siswanonrutintemp_Bayar">
<input type="text" data-table="t09_siswanonrutintemp" data-field="x_Bayar" name="x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_Bayar" id="x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_Bayar" size="10" placeholder="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->Bayar->getPlaceHolder()) ?>" value="<?php echo $t09_siswanonrutintemp->Bayar->EditValue ?>"<?php echo $t09_siswanonrutintemp->Bayar->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_Bayar" name="o<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_Bayar" id="o<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_Bayar" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->Bayar->OldValue) ?>">
<?php } ?>
<?php if ($t09_siswanonrutintemp->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t09_siswanonrutintemp_list->RowCnt ?>_t09_siswanonrutintemp_Bayar" class="form-group t09_siswanonrutintemp_Bayar">
<input type="text" data-table="t09_siswanonrutintemp" data-field="x_Bayar" name="x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_Bayar" id="x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_Bayar" size="10" placeholder="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->Bayar->getPlaceHolder()) ?>" value="<?php echo $t09_siswanonrutintemp->Bayar->EditValue ?>"<?php echo $t09_siswanonrutintemp->Bayar->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t09_siswanonrutintemp->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t09_siswanonrutintemp_list->RowCnt ?>_t09_siswanonrutintemp_Bayar" class="t09_siswanonrutintemp_Bayar">
<span<?php echo $t09_siswanonrutintemp->Bayar->ViewAttributes() ?>>
<?php echo $t09_siswanonrutintemp->Bayar->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t09_siswanonrutintemp->Sisa->Visible) { // Sisa ?>
		<td data-name="Sisa"<?php echo $t09_siswanonrutintemp->Sisa->CellAttributes() ?>>
<?php if ($t09_siswanonrutintemp->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t09_siswanonrutintemp_list->RowCnt ?>_t09_siswanonrutintemp_Sisa" class="form-group t09_siswanonrutintemp_Sisa">
<input type="text" data-table="t09_siswanonrutintemp" data-field="x_Sisa" name="x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_Sisa" id="x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_Sisa" size="10" placeholder="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->Sisa->getPlaceHolder()) ?>" value="<?php echo $t09_siswanonrutintemp->Sisa->EditValue ?>"<?php echo $t09_siswanonrutintemp->Sisa->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_Sisa" name="o<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_Sisa" id="o<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_Sisa" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->Sisa->OldValue) ?>">
<?php } ?>
<?php if ($t09_siswanonrutintemp->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t09_siswanonrutintemp_list->RowCnt ?>_t09_siswanonrutintemp_Sisa" class="form-group t09_siswanonrutintemp_Sisa">
<input type="text" data-table="t09_siswanonrutintemp" data-field="x_Sisa" name="x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_Sisa" id="x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_Sisa" size="10" placeholder="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->Sisa->getPlaceHolder()) ?>" value="<?php echo $t09_siswanonrutintemp->Sisa->EditValue ?>"<?php echo $t09_siswanonrutintemp->Sisa->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t09_siswanonrutintemp->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t09_siswanonrutintemp_list->RowCnt ?>_t09_siswanonrutintemp_Sisa" class="t09_siswanonrutintemp_Sisa">
<span<?php echo $t09_siswanonrutintemp->Sisa->ViewAttributes() ?>>
<?php echo $t09_siswanonrutintemp->Sisa->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t09_siswanonrutintemp_list->ListOptions->Render("body", "right", $t09_siswanonrutintemp_list->RowCnt);
?>
	</tr>
<?php if ($t09_siswanonrutintemp->RowType == EW_ROWTYPE_ADD || $t09_siswanonrutintemp->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ft09_siswanonrutintemplist.UpdateOpts(<?php echo $t09_siswanonrutintemp_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($t09_siswanonrutintemp->CurrentAction <> "gridadd")
		if (!$t09_siswanonrutintemp_list->Recordset->EOF) $t09_siswanonrutintemp_list->Recordset->MoveNext();
}
?>
<?php
	if ($t09_siswanonrutintemp->CurrentAction == "gridadd" || $t09_siswanonrutintemp->CurrentAction == "gridedit") {
		$t09_siswanonrutintemp_list->RowIndex = '$rowindex$';
		$t09_siswanonrutintemp_list->LoadDefaultValues();

		// Set row properties
		$t09_siswanonrutintemp->ResetAttrs();
		$t09_siswanonrutintemp->RowAttrs = array_merge($t09_siswanonrutintemp->RowAttrs, array('data-rowindex'=>$t09_siswanonrutintemp_list->RowIndex, 'id'=>'r0_t09_siswanonrutintemp', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($t09_siswanonrutintemp->RowAttrs["class"], "ewTemplate");
		$t09_siswanonrutintemp->RowType = EW_ROWTYPE_ADD;

		// Render row
		$t09_siswanonrutintemp_list->RenderRow();

		// Render list options
		$t09_siswanonrutintemp_list->RenderListOptions();
		$t09_siswanonrutintemp_list->StartRowCnt = 0;
?>
	<tr<?php echo $t09_siswanonrutintemp->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t09_siswanonrutintemp_list->ListOptions->Render("body", "left", $t09_siswanonrutintemp_list->RowIndex);
?>
	<?php if ($t09_siswanonrutintemp->siswa_id->Visible) { // siswa_id ?>
		<td data-name="siswa_id">
<?php if ($t09_siswanonrutintemp->siswa_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_t09_siswanonrutintemp_siswa_id" class="form-group t09_siswanonrutintemp_siswa_id">
<span<?php echo $t09_siswanonrutintemp->siswa_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t09_siswanonrutintemp->siswa_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_siswa_id" name="x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_siswa_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->siswa_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_t09_siswanonrutintemp_siswa_id" class="form-group t09_siswanonrutintemp_siswa_id">
<input type="text" data-table="t09_siswanonrutintemp" data-field="x_siswa_id" name="x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_siswa_id" id="x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_siswa_id" size="30" placeholder="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->siswa_id->getPlaceHolder()) ?>" value="<?php echo $t09_siswanonrutintemp->siswa_id->EditValue ?>"<?php echo $t09_siswanonrutintemp->siswa_id->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_siswa_id" name="o<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_siswa_id" id="o<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_siswa_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->siswa_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t09_siswanonrutintemp->nonrutin_id->Visible) { // nonrutin_id ?>
		<td data-name="nonrutin_id">
<span id="el$rowindex$_t09_siswanonrutintemp_nonrutin_id" class="form-group t09_siswanonrutintemp_nonrutin_id">
<?php
$wrkonchange = trim(" " . @$t09_siswanonrutintemp->nonrutin_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t09_siswanonrutintemp->nonrutin_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_nonrutin_id" style="white-space: nowrap; z-index: <?php echo (9000 - $t09_siswanonrutintemp_list->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_nonrutin_id" id="sv_x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_nonrutin_id" value="<?php echo $t09_siswanonrutintemp->nonrutin_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->nonrutin_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->nonrutin_id->getPlaceHolder()) ?>"<?php echo $t09_siswanonrutintemp->nonrutin_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_nonrutin_id" data-value-separator="<?php echo $t09_siswanonrutintemp->nonrutin_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_nonrutin_id" id="x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_nonrutin_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->nonrutin_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_nonrutin_id" id="q_x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_nonrutin_id" value="<?php echo $t09_siswanonrutintemp->nonrutin_id->LookupFilterQuery(true) ?>">
<script type="text/javascript">
ft09_siswanonrutintemplist.CreateAutoSuggest({"id":"x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_nonrutin_id","forceSelect":false});
</script>
</span>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_nonrutin_id" name="o<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_nonrutin_id" id="o<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_nonrutin_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->nonrutin_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t09_siswanonrutintemp->siswanonrutin_id->Visible) { // siswanonrutin_id ?>
		<td data-name="siswanonrutin_id">
<span id="el$rowindex$_t09_siswanonrutintemp_siswanonrutin_id" class="form-group t09_siswanonrutintemp_siswanonrutin_id">
<input type="text" data-table="t09_siswanonrutintemp" data-field="x_siswanonrutin_id" name="x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_siswanonrutin_id" id="x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_siswanonrutin_id" size="30" placeholder="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->siswanonrutin_id->getPlaceHolder()) ?>" value="<?php echo $t09_siswanonrutintemp->siswanonrutin_id->EditValue ?>"<?php echo $t09_siswanonrutintemp->siswanonrutin_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_siswanonrutin_id" name="o<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_siswanonrutin_id" id="o<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_siswanonrutin_id" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->siswanonrutin_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t09_siswanonrutintemp->Nilai->Visible) { // Nilai ?>
		<td data-name="Nilai">
<span id="el$rowindex$_t09_siswanonrutintemp_Nilai" class="form-group t09_siswanonrutintemp_Nilai">
<input type="text" data-table="t09_siswanonrutintemp" data-field="x_Nilai" name="x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_Nilai" id="x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_Nilai" size="30" placeholder="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->Nilai->getPlaceHolder()) ?>" value="<?php echo $t09_siswanonrutintemp->Nilai->EditValue ?>"<?php echo $t09_siswanonrutintemp->Nilai->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_Nilai" name="o<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_Nilai" id="o<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_Nilai" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->Nilai->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t09_siswanonrutintemp->Bayar->Visible) { // Bayar ?>
		<td data-name="Bayar">
<span id="el$rowindex$_t09_siswanonrutintemp_Bayar" class="form-group t09_siswanonrutintemp_Bayar">
<input type="text" data-table="t09_siswanonrutintemp" data-field="x_Bayar" name="x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_Bayar" id="x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_Bayar" size="10" placeholder="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->Bayar->getPlaceHolder()) ?>" value="<?php echo $t09_siswanonrutintemp->Bayar->EditValue ?>"<?php echo $t09_siswanonrutintemp->Bayar->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_Bayar" name="o<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_Bayar" id="o<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_Bayar" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->Bayar->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t09_siswanonrutintemp->Sisa->Visible) { // Sisa ?>
		<td data-name="Sisa">
<span id="el$rowindex$_t09_siswanonrutintemp_Sisa" class="form-group t09_siswanonrutintemp_Sisa">
<input type="text" data-table="t09_siswanonrutintemp" data-field="x_Sisa" name="x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_Sisa" id="x<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_Sisa" size="10" placeholder="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->Sisa->getPlaceHolder()) ?>" value="<?php echo $t09_siswanonrutintemp->Sisa->EditValue ?>"<?php echo $t09_siswanonrutintemp->Sisa->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t09_siswanonrutintemp" data-field="x_Sisa" name="o<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_Sisa" id="o<?php echo $t09_siswanonrutintemp_list->RowIndex ?>_Sisa" value="<?php echo ew_HtmlEncode($t09_siswanonrutintemp->Sisa->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t09_siswanonrutintemp_list->ListOptions->Render("body", "right", $t09_siswanonrutintemp_list->RowCnt);
?>
<script type="text/javascript">
ft09_siswanonrutintemplist.UpdateOpts(<?php echo $t09_siswanonrutintemp_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($t09_siswanonrutintemp->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $t09_siswanonrutintemp_list->FormKeyCountName ?>" id="<?php echo $t09_siswanonrutintemp_list->FormKeyCountName ?>" value="<?php echo $t09_siswanonrutintemp_list->KeyCount ?>">
<?php echo $t09_siswanonrutintemp_list->MultiSelectKey ?>
<?php } ?>
<?php if ($t09_siswanonrutintemp->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($t09_siswanonrutintemp_list->Recordset)
	$t09_siswanonrutintemp_list->Recordset->Close();
?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($t09_siswanonrutintemp->CurrentAction <> "gridadd" && $t09_siswanonrutintemp->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($t09_siswanonrutintemp_list->Pager)) $t09_siswanonrutintemp_list->Pager = new cPrevNextPager($t09_siswanonrutintemp_list->StartRec, $t09_siswanonrutintemp_list->DisplayRecs, $t09_siswanonrutintemp_list->TotalRecs) ?>
<?php if ($t09_siswanonrutintemp_list->Pager->RecordCount > 0 && $t09_siswanonrutintemp_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($t09_siswanonrutintemp_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $t09_siswanonrutintemp_list->PageUrl() ?>start=<?php echo $t09_siswanonrutintemp_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($t09_siswanonrutintemp_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $t09_siswanonrutintemp_list->PageUrl() ?>start=<?php echo $t09_siswanonrutintemp_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $t09_siswanonrutintemp_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($t09_siswanonrutintemp_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $t09_siswanonrutintemp_list->PageUrl() ?>start=<?php echo $t09_siswanonrutintemp_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($t09_siswanonrutintemp_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $t09_siswanonrutintemp_list->PageUrl() ?>start=<?php echo $t09_siswanonrutintemp_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $t09_siswanonrutintemp_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $t09_siswanonrutintemp_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $t09_siswanonrutintemp_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $t09_siswanonrutintemp_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t09_siswanonrutintemp_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($t09_siswanonrutintemp_list->TotalRecs == 0 && $t09_siswanonrutintemp->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t09_siswanonrutintemp_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
ft09_siswanonrutintemplist.Init();
</script>
<?php
$t09_siswanonrutintemp_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t09_siswanonrutintemp_list->Page_Terminate();
?>
