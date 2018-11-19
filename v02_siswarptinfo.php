<?php

// Global variable for table object
$v02_siswa = NULL;

//
// Table class for v02_siswa
//
class crv02_siswa extends crTableBase {
	var $ShowGroupHeaderAsRow = FALSE;
	var $ShowCompactSummaryFooter = TRUE;
	var $siswarutin_id;
	var $siswa_id;
	var $rutin_id;
	var $sekolah_id;
	var $kelas_id;
	var $NIS;
	var $Nama;
	var $Kelas;
	var $Sekolah;
	var $Periode_Tahun_Bulan;
	var $Periode_Text;

	//
	// Table class constructor
	//
	function __construct() {
		global $ReportLanguage, $gsLanguage;
		$this->TableVar = 'v02_siswa';
		$this->TableName = 'v02_siswa';
		$this->TableType = 'VIEW';
		$this->DBID = 'DB';
		$this->ExportAll = FALSE;
		$this->ExportPageBreakCount = 0;

		// siswarutin_id
		$this->siswarutin_id = new crField('v02_siswa', 'v02_siswa', 'x_siswarutin_id', 'siswarutin_id', '`siswarutin_id`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->siswarutin_id->Sortable = TRUE; // Allow sort
		$this->siswarutin_id->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['siswarutin_id'] = &$this->siswarutin_id;
		$this->siswarutin_id->DateFilter = "";
		$this->siswarutin_id->SqlSelect = "";
		$this->siswarutin_id->SqlOrderBy = "";

		// siswa_id
		$this->siswa_id = new crField('v02_siswa', 'v02_siswa', 'x_siswa_id', 'siswa_id', '`siswa_id`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->siswa_id->Sortable = TRUE; // Allow sort
		$this->siswa_id->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['siswa_id'] = &$this->siswa_id;
		$this->siswa_id->DateFilter = "";
		$this->siswa_id->SqlSelect = "";
		$this->siswa_id->SqlOrderBy = "";

		// rutin_id
		$this->rutin_id = new crField('v02_siswa', 'v02_siswa', 'x_rutin_id', 'rutin_id', '`rutin_id`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->rutin_id->Sortable = TRUE; // Allow sort
		$this->rutin_id->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['rutin_id'] = &$this->rutin_id;
		$this->rutin_id->DateFilter = "";
		$this->rutin_id->SqlSelect = "";
		$this->rutin_id->SqlOrderBy = "";

		// sekolah_id
		$this->sekolah_id = new crField('v02_siswa', 'v02_siswa', 'x_sekolah_id', 'sekolah_id', '`sekolah_id`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->sekolah_id->Sortable = TRUE; // Allow sort
		$this->sekolah_id->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['sekolah_id'] = &$this->sekolah_id;
		$this->sekolah_id->DateFilter = "";
		$this->sekolah_id->SqlSelect = "";
		$this->sekolah_id->SqlOrderBy = "";

		// kelas_id
		$this->kelas_id = new crField('v02_siswa', 'v02_siswa', 'x_kelas_id', 'kelas_id', '`kelas_id`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->kelas_id->Sortable = TRUE; // Allow sort
		$this->kelas_id->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['kelas_id'] = &$this->kelas_id;
		$this->kelas_id->DateFilter = "";
		$this->kelas_id->SqlSelect = "";
		$this->kelas_id->SqlOrderBy = "";

		// NIS
		$this->NIS = new crField('v02_siswa', 'v02_siswa', 'x_NIS', 'NIS', '`NIS`', 200, EWR_DATATYPE_STRING, -1);
		$this->NIS->Sortable = TRUE; // Allow sort
		$this->fields['NIS'] = &$this->NIS;
		$this->NIS->DateFilter = "";
		$this->NIS->SqlSelect = "";
		$this->NIS->SqlOrderBy = "";

		// Nama
		$this->Nama = new crField('v02_siswa', 'v02_siswa', 'x_Nama', 'Nama', '`Nama`', 200, EWR_DATATYPE_STRING, -1);
		$this->Nama->Sortable = TRUE; // Allow sort
		$this->fields['Nama'] = &$this->Nama;
		$this->Nama->DateFilter = "";
		$this->Nama->SqlSelect = "";
		$this->Nama->SqlOrderBy = "";

		// Kelas
		$this->Kelas = new crField('v02_siswa', 'v02_siswa', 'x_Kelas', 'Kelas', '`Kelas`', 200, EWR_DATATYPE_STRING, -1);
		$this->Kelas->Sortable = TRUE; // Allow sort
		$this->fields['Kelas'] = &$this->Kelas;
		$this->Kelas->DateFilter = "";
		$this->Kelas->SqlSelect = "";
		$this->Kelas->SqlOrderBy = "";

		// Sekolah
		$this->Sekolah = new crField('v02_siswa', 'v02_siswa', 'x_Sekolah', 'Sekolah', '`Sekolah`', 200, EWR_DATATYPE_STRING, -1);
		$this->Sekolah->Sortable = TRUE; // Allow sort
		$this->fields['Sekolah'] = &$this->Sekolah;
		$this->Sekolah->DateFilter = "";
		$this->Sekolah->SqlSelect = "";
		$this->Sekolah->SqlOrderBy = "";

		// Periode_Tahun_Bulan
		$this->Periode_Tahun_Bulan = new crField('v02_siswa', 'v02_siswa', 'x_Periode_Tahun_Bulan', 'Periode_Tahun_Bulan', '`Periode_Tahun_Bulan`', 200, EWR_DATATYPE_STRING, -1);
		$this->Periode_Tahun_Bulan->Sortable = TRUE; // Allow sort
		$this->fields['Periode_Tahun_Bulan'] = &$this->Periode_Tahun_Bulan;
		$this->Periode_Tahun_Bulan->DateFilter = "";
		$this->Periode_Tahun_Bulan->SqlSelect = "";
		$this->Periode_Tahun_Bulan->SqlOrderBy = "";

		// Periode_Text
		$this->Periode_Text = new crField('v02_siswa', 'v02_siswa', 'x_Periode_Text', 'Periode_Text', '`Periode_Text`', 200, EWR_DATATYPE_STRING, -1);
		$this->Periode_Text->Sortable = TRUE; // Allow sort
		$this->fields['Periode_Text'] = &$this->Periode_Text;
		$this->Periode_Text->DateFilter = "";
		$this->Periode_Text->SqlSelect = "";
		$this->Periode_Text->SqlOrderBy = "";
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
			if ($ofld->GroupingFieldId == 0) {
				if ($ctrl) {
					$sOrderBy = $this->getDetailOrderBy();
					if (strpos($sOrderBy, $sSortField . " " . $sLastSort) !== FALSE) {
						$sOrderBy = str_replace($sSortField . " " . $sLastSort, $sSortField . " " . $sThisSort, $sOrderBy);
					} else {
						if ($sOrderBy <> "") $sOrderBy .= ", ";
						$sOrderBy .= $sSortField . " " . $sThisSort;
					}
					$this->setDetailOrderBy($sOrderBy); // Save to Session
				} else {
					$this->setDetailOrderBy($sSortField . " " . $sThisSort); // Save to Session
				}
			}
		} else {
			if ($ofld->GroupingFieldId == 0 && !$ctrl) $ofld->setSort("");
		}
	}

	// Get Sort SQL
	function SortSql() {
		$sDtlSortSql = $this->getDetailOrderBy(); // Get ORDER BY for detail fields from session
		$argrps = array();
		foreach ($this->fields as $fld) {
			if ($fld->getSort() <> "") {
				$fldsql = $fld->FldExpression;
				if ($fld->GroupingFieldId > 0) {
					if ($fld->FldGroupSql <> "")
						$argrps[$fld->GroupingFieldId] = str_replace("%s", $fldsql, $fld->FldGroupSql) . " " . $fld->getSort();
					else
						$argrps[$fld->GroupingFieldId] = $fldsql . " " . $fld->getSort();
				}
			}
		}
		$sSortSql = "";
		foreach ($argrps as $grp) {
			if ($sSortSql <> "") $sSortSql .= ", ";
			$sSortSql .= $grp;
		}
		if ($sDtlSortSql <> "") {
			if ($sSortSql <> "") $sSortSql .= ", ";
			$sSortSql .= $sDtlSortSql;
		}
		return $sSortSql;
	}

	// Table level SQL
	// From

	var $_SqlFrom = "";

	function getSqlFrom() {
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`v02_siswa`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}

	// Select
	var $_SqlSelect = "";

	function getSqlSelect() {
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
		return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
		$this->_SqlSelect = $v;
	}

	// Where
	var $_SqlWhere = "";

	function getSqlWhere() {
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
		return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
		$this->_SqlWhere = $v;
	}

	// Group By
	var $_SqlGroupBy = "";

	function getSqlGroupBy() {
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
		return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
		$this->_SqlGroupBy = $v;
	}

	// Having
	var $_SqlHaving = "";

	function getSqlHaving() {
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
		return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
		$this->_SqlHaving = $v;
	}

	// Order By
	var $_SqlOrderBy = "";

	function getSqlOrderBy() {
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "";
	}

	function SqlOrderBy() { // For backward compatibility
		return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
		$this->_SqlOrderBy = $v;
	}

	// Select Aggregate
	var $_SqlSelectAgg = "";

	function getSqlSelectAgg() {
		return ($this->_SqlSelectAgg <> "") ? $this->_SqlSelectAgg : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelectAgg() { // For backward compatibility
		return $this->getSqlSelectAgg();
	}

	function setSqlSelectAgg($v) {
		$this->_SqlSelectAgg = $v;
	}

	// Aggregate Prefix
	var $_SqlAggPfx = "";

	function getSqlAggPfx() {
		return ($this->_SqlAggPfx <> "") ? $this->_SqlAggPfx : "";
	}

	function SqlAggPfx() { // For backward compatibility
		return $this->getSqlAggPfx();
	}

	function setSqlAggPfx($v) {
		$this->_SqlAggPfx = $v;
	}

	// Aggregate Suffix
	var $_SqlAggSfx = "";

	function getSqlAggSfx() {
		return ($this->_SqlAggSfx <> "") ? $this->_SqlAggSfx : "";
	}

	function SqlAggSfx() { // For backward compatibility
		return $this->getSqlAggSfx();
	}

	function setSqlAggSfx($v) {
		$this->_SqlAggSfx = $v;
	}

	// Select Count
	var $_SqlSelectCount = "";

	function getSqlSelectCount() {
		return ($this->_SqlSelectCount <> "") ? $this->_SqlSelectCount : "SELECT COUNT(*) FROM " . $this->getSqlFrom();
	}

	function SqlSelectCount() { // For backward compatibility
		return $this->getSqlSelectCount();
	}

	function setSqlSelectCount($v) {
		$this->_SqlSelectCount = $v;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {

			//$sUrlParm = "order=" . urlencode($fld->FldName) . "&ordertype=" . $fld->ReverseSort();
			$sUrlParm = "order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort();
			return ewr_CurrentPage() . "?" . $sUrlParm;
		} else {
			return "";
		}
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld) {
		global $gsLanguage;
		switch ($fld->FldVar) {
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld) {
		global $gsLanguage;
		switch ($fld->FldVar) {
		}
	}

	// Table level events
	// Page Selecting event
	function Page_Selecting(&$filter) {

		// Enter your code here
	}

	// Page Breaking event
	function Page_Breaking(&$break, &$content) {

		// Example:
		//$break = FALSE; // Skip page break, or
		//$content = "<div style=\"page-break-after:always;\">&nbsp;</div>"; // Modify page break content

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here
	}

	// Cell Rendered event
	function Cell_Rendered(&$Field, $CurrentValue, &$ViewValue, &$ViewAttrs, &$CellAttrs, &$HrefValue, &$LinkAttrs) {

		//$ViewValue = "xxx";
		//$ViewAttrs["style"] = "xxx";

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

	// Load Filters event
	function Page_FilterLoad() {

		// Enter your code here
		// Example: Register/Unregister Custom Extended Filter
		//ewr_RegisterFilter($this-><Field>, 'StartsWithA', 'Starts With A', 'GetStartsWithAFilter'); // With function, or
		//ewr_RegisterFilter($this-><Field>, 'StartsWithA', 'Starts With A'); // No function, use Page_Filtering event
		//ewr_UnregisterFilter($this-><Field>, 'StartsWithA');

	}

	// Page Filter Validated event
	function Page_FilterValidated() {

		// Example:
		//$this->MyField1->SearchValue = "your search criteria"; // Search value

	}

	// Page Filtering event
	function Page_Filtering(&$fld, &$filter, $typ, $opr = "", $val = "", $cond = "", $opr2 = "", $val2 = "") {

		// Note: ALWAYS CHECK THE FILTER TYPE ($typ)! Example:
		//if ($typ == "dropdown" && $fld->FldName == "MyField") // Dropdown filter
		//	$filter = "..."; // Modify the filter
		//if ($typ == "extended" && $fld->FldName == "MyField") // Extended filter
		//	$filter = "..."; // Modify the filter
		//if ($typ == "popup" && $fld->FldName == "MyField") // Popup filter
		//	$filter = "..."; // Modify the filter
		//if ($typ == "custom" && $opr == "..." && $fld->FldName == "MyField") // Custom filter, $opr is the custom filter ID
		//	$filter = "..."; // Modify the filter

	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		// Enter your code here
	}
}
?>
