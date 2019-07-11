<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo $title; ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex, nofollow"> <!-- control panel should not be indexed by search engines -->
  <link href="<?php echo base_url; ?>assets/web-fonts-with-css/css/fontawesome-all.css" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo base_url; ?>assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url; ?>assets/custom.css">
</head>
<body class="<?php echo $page; ?>" id="body">
<?php
    define('PAGE', $page);
    function is_active($current_page)
    {
        if($current_page == PAGE){
           echo "active";
        }
    }
?>
<div id="top_nav" class="nav" >
    <ul>
        <li class="menu_btn" onclick="open_menu()"><i class="fa fa-bars"></i></li>
        <li class="site_title">ADMIN C-PANNEL &nbsp;&nbsp;&nbsp;</li>
        <li class="logout_btn"><a class="btn btn-outline-secondary btn-sm" href="<?php echo base_url; ?>index.php/users/logout">Logout</a></li>
    </ul>
</div>
<div id="side_nav" class="nav">
        <ul>
            <li class ="primary_nav"><i class="fa fa-desktop"></i><a href="#">Dashboard</a></li><hr>
            <li class ="primary_nav"><i class="fa fa-user"></i><a href="<?php echo base_url; ?>index.php/users/view_user">Users</a><i class="fa side_drop fa-caret-down"></i></li>
                <ul class="secondary_nav">
                    <li class ="<?php is_active('account');?>"><a href="<?php echo base_url; ?>index.php/users/view_user">Your Account</a></li>
                    <?php
                    if($this->session->role == "Administrator")
                    { ?>
                    <li class ="<?php is_active('new_user');?>"><a href="<?php echo base_url; ?>index.php/users/new_user">New User</a></li>
                    <li class ="<?php is_active('all_users');?>"><a href="<?php echo base_url; ?>index.php/users/view_all_users">All Users</a></li>
                    <?php } ?>
                </ul>
            <hr>
            <li class ="primary_nav"><i class="fa fa-image"></i><a href="<?php echo base_url; ?>index.php/media/">Media</a><i class="fa side_drop fa-caret-down"></i></li>
                <ul class="secondary_nav">
                    <li class ="<?php is_active('all_media');?>"><a href="<?php echo base_url; ?>index.php/media/">All Media</a></li>
                    <li class ="<?php is_active('add_new');?>"><a href="<?php echo base_url; ?>index.php/media/add_new">Add New</a></li>
                </ul>
            <hr>
            <li class ="primary_nav"><i class="fa fa-rss"></i><a href="<?php echo base_url; ?>index.php/blog/">Blog</a><i class="fa side_drop fa-caret-down"></i></li>
                <ul class="secondary_nav">
                    <li class ="<?php is_active('all_posts');?>"><a href="<?php echo base_url; ?>index.php/blog/">All Posts</a></li>
                    <li class ="<?php is_active('new_post');?>"><a href="<?php echo base_url; ?>index.php/blog/new_post">Post</a></li>
                    <li class ="<?php is_active('category');?>"><a href="<?php echo base_url; ?>index.php/blog/category">Categories</a></li>
                </ul>
            <hr>
            <li class ="primary_nav"><i class="fa fa-shopping-cart"></i><a href="<?php echo base_url; ?>index.php/store/">Store</a><i class="fa side_drop fa-caret-down"></i></li>
                <ul class="secondary_nav">
                <li class ="<?php is_active('orders');?>"><a href="#">Orders</a></li>
                    <li class ="<?php is_active('all_products');?>"><a href="<?php echo base_url; ?>index.php/store/view_products">Products</a></li>
                    <li class ="<?php is_active('add_product');?>"><a href="<?php echo base_url; ?>index.php/store/add_product">Add Product</a></li>
                    <li class ="<?php is_active('product_category');?>"><a href="<?php echo base_url; ?>index.php/store/category">Product Categories</a></li>
                </ul>
            <hr>
        </ul>
</div>
<div class="<?php echo $page;?>-module module" id="module">
    <div class="container">
