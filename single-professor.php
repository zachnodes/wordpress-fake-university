<?php 
    get_header();
    while(have_posts()) {
        the_post(); 
        pageBanner();
        ?>
        
    
    <div class="container container--narrow page-section">
        <div class="generic-content">
            <div class="row group">
                <div class="one-third">
                    <?php the_post_thumbnail('professorPortrait'); ?>
                </div>
                <div class="two-thirds">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
            <?php 
              $relatedProgams = get_field('related_programs');
              if ($relatedProgams) {
                echo '<hr class="section-break">';
                echo '<h2 class="headline headline--medium">Subject(s) Taught</h2>';
                echo '<ul class="link-list min-list">';
                foreach($relatedProgams as $item) { ?>

                  <li><a href="<?php echo get_the_permalink($item); ?>"><?php echo get_the_title($item); ?></a></li>
  
                <?php }
                echo '</ul>';
              }
              ?>

    </div>

    <?php }
    get_footer();
?>