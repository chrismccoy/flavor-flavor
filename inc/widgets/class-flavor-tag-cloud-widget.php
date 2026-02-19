<?php

/**
 * Tag Cloud Widget
 *
 * @package    Flavor_Flavor
 */

declare(strict_types=1);

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Widget: Tag Cloud
 *
 * Renders tags as a cloud with font sizes proportional to usage count.
 * Tags are shuffled for a natural look and display their post count.
 */
class Flavor_Tag_Cloud_Widget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'flavor_tag_cloud',
            __('Flavor: Tag Cloud', 'flavor-flavor'),
            ['description' => __('Displays tags as a cloud with sizes based on usage.', 'flavor-flavor')]
        );
    }

    /**
     * Render the widget on the front end.
     */
    public function widget($args, $instance): void
    {
        $max_tags = ! empty($instance['max_tags']) ? (int) $instance['max_tags'] : 20;
        $min_size = 0.75;
        $max_size = 1.5;

        $tags = get_tags([
            'number'     => $max_tags,
            'orderby'    => 'count',
            'order'      => 'DESC',
            'hide_empty' => true,
        ]);

        if (empty($tags)) {
            return;
        }

        $counts    = wp_list_pluck($tags, 'count');
        $min_count = max(1, min($counts));
        $max_count = max($counts);
        $spread    = max(1, $max_count - $min_count);

        // Shuffle for a natural cloud look.
        shuffle($tags);

        $colors = ['bg-white', 'bg-pop-cyan', 'bg-pop-pink', 'bg-pop-yellow'];
        ?>
        <section class="accordion overflow-hidden">
            <div class="p-5 bg-white">
                <div class="flex items-center justify-between">
                    <span class="badge bg-pop-yellow">
                        <span class="fa-solid fa-tags" aria-hidden="true"></span>
                        <?php esc_html_e('Tags', 'flavor-flavor'); ?>
                    </span>
                    <span class="fa-solid fa-cloud" aria-hidden="true"></span>
                </div>

                <div class="mt-4 flex flex-wrap gap-2">
                    <?php foreach ($tags as $i => $tag) :
                        $size  = $min_size + (($tag->count - $min_count) / $spread) * ($max_size - $min_size);
                        $color = $colors[$i % count($colors)];
                    ?>
                        <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>"
                           class="badge <?php echo esc_attr($color); ?> transition-transform hover:scale-110"
                           style="font-size: <?php echo esc_attr(round($size, 2)); ?>rem">
                            <?php echo esc_html($tag->name); ?>
                            <span class="text-gray-500" style="font-size: 0.65rem"><?php echo (int) $tag->count; ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }

    public function form($instance): void
    {
        $max_tags = ! empty($instance['max_tags']) ? (int) $instance['max_tags'] : 20;
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('max_tags')); ?>">
                <?php esc_html_e('Max tags to show:', 'flavor-flavor'); ?>
            </label>
            <input class="tiny-text" id="<?php echo esc_attr($this->get_field_id('max_tags')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('max_tags')); ?>"
                   type="number" min="5" max="50" value="<?php echo esc_attr($max_tags); ?>">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance): array
    {
        return [
            'max_tags' => (int) ($new_instance['max_tags'] ?? 20),
        ];
    }
}
