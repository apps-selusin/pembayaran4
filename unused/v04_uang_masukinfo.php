<?php

// Global variable for table object
$v04_uang_masuk = NULL;

//
// Table class for v04_uang_masuk
//
class cv04_uang_masuk extends cTable {
	var $siswanonrutin_id;
	var $siswa_id;
	var $nonrutin_id;
	var $sekolah_id;
	var $kelas_id;
	var $NIS;
	var $Nama;
	var $Jenis;
	var $Nilai;
	var $Kelas;
	var $Sekolah;
	var $Periode_Tahun_Bulan;
	var $Periode_Text;
	var $Bayar;
	var $Per_Thn_Bln_Byr;
	var $Per_Thn_Bln_Byr_Text;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'v04_uang_masuk';
		$this->TableName = 'v04_uang_masuk';
		$this->TableType = 'VIEW';

		// Update Table
		$this->UpdateTable = "`v04_uang_masuk`";
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 1;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// siswanonrutin_id
		$this->siswanonrutin_id = new cField('v04_uang_masuk', 'v04_uang_masuk', 'x_siswanonrutin_id', 'siswanonrutin_id', '`siswanonrutin_id`', '`siswanonrutin_id`', 3, -1, FALSE, '`siswanonrutin_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->siswanonrutin_id->Sortable = TRUE; // Allow sort
		$this->siswanonrutin_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['siswanonrutin_id'] = &$this->siswanonrutin_id;

		// siswa_id
		$this->siswa_id = new cField('v04_uang_masuk', 'v04_uang_masuk', 'x_siswa_id', 'siswa_id', '`siswa_id`', '`siswa_id`', 3, -1, FALSE, '`siswa_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->siswa_id->Sortable = TRUE; // Allow sort
		$this->siswa_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['siswa_id'] = &$this->siswa_id;

		// nonrutin_id
		$this->nonrutin_id = new cField('v04_uang_masuk', 'v04_uang_masuk', 'x_nonrutin_id', 'nonrutin_id', '`nonrutin_id`', '`nonrutin_id`', 3, -1, FALSE, '`nonrutin_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nonrutin_id->Sortable = TRUE; // Allow sort
		$this->nonrutin_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['nonrutin_id'] = &$this->nonrutin_id;

		// sekolah_id
		$this->sekolah_id = new cField('v04_uang_masuk', 'v04_uang_masuk', 'x_sekolah_id', 'sekolah_id', '`sekolah_id`', '`sekolah_id`', 3, -1, FALSE, '`sekolah_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sekolah_id->Sortable = TRUE; // Allow sort
		$this->sekolah_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['sekolah_id'] = &$this->sekolah_id;

		// kelas_id
		$this->kelas_id = new cField('v04_uang_masuk', 'v04_uang_masuk', 'x_kelas_id', 'kelas_id', '`kelas_id`', '`kelas_id`', 3, -1, FALSE, '`kelas_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kelas_id->Sortable = TRUE; // Allow sort
		$this->kelas_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['kelas_id'] = &$this->kelas_id;

		// NIS
		$this->NIS = new cField('v04_uang_masuk', 'v04_uang_masuk', 'x_NIS', 'NIS', '`NIS`', '`NIS`', 200, -1, FALSE, '`NIS`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NIS->Sortable = TRUE; // Allow sort
		$this->fields['NIS'] = &$this->NIS;

		// Nama
		$this->Nama = new cField('v04_uang_masuk', 'v04_uang_masuk', 'x_Nama', 'Nama', '`Nama`', '`Nama`', 200, -1, FALSE, '`Nama`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Nama->Sortable = TRUE; // Allow sort
		$this->fields['Nama'] = &$this->Nama;

		// Jenis
		$this->Jenis = new cField('v04_uang_masuk', 'v04_uang_masuk', 'x_Jenis', 'Jenis', '`Jenis`', '`Jenis`', 200, -1, FALSE, '`Jenis`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Jenis->Sortable = TRUE; // Allow sort
		$this->fields['Jenis'] = &$this->Jenis;

		// Nilai
		$this->Nilai = new cField('v04_uang_masuk', 'v04_uang_masuk', 'x_Nilai', 'Nilai', '`Nilai`', '`Nilai`', 4, -1, FALSE, '`Nilai`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Nilai->Sortable = TRUE; // Allow sort
		$this->Nilai->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Nilai'] = &$this->Nilai;

		// Kelas
		$this->Kelas = new cField('v04_uang_masuk', 'v04_uang_masuk', 'x_Kelas', 'Kelas', '`Kelas`', '`Kelas`', 200, -1, FALSE, '`Kelas`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Kelas->Sortable = TRUE; // Allow sort
		$this->fields['Kelas'] = &$this->Kelas;

		// Sekolah
		$this->Sekolah = new cField('v04_uang_masuk', 'v04_uang_masuk', 'x_Sekolah', 'Sekolah', '`Sekolah`', '`Sekolah`', 200, -1, FALSE, '`Sekolah`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Sekolah->Sortable = TRUE; // Allow sort
		$this->fields['Sekolah'] = &$this->Sekolah;

		// Periode_Tahun_Bulan
		$this->Periode_Tahun_Bulan = new cField('v04_uang_masuk', 'v04_uang_masuk', 'x_Periode_Tahun_Bulan', 'Periode_Tahun_Bulan', '`Periode_Tahun_Bulan`', '`Periode_Tahun_Bulan`', 200, -1, FALSE, '`Periode_Tahun_Bulan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Periode_Tahun_Bulan->Sortable = TRUE; // Allow sort
		$this->fields['Periode_Tahun_Bulan'] = &$this->Periode_Tahun_Bulan;

		// Periode_Text
		$this->Periode_Text = new cField('v04_uang_masuk', 'v04_uang_masuk', 'x_Periode_Text', 'Periode_Text', '`Periode_Text`', '`Periode_Text`', 200, -1, FALSE, '`Periode_Text`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Periode_Text->Sortable = TRUE; // Allow sort
		$this->fields['Periode_Text'] = &$this->Periode_Text;

		// Bayar
		$this->Bayar = new cField('v04_uang_masuk', 'v04_uang_masuk', 'x_Bayar', 'Bayar', '`Bayar`', '`Bayar`', 4, -1, FALSE, '`Bayar`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Bayar->Sortable = TRUE; // Allow sort
		$this->Bayar->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Bayar'] = &$this->Bayar;

		// Per_Thn_Bln_Byr
		$this->Per_Thn_Bln_Byr = new cField('v04_uang_masuk', 'v04_uang_masuk', 'x_Per_Thn_Bln_Byr', 'Per_Thn_Bln_Byr', '`Per_Thn_Bln_Byr`', '`Per_Thn_Bln_Byr`', 200, -1, FALSE, '`Per_Thn_Bln_Byr`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Per_Thn_Bln_Byr->Sortable = TRUE; // Allow sort
		$this->fields['Per_Thn_Bln_Byr'] = &$this->Per_Thn_Bln_Byr;

		// Per_Thn_Bln_Byr_Text
		$this->Per_Thn_Bln_Byr_Text = new cField('v04_uang_masuk', 'v04_uang_masuk', 'x_Per_Thn_Bln_Byr_Text', 'Per_Thn_Bln_Byr_Text', '`Per_Thn_Bln_Byr_Text`', '`Per_Thn_Bln_Byr_Text`', 200, -1, FALSE, '`Per_Thn_Bln_Byr_Text`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Per_Thn_Bln_Byr_Text->Sortable = TRUE; // Allow sort
		$this->fields['Per_Thn_Bln_Byr_Text'] = &$this->Per_Thn_Bln_Byr_Text;
	}

	// Set Field Visibility
	function SetFieldVisibility($fldparm) {
		global $Security;
		return $this->$fldparm->Visible; // Returns original value
	}

	// Multiple column sort
	function UpdateSort(&$ofld, $ctrl) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			if ($ctrl) {
				$sOrderBy = $this->getSessionOrderBy();
				if (strpos($sOrderBy, $sSortField . " " . $sLastSort) !== FALSE) {
					$sOrderBy = str_replace($sSortField . " " . $sLastSort, $sSortField . " " . $sThisSort, $sOrderBy);
				} else {
					if ($sOrderBy <> "") $sOrderBy .= ", ";
					$sOrderBy .= $sSortField . " " . $sThisSort;
				}
				$this->setSessionOrderBy($sOrderBy); // Save to Session
			} else {
				$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
			}
		} else {
			if (!$ctrl) $ofld->setSort("");
		}
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`v04_uang_masuk`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
		return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
		$this->_SqlSelect = $v;
	}
	var $_SqlWhere = "";

	function getSqlWhere() { // Where
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
		return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
		$this->_SqlWhere = $v;
	}
	var $_SqlGroupBy = "";

	function getSqlGroupBy() { // Group By
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
		return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
		$this->_SqlGroupBy = $v;
	}
	var $_SqlHaving = "";

	function getSqlHaving() { // Having
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
		return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
		$this->_SqlHaving = $v;
	}
	var $_SqlOrderBy = "";

	function getSqlOrderBy() { // Order By
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "";
	}

	function SqlOrderBy() { // For backward compatibility
		return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
		$this->_SqlOrderBy = $v;
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$sFilter = $this->CurrentFilter;
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$sFilter, $sSort);
	}

	// Table SQL with List page filter
	function SelectSQL() {
		$sFilter = $this->getSessionWhere();
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$this->Recordset_Selecting($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sSql) {
		$cnt = -1;
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') && preg_match("/^SELECT \* FROM/i", $sSql)) {
			$sSql = "SELECT COUNT(*) FROM" . preg_replace('/^SELECT\s([\s\S]+)?\*\sFROM/i', "", $sSql);
			$sOrderBy = $this->GetOrderBy();
			if (substr($sSql, strlen($sOrderBy) * -1) == $sOrderBy)
				$sSql = substr($sSql, 0, strlen($sSql) - strlen($sOrderBy)); // Remove ORDER BY clause
		} else {
			$sSql = "SELECT COUNT(*) FROM (" . $sSql . ") EW_COUNT_TABLE";
		}
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sSql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($sFilter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $sFilter;
		$this->Recordset_Selecting($this->CurrentFilter);

		//$sSql = $this->SQL();
		$sSql = $this->GetSQL($this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function SelectRecordCount() {
		$sSql = $this->SelectSQL();
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			$conn = &$this->Connection();
			if ($rs = $conn->Execute($sSql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($names, -1) == ",")
			$names = substr($names, 0, -1);
		while (substr($values, -1) == ",")
			$values = substr($values, 0, -1);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		$conn = &$this->Connection();
		$bInsert = $conn->Execute($this->InsertSQL($rs));
		if ($bInsert) {
		}
		return $bInsert;
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($sql, -1) == ",")
			$sql = substr($sql, 0, -1);
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL, $curfilter = TRUE) {
		$conn = &$this->Connection();
		$bUpdate = $conn->Execute($this->UpdateSQL($rs, $where, $curfilter));
		return $bUpdate;
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		if ($rs) {
		}
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "", $curfilter = TRUE) {
		$conn = &$this->Connection();
		$bDelete = $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
		return $bDelete;
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "v04_uang_masuklist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "v04_uang_masuklist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("v04_uang_masukview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("v04_uang_masukview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "v04_uang_masukadd.php?" . $this->UrlParm($parm);
		else
			$url = "v04_uang_masukadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("v04_uang_masukedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("v04_uang_masukadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("v04_uang_masukdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort());
			return $this->AddMasterUrl(ew_CurrentPage() . "?" . $sUrlParm);
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = ew_StripSlashes($_POST["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = ew_StripSlashes($_GET["key_m"]);
			$cnt = count($arKeys);
		} elseif (!empty($_GET) || !empty($_POST)) {
			$isPost = ew_IsHttpPost();

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				$ar[] = $key;
			}
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($sFilter) {

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $sFilter;
		//$sSql = $this->SQL();

		$sSql = $this->GetSQL($sFilter, "");
		$conn = &$this->Connection();
		$rs = $conn->Execute($sSql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
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

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
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

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// siswanonrutin_id
		$this->siswanonrutin_id->EditAttrs["class"] = "form-control";
		$this->siswanonrutin_id->EditCustomAttributes = "";
		$this->siswanonrutin_id->EditValue = $this->siswanonrutin_id->CurrentValue;
		$this->siswanonrutin_id->PlaceHolder = ew_RemoveHtml($this->siswanonrutin_id->FldCaption());

		// siswa_id
		$this->siswa_id->EditAttrs["class"] = "form-control";
		$this->siswa_id->EditCustomAttributes = "";
		$this->siswa_id->EditValue = $this->siswa_id->CurrentValue;
		$this->siswa_id->PlaceHolder = ew_RemoveHtml($this->siswa_id->FldCaption());

		// nonrutin_id
		$this->nonrutin_id->EditAttrs["class"] = "form-control";
		$this->nonrutin_id->EditCustomAttributes = "";
		$this->nonrutin_id->EditValue = $this->nonrutin_id->CurrentValue;
		$this->nonrutin_id->PlaceHolder = ew_RemoveHtml($this->nonrutin_id->FldCaption());

		// sekolah_id
		$this->sekolah_id->EditAttrs["class"] = "form-control";
		$this->sekolah_id->EditCustomAttributes = "";
		$this->sekolah_id->EditValue = $this->sekolah_id->CurrentValue;
		$this->sekolah_id->PlaceHolder = ew_RemoveHtml($this->sekolah_id->FldCaption());

		// kelas_id
		$this->kelas_id->EditAttrs["class"] = "form-control";
		$this->kelas_id->EditCustomAttributes = "";
		$this->kelas_id->EditValue = $this->kelas_id->CurrentValue;
		$this->kelas_id->PlaceHolder = ew_RemoveHtml($this->kelas_id->FldCaption());

		// NIS
		$this->NIS->EditAttrs["class"] = "form-control";
		$this->NIS->EditCustomAttributes = "";
		$this->NIS->EditValue = $this->NIS->CurrentValue;
		$this->NIS->PlaceHolder = ew_RemoveHtml($this->NIS->FldCaption());

		// Nama
		$this->Nama->EditAttrs["class"] = "form-control";
		$this->Nama->EditCustomAttributes = "";
		$this->Nama->EditValue = $this->Nama->CurrentValue;
		$this->Nama->PlaceHolder = ew_RemoveHtml($this->Nama->FldCaption());

		// Jenis
		$this->Jenis->EditAttrs["class"] = "form-control";
		$this->Jenis->EditCustomAttributes = "";
		$this->Jenis->EditValue = $this->Jenis->CurrentValue;
		$this->Jenis->PlaceHolder = ew_RemoveHtml($this->Jenis->FldCaption());

		// Nilai
		$this->Nilai->EditAttrs["class"] = "form-control";
		$this->Nilai->EditCustomAttributes = "";
		$this->Nilai->EditValue = $this->Nilai->CurrentValue;
		$this->Nilai->PlaceHolder = ew_RemoveHtml($this->Nilai->FldCaption());
		if (strval($this->Nilai->EditValue) <> "" && is_numeric($this->Nilai->EditValue)) $this->Nilai->EditValue = ew_FormatNumber($this->Nilai->EditValue, -2, -1, -2, 0);

		// Kelas
		$this->Kelas->EditAttrs["class"] = "form-control";
		$this->Kelas->EditCustomAttributes = "";
		$this->Kelas->EditValue = $this->Kelas->CurrentValue;
		$this->Kelas->PlaceHolder = ew_RemoveHtml($this->Kelas->FldCaption());

		// Sekolah
		$this->Sekolah->EditAttrs["class"] = "form-control";
		$this->Sekolah->EditCustomAttributes = "";
		$this->Sekolah->EditValue = $this->Sekolah->CurrentValue;
		$this->Sekolah->PlaceHolder = ew_RemoveHtml($this->Sekolah->FldCaption());

		// Periode_Tahun_Bulan
		$this->Periode_Tahun_Bulan->EditAttrs["class"] = "form-control";
		$this->Periode_Tahun_Bulan->EditCustomAttributes = "";
		$this->Periode_Tahun_Bulan->EditValue = $this->Periode_Tahun_Bulan->CurrentValue;
		$this->Periode_Tahun_Bulan->PlaceHolder = ew_RemoveHtml($this->Periode_Tahun_Bulan->FldCaption());

		// Periode_Text
		$this->Periode_Text->EditAttrs["class"] = "form-control";
		$this->Periode_Text->EditCustomAttributes = "";
		$this->Periode_Text->EditValue = $this->Periode_Text->CurrentValue;
		$this->Periode_Text->PlaceHolder = ew_RemoveHtml($this->Periode_Text->FldCaption());

		// Bayar
		$this->Bayar->EditAttrs["class"] = "form-control";
		$this->Bayar->EditCustomAttributes = "";
		$this->Bayar->EditValue = $this->Bayar->CurrentValue;
		$this->Bayar->PlaceHolder = ew_RemoveHtml($this->Bayar->FldCaption());
		if (strval($this->Bayar->EditValue) <> "" && is_numeric($this->Bayar->EditValue)) $this->Bayar->EditValue = ew_FormatNumber($this->Bayar->EditValue, -2, -1, -2, 0);

		// Per_Thn_Bln_Byr
		$this->Per_Thn_Bln_Byr->EditAttrs["class"] = "form-control";
		$this->Per_Thn_Bln_Byr->EditCustomAttributes = "";
		$this->Per_Thn_Bln_Byr->EditValue = $this->Per_Thn_Bln_Byr->CurrentValue;
		$this->Per_Thn_Bln_Byr->PlaceHolder = ew_RemoveHtml($this->Per_Thn_Bln_Byr->FldCaption());

		// Per_Thn_Bln_Byr_Text
		$this->Per_Thn_Bln_Byr_Text->EditAttrs["class"] = "form-control";
		$this->Per_Thn_Bln_Byr_Text->EditCustomAttributes = "";
		$this->Per_Thn_Bln_Byr_Text->EditValue = $this->Per_Thn_Bln_Byr_Text->CurrentValue;
		$this->Per_Thn_Bln_Byr_Text->PlaceHolder = ew_RemoveHtml($this->Per_Thn_Bln_Byr_Text->FldCaption());

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {

		// Call Row Rendered event
		$this->Row_Rendered();
	}
	var $ExportDoc;

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;
		if (!$Doc->ExportCustom) {

			// Write header
			$Doc->ExportTableHeader();
			if ($Doc->Horizontal) { // Horizontal format, write header
				$Doc->BeginExportRow();
				if ($ExportPageType == "view") {
					if ($this->siswanonrutin_id->Exportable) $Doc->ExportCaption($this->siswanonrutin_id);
					if ($this->siswa_id->Exportable) $Doc->ExportCaption($this->siswa_id);
					if ($this->nonrutin_id->Exportable) $Doc->ExportCaption($this->nonrutin_id);
					if ($this->sekolah_id->Exportable) $Doc->ExportCaption($this->sekolah_id);
					if ($this->kelas_id->Exportable) $Doc->ExportCaption($this->kelas_id);
					if ($this->NIS->Exportable) $Doc->ExportCaption($this->NIS);
					if ($this->Nama->Exportable) $Doc->ExportCaption($this->Nama);
					if ($this->Jenis->Exportable) $Doc->ExportCaption($this->Jenis);
					if ($this->Nilai->Exportable) $Doc->ExportCaption($this->Nilai);
					if ($this->Kelas->Exportable) $Doc->ExportCaption($this->Kelas);
					if ($this->Sekolah->Exportable) $Doc->ExportCaption($this->Sekolah);
					if ($this->Periode_Tahun_Bulan->Exportable) $Doc->ExportCaption($this->Periode_Tahun_Bulan);
					if ($this->Periode_Text->Exportable) $Doc->ExportCaption($this->Periode_Text);
					if ($this->Bayar->Exportable) $Doc->ExportCaption($this->Bayar);
					if ($this->Per_Thn_Bln_Byr->Exportable) $Doc->ExportCaption($this->Per_Thn_Bln_Byr);
					if ($this->Per_Thn_Bln_Byr_Text->Exportable) $Doc->ExportCaption($this->Per_Thn_Bln_Byr_Text);
				} else {
					if ($this->siswanonrutin_id->Exportable) $Doc->ExportCaption($this->siswanonrutin_id);
					if ($this->siswa_id->Exportable) $Doc->ExportCaption($this->siswa_id);
					if ($this->nonrutin_id->Exportable) $Doc->ExportCaption($this->nonrutin_id);
					if ($this->sekolah_id->Exportable) $Doc->ExportCaption($this->sekolah_id);
					if ($this->kelas_id->Exportable) $Doc->ExportCaption($this->kelas_id);
					if ($this->NIS->Exportable) $Doc->ExportCaption($this->NIS);
					if ($this->Nama->Exportable) $Doc->ExportCaption($this->Nama);
					if ($this->Jenis->Exportable) $Doc->ExportCaption($this->Jenis);
					if ($this->Nilai->Exportable) $Doc->ExportCaption($this->Nilai);
					if ($this->Kelas->Exportable) $Doc->ExportCaption($this->Kelas);
					if ($this->Sekolah->Exportable) $Doc->ExportCaption($this->Sekolah);
					if ($this->Periode_Tahun_Bulan->Exportable) $Doc->ExportCaption($this->Periode_Tahun_Bulan);
					if ($this->Periode_Text->Exportable) $Doc->ExportCaption($this->Periode_Text);
					if ($this->Bayar->Exportable) $Doc->ExportCaption($this->Bayar);
					if ($this->Per_Thn_Bln_Byr->Exportable) $Doc->ExportCaption($this->Per_Thn_Bln_Byr);
					if ($this->Per_Thn_Bln_Byr_Text->Exportable) $Doc->ExportCaption($this->Per_Thn_Bln_Byr_Text);
				}
				$Doc->EndExportRow();
			}
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				if (!$Doc->ExportCustom) {
					$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
					if ($ExportPageType == "view") {
						if ($this->siswanonrutin_id->Exportable) $Doc->ExportField($this->siswanonrutin_id);
						if ($this->siswa_id->Exportable) $Doc->ExportField($this->siswa_id);
						if ($this->nonrutin_id->Exportable) $Doc->ExportField($this->nonrutin_id);
						if ($this->sekolah_id->Exportable) $Doc->ExportField($this->sekolah_id);
						if ($this->kelas_id->Exportable) $Doc->ExportField($this->kelas_id);
						if ($this->NIS->Exportable) $Doc->ExportField($this->NIS);
						if ($this->Nama->Exportable) $Doc->ExportField($this->Nama);
						if ($this->Jenis->Exportable) $Doc->ExportField($this->Jenis);
						if ($this->Nilai->Exportable) $Doc->ExportField($this->Nilai);
						if ($this->Kelas->Exportable) $Doc->ExportField($this->Kelas);
						if ($this->Sekolah->Exportable) $Doc->ExportField($this->Sekolah);
						if ($this->Periode_Tahun_Bulan->Exportable) $Doc->ExportField($this->Periode_Tahun_Bulan);
						if ($this->Periode_Text->Exportable) $Doc->ExportField($this->Periode_Text);
						if ($this->Bayar->Exportable) $Doc->ExportField($this->Bayar);
						if ($this->Per_Thn_Bln_Byr->Exportable) $Doc->ExportField($this->Per_Thn_Bln_Byr);
						if ($this->Per_Thn_Bln_Byr_Text->Exportable) $Doc->ExportField($this->Per_Thn_Bln_Byr_Text);
					} else {
						if ($this->siswanonrutin_id->Exportable) $Doc->ExportField($this->siswanonrutin_id);
						if ($this->siswa_id->Exportable) $Doc->ExportField($this->siswa_id);
						if ($this->nonrutin_id->Exportable) $Doc->ExportField($this->nonrutin_id);
						if ($this->sekolah_id->Exportable) $Doc->ExportField($this->sekolah_id);
						if ($this->kelas_id->Exportable) $Doc->ExportField($this->kelas_id);
						if ($this->NIS->Exportable) $Doc->ExportField($this->NIS);
						if ($this->Nama->Exportable) $Doc->ExportField($this->Nama);
						if ($this->Jenis->Exportable) $Doc->ExportField($this->Jenis);
						if ($this->Nilai->Exportable) $Doc->ExportField($this->Nilai);
						if ($this->Kelas->Exportable) $Doc->ExportField($this->Kelas);
						if ($this->Sekolah->Exportable) $Doc->ExportField($this->Sekolah);
						if ($this->Periode_Tahun_Bulan->Exportable) $Doc->ExportField($this->Periode_Tahun_Bulan);
						if ($this->Periode_Text->Exportable) $Doc->ExportField($this->Periode_Text);
						if ($this->Bayar->Exportable) $Doc->ExportField($this->Bayar);
						if ($this->Per_Thn_Bln_Byr->Exportable) $Doc->ExportField($this->Per_Thn_Bln_Byr);
						if ($this->Per_Thn_Bln_Byr_Text->Exportable) $Doc->ExportField($this->Per_Thn_Bln_Byr_Text);
					}
					$Doc->EndExportRow();
				}
			}

			// Call Row Export server event
			if ($Doc->ExportCustom)
				$this->Row_Export($Recordset->fields);
			$Recordset->MoveNext();
		}
		if (!$Doc->ExportCustom) {
			$Doc->ExportTableFooter();
		}
	}

	// Get auto fill value
	function GetAutoFill($id, $val) {
		$rsarr = array();
		$rowcnt = 0;

		// Output
		if (is_array($rsarr) && $rowcnt > 0) {
			$fldcnt = count($rsarr[0]);
			for ($i = 0; $i < $rowcnt; $i++) {
				for ($j = 0; $j < $fldcnt; $j++) {
					$str = strval($rsarr[$i][$j]);
					$str = ew_ConvertToUtf8($str);
					if (isset($post["keepCRLF"])) {
						$str = str_replace(array("\r", "\n"), array("\\r", "\\n"), $str);
					} else {
						$str = str_replace(array("\r", "\n"), array(" ", " "), $str);
					}
					$rsarr[$i][$j] = $str;
				}
			}
			return ew_ArrayToJson($rsarr);
		} else {
			return FALSE;
		}
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here	
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here	
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here	
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		//var_dump($fld->FldName, $fld->LookupFilters, $filter); // Uncomment to view the filter
		// Enter your code here

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>); 

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
