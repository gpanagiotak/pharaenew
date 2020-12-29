<?php

/**
*
* Template Name: Reviews
*
**/

get_header();

?>


<?php genius_theme_featured_square(); ?>

<?php

$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

$args = array(
    'post_type' => 'our-reviews',
//    'orderby' => 'rand',
    'posts_per_page' => '8',
    'paged'          => $paged
);
$query = new WP_Query( $args );


?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post section-content' ); ?>>


    <div class="content-holder">

        <h2 class="page-title"><span><?= get_the_title(); ?></span></h2>

        <?php
        if ( $query->have_posts() ) {
            echo '<ul class="all_reviews">';
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

        <?php
        echo get_the_posts_pagination( array(
            'prev_text' => __( 'Newer', 'textdomain' ),
            'next_text' => __( 'Older', 'textdomain' ),
        ) );
        ?>


        <?php if( get_previous_posts_link() ) :

            previous_posts_link( '« Newer Entries' );

        endif; ?>

        <?php if( get_next_posts_link() ) :

            next_posts_link( 'Older Entries »' );

        endif; ?>





    </div>
</article>

<?php get_footer(); ?>