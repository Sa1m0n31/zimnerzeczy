<?php
/**
 * Storefront engine room
 *
 * @package storefront
 */

/**
 * Assign the Storefront version to a var
 */
$theme              = wp_get_theme( 'storefront' );
$storefront_version = $theme['Version'];

/**
 * Set the content width based on the theme's design and stylesheet.
 */

if ( ! isset( $content_width ) ) {
	$content_width = 980; /* pixels */
}

$storefront = (object) array(
	'version'    => $storefront_version,

	/**
	 * Initialize all the things.
	 */
	'main'       => require 'inc/class-storefront.php',
	'customizer' => require 'inc/customizer/class-storefront-customizer.php',
);

require 'inc/storefront-functions.php';
require 'inc/storefront-template-hooks.php';
require 'inc/storefront-template-functions.php';
require 'inc/wordpress-shims.php';

if ( class_exists( 'Jetpack' ) ) {
	$storefront->jetpack = require 'inc/jetpack/class-storefront-jetpack.php';
}

if ( storefront_is_woocommerce_activated() ) {
	$storefront->woocommerce            = require 'inc/woocommerce/class-storefront-woocommerce.php';
	$storefront->woocommerce_customizer = require 'inc/woocommerce/class-storefront-woocommerce-customizer.php';

	require 'inc/woocommerce/class-storefront-woocommerce-adjacent-products.php';

	require 'inc/woocommerce/storefront-woocommerce-template-hooks.php';
	require 'inc/woocommerce/storefront-woocommerce-template-functions.php';
	require 'inc/woocommerce/storefront-woocommerce-functions.php';
}

if ( is_admin() ) {
	$storefront->admin = require 'inc/admin/class-storefront-admin.php';

	require 'inc/admin/class-storefront-plugin-install.php';
}

/**
 * NUX
 * Only load if wp version is 4.7.3 or above because of this issue;
 * https://core.trac.wordpress.org/ticket/39610?cversion=1&cnum_hist=2
 */
if ( version_compare( get_bloginfo( 'version' ), '4.7.3', '>=' ) && ( is_admin() || is_customize_preview() ) ) {
	require 'inc/nux/class-storefront-nux-admin.php';
	require 'inc/nux/class-storefront-nux-guided-tour.php';
	require 'inc/nux/class-storefront-nux-starter-content.php';
}

/**
 * Note: Do not add any custom code here. Please use a custom plugin so that your customizations aren't lost during updates.
 * https://github.com/woocommerce/theme-customisations
 */

/* Enqueue scripts */
function jurkiewicz_scripts() {
    wp_enqueue_style( 'css-mobile', get_template_directory_uri() . '/mobile.css', array(), 1.0 );

    wp_enqueue_script( 'main', get_template_directory_uri() . '/assets/js/main.js', array('aos-js'), 1.0, true );

    /* AOS */
    wp_enqueue_script('aos-js', 'https://unpkg.com/aos@2.3.1/dist/aos.js');
    wp_enqueue_style('aos-css', 'https://unpkg.com/aos@2.3.1/dist/aos.css');

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'jurkiewicz_scripts' );

/* Header */
function remove_header_actions() {
    remove_all_actions('storefront_header');
    remove_all_actions('storefront_content_top');
}
add_action('wp_head', 'remove_header_actions');

function jurkiewicz_header() {
    ?>
    <header class="header w flex">
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

        <a class="header__logoWrapper" href="<?php echo home_url(); ?>">
            <img class="img" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/logo-2.png'; ?>" alt="logo" />
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
                    <a href="/sklep">
                        Sklep morsa
                    </a>
                </li>
            </ul>
            <a class="hero__cart" href="<?php echo wc_get_cart_url(); ?>">
                Twój koszyk (<?php echo WC()->cart->get_cart_contents_count(); ?>)
            </a>
    </header>
    <?php
}

add_action('storefront_before_content', 'jurkiewicz_header', 10);


/* Procentowo slider */
function remove_homepage()
{
    //remove_all_actins('storefront_page');
}
add_action('wp_head', 'remove_homepage');

function jurkiewicz_homepage() {
    ?>
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
                        <a href=".">
                            O nas
                        </a>
                    </li>
                    <li>
                        <a href=".">
                            Blog
                        </a>
                    </li>
                    <li>
                        <a href=".">
                            Sklep
                        </a>
                    </li>
                </ul>
            </menu>

            <img class="hero__background" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/zimnerzeczy-landing-page.png'; ?>" alt="zimne-rzeczy" />
            <header class="hero__header flex w">
                <a class="hero__logoWrapper" href="<?php echo home_url(); ?>">
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
                            <a>
                                Blog
                            </a>
                        </li>
                        <li>
                            <a>
                                O nas
                            </a>
                        </li>
                        <li>
                            <a>
                                Sklep morsa
                            </a>
                        </li>
                    </ul>
                    <button class="hero__cart">
                        Twój koszyk (0,00 zł)
                    </button>
                </menu>
            </header>
            <main class="hero__main">
                <h2 class="hero__main__header">
                    BRR!
                </h2>
                <h3 class="hero__main__subheader">
                    "W mrozie jest coś takiego, że wydobywa z ludzi ciepło"
                </h3>
                <h4 class="hero__main__thirdHeader">
                    J. Maarten Trost
                </h4>
                <a class="hero__btn" href="#blog">
                    Idź dalej
                </a>
            </main>
        </main>
        <section class="blog" id="blog">
            <section class="blog__inner w">
                <header class="blog__categories d-desktop flex">
                    <button class="blog__categories__btn">
                        Zimno
                    </button>
                    <button class="blog__categories__btn">
                        Zdrowie
                    </button>
                    <button class="blog__categories__btn">
                        Chemia mózgu
                    </button>
                    <button class="blog__categories__btn">
                        Hormony
                    </button>
                    <button class="blog__categories__btn">
                        Suplementacja
                    </button>
                    <button class="blog__categories__btn">
                        Mindset
                    </button>
                    <button class="blog__categories__btn">
                        Zimne rozmowy
                    </button>
                </header>
                <h2 class="blog__mobileHeader d-mobile">
                    Ostatnie wpisy
                </h2>
                <main class="blog__articles">
                    <a class="blog__articles__item" href="">
                        <span class="blog__articles__item__category">
                            Zimno
                        </span>
                        <figure class="blog__articles__imgWrapper">
                            <img class="img" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/img1.png'; ?>" alt="blog" />
                        </figure>
                        <h4 class="blog__articles__item__title">
                            Pierwsze morsowanie - o czym należy pamiętać?
                        </h4>
                        <p class="blog__articles__item__excerpt">
                            Chcesz zacząć morsować? To świetny wybór! W tym artykule dowiesz się, jak odpowiednio przygotować się do Twojego pierwszego razu.
                        </p>
                        <button class="blog__articles__item__readMoreBtn">
                            Czytaj dalej
                            <img class="icon" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/long-arrow.svg'; ?>" alt="wiecej" />
                        </button>
                    </a>
                </main>
                <a class="blog__btn" href="/blog">
                    Zobacz wszystkie wpisy
                    <img class="icon" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/long-arrow.svg'; ?>" alt="blog" />
                </a>
                <section class="blog__bottom flex">
                    <article class="blog__bottom__article">
                        <h2 class="blog__bottom__article__header">
                            Wiemy dużo o morsowaniu!
                        </h2>
                        <p class="blog__bottom__article__text">
                            Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.
                        </p>
                        <a class="blog__bottom__article__btn">
                            Dowiedz się więcej o nas
                            <img class="icon" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/long-arrow.svg'; ?>" alt="wiecej" />
                        </a>
                    </article>
                    <figure class="blog__bottom__imgWrapper">
                        <img class="img" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/img2.png'; ?>" alt="blog" />
                    </figure>
                </section>
            </section>
        </section>
    </div>
    <?php
}

add_action('storefront_homepage', 'jurkiewicz_homepage', 10);

function jurkiewicz_footer() {
    ?>
    <footer class="footer">
        <section class="footer__main w flex">
            <section class="footer__main__firstCol">
                <a class="footer__main__firstCol__logo" href="">
                    <img class="img" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/logo.png'; ?>" alt="zimne-rzeczy" />
                </a>
                <h4 class="footer__main__header">
                    Blog Zimne rzeczy
                </h4>
            </section>
            <section class="footer__main__cols flex">
                <section class="footer__main__col">
                    <h4 class="footer__main__header">
                        Zimny blog
                    </h4>
                    <ul>
                        <li>
                            <a href="">
                                Zimno
                            </a>
                        </li>
                        <li>
                            <a href="">
                                Chemia mózgu
                            </a>
                        </li>
                        <li>
                            <a href="">
                                Hormony
                            </a>
                        </li>
                        <li>
                            <a href="">
                                Suplementy
                            </a>
                        </li>
                    </ul>
                </section>
                <section class="footer__main__col">
                    <h4 class="footer__main__header">
                        Zimny blog
                    </h4>
                    <ul>
                        <li>
                            <a href="">
                                Zimno
                            </a>
                        </li>
                        <li>
                            <a href="">
                                Chemia mózgu
                            </a>
                        </li>
                        <li>
                            <a href="">
                                Hormony
                            </a>
                        </li>
                        <li>
                            <a href="">
                                Suplementy
                            </a>
                        </li>
                    </ul>
                </section>
                <section class="footer__main__col">
                    <h4 class="footer__main__header">
                        Zimny blog
                    </h4>
                    <ul>
                        <li>
                            <a href="">
                                Zimno
                            </a>
                        </li>
                        <li>
                            <a href="">
                                Chemia mózgu
                            </a>
                        </li>
                        <li>
                            <a href="">
                                Hormony
                            </a>
                        </li>
                        <li>
                            <a href="">
                                Suplementy
                            </a>
                        </li>
                    </ul>
                </section>
                <section class="footer__main__col">
                    <h4 class="footer__main__header">
                        Zimny blog
                    </h4>
                    <ul>
                        <li>
                            <a href="">
                                Zimno
                            </a>
                        </li>
                        <li>
                            <a href="">
                                Chemia mózgu
                            </a>
                        </li>
                        <li>
                            <a href="">
                                Hormony
                            </a>
                        </li>
                        <li>
                            <a href="">
                                Suplementy
                            </a>
                        </li>
                    </ul>
                </section>
                <section class="footer__main__col">
                    <h4 class="footer__main__header">
                        Zimny blog
                    </h4>
                    <ul>
                        <li>
                            <a href="">
                                Zimno
                            </a>
                        </li>
                        <li>
                            <a href="">
                                Chemia mózgu
                            </a>
                        </li>
                        <li>
                            <a href="">
                                Hormony
                            </a>
                        </li>
                        <li>
                            <a href="">
                                Suplementy
                            </a>
                        </li>
                    </ul>
                </section>
            </section>
        </section>
        <aside class="footer__bottom w flex">
            <div class="footer__bottom__socialMedia flex">
                <a href="https://facebook.com/zimnerzeczy" target="_blank">
                    <img class="icon--socialMedia" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/facebook.svg'; ?>" alt="facebook" />
                </a>
                <a href="https://www.instagram.com/zimnerzeczy/" target="_blank">
                    <img class="icon--socialMedia" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/instagram.svg'; ?>" alt="instagram" />
                </a>
            </div>
            <div class="footer__bottom__captions">
                <h6>
                    &copy; 2022 Zimne Rzeczy. Wszystkie prawa zastrzeżone.
                </h6>
                <h6>
                    by <a href="https://skylo.pl">skylo.pl</a>
                </h6>
            </div>
        </aside>
    </footer>
    <?php
}
add_action('storefront_footer', 'jurkiewicz_footer', 14);

function zimnerzeczy_single_post() {
    ?>
            <main class="single flex w">
                <article class="single__article">
                    <figure class="single__imgWrapper">
                        <img class="img" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/big-image.png'; ?>" alt="title" />
                    </figure>
                    <h2 class="single__title">
                        <?php echo the_title(); ?>
                    </h2>
                    <main class="single__content">
                        <?php
                            the_content();
                        ?>
                    </main>
                </article>
                <aside class="single__aside d-desktop">
                    <h4 class="single__aside__header">
                        O autorach
                    </h4>
                    <p class="single__aside__text">
                        Dwóch przyjaciół. Dwie historie. Dwa podejścia do zimna.
                        Połączyliśmy swoje siły, by badać i opisywać wpływ zimna na ciało i umysł człowieka.
                        Stworzyliśmy tego bloga, by dzielić się wiedzą, która ma realny wpływ na pozytywne zmiany, które zachodzą w nas samych i społeczności, którą mamy wokół siebie.
                    </p>
                    <h4 class="single__aside__header">
                        Ostatnie wpisy
                    </h4>
                    <div class="single__aside__text">
                        <?php
                        $args = array(
                            'post_type' => 'post',
                            'per_page' => 4
                        );

                        $post_query = new WP_Query($args);

                        if($post_query->have_posts() ) {
                            while($post_query->have_posts() ) {
                                $post_query->the_post();
                                ?>
                                <a class="blog__articles__item" href="<?php the_permalink() ?>">
                                    <?php echo the_title(); ?>
                                </a>
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <a class="single__aside__btn" href="/blog">
                        Wszystkie wpisy
                        <img class="icon" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/long-arrow.svg'; ?>" alt="blog" />
                    </a>
                    <h4 class="single__aside__header">
                        Obserwuj nas w social media
                    </h4>
                    <div class="footer__bottom__socialMedia flex">
                        <a href="https://facebook.com/zimnerzeczy" target="_blank">
                            <img class="icon--socialMedia" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/facebook.svg'; ?>" alt="facebook" />
                        </a>
                        <a href="https://www.instagram.com/zimnerzeczy/" target="_blank">
                            <img class="icon--socialMedia" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/instagram.svg'; ?>" alt="instagram" />
                        </a>
                    </div>
                </aside>
            </main>
<?php
}

add_action('storefront_single_post', 'zimnerzeczy_single_post', 14);

function zimnerzeczy_after_single_product_summary() {
    ?>
    <section class="instagram">
        <h3 class="instagram__header">
            Wpadnij na naszego Instagrama
        </h3>
        <h4 class="instagram__subheader">
            @nazwa
        </h4>
        <?php
        echo do_shortcode('[instagram-feed]');
        ?>
    </section>
<?php
}

add_action('woocommerce_after_single_product_summary', 'zimnerzeczy_after_single_product_summary');