<?php

/**
 * Archives Widget
 *
 * @package    Flavor_Flavor
 */

declare(strict_types=1);

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Widget: Archives
 *
 * Displays a monthly archive list with post counts, queried directly
 * via `$wpdb` for accuracy. Each month links to its date archive.
 */
class Flavor_Archives_Widget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'flavor_archives',
            __('Flavor: Archives', 'flavor-flavor'),
            ['description' => __('Monthly archive list in brutalism style with post counts.', 'flavor-flavor')]
        );
    }

    /**
     * Render the widget on the front end.
     */
    public function widget($args, $instance): void
    {
        global $wpdb;

        $limit = ! empty($instance['count']) ? (int) $instance['count'] : 12;

        // Query monthly archives with post counts directly.
        $results = $wpdb->get_results($wpdb->prepare(
            "SELECT YEAR(post_date) AS `year`, MONTH(post_date) AS `month`, COUNT(ID) AS `posts`
             FROM {$wpdb->posts}
             WHERE post_type = 'post' AND post_status = 'publish'
             GROUP BY `year`, `month`
             ORDER BY post_date DESC
             LIMIT %d",
            $limit
        ));

        if (empty($results)) {
            return;
        }

        $colors = ['bg-pop-yellow', 'bg-pop-cyan', 'bg-pop-pink'];
        ?>
        <section class="accordion overflow-hidden">
            <div class="p-5 bg-white">
                <div class="flex items-center justify-between">
                    <span class="badge bg-pop-yellow">
                        <span class="fa-solid fa-calendar-days" aria-hidden="true"></span>
                        <?php esc_html_e('Archives', 'flavor-flavor'); ?>
                    </span>
                    <span class="fa-solid fa-box-archive" aria-hidden="true"></span>
                </div>

                <div class="mt-4 space-y-2">
                    <?php foreach ($results as $i => $row) :
                        $url   = get_month_link($row->year, $row->month);
                        $label = date_i18n('F Y', mktime(0, 0, 0, (int) $row->month, 1, (int) $row->year));
                    ?>
                        <a href="<?php echo esc_url($url); ?>"
                           class="card-physics hard-outline-2 bg-paper p-3 shadow-hard-sm flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="w-8 h-8 hard-outline-2 <?php echo esc_attr($colors[$i % count($colors)]); ?> flex items-center justify-center shadow-hard-sm shrink-0 text-xs"
                                      aria-hidden="true">
                                    <span class="fa-solid fa-calendar"></span>
                                </span>
                                <span class="font-mono font-bold text-sm"><?php echo esc_html($label); ?></span>
                            </div>
                            <span class="badge bg-white"><?php echo (int) $row->posts; ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }

    public function form($instance): void
    {
        $count = ! empty($instance['count']) ? (int) $instance['count'] : 12;
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('count')); ?>">
                <?php esc_html_e('Number of months:', 'flavor-flavor'); ?>
            </label>
            <input class="tiny-text" id="<?php echo esc_attr($this->get_field_id('count')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('count')); ?>"
                   type="number" min="1" max="36" value="<?php echo esc_attr($count); ?>">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance): array
    {
        return [
            'count'      => (int) ($new_instance['count'] ?? 12),
            'show_count' => ! empty($new_instance['show_count']),
        ];
    }
}
