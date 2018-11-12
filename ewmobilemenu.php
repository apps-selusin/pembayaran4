<!-- Begin Main Menu -->
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(1, "mmi_t01_tahunajaran", $Language->MenuPhrase("1", "MenuText"), "t01_tahunajaranlist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(2, "mmi_t02_sekolah", $Language->MenuPhrase("2", "MenuText"), "t02_sekolahlist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(3, "mmi_t03_kelas", $Language->MenuPhrase("3", "MenuText"), "t03_kelaslist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(4, "mmi_t04_siswa", $Language->MenuPhrase("4", "MenuText"), "t04_siswalist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(5, "mmi_t05_rutin", $Language->MenuPhrase("5", "MenuText"), "t05_rutinlist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(8, "mmi_t99_audittrail", $Language->MenuPhrase("8", "MenuText"), "t99_audittraillist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->Render();
?>
<!-- End Main Menu -->
