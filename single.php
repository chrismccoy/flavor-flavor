<?php
/**
 * Single Post Template
 *
 * @package    Flavor_Flavor
 */

get_header();
?>

<section id="blog" class="mb-10">
    <?php
    $post_cats = get_the_category();
    $post_tags = get_the_tags();
    ?>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <div class="lg:col-span-8 space-y-6">
        <?php while ( have_posts() ) : the_post(); ?>
            <article <?php post_class(); ?>>
                <div class="relative">
                    <div class="absolute inset-0 bg-pop-black translate-x-2 translate-y-2" aria-hidden="true"></div>

                    <div class="relative accordion overflow-hidden">
                        <header class="p-6 md:p-8 bg-white">
                            <div class="flex flex-wrap items-center gap-3 mb-5">
                                <?php if ( is_sticky() ) : ?>
                                    <span class="badge bg-pop-yellow">
                                        <span class="fa-solid fa-star" aria-hidden="true"></span>
                                        <?php esc_html_e( 'Featured Post', 'flavor-flavor' ); ?>
                                    </span>
                                <?php endif; ?>

                                <?php if ( ! empty( $post_cats ) ) : ?>
                                    <a href="<?php echo esc_url( get_category_link( $post_cats[0]->term_id ) ); ?>"
                                       class="badge bg-pop-cyan">
                                        <span class="fa-solid fa-screwdriver-wrench" aria-hidden="true"></span>
                                        <?php echo esc_html( $post_cats[0]->name ); ?>
                                    </a>
                                <?php endif; ?>
                            </div>

                            <h1 class="font-sans font-black text-4xl md:text-5xl uppercase tracking-tighter leading-[0.95] underline decoration-8 decoration-pop-pink">
                                <?php the_title(); ?>
                            </h1>

                            <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-3 text-sm">
                                <div class="hard-outline-2 bg-paper p-3 shadow-hard-sm">
                                    <div class="font-mono uppercase tracking-widest text-xs">
                                        <span class="fa-solid fa-calendar-days mr-2"></span><?php esc_html_e( 'Date', 'flavor-flavor' ); ?>
                                    </div>
                                    <div class="font-mono font-bold"><?php echo esc_html( get_the_date( 'M d, Y' ) ); ?></div>
                                </div>

                                <div class="hard-outline-2 bg-paper p-3 shadow-hard-sm">
                                    <div class="font-mono uppercase tracking-widest text-xs">
                                        <span class="fa-solid fa-user-pen mr-2"></span><?php esc_html_e( 'Author', 'flavor-flavor' ); ?>
                                    </div>
                                    <div class="font-mono font-bold"><?php echo esc_html( get_the_author() ); ?></div>
                                </div>

                                <div class="hard-outline-2 bg-paper p-3 shadow-hard-sm">
                                    <div class="font-mono uppercase tracking-widest text-xs">
                                        <span class="fa-solid fa-clock mr-2"></span><?php esc_html_e( 'Read time', 'flavor-flavor' ); ?>
                                    </div>
                                    <div class="font-mono font-bold"><?php printf( esc_html__( '%d min', 'flavor-flavor' ), flavor_reading_time() ); ?></div>
                                </div>

                                <div class="hard-outline-2 bg-paper p-3 shadow-hard-sm">
                                    <div class="font-mono uppercase tracking-widest text-xs">
                                        <span class="fa-solid fa-eye mr-2"></span><?php esc_html_e( 'Views', 'flavor-flavor' ); ?>
                                    </div>
                                    <div class="font-mono font-bold"><?php echo esc_html( flavor_format_views() ); ?></div>
                                </div>
                            </div>

                            <?php if ( has_excerpt() ) : ?>
                                <p class="mt-6 text-gray-700 text-sm md:text-base max-w-3xl">
                                    <?php echo esc_html( get_the_excerpt() ); ?>
                                </p>
                            <?php endif; ?>
                        </header>

                        <div class="soft-divider"></div>

                        <div class="p-6 md:p-8 bg-white">
                            <div class="grid gap-6 prose-brutal">
                                <?php the_content(); ?>

                                <div class="soft-divider"></div>

                                <footer class="pt-2">
                                    <div class="flex flex-col gap-4">
                                        <?php $tags = get_the_tags(); ?>
                                        <?php if ( $tags ) : ?>
                                            <div class="flex flex-wrap items-center gap-3">
                                                <span class="font-mono font-bold uppercase tracking-widest text-xs">
                                                    <span class="fa-solid fa-tags mr-2" aria-hidden="true"></span>
                                                    <?php esc_html_e( 'Tags', 'flavor-flavor' ); ?>
                                                </span>
                                                <?php foreach ( $tags as $tag ) : ?>
                                                    <a href="<?php echo esc_url( get_tag_link( $tag ) ); ?>"
                                                       class="badge bg-white link-underline">
                                                        <span class="fa-solid fa-tag" aria-hidden="true"></span>
                                                        <?php echo esc_html( $tag->name ); ?>
                                                    </a>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>

                                        <div class="flex flex-col sm:flex-row gap-3">
                                            <a href="javascript:void(0);"
                                               onclick="navigator.share ? navigator.share({title: document.title, url: window.location.href}) : void(0)"
                                               class="btn-physics inline-flex items-center justify-center bg-pop-black text-white px-6 py-3 border-2 border-pop-black shadow-hard-sm font-sans font-black uppercase tracking-tight w-full sm:w-auto">
                                                <span class="fa-solid fa-share-nodes mr-2"></span>
                                                <?php esc_html_e( 'Share', 'flavor-flavor' ); ?>
                                            </a>

                                            <?php
                                            $next_post = get_next_post();
                                            $prev_post = get_previous_post();
                                            ?>

                                            <?php if ( $prev_post ) : ?>
                                                <a href="<?php echo esc_url( get_permalink( $prev_post ) ); ?>"
                                                   class="btn-physics inline-flex items-center justify-center bg-pop-pink text-black px-6 py-3 border-2 border-pop-black shadow-hard-sm font-sans font-black uppercase tracking-tight w-full sm:w-auto">
                                                    <span class="fa-solid fa-arrow-left mr-2"></span>
                                                    <?php esc_html_e( 'Prev post', 'flavor-flavor' ); ?>
                                                </a>
                                            <?php endif; ?>

                                            <?php if ( $next_post ) : ?>
                                                <a href="<?php echo esc_url( get_permalink( $next_post ) ); ?>"
                                                   class="btn-physics inline-flex items-center justify-center bg-pop-yellow text-black px-6 py-3 border-2 border-pop-black shadow-hard-sm font-sans font-black uppercase tracking-tight w-full sm:w-auto">
                                                    <span class="fa-solid fa-arrow-right mr-2"></span>
                                                    <?php esc_html_e( 'Next post', 'flavor-flavor' ); ?>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </footer>
                            </div>
                        </div>
                    </div>
                </div>
            </article>

            <?php if ( comments_open() || get_comments_number() ) : ?>
                <?php comments_template(); ?>
            <?php endif; ?>
        <?php endwhile; ?>
        </div>

        <?php get_sidebar(); ?>
    </div>
</section>

<?php
get_footer();
