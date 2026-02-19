<?php
/**
 * Theme Footer Template
 *
 * @package    Flavor_Flavor
 */
?>
    </main>

    <?php get_template_part( 'template-parts/cta' ); ?>

    <footer class="border-t-4 border-pop-black bg-pop-black text-white p-8">
        <div class="flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="flex items-center gap-4">
                <?php if ( has_custom_logo() ) : ?>
                    <?php
                    $logo_id  = get_theme_mod( 'custom_logo' );
                    $logo_url = wp_get_attachment_image_url( $logo_id, 'full' );
                    ?>
                    <img src="<?php echo esc_url( $logo_url ); ?>" alt=""
                         class="w-12 h-12 rounded-full border-2 border-white object-cover">
                <?php else : ?>
                    <span class="w-12 h-12 bg-pop-yellow text-black rounded-full flex items-center justify-center font-black text-xl border-2 border-white">
                        <?php echo esc_html( mb_substr( get_bloginfo( 'name' ), 0, 1 ) ); ?>
                    </span>
                <?php endif; ?>

                <div class="font-sans font-black text-3xl uppercase">
                    <?php bloginfo( 'name' ); ?>
                </div>
            </div>

            <div class="font-mono text-gray-400 text-sm text-center">
                <?php echo esc_html( get_theme_mod( 'flavor_footer_text', '© ' . date( 'Y' ) . ' ' . get_bloginfo( 'name' ) . '.' ) ); ?>
            </div>
        </div>
    </footer>

</div>

<button id="scrolltop"
        class="fixed bottom-6 right-6 z-40 bg-pop-cyan border-4 border-pop-black w-16 h-16 shadow-hard-md hidden flex-col items-center justify-center btn-physics group"
        aria-label="<?php esc_attr_e( 'Scroll to top', 'flavor-flavor' ); ?>">
    <span class="fa fa-arrow-up text-xl group-hover:-translate-y-1 transition-transform"></span>
</button>

<?php wp_footer(); ?>
</body>
</html>
