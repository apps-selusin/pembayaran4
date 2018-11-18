<!-- Begin Main Menu -->
<?php $RootMenu = new cMenu(EW_MENUBAR_ID) ?>
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(21, "mi_cf01_home_php", $Language->MenuPhrase("21", "MenuText"), "cf01_home.php", -1, "", TRUE, FALSE, TRUE);
$RootMenu->AddMenuItem(10, "mi_v01_siswa", $Language->MenuPhrase("10", "MenuText"), "v01_siswalist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(19, "mci_Setup", $Language->MenuPhrase("19", "MenuText"), "", -1, "", TRUE, FALSE, TRUE);
$RootMenu->AddMenuItem(26, "mi_t93_periode", $Language->MenuPhrase("26", "MenuText"), "t93_periodelist.php", 19, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(1, "mi_t01_tahunajaran", $Language->MenuPhrase("1", "MenuText"), "t01_tahunajaranlist.php", 19, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(2, "mi_t02_sekolah", $Language->MenuPhrase("2", "MenuText"), "t02_sekolahlist.php", 19, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(3, "mi_t03_kelas", $Language->MenuPhrase("3", "MenuText"), "t03_kelaslist.php", 19, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(4, "mi_t04_siswa", $Language->MenuPhrase("4", "MenuText"), "t04_siswalist.php", 19, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(5, "mi_t05_rutin", $Language->MenuPhrase("5", "MenuText"), "t05_rutinlist.php", 19, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(22, "mi_t08_nonrutin", $Language->MenuPhrase("22", "MenuText"), "t08_nonrutinlist.php", 19, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(20, "mci_Laporan", $Language->MenuPhrase("20", "MenuText"), "", -1, "", TRUE, FALSE, TRUE);
$RootMenu->AddMenuItem(8, "mi_t99_audittrail", $Language->MenuPhrase("8", "MenuText"), "t99_audittraillist.php", 20, "", TRUE, FALSE, FALSE);
$RootMenu->Render();
?>
<!-- End Main Menu -->
