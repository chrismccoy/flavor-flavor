<?php

/**
 * Recent Posts Widget
 *
 * @package    Flavor_Flavor
 */

declare(strict_types=1);

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Widget: Recent Posts
 *
 * Displays the latest published posts with optional date display
 * and the ability to exclude the currently viewed post.
 */
class Flavor_Recent_Posts_Widget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'flavor_recent_posts',
            __('Flavor: Recent Posts', 'flavor-flavor'),
            ['description' => __('Displays the most recent posts in brutalism card style.', 'flavor-flavor')]
        );
    }

    /**
     * Render the widget on the front end.
     */
    public function widget($args, $instance): void
    {
        $count           = ! empty($instance['count']) ? (int) $instance['count'] : 5;
        $show_date       = isset($instance['show_date']) ? (bool) $instance['show_date'] : true;
        $exclude_current = isset($instance['exclude_current']) ? (bool) $instance['exclude_current'] : true;
        $colors          = ['bg-pop-cyan', 'bg-pop-pink', 'bg-pop-yellow'];

        $query_args = [
            'posts_per_page' => $count,
            'orderby'        => 'date',
            'order'          => 'DESC',
            'post_status'    => 'publish',
        ];

        // Exclude the current post when on a single post page.
        if ($exclude_current && is_singular('post')) {
            $query_args['post__not_in'] = [get_the_ID()];
        }

        $posts = get_posts($query_args);

        if (empty($posts)) {
            return;
        }
        ?>
        <section class="accordion overflow-hidden">
            <div class="p-5 bg-white">
                <div class="flex items-center justify-between">
                    <span class="badge bg-pop-cyan">
                        <span class="fa-solid fa-clock-rotate-left" aria-hidden="true"></span>
                        <?php esc_html_e('Recent', 'flavor-flavor'); ?>
                    </span>
                    <span class="fa-solid fa-rss" aria-hidden="true"></span>
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
                                    <?php if ($show_date) : ?>
                                        <div class="mt-1 text-xs text-gray-600 font-mono">
                                            <span class="fa-solid fa-calendar-days mr-2"></span><?php echo esc_html(get_the_date('M d, Y', $post)); ?>
                                        </div>
                                    <?php endif; ?>
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
        $count           = ! empty($instance['count']) ? (int) $instance['count'] : 5;
        $show_date       = isset($instance['show_date']) ? (bool) $instance['show_date'] : true;
        $exclude_current = isset($instance['exclude_current']) ? (bool) $instance['exclude_current'] : true;
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('count')); ?>">
                <?php esc_html_e('Number of posts:', 'flavor-flavor'); ?>
            </label>
            <input class="tiny-text" id="<?php echo esc_attr($this->get_field_id('count')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('count')); ?>"
                   type="number" min="1" max="15" value="<?php echo esc_attr($count); ?>">
        </p>
        <p>
            <input class="checkbox" type="checkbox"
                   id="<?php echo esc_attr($this->get_field_id('show_date')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('show_date')); ?>"
                   <?php checked($show_date); ?>>
            <label for="<?php echo esc_attr($this->get_field_id('show_date')); ?>">
                <?php esc_html_e('Show post date', 'flavor-flavor'); ?>
            </label>
        </p>
        <p>
            <input class="checkbox" type="checkbox"
                   id="<?php echo esc_attr($this->get_field_id('exclude_current')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('exclude_current')); ?>"
                   <?php checked($exclude_current); ?>>
            <label for="<?php echo esc_attr($this->get_field_id('exclude_current')); ?>">
                <?php esc_html_e('Exclude current post on single pages', 'flavor-flavor'); ?>
            </label>
        </p>
        <?php
    }

    public function update($new_instance, $old_instance): array
    {
        return [
            'count'           => (int) ($new_instance['count'] ?? 5),
            'show_date'       => ! empty($new_instance['show_date']),
            'exclude_current' => ! empty($new_instance['exclude_current']),
        ];
    }
}
