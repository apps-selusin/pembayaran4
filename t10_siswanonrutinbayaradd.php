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

$t10_siswanonrutinbayar_add = NULL; // Initialize page object first

class ct10_siswanonrutinbayar_add extends ct10_siswanonrutinbayar {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{64CABE7A-1609-4157-8293-D7242B591905}";

	// Table name
	var $TableName = 't10_siswanonrutinbayar';

	// Page object name
	var $PageObjName = 't10_siswanonrutinbayar_add';

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

		// Table object (t10_siswanonrutinbayar)
		if (!isset($GLOBALS["t10_siswanonrutinbayar"]) || get_class($GLOBALS["t10_siswanonrutinbayar"]) == "ct10_siswanonrutinbayar") {
			$GLOBALS["t10_siswanonrutinbayar"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t10_siswanonrutinbayar"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't10_siswanonrutinbayar', TRUE);

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
	var $FormClassName = "form-horizontal ewForm ewAddForm";
	var $IsModal = FALSE;
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

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

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["id"] != "") {
				$this->id->setQueryStringValue($_GET["id"]);
				$this->setKey("id", $this->id->CurrentValue); // Set up key
			} else {
				$this->setKey("id", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
			}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		} else {
			if ($this->CurrentAction == "I") // Load default values for blank record
				$this->LoadDefaultValues();
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("t10_siswanonrutinbayarlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "t10_siswanonrutinbayarlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "t10_siswanonrutinbayarview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD; // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->siswanonrutin_id->CurrentValue = NULL;
		$this->siswanonrutin_id->OldValue = $this->siswanonrutin_id->CurrentValue;
		$this->Bulan->CurrentValue = 0;
		$this->Tahun->CurrentValue = 0;
		$this->Nilai->CurrentValue = 0.00;
		$this->Tanggal_Bayar->CurrentValue = NULL;
		$this->Tanggal_Bayar->OldValue = $this->Tanggal_Bayar->CurrentValue;
		$this->Nilai_Bayar->CurrentValue = 0.00;
		$this->Periode_Tahun_Bulan->CurrentValue = NULL;
		$this->Periode_Tahun_Bulan->OldValue = $this->Periode_Tahun_Bulan->CurrentValue;
		$this->Periode_Text->CurrentValue = NULL;
		$this->Periode_Text->OldValue = $this->Periode_Text->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->siswanonrutin_id->FldIsDetailKey) {
			$this->siswanonrutin_id->setFormValue($objForm->GetValue("x_siswanonrutin_id"));
		}
		if (!$this->Bulan->FldIsDetailKey) {
			$this->Bulan->setFormValue($objForm->GetValue("x_Bulan"));
		}
		if (!$this->Tahun->FldIsDetailKey) {
			$this->Tahun->setFormValue($objForm->GetValue("x_Tahun"));
		}
		if (!$this->Nilai->FldIsDetailKey) {
			$this->Nilai->setFormValue($objForm->GetValue("x_Nilai"));
		}
		if (!$this->Tanggal_Bayar->FldIsDetailKey) {
			$this->Tanggal_Bayar->setFormValue($objForm->GetValue("x_Tanggal_Bayar"));
			$this->Tanggal_Bayar->CurrentValue = ew_UnFormatDateTime($this->Tanggal_Bayar->CurrentValue, 0);
		}
		if (!$this->Nilai_Bayar->FldIsDetailKey) {
			$this->Nilai_Bayar->setFormValue($objForm->GetValue("x_Nilai_Bayar"));
		}
		if (!$this->Periode_Tahun_Bulan->FldIsDetailKey) {
			$this->Periode_Tahun_Bulan->setFormValue($objForm->GetValue("x_Periode_Tahun_Bulan"));
		}
		if (!$this->Periode_Text->FldIsDetailKey) {
			$this->Periode_Text->setFormValue($objForm->GetValue("x_Periode_Text"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->siswanonrutin_id->CurrentValue = $this->siswanonrutin_id->FormValue;
		$this->Bulan->CurrentValue = $this->Bulan->FormValue;
		$this->Tahun->CurrentValue = $this->Tahun->FormValue;
		$this->Nilai->CurrentValue = $this->Nilai->FormValue;
		$this->Tanggal_Bayar->CurrentValue = $this->Tanggal_Bayar->FormValue;
		$this->Tanggal_Bayar->CurrentValue = ew_UnFormatDateTime($this->Tanggal_Bayar->CurrentValue, 0);
		$this->Nilai_Bayar->CurrentValue = $this->Nilai_Bayar->FormValue;
		$this->Periode_Tahun_Bulan->CurrentValue = $this->Periode_Tahun_Bulan->FormValue;
		$this->Periode_Text->CurrentValue = $this->Periode_Text->FormValue;
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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// siswanonrutin_id
			$this->siswanonrutin_id->EditAttrs["class"] = "form-control";
			$this->siswanonrutin_id->EditCustomAttributes = "";
			$this->siswanonrutin_id->EditValue = ew_HtmlEncode($this->siswanonrutin_id->CurrentValue);
			$this->siswanonrutin_id->PlaceHolder = ew_RemoveHtml($this->siswanonrutin_id->FldCaption());

			// Bulan
			$this->Bulan->EditAttrs["class"] = "form-control";
			$this->Bulan->EditCustomAttributes = "";
			$this->Bulan->EditValue = ew_HtmlEncode($this->Bulan->CurrentValue);
			$this->Bulan->PlaceHolder = ew_RemoveHtml($this->Bulan->FldCaption());

			// Tahun
			$this->Tahun->EditAttrs["class"] = "form-control";
			$this->Tahun->EditCustomAttributes = "";
			$this->Tahun->EditValue = ew_HtmlEncode($this->Tahun->CurrentValue);
			$this->Tahun->PlaceHolder = ew_RemoveHtml($this->Tahun->FldCaption());

			// Nilai
			$this->Nilai->EditAttrs["class"] = "form-control";
			$this->Nilai->EditCustomAttributes = "";
			$this->Nilai->EditValue = ew_HtmlEncode($this->Nilai->CurrentValue);
			$this->Nilai->PlaceHolder = ew_RemoveHtml($this->Nilai->FldCaption());
			if (strval($this->Nilai->EditValue) <> "" && is_numeric($this->Nilai->EditValue)) $this->Nilai->EditValue = ew_FormatNumber($this->Nilai->EditValue, -2, -1, -2, 0);

			// Tanggal_Bayar
			$this->Tanggal_Bayar->EditAttrs["class"] = "form-control";
			$this->Tanggal_Bayar->EditCustomAttributes = "";
			$this->Tanggal_Bayar->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->Tanggal_Bayar->CurrentValue, 8));
			$this->Tanggal_Bayar->PlaceHolder = ew_RemoveHtml($this->Tanggal_Bayar->FldCaption());

			// Nilai_Bayar
			$this->Nilai_Bayar->EditAttrs["class"] = "form-control";
			$this->Nilai_Bayar->EditCustomAttributes = "";
			$this->Nilai_Bayar->EditValue = ew_HtmlEncode($this->Nilai_Bayar->CurrentValue);
			$this->Nilai_Bayar->PlaceHolder = ew_RemoveHtml($this->Nilai_Bayar->FldCaption());
			if (strval($this->Nilai_Bayar->EditValue) <> "" && is_numeric($this->Nilai_Bayar->EditValue)) $this->Nilai_Bayar->EditValue = ew_FormatNumber($this->Nilai_Bayar->EditValue, -2, -1, -2, 0);

			// Periode_Tahun_Bulan
			$this->Periode_Tahun_Bulan->EditAttrs["class"] = "form-control";
			$this->Periode_Tahun_Bulan->EditCustomAttributes = "";
			$this->Periode_Tahun_Bulan->EditValue = ew_HtmlEncode($this->Periode_Tahun_Bulan->CurrentValue);
			$this->Periode_Tahun_Bulan->PlaceHolder = ew_RemoveHtml($this->Periode_Tahun_Bulan->FldCaption());

			// Periode_Text
			$this->Periode_Text->EditAttrs["class"] = "form-control";
			$this->Periode_Text->EditCustomAttributes = "";
			$this->Periode_Text->EditValue = ew_HtmlEncode($this->Periode_Text->CurrentValue);
			$this->Periode_Text->PlaceHolder = ew_RemoveHtml($this->Periode_Text->FldCaption());

			// Add refer script
			// siswanonrutin_id

			$this->siswanonrutin_id->LinkCustomAttributes = "";
			$this->siswanonrutin_id->HrefValue = "";

			// Bulan
			$this->Bulan->LinkCustomAttributes = "";
			$this->Bulan->HrefValue = "";

			// Tahun
			$this->Tahun->LinkCustomAttributes = "";
			$this->Tahun->HrefValue = "";

			// Nilai
			$this->Nilai->LinkCustomAttributes = "";
			$this->Nilai->HrefValue = "";

			// Tanggal_Bayar
			$this->Tanggal_Bayar->LinkCustomAttributes = "";
			$this->Tanggal_Bayar->HrefValue = "";

			// Nilai_Bayar
			$this->Nilai_Bayar->LinkCustomAttributes = "";
			$this->Nilai_Bayar->HrefValue = "";

			// Periode_Tahun_Bulan
			$this->Periode_Tahun_Bulan->LinkCustomAttributes = "";
			$this->Periode_Tahun_Bulan->HrefValue = "";

			// Periode_Text
			$this->Periode_Text->LinkCustomAttributes = "";
			$this->Periode_Text->HrefValue = "";
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
		if (!$this->siswanonrutin_id->FldIsDetailKey && !is_null($this->siswanonrutin_id->FormValue) && $this->siswanonrutin_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->siswanonrutin_id->FldCaption(), $this->siswanonrutin_id->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->siswanonrutin_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->siswanonrutin_id->FldErrMsg());
		}
		if (!$this->Bulan->FldIsDetailKey && !is_null($this->Bulan->FormValue) && $this->Bulan->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Bulan->FldCaption(), $this->Bulan->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->Bulan->FormValue)) {
			ew_AddMessage($gsFormError, $this->Bulan->FldErrMsg());
		}
		if (!$this->Tahun->FldIsDetailKey && !is_null($this->Tahun->FormValue) && $this->Tahun->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Tahun->FldCaption(), $this->Tahun->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->Tahun->FormValue)) {
			ew_AddMessage($gsFormError, $this->Tahun->FldErrMsg());
		}
		if (!ew_CheckNumber($this->Nilai->FormValue)) {
			ew_AddMessage($gsFormError, $this->Nilai->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->Tanggal_Bayar->FormValue)) {
			ew_AddMessage($gsFormError, $this->Tanggal_Bayar->FldErrMsg());
		}
		if (!ew_CheckNumber($this->Nilai_Bayar->FormValue)) {
			ew_AddMessage($gsFormError, $this->Nilai_Bayar->FldErrMsg());
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

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// siswanonrutin_id
		$this->siswanonrutin_id->SetDbValueDef($rsnew, $this->siswanonrutin_id->CurrentValue, 0, FALSE);

		// Bulan
		$this->Bulan->SetDbValueDef($rsnew, $this->Bulan->CurrentValue, 0, strval($this->Bulan->CurrentValue) == "");

		// Tahun
		$this->Tahun->SetDbValueDef($rsnew, $this->Tahun->CurrentValue, 0, strval($this->Tahun->CurrentValue) == "");

		// Nilai
		$this->Nilai->SetDbValueDef($rsnew, $this->Nilai->CurrentValue, NULL, strval($this->Nilai->CurrentValue) == "");

		// Tanggal_Bayar
		$this->Tanggal_Bayar->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->Tanggal_Bayar->CurrentValue, 0), NULL, FALSE);

		// Nilai_Bayar
		$this->Nilai_Bayar->SetDbValueDef($rsnew, $this->Nilai_Bayar->CurrentValue, NULL, strval($this->Nilai_Bayar->CurrentValue) == "");

		// Periode_Tahun_Bulan
		$this->Periode_Tahun_Bulan->SetDbValueDef($rsnew, $this->Periode_Tahun_Bulan->CurrentValue, NULL, FALSE);

		// Periode_Text
		$this->Periode_Text->SetDbValueDef($rsnew, $this->Periode_Text->CurrentValue, NULL, FALSE);

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

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t10_siswanonrutinbayarlist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
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
if (!isset($t10_siswanonrutinbayar_add)) $t10_siswanonrutinbayar_add = new ct10_siswanonrutinbayar_add();

// Page init
$t10_siswanonrutinbayar_add->Page_Init();

// Page main
$t10_siswanonrutinbayar_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t10_siswanonrutinbayar_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = ft10_siswanonrutinbayaradd = new ew_Form("ft10_siswanonrutinbayaradd", "add");

// Validate form
ft10_siswanonrutinbayaradd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_siswanonrutin_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t10_siswanonrutinbayar->siswanonrutin_id->FldCaption(), $t10_siswanonrutinbayar->siswanonrutin_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_siswanonrutin_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t10_siswanonrutinbayar->siswanonrutin_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Bulan");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t10_siswanonrutinbayar->Bulan->FldCaption(), $t10_siswanonrutinbayar->Bulan->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Bulan");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t10_siswanonrutinbayar->Bulan->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Tahun");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t10_siswanonrutinbayar->Tahun->FldCaption(), $t10_siswanonrutinbayar->Tahun->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Tahun");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t10_siswanonrutinbayar->Tahun->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Nilai");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t10_siswanonrutinbayar->Nilai->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Tanggal_Bayar");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t10_siswanonrutinbayar->Tanggal_Bayar->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Nilai_Bayar");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t10_siswanonrutinbayar->Nilai_Bayar->FldErrMsg()) ?>");

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
ft10_siswanonrutinbayaradd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft10_siswanonrutinbayaradd.ValidateRequired = true;
<?php } else { ?>
ft10_siswanonrutinbayaradd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$t10_siswanonrutinbayar_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $t10_siswanonrutinbayar_add->ShowPageHeader(); ?>
<?php
$t10_siswanonrutinbayar_add->ShowMessage();
?>
<form name="ft10_siswanonrutinbayaradd" id="ft10_siswanonrutinbayaradd" class="<?php echo $t10_siswanonrutinbayar_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t10_siswanonrutinbayar_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t10_siswanonrutinbayar_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t10_siswanonrutinbayar">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($t10_siswanonrutinbayar_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($t10_siswanonrutinbayar->siswanonrutin_id->Visible) { // siswanonrutin_id ?>
	<div id="r_siswanonrutin_id" class="form-group">
		<label id="elh_t10_siswanonrutinbayar_siswanonrutin_id" for="x_siswanonrutin_id" class="col-sm-2 control-label ewLabel"><?php echo $t10_siswanonrutinbayar->siswanonrutin_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t10_siswanonrutinbayar->siswanonrutin_id->CellAttributes() ?>>
<span id="el_t10_siswanonrutinbayar_siswanonrutin_id">
<input type="text" data-table="t10_siswanonrutinbayar" data-field="x_siswanonrutin_id" name="x_siswanonrutin_id" id="x_siswanonrutin_id" size="30" placeholder="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->siswanonrutin_id->getPlaceHolder()) ?>" value="<?php echo $t10_siswanonrutinbayar->siswanonrutin_id->EditValue ?>"<?php echo $t10_siswanonrutinbayar->siswanonrutin_id->EditAttributes() ?>>
</span>
<?php echo $t10_siswanonrutinbayar->siswanonrutin_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t10_siswanonrutinbayar->Bulan->Visible) { // Bulan ?>
	<div id="r_Bulan" class="form-group">
		<label id="elh_t10_siswanonrutinbayar_Bulan" for="x_Bulan" class="col-sm-2 control-label ewLabel"><?php echo $t10_siswanonrutinbayar->Bulan->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t10_siswanonrutinbayar->Bulan->CellAttributes() ?>>
<span id="el_t10_siswanonrutinbayar_Bulan">
<input type="text" data-table="t10_siswanonrutinbayar" data-field="x_Bulan" name="x_Bulan" id="x_Bulan" size="30" placeholder="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Bulan->getPlaceHolder()) ?>" value="<?php echo $t10_siswanonrutinbayar->Bulan->EditValue ?>"<?php echo $t10_siswanonrutinbayar->Bulan->EditAttributes() ?>>
</span>
<?php echo $t10_siswanonrutinbayar->Bulan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t10_siswanonrutinbayar->Tahun->Visible) { // Tahun ?>
	<div id="r_Tahun" class="form-group">
		<label id="elh_t10_siswanonrutinbayar_Tahun" for="x_Tahun" class="col-sm-2 control-label ewLabel"><?php echo $t10_siswanonrutinbayar->Tahun->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t10_siswanonrutinbayar->Tahun->CellAttributes() ?>>
<span id="el_t10_siswanonrutinbayar_Tahun">
<input type="text" data-table="t10_siswanonrutinbayar" data-field="x_Tahun" name="x_Tahun" id="x_Tahun" size="30" placeholder="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Tahun->getPlaceHolder()) ?>" value="<?php echo $t10_siswanonrutinbayar->Tahun->EditValue ?>"<?php echo $t10_siswanonrutinbayar->Tahun->EditAttributes() ?>>
</span>
<?php echo $t10_siswanonrutinbayar->Tahun->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t10_siswanonrutinbayar->Nilai->Visible) { // Nilai ?>
	<div id="r_Nilai" class="form-group">
		<label id="elh_t10_siswanonrutinbayar_Nilai" for="x_Nilai" class="col-sm-2 control-label ewLabel"><?php echo $t10_siswanonrutinbayar->Nilai->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t10_siswanonrutinbayar->Nilai->CellAttributes() ?>>
<span id="el_t10_siswanonrutinbayar_Nilai">
<input type="text" data-table="t10_siswanonrutinbayar" data-field="x_Nilai" name="x_Nilai" id="x_Nilai" size="30" placeholder="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Nilai->getPlaceHolder()) ?>" value="<?php echo $t10_siswanonrutinbayar->Nilai->EditValue ?>"<?php echo $t10_siswanonrutinbayar->Nilai->EditAttributes() ?>>
</span>
<?php echo $t10_siswanonrutinbayar->Nilai->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t10_siswanonrutinbayar->Tanggal_Bayar->Visible) { // Tanggal_Bayar ?>
	<div id="r_Tanggal_Bayar" class="form-group">
		<label id="elh_t10_siswanonrutinbayar_Tanggal_Bayar" for="x_Tanggal_Bayar" class="col-sm-2 control-label ewLabel"><?php echo $t10_siswanonrutinbayar->Tanggal_Bayar->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t10_siswanonrutinbayar->Tanggal_Bayar->CellAttributes() ?>>
<span id="el_t10_siswanonrutinbayar_Tanggal_Bayar">
<input type="text" data-table="t10_siswanonrutinbayar" data-field="x_Tanggal_Bayar" name="x_Tanggal_Bayar" id="x_Tanggal_Bayar" placeholder="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Tanggal_Bayar->getPlaceHolder()) ?>" value="<?php echo $t10_siswanonrutinbayar->Tanggal_Bayar->EditValue ?>"<?php echo $t10_siswanonrutinbayar->Tanggal_Bayar->EditAttributes() ?>>
</span>
<?php echo $t10_siswanonrutinbayar->Tanggal_Bayar->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t10_siswanonrutinbayar->Nilai_Bayar->Visible) { // Nilai_Bayar ?>
	<div id="r_Nilai_Bayar" class="form-group">
		<label id="elh_t10_siswanonrutinbayar_Nilai_Bayar" for="x_Nilai_Bayar" class="col-sm-2 control-label ewLabel"><?php echo $t10_siswanonrutinbayar->Nilai_Bayar->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t10_siswanonrutinbayar->Nilai_Bayar->CellAttributes() ?>>
<span id="el_t10_siswanonrutinbayar_Nilai_Bayar">
<input type="text" data-table="t10_siswanonrutinbayar" data-field="x_Nilai_Bayar" name="x_Nilai_Bayar" id="x_Nilai_Bayar" size="30" placeholder="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Nilai_Bayar->getPlaceHolder()) ?>" value="<?php echo $t10_siswanonrutinbayar->Nilai_Bayar->EditValue ?>"<?php echo $t10_siswanonrutinbayar->Nilai_Bayar->EditAttributes() ?>>
</span>
<?php echo $t10_siswanonrutinbayar->Nilai_Bayar->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t10_siswanonrutinbayar->Periode_Tahun_Bulan->Visible) { // Periode_Tahun_Bulan ?>
	<div id="r_Periode_Tahun_Bulan" class="form-group">
		<label id="elh_t10_siswanonrutinbayar_Periode_Tahun_Bulan" for="x_Periode_Tahun_Bulan" class="col-sm-2 control-label ewLabel"><?php echo $t10_siswanonrutinbayar->Periode_Tahun_Bulan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t10_siswanonrutinbayar->Periode_Tahun_Bulan->CellAttributes() ?>>
<span id="el_t10_siswanonrutinbayar_Periode_Tahun_Bulan">
<input type="text" data-table="t10_siswanonrutinbayar" data-field="x_Periode_Tahun_Bulan" name="x_Periode_Tahun_Bulan" id="x_Periode_Tahun_Bulan" size="30" maxlength="6" placeholder="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Periode_Tahun_Bulan->getPlaceHolder()) ?>" value="<?php echo $t10_siswanonrutinbayar->Periode_Tahun_Bulan->EditValue ?>"<?php echo $t10_siswanonrutinbayar->Periode_Tahun_Bulan->EditAttributes() ?>>
</span>
<?php echo $t10_siswanonrutinbayar->Periode_Tahun_Bulan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t10_siswanonrutinbayar->Periode_Text->Visible) { // Periode_Text ?>
	<div id="r_Periode_Text" class="form-group">
		<label id="elh_t10_siswanonrutinbayar_Periode_Text" for="x_Periode_Text" class="col-sm-2 control-label ewLabel"><?php echo $t10_siswanonrutinbayar->Periode_Text->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t10_siswanonrutinbayar->Periode_Text->CellAttributes() ?>>
<span id="el_t10_siswanonrutinbayar_Periode_Text">
<input type="text" data-table="t10_siswanonrutinbayar" data-field="x_Periode_Text" name="x_Periode_Text" id="x_Periode_Text" size="30" maxlength="14" placeholder="<?php echo ew_HtmlEncode($t10_siswanonrutinbayar->Periode_Text->getPlaceHolder()) ?>" value="<?php echo $t10_siswanonrutinbayar->Periode_Text->EditValue ?>"<?php echo $t10_siswanonrutinbayar->Periode_Text->EditAttributes() ?>>
</span>
<?php echo $t10_siswanonrutinbayar->Periode_Text->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$t10_siswanonrutinbayar_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t10_siswanonrutinbayar_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ft10_siswanonrutinbayaradd.Init();
</script>
<?php
$t10_siswanonrutinbayar_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t10_siswanonrutinbayar_add->Page_Terminate();
?>
