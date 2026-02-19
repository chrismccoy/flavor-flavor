<?php

/**
 * Search Widget
 *
 * @package    Flavor_Flavor
 */

declare(strict_types=1);

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Widget: Brutalism Search
 *
 * Displays a search form styled with hard outlines, a keyboard icon,
 * and a yellow submit button.
 */
class Flavor_Search_Widget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'flavor_search',
            __('Flavor: Search', 'flavor-flavor'),
            ['description' => __('Brutalism-styled search form.', 'flavor-flavor')]
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
                <div class="flex items-center justify-between gap-3">
                    <span class="badge bg-pop-cyan">
                        <span class="fa-solid fa-magnifying-glass" aria-hidden="true"></span>
                        <?php esc_html_e('Search', 'flavor-flavor'); ?>
                    </span>
                    <span class="fa-solid fa-sliders" aria-hidden="true"></span>
                </div>

                <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="mt-4">
                    <label class="font-mono uppercase tracking-widest text-xs font-bold">
                        <span class="fa-solid fa-keyboard mr-2" aria-hidden="true"></span>
                        <?php esc_html_e('Find a post', 'flavor-flavor'); ?>
                    </label>
                    <div class="mt-2 flex gap-2">
                        <input type="search" name="s" placeholder="<?php esc_attr_e('Search blog...', 'flavor-flavor'); ?>"
                               value=""
                               class="w-full hard-outline-2 bg-white px-4 py-3 font-mono text-sm focus:outline-none">
                        <button type="submit"
                                class="btn-physics hard-outline-2 bg-pop-yellow px-4 py-3 shadow-hard-sm"
                                aria-label="<?php esc_attr_e('Search', 'flavor-flavor'); ?>">
                            <span class="fa-solid fa-arrow-right"></span>
                        </button>
                    </div>
                </form>
            </div>
        </section>
        <?php
    }

    public function form($instance): void
    {
        echo '<p>' . esc_html__('No settings. Displays a brutalism-styled search form.', 'flavor-flavor') . '</p>';
    }

    public function update($new_instance, $old_instance): array
    {
        return [];
    }
}
