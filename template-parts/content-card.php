<?php
/**
 * Template Part: Post Card
 *
 * @package    Flavor_Flavor
 */

$categories = get_the_category();
$tags       = get_the_tags();
$first_cat  = ! empty( $categories ) ? $categories[0] : null;
?>

<article <?php post_class( 'accordion overflow-hidden card-physics relative' ); ?>>
    <?php if ( has_post_thumbnail() ) : ?>
        <div class="border-b-4 border-pop-black overflow-hidden">
            <?php the_post_thumbnail( 'flavor-card', array(
                'class'   => 'w-full h-64 md:h-80 object-cover',
                'loading' => 'lazy',
            ) ); ?>
        </div>
    <?php endif; ?>
    <div class="p-6 md:p-7 bg-white">
        <div class="flex flex-wrap items-center gap-3 relative z-10">
            <?php if ( $first_cat ) : ?>
                <a href="<?php echo esc_url( get_category_link( $first_cat->term_id ) ); ?>"
                   class="badge bg-white">
                    <span class="fa-solid fa-tag" aria-hidden="true"></span>
                    <?php echo esc_html( $first_cat->name ); ?>
                </a>
            <?php endif; ?>

            <?php if ( $tags ) : ?>
                <?php $first_tag = $tags[0]; ?>
                <a href="<?php echo esc_url( get_tag_link( $first_tag->term_id ) ); ?>"
                   class="badge bg-pop-pink">
                    <span class="fa-solid fa-wand-magic-sparkles" aria-hidden="true"></span>
                    <?php echo esc_html( $first_tag->name ); ?>
                </a>
            <?php endif; ?>

            <?php if ( is_sticky() ) : ?>
                <span class="badge bg-pop-yellow">
                    <span class="fa-solid fa-star" aria-hidden="true"></span>
                    <?php esc_html_e( 'Featured', 'flavor-flavor' ); ?>
                </span>
            <?php endif; ?>
        </div>

        <h3 class="mt-4 font-sans font-black text-2xl md:text-3xl uppercase tracking-tighter leading-[0.95]">
            <?php
            $title = get_the_title();
            $colon = strpos( $title, ':' );
            if ( $colon !== false ) {
                $before = substr( $title, 0, $colon + 1 );
                $after  = substr( $title, $colon + 1 );
                echo esc_html( $before );
                echo '<span class="underline decoration-8 decoration-pop-pink">';
                echo esc_html( $after );
                echo '</span>';
            } else {
                echo esc_html( $title );
            }
            ?>
        </h3>

        <?php if ( has_excerpt() || get_the_content() ) : ?>
            <p class="mt-3 text-sm md:text-base text-gray-700 max-w-3xl">
                <?php echo esc_html( get_the_excerpt() ); ?>
            </p>
        <?php endif; ?>

        <div class="mt-5 flex flex-wrap gap-3 text-sm">
            <span class="badge bg-white">
                <span class="fa-solid fa-calendar-days" aria-hidden="true"></span>
                <span><?php echo esc_html( get_the_date( 'M d, Y' ) ); ?></span>
            </span>
            <span class="badge bg-white">
                <span class="fa-solid fa-user-pen" aria-hidden="true"></span>
                <span><?php echo esc_html( get_the_author() ); ?></span>
            </span>
            <span class="badge bg-white">
                <span class="fa-solid fa-clock" aria-hidden="true"></span>
                <span><?php printf( esc_html__( '%d min', 'flavor-flavor' ), flavor_reading_time() ); ?></span>
            </span>
            <span class="badge bg-white">
                <span class="fa-solid fa-eye" aria-hidden="true"></span>
                <span><?php echo esc_html( flavor_format_views() ); ?></span>
            </span>
        </div>

        <div class="mt-5 flex items-center justify-between">
            <?php if ( $first_cat ) : ?>
                <div class="text-sm text-gray-600 font-mono relative z-10">
                    <a href="<?php echo esc_url( get_category_link( $first_cat->term_id ) ); ?>"
                       class="hover:underline">
                        <span class="fa-solid fa-folder-open mr-2"></span><?php echo esc_html( $first_cat->name ); ?>
                    </a>
                </div>
            <?php endif; ?>
            <a href="<?php the_permalink(); ?>"
               class="inline-flex items-center font-sans font-black uppercase tracking-tight stretched-link"
               aria-label="<?php echo esc_attr( sprintf( __( 'Read: %s', 'flavor-flavor' ), get_the_title() ) ); ?>">
                <?php esc_html_e( 'Read post', 'flavor-flavor' ); ?>
                <span class="fa-solid fa-arrow-right ml-2"></span>
            </a>
        </div>
    </div>
</article>
