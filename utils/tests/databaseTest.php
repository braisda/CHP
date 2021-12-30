<?php

function initTestDB() {
    shell_exec('mysql -u root -ppdp < database.sql');
}

function restoreDB() {
    shell_exec('mysql -u root -ppdp < dump.sql');
}

?>