<?php
get_header();
?>

<main class="page page--blog">
    <section class="blog" id="blog">
        <section class="blog__inner w">
            <header class="blog__categories d-desktop flex">
                <?php
                foreach ( get_categories() as $category ) :
                    ?>
                    <button class="blog__categories__btn">
                        <?php
                            echo $category->name;
                        ?>
                    </button>
                <?php
                endforeach;
                ?>
            </header>
            <h2 class="blog__mobileHeader d-mobile">
                Ostatnie wpisy
            </h2>
            <main class="blog__articles">
                <?php
                $args = array(
                    'post_type' => 'post'
                );

                $post_query = new WP_Query($args);

                if($post_query->have_posts() ) {
                    while($post_query->have_posts() ) {
                        $post_query->the_post();
                        ?>
                        <a class="blog__articles__item" href="<?php the_permalink() ?>">
                        <span class="blog__articles__item__category">
                            Zimno
                        </span>
                            <figure class="blog__articles__imgWrapper">
                                <?php
                                    echo get_the_post_thumbnail();
                                ?>
                            </figure>
                            <h4 class="blog__articles__item__title">
                                <?php echo the_title(); ?>
                            </h4>
                            <p class="blog__articles__item__excerpt">
                                <?php
                                    echo the_excerpt();
                                ?>
                            </p>
                            <button class="blog__articles__item__readMoreBtn">
                                Czytaj dalej
                                <img class="icon" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/long-arrow.svg'; ?>" alt="wiecej" />
                            </button>
                        </a>
                        <?php
                    }
                }
                ?>
            </main>
        </section>
    </section>
</main>

<?php
get_footer();
?>
