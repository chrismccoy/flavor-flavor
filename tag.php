<?php
/**
 * Tag Archive Template
 *
 * @package    Flavor_Flavor
 */

get_header();
?>

<section id="blog-archive" class="mb-10">
    <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4">
        <div>
            <div class="badge bg-pop-yellow mb-3">
                <span class="fa-solid fa-tags" aria-hidden="true"></span>
                <?php esc_html_e( 'Tag', 'flavor-flavor' ); ?>
            </div>
            <h2 class="font-sans font-black text-4xl md:text-5xl uppercase tracking-tighter leading-none">
                <?php single_tag_title(); ?>
            </h2>
            <?php if ( tag_description() ) : ?>
                <p class="mt-3 text-sm md:text-base text-gray-700 max-w-3xl">
                    <?php echo wp_kses_post( tag_description() ); ?>
                </p>
            <?php endif; ?>
            <div class="mt-4 inline-flex items-center gap-2 bg-paper border-2 border-pop-black px-4 py-2 shadow-hard-sm">
                <span class="fa-solid fa-list-ol text-pop-pink" aria-hidden="true"></span>
                <span class="font-mono font-bold text-sm">
                    <?php printf( esc_html__( '%d results found', 'flavor-flavor' ), (int) $wp_query->found_posts ); ?>
                </span>
            </div>
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
