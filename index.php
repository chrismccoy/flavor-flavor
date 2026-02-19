<?php
/**
 * Main Blog Index Template
 *
 * @package    Flavor_Flavor
 */

get_header();
?>

<section id="blog-index" class="mb-10">
    <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4">
        <div>
            <div class="badge bg-pop-cyan mb-3">
                <span class="fa-solid fa-newspaper" aria-hidden="true"></span>
                <?php esc_html_e( 'Blog Index', 'flavor-flavor' ); ?>
            </div>
            <h2 class="font-sans font-black text-4xl md:text-5xl uppercase tracking-tighter leading-none">
                <?php
                if ( is_home() && ! is_front_page() ) {
                    single_post_title();
                } else {
                    esc_html_e( 'Latest Posts', 'flavor-flavor' );
                }
                ?>
            </h2>
            <p class="mt-3 text-sm md:text-base text-gray-700 max-w-3xl">
                <?php echo esc_html( get_bloginfo( 'description' ) ); ?>
            </p>
        </div>

        <div class="flex flex-wrap gap-3">
            <?php
            $top_cats = get_categories( array( 'number' => 3, 'orderby' => 'count', 'order' => 'DESC' ) );
            $cat_colors = array( 'bg-pop-yellow', 'bg-white', 'bg-pop-pink' );
            $cat_icons  = array( 'fa-solid fa-filter', 'fa-solid fa-arrow-down-wide-short', 'fa-solid fa-tags' );
            foreach ( $top_cats as $i => $cat ) :
            ?>
                <a href="<?php echo esc_url( get_category_link( $cat ) ); ?>"
                   class="badge <?php echo esc_attr( $cat_colors[ $i % 3 ] ); ?>">
                    <span class="<?php echo esc_attr( $cat_icons[ $i % 3 ] ); ?>" aria-hidden="true"></span>
                    <?php echo esc_html( $cat->name ); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="mt-8 grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <div class="lg:col-span-8 space-y-6">
            <?php if ( have_posts() ) : ?>
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php get_template_part( 'template-parts/content', 'card' ); ?>
                <?php endwhile; ?>

                <?php flavor_pagination(); ?>
            <?php else : ?>
                <?php get_template_part( 'template-parts/content', 'none' ); ?>
            <?php endif; ?>
        </div>

        <?php get_sidebar(); ?>
    </div>
</section>

<?php
get_footer();
