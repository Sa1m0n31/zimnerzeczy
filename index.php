<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package storefront
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

            <div class="container">
                <main class="hero">
                    <menu class="mobileMenu d-mobile">
                        <button class="closeMenu" onclick="closeMenu()">
                            <img class="img" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/close.svg'; ?>" alt="zamknij" />
                        </button>

                        <img class="mobileMenu__logo" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/logo-2.png'; ?>" alt="logo" />

                        <ul>
                            <li>
                                <a href="<?php echo home_url(); ?>">
                                    Strona główna
                                </a>
                            </li>
                            <li>
                                <a href="/o-nas">
                                    O nas
                                </a>
                            </li>
                            <li>
                                <a href="/blog">
                                    Blog
                                </a>
                            </li>
                            <li>
                                <a href="/sklep">
                                    Sklep
                                </a>
                            </li>
                        </ul>
                    </menu>

                    <img class="hero__background" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/zimnerzeczy-landing-page.png'; ?>" alt="zimne-rzeczy" />
                    <header class="hero__header flex w">
                        <a class="hero__logoWrapper" href="">
                            <img class="img" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/logo.png'; ?>" alt="logo" />
                        </a>
                        <button class="hero__hamburgerMenu d-mobile" onclick="openMenu()">
                            <img class="img" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/menu.svg'; ?>" alt="menu" />
                        </button>
                        <menu class="hero__menu d-desktop flex">
                            <ul class="hero__menu__list flex">
                                <li>
                                    <a href="<?php echo home_url(); ?>">
                                        Strona główna
                                    </a>
                                </li>
                                <li>
                                    <a href="/blog">
                                        Blog
                                    </a>
                                </li>
                                <li>
                                    <a href="/o-nas">
                                        O nas
                                    </a>
                                </li>
                                <li>
                                    <a href="/sklep" class="menu__shop">
                                        Sklep morsa
                                        <img class="cartIcon invert" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/cart.svg'; ?>" alt="koszyk" />
                                    </a>
                                </li>
                            </ul>
                            <a class="hero__cart" href="<?php echo wc_get_cart_url(); ?>">
                                Twój koszyk (<?php echo WC()->cart->get_cart_contents_count(); ?>)
                            </a>
                        </menu>
                    </header>
                    <main class="hero__main">
                        <h2 class="hero__main__header">
                            Dom miłośników zimna
                        </h2>
                        <h3 class="hero__main__subheader">
                            Praktyczne wskazówki, dzięki którym zahartujesz swojego ducha i ciało
                        </h3>
                        <a class="hero__btn" href="#blog">
                            Idź dalej
                        </a>
                    </main>
                </main>
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
                        <main class="blog__articles">
                            <?php
                            $args = array(
                                'post_type' => 'post'
                            );
                            $i = 0;

                            $post_query = new WP_Query($args);

                            if($post_query->have_posts() ) {
                                while($post_query->have_posts() ) {
                                    $post_query->the_post();
                                    $post_id = get_the_ID();
                                    $category_object = get_the_category($post_id);
                                    $category_name = $category_object[0]->name;
                                    $i++;
                                    if($i <= 9) {
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
                                    else {
                                        ?>
                                        <a class="blog__articles__item hidden" href="<?php the_permalink() ?>">
                            <span class="blog__articles__item__category">
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
                            }
                            ?>
                        </main>

                        <a class="blog__btn" href="/blog">
                            Zobacz wszystkie wpisy
                            <img class="icon" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/long-arrow.svg'; ?>" alt="blog" />
                        </a>
                        <section class="blog__bottom flex">
                            <article class="blog__bottom__article">
                                <h2 class="blog__bottom__article__header">
                                    O nas
                                </h2>
                                <p class="blog__bottom__article__text">
                                    Dwóch przyjaciół. Dwie historie. Dwa podejścia do zimna.
                                    Połączyliśmy swoje siły, by badać i opisywać wpływ zimna na ciało i umysł człowieka.
                                    Stworzyliśmy tego bloga, by dzielić się wiedzą, która ma realny wpływ na pozytywne zmiany, które zachodzą w nas samych i społeczności, którą mamy wokół siebie.
                                    Jeden z nas to specjalista do spraw suplementacji i chemii mózgu. Dietetyk kliniczny, absolwent Functional Medical University FMU. Popularyzator nauki, od lat zajmuje się hobbistycznie endokrynologią i zastosowaniem peptydów w medycynie regeneracyjnej.
                                    Drugi to przedsiębiorca, wieloletni miłośnik zimna i pasjonat zdobywania górskich szczytów w samych szortach. Coach, organizator warsztatów, popularyzator dobrych nawyków w morsowaniu.
                                    Zapraszamy Cię we wspólną podróż po wiedzę i rozwój ducha.
                                </p>
                                <a class="blog__bottom__article__btn" href="/blog">
                                    Przejdź do naszego bloga
                                    <img class="icon" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/long-arrow.svg'; ?>" alt="wiecej" />
                                </a>
                            </article>
                            <figure class="blog__bottom__imgWrapper">
                                <img class="img" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/img2.png'; ?>" alt="blog" />
                            </figure>
                        </section>
                    </section>
                </section>

                <section class="instagram">
                    <h3 class="instagram__header">
                        Wpadnij na naszego Instagrama
                    </h3>
                    <h4 class="instagram__subheader">
                        @zimnerzeczy
                    </h4>
                    <?php
                        echo do_shortcode('[instagram-feed]');
                    ?>
                </section>
            </div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
do_action( 'storefront_sidebar' );
get_footer();
