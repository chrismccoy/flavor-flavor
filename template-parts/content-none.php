<?php
/**
 * Template Part: No Posts Found
 *
 * @package    Flavor_Flavor
 */
?>

<div class="accordion overflow-hidden p-6 md:p-8 text-center">
    <div class="badge bg-pop-yellow mb-4">
        <span class="fa-solid fa-ghost" aria-hidden="true"></span>
        <?php esc_html_e( 'Nothing here', 'flavor-flavor' ); ?>
    </div>

    <h3 class="font-sans font-black text-2xl md:text-3xl uppercase tracking-tighter">
        <?php esc_html_e( 'No posts found', 'flavor-flavor' ); ?>
    </h3>

    <p class="mt-3 text-sm text-gray-700">
        <?php if ( is_search() ) : ?>
            <?php esc_html_e( 'No results matched your search. Try different keywords.', 'flavor-flavor' ); ?>
        <?php else : ?>
            <?php esc_html_e( 'There are no posts to display yet. Check back soon.', 'flavor-flavor' ); ?>
        <?php endif; ?>
    </p>

    <?php if ( is_search() ) : ?>
        <div class="mt-6">
            <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex gap-2 max-w-md mx-auto">
                <input type="search" name="s"
                       placeholder="<?php esc_attr_e( 'Try again...', 'flavor-flavor' ); ?>"
                       value=""
                       class="w-full hard-outline-2 bg-white px-4 py-3 font-mono text-sm focus:outline-none">
                <button type="submit"
                        class="btn-physics hard-outline-2 bg-pop-yellow px-4 py-3 shadow-hard-sm"
                        aria-label="<?php esc_attr_e( 'Search', 'flavor-flavor' ); ?>">
                    <span class="fa-solid fa-arrow-right"></span>
                </button>
            </form>
        </div>
    <?php endif; ?>
</div>
