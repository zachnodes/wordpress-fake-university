<?php

    function pageBanner($args = null) {
        if (!isset($args['title'])) {
            $args['title'] = get_the_title();
        }
        if (!isset($args['subtitle'])) {
            $args['subtitle'] = get_field('page_banner_subtitle');
        } 
        if (!isset($args['photo'])) {
            if (get_field('page_banner_background_image')) {
                $args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
            } else {
                $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
            }
        }

        // if (!$args) {
        //     $args['title'] = get_the_title();
        //     $args['subtitle'] = get_field('page_banner_subtitle');
        //     if (get_field('page_banner_background_image')) {
        //         $args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
        //     } else {
        //         $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
        //     }
        // }
        ?>

        <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo']; ?>)"></div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"><?php echo $args['title'] ?></h1>
            <div class="page-banner__intro">
            <p><?php echo $args['subtitle'] ?></p>
            </div>
        </div>
        </div>

    <?php }

    // This is to load styles + scriptss
    function university_files() {
        wp_enqueue_script('main-university-js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);
        wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css'));
        wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/index.css'));
        wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
        wp_enqueue_style('google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    }

    add_action('wp_enqueue_scripts', 'university_files');
    

    
    function university_features() {
        // Allows the user to create a dynamic navigation menu from admin dashboard in header.php instead of static html
        register_nav_menu('headerMenuLocaton', 'Header Menu Location');
        
        add_theme_support('title-tag');
        
        // Adds support for featured images (Must also modify the specific post type's array 'supports' element to include thumbnails in mu-plugins)
        add_theme_support('post-thumbnails');

        add_image_size('professorLandscape', 400, 260, true);
        add_image_size('professorPortrait', 480, 650, true);
        add_image_size('pageBanner', 1500, 350, true);
    }
    add_action('after_setup_theme', 'university_features');


    // This is to manupulate URL queries of the 'event' post type NOT custom queries
    // is_admin() checks if the current page/request is within the admin dashboard
    // is_post_type_archive('event') checks if the current page being displayed is an archive page for the 'event' post type
    // $query->is_main_query() checks if the query being sent to the database is a main query (URL based), or a custom one (new WP_query)
    function university_adjust_queries($query) {
        if (!is_admin() && is_post_type_archive('program') && $query->is_main_query()) {
            $query->set('posts_per_page', -1);
            $query->set('orderby', 'title');
            $query->set('order', 'ASC');
        }

        if (!is_admin() && is_post_type_archive('event') && $query->is_main_query()) {
            $query->set('posts_per_page', -1);
            $query->set('meta_key', 'event_date');
            $query->set('orderby', 'meta_value_num');
            $query->set('order', 'ASC');
            $query->set('meta_query', array(
                array(
                    'key' => 'event_date',
                    'compare' => '>=',
                    'value' => date('Ymd'),
                    'type' => 'numeric'
                )
            ));
        }


    }

    add_action('pre_get_posts', 'university_adjust_queries');


