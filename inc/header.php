<?php require_once './system/function.php';


if ($row->sitedurum != 1) {
    go($site . '/maintenance.php');
    die();
}

?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Shop Sidebar || Hurst</title>
    <meta name="description" content="Hurst – Furniture Store eCommerce HTML Template is a clean and elegant design – suitable for selling flower, cookery, accessories, fashion, high fashion, accessories, digital, kids, watches, jewelries, shoes, kids, furniture, sports….. It has a fully responsive width adjusts automatically to any screen size or resolution.">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
    <!-- Place favicon.ico in the root directory -->

    <!-- Google Font -->
    <link href='https://fonts.googleapis.com/css?family=Lato:400,700,900' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Bree+Serif' rel='stylesheet' type='text/css'>

    <!-- all css here -->
    <!-- bootstrap v5 css -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- animate css -->
    <link rel="stylesheet" href="css/animate.min.css">
    <!-- jquery-ui.min css -->
    <link rel="stylesheet" href="css/jquery-ui.min.css">
    <!-- meanmenu css -->
    <link rel="stylesheet" href="css/meanmenu.min.css">
    <!-- nivo-slider css -->
    <!-- slick css -->
    <link rel="stylesheet" href="css/slick.min.css">
    <!-- lightbox css -->
    <link rel="stylesheet" href="css/lightbox.min.css">
    <!-- material-design-iconic-font css -->
    <link rel="stylesheet" href="css/material-design-iconic-font.css">
    <!-- All common css of theme -->
    <link rel="stylesheet" href="css/default.css">
    <!-- style css -->
    <link rel="stylesheet" href="style.css">
    <!-- shortcode css -->
    <link rel="stylesheet" href="css/shortcode.css">
    <!-- responsive css -->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- modernizr css -->
    <script src="js/vendor/modernizr-3.11.2.min.js"></script>
</head>

<body>