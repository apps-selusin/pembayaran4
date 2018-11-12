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

$t01_tahunajaran_edit = NULL; // Initialize page object first

class ct01_tahunajaran_edit extends ct01_tahunajaran {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{64CABE7A-1609-4157-8293-D7242B591905}";

	// Table name
	var $TableName = 't01_tahunajaran';

	// Page object name
	var $PageObjName = 't01_tahunajaran_edit';

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
			define("EW_PAGE_ID", 'edit', TRUE);

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

		// Create form object
		$objForm = new cFormObj();
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
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->id->CurrentValue == "") {
			$this->Page_Terminate("t01_tahunajaranlist.php"); // Invalid key, return to list
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
					$this->Page_Terminate("t01_tahunajaranlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "t01_tahunajaranlist.php")
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
		if (!$this->Awal_Bulan->FldIsDetailKey) {
			$this->Awal_Bulan->setFormValue($objForm->GetValue("x_Awal_Bulan"));
		}
		if (!$this->Awal_Tahun->FldIsDetailKey) {
			$this->Awal_Tahun->setFormValue($objForm->GetValue("x_Awal_Tahun"));
		}
		if (!$this->Akhir_Bulan->FldIsDetailKey) {
			$this->Akhir_Bulan->setFormValue($objForm->GetValue("x_Akhir_Bulan"));
		}
		if (!$this->Akhir_Tahun->FldIsDetailKey) {
			$this->Akhir_Tahun->setFormValue($objForm->GetValue("x_Akhir_Tahun"));
		}
		if (!$this->Tahun_Ajaran->FldIsDetailKey) {
			$this->Tahun_Ajaran->setFormValue($objForm->GetValue("x_Tahun_Ajaran"));
		}
		if (!$this->Aktif->FldIsDetailKey) {
			$this->Aktif->setFormValue($objForm->GetValue("x_Aktif"));
		}
		if (!$this->id->FldIsDetailKey)
			$this->id->setFormValue($objForm->GetValue("x_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->id->CurrentValue = $this->id->FormValue;
		$this->Awal_Bulan->CurrentValue = $this->Awal_Bulan->FormValue;
		$this->Awal_Tahun->CurrentValue = $this->Awal_Tahun->FormValue;
		$this->Akhir_Bulan->CurrentValue = $this->Akhir_Bulan->FormValue;
		$this->Akhir_Tahun->CurrentValue = $this->Akhir_Tahun->FormValue;
		$this->Tahun_Ajaran->CurrentValue = $this->Tahun_Ajaran->FormValue;
		$this->Aktif->CurrentValue = $this->Aktif->FormValue;
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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Awal_Bulan
			$this->Awal_Bulan->EditAttrs["class"] = "form-control";
			$this->Awal_Bulan->EditCustomAttributes = "";
			$this->Awal_Bulan->EditValue = ew_HtmlEncode($this->Awal_Bulan->CurrentValue);
			$this->Awal_Bulan->PlaceHolder = ew_RemoveHtml($this->Awal_Bulan->FldCaption());

			// Awal_Tahun
			$this->Awal_Tahun->EditAttrs["class"] = "form-control";
			$this->Awal_Tahun->EditCustomAttributes = "";
			$this->Awal_Tahun->EditValue = ew_HtmlEncode($this->Awal_Tahun->CurrentValue);
			$this->Awal_Tahun->PlaceHolder = ew_RemoveHtml($this->Awal_Tahun->FldCaption());

			// Akhir_Bulan
			$this->Akhir_Bulan->EditAttrs["class"] = "form-control";
			$this->Akhir_Bulan->EditCustomAttributes = "";
			$this->Akhir_Bulan->EditValue = ew_HtmlEncode($this->Akhir_Bulan->CurrentValue);
			$this->Akhir_Bulan->PlaceHolder = ew_RemoveHtml($this->Akhir_Bulan->FldCaption());

			// Akhir_Tahun
			$this->Akhir_Tahun->EditAttrs["class"] = "form-control";
			$this->Akhir_Tahun->EditCustomAttributes = "";
			$this->Akhir_Tahun->EditValue = ew_HtmlEncode($this->Akhir_Tahun->CurrentValue);
			$this->Akhir_Tahun->PlaceHolder = ew_RemoveHtml($this->Akhir_Tahun->FldCaption());

			// Tahun_Ajaran
			$this->Tahun_Ajaran->EditAttrs["class"] = "form-control";
			$this->Tahun_Ajaran->EditCustomAttributes = "";
			$this->Tahun_Ajaran->EditValue = ew_HtmlEncode($this->Tahun_Ajaran->CurrentValue);
			$this->Tahun_Ajaran->PlaceHolder = ew_RemoveHtml($this->Tahun_Ajaran->FldCaption());

			// Aktif
			$this->Aktif->EditCustomAttributes = "";
			$this->Aktif->EditValue = $this->Aktif->Options(FALSE);

			// Edit refer script
			// Awal_Bulan

			$this->Awal_Bulan->LinkCustomAttributes = "";
			$this->Awal_Bulan->HrefValue = "";

			// Awal_Tahun
			$this->Awal_Tahun->LinkCustomAttributes = "";
			$this->Awal_Tahun->HrefValue = "";

			// Akhir_Bulan
			$this->Akhir_Bulan->LinkCustomAttributes = "";
			$this->Akhir_Bulan->HrefValue = "";

			// Akhir_Tahun
			$this->Akhir_Tahun->LinkCustomAttributes = "";
			$this->Akhir_Tahun->HrefValue = "";

			// Tahun_Ajaran
			$this->Tahun_Ajaran->LinkCustomAttributes = "";
			$this->Tahun_Ajaran->HrefValue = "";

			// Aktif
			$this->Aktif->LinkCustomAttributes = "";
			$this->Aktif->HrefValue = "";
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
		if (!$this->Awal_Bulan->FldIsDetailKey && !is_null($this->Awal_Bulan->FormValue) && $this->Awal_Bulan->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Awal_Bulan->FldCaption(), $this->Awal_Bulan->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->Awal_Bulan->FormValue)) {
			ew_AddMessage($gsFormError, $this->Awal_Bulan->FldErrMsg());
		}
		if (!$this->Awal_Tahun->FldIsDetailKey && !is_null($this->Awal_Tahun->FormValue) && $this->Awal_Tahun->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Awal_Tahun->FldCaption(), $this->Awal_Tahun->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->Awal_Tahun->FormValue)) {
			ew_AddMessage($gsFormError, $this->Awal_Tahun->FldErrMsg());
		}
		if (!$this->Akhir_Bulan->FldIsDetailKey && !is_null($this->Akhir_Bulan->FormValue) && $this->Akhir_Bulan->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Akhir_Bulan->FldCaption(), $this->Akhir_Bulan->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->Akhir_Bulan->FormValue)) {
			ew_AddMessage($gsFormError, $this->Akhir_Bulan->FldErrMsg());
		}
		if (!$this->Akhir_Tahun->FldIsDetailKey && !is_null($this->Akhir_Tahun->FormValue) && $this->Akhir_Tahun->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Akhir_Tahun->FldCaption(), $this->Akhir_Tahun->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->Akhir_Tahun->FormValue)) {
			ew_AddMessage($gsFormError, $this->Akhir_Tahun->FldErrMsg());
		}
		if (!$this->Tahun_Ajaran->FldIsDetailKey && !is_null($this->Tahun_Ajaran->FormValue) && $this->Tahun_Ajaran->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Tahun_Ajaran->FldCaption(), $this->Tahun_Ajaran->ReqErrMsg));
		}
		if ($this->Aktif->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Aktif->FldCaption(), $this->Aktif->ReqErrMsg));
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

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// Awal_Bulan
			$this->Awal_Bulan->SetDbValueDef($rsnew, $this->Awal_Bulan->CurrentValue, 0, $this->Awal_Bulan->ReadOnly);

			// Awal_Tahun
			$this->Awal_Tahun->SetDbValueDef($rsnew, $this->Awal_Tahun->CurrentValue, 0, $this->Awal_Tahun->ReadOnly);

			// Akhir_Bulan
			$this->Akhir_Bulan->SetDbValueDef($rsnew, $this->Akhir_Bulan->CurrentValue, 0, $this->Akhir_Bulan->ReadOnly);

			// Akhir_Tahun
			$this->Akhir_Tahun->SetDbValueDef($rsnew, $this->Akhir_Tahun->CurrentValue, 0, $this->Akhir_Tahun->ReadOnly);

			// Tahun_Ajaran
			$this->Tahun_Ajaran->SetDbValueDef($rsnew, $this->Tahun_Ajaran->CurrentValue, "", $this->Tahun_Ajaran->ReadOnly);

			// Aktif
			$this->Aktif->SetDbValueDef($rsnew, $this->Aktif->CurrentValue, "", $this->Aktif->ReadOnly);

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

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t01_tahunajaranlist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($t01_tahunajaran_edit)) $t01_tahunajaran_edit = new ct01_tahunajaran_edit();

// Page init
$t01_tahunajaran_edit->Page_Init();

// Page main
$t01_tahunajaran_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t01_tahunajaran_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = ft01_tahunajaranedit = new ew_Form("ft01_tahunajaranedit", "edit");

// Validate form
ft01_tahunajaranedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Awal_Bulan");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t01_tahunajaran->Awal_Bulan->FldCaption(), $t01_tahunajaran->Awal_Bulan->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Awal_Bulan");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t01_tahunajaran->Awal_Bulan->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Awal_Tahun");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t01_tahunajaran->Awal_Tahun->FldCaption(), $t01_tahunajaran->Awal_Tahun->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Awal_Tahun");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t01_tahunajaran->Awal_Tahun->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Akhir_Bulan");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t01_tahunajaran->Akhir_Bulan->FldCaption(), $t01_tahunajaran->Akhir_Bulan->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Akhir_Bulan");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t01_tahunajaran->Akhir_Bulan->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Akhir_Tahun");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t01_tahunajaran->Akhir_Tahun->FldCaption(), $t01_tahunajaran->Akhir_Tahun->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Akhir_Tahun");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t01_tahunajaran->Akhir_Tahun->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Tahun_Ajaran");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t01_tahunajaran->Tahun_Ajaran->FldCaption(), $t01_tahunajaran->Tahun_Ajaran->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Aktif");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t01_tahunajaran->Aktif->FldCaption(), $t01_tahunajaran->Aktif->ReqErrMsg)) ?>");

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
ft01_tahunajaranedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft01_tahunajaranedit.ValidateRequired = true;
<?php } else { ?>
ft01_tahunajaranedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft01_tahunajaranedit.Lists["x_Aktif"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ft01_tahunajaranedit.Lists["x_Aktif"].Options = <?php echo json_encode($t01_tahunajaran->Aktif->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$t01_tahunajaran_edit->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $t01_tahunajaran_edit->ShowPageHeader(); ?>
<?php
$t01_tahunajaran_edit->ShowMessage();
?>
<form name="ft01_tahunajaranedit" id="ft01_tahunajaranedit" class="<?php echo $t01_tahunajaran_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t01_tahunajaran_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t01_tahunajaran_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t01_tahunajaran">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($t01_tahunajaran_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($t01_tahunajaran->Awal_Bulan->Visible) { // Awal_Bulan ?>
	<div id="r_Awal_Bulan" class="form-group">
		<label id="elh_t01_tahunajaran_Awal_Bulan" for="x_Awal_Bulan" class="col-sm-2 control-label ewLabel"><?php echo $t01_tahunajaran->Awal_Bulan->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t01_tahunajaran->Awal_Bulan->CellAttributes() ?>>
<span id="el_t01_tahunajaran_Awal_Bulan">
<input type="text" data-table="t01_tahunajaran" data-field="x_Awal_Bulan" name="x_Awal_Bulan" id="x_Awal_Bulan" size="30" placeholder="<?php echo ew_HtmlEncode($t01_tahunajaran->Awal_Bulan->getPlaceHolder()) ?>" value="<?php echo $t01_tahunajaran->Awal_Bulan->EditValue ?>"<?php echo $t01_tahunajaran->Awal_Bulan->EditAttributes() ?>>
</span>
<?php echo $t01_tahunajaran->Awal_Bulan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_tahunajaran->Awal_Tahun->Visible) { // Awal_Tahun ?>
	<div id="r_Awal_Tahun" class="form-group">
		<label id="elh_t01_tahunajaran_Awal_Tahun" for="x_Awal_Tahun" class="col-sm-2 control-label ewLabel"><?php echo $t01_tahunajaran->Awal_Tahun->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t01_tahunajaran->Awal_Tahun->CellAttributes() ?>>
<span id="el_t01_tahunajaran_Awal_Tahun">
<input type="text" data-table="t01_tahunajaran" data-field="x_Awal_Tahun" name="x_Awal_Tahun" id="x_Awal_Tahun" size="30" placeholder="<?php echo ew_HtmlEncode($t01_tahunajaran->Awal_Tahun->getPlaceHolder()) ?>" value="<?php echo $t01_tahunajaran->Awal_Tahun->EditValue ?>"<?php echo $t01_tahunajaran->Awal_Tahun->EditAttributes() ?>>
</span>
<?php echo $t01_tahunajaran->Awal_Tahun->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_tahunajaran->Akhir_Bulan->Visible) { // Akhir_Bulan ?>
	<div id="r_Akhir_Bulan" class="form-group">
		<label id="elh_t01_tahunajaran_Akhir_Bulan" for="x_Akhir_Bulan" class="col-sm-2 control-label ewLabel"><?php echo $t01_tahunajaran->Akhir_Bulan->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t01_tahunajaran->Akhir_Bulan->CellAttributes() ?>>
<span id="el_t01_tahunajaran_Akhir_Bulan">
<input type="text" data-table="t01_tahunajaran" data-field="x_Akhir_Bulan" name="x_Akhir_Bulan" id="x_Akhir_Bulan" size="30" placeholder="<?php echo ew_HtmlEncode($t01_tahunajaran->Akhir_Bulan->getPlaceHolder()) ?>" value="<?php echo $t01_tahunajaran->Akhir_Bulan->EditValue ?>"<?php echo $t01_tahunajaran->Akhir_Bulan->EditAttributes() ?>>
</span>
<?php echo $t01_tahunajaran->Akhir_Bulan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_tahunajaran->Akhir_Tahun->Visible) { // Akhir_Tahun ?>
	<div id="r_Akhir_Tahun" class="form-group">
		<label id="elh_t01_tahunajaran_Akhir_Tahun" for="x_Akhir_Tahun" class="col-sm-2 control-label ewLabel"><?php echo $t01_tahunajaran->Akhir_Tahun->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t01_tahunajaran->Akhir_Tahun->CellAttributes() ?>>
<span id="el_t01_tahunajaran_Akhir_Tahun">
<input type="text" data-table="t01_tahunajaran" data-field="x_Akhir_Tahun" name="x_Akhir_Tahun" id="x_Akhir_Tahun" size="30" placeholder="<?php echo ew_HtmlEncode($t01_tahunajaran->Akhir_Tahun->getPlaceHolder()) ?>" value="<?php echo $t01_tahunajaran->Akhir_Tahun->EditValue ?>"<?php echo $t01_tahunajaran->Akhir_Tahun->EditAttributes() ?>>
</span>
<?php echo $t01_tahunajaran->Akhir_Tahun->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_tahunajaran->Tahun_Ajaran->Visible) { // Tahun_Ajaran ?>
	<div id="r_Tahun_Ajaran" class="form-group">
		<label id="elh_t01_tahunajaran_Tahun_Ajaran" for="x_Tahun_Ajaran" class="col-sm-2 control-label ewLabel"><?php echo $t01_tahunajaran->Tahun_Ajaran->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t01_tahunajaran->Tahun_Ajaran->CellAttributes() ?>>
<span id="el_t01_tahunajaran_Tahun_Ajaran">
<input type="text" data-table="t01_tahunajaran" data-field="x_Tahun_Ajaran" name="x_Tahun_Ajaran" id="x_Tahun_Ajaran" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t01_tahunajaran->Tahun_Ajaran->getPlaceHolder()) ?>" value="<?php echo $t01_tahunajaran->Tahun_Ajaran->EditValue ?>"<?php echo $t01_tahunajaran->Tahun_Ajaran->EditAttributes() ?>>
</span>
<?php echo $t01_tahunajaran->Tahun_Ajaran->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t01_tahunajaran->Aktif->Visible) { // Aktif ?>
	<div id="r_Aktif" class="form-group">
		<label id="elh_t01_tahunajaran_Aktif" class="col-sm-2 control-label ewLabel"><?php echo $t01_tahunajaran->Aktif->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t01_tahunajaran->Aktif->CellAttributes() ?>>
<span id="el_t01_tahunajaran_Aktif">
<div id="tp_x_Aktif" class="ewTemplate"><input type="radio" data-table="t01_tahunajaran" data-field="x_Aktif" data-value-separator="<?php echo $t01_tahunajaran->Aktif->DisplayValueSeparatorAttribute() ?>" name="x_Aktif" id="x_Aktif" value="{value}"<?php echo $t01_tahunajaran->Aktif->EditAttributes() ?>></div>
<div id="dsl_x_Aktif" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $t01_tahunajaran->Aktif->RadioButtonListHtml(FALSE, "x_Aktif") ?>
</div></div>
</span>
<?php echo $t01_tahunajaran->Aktif->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<input type="hidden" data-table="t01_tahunajaran" data-field="x_id" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($t01_tahunajaran->id->CurrentValue) ?>">
<?php if (!$t01_tahunajaran_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t01_tahunajaran_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ft01_tahunajaranedit.Init();
</script>
<?php
$t01_tahunajaran_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t01_tahunajaran_edit->Page_Terminate();
?>
