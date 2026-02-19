<?php
/**
 * Static Page Template
 *
 * @package    Flavor_Flavor
 */

get_header();
?>

<section id="page-content" class="mb-10">
    <?php while ( have_posts() ) : the_post(); ?>
        <article <?php post_class(); ?>>
            <div class="relative">
                <div class="absolute inset-0 bg-pop-black translate-x-2 translate-y-2" aria-hidden="true"></div>

                <div class="relative accordion overflow-hidden">
                    <header class="p-6 md:p-8 bg-white">
                        <h1 class="font-sans font-black text-4xl md:text-5xl uppercase tracking-tighter leading-[0.95] underline decoration-8 decoration-pop-pink">
                            <?php the_title(); ?>
                        </h1>

                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="mt-6">
                                <div class="relative">
                                    <div class="absolute inset-0 bg-pop-black translate-x-2 translate-y-2" aria-hidden="true"></div>
                                    <div class="relative hard-outline bg-white overflow-hidden">
                                        <?php the_post_thumbnail( 'flavor-hero', array(
                                            'class'   => 'w-full object-cover',
                                            'loading' => 'lazy',
                                        ) ); ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </header>

                    <div class="soft-divider"></div>

                    <div class="p-6 md:p-8 bg-white">
                        <div class="prose-brutal">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    <?php endwhile; ?>
</section>

<?php
get_footer();
