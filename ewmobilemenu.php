<!-- Begin Main Menu -->
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(21, "mmi_cf01_home_php", $Language->MenuPhrase("21", "MenuText"), "cf01_home.php", -1, "", TRUE, FALSE, TRUE);
$RootMenu->AddMenuItem(10, "mmi_v01_siswa", $Language->MenuPhrase("10", "MenuText"), "v01_siswalist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(19, "mmci_Setup", $Language->MenuPhrase("19", "MenuText"), "", -1, "", TRUE, FALSE, TRUE);
$RootMenu->AddMenuItem(26, "mmi_t93_periode", $Language->MenuPhrase("26", "MenuText"), "t93_periodelist.php", 19, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(1, "mmi_t01_tahunajaran", $Language->MenuPhrase("1", "MenuText"), "t01_tahunajaranlist.php", 19, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(2, "mmi_t02_sekolah", $Language->MenuPhrase("2", "MenuText"), "t02_sekolahlist.php", 19, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(3, "mmi_t03_kelas", $Language->MenuPhrase("3", "MenuText"), "t03_kelaslist.php", 19, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(4, "mmi_t04_siswa", $Language->MenuPhrase("4", "MenuText"), "t04_siswalist.php", 19, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(5, "mmi_t05_rutin", $Language->MenuPhrase("5", "MenuText"), "t05_rutinlist.php", 19, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(22, "mmi_t08_nonrutin", $Language->MenuPhrase("22", "MenuText"), "t08_nonrutinlist.php", 19, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(27, "mmi_cf02_tutupbuku_php", $Language->MenuPhrase("27", "MenuText"), "cf02_tutupbuku.php", -1, "", TRUE, FALSE, TRUE);
$RootMenu->AddMenuItem(20, "mmci_Laporan", $Language->MenuPhrase("20", "MenuText"), "", -1, "", TRUE, FALSE, TRUE);
$RootMenu->AddMenuItem(10017, "mmri_v025fsiswa", $Language->MenuPhrase("10017", "MenuText"), "v02_siswarpt.php", 20, "{0BB1DC5C-09DE-419A-9701-F3161918C007}", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(10020, "mmri_v035fsiswa5fblm5fbyr", $Language->MenuPhrase("10020", "MenuText"), "v03_siswa_blm_byrrpt.php", 20, "{0BB1DC5C-09DE-419A-9701-F3161918C007}", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(8, "mmi_t99_audittrail", $Language->MenuPhrase("8", "MenuText"), "t99_audittraillist.php", 20, "", TRUE, FALSE, FALSE);
$RootMenu->Render();
?>
<!-- End Main Menu -->
