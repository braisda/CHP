<?php
function IsAuthenticated()
{
    if (!isset($_SESSION['token'])) {
        return false;
    } else {
        return true;
    }
}