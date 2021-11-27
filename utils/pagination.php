<?php

function getPage()
{
    if (!empty($_REQUEST['currentPage'])) {
        $currentPage = $_REQUEST['currentPage'];
    } else {
        $currentPage = 1;
    }
    return $currentPage;
}

function getNumberItems() {
    if (!empty($_REQUEST['itemsPerPage'])) {
        $itemsPerPage = $_REQUEST['itemsPerPage'];
    } else {
        $itemsPerPage = 10;
    }
    return $itemsPerPage;
}

function getToSearch($search)
{
    $searchRequested = $_REQUEST['search'];
    if (!empty($searchRequested)) {
        $toSearch = $searchRequested;
    } elseif (!is_null($search)) {
        $toSearch = $search;
    } else {
        $toSearch = NULL;
    }
    return $toSearch;
}