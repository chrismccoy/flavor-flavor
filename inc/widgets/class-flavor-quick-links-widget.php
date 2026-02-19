<?php

/**
 * Quick Links Widget
 *
 * @package    Flavor_Flavor
 */

declare(strict_types=1);

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Widget: Quick Links
 *
 * Displays a set of navigation shortcut buttons (All Posts, Featured,
 * Browse Tags) with customisable labels and URLs.
 */
class Flavor_Quick_Links_Widget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'flavor_quick_links',
            __('Flavor: Quick Links', 'flavor-flavor'),
            ['description' => __('Quick navigation links with brutalism style.', 'flavor-flavor')]
        );
    }

    /**
     * Render the widget on the front end.
     */
    public function widget($args, $instance): void
    {
        $all_text      = ! empty($instance['all_text']) ? $instance['all_text'] : __('All posts', 'flavor-flavor');
        $all_url       = ! empty($instance['all_url']) ? $instance['all_url'] : get_permalink(get_option('page_for_posts'));
        $featured_text = ! empty($instance['featured_text']) ? $instance['featured_text'] : __('Featured', 'flavor-flavor');
        $featured_url  = ! empty($instance['featured_url']) ? $instance['featured_url'] : '#';
        $tags_text     = ! empty($instance['tags_text']) ? $instance['tags_text'] : __('Browse tags', 'flavor-flavor');
        ?>
        <section class="accordion overflow-hidden">
            <div class="p-5 bg-white">
                <div class="flex items-center justify-between gap-3">
                    <span class="badge bg-pop-yellow">
                        <span class="fa-solid fa-bolt" aria-hidden="true"></span>
                        <?php esc_html_e('Quick', 'flavor-flavor'); ?>
                    </span>
                    <span class="fa-solid fa-compass" aria-hidden="true"></span>
                </div>

                <div class="mt-4 grid gap-3">
                    <a href="<?php echo esc_url($all_url); ?>"
                       class="btn-physics inline-flex items-center justify-center bg-pop-black text-white px-5 py-3 border-2 border-pop-black shadow-hard-sm font-sans font-black uppercase tracking-tight">
                        <span class="fa-solid fa-list mr-2" aria-hidden="true"></span>
                        <?php echo esc_html($all_text); ?>
                    </a>
                    <a href="<?php echo esc_url($featured_url); ?>"
                       class="btn-physics inline-flex items-center justify-center bg-pop-pink text-black px-5 py-3 border-2 border-pop-black shadow-hard-sm font-sans font-black uppercase tracking-tight">
                        <span class="fa-solid fa-star mr-2" aria-hidden="true"></span>
                        <?php echo esc_html($featured_text); ?>
                    </a>
                    <a href="<?php echo esc_url(get_tag_link(0)); ?>"
                       class="btn-physics inline-flex items-center justify-center bg-white text-black px-5 py-3 border-2 border-pop-black shadow-hard-sm font-sans font-black uppercase tracking-tight">
                        <span class="fa-solid fa-tags mr-2" aria-hidden="true"></span>
                        <?php echo esc_html($tags_text); ?>
                    </a>
                </div>
            </div>
        </section>
        <?php
    }

    /**
     * Render the widget settings form in the admin.
     */
    public function form($instance): void
    {
        $fields = [
            'all_text'      => [__('All Posts Label', 'flavor-flavor'), 'All posts'],
            'all_url'       => [__('All Posts URL (leave blank for blog page)', 'flavor-flavor'), ''],
            'featured_text' => [__('Featured Label', 'flavor-flavor'), 'Featured'],
            'featured_url'  => [__('Featured URL', 'flavor-flavor'), '#'],
            'tags_text'     => [__('Tags Label', 'flavor-flavor'), 'Browse tags'],
        ];

        foreach ($fields as $key => $data) {
            $value = ! empty($instance[$key]) ? $instance[$key] : $data[1];
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id($key)); ?>"><?php echo esc_html($data[0]); ?></label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id($key)); ?>"
                       name="<?php echo esc_attr($this->get_field_name($key)); ?>"
                       type="text" value="<?php echo esc_attr($value); ?>">
            </p>
            <?php
        }
    }

    /**
     * Sanitise and save widget settings.
     */
    public function update($new_instance, $old_instance): array
    {
        $instance = [];
        foreach (['all_text', 'all_url', 'featured_text', 'featured_url', 'tags_text'] as $key) {
            $instance[$key] = sanitize_text_field($new_instance[$key] ?? '');
        }
        return $instance;
    }
}
