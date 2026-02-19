<?php
/**
 * Flavor Flavor Theme Functions
 *
 * @package    Flavor_Flavor
 */

declare(strict_types=1);

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Set up theme defaults and register support for various WordPress features.
 */
function flavor_setup(): void
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ]);
    add_theme_support('custom-logo', [
        'height'      => 40,
        'width'       => 40,
        'flex-height' => true,
        'flex-width'  => true,
    ]);
    add_theme_support('editor-styles');

    add_image_size('flavor-hero', 1200, 520, true);
    add_image_size('flavor-card', 800, 400, true);

    register_nav_menus([
        'header-buttons' => __('Header Buttons', 'flavor-flavor'),
    ]);
}

add_action('after_setup_theme', 'flavor_setup');

/**
 * Enqueue front-end stylesheets and scripts.
 */
function flavor_enqueue_assets(): void
{
    // Google Fonts
    wp_enqueue_style(
        'flavor-google-fonts',
        'https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@500;600;700&family=Inter:wght@800;900&display=swap',
        [],
        null
    );

    // Font Awesome
    wp_enqueue_style(
        'flavor-fontawesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css',
        [],
        '6.5.2'
    );

    // Theme compiled CSS
    wp_enqueue_style(
        'flavor-style',
        get_template_directory_uri() . '/assets/css/app.css',
        ['flavor-google-fonts', 'flavor-fontawesome'],
        '1.0'
    );

    // Scroll-to-top + mobile menu script
    wp_enqueue_script(
        'flavor-scripts',
        get_template_directory_uri() . '/assets/js/theme.js',
        [],
        '1.0',
        true
    );
}

add_action('wp_enqueue_scripts', 'flavor_enqueue_assets');

/**
 * Redirect `?s=` queries to pretty `/search/term/` URLs.
 */
function flavor_pretty_search_redirect(): void
{
    if (is_search() && ! empty($_GET['s'])) {
        $search_query = get_search_query(false);
        wp_safe_redirect(home_url('/search/' . urlencode($search_query) . '/'));
        exit;
    }
}

add_action('template_redirect', 'flavor_pretty_search_redirect');

/**
 * Register the main sidebar widget area.
 */
function flavor_widgets_init(): void
{
    register_sidebar([
        'name'          => __('Sidebar', 'flavor-flavor'),
        'id'            => 'sidebar-1',
        'description'   => __('Widgets shown in the sidebar across all pages.', 'flavor-flavor'),
        'before_widget' => '<section id="%1$s" class="accordion overflow-hidden %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<!-- widget-title: ',
        'after_title'   => ' -->',
    ]);
}

add_action('widgets_init', 'flavor_widgets_init');

/**
 * Calculate the estimated reading time for a post.
 */
function flavor_reading_time(?int $post_id = null): int
{
    $post_id = $post_id ?: get_the_ID();
    $content = get_post_field('post_content', $post_id);
    $words   = str_word_count(wp_strip_all_tags($content));

    return max(1, (int) ceil($words / 250));
}

/**
 * Retrieve the view count for a post.
 */
function flavor_get_views(?int $post_id = null): int
{
    $post_id = $post_id ?: get_the_ID();
    $count   = get_post_meta($post_id, '_flavor_views', true);

    return $count ? (int) $count : 0;
}

/**
 * Increment the view counter for the current single post.
 */
function flavor_increment_views(): void
{
    if (! is_single()) {
        return;
    }

    if (is_user_logged_in() && current_user_can('edit_posts')) {
        return;
    }

    $post_id = get_the_ID();

    if (false === $post_id) {
        return;
    }

    $count = flavor_get_views($post_id);
    update_post_meta($post_id, '_flavor_views', $count + 1);
}

add_action('wp', 'flavor_increment_views');

/**
 * Format a post's view count with thousands separators.
 */
function flavor_format_views(?int $post_id = null): string
{
    return number_format(flavor_get_views($post_id));
}

/**
 * Set the automatic excerpt length to 25 words.
 */
function flavor_excerpt_length(int $length): int
{
    return 25;
}
add_filter('excerpt_length', 'flavor_excerpt_length');

/**
 * Replace the default "[...]" excerpt suffix
 */
function flavor_excerpt_more(string $more): string
{
    return '&hellip;';
}
add_filter('excerpt_more', 'flavor_excerpt_more');

/**
 * Append Tailwind utility classes to the `<body>` element.
 */
function flavor_body_classes(array $classes): array
{
    $classes[] = 'bg-pop-cyan';
    $classes[] = 'text-pop-black';
    $classes[] = 'font-mono';
    $classes[] = 'min-h-screen';
    $classes[] = 'p-2';
    $classes[] = 'md:p-8';
    $classes[] = 'flex';
    $classes[] = 'flex-col';
    $classes[] = 'items-center';

    return $classes;
}
add_filter('body_class', 'flavor_body_classes');

/**
 * Register Customizer settings and controls.
 */
function flavor_customizer(\WP_Customize_Manager $wp_customize): void
{
    // CTA Section
    $wp_customize->add_section('flavor_cta', [
        'title'    => __('CTA Section', 'flavor-flavor'),
        'priority' => 90,
    ]);

    $cta_fields = [
        'flavor_cta_badge'             => ['CTA Badge Text', 'Ready when you are'],
        'flavor_cta_heading'           => ['CTA Heading Line 1', 'Launch your'],
        'flavor_cta_heading_highlight' => ['CTA Heading Highlight', 'Big Product Now'],
        'flavor_cta_description'       => ['CTA Description', 'Fast setup . 12 platform connections . 18 themes . Admin tools . Search-friendly pages . Mobile app feel'],
        'flavor_cta_btn1_text'         => ['Button 1 Text', 'Buy the script'],
        'flavor_cta_btn1_url'          => ['Button 1 URL', 'https://buy.domain.com'],
        'flavor_cta_btn2_text'         => ['Button 2 Text', 'Live demo'],
        'flavor_cta_btn2_url'          => ['Button 2 URL', 'https://demo.domain.com'],
        'flavor_cta_badges'            => ['Tech Badges (comma-separated)', 'PHP 8.5,Laravel 12,Tailwind,Vite,PWA'],
    ];

    foreach ($cta_fields as $id => $data) {
        $wp_customize->add_setting($id, [
            'default'           => $data[1],
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control($id, [
            'label'   => $data[0],
            'section' => 'flavor_cta',
            'type'    => 'text',
        ]);
    }

    // Header Buttons
    $wp_customize->add_section('flavor_header', [
        'title'    => __('Header Buttons', 'flavor-flavor'),
        'priority' => 80,
    ]);

    $header_fields = [
        'flavor_header_btn1_text' => ['Button 1 Text', 'Live Demo'],
        'flavor_header_btn1_url'  => ['Button 1 URL', 'https://demo.domain.com'],
        'flavor_header_btn1_icon' => ['Button 1 FA Icon Class', 'fa-solid fa-eye'],
        'flavor_header_btn2_text' => ['Button 2 Text', 'Buy for $1'],
        'flavor_header_btn2_url'  => ['Button 2 URL', 'https://buy.domain.com'],
        'flavor_header_btn2_icon' => ['Button 2 FA Icon Class', 'fa-solid fa-arrow-right'],
    ];

    foreach ($header_fields as $id => $data) {
        $wp_customize->add_setting($id, [
            'default'           => $data[1],
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control($id, [
            'label'   => $data[0],
            'section' => 'flavor_header',
            'type'    => 'text',
        ]);
    }

    // Pagination
    $wp_customize->add_section('flavor_pagination', [
        'title'    => __('Pagination', 'flavor-flavor'),
        'priority' => 85,
    ]);

    $wp_customize->add_setting('flavor_pagination_style', [
        'default'           => 'prev_next',
        'sanitize_callback' => function (string $value): string {
            return in_array($value, ['prev_next', 'numbered'], true) ? $value : 'prev_next';
        },
    ]);
    $wp_customize->add_control('flavor_pagination_style', [
        'label'   => __('Pagination Style', 'flavor-flavor'),
        'section' => 'flavor_pagination',
        'type'    => 'radio',
        'choices' => [
            'prev_next' => __('Newer / Older with page counter', 'flavor-flavor'),
            'numbered'  => __('Numbered pages with prev / next', 'flavor-flavor'),
        ],
    ]);

    // Footer
    $wp_customize->add_section('flavor_footer', [
        'title'    => __('Footer', 'flavor-flavor'),
        'priority' => 95,
    ]);

    $wp_customize->add_setting('flavor_footer_text', [
        'default'           => '© ' . date('Y') . ' Flavor Flavor.',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('flavor_footer_text', [
        'label'   => __('Footer Copyright Text', 'flavor-flavor'),
        'section' => 'flavor_footer',
        'type'    => 'text',
    ]);
}

add_action('customize_register', 'flavor_customizer');

/**
 * Replace the default [gallery] shortcode output with a styled grid.
 */
function flavor_post_gallery(string $output, array $attr, int $instance): string
{
    $post = get_post();

    $atts = shortcode_atts([
        'order'   => 'ASC',
        'orderby' => 'menu_order ID',
        'id'      => $post ? $post->ID : 0,
        'columns' => 3,
        'size'    => 'medium',
        'include' => '',
        'exclude' => '',
        'link'    => '',
    ], $attr, 'gallery');

    $id = (int) $atts['id'];

    // Build the attachment query.
    if (! empty($atts['include'])) {
        $attachments = get_posts([
            'include'        => $atts['include'],
            'post_status'    => 'inherit',
            'post_type'      => 'attachment',
            'post_mime_type' => 'image',
            'order'          => $atts['order'],
            'orderby'        => $atts['orderby'],
        ]);
    } elseif (! empty($atts['exclude'])) {
        $attachments = get_posts([
            'post_parent'    => $id,
            'exclude'        => $atts['exclude'],
            'post_status'    => 'inherit',
            'post_type'      => 'attachment',
            'post_mime_type' => 'image',
            'order'          => $atts['order'],
            'orderby'        => $atts['orderby'],
        ]);
    } else {
        $attachments = get_posts([
            'post_parent'    => $id,
            'post_status'    => 'inherit',
            'post_type'      => 'attachment',
            'post_mime_type' => 'image',
            'order'          => $atts['order'],
            'orderby'        => $atts['orderby'],
        ]);
    }

    if (empty($attachments)) {
        return '';
    }

    // Single image
    if (count($attachments) === 1) {
        $attachment = $attachments[0];
        $img_src    = wp_get_attachment_image_src($attachment->ID, 'large');
        $img_full   = wp_get_attachment_image_src($attachment->ID, 'full');
        $img_alt    = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);
        $img_alt    = $img_alt ?: $attachment->post_title;
        $caption    = wp_get_attachment_caption($attachment->ID);

        if (! $img_src) {
            return '';
        }

        ob_start();
        ?>
        <figure class="my-6 hard-outline bg-paper shadow-hard-md overflow-hidden m-0">
            <?php
            $link_url = '';
            if ('none' !== $atts['link']) {
                if ('file' === $atts['link'] && $img_full) {
                    $link_url = $img_full[0];
                } else {
                    $link_url = get_attachment_link($attachment->ID);
                }
            }
            ?>
            <?php if ($link_url) : ?>
                <a href="<?php echo esc_url($link_url); ?>">
                    <img src="<?php echo esc_url($img_src[0]); ?>"
                         alt="<?php echo esc_attr($img_alt); ?>"
                         class="w-full object-cover"
                         width="<?php echo (int) $img_src[1]; ?>"
                         height="<?php echo (int) $img_src[2]; ?>"
                         loading="lazy" />
                </a>
            <?php else : ?>
                <img src="<?php echo esc_url($img_src[0]); ?>"
                     alt="<?php echo esc_attr($img_alt); ?>"
                     class="w-full object-cover"
                     width="<?php echo (int) $img_src[1]; ?>"
                     height="<?php echo (int) $img_src[2]; ?>"
                     loading="lazy" />
            <?php endif; ?>
            <?php if ($caption) : ?>
                <figcaption class="p-3 bg-paper border-t-2 border-pop-black">
                    <p class="font-mono text-xs text-gray-700 m-0"><?php echo esc_html($caption); ?></p>
                </figcaption>
            <?php endif; ?>
        </figure>
        <?php
        return ob_get_clean() ?: '';
    }

    $columns    = max(1, min(9, (int) $atts['columns']));
    $gallery_id = 'flavor-gallery-' . $instance;

    // Start building output via template buffer.
    ob_start();
    ?>
    <div id="<?php echo esc_attr($gallery_id); ?>" class="flavor-gallery my-6">

        <div class="flex items-center gap-3 mb-4">
            <span class="badge bg-pop-pink">
                <span class="fa-solid fa-images" aria-hidden="true"></span>
                <?php esc_html_e('Gallery', 'flavor-flavor'); ?>
            </span>
            <span class="badge bg-white">
                <span class="fa-solid fa-image" aria-hidden="true"></span>
                <?php echo count($attachments); ?> <?php esc_html_e('images', 'flavor-flavor'); ?>
            </span>
        </div>

        <div class="grid gap-4 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($attachments as $index => $attachment) :
                $img_src  = wp_get_attachment_image_src($attachment->ID, $atts['size']);
                $img_full = wp_get_attachment_image_src($attachment->ID, 'full');
                $img_alt  = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);
                $img_alt  = $img_alt ?: $attachment->post_title;
                $caption  = wp_get_attachment_caption($attachment->ID);

                if (! $img_src) {
                    continue;
                }

                // Determine link target.
                $link_url = '';
                if ('none' !== $atts['link']) {
                    if ('file' === $atts['link'] && $img_full) {
                        $link_url = $img_full[0];
                    } else {
                        $link_url = get_attachment_link($attachment->ID);
                    }
                }
            ?>
                <?php if ($link_url) : ?>
                    <a href="<?php echo esc_url($link_url); ?>"
                       class="flavor-gallery-link card-physics hard-outline-2 bg-paper block overflow-hidden"
                       data-gallery="<?php echo esc_attr($gallery_id); ?>"
                       data-index="<?php echo (int) $index; ?>"
                       data-caption="<?php echo esc_attr($caption); ?>"
                       aria-label="<?php echo esc_attr(sprintf(__('View image: %s', 'flavor-flavor'), $img_alt)); ?>">
                        <img src="<?php echo esc_url($img_src[0]); ?>"
                             alt="<?php echo esc_attr($img_alt); ?>"
                             class="w-full aspect-square object-cover"
                             width="<?php echo (int) $img_src[1]; ?>"
                             height="<?php echo (int) $img_src[2]; ?>"
                             loading="lazy" />
                        <?php if ($caption) : ?>
                            <div class="p-2 bg-paper border-t-2 border-pop-black">
                                <p class="font-mono text-xs text-gray-700 truncate m-0"><?php echo esc_html($caption); ?></p>
                            </div>
                        <?php endif; ?>
                    </a>
                <?php else : ?>
                    <figure class="card-physics hard-outline-2 bg-paper block overflow-hidden m-0">
                        <img src="<?php echo esc_url($img_src[0]); ?>"
                             alt="<?php echo esc_attr($img_alt); ?>"
                             class="w-full aspect-square object-cover"
                             width="<?php echo (int) $img_src[1]; ?>"
                             height="<?php echo (int) $img_src[2]; ?>"
                             loading="lazy" />
                        <?php if ($caption) : ?>
                            <figcaption class="p-2 bg-paper border-t-2 border-pop-black">
                                <p class="font-mono text-xs text-gray-700 truncate m-0"><?php echo esc_html($caption); ?></p>
                            </figcaption>
                        <?php endif; ?>
                    </figure>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

    </div>
    <?php
    return ob_get_clean();
}

add_filter('post_gallery', 'flavor_post_gallery', 10, 3);

/**
 * Conditionally enqueue the lightbox script when a [gallery] shortcode is present.
 */
function flavor_maybe_enqueue_gallery_assets(): void
{
    global $post;

    if ($post && has_shortcode($post->post_content, 'gallery')) {
        wp_enqueue_script(
            'flavor-lightbox',
            get_template_directory_uri() . '/assets/js/lightbox.js',
            [],
            '1.0.0',
            true
        );
    }

}

add_action('wp_enqueue_scripts', 'flavor_maybe_enqueue_gallery_assets');

/**
 * Strip fixed-width inline styles from the [video] shortcode output.
 */
function flavor_responsive_video_shortcode(
    string $output,
    array $atts,
    ?string $video,
    int|false $post_id,
    string $library
): string {
    // Remove fixed-width inline style from the .wp-video wrapper.
    $output = preg_replace(
        '/(<div[^>]*class="wp-video"[^>]*)\s*style="[^"]*width:\s*\d+px[^"]*"/i',
        '$1',
        $output
    );

    // Also strip any width/height attributes from the <video> element itself.
    $output = preg_replace('/(<video[^>]*)\s*width="\d+"/i', '$1', $output);
    $output = preg_replace('/(<video[^>]*)\s*height="\d+"/i', '$1', $output);

    return $output;
}

add_filter('wp_video_shortcode', 'flavor_responsive_video_shortcode', 10, 5);

// Custom comment walker for threaded comments.
require_once get_template_directory() . '/inc/class-flavor-walker-comment.php';

// Widget Class Files
require_once get_template_directory() . '/inc/widgets/class-flavor-quick-links-widget.php';
require_once get_template_directory() . '/inc/widgets/class-flavor-search-widget.php';
require_once get_template_directory() . '/inc/widgets/class-flavor-categories-widget.php';
require_once get_template_directory() . '/inc/widgets/class-flavor-popular-posts-widget.php';
require_once get_template_directory() . '/inc/widgets/class-flavor-recent-posts-widget.php';
require_once get_template_directory() . '/inc/widgets/class-flavor-newsletter-widget.php';
require_once get_template_directory() . '/inc/widgets/class-flavor-tag-cloud-widget.php';
require_once get_template_directory() . '/inc/widgets/class-flavor-pages-widget.php';
require_once get_template_directory() . '/inc/widgets/class-flavor-archives-widget.php';
require_once get_template_directory() . '/inc/widgets/class-flavor-recent-comments-widget.php';
require_once get_template_directory() . '/inc/widgets/class-flavor-text-widget.php';
require_once get_template_directory() . '/inc/widgets/class-flavor-calendar-widget.php';
require_once get_template_directory() . '/inc/widgets/class-flavor-social-media-widget.php';
require_once get_template_directory() . '/inc/widgets/class-flavor-about-me-widget.php';

/**
 * Register all custom Flavor widgets with WordPress.
 */
function flavor_register_widgets(): void
{
    register_widget(Flavor_Quick_Links_Widget::class);
    register_widget(Flavor_Search_Widget::class);
    register_widget(Flavor_Categories_Widget::class);
    register_widget(Flavor_Popular_Posts_Widget::class);
    register_widget(Flavor_Recent_Posts_Widget::class);
    register_widget(Flavor_Newsletter_Widget::class);
    register_widget(Flavor_Tag_Cloud_Widget::class);
    register_widget(Flavor_Pages_Widget::class);
    register_widget(Flavor_Archives_Widget::class);
    register_widget(Flavor_Recent_Comments_Widget::class);
    register_widget(Flavor_Text_Widget::class);
    register_widget(Flavor_Calendar_Widget::class);
    register_widget(Flavor_Social_Media_Widget::class);
    register_widget(Flavor_About_Me_Widget::class);
}

add_action('widgets_init', 'flavor_register_widgets');

/**
 * Render blog pagination based on the Customizer setting.
 */
function flavor_pagination(): void
{
    global $wp_query;

    // Total number of pages.
    $total = (int) $wp_query->max_num_pages;

    if ($total <= 1) {
        return;
    }

    // Current page number
    $current = max(1, (int) get_query_var('paged'));

    // Pagination style: 'prev_next' or 'numbered'.
    $style = get_theme_mod('flavor_pagination_style', 'prev_next');

    // Shared Tailwind classes for all pagination buttons.
    $btn_base = 'btn-physics inline-flex items-center justify-center px-6 py-3 border-2 border-pop-black shadow-hard-sm font-sans font-black uppercase tracking-tight';
    ?>
    <nav class="pt-2" aria-label="<?php esc_attr_e('Blog pagination', 'flavor-flavor'); ?>">
        <?php if ('numbered' === $style) : ?>
            <div class="flex flex-wrap items-center justify-center gap-2">
                <?php if ($current > 1) : ?>
                    <a href="<?php echo esc_url(get_previous_posts_page_link()); ?>"
                       class="<?php echo esc_attr($btn_base); ?> bg-white text-black w-auto">
                        <span class="fa-solid fa-arrow-left mr-2"></span>
                        <?php esc_html_e('Prev', 'flavor-flavor'); ?>
                    </a>
                <?php endif; ?>

                <?php
                // Fixed-width sliding window of page numbers.
                $visible = 5;
                $show    = [];

                // Always include first and last pages.
                $show[] = 1;
                $show[] = $total;

                // Calculate a sliding window of $visible pages centred on $current.
                $half  = (int) floor($visible / 2);
                $start = $current - $half;
                $end   = $current + $half;

                // Clamp the window inside 1...$total.
                if ($start < 1) {
                    $start = 1;
                    $end   = min($total, $visible);
                }
                if ($end > $total) {
                    $end   = $total;
                    $start = max(1, $total - $visible + 1);
                }

                for ($i = $start; $i <= $end; $i++) {
                    $show[] = $i;
                }

                $show = array_unique($show);
                sort($show);

                $prev_page = 0;
                foreach ($show as $page_num) :
                    // Insert ellipsis when there is a gap between page numbers.
                    if ($prev_page && $page_num - $prev_page > 1) : ?>
                        <span class="px-2 font-mono font-bold text-gray-400 select-none">&hellip;</span>
                    <?php endif;
                    $prev_page  = $page_num;
                    $is_current = ($page_num === $current);
                    $page_url   = get_pagenum_link($page_num);
                ?>
                    <?php if ($is_current) : ?>
                        <span class="<?php echo esc_attr($btn_base); ?> bg-pop-black text-white"><?php echo (int) $page_num; ?></span>
                    <?php else : ?>
                        <a href="<?php echo esc_url($page_url); ?>"
                           class="<?php echo esc_attr($btn_base); ?> bg-white text-black hover:bg-pop-yellow transition-colors">
                            <?php echo (int) $page_num; ?>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>

                <?php if ($current < $total) : ?>
                    <a href="<?php echo esc_url(get_next_posts_page_link()); ?>"
                       class="<?php echo esc_attr($btn_base); ?> bg-pop-black text-white w-auto">
                        <?php esc_html_e('Next', 'flavor-flavor'); ?>
                        <span class="fa-solid fa-arrow-right ml-2"></span>
                    </a>
                <?php endif; ?>
            </div>
        <?php else : ?>
            <div class="flex flex-col sm:flex-row gap-3">
                <?php if (get_previous_posts_link()) : ?>
                    <a href="<?php echo esc_url(get_previous_posts_page_link()); ?>"
                       class="<?php echo esc_attr($btn_base); ?> bg-white text-black w-full sm:w-auto">
                        <span class="fa-solid fa-arrow-left mr-2"></span>
                        <?php esc_html_e('Newer', 'flavor-flavor'); ?>
                    </a>
                <?php endif; ?>

                <?php if (get_next_posts_link()) : ?>
                    <a href="<?php echo esc_url(get_next_posts_page_link()); ?>"
                       class="<?php echo esc_attr($btn_base); ?> bg-pop-black text-white w-full sm:w-auto">
                        <?php esc_html_e('Older', 'flavor-flavor'); ?>
                        <span class="fa-solid fa-arrow-right ml-2"></span>
                    </a>
                <?php endif; ?>

                <div class="sm:ml-auto flex items-center gap-2">
                    <span class="badge bg-white">
                        <span class="fa-solid fa-file-lines" aria-hidden="true"></span>
                        <?php printf(esc_html__('Page %1$d / %2$d', 'flavor-flavor'), $current, $total); ?>
                    </span>
                </div>
            </div>
        <?php endif; ?>
    </nav>
    <?php
}
