<?php

/**
 * Social Media Widget
 *
 * @package    Flavor_Flavor
 */

declare(strict_types=1);

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Widget: Social Media Icons
 *
 * Displays icon links to social media profiles. Supports 12 networks
 * (X/Twitter, Facebook, Instagram, YouTube, LinkedIn, GitHub, TikTok,
 * Pinterest, Discord, Twitch, Mastodon, RSS). Each active network is
 * rendered as a brand-coloured button with its Font Awesome icon.
 * An optional "show labels" toggle adds the network name next to the icon.
 */
class Flavor_Social_Media_Widget extends WP_Widget
{
    /**
     * Available social networks with their FA icons and brand colours.
     */
    private static array $networks = [
        'twitter'   => ['label' => 'X / Twitter',  'icon' => 'fa-brands fa-x-twitter',  'color' => 'bg-pop-black text-white'],
        'facebook'  => ['label' => 'Facebook',     'icon' => 'fa-brands fa-facebook-f',  'color' => 'bg-[#1877F2] text-white'],
        'instagram' => ['label' => 'Instagram',    'icon' => 'fa-brands fa-instagram',   'color' => 'bg-pop-pink text-black'],
        'youtube'   => ['label' => 'YouTube',      'icon' => 'fa-brands fa-youtube',     'color' => 'bg-[#FF0000] text-white'],
        'linkedin'  => ['label' => 'LinkedIn',     'icon' => 'fa-brands fa-linkedin-in', 'color' => 'bg-[#0A66C2] text-white'],
        'github'    => ['label' => 'GitHub',       'icon' => 'fa-brands fa-github',      'color' => 'bg-pop-black text-white'],
        'tiktok'    => ['label' => 'TikTok',       'icon' => 'fa-brands fa-tiktok',      'color' => 'bg-pop-cyan text-black'],
        'pinterest' => ['label' => 'Pinterest',    'icon' => 'fa-brands fa-pinterest-p', 'color' => 'bg-[#E60023] text-white'],
        'discord'   => ['label' => 'Discord',      'icon' => 'fa-brands fa-discord',     'color' => 'bg-[#5865F2] text-white'],
        'twitch'    => ['label' => 'Twitch',       'icon' => 'fa-brands fa-twitch',      'color' => 'bg-[#9146FF] text-white'],
        'mastodon'  => ['label' => 'Mastodon',     'icon' => 'fa-brands fa-mastodon',    'color' => 'bg-[#6364FF] text-white'],
        'rss'       => ['label' => 'RSS Feed',     'icon' => 'fa-solid fa-rss',          'color' => 'bg-pop-yellow text-black'],
    ];

    public function __construct()
    {
        parent::__construct(
            'flavor_social_media',
            __('Flavor: Social Media', 'flavor-flavor'),
            ['description' => __('Social media icon links in brutalism style.', 'flavor-flavor')]
        );
    }

    /**
     * Render the widget on the front end.
     */
    public function widget($args, $instance): void
    {
        $show_labels = ! empty($instance['show_labels']);

        // Collect networks that have a URL set.
        $active = [];
        foreach (self::$networks as $key => $net) {
            if (! empty($instance[$key])) {
                $active[$key]        = $net;
                $active[$key]['url'] = $instance[$key];
            }
        }

        if (empty($active)) {
            return;
        }
        ?>
        <section class="accordion overflow-hidden">
            <div class="p-5 bg-white">
                <div class="flex items-center justify-between mb-4">
                    <span class="badge bg-pop-cyan">
                        <span class="fa-solid fa-share-nodes" aria-hidden="true"></span>
                        <?php esc_html_e('Follow', 'flavor-flavor'); ?>
                    </span>
                    <span class="fa-solid fa-heart" aria-hidden="true"></span>
                </div>

                <div class="flex flex-wrap gap-2">
                    <?php foreach ($active as $key => $net) : ?>
                        <a href="<?php echo esc_url($net['url']); ?>"
                           target="_blank"
                           rel="noopener noreferrer me"
                           aria-label="<?php echo esc_attr($net['label']); ?>"
                           class="btn-physics inline-flex items-center justify-center gap-2 <?php echo esc_attr($net['color']); ?> border-2 border-pop-black shadow-hard-sm <?php echo $show_labels ? 'px-4 py-2.5' : 'w-11 h-11'; ?>">
                            <span class="<?php echo esc_attr($net['icon']); ?> text-lg" aria-hidden="true"></span>
                            <?php if ($show_labels) : ?>
                                <span class="font-mono font-bold text-xs uppercase tracking-widest">
                                    <?php echo esc_html($net['label']); ?>
                                </span>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }

    public function form($instance): void
    {
        $show_labels = ! empty($instance['show_labels']);
        ?>
        <p>
            <input class="checkbox" type="checkbox"
                   id="<?php echo esc_attr($this->get_field_id('show_labels')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('show_labels')); ?>"
                   <?php checked($show_labels); ?>>
            <label for="<?php echo esc_attr($this->get_field_id('show_labels')); ?>">
                <?php esc_html_e('Show network names next to icons', 'flavor-flavor'); ?>
            </label>
        </p>
        <hr>
        <p><strong><?php esc_html_e('Enter profile URLs (leave blank to hide):', 'flavor-flavor'); ?></strong></p>
        <?php
        foreach (self::$networks as $key => $net) {
            $value       = ! empty($instance[$key]) ? $instance[$key] : '';
            $placeholder = ('rss' === $key) ? home_url('/feed/') : 'https://';
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id($key)); ?>">
                    <span class="<?php echo esc_attr($net['icon']); ?>" aria-hidden="true"></span>
                    <?php echo esc_html($net['label']); ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id($key)); ?>"
                       name="<?php echo esc_attr($this->get_field_name($key)); ?>"
                       type="url" value="<?php echo esc_attr($value); ?>"
                       placeholder="<?php echo esc_attr($placeholder); ?>">
            </p>
            <?php
        }
    }

    public function update($new_instance, $old_instance): array
    {
        $instance                = [];
        $instance['show_labels'] = ! empty($new_instance['show_labels']);

        foreach (array_keys(self::$networks) as $key) {
            $instance[$key] = esc_url_raw($new_instance[$key] ?? '');
        }

        return $instance;
    }
}
