<?php

/**
 * Categories Widget
 *
 * @package    Flavor_Flavor
 */

declare(strict_types=1);

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Widget: Categories with Counts
 *
 * Lists the top categories sorted by post count, each rendered as a
 * clickable card with an icon and count badge.
 */
class Flavor_Categories_Widget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'flavor_categories',
            __('Flavor: Categories', 'flavor-flavor'),
            ['description' => __('Displays categories with brutalism card style and post counts.', 'flavor-flavor')]
        );
    }

    /**
     * Render the widget on the front end.
     */
    public function widget($args, $instance): void
    {
        $max = ! empty($instance['max_categories']) ? (int) $instance['max_categories'] : 6;

        $icon_map = [
            'launch' => 'fa-solid fa-rocket',
            'seo'    => 'fa-solid fa-magnifying-glass-chart',
            'admin'  => 'fa-solid fa-screwdriver-wrench',
            'themes' => 'fa-solid fa-palette',
            'setup'  => 'fa-solid fa-gear',
            'tips'   => 'fa-solid fa-wand-magic-sparkles',
            'design' => 'fa-solid fa-paintbrush',
        ];
        $default_icon = 'fa-solid fa-folder-open';

        $categories = get_categories([
            'number'     => $max,
            'orderby'    => 'count',
            'order'      => 'DESC',
            'hide_empty' => true,
        ]);

        if (empty($categories)) {
            return;
        }
        ?>
        <section class="accordion overflow-hidden">
            <div class="p-5 bg-white">
                <div class="flex items-center justify-between">
                    <span class="badge bg-pop-pink">
                        <span class="fa-solid fa-layer-group" aria-hidden="true"></span>
                        <?php esc_html_e('Categories', 'flavor-flavor'); ?>
                    </span>
                    <span class="fa-solid fa-grip" aria-hidden="true"></span>
                </div>

                <div class="mt-4 space-y-3">
                    <?php foreach ($categories as $cat) :
                        $slug = strtolower($cat->slug);
                        $icon = $icon_map[$slug] ?? $default_icon;
                    ?>
                        <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>"
                           class="card-physics hard-outline-2 bg-paper p-4 shadow-hard-sm block">
                            <div class="flex items-center justify-between gap-3">
                                <div class="font-mono font-bold">
                                    <span class="<?php echo esc_attr($icon); ?> mr-2" aria-hidden="true"></span>
                                    <?php echo esc_html($cat->name); ?>
                                </div>
                                <span class="badge bg-white"><?php echo (int) $cat->count; ?></span>
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
        $max = ! empty($instance['max_categories']) ? (int) $instance['max_categories'] : 6;
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('max_categories')); ?>">
                <?php esc_html_e('Max categories to show:', 'flavor-flavor'); ?>
            </label>
            <input class="tiny-text" id="<?php echo esc_attr($this->get_field_id('max_categories')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('max_categories')); ?>"
                   type="number" min="1" max="20" value="<?php echo esc_attr($max); ?>">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance): array
    {
        return [
            'max_categories' => (int) ($new_instance['max_categories'] ?? 6),
        ];
    }
}
