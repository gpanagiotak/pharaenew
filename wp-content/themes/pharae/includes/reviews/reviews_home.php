<?php


//$today = date('m-d-Y');


$time = strtotime("-2 years", time());
$date = date("Y-m-d", $time);


$args = array(
    'post_type' => 'our-reviews',
    'orderby' => 'rand',

    'meta_query' => array(
        array(
            'key'        => 'review_date',
            'value'      => $date,
            'compare'    => '>='
        )
    ),

    'posts_per_page' => 3,
);
$query = new WP_Query( $args );


?>



<?php
if ( $query->have_posts() ) {
    echo '<ul class="home_reviews clearfix">';
    while ( $query->have_posts() ) {
        $query->the_post();
        $author_name = get_post_meta( $post->ID, 'review_author', true );
        $author_location = get_post_meta( $post->ID, 'review_author_location', true );
        $review_date = get_post_meta( $post->ID, 'review_date', true );
        $review_rating = get_post_meta( $post->ID, 'review_rating', true );
        $review_source = get_post_meta( $post->ID, 'review_source', true );

        echo '<li>';
        echo '<a href="'.get_post_permalink().'">';
        echo get_the_title();
        echo '</a>';
        echo '<p class="excerpt">'.wp_trim_words(get_the_content(), 10).'</p>';
        echo '<p class="home_other_review_meta">';
        echo '<span>'.$author_name.'<span>, ';
        echo '<span>'.$author_location.'<span>, ';
        echo '<span>'.$review_date.'<span>';
        echo '</p>';
        echo '<p class="home_review_src">';
        echo '<img src="'.get_stylesheet_directory_uri().'/images/'.$review_source. '.png" width="80"  />';
        echo '</p>';
        echo '</li>';
    }
    echo '</ul>';
    /* Restore original Post Data */
    wp_reset_postdata();

    $reviews_page = 'reviews-'.pll_current_language();
    $submit_review_page = 'submit-review-'.pll_current_language();

    echo '<div class="reviews_all"><a href="'.get_site_url(null, $reviews_page).'" class="button"> ';
    pll_e( 'View all Reviews' );
    echo ' </a></div>';

    echo '<div class="new_review_btn"><a href="'.get_site_url(null, $submit_review_page).'" class="button new_review"> ';
    pll_e( 'Submit your Review' );
    echo ' </a></div>';
}
?>