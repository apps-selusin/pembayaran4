<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "t07_siswarutinbayarinfo.php" ?>
<?php include_once "t06_siswarutininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$t07_siswarutinbayar_delete = NULL; // Initialize page object first

class ct07_siswarutinbayar_delete extends ct07_siswarutinbayar {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{64CABE7A-1609-4157-8293-D7242B591905}";

	// Table name
	var $TableName = 't07_siswarutinbayar';

	// Page object name
	var $PageObjName = 't07_siswarutinbayar_delete';

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

		// Table object (t07_siswarutinbayar)
		if (!isset($GLOBALS["t07_siswarutinbayar"]) || get_class($GLOBALS["t07_siswarutinbayar"]) == "ct07_siswarutinbayar") {
			$GLOBALS["t07_siswarutinbayar"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t07_siswarutinbayar"];
		}

		// Table object (t06_siswarutin)
		if (!isset($GLOBALS['t06_siswarutin'])) $GLOBALS['t06_siswarutin'] = new ct06_siswarutin();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't07_siswarutinbayar', TRUE);

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
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
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
			header("Location: " . $url);
		}
		exit();
	}
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up master/detail parameters
		$this->SetUpMasterParms();

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("t07_siswarutinbayarlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in t07_siswarutinbayar class, t07_siswarutinbayarinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} elseif (@$_GET["a_delete"] == "1") {
			$this->CurrentAction = "D"; // Delete record directly
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		if ($this->CurrentAction == "D") {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->DeleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			} else { // Delete failed
				$this->CurrentAction = "I"; // Display record
			}
		}
		if ($this->CurrentAction == "I") { // Load records for display
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecs <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->Close();
				$this->Page_Terminate("t07_siswarutinbayarlist.php"); // Return to list
			}
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
		$conn->BeginTrans();
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
			$conn->CommitTrans(); // Commit the changes
			if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteSuccess")); // Batch delete success
		} else {
			$conn->RollbackTrans(); // Rollback changes
			if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteRollback")); // Batch delete rollback
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
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
			if ($sMasterTblVar == "t06_siswarutin") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_id"] <> "") {
					$GLOBALS["t06_siswarutin"]->id->setQueryStringValue($_GET["fk_id"]);
					$this->siswarutin_id->setQueryStringValue($GLOBALS["t06_siswarutin"]->id->QueryStringValue);
					$this->siswarutin_id->setSessionValue($this->siswarutin_id->QueryStringValue);
					if (!is_numeric($GLOBALS["t06_siswarutin"]->id->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar == "t06_siswarutin") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_id"] <> "") {
					$GLOBALS["t06_siswarutin"]->id->setFormValue($_POST["fk_id"]);
					$this->siswarutin_id->setFormValue($GLOBALS["t06_siswarutin"]->id->FormValue);
					$this->siswarutin_id->setSessionValue($this->siswarutin_id->FormValue);
					if (!is_numeric($GLOBALS["t06_siswarutin"]->id->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "t06_siswarutin") {
				if ($this->siswarutin_id->CurrentValue == "") $this->siswarutin_id->setSessionValue("");
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t07_siswarutinbayarlist.php"), "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($t07_siswarutinbayar_delete)) $t07_siswarutinbayar_delete = new ct07_siswarutinbayar_delete();

// Page init
$t07_siswarutinbayar_delete->Page_Init();

// Page main
$t07_siswarutinbayar_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t07_siswarutinbayar_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = ft07_siswarutinbayardelete = new ew_Form("ft07_siswarutinbayardelete", "delete");

// Form_CustomValidate event
ft07_siswarutinbayardelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft07_siswarutinbayardelete.ValidateRequired = true;
<?php } else { ?>
ft07_siswarutinbayardelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft07_siswarutinbayardelete.Lists["x_Periode_Tahun_Bulan"] = {"LinkField":"x_Periode_Tahun_Bulan","Ajax":true,"AutoFill":false,"DisplayFields":["x_Periode_Text","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t07_siswarutinbayar"};
ft07_siswarutinbayardelete.Lists["x_Bulan"] = {"LinkField":"x_Bulan","Ajax":true,"AutoFill":false,"DisplayFields":["x_Bulan","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t07_siswarutinbayar"};
ft07_siswarutinbayardelete.Lists["x_Tahun"] = {"LinkField":"x_Tahun","Ajax":true,"AutoFill":false,"DisplayFields":["x_Tahun","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t07_siswarutinbayar"};
ft07_siswarutinbayardelete.Lists["x_Periode_Text"] = {"LinkField":"x_Periode_Text","Ajax":true,"AutoFill":false,"DisplayFields":["x_Periode_Text","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t07_siswarutinbayar"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $t07_siswarutinbayar_delete->ShowPageHeader(); ?>
<?php
$t07_siswarutinbayar_delete->ShowMessage();
?>
<form name="ft07_siswarutinbayardelete" id="ft07_siswarutinbayardelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t07_siswarutinbayar_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t07_siswarutinbayar_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t07_siswarutinbayar">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($t07_siswarutinbayar_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $t07_siswarutinbayar->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($t07_siswarutinbayar->siswarutin_id->Visible) { // siswarutin_id ?>
		<th><span id="elh_t07_siswarutinbayar_siswarutin_id" class="t07_siswarutinbayar_siswarutin_id"><?php echo $t07_siswarutinbayar->siswarutin_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t07_siswarutinbayar->Periode_Tahun_Bulan->Visible) { // Periode_Tahun_Bulan ?>
		<th><span id="elh_t07_siswarutinbayar_Periode_Tahun_Bulan" class="t07_siswarutinbayar_Periode_Tahun_Bulan"><?php echo $t07_siswarutinbayar->Periode_Tahun_Bulan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t07_siswarutinbayar->Nilai->Visible) { // Nilai ?>
		<th><span id="elh_t07_siswarutinbayar_Nilai" class="t07_siswarutinbayar_Nilai"><?php echo $t07_siswarutinbayar->Nilai->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t07_siswarutinbayar->Tanggal_Bayar->Visible) { // Tanggal_Bayar ?>
		<th><span id="elh_t07_siswarutinbayar_Tanggal_Bayar" class="t07_siswarutinbayar_Tanggal_Bayar"><?php echo $t07_siswarutinbayar->Tanggal_Bayar->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t07_siswarutinbayar->Nilai_Bayar->Visible) { // Nilai_Bayar ?>
		<th><span id="elh_t07_siswarutinbayar_Nilai_Bayar" class="t07_siswarutinbayar_Nilai_Bayar"><?php echo $t07_siswarutinbayar->Nilai_Bayar->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t07_siswarutinbayar->Bulan->Visible) { // Bulan ?>
		<th><span id="elh_t07_siswarutinbayar_Bulan" class="t07_siswarutinbayar_Bulan"><?php echo $t07_siswarutinbayar->Bulan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t07_siswarutinbayar->Tahun->Visible) { // Tahun ?>
		<th><span id="elh_t07_siswarutinbayar_Tahun" class="t07_siswarutinbayar_Tahun"><?php echo $t07_siswarutinbayar->Tahun->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t07_siswarutinbayar->Periode_Text->Visible) { // Periode_Text ?>
		<th><span id="elh_t07_siswarutinbayar_Periode_Text" class="t07_siswarutinbayar_Periode_Text"><?php echo $t07_siswarutinbayar->Periode_Text->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$t07_siswarutinbayar_delete->RecCnt = 0;
$i = 0;
while (!$t07_siswarutinbayar_delete->Recordset->EOF) {
	$t07_siswarutinbayar_delete->RecCnt++;
	$t07_siswarutinbayar_delete->RowCnt++;

	// Set row properties
	$t07_siswarutinbayar->ResetAttrs();
	$t07_siswarutinbayar->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$t07_siswarutinbayar_delete->LoadRowValues($t07_siswarutinbayar_delete->Recordset);

	// Render row
	$t07_siswarutinbayar_delete->RenderRow();
?>
	<tr<?php echo $t07_siswarutinbayar->RowAttributes() ?>>
<?php if ($t07_siswarutinbayar->siswarutin_id->Visible) { // siswarutin_id ?>
		<td<?php echo $t07_siswarutinbayar->siswarutin_id->CellAttributes() ?>>
<span id="el<?php echo $t07_siswarutinbayar_delete->RowCnt ?>_t07_siswarutinbayar_siswarutin_id" class="t07_siswarutinbayar_siswarutin_id">
<span<?php echo $t07_siswarutinbayar->siswarutin_id->ViewAttributes() ?>>
<?php echo $t07_siswarutinbayar->siswarutin_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t07_siswarutinbayar->Periode_Tahun_Bulan->Visible) { // Periode_Tahun_Bulan ?>
		<td<?php echo $t07_siswarutinbayar->Periode_Tahun_Bulan->CellAttributes() ?>>
<span id="el<?php echo $t07_siswarutinbayar_delete->RowCnt ?>_t07_siswarutinbayar_Periode_Tahun_Bulan" class="t07_siswarutinbayar_Periode_Tahun_Bulan">
<span<?php echo $t07_siswarutinbayar->Periode_Tahun_Bulan->ViewAttributes() ?>>
<?php echo $t07_siswarutinbayar->Periode_Tahun_Bulan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t07_siswarutinbayar->Nilai->Visible) { // Nilai ?>
		<td<?php echo $t07_siswarutinbayar->Nilai->CellAttributes() ?>>
<span id="el<?php echo $t07_siswarutinbayar_delete->RowCnt ?>_t07_siswarutinbayar_Nilai" class="t07_siswarutinbayar_Nilai">
<span<?php echo $t07_siswarutinbayar->Nilai->ViewAttributes() ?>>
<?php echo $t07_siswarutinbayar->Nilai->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t07_siswarutinbayar->Tanggal_Bayar->Visible) { // Tanggal_Bayar ?>
		<td<?php echo $t07_siswarutinbayar->Tanggal_Bayar->CellAttributes() ?>>
<span id="el<?php echo $t07_siswarutinbayar_delete->RowCnt ?>_t07_siswarutinbayar_Tanggal_Bayar" class="t07_siswarutinbayar_Tanggal_Bayar">
<span<?php echo $t07_siswarutinbayar->Tanggal_Bayar->ViewAttributes() ?>>
<?php echo $t07_siswarutinbayar->Tanggal_Bayar->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t07_siswarutinbayar->Nilai_Bayar->Visible) { // Nilai_Bayar ?>
		<td<?php echo $t07_siswarutinbayar->Nilai_Bayar->CellAttributes() ?>>
<span id="el<?php echo $t07_siswarutinbayar_delete->RowCnt ?>_t07_siswarutinbayar_Nilai_Bayar" class="t07_siswarutinbayar_Nilai_Bayar">
<span<?php echo $t07_siswarutinbayar->Nilai_Bayar->ViewAttributes() ?>>
<?php echo $t07_siswarutinbayar->Nilai_Bayar->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t07_siswarutinbayar->Bulan->Visible) { // Bulan ?>
		<td<?php echo $t07_siswarutinbayar->Bulan->CellAttributes() ?>>
<span id="el<?php echo $t07_siswarutinbayar_delete->RowCnt ?>_t07_siswarutinbayar_Bulan" class="t07_siswarutinbayar_Bulan">
<span<?php echo $t07_siswarutinbayar->Bulan->ViewAttributes() ?>>
<?php echo $t07_siswarutinbayar->Bulan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t07_siswarutinbayar->Tahun->Visible) { // Tahun ?>
		<td<?php echo $t07_siswarutinbayar->Tahun->CellAttributes() ?>>
<span id="el<?php echo $t07_siswarutinbayar_delete->RowCnt ?>_t07_siswarutinbayar_Tahun" class="t07_siswarutinbayar_Tahun">
<span<?php echo $t07_siswarutinbayar->Tahun->ViewAttributes() ?>>
<?php echo $t07_siswarutinbayar->Tahun->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t07_siswarutinbayar->Periode_Text->Visible) { // Periode_Text ?>
		<td<?php echo $t07_siswarutinbayar->Periode_Text->CellAttributes() ?>>
<span id="el<?php echo $t07_siswarutinbayar_delete->RowCnt ?>_t07_siswarutinbayar_Periode_Text" class="t07_siswarutinbayar_Periode_Text">
<span<?php echo $t07_siswarutinbayar->Periode_Text->ViewAttributes() ?>>
<?php echo $t07_siswarutinbayar->Periode_Text->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$t07_siswarutinbayar_delete->Recordset->MoveNext();
}
$t07_siswarutinbayar_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t07_siswarutinbayar_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
ft07_siswarutinbayardelete.Init();
</script>
<?php
$t07_siswarutinbayar_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t07_siswarutinbayar_delete->Page_Terminate();
?>
