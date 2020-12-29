<?php get_header(); ?>

<?php

$author_name = get_post_meta( $post->ID, 'review_author', true );
$author_location = get_post_meta( $post->ID, 'review_author_location', true );
$review_date = get_post_meta( $post->ID, 'review_date', true );
$review_rating = get_post_meta( $post->ID, 'review_rating', true );
$review_source = get_post_meta( $post->ID, 'review_source', true );

?>

<?php genius_theme_featured_small_squares(); ?>


    <article id="<?= $post->ID ?>" <?php post_class( 'post section-content' ); ?>>

        <div class="reviews content-holder">
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>



                <h1 class="review_title"><?= get_the_title(); ?></h1>
                <h4 class="review_details">
                    <span class="author_name"> <?= $author_name ?>  </span>
                    <span class="author_location"> <?= $author_location ?>  </span>

                </h4>
                <p class="review_date"> <?= $review_date ?> </p>


                <?= get_the_content(); ?>

                <div class="review_image_src">
                    <img src="<?= get_stylesheet_directory_uri().'/images/'.$review_source. '.png' ?>"  />
                    <span class="review_rating"> <?= $review_rating ?>  </span>
                </div>


<!--                <span class="review_source"> --><?//= $review_source ?><!--  </span>-->

                <hr class="reviews_hr">

            <?php endwhile; endif; wp_reset_query(); ?>


            <?php

            $args = array(
                'post_type' => 'our-reviews',
                'orderby' => 'rand',
                'posts_per_page' => '6',
                'post__not_in' => array( $post->ID )
            );
            $query = new WP_Query( $args );


            ?>


            <div class="view_also">
                <h4 class="other_reviews_title">Other Reviews</h4>

                <?php

                if ( $query->have_posts() ) {
                    echo '<ul class="other_reviews">';
                    while ( $query->have_posts() ) {
                        $query->the_post();
                        $author_name = get_post_meta( $post->ID, 'review_author', true );
                        $author_location = get_post_meta( $post->ID, 'review_author_location', true );
                        $review_date = get_post_meta( $post->ID, 'review_date', true );
                        $review_rating = get_post_meta( $post->ID, 'review_rating', true );
                        $review_source = get_post_meta( $post->ID, 'review_source', true );

                        echo '<li>';
                        echo '<a href="'.get_post_permalink().'">';
                        echo '<p class="other_review_title">'.get_the_title().'</p>';
                        echo '</a>';
                        echo '<p class="other_review_meta">';
                        echo '<span>'.$author_name.'<span>, ';
                        echo '<span>'.$author_location.'<span>, ';
                        echo '<span>'.$review_date.'<span>';
                        echo '</p>';
                        echo '<p class="other_review_src">';
                        echo '<img src="'.get_stylesheet_directory_uri().'/images/'.$review_source. '.png" width="70"  />';
                        echo '</p>';
                        echo '</li>';
                    }
                    echo '</ul>';
                    /* Restore original Post Data */
                    wp_reset_postdata();
                }


                ?>




            </div>

    </div>

    </article>







<?php get_footer(); ?>
