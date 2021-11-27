<?php
function openDeletionModal($title, $message, $href) {
    include_once "../views/common/confirmDeletionView.php";
    if(isset($title) && isset($message)) {
        echo '<script src="../js/confirmDeletion.js"></script>';
        echo '<script>';
        echo 'confirmDeletion("' . $title . '","' . $message . '","' . $href . '");';
        echo '</script>';
    }
}
