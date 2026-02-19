<?php
/**
 * Custom Search Form Template
 *
 * @package    Flavor_Flavor
 */
?>
<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex gap-2">
    <input type="search" name="s"
           placeholder="<?php esc_attr_e( 'Search blog...', 'flavor-flavor' ); ?>"
           value=""
           class="w-full hard-outline-2 bg-white px-4 py-3 font-mono text-sm focus:outline-none">
    <button type="submit"
            class="btn-physics hard-outline-2 bg-pop-yellow px-4 py-3 shadow-hard-sm"
            aria-label="<?php esc_attr_e( 'Search', 'flavor-flavor' ); ?>">
        <span class="fa-solid fa-arrow-right"></span>
    </button>
</form>
