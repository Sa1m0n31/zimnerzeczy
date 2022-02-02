<?php
get_header();
?>

<main class="page page--blog">
    <section class="blog" id="blog">
        <section class="blog__inner w">
            <header class="blog__categories d-desktop flex">
                <button class="blog__categories__btn" onclick="filterCategories()" id="all">
                    Wszystkie kategorie
                </button>
                <?php
                foreach ( get_categories() as $category ) :
                    ?>
                    <button class="blog__categories__btn" id="<?php echo $category->name; ?>">
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
            <h3 class="notFound">
                Nic nie znaleziono
            </h3>
            <main class="blog__articles blog__articles--blog">
                <?php
                $args = array(
                    'post_type' => 'post'
                );

                $post_query = new WP_Query($args);

                if($post_query->have_posts() ) {
                    while($post_query->have_posts() ) {
                        $post_query->the_post();
                        $post_id = get_the_ID();
                        $category_object = get_the_category($post_id);
                        $category_name = $category_object[0]->name;
                        ?>
                        <a class="blog__articles__item" href="<?php the_permalink() ?>">
                            <span class="blog__articles__item__category" id="<?php
                                foreach($category_object as $cat) {
                                    echo $cat->name . ';';
                                }
                            ?>">
                                <?php echo $category_name; ?>
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
