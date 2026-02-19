<?php

/**
 * Recent Comments Widget
 *
 * @package    Flavor_Flavor
 */

declare(strict_types=1);

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Widget: Recent Comments
 *
 * Displays approved comments with avatar, author name, excerpt, and
 * the parent post title.
 */
class Flavor_Recent_Comments_Widget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'flavor_recent_comments',
            __('Flavor: Recent Comments', 'flavor-flavor'),
            ['description' => __('Displays recent comments in brutalism style.', 'flavor-flavor')]
        );
    }

    /**
     * Render the widget on the front end.
     */
    public function widget($args, $instance): void
    {
        $count = ! empty($instance['count']) ? (int) $instance['count'] : 5;

        $comments = get_comments([
            'number' => $count,
            'status' => 'approve',
            'type'   => 'comment',
        ]);

        if (empty($comments)) {
            return;
        }

        $colors = ['bg-pop-pink', 'bg-pop-cyan', 'bg-pop-yellow'];
        ?>
        <section class="accordion overflow-hidden">
            <div class="p-5 bg-white">
                <div class="flex items-center justify-between">
                    <span class="badge bg-pop-pink">
                        <span class="fa-solid fa-comments" aria-hidden="true"></span>
                        <?php esc_html_e('Comments', 'flavor-flavor'); ?>
                    </span>
                    <span class="fa-solid fa-message" aria-hidden="true"></span>
                </div>

                <div class="mt-4 space-y-3">
                    <?php foreach ($comments as $i => $comment) :
                        $color   = $colors[$i % count($colors)];
                        $excerpt = wp_trim_words($comment->comment_content, 12, '...');
                    ?>
                        <a href="<?php echo esc_url(get_comment_link($comment)); ?>"
                           class="card-physics hard-outline-2 bg-white p-4 shadow-hard-sm block">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 hard-outline-2 <?php echo esc_attr($color); ?> flex items-center justify-center shadow-hard-sm shrink-0 overflow-hidden">
                                    <?php echo get_avatar($comment, 40, '', '', ['class' => 'w-full h-full object-cover']); ?>
                                </div>
                                <div class="min-w-0">
                                    <div class="font-mono font-bold text-sm leading-snug">
                                        <?php echo esc_html($comment->comment_author); ?>
                                    </div>
                                    <div class="mt-1 text-xs text-gray-600 font-mono truncate">
                                        <?php echo esc_html($excerpt); ?>
                                    </div>
                                    <div class="mt-1 text-xs text-gray-400 font-mono">
                                        <span class="fa-solid fa-reply mr-1" aria-hidden="true"></span>
                                        <?php echo esc_html(get_the_title($comment->comment_post_ID)); ?>
                                    </div>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }

    public function form($instance): void
    {
        $count = ! empty($instance['count']) ? (int) $instance['count'] : 5;
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('count')); ?>">
                <?php esc_html_e('Number of comments:', 'flavor-flavor'); ?>
            </label>
            <input class="tiny-text" id="<?php echo esc_attr($this->get_field_id('count')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('count')); ?>"
                   type="number" min="1" max="15" value="<?php echo esc_attr($count); ?>">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance): array
    {
        return [
            'count' => (int) ($new_instance['count'] ?? 5),
        ];
    }
}
