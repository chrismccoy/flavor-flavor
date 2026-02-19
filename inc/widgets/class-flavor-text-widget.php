<?php

/**
 * Text / HTML Widget
 *
 * @package    Flavor_Flavor
 */

declare(strict_types=1);

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Widget: Text / HTML
 *
 * A versatile card for custom text or HTML content with configurable
 * badge title, icon, and colour.
 */
class Flavor_Text_Widget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'flavor_text',
            __('Flavor: Text', 'flavor-flavor'),
            ['description' => __('Custom text or HTML in a brutalism card.', 'flavor-flavor')]
        );
    }

    /**
     * Render the widget on the front end.
     */
    public function widget($args, $instance): void
    {
        $title   = ! empty($instance['title']) ? $instance['title'] : '';
        $content = ! empty($instance['content']) ? $instance['content'] : '';
        $icon    = ! empty($instance['icon']) ? $instance['icon'] : 'fa-solid fa-pen-nib';
        $color   = ! empty($instance['color']) ? $instance['color'] : 'bg-pop-cyan';

        if (empty($content)) {
            return;
        }
        ?>
        <section class="accordion overflow-hidden">
            <div class="p-5 bg-white">
                <?php if ($title) : ?>
                    <div class="flex items-center justify-between">
                        <span class="badge <?php echo esc_attr($color); ?>">
                            <span class="<?php echo esc_attr($icon); ?>" aria-hidden="true"></span>
                            <?php echo esc_html($title); ?>
                        </span>
                    </div>
                <?php endif; ?>

                <div class="<?php echo $title ? 'mt-4' : ''; ?> prose-brutal text-sm">
                    <?php echo wp_kses_post(wpautop($content)); ?>
                </div>
            </div>
        </section>
        <?php
    }

    public function form($instance): void
    {
        $title   = ! empty($instance['title']) ? $instance['title'] : '';
        $content = ! empty($instance['content']) ? $instance['content'] : '';
        $icon    = ! empty($instance['icon']) ? $instance['icon'] : 'fa-solid fa-pen-nib';
        $color   = ! empty($instance['color']) ? $instance['color'] : 'bg-pop-cyan';
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                <?php esc_html_e('Title (badge text):', 'flavor-flavor'); ?>
            </label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>"
                   type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('icon')); ?>">
                <?php esc_html_e('Font Awesome icon class:', 'flavor-flavor'); ?>
            </label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('icon')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('icon')); ?>"
                   type="text" value="<?php echo esc_attr($icon); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('color')); ?>">
                <?php esc_html_e('Badge color class:', 'flavor-flavor'); ?>
            </label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('color')); ?>"
                    name="<?php echo esc_attr($this->get_field_name('color')); ?>">
                <option value="bg-pop-cyan" <?php selected($color, 'bg-pop-cyan'); ?>>Cyan</option>
                <option value="bg-pop-pink" <?php selected($color, 'bg-pop-pink'); ?>>Pink</option>
                <option value="bg-pop-yellow" <?php selected($color, 'bg-pop-yellow'); ?>>Yellow</option>
                <option value="bg-white" <?php selected($color, 'bg-white'); ?>>White</option>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('content')); ?>">
                <?php esc_html_e('Content (HTML allowed):', 'flavor-flavor'); ?>
            </label>
            <textarea class="widefat" rows="8" id="<?php echo esc_attr($this->get_field_id('content')); ?>"
                      name="<?php echo esc_attr($this->get_field_name('content')); ?>"><?php echo esc_textarea($content); ?></textarea>
        </p>
        <?php
    }

    public function update($new_instance, $old_instance): array
    {
        return [
            'title'   => sanitize_text_field($new_instance['title'] ?? ''),
            'icon'    => sanitize_text_field($new_instance['icon'] ?? 'fa-solid fa-pen-nib'),
            'color'   => sanitize_text_field($new_instance['color'] ?? 'bg-pop-cyan'),
            'content' => wp_kses_post($new_instance['content'] ?? ''),
        ];
    }
}
