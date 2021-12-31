<?php

function initTestDB() {
    shell_exec('mysql -uroot -ppdp < /var/www/html/CHP/utils/tests/dump.sql');
}

function restoreDB() {
    shell_exec('mysql -uroot -ppdp < /var/www/html/CHP/utils/tests/dump.sql');
}

?>