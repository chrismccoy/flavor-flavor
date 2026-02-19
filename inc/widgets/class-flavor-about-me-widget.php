<?php
/**
 * About Me Widget
 *
 * @package    Flavor_Flavor
 */

declare(strict_types=1);

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Widget: About Me
 */
class Flavor_About_Me_Widget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'flavor_about_me',
            __('Flavor: About Me', 'flavor-flavor'),
            ['description' => __('Author bio card with avatar, name, tagline, and optional button.', 'flavor-flavor')]
        );
    }

    /**
     * Render the widget on the front end.
     */
    public function widget($args, $instance): void
    {
        $name       = ! empty($instance['name'])       ? $instance['name']       : '';
        $tagline    = ! empty($instance['tagline'])     ? $instance['tagline']    : '';
        $bio        = ! empty($instance['bio'])         ? $instance['bio']        : '';
        $avatar_url = ! empty($instance['avatar_url'])  ? $instance['avatar_url'] : '';
        $btn_text   = ! empty($instance['btn_text'])    ? $instance['btn_text']   : '';
        $btn_url    = ! empty($instance['btn_url'])     ? $instance['btn_url']    : '';

        if (empty($name) && empty($bio)) {
            return;
        }
        ?>
        <section class="accordion overflow-hidden">
            <div class="p-5 bg-white">
                <div class="flex items-center justify-between mb-4">
                    <span class="badge bg-pop-pink">
                        <span class="fa-solid fa-user" aria-hidden="true"></span>
                        <?php esc_html_e('About', 'flavor-flavor'); ?>
                    </span>
                    <span class="fa-solid fa-id-card" aria-hidden="true"></span>
                </div>

                <div class="flex flex-col items-center text-center">
                    <?php if ($avatar_url) : ?>
                        <div class="w-24 h-24 hard-outline-2 border-4 border-pop-black shadow-hard-sm overflow-hidden mb-4 bg-paper">
                            <img src="<?php echo esc_url($avatar_url); ?>"
                                 alt="<?php echo esc_attr($name); ?>"
                                 class="w-full h-full object-cover"
                                 loading="lazy">
                        </div>
                    <?php endif; ?>

                    <?php if ($name) : ?>
                        <h3 class="font-sans font-black text-xl uppercase tracking-tight">
                            <?php echo esc_html($name); ?>
                        </h3>
                    <?php endif; ?>

                    <?php if ($tagline) : ?>
                        <span class="badge bg-pop-yellow mt-2">
                            <?php echo esc_html($tagline); ?>
                        </span>
                    <?php endif; ?>

                    <?php if ($bio) : ?>
                        <p class="mt-3 text-sm text-gray-700 font-mono leading-relaxed">
                            <?php echo esc_html($bio); ?>
                        </p>
                    <?php endif; ?>

                    <?php if ($btn_text && $btn_url) : ?>
                        <a href="<?php echo esc_url($btn_url); ?>"
                           class="btn-physics mt-4 inline-flex items-center justify-center gap-2 bg-pop-black text-white px-5 py-3 border-2 border-pop-black shadow-hard-sm font-sans font-black uppercase tracking-tight">
                            <span class="fa-solid fa-arrow-right" aria-hidden="true"></span>
                            <?php echo esc_html($btn_text); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <?php
    }

    public function form($instance): void
    {
        $fields = [
            'name'       => [__('Name', 'flavor-flavor'), ''],
            'tagline'    => [__('Tagline (e.g. "Blogger & Developer")', 'flavor-flavor'), ''],
            'avatar_url' => [__('Avatar Image URL', 'flavor-flavor'), ''],
            'bio'        => [__('Short Bio', 'flavor-flavor'), ''],
            'btn_text'   => [__('Button Text (optional)', 'flavor-flavor'), ''],
            'btn_url'    => [__('Button URL (optional)', 'flavor-flavor'), ''],
        ];

        foreach ($fields as $key => $data) {
            $value = ! empty($instance[$key]) ? $instance[$key] : $data[1];
            if ('bio' === $key) {
                ?>
                <p>
                    <label for="<?php echo esc_attr($this->get_field_id($key)); ?>"><?php echo esc_html($data[0]); ?></label>
                    <textarea class="widefat" rows="4" id="<?php echo esc_attr($this->get_field_id($key)); ?>"
                              name="<?php echo esc_attr($this->get_field_name($key)); ?>"><?php echo esc_textarea($value); ?></textarea>
                </p>
                <?php
            } else {
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
    }

    public function update($new_instance, $old_instance): array
    {
        $instance = [];
        foreach (['name', 'tagline', 'bio', 'btn_text'] as $key) {
            $instance[$key] = sanitize_text_field($new_instance[$key] ?? '');
        }
        $instance['avatar_url'] = esc_url_raw($new_instance['avatar_url'] ?? '');
        $instance['btn_url']    = esc_url_raw($new_instance['btn_url'] ?? '');

        return $instance;
    }
}
