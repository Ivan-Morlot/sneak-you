<?php
    session_start();
    include '../utils/GlobalUtils.php';
    include 'controllers/ConnectionController.php';

    $globalUtils = new GlobalUtils();
    $connectionController = new ConnectionController($globalUtils);
    $connectionController->createPage();