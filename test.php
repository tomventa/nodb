<?php
require_once("modules/configuration.php");
require_once("modules/storage.php");
require_once("modules/math.php");

/* Functions Requires */
require_once("modules/language.php");

/* Script */
print_r(storage::read_small_file("README.md", true));
?>