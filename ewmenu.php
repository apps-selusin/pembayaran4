<!-- Begin Main Menu -->
<?php $RootMenu = new cMenu(EW_MENUBAR_ID) ?>
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(9, "mi_t06_siswarutintemp", $Language->MenuPhrase("9", "MenuText"), "t06_siswarutintemplist.php?cmd=resetall", -1, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(10, "mi_v01_siswa", $Language->MenuPhrase("10", "MenuText"), "v01_siswalist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(1, "mi_t01_tahunajaran", $Language->MenuPhrase("1", "MenuText"), "t01_tahunajaranlist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(2, "mi_t02_sekolah", $Language->MenuPhrase("2", "MenuText"), "t02_sekolahlist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(3, "mi_t03_kelas", $Language->MenuPhrase("3", "MenuText"), "t03_kelaslist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(4, "mi_t04_siswa", $Language->MenuPhrase("4", "MenuText"), "t04_siswalist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(5, "mi_t05_rutin", $Language->MenuPhrase("5", "MenuText"), "t05_rutinlist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(8, "mi_t99_audittrail", $Language->MenuPhrase("8", "MenuText"), "t99_audittraillist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->Render();
?>
<!-- End Main Menu -->
