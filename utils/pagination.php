<?php

function getPage()
{
    if (!empty($_REQUEST['page'])) {
        $page = $_REQUEST['page'];
    } else {
        $page = 1;
    }
    return $page;
}

function getNumberItems() {
    if (!empty($_REQUEST['pageItems'])) {
        $pageItems = $_REQUEST['pageItems'];
    } else {
        $pageItems = 10;
    }
    return $pageItems;
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