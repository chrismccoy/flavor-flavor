<?php
/**
 * Custom Comment Walker for the Flavor Flavor theme.
 *
 * @package    Flavor_Flavor
 */

declare(strict_types=1);

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Class Flavor_Walker_Comment
 */
class Flavor_Walker_Comment extends Walker_Comment
{
    /**
     * Accent colours that rotate by comment depth.
     */
    private array $accent_colors = [
        'bg-pop-cyan',
        'bg-pop-pink',
        'bg-pop-yellow',
    ];

    /**
     * Output a comment in the HTML5 format.
     */
    protected function html5_comment($comment, $depth, $args): void
    {
        $tag       = ('div' === $args['style']) ? 'div' : 'li';
        $commenter = wp_get_current_commenter();
        $is_author = ($comment->user_id === get_the_author_meta('ID'));
        $accent    = $this->accent_colors[($depth - 1) % count($this->accent_colors)];

        // Indent nested replies visually.
        $indent_class = ($depth > 1) ? 'ml-6 md:ml-10' : '';
        ?>
        <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class($indent_class . ' mb-4'); ?>>
            <div class="hard-outline-2 bg-white p-4 md:p-5 shadow-hard-sm">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 md:w-12 md:h-12 hard-outline-2 <?php echo esc_attr($accent); ?> shadow-hard-sm shrink-0 rounded-full overflow-hidden">
                        <?php echo get_avatar($comment, 48, '', '', ['class' => 'w-full h-full object-cover']); ?>
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="font-mono font-bold text-sm truncate">
                                <?php
                                $author_url = get_comment_author_url($comment);
                                if ($author_url && '#' !== $author_url) {
                                    printf(
                                        '<a href="%s" class="link-underline" rel="external nofollow">%s</a>',
                                        esc_url($author_url),
                                        esc_html(get_comment_author($comment))
                                    );
                                } else {
                                    echo esc_html(get_comment_author($comment));
                                }
                                ?>
                            </span>

                            <?php if ($is_author) : ?>
                                <span class="badge bg-pop-yellow text-[10px]">
                                    <span class="fa-solid fa-pen-nib" aria-hidden="true"></span>
                                    <?php esc_html_e('Author', 'flavor-flavor'); ?>
                                </span>
                            <?php endif; ?>

                            <span class="badge bg-white text-[10px]">
                                <span class="fa-solid fa-calendar-days" aria-hidden="true"></span>
                                <time datetime="<?php echo esc_attr(get_comment_date('c', $comment)); ?>">
                                    <?php echo esc_html(get_comment_date('M d, Y', $comment)); ?>
                                </time>
                            </span>

                            <span class="badge bg-white text-[10px]">
                                <span class="fa-solid fa-clock" aria-hidden="true"></span>
                                <?php echo esc_html(get_comment_date('g:i a', $comment)); ?>
                            </span>
                        </div>

                        <?php if ('0' === $comment->comment_approved) : ?>
                            <div class="mt-2">
                                <span class="badge bg-pop-pink">
                                    <span class="fa-solid fa-hourglass-half" aria-hidden="true"></span>
                                    <?php esc_html_e('Awaiting moderation', 'flavor-flavor'); ?>
                                </span>
                            </div>
                        <?php endif; ?>

                        <div class="mt-3 text-sm md:text-base text-gray-700 leading-relaxed">
                            <?php comment_text($comment); ?>
                        </div>

                        <div class="mt-3 flex flex-wrap items-center gap-2">
                            <?php
                            comment_reply_link(array_merge($args, [
                                'add_below'  => 'comment',
                                'depth'      => $depth,
                                'max_depth'  => $args['max_depth'],
                                'before'     => '',
                                'after'      => '',
                                'reply_text' => '<span class="badge bg-pop-yellow cursor-pointer"><span class="fa-solid fa-reply mr-1" aria-hidden="true"></span>' . esc_html__('Reply', 'flavor-flavor') . '</span>',
                            ]));
                            ?>

                            <?php edit_comment_link(
                                '<span class="badge bg-paper cursor-pointer"><span class="fa-solid fa-pen mr-1" aria-hidden="true"></span>' . esc_html__('Edit', 'flavor-flavor') . '</span>',
                                '',
                                ''
                            ); ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        // Walker_Comment handles closing tags for nested comments.
    }

    /**
     * Output a pingback or trackback comment.
     */
    protected function ping($comment, $depth, $args): void
    {
        $tag = ('div' === $args['style']) ? 'div' : 'li';
        ?>
        <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class('mb-4'); ?>>
            <div class="hard-outline-2 bg-paper p-4 shadow-hard-sm">
                <div class="flex items-center gap-3">
                    <span class="badge bg-white">
                        <span class="fa-solid fa-link" aria-hidden="true"></span>
                        <?php esc_html_e('Pingback', 'flavor-flavor'); ?>
                    </span>
                    <span class="font-mono text-sm truncate">
                        <?php comment_author_link($comment); ?>
                    </span>
                    <?php edit_comment_link(
                        '<span class="badge bg-paper cursor-pointer text-[10px]"><span class="fa-solid fa-pen mr-1" aria-hidden="true"></span>' . esc_html__('Edit', 'flavor-flavor') . '</span>',
                        '',
                        ''
                    ); ?>
                </div>
            </div>
        <?php
    }
}
