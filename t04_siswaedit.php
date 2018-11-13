<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "t04_siswainfo.php" ?>
<?php include_once "t06_siswarutingridcls.php" ?>
<?php include_once "t09_siswanonrutingridcls.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$t04_siswa_edit = NULL; // Initialize page object first

class ct04_siswa_edit extends ct04_siswa {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{64CABE7A-1609-4157-8293-D7242B591905}";

	// Table name
	var $TableName = 't04_siswa';

	// Page object name
	var $PageObjName = 't04_siswa_edit';

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

		// Table object (t04_siswa)
		if (!isset($GLOBALS["t04_siswa"]) || get_class($GLOBALS["t04_siswa"]) == "ct04_siswa") {
			$GLOBALS["t04_siswa"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t04_siswa"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't04_siswa', TRUE);

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

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->sekolah_id->SetVisibility();
		$this->kelas_id->SetVisibility();
		$this->NIS->SetVisibility();
		$this->Nama->SetVisibility();

		// Set up detail page object
		$this->SetupDetailPages();

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

			// Process auto fill for detail table 't06_siswarutin'
			if (@$_POST["grid"] == "ft06_siswarutingrid") {
				if (!isset($GLOBALS["t06_siswarutin_grid"])) $GLOBALS["t06_siswarutin_grid"] = new ct06_siswarutin_grid;
				$GLOBALS["t06_siswarutin_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 't09_siswanonrutin'
			if (@$_POST["grid"] == "ft09_siswanonrutingrid") {
				if (!isset($GLOBALS["t09_siswanonrutin_grid"])) $GLOBALS["t09_siswanonrutin_grid"] = new ct09_siswanonrutin_grid;
				$GLOBALS["t09_siswanonrutin_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}
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
		global $EW_EXPORT, $t04_siswa;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t04_siswa);
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
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $IsModal = FALSE;
	var $DbMasterFilter;
	var $DbDetailFilter;
	var $DetailPages; // Detail pages object

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;
		global $gbSkipHeaderFooter;

		// Check modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;

		// Load key from QueryString
		if (@$_GET["id"] <> "") {
			$this->id->setQueryStringValue($_GET["id"]);
		}

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Set up detail parameters
			$this->SetUpDetailParms();
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->id->CurrentValue == "") {
			$this->Page_Terminate("t04_siswalist.php"); // Invalid key, return to list
		}

		// Validate form if post back
		if (@$_POST["a_edit"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("t04_siswalist.php"); // No matching record, return to list
				}

				// Set up detail parameters
				$this->SetUpDetailParms();
				break;
			Case "U": // Update
				if ($this->getCurrentDetailTable() <> "") // Master/detail edit
					$sReturnUrl = $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=" . $this->getCurrentDetailTable()); // Master/Detail view page
				else
					$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "t04_siswalist.php")
					$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} elseif ($this->getFailureMessage() == $Language->Phrase("NoRecord")) {
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed

					// Set up detail parameters
					$this->SetUpDetailParms();
				}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
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

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->sekolah_id->FldIsDetailKey) {
			$this->sekolah_id->setFormValue($objForm->GetValue("x_sekolah_id"));
		}
		if (!$this->kelas_id->FldIsDetailKey) {
			$this->kelas_id->setFormValue($objForm->GetValue("x_kelas_id"));
		}
		if (!$this->NIS->FldIsDetailKey) {
			$this->NIS->setFormValue($objForm->GetValue("x_NIS"));
		}
		if (!$this->Nama->FldIsDetailKey) {
			$this->Nama->setFormValue($objForm->GetValue("x_Nama"));
		}
		if (!$this->id->FldIsDetailKey)
			$this->id->setFormValue($objForm->GetValue("x_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->id->CurrentValue = $this->id->FormValue;
		$this->sekolah_id->CurrentValue = $this->sekolah_id->FormValue;
		$this->kelas_id->CurrentValue = $this->kelas_id->FormValue;
		$this->NIS->CurrentValue = $this->NIS->FormValue;
		$this->Nama->CurrentValue = $this->Nama->FormValue;
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
		$this->sekolah_id->setDbValue($rs->fields('sekolah_id'));
		$this->kelas_id->setDbValue($rs->fields('kelas_id'));
		$this->NIS->setDbValue($rs->fields('NIS'));
		$this->Nama->setDbValue($rs->fields('Nama'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->sekolah_id->DbValue = $row['sekolah_id'];
		$this->kelas_id->DbValue = $row['kelas_id'];
		$this->NIS->DbValue = $row['NIS'];
		$this->Nama->DbValue = $row['Nama'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// sekolah_id
		// kelas_id
		// NIS
		// Nama

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// sekolah_id
		if (strval($this->sekolah_id->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->sekolah_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `Sekolah` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t02_sekolah`";
		$sWhereWrk = "";
		$this->sekolah_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->sekolah_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->sekolah_id->ViewValue = $this->sekolah_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->sekolah_id->ViewValue = $this->sekolah_id->CurrentValue;
			}
		} else {
			$this->sekolah_id->ViewValue = NULL;
		}
		$this->sekolah_id->ViewCustomAttributes = "";

		// kelas_id
		if (strval($this->kelas_id->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->kelas_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `Kelas` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t03_kelas`";
		$sWhereWrk = "";
		$this->kelas_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->kelas_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->kelas_id->ViewValue = $this->kelas_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->kelas_id->ViewValue = $this->kelas_id->CurrentValue;
			}
		} else {
			$this->kelas_id->ViewValue = NULL;
		}
		$this->kelas_id->ViewCustomAttributes = "";

		// NIS
		$this->NIS->ViewValue = $this->NIS->CurrentValue;
		$this->NIS->ViewCustomAttributes = "";

		// Nama
		$this->Nama->ViewValue = $this->Nama->CurrentValue;
		$this->Nama->ViewCustomAttributes = "";

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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// sekolah_id
			$this->sekolah_id->EditAttrs["class"] = "form-control";
			$this->sekolah_id->EditCustomAttributes = "";
			if (trim(strval($this->sekolah_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->sekolah_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `Sekolah` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `t02_sekolah`";
			$sWhereWrk = "";
			$this->sekolah_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->sekolah_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->sekolah_id->EditValue = $arwrk;

			// kelas_id
			$this->kelas_id->EditAttrs["class"] = "form-control";
			$this->kelas_id->EditCustomAttributes = "";
			if (trim(strval($this->kelas_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->kelas_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `Kelas` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `sekolah_id` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `t03_kelas`";
			$sWhereWrk = "";
			$this->kelas_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->kelas_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->kelas_id->EditValue = $arwrk;

			// NIS
			$this->NIS->EditAttrs["class"] = "form-control";
			$this->NIS->EditCustomAttributes = "";
			$this->NIS->EditValue = ew_HtmlEncode($this->NIS->CurrentValue);
			$this->NIS->PlaceHolder = ew_RemoveHtml($this->NIS->FldCaption());

			// Nama
			$this->Nama->EditAttrs["class"] = "form-control";
			$this->Nama->EditCustomAttributes = "";
			$this->Nama->EditValue = ew_HtmlEncode($this->Nama->CurrentValue);
			$this->Nama->PlaceHolder = ew_RemoveHtml($this->Nama->FldCaption());

			// Edit refer script
			// sekolah_id

			$this->sekolah_id->LinkCustomAttributes = "";
			$this->sekolah_id->HrefValue = "";

			// kelas_id
			$this->kelas_id->LinkCustomAttributes = "";
			$this->kelas_id->HrefValue = "";

			// NIS
			$this->NIS->LinkCustomAttributes = "";
			$this->NIS->HrefValue = "";

			// Nama
			$this->Nama->LinkCustomAttributes = "";
			$this->Nama->HrefValue = "";
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
		if (!$this->sekolah_id->FldIsDetailKey && !is_null($this->sekolah_id->FormValue) && $this->sekolah_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->sekolah_id->FldCaption(), $this->sekolah_id->ReqErrMsg));
		}
		if (!$this->kelas_id->FldIsDetailKey && !is_null($this->kelas_id->FormValue) && $this->kelas_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->kelas_id->FldCaption(), $this->kelas_id->ReqErrMsg));
		}
		if (!$this->NIS->FldIsDetailKey && !is_null($this->NIS->FormValue) && $this->NIS->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->NIS->FldCaption(), $this->NIS->ReqErrMsg));
		}
		if (!$this->Nama->FldIsDetailKey && !is_null($this->Nama->FormValue) && $this->Nama->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Nama->FldCaption(), $this->Nama->ReqErrMsg));
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("t06_siswarutin", $DetailTblVar) && $GLOBALS["t06_siswarutin"]->DetailEdit) {
			if (!isset($GLOBALS["t06_siswarutin_grid"])) $GLOBALS["t06_siswarutin_grid"] = new ct06_siswarutin_grid(); // get detail page object
			$GLOBALS["t06_siswarutin_grid"]->ValidateGridForm();
		}
		if (in_array("t09_siswanonrutin", $DetailTblVar) && $GLOBALS["t09_siswanonrutin"]->DetailEdit) {
			if (!isset($GLOBALS["t09_siswanonrutin_grid"])) $GLOBALS["t09_siswanonrutin_grid"] = new ct09_siswanonrutin_grid(); // get detail page object
			$GLOBALS["t09_siswanonrutin_grid"]->ValidateGridForm();
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

			// Begin transaction
			if ($this->getCurrentDetailTable() <> "")
				$conn->BeginTrans();

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// sekolah_id
			$this->sekolah_id->SetDbValueDef($rsnew, $this->sekolah_id->CurrentValue, 0, $this->sekolah_id->ReadOnly);

			// kelas_id
			$this->kelas_id->SetDbValueDef($rsnew, $this->kelas_id->CurrentValue, 0, $this->kelas_id->ReadOnly);

			// NIS
			$this->NIS->SetDbValueDef($rsnew, $this->NIS->CurrentValue, "", $this->NIS->ReadOnly);

			// Nama
			$this->Nama->SetDbValueDef($rsnew, $this->Nama->CurrentValue, "", $this->Nama->ReadOnly);

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

				// Update detail records
				$DetailTblVar = explode(",", $this->getCurrentDetailTable());
				if ($EditRow) {
					if (in_array("t06_siswarutin", $DetailTblVar) && $GLOBALS["t06_siswarutin"]->DetailEdit) {
						if (!isset($GLOBALS["t06_siswarutin_grid"])) $GLOBALS["t06_siswarutin_grid"] = new ct06_siswarutin_grid(); // Get detail page object
						$EditRow = $GLOBALS["t06_siswarutin_grid"]->GridUpdate();
					}
				}
				if ($EditRow) {
					if (in_array("t09_siswanonrutin", $DetailTblVar) && $GLOBALS["t09_siswanonrutin"]->DetailEdit) {
						if (!isset($GLOBALS["t09_siswanonrutin_grid"])) $GLOBALS["t09_siswanonrutin_grid"] = new ct09_siswanonrutin_grid(); // Get detail page object
						$EditRow = $GLOBALS["t09_siswanonrutin_grid"]->GridUpdate();
					}
				}

				// Commit/Rollback transaction
				if ($this->getCurrentDetailTable() <> "") {
					if ($EditRow) {
						$conn->CommitTrans(); // Commit transaction
					} else {
						$conn->RollbackTrans(); // Rollback transaction
					}
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

	// Set up detail parms based on QueryString
	function SetUpDetailParms() {

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_DETAIL])) {
			$sDetailTblVar = $_GET[EW_TABLE_SHOW_DETAIL];
			$this->setCurrentDetailTable($sDetailTblVar);
		} else {
			$sDetailTblVar = $this->getCurrentDetailTable();
		}
		if ($sDetailTblVar <> "") {
			$DetailTblVar = explode(",", $sDetailTblVar);
			if (in_array("t06_siswarutin", $DetailTblVar)) {
				if (!isset($GLOBALS["t06_siswarutin_grid"]))
					$GLOBALS["t06_siswarutin_grid"] = new ct06_siswarutin_grid;
				if ($GLOBALS["t06_siswarutin_grid"]->DetailEdit) {
					$GLOBALS["t06_siswarutin_grid"]->CurrentMode = "edit";
					$GLOBALS["t06_siswarutin_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["t06_siswarutin_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["t06_siswarutin_grid"]->setStartRecordNumber(1);
					$GLOBALS["t06_siswarutin_grid"]->siswa_id->FldIsDetailKey = TRUE;
					$GLOBALS["t06_siswarutin_grid"]->siswa_id->CurrentValue = $this->id->CurrentValue;
					$GLOBALS["t06_siswarutin_grid"]->siswa_id->setSessionValue($GLOBALS["t06_siswarutin_grid"]->siswa_id->CurrentValue);
				}
			}
			if (in_array("t09_siswanonrutin", $DetailTblVar)) {
				if (!isset($GLOBALS["t09_siswanonrutin_grid"]))
					$GLOBALS["t09_siswanonrutin_grid"] = new ct09_siswanonrutin_grid;
				if ($GLOBALS["t09_siswanonrutin_grid"]->DetailEdit) {
					$GLOBALS["t09_siswanonrutin_grid"]->CurrentMode = "edit";
					$GLOBALS["t09_siswanonrutin_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["t09_siswanonrutin_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["t09_siswanonrutin_grid"]->setStartRecordNumber(1);
					$GLOBALS["t09_siswanonrutin_grid"]->siswa_id->FldIsDetailKey = TRUE;
					$GLOBALS["t09_siswanonrutin_grid"]->siswa_id->CurrentValue = $this->id->CurrentValue;
					$GLOBALS["t09_siswanonrutin_grid"]->siswa_id->setSessionValue($GLOBALS["t09_siswanonrutin_grid"]->siswa_id->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t04_siswalist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
	}

	// Set up detail pages
	function SetupDetailPages() {
		$pages = new cSubPages();
		$pages->Style = "tabs";
		$pages->Add('t06_siswarutin');
		$pages->Add('t09_siswanonrutin');
		$this->DetailPages = $pages;
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_sekolah_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `Sekolah` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t02_sekolah`";
			$sWhereWrk = "";
			$this->sekolah_id->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->sekolah_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_kelas_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `Kelas` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t03_kelas`";
			$sWhereWrk = "{filter}";
			$this->kelas_id->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` = {filter_value}', "t0" => "3", "fn0" => "", "f1" => '`sekolah_id` IN ({filter_value})', "t1" => "3", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->kelas_id, $sWhereWrk); // Call Lookup selecting
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($t04_siswa_edit)) $t04_siswa_edit = new ct04_siswa_edit();

// Page init
$t04_siswa_edit->Page_Init();

// Page main
$t04_siswa_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t04_siswa_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = ft04_siswaedit = new ew_Form("ft04_siswaedit", "edit");

// Validate form
ft04_siswaedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_sekolah_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t04_siswa->sekolah_id->FldCaption(), $t04_siswa->sekolah_id->ReqErrMsg)) ?>");
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
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
ft04_siswaedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft04_siswaedit.ValidateRequired = true;
<?php } else { ?>
ft04_siswaedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft04_siswaedit.Lists["x_sekolah_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_Sekolah","","",""],"ParentFields":[],"ChildFields":["x_kelas_id"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t02_sekolah"};
ft04_siswaedit.Lists["x_kelas_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_Kelas","","",""],"ParentFields":["x_sekolah_id"],"ChildFields":[],"FilterFields":["x_sekolah_id"],"Options":[],"Template":"","LinkTable":"t03_kelas"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$t04_siswa_edit->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $t04_siswa_edit->ShowPageHeader(); ?>
<?php
$t04_siswa_edit->ShowMessage();
?>
<form name="ft04_siswaedit" id="ft04_siswaedit" class="<?php echo $t04_siswa_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t04_siswa_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t04_siswa_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t04_siswa">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($t04_siswa_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($t04_siswa->sekolah_id->Visible) { // sekolah_id ?>
	<div id="r_sekolah_id" class="form-group">
		<label id="elh_t04_siswa_sekolah_id" for="x_sekolah_id" class="col-sm-2 control-label ewLabel"><?php echo $t04_siswa->sekolah_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t04_siswa->sekolah_id->CellAttributes() ?>>
<span id="el_t04_siswa_sekolah_id">
<?php $t04_siswa->sekolah_id->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$t04_siswa->sekolah_id->EditAttrs["onchange"]; ?>
<select data-table="t04_siswa" data-field="x_sekolah_id" data-value-separator="<?php echo $t04_siswa->sekolah_id->DisplayValueSeparatorAttribute() ?>" id="x_sekolah_id" name="x_sekolah_id"<?php echo $t04_siswa->sekolah_id->EditAttributes() ?>>
<?php echo $t04_siswa->sekolah_id->SelectOptionListHtml("x_sekolah_id") ?>
</select>
<input type="hidden" name="s_x_sekolah_id" id="s_x_sekolah_id" value="<?php echo $t04_siswa->sekolah_id->LookupFilterQuery() ?>">
</span>
<?php echo $t04_siswa->sekolah_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t04_siswa->kelas_id->Visible) { // kelas_id ?>
	<div id="r_kelas_id" class="form-group">
		<label id="elh_t04_siswa_kelas_id" for="x_kelas_id" class="col-sm-2 control-label ewLabel"><?php echo $t04_siswa->kelas_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t04_siswa->kelas_id->CellAttributes() ?>>
<span id="el_t04_siswa_kelas_id">
<select data-table="t04_siswa" data-field="x_kelas_id" data-value-separator="<?php echo $t04_siswa->kelas_id->DisplayValueSeparatorAttribute() ?>" id="x_kelas_id" name="x_kelas_id"<?php echo $t04_siswa->kelas_id->EditAttributes() ?>>
<?php echo $t04_siswa->kelas_id->SelectOptionListHtml("x_kelas_id") ?>
</select>
<input type="hidden" name="s_x_kelas_id" id="s_x_kelas_id" value="<?php echo $t04_siswa->kelas_id->LookupFilterQuery() ?>">
</span>
<?php echo $t04_siswa->kelas_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t04_siswa->NIS->Visible) { // NIS ?>
	<div id="r_NIS" class="form-group">
		<label id="elh_t04_siswa_NIS" for="x_NIS" class="col-sm-2 control-label ewLabel"><?php echo $t04_siswa->NIS->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t04_siswa->NIS->CellAttributes() ?>>
<span id="el_t04_siswa_NIS">
<input type="text" data-table="t04_siswa" data-field="x_NIS" name="x_NIS" id="x_NIS" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($t04_siswa->NIS->getPlaceHolder()) ?>" value="<?php echo $t04_siswa->NIS->EditValue ?>"<?php echo $t04_siswa->NIS->EditAttributes() ?>>
</span>
<?php echo $t04_siswa->NIS->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t04_siswa->Nama->Visible) { // Nama ?>
	<div id="r_Nama" class="form-group">
		<label id="elh_t04_siswa_Nama" for="x_Nama" class="col-sm-2 control-label ewLabel"><?php echo $t04_siswa->Nama->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t04_siswa->Nama->CellAttributes() ?>>
<span id="el_t04_siswa_Nama">
<input type="text" data-table="t04_siswa" data-field="x_Nama" name="x_Nama" id="x_Nama" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($t04_siswa->Nama->getPlaceHolder()) ?>" value="<?php echo $t04_siswa->Nama->EditValue ?>"<?php echo $t04_siswa->Nama->EditAttributes() ?>>
</span>
<?php echo $t04_siswa->Nama->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<input type="hidden" data-table="t04_siswa" data-field="x_id" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($t04_siswa->id->CurrentValue) ?>">
<?php if ($t04_siswa->getCurrentDetailTable() <> "") { ?>
<?php
	$t04_siswa_edit->DetailPages->ValidKeys = explode(",", $t04_siswa->getCurrentDetailTable());
	$FirstActiveDetailTable = $t04_siswa_edit->DetailPages->ActivePageIndex();
?>
<div class="ewDetailPages">
<div class="tabbable" id="t04_siswa_edit_details">
	<ul class="nav<?php echo $t04_siswa_edit->DetailPages->NavStyle() ?>">
<?php
	if (in_array("t06_siswarutin", explode(",", $t04_siswa->getCurrentDetailTable())) && $t06_siswarutin->DetailEdit) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "t06_siswarutin") {
			$FirstActiveDetailTable = "t06_siswarutin";
		}
?>
		<li<?php echo $t04_siswa_edit->DetailPages->TabStyle("t06_siswarutin") ?>><a href="#tab_t06_siswarutin" data-toggle="tab"><?php echo $Language->TablePhrase("t06_siswarutin", "TblCaption") ?></a></li>
<?php
	}
?>
<?php
	if (in_array("t09_siswanonrutin", explode(",", $t04_siswa->getCurrentDetailTable())) && $t09_siswanonrutin->DetailEdit) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "t09_siswanonrutin") {
			$FirstActiveDetailTable = "t09_siswanonrutin";
		}
?>
		<li<?php echo $t04_siswa_edit->DetailPages->TabStyle("t09_siswanonrutin") ?>><a href="#tab_t09_siswanonrutin" data-toggle="tab"><?php echo $Language->TablePhrase("t09_siswanonrutin", "TblCaption") ?></a></li>
<?php
	}
?>
	</ul>
	<div class="tab-content">
<?php
	if (in_array("t06_siswarutin", explode(",", $t04_siswa->getCurrentDetailTable())) && $t06_siswarutin->DetailEdit) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "t06_siswarutin") {
			$FirstActiveDetailTable = "t06_siswarutin";
		}
?>
		<div class="tab-pane<?php echo $t04_siswa_edit->DetailPages->PageStyle("t06_siswarutin") ?>" id="tab_t06_siswarutin">
<?php include_once "t06_siswarutingrid.php" ?>
		</div>
<?php } ?>
<?php
	if (in_array("t09_siswanonrutin", explode(",", $t04_siswa->getCurrentDetailTable())) && $t09_siswanonrutin->DetailEdit) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "t09_siswanonrutin") {
			$FirstActiveDetailTable = "t09_siswanonrutin";
		}
?>
		<div class="tab-pane<?php echo $t04_siswa_edit->DetailPages->PageStyle("t09_siswanonrutin") ?>" id="tab_t09_siswanonrutin">
<?php include_once "t09_siswanonrutingrid.php" ?>
		</div>
<?php } ?>
	</div>
</div>
</div>
<?php } ?>
<?php if (!$t04_siswa_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t04_siswa_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ft04_siswaedit.Init();
</script>
<?php
$t04_siswa_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t04_siswa_edit->Page_Terminate();
?>
