<?php
/**
 * Template Part: Call to Action Section
 *
 * @package    Flavor_Flavor
 */

$badge       = get_theme_mod( 'flavor_cta_badge', 'Ready when you are' );
$heading     = get_theme_mod( 'flavor_cta_heading', 'Launch your' );
$highlight   = get_theme_mod( 'flavor_cta_heading_highlight', 'Big Product Today' );
$description = get_theme_mod( 'flavor_cta_description', 'Fast setup • 12 platform connections • 18 themes • Admin tools • Search-friendly pages • Mobile app feel' );
$btn1_text   = get_theme_mod( 'flavor_cta_btn1_text', 'Buy the script' );
$btn1_url    = get_theme_mod( 'flavor_cta_btn1_url', 'https://buy.domain.com' );
$btn2_text   = get_theme_mod( 'flavor_cta_btn2_text', 'Live demo' );
$btn2_url    = get_theme_mod( 'flavor_cta_btn2_url', 'https://demo.domain.com' );
$badges_raw  = get_theme_mod( 'flavor_cta_badges', 'PHP 8.5,Laravel 12,Tailwind,Vite,PWA' );
$badges      = array_map( 'trim', explode( ',', $badges_raw ) );

$badge_colors = array( 'bg-white', 'bg-pop-cyan', 'bg-pop-yellow', 'bg-pop-pink', 'bg-white' );
?>

<section class="p-6 md:p-8 bg-paper">
    <div class="mb-4">
        <div class="relative">
            <div class="absolute inset-0 bg-pop-black translate-x-2 translate-y-2"></div>

            <div class="relative bg-pop-black border-4 border-pop-black p-8">
                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-8">
                    <div class="max-w-2xl">
                        <div class="badge bg-pop-yellow mb-4">
                            <span class="fa-solid fa-bolt"></span>
                            <?php echo esc_html( $badge ); ?>
                        </div>
                        <h2 class="font-sans font-black text-4xl md:text-5xl uppercase tracking-tighter leading-none text-white">
                            <?php echo esc_html( $heading ); ?>
                            <span class="block text-pop-yellow underline decoration-8 decoration-pop-pink">
                                <?php echo esc_html( $highlight ); ?>
                            </span>
                        </h2>
                        <p class="mt-4 text-sm md:text-base font-medium text-gray-200">
                            <?php echo esc_html( $description ); ?>
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 w-full lg:w-auto">
                        <?php if ( $btn1_url ) : ?>
                            <a href="<?php echo esc_url( $btn1_url ); ?>"
                               class="btn-physics inline-flex items-center justify-center bg-pop-yellow text-black px-7 py-4 border-2 border-pop-black shadow-hard-md font-sans font-black uppercase tracking-tight text-lg w-full sm:w-auto">
                                <?php echo esc_html( $btn1_text ); ?>
                                <span class="fa-solid fa-arrow-right ml-2"></span>
                            </a>
                        <?php endif; ?>
                        <?php if ( $btn2_url ) : ?>
                            <a href="<?php echo esc_url( $btn2_url ); ?>"
                               class="btn-physics inline-flex items-center justify-center bg-pop-pink text-black px-7 py-4 border-2 border-pop-black shadow-hard-md font-sans font-black uppercase tracking-tight text-lg w-full sm:w-auto">
                                <?php echo esc_html( $btn2_text ); ?>
                                <span class="fa-solid fa-eye ml-2"></span>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if ( ! empty( $badges ) ) : ?>
                    <div class="mt-8 flex flex-wrap gap-3">
                        <?php foreach ( $badges as $i => $b ) :
                            $color = $badge_colors[ $i % count( $badge_colors ) ];
                        ?>
                            <span class="badge <?php echo esc_attr( $color ); ?>"><?php echo esc_html( $b ); ?></span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
