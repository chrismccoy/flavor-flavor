<?php

/**
 * Pages Widget
 *
 * @package    Flavor_Flavor
 */

declare(strict_types=1);

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Widget: Pages List
 *
 * Lists WordPress pages with configurable sort order, page exclusion,
 * and an option to exclude the currently viewed page. The active page
 * is highlighted with an inverted colour scheme.
 */
class Flavor_Pages_Widget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'flavor_pages',
            __('Flavor: Pages', 'flavor-flavor'),
            ['description' => __('Displays a list of pages in brutalism style.', 'flavor-flavor')]
        );
    }

    /**
     * Render the widget on the front end.
     */
    public function widget($args, $instance): void
    {
        $sort_by         = ! empty($instance['sort_by']) ? $instance['sort_by'] : 'menu_order';
        $exclude         = ! empty($instance['exclude']) ? $instance['exclude'] : '';
        $exclude_current = isset($instance['exclude_current']) ? (bool) $instance['exclude_current'] : false;

        // Merge manual excludes with the current page if option is enabled.
        $exclude_ids = array_filter(array_map('intval', explode(',', $exclude)));
        if ($exclude_current && is_page()) {
            $exclude_ids[] = get_queried_object_id();
        }

        $pages = get_pages([
            'sort_column' => $sort_by,
            'exclude'     => $exclude_ids,
        ]);

        if (empty($pages)) {
            return;
        }

        $colors = ['bg-pop-cyan', 'bg-pop-pink', 'bg-pop-yellow'];
        ?>
        <section class="accordion overflow-hidden">
            <div class="p-5 bg-white">
                <div class="flex items-center justify-between">
                    <span class="badge bg-pop-cyan">
                        <span class="fa-solid fa-file-lines" aria-hidden="true"></span>
                        <?php esc_html_e('Pages', 'flavor-flavor'); ?>
                    </span>
                    <span class="fa-solid fa-sitemap" aria-hidden="true"></span>
                </div>

                <div class="mt-4 space-y-2">
                    <?php foreach ($pages as $i => $page) :
                        $is_current = is_page($page->ID);
                    ?>
                        <a href="<?php echo esc_url(get_page_link($page->ID)); ?>"
                           class="card-physics hard-outline-2 <?php echo $is_current ? 'bg-pop-black text-white' : 'bg-paper'; ?> p-3 shadow-hard-sm block">
                            <div class="flex items-center gap-3">
                                <span class="w-8 h-8 hard-outline-2 <?php echo esc_attr($colors[$i % count($colors)]); ?> flex items-center justify-center shadow-hard-sm shrink-0 text-xs"
                                      aria-hidden="true">
                                    <span class="fa-solid fa-file"></span>
                                </span>
                                <span class="font-mono font-bold text-sm">
                                    <?php echo esc_html($page->post_title); ?>
                                </span>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }

    public function form($instance): void
    {
        $sort_by         = ! empty($instance['sort_by']) ? $instance['sort_by'] : 'menu_order';
        $exclude         = ! empty($instance['exclude']) ? $instance['exclude'] : '';
        $exclude_current = isset($instance['exclude_current']) ? (bool) $instance['exclude_current'] : false;
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('sort_by')); ?>">
                <?php esc_html_e('Sort by:', 'flavor-flavor'); ?>
            </label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('sort_by')); ?>"
                    name="<?php echo esc_attr($this->get_field_name('sort_by')); ?>">
                <option value="menu_order" <?php selected($sort_by, 'menu_order'); ?>><?php esc_html_e('Page order', 'flavor-flavor'); ?></option>
                <option value="post_title" <?php selected($sort_by, 'post_title'); ?>><?php esc_html_e('Title', 'flavor-flavor'); ?></option>
                <option value="post_date" <?php selected($sort_by, 'post_date'); ?>><?php esc_html_e('Date', 'flavor-flavor'); ?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('exclude')); ?>">
                <?php esc_html_e('Exclude page IDs (comma-separated):', 'flavor-flavor'); ?>
            </label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('exclude')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('exclude')); ?>"
                   type="text" value="<?php echo esc_attr($exclude); ?>">
        </p>
        <p>
            <input class="checkbox" type="checkbox"
                   id="<?php echo esc_attr($this->get_field_id('exclude_current')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('exclude_current')); ?>"
                   <?php checked($exclude_current); ?>>
            <label for="<?php echo esc_attr($this->get_field_id('exclude_current')); ?>">
                <?php esc_html_e('Exclude current page when viewing a page', 'flavor-flavor'); ?>
            </label>
        </p>
        <?php
    }

    public function update($new_instance, $old_instance): array
    {
        return [
            'sort_by'         => sanitize_text_field($new_instance['sort_by'] ?? 'menu_order'),
            'exclude'         => sanitize_text_field($new_instance['exclude'] ?? ''),
            'exclude_current' => ! empty($new_instance['exclude_current']),
        ];
    }
}
