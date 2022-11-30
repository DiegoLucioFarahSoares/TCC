<?php

session_start();

if($_SESSION['loggeSic'] !== true) {
    header("Location: /");
    exit;
}