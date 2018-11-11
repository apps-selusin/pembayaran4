<!-- Begin Main Menu -->
<?php $RootMenu = new cMenu(EW_MENUBAR_ID) ?>
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(2, "mi_cf01_home_php", $Language->MenuPhrase("2", "MenuText"), "cf01_home.php", -1, "", TRUE, FALSE, TRUE);
$RootMenu->AddMenuItem(1, "mi_t01_tahunajaran", $Language->MenuPhrase("1", "MenuText"), "t01_tahunajaranlist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->Render();
?>
<!-- End Main Menu -->
