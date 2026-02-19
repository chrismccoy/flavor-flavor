<?php

/**
 * Newsletter Widget
 *
 * @package    Flavor_Flavor
 */

declare(strict_types=1);

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Widget: Newsletter CTA
 *
 * A dark-background email signup box with customisable heading,
 * description, form action URL, and input name attribute.
 */
class Flavor_Newsletter_Widget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'flavor_newsletter',
            __('Flavor: Newsletter', 'flavor-flavor'),
            ['description' => __('Dark newsletter signup box.', 'flavor-flavor')]
        );
    }

    /**
     * Render the widget on the front end.
     */
    public function widget($args, $instance): void
    {
        $heading     = ! empty($instance['heading']) ? $instance['heading'] : __('Get launch notes', 'flavor-flavor');
        $description = ! empty($instance['description']) ? $instance['description'] : __('One short email when a new guide drops. No fluff.', 'flavor-flavor');
        $form_action = ! empty($instance['form_action']) ? $instance['form_action'] : '#';
        $input_name  = ! empty($instance['input_name']) ? $instance['input_name'] : 'email';
        ?>
        <section class="relative">
            <div class="absolute inset-0 bg-pop-black translate-x-2 translate-y-2" aria-hidden="true"></div>

            <div class="relative bg-pop-black border-4 border-pop-black p-5">
                <div class="badge bg-pop-yellow mb-4">
                    <span class="fa-solid fa-envelope-open-text" aria-hidden="true"></span>
                    <?php esc_html_e('Newsletter', 'flavor-flavor'); ?>
                </div>

                <div class="text-white font-sans font-black text-2xl uppercase tracking-tight">
                    <?php echo esc_html($heading); ?>
                </div>

                <p class="mt-2 text-gray-200 text-sm">
                    <?php echo esc_html($description); ?>
                </p>

                <form action="<?php echo esc_url($form_action); ?>" method="post" class="mt-4 flex gap-2">
                    <input type="email" name="<?php echo esc_attr($input_name); ?>"
                           placeholder="<?php esc_attr_e('you@example.com', 'flavor-flavor'); ?>"
                           required
                           class="w-full hard-outline-2 bg-white px-4 py-3 font-mono text-sm focus:outline-none">
                    <button type="submit"
                            class="btn-physics bg-pop-pink text-black px-4 py-3 border-2 border-pop-black shadow-hard-sm font-sans font-black uppercase tracking-tight"
                            aria-label="<?php esc_attr_e('Subscribe', 'flavor-flavor'); ?>">
                        <span class="fa-solid fa-arrow-right"></span>
                    </button>
                </form>

                <div class="mt-4 flex flex-wrap gap-2">
                    <span class="badge bg-white">
                        <span class="fa-solid fa-lock" aria-hidden="true"></span>
                        <?php esc_html_e('No spam', 'flavor-flavor'); ?>
                    </span>
                    <span class="badge bg-white">
                        <span class="fa-solid fa-clock" aria-hidden="true"></span>
                        <?php esc_html_e('2 min read', 'flavor-flavor'); ?>
                    </span>
                </div>
            </div>
        </section>
        <?php
    }

    public function form($instance): void
    {
        $fields = [
            'heading'     => [__('Heading', 'flavor-flavor'), 'Get launch notes'],
            'description' => [__('Description', 'flavor-flavor'), 'One short email when a new guide drops. No fluff.'],
            'form_action' => [__('Form Action URL', 'flavor-flavor'), '#'],
            'input_name'  => [__('Email Input Name Attribute', 'flavor-flavor'), 'email'],
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

    public function update($new_instance, $old_instance): array
    {
        $instance = [];
        foreach (['heading', 'description', 'form_action', 'input_name'] as $key) {
            $instance[$key] = sanitize_text_field($new_instance[$key] ?? '');
        }
        return $instance;
    }
}
