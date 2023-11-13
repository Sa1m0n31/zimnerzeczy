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
    wp_enqueue_style( 'css-mobile', get_template_directory_uri() . '/mobile.css?n=8', array(), 1.0 );

    wp_enqueue_script( 'main', get_template_directory_uri() . '/assets/js/main.js?n=4', array('aos-js'), 1.0, true );
    wp_enqueue_style( 'wpb-google-fonts', 'https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;900&display=swap', false );

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

            <img class="mobileMenu__logo" src="<?php echo get_field('logo_na_podstronach', 146); ?>" alt="logo" />

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
                    <a href="/moje-konto">
                        Panel klienta
                    </a>
                </li>
                <li>
                    <a href="/sklep">
                        Sklep morsa
                    </a>
                </li>
            </ul>
        </menu>

        <a class="header__logoWrapper" href="<?php echo home_url(); ?>">
            <img class="img" src="https://zimnerzeczy.pl/wp-content/uploads/2022/01/cropped-zimne-final-bez-bold-1.png" alt="logo" />
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
                    <a href="/moje-konto" class="menu__shop">
                        Panel klienta
                    </a>
                </li>
                <li>
                    <a href="/sklep" class="menu__shop">
                        Sklep morsa
                        <img class="cartIcon" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/cart.svg'; ?>" alt="koszyk" />
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


function jurkiewicz_footer() {
    ?>
    <footer class="footer">
        <section class="footer__main w flex">
            <section class="footer__main__firstCol">
                <a class="footer__main__firstCol__logo" href="<?php echo home_url(); ?>">
                    <img class="img" src="<?php echo get_field('logo_w_stopce', 146); ?>" alt="zimne-rzeczy" />
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
                        <?php
                        $cats = get_terms('category', array(
                            'fields' => 'all',
                            'exclude' => '1',
                            'hide_empty' => false,
                        ));
                        foreach ( $cats as $category ) :
                            ?>
                            <li>
                                <a href="<?php echo home_url() . '/blog?kategoria=' . $category->slug; ?>">
                                    <?php
                                        echo $category->name;
                                    ?>
                                </a>
                            </li>
                        <?php
                        endforeach;
                        ?>
                    </ul>
                </section>
                <section class="footer__main__col">
                    <h4 class="footer__main__header">
                        Sklep
                    </h4>
                    <ul>
                        <li>
                            <a href="/sklep">
                                Produkty
                            </a>
                        </li>
                        <li>
                            <a href="/koszyk">
                                Twój koszyk
                            </a>
                        </li>
                    </ul>
                </section>
                <section class="footer__main__col">
                    <h4 class="footer__main__header">
                        Informacje
                    </h4>
                    <ul>
                        <li>
                            <a href="/regulamin">
                                Regulamin
                            </a>
                        </li>
                        <li>
                            <a href="/polityka-prywatnosci">
                                Polityka prywatności
                            </a>
                        </li>
                    </ul>
                </section>
                <section class="footer__main__col footer__main__col--contact">
                    <h4 class="footer__main__header">
                        Obsługa Klienta:
                    </h4>
                    <a href="tel:+48<?php echo str_replace(' ',  '', get_field('numer_telefonu', 146)); ?>">
                        <img class="icon" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/phone.svg'; ?>" alt="telefon" />
                        <?php echo get_field('numer_telefonu', 146); ?>
                    </a>
                    <h4 class="footer__main__header">
                        Mail kontaktowy:
                    </h4>
                    <a href="mailto:<?php echo get_field('adres_email', 146); ?>">
                        <img class="icon" src="<?php echo get_bloginfo('stylesheet_directory') . '/img/mail.svg'; ?>" alt="telefon" />
                        <?php echo get_field('adres_email', 146); ?>
                    </a>
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
            <figure class="single__imgWrapper">
                <img class="img" src="<?php echo get_field('zdjecie_wpisu'); ?>" alt="title" />
                <h2 class="single__title">
                    <?php echo the_title(); ?>
                </h2>
            </figure>
            <main class="single flex w">
                <article class="single__article">
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
                        <?php echo get_field('o_autorach', 146); ?>
                    </p>
                    <h4 class="single__aside__header">
                        Ostatnie wpisy
                    </h4>
                    <div class="single__aside__text">
                        <?php
                        $args = array(
                            'post_type' => 'post',
                            'posts_per_page' => 4
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
    <section class="single__blogSection w flex">
        <h3 class="single__blogSection__header">
            Przeczytaj również
        </h3>
        <main class="blog__articles">
            <?php
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => 3
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
<?php
}

add_action('storefront_single_post', 'zimnerzeczy_single_post', 14);

function zimnerzeczy_after_single_product_summary() {
    global $product;

    $first_img = get_field('co_wyroznia_nasz_produkt_-_zdjecie_1');
    $second_img = get_field('co_wyroznia_nasz_produkt_-_zdjecie_2');
    $third_img = get_field('co_wyroznia_nasz_produkt_-_zdjecie_3');
    $fourth_img = get_field('co_wyroznia_nasz_produkt_-_zdjecie_4');
    $images = array($first_img, $second_img, $third_img, $fourth_img);

    $header1 = get_field('co_wyroznia_nasz_produkt_-_naglowek_1');
    $header2 = get_field('co_wyroznia_nasz_produkt_-_naglowek_2');
    $header3 = get_field('co_wyroznia_nasz_produkt_-_naglowek_3');
    $header4 = get_field('co_wyroznia_nasz_produkt_-_naglowek_4');
    $headers = array($header1, $header2, $header3, $header4);

    $text1 = get_field('co_wyroznia_nasz_produkt_-_tekst_pod_naglowkiem_1');
    $text2 = get_field('co_wyroznia_nasz_produkt_-_tekst_pod_naglowkiem_2');
    $text3 = get_field('co_wyroznia_nasz_produkt_-_tekst_pod_naglowkiem_3');
    $text4 = get_field('co_wyroznia_nasz_produkt_-_tekst_pod_naglowkiem_4');
    $texts = array($text1, $text2, $text3, $text4);

    $i = 0;

    if($header1 || $header2 || $header3 || $header4) {
        ?>
        <div class="product__icons">
        <h3 class="product__icons__mainHeader">
            Co wyróżnia nasz produkt?
        </h3>
        <div class="product__icons__inner">
            <?php

            foreach($images as $img) {
                if($img) {
                    ?>

                    <div class="product__icons__section">
                        <figure>
                            <img class="img" src="<?php echo $img; ?>" alt="icon" />
                        </figure>
                        <h4 class="product__icons__header">
                            <?php
                            echo $headers[$i];
                            ?>
                        </h4>
                        <p class="product__icons__text">
                            <?php
                            echo $texts[$i];
                            ?>
                        </p>
                    </div>

                    <?php
                }
                $i++;
            }
            ?>
        </div>
        <?php
    }
    ?>

    </div>

    <div class="productDescription">
        <h3 class="productDescription__header">
            Opis produktu
        </h3>
        <?php
        echo the_content();
        ?>
    </div>

    <?php
    if(get_field( 'informacja_zywieniowa' )) {
        ?>

        <div class="productDescription">
            <h3 class="productDescription__header productDescription__header--marginTop">
                <?php
                echo __( 'Informacja żywieniowa', 'my-plugin-domain' );
                ?>
            </h3>
            <?php
            $table = get_field( 'informacja_zywieniowa' );

            if ( ! empty ( $table ) ) {

                echo '<table border="0">';

                if ( ! empty( $table['caption'] ) ) {

                    echo '<caption>' . $table['caption'] . '</caption>';
                }

                if ( ! empty( $table['header'] ) ) {

                    echo '<thead>';

                    echo '<tr>';

                    foreach ( $table['header'] as $th ) {

                        echo '<th>';
                        echo $th['c'];
                        echo '</th>';
                    }

                    echo '</tr>';

                    echo '</thead>';
                }

                echo '<tbody>';

                foreach ( $table['body'] as $tr ) {

                    echo '<tr>';

                    foreach ( $tr as $td ) {

                        echo '<td>';
                        echo $td['c'];
                        echo '</td>';
                    }

                    echo '</tr>';
                }

                echo '</tbody>';

                echo '</table>';
            }
            ?>
        </div>
        <?php
    }

    ?>
        <section class="single__blogSection flex">
            <h3 class="single__blogSection__header">
                Zajrzyj na Zimnego Bloga!
            </h3>
            <main class="blog__articles">
                <?php
                $args = array(
                    'post_type' => 'post',
                    'posts_per_page' => 3
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
<?php
}

add_action('woocommerce_after_single_product_summary', 'zimnerzeczy_after_single_product_summary');

function metahuman_product_meta_start() {

    global $product;

    if(get_field('cechy_produktu')) {

        ?>

        <div class="productDescription">
            <h3 class="productDescription__header productDescription__header--small">
                <?php
                echo __( 'Cechy produktu', 'my-plugin-domain' );
                ?>
            </h3>
            <?php
            $points = explode("-", get_field('cechy_produktu'));

            foreach($points as $point) {
                if($point != "") {
                    ?>
                    <p class="productDescription__point">
                        <img class="img" src="https://metahuman.pl/wp-content/uploads/2022/05/check-mark.svg" alt="cecha" />
                        <?php
                        echo $point;
                        ?>
                    </p>

                    <?php
                }
            }
            ?>
        </div>

        <?php
    }
}

add_action('woocommerce_product_meta_start', 'metahuman_product_meta_start');