<?php

// Global variable for table object
$r02_belumbayar = NULL;

//
// Table class for r02_belumbayar
//
class crr02_belumbayar extends crTableBase {
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
	var $Jenis;
	var $Nilai;

	//
	// Table class constructor
	//
	function __construct() {
		global $ReportLanguage, $gsLanguage;
		$this->TableVar = 'r02_belumbayar';
		$this->TableName = 'r02_belumbayar';
		$this->TableType = 'REPORT';
		$this->DBID = 'DB';
		$this->ExportAll = FALSE;
		$this->ExportPageBreakCount = 0;

		// siswarutin_id
		$this->siswarutin_id = new crField('r02_belumbayar', 'r02_belumbayar', 'x_siswarutin_id', 'siswarutin_id', '`siswarutin_id`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->siswarutin_id->Sortable = TRUE; // Allow sort
		$this->siswarutin_id->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['siswarutin_id'] = &$this->siswarutin_id;
		$this->siswarutin_id->DateFilter = "";
		$this->siswarutin_id->SqlSelect = "";
		$this->siswarutin_id->SqlOrderBy = "";

		// siswa_id
		$this->siswa_id = new crField('r02_belumbayar', 'r02_belumbayar', 'x_siswa_id', 'siswa_id', '`siswa_id`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->siswa_id->Sortable = TRUE; // Allow sort
		$this->siswa_id->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['siswa_id'] = &$this->siswa_id;
		$this->siswa_id->DateFilter = "";
		$this->siswa_id->SqlSelect = "";
		$this->siswa_id->SqlOrderBy = "";

		// rutin_id
		$this->rutin_id = new crField('r02_belumbayar', 'r02_belumbayar', 'x_rutin_id', 'rutin_id', '`rutin_id`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->rutin_id->Sortable = TRUE; // Allow sort
		$this->rutin_id->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['rutin_id'] = &$this->rutin_id;
		$this->rutin_id->DateFilter = "";
		$this->rutin_id->SqlSelect = "";
		$this->rutin_id->SqlOrderBy = "";

		// sekolah_id
		$this->sekolah_id = new crField('r02_belumbayar', 'r02_belumbayar', 'x_sekolah_id', 'sekolah_id', '`sekolah_id`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->sekolah_id->Sortable = TRUE; // Allow sort
		$this->sekolah_id->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['sekolah_id'] = &$this->sekolah_id;
		$this->sekolah_id->DateFilter = "";
		$this->sekolah_id->SqlSelect = "";
		$this->sekolah_id->SqlOrderBy = "";

		// kelas_id
		$this->kelas_id = new crField('r02_belumbayar', 'r02_belumbayar', 'x_kelas_id', 'kelas_id', '`kelas_id`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->kelas_id->Sortable = TRUE; // Allow sort
		$this->kelas_id->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['kelas_id'] = &$this->kelas_id;
		$this->kelas_id->DateFilter = "";
		$this->kelas_id->SqlSelect = "";
		$this->kelas_id->SqlOrderBy = "";

		// NIS
		$this->NIS = new crField('r02_belumbayar', 'r02_belumbayar', 'x_NIS', 'NIS', '`NIS`', 200, EWR_DATATYPE_STRING, -1);
		$this->NIS->Sortable = TRUE; // Allow sort
		$this->NIS->GroupingFieldId = 3;
		$this->NIS->ShowGroupHeaderAsRow = $this->ShowGroupHeaderAsRow;
		$this->NIS->ShowCompactSummaryFooter = $this->ShowCompactSummaryFooter;
		$this->fields['NIS'] = &$this->NIS;
		$this->NIS->DateFilter = "";
		$this->NIS->SqlSelect = "";
		$this->NIS->SqlOrderBy = "";
		$this->NIS->FldGroupByType = "";
		$this->NIS->FldGroupInt = "0";
		$this->NIS->FldGroupSql = "";

		// Nama
		$this->Nama = new crField('r02_belumbayar', 'r02_belumbayar', 'x_Nama', 'Nama', '`Nama`', 200, EWR_DATATYPE_STRING, -1);
		$this->Nama->Sortable = TRUE; // Allow sort
		$this->Nama->GroupingFieldId = 4;
		$this->Nama->ShowGroupHeaderAsRow = $this->ShowGroupHeaderAsRow;
		$this->Nama->ShowCompactSummaryFooter = $this->ShowCompactSummaryFooter;
		$this->fields['Nama'] = &$this->Nama;
		$this->Nama->DateFilter = "";
		$this->Nama->SqlSelect = "";
		$this->Nama->SqlOrderBy = "";
		$this->Nama->FldGroupByType = "";
		$this->Nama->FldGroupInt = "0";
		$this->Nama->FldGroupSql = "";

		// Kelas
		$this->Kelas = new crField('r02_belumbayar', 'r02_belumbayar', 'x_Kelas', 'Kelas', '`Kelas`', 200, EWR_DATATYPE_STRING, -1);
		$this->Kelas->Sortable = TRUE; // Allow sort
		$this->Kelas->GroupingFieldId = 2;
		$this->Kelas->ShowGroupHeaderAsRow = $this->ShowGroupHeaderAsRow;
		$this->Kelas->ShowCompactSummaryFooter = $this->ShowCompactSummaryFooter;
		$this->fields['Kelas'] = &$this->Kelas;
		$this->Kelas->DateFilter = "";
		$this->Kelas->SqlSelect = "";
		$this->Kelas->SqlOrderBy = "";
		$this->Kelas->FldGroupByType = "";
		$this->Kelas->FldGroupInt = "0";
		$this->Kelas->FldGroupSql = "";

		// Sekolah
		$this->Sekolah = new crField('r02_belumbayar', 'r02_belumbayar', 'x_Sekolah', 'Sekolah', '`Sekolah`', 200, EWR_DATATYPE_STRING, -1);
		$this->Sekolah->Sortable = TRUE; // Allow sort
		$this->Sekolah->GroupingFieldId = 1;
		$this->Sekolah->ShowGroupHeaderAsRow = $this->ShowGroupHeaderAsRow;
		$this->Sekolah->ShowCompactSummaryFooter = $this->ShowCompactSummaryFooter;
		$this->fields['Sekolah'] = &$this->Sekolah;
		$this->Sekolah->DateFilter = "";
		$this->Sekolah->SqlSelect = "";
		$this->Sekolah->SqlOrderBy = "";
		$this->Sekolah->FldGroupByType = "";
		$this->Sekolah->FldGroupInt = "0";
		$this->Sekolah->FldGroupSql = "";

		// Periode_Tahun_Bulan
		$this->Periode_Tahun_Bulan = new crField('r02_belumbayar', 'r02_belumbayar', 'x_Periode_Tahun_Bulan', 'Periode_Tahun_Bulan', '`Periode_Tahun_Bulan`', 200, EWR_DATATYPE_STRING, -1);
		$this->Periode_Tahun_Bulan->Sortable = TRUE; // Allow sort
		$this->fields['Periode_Tahun_Bulan'] = &$this->Periode_Tahun_Bulan;
		$this->Periode_Tahun_Bulan->DateFilter = "";
		$this->Periode_Tahun_Bulan->SqlSelect = "";
		$this->Periode_Tahun_Bulan->SqlOrderBy = "";

		// Periode_Text
		$this->Periode_Text = new crField('r02_belumbayar', 'r02_belumbayar', 'x_Periode_Text', 'Periode_Text', '`Periode_Text`', 200, EWR_DATATYPE_STRING, -1);
		$this->Periode_Text->Sortable = TRUE; // Allow sort
		$this->fields['Periode_Text'] = &$this->Periode_Text;
		$this->Periode_Text->DateFilter = "";
		$this->Periode_Text->SqlSelect = "";
		$this->Periode_Text->SqlOrderBy = "";

		// Jenis
		$this->Jenis = new crField('r02_belumbayar', 'r02_belumbayar', 'x_Jenis', 'Jenis', '`Jenis`', 200, EWR_DATATYPE_STRING, -1);
		$this->Jenis->Sortable = TRUE; // Allow sort
		$this->Jenis->GroupingFieldId = 5;
		$this->Jenis->ShowGroupHeaderAsRow = $this->ShowGroupHeaderAsRow;
		$this->Jenis->ShowCompactSummaryFooter = $this->ShowCompactSummaryFooter;
		$this->fields['Jenis'] = &$this->Jenis;
		$this->Jenis->DateFilter = "";
		$this->Jenis->SqlSelect = "";
		$this->Jenis->SqlOrderBy = "";
		$this->Jenis->FldGroupByType = "";
		$this->Jenis->FldGroupInt = "0";
		$this->Jenis->FldGroupSql = "";

		// Nilai
		$this->Nilai = new crField('r02_belumbayar', 'r02_belumbayar', 'x_Nilai', 'Nilai', '`Nilai`', 4, EWR_DATATYPE_NUMBER, -1);
		$this->Nilai->Sortable = TRUE; // Allow sort
		$this->Nilai->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectFloat");
		$this->fields['Nilai'] = &$this->Nilai;
		$this->Nilai->DateFilter = "";
		$this->Nilai->SqlSelect = "";
		$this->Nilai->SqlOrderBy = "";
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`v03_siswa_blm_byr`";
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
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "`Sekolah` ASC, `Kelas` ASC, `NIS` ASC, `Nama` ASC, `Jenis` ASC";
	}

	function SqlOrderBy() { // For backward compatibility
		return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
		$this->_SqlOrderBy = $v;
	}

	// Table Level Group SQL
	// First Group Field

	var $_SqlFirstGroupField = "";

	function getSqlFirstGroupField() {
		return ($this->_SqlFirstGroupField <> "") ? $this->_SqlFirstGroupField : "`Sekolah`";
	}

	function SqlFirstGroupField() { // For backward compatibility
		return $this->getSqlFirstGroupField();
	}

	function setSqlFirstGroupField($v) {
		$this->_SqlFirstGroupField = $v;
	}

	// Select Group
	var $_SqlSelectGroup = "";

	function getSqlSelectGroup() {
		return ($this->_SqlSelectGroup <> "") ? $this->_SqlSelectGroup : "SELECT DISTINCT " . $this->getSqlFirstGroupField() . " FROM " . $this->getSqlFrom();
	}

	function SqlSelectGroup() { // For backward compatibility
		return $this->getSqlSelectGroup();
	}

	function setSqlSelectGroup($v) {
		$this->_SqlSelectGroup = $v;
	}

	// Order By Group
	var $_SqlOrderByGroup = "";

	function getSqlOrderByGroup() {
		return ($this->_SqlOrderByGroup <> "") ? $this->_SqlOrderByGroup : "`Sekolah` ASC";
	}

	function SqlOrderByGroup() { // For backward compatibility
		return $this->getSqlOrderByGroup();
	}

	function setSqlOrderByGroup($v) {
		$this->_SqlOrderByGroup = $v;
	}

	// Select Aggregate
	var $_SqlSelectAgg = "";

	function getSqlSelectAgg() {
		return ($this->_SqlSelectAgg <> "") ? $this->_SqlSelectAgg : "SELECT SUM(`Nilai`) AS `sum_nilai` FROM " . $this->getSqlFrom();
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
		case "x_NIS":
			$sSqlWrk = "";
		$sSqlWrk = "SELECT DISTINCT `NIS`, `NIS` AS `DispFld`, '' AS `DispFld2`, '' AS `DispFld3`, '' AS `DispFld4` FROM `v03_siswa_blm_byr`";
		$sWhereWrk = "";
		$this->NIS->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "DB", "f0" => '`NIS` = {filter_value}', "t0" => "200", "fn0" => "", "dlm" => ewr_Encrypt($fld->FldDelimiter));
			$sSqlWrk = "";
		$this->Lookup_Selecting($this->NIS, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `NIS` ASC";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Nama":
			$sSqlWrk = "";
		$sSqlWrk = "SELECT DISTINCT `Nama`, `Nama` AS `DispFld`, '' AS `DispFld2`, '' AS `DispFld3`, '' AS `DispFld4` FROM `v03_siswa_blm_byr`";
		$sWhereWrk = "";
		$this->Nama->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "DB", "f0" => '`Nama` = {filter_value}', "t0" => "200", "fn0" => "", "dlm" => ewr_Encrypt($fld->FldDelimiter));
			$sSqlWrk = "";
		$this->Lookup_Selecting($this->Nama, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Nama` ASC";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Kelas":
			$sSqlWrk = "";
		$sSqlWrk = "SELECT DISTINCT `Kelas`, `Kelas` AS `DispFld`, '' AS `DispFld2`, '' AS `DispFld3`, '' AS `DispFld4` FROM `v03_siswa_blm_byr`";
		$sWhereWrk = "";
		$this->Kelas->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "DB", "f0" => '`Kelas` = {filter_value}', "t0" => "200", "fn0" => "", "dlm" => ewr_Encrypt($fld->FldDelimiter));
			$sSqlWrk = "";
		$this->Lookup_Selecting($this->Kelas, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Kelas` ASC";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Sekolah":
			$sSqlWrk = "";
		$sSqlWrk = "SELECT DISTINCT `Sekolah`, `Sekolah` AS `DispFld`, '' AS `DispFld2`, '' AS `DispFld3`, '' AS `DispFld4` FROM `v03_siswa_blm_byr`";
		$sWhereWrk = "";
		$this->Sekolah->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "DB", "f0" => '`Sekolah` = {filter_value}', "t0" => "200", "fn0" => "", "dlm" => ewr_Encrypt($fld->FldDelimiter));
			$sSqlWrk = "";
		$this->Lookup_Selecting($this->Sekolah, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Sekolah` ASC";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
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
