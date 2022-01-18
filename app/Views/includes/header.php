<!DOCTYPE html>
<html class="no-js" lang="en">
<head>

    <!--- basic page needs
    ================================================== -->
    <meta charset="utf-8">
    <title>Post Engine</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- mobile specific metas
    ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- CSS
    ================================================== -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/css/base.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/css/vendor.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/css/main.css">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    
    <!-- script
    ================================================== -->
    <script src="<?php echo base_url(); ?>/public/assets/js/modernizr.js"></script>

    <!-- favicons
    ================================================== -->
    <link rel="shortcut icon" href="<?php echo base_url(); ?>/public/assets/images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?php echo base_url(); ?>/public/assets/images/favicon.ico" type="image/x-icon">

</head>

<body id="top">

    <!-- preloader
    ================================================== -->
    <div id="preloader">
        <div id="loader" class="dots-fade">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>


    <!-- header
    ================================================== -->
    <header class="s-header header">

        <div class="header__logo">
            <a class="logo" href="<?php echo base_url(); ?>">
                <img src="<?php echo base_url(); ?>/public/assets/images/logo.svg" alt="Homepage">
            </a>
        </div> <!-- end header__logo -->

        <a class="header__search-trigger" href="#0"></a>
        <div class="header__search">

            <form role="search" method="get" class="header__search-form" action="<?php echo base_url()."/index.php/dashboard/search";?>">
                <label>
                    <span class="hide-content">Search for:</span>
                    <input type="search" class="search-field" placeholder="Type Keywords" value="" name="s" title="Search for:" autocomplete="off">
                    <input type="hidden" value="1" name="page">
                </label>
                <input type="submit" class="search-submit" value="Search">
            </form>

            <a href="" title="Close Search" class="header__overlay-close">Close</a>

        </div>  <!-- end header__search -->

        <a class="header__toggle-menu" href="#0" title="Menu"><span>Menu</span></a>
        <nav class="header__nav-wrap">

            <h2 class="header__nav-heading h6">Navigate to</h2>

            <ul class="header__nav">
                <li class="current"><a href="<?php echo base_url(); ?>" title="">Home</a></li>
                <li class="has-children">
                    <a href="#0" title="">Categories</a>
                    <ul class="sub-menu">
                   
                    <?php 
                        $db = \Config\Database::connect();
                        $query = $db->query('select * from CATEGORIES');
                        $result = $query->getResult();

                        foreach($result as $r){
                            echo '<li><a href="'.base_url().'/index.php/dashboard/category/'.$r->idcat.'">'.$r->namec.'</a></li>';
                        }
                    ?>

                    </ul>
                </li>
                <li>
                    <?php
                        if(isset($_SESSION['user'])){
                            echo "<a href='".base_url()."/index.php/dashboard/uploadPost'>New Blog</a>";
                        }else{ 
                            echo "<a href='".base_url()."/index.php/dashboard/login'>New Blog</a>";
                        } ?> 
                    </li>
                    <!-- <ul class="sub-menu">
                       
                    </ul> -->
                    <li>
                    <?php
                        if(isset($_SESSION['user'])){
                            echo "<a href='".base_url()."/index.php/dashboard/logout'>".$_SESSION['user']['username']."</a>";
                        }else{ 
                            echo "<a href='".base_url()."/index.php/dashboard/login'>Login</a>";
                        } ?>
                    </li>
                    <li>
                    <?php
                        if(!isset($_SESSION['user'])){
                            echo "<a href='".base_url()."/index.php/dashboard/register'>Register</a>";
                        } ?>
                    </li> 
            </ul> <!-- end header__nav -->

            <a href="#0" title="Close Menu" class="header__overlay-close close-mobile-menu">Close</a>

        </nav> <!-- end header__nav-wrap -->

    </header> <!-- s-header -->
