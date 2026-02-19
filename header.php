<?php
/**
 * Theme Header Template
 *
 * @package    Flavor_Flavor
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a href="#main" class="sr-skip bg-pop-yellow hard-outline-2 shadow-hard-sm px-4 py-2 font-mono font-bold">
    <?php esc_html_e( 'Skip to main content', 'flavor-flavor' ); ?>
</a>

<div class="w-full max-w-[1400px] bg-white border-4 border-pop-black shadow-hard-xl relative flex flex-col">

    <header class="hard-divider p-4 md:p-6 flex flex-col md:flex-row gap-6 justify-between items-center bg-white sticky top-0 z-40">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>"
           class="group relative inline-block transform -rotate-1 hover:rotate-0 transition-transform"
           aria-label="<?php bloginfo( 'name' ); ?>">
            <div class="absolute inset-0 bg-pop-black translate-x-1 translate-y-1 group-hover:translate-x-2 group-hover:translate-y-2 transition-transform"></div>

            <div class="relative bg-pop-yellow border-2 border-pop-black px-4 py-2 flex items-center gap-3">
                <?php if ( has_custom_logo() ) : ?>
                    <?php
                    $logo_id  = get_theme_mod( 'custom_logo' );
                    $logo_url = wp_get_attachment_image_url( $logo_id, 'full' );
                    ?>
                    <img src="<?php echo esc_url( $logo_url ); ?>" alt=""
                         class="w-10 h-10 rounded-full object-cover">
                <?php else : ?>
                    <span class="w-10 h-10 bg-black text-white rounded-full flex items-center justify-center font-black text-xl">
                        <?php echo esc_html( mb_substr( get_bloginfo( 'name' ), 0, 1 ) ); ?>
                    </span>
                <?php endif; ?>

                <span class="font-sans font-black text-2xl uppercase tracking-tighter italic">
                    <?php bloginfo( 'name' ); ?>
                </span>

                <span class="hidden sm:inline badge bg-pop-pink">
                    <?php esc_html_e( 'Blog', 'flavor-flavor' ); ?>
                </span>
            </div>
        </a>

        <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>"
              class="hidden md:flex items-center flex-1 max-w-xl mx-4">
            <label for="header-search" class="sr-only"><?php esc_html_e( 'Search', 'flavor-flavor' ); ?></label>
            <div class="flex w-full border-2 border-pop-black shadow-hard-sm">
                <input id="header-search" type="search" name="s"
                       placeholder="<?php esc_attr_e( 'Search posts…', 'flavor-flavor' ); ?>"
                       value=""
                       class="w-full h-10 px-3 bg-white font-mono text-sm focus:outline-none focus:ring-2 focus:ring-pop-cyan placeholder:text-gray-400" />
                <button type="submit"
                        class="h-10 w-10 flex-shrink-0 bg-pop-black text-white flex items-center justify-center hover:bg-pop-cyan hover:text-black transition-colors"
                        aria-label="<?php esc_attr_e( 'Search', 'flavor-flavor' ); ?>">
                    <span class="fa-solid fa-magnifying-glass"></span>
                </button>
            </div>
        </form>

    </header>

    <main id="main" class="p-6 md:p-8 bg-paper flex-grow">
