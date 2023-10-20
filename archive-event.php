<?php 
    get_header(); 
    pageBanner(array(
        'title' => 'All Events',
        'subtitle' => 'See whats crackin nig'
    ));
    ?>

    <div class="container container--narrow page-section">
        <?php 
            while(have_posts()) {
                the_post(); 
                get_template_part('template-parts/content-event');
             }
            echo paginate_links();
        ?>

        <hr class="section-break">

        <p><a href="<?php echo site_url('/past-events') ?>">Past events</a></p>
    </div>


    <?php get_footer();

?>