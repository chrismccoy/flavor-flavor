<?php
/**
 * 404 Not Found Template
 *
 * @package    Flavor_Flavor
 */

get_header();
?>

<section id="error-404" class="mb-10">
    <div class="flex flex-col items-center justify-center min-h-[50vh]">
        <div class="relative">
            <div class="absolute inset-0 bg-pop-black translate-x-2 translate-y-2" aria-hidden="true"></div>

            <div class="relative accordion overflow-hidden p-8 md:p-12 text-center max-w-2xl">
                <div class="badge bg-pop-pink mb-6">
                    <span class="fa-solid fa-triangle-exclamation" aria-hidden="true"></span>
                    <?php esc_html_e( '404', 'flavor-flavor' ); ?>
                </div>

                <h1 class="font-sans font-black text-5xl md:text-7xl uppercase tracking-tighter leading-none">
                    <?php esc_html_e( 'Page not found', 'flavor-flavor' ); ?>
                </h1>

                <p class="mt-4 text-gray-700 text-sm md:text-base">
                    <?php esc_html_e( 'The page you are looking for does not exist or has been moved.', 'flavor-flavor' ); ?>
                </p>

                <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>"
                       class="btn-physics inline-flex items-center justify-center bg-pop-black text-white px-6 py-3 border-2 border-pop-black shadow-hard-sm font-sans font-black uppercase tracking-tight">
                        <span class="fa-solid fa-arrow-left mr-2"></span>
                        <?php esc_html_e( 'Go home', 'flavor-flavor' ); ?>
                    </a>
                    <a href="<?php echo esc_url( home_url( '/?s=' ) ); ?>"
                       class="btn-physics inline-flex items-center justify-center bg-pop-yellow text-black px-6 py-3 border-2 border-pop-black shadow-hard-sm font-sans font-black uppercase tracking-tight">
                        <span class="fa-solid fa-magnifying-glass mr-2"></span>
                        <?php esc_html_e( 'Search', 'flavor-flavor' ); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
get_footer();
