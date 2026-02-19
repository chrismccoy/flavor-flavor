<?php

/**
 * Popular Posts Widget
 *
 * @package    Flavor_Flavor
 */

declare(strict_types=1);

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Widget: Popular Posts
 *
 * Displays posts ranked by the `_flavor_views` meta value. Falls back
 * to the most recent posts when no view data exists yet.
 */
class Flavor_Popular_Posts_Widget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'flavor_popular_posts',
            __('Flavor: Popular Posts', 'flavor-flavor'),
            ['description' => __('Displays popular posts ranked by view count.', 'flavor-flavor')]
        );
    }

    /**
     * Render the widget on the front end.
     */
    public function widget($args, $instance): void
    {
        $count  = ! empty($instance['count']) ? (int) $instance['count'] : 3;
        $colors = ['bg-pop-cyan', 'bg-pop-pink', 'bg-pop-yellow'];

        $posts = get_posts([
            'posts_per_page' => $count,
            'meta_key'       => '_flavor_views',
            'orderby'        => 'meta_value_num',
            'order'          => 'DESC',
        ]);

        // Fallback to recent posts if no views recorded yet.
        if (empty($posts)) {
            $posts = get_posts([
                'posts_per_page' => $count,
                'orderby'        => 'date',
                'order'          => 'DESC',
            ]);
        }

        if (empty($posts)) {
            return;
        }
        ?>
        <section class="accordion overflow-hidden">
            <div class="p-5 bg-white">
                <div class="flex items-center justify-between">
                    <span class="badge bg-pop-yellow">
                        <span class="fa-solid fa-arrow-trend-up" aria-hidden="true"></span>
                        <?php esc_html_e('Popular', 'flavor-flavor'); ?>
                    </span>
                    <span class="fa-solid fa-ranking-star" aria-hidden="true"></span>
                </div>

                <div class="mt-4 space-y-3">
                    <?php foreach ($posts as $i => $post) :
                        $color = $colors[$i % count($colors)];
                        $num   = $i + 1;
                    ?>
                        <a href="<?php echo esc_url(get_permalink($post)); ?>"
                           class="card-physics hard-outline-2 bg-white p-4 shadow-hard-sm block">
                            <div class="flex items-start gap-3">
                                <div class="w-11 h-11 hard-outline-2 <?php echo esc_attr($color); ?> flex items-center justify-center shadow-hard-sm shrink-0"
                                     aria-hidden="true">
                                    <span class="fa-solid fa-<?php echo esc_attr($num); ?>"></span>
                                </div>
                                <div>
                                    <div class="font-mono font-bold leading-snug">
                                        <?php echo esc_html(get_the_title($post)); ?>
                                    </div>
                                    <div class="mt-1 text-xs text-gray-600 font-mono">
                                        <span class="fa-solid fa-calendar-days mr-2"></span><?php echo esc_html(get_the_date('M d, Y', $post)); ?>
                                    </div>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
        wp_reset_postdata();
    }

    public function form($instance): void
    {
        $count = ! empty($instance['count']) ? (int) $instance['count'] : 3;
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('count')); ?>">
                <?php esc_html_e('Number of posts:', 'flavor-flavor'); ?>
            </label>
            <input class="tiny-text" id="<?php echo esc_attr($this->get_field_id('count')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('count')); ?>"
                   type="number" min="1" max="10" value="<?php echo esc_attr($count); ?>">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance): array
    {
        return [
            'count' => (int) ($new_instance['count'] ?? 3),
        ];
    }
}
