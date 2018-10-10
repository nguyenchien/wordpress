<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <div id="container" class="container">
            <div id="header" class="area">
                <div class="wrapper flex-box">
                    <div class="site-info">
                        <div class='site-name'>
                            <h1><a href="<?php echo home_url(); ?>" title="<?php echo get_bloginfo('description'); ?>"><?php echo get_bloginfo('sitename'); ?></a></h1>
                        </div>
                        <h2 class='site-description'><?php echo get_bloginfo('description'); ?></h2>
                    </div>
                    <div class="languages">
                        <?php echo qtranxf_generateLanguageSelectCode("both"); ?>
                    </div>
                </div>
            </div>
            <div class="main-menu">
                <div class="wrapper flex-box">
                    <?php
                        wp_nav_menu(array(
                            'theme_location' => 'primary',
                            'menu'=> 'TopMenu',
                            'menu_class' => 'list-menu-top flex-box',
                            'container_id' => 'ListMenuTop',
                        ));
                    ?>
                    <div class="search-form">
                        <?php echo get_search_form(); ?>
                    </div>
                </div>
            </div>