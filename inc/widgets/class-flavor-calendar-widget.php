<?php

/**
 * Calendar Widget
 *
 * @package    Flavor_Flavor
 */

declare(strict_types=1);

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Widget: Calendar
 *
 * Wraps the WordPress `get_calendar()` output in a styled card.
 * Calendar table and navigation are styled via `app.scss`.
 */
class Flavor_Calendar_Widget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'flavor_calendar',
            __('Flavor: Calendar', 'flavor-flavor'),
            ['description' => __('Displays a post calendar in brutalism style.', 'flavor-flavor')]
        );
    }

    /**
     * Render the widget on the front end.
     */
    public function widget($args, $instance): void
    {
        ?>
        <section class="accordion overflow-hidden">
            <div class="p-5 bg-white">
                <div class="flex items-center justify-between mb-4">
                    <span class="badge bg-pop-yellow">
                        <span class="fa-solid fa-calendar" aria-hidden="true"></span>
                        <?php esc_html_e('Calendar', 'flavor-flavor'); ?>
                    </span>
                    <span class="fa-solid fa-calendar-check" aria-hidden="true"></span>
                </div>

                <div class="flavor-calendar">
                    <?php get_calendar(); ?>
                </div>
            </div>
        </section>
        <?php
    }

    public function form($instance): void
    {
        echo '<p>' . esc_html__('Displays the WordPress post calendar with brutalism styling.', 'flavor-flavor') . '</p>';
    }

    public function update($new_instance, $old_instance): array
    {
        return [];
    }
}
