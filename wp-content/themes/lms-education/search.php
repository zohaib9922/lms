<?php get_header(); ?>

<div id="content">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-8 mt-5">

        <?php echo '<h1>' . esc_html__('You searched: ', 'lms-education') . get_search_query() . '</h1>'; ?>

        <?php
          if ( have_posts() ) :

            while ( have_posts() ) :

              the_post();
              get_template_part( 'template-parts/content' );

            endwhile;

          else:

            esc_html_e( 'Sorry, no post found on this archive.', 'lms-education' );

          endif;

          get_template_part( 'template-parts/pagination' );
        ?>
      </div>
      <div class="col-lg-4 col-md-4">
        <?php get_sidebar(); ?>
      </div>
    </div>
  </div>
</div>

<?php get_footer(); ?>