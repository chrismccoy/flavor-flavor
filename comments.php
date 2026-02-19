<?php
/**
 * Comments Template
 *
 * @package    Flavor_Flavor
 */

if ( post_password_required() ) {
    return;
}
?>

<section id="comments" class="mt-6">

    <?php if ( have_comments() ) : ?>
        <div class="relative mb-6">
            <div class="absolute inset-0 bg-pop-black translate-x-2 translate-y-2" aria-hidden="true"></div>

            <div class="relative accordion overflow-hidden">
                <div class="p-6 md:p-8 bg-white">

                    <div class="flex items-center justify-between gap-3 mb-6">
                        <span class="badge bg-pop-cyan">
                            <span class="fa-solid fa-comments" aria-hidden="true"></span>
                            <?php
                            printf(
                                esc_html( _n( '%d Comment', '%d Comments', get_comments_number(), 'flavor-flavor' ) ),
                                get_comments_number()
                            );
                            ?>
                        </span>
                        <span class="badge bg-white">
                            <span class="fa-solid fa-message" aria-hidden="true"></span>
                            <?php esc_html_e( 'Discussion', 'flavor-flavor' ); ?>
                        </span>
                    </div>

                    <ol class="space-y-4 list-none p-0 m-0">
                        <?php
                        wp_list_comments( array(
                            'style'       => 'ol',
                            'short_ping'  => true,
                            'walker'      => new Flavor_Walker_Comment(),
                            'avatar_size' => 48,
                        ) );
                        ?>
                    </ol>

                    <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
                        <nav class="mt-6 pt-4 soft-divider" aria-label="<?php esc_attr_e( 'Comments pagination', 'flavor-flavor' ); ?>">
                            <div class="flex flex-col sm:flex-row gap-3">
                                <?php if ( get_previous_comments_link() ) : ?>
                                    <span class="btn-physics inline-flex items-center justify-center bg-white text-black px-5 py-2 border-2 border-pop-black shadow-hard-sm font-sans font-black uppercase tracking-tight text-sm">
                                        <?php previous_comments_link( '<span class="fa-solid fa-arrow-left mr-2"></span>' . esc_html__( 'Older comments', 'flavor-flavor' ) ); ?>
                                    </span>
                                <?php endif; ?>

                                <?php if ( get_next_comments_link() ) : ?>
                                    <span class="btn-physics inline-flex items-center justify-center bg-pop-black text-white px-5 py-2 border-2 border-pop-black shadow-hard-sm font-sans font-black uppercase tracking-tight text-sm">
                                        <?php next_comments_link( esc_html__( 'Newer comments', 'flavor-flavor' ) . '<span class="fa-solid fa-arrow-right ml-2"></span>' ); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </nav>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    <?php endif; ?>


    <?php if ( comments_open() ) : ?>
        <div class="relative">
            <div class="absolute inset-0 bg-pop-black translate-x-2 translate-y-2" aria-hidden="true"></div>

            <div class="relative accordion overflow-hidden">
                <div class="p-6 md:p-8 bg-white">

                    <?php
                    // Input field class string
                    $field_class = 'w-full hard-outline-2 bg-white px-4 py-3 font-mono text-sm focus:outline-none focus:border-pop-cyan';

                    comment_form( array(

                        // Heading
                        'title_reply_before' => '<div class="flex items-center gap-3 mb-6"><span class="badge bg-pop-pink"><span class="fa-solid fa-pen-to-square" aria-hidden="true"></span>',
                        'title_reply'        => esc_html__( 'Leave a comment', 'flavor-flavor' ),
                        'title_reply_after'  => '</span></div>',
                        'title_reply_to'     => esc_html__( 'Reply to %s', 'flavor-flavor' ),

                        'cancel_reply_before' => ' ',
                        'cancel_reply_after'  => '',
                        'cancel_reply_link'   => '<span class="badge bg-pop-yellow cursor-pointer"><span class="fa-solid fa-xmark mr-1" aria-hidden="true"></span>' . esc_html__( 'Cancel', 'flavor-flavor' ) . '</span>',

                        // Logged-in notice
                        'logged_in_as' => sprintf(
                            '<div class="mb-4"><span class="badge bg-pop-cyan"><span class="fa-solid fa-user-check mr-1" aria-hidden="true"></span>%s</span> <a href="%s" class="badge bg-white cursor-pointer ml-2"><span class="fa-solid fa-right-from-bracket mr-1" aria-hidden="true"></span>%s</a></div>',
                            sprintf( esc_html__( 'Logged in as %s', 'flavor-flavor' ), esc_html( wp_get_current_user()->display_name ) ),
                            esc_url( wp_logout_url( get_permalink() ) ),
                            esc_html__( 'Log out', 'flavor-flavor' )
                        ),

                        // Field wrappers
                        'comment_notes_before' => '<p class="text-sm text-gray-600 font-mono mb-4"><span class="fa-solid fa-circle-info mr-2" aria-hidden="true"></span>' . esc_html__( 'Your email address will not be published. Required fields are marked *', 'flavor-flavor' ) . '</p>',
                        'comment_notes_after'  => '',

                        // Author / email / URL fields
                        'fields' => array(
                            'author' => sprintf(
                                '<div class="mb-4">' .
                                '<label for="author" class="font-mono uppercase tracking-widest text-xs font-bold block mb-2">' .
                                '<span class="fa-solid fa-user mr-2" aria-hidden="true"></span>%s <span class="text-pop-pink">*</span>' .
                                '</label>' .
                                '<input id="author" name="author" type="text" value="%s" required class="%s" placeholder="%s" />' .
                                '</div>',
                                esc_html__( 'Name', 'flavor-flavor' ),
                                esc_attr( $commenter['comment_author'] ?? '' ),
                                esc_attr( $field_class ),
                                esc_attr__( 'Your name', 'flavor-flavor' )
                            ),
                            'email' => sprintf(
                                '<div class="mb-4">' .
                                '<label for="email" class="font-mono uppercase tracking-widest text-xs font-bold block mb-2">' .
                                '<span class="fa-solid fa-envelope mr-2" aria-hidden="true"></span>%s <span class="text-pop-pink">*</span>' .
                                '</label>' .
                                '<input id="email" name="email" type="email" value="%s" required class="%s" placeholder="%s" />' .
                                '</div>',
                                esc_html__( 'Email', 'flavor-flavor' ),
                                esc_attr( $commenter['comment_author_email'] ?? '' ),
                                esc_attr( $field_class ),
                                esc_attr__( 'you@example.com', 'flavor-flavor' )
                            ),
                            'url' => sprintf(
                                '<div class="mb-4">' .
                                '<label for="url" class="font-mono uppercase tracking-widest text-xs font-bold block mb-2">' .
                                '<span class="fa-solid fa-globe mr-2" aria-hidden="true"></span>%s' .
                                '</label>' .
                                '<input id="url" name="url" type="url" value="%s" class="%s" placeholder="%s" />' .
                                '</div>',
                                esc_html__( 'Website', 'flavor-flavor' ),
                                esc_attr( $commenter['comment_author_url'] ?? '' ),
                                esc_attr( $field_class ),
                                esc_attr__( 'https://', 'flavor-flavor' )
                            ),
                            'cookies' => sprintf(
                                '<div class="mb-4">' .
                                '<label for="wp-comment-cookies-consent" class="flex items-center gap-2 font-mono text-xs text-gray-600 cursor-pointer">' .
                                '<input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes" class="hard-outline-2 w-5 h-5 accent-pop-cyan" %s />' .
                                '%s' .
                                '</label>' .
                                '</div>',
                                empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"',
                                esc_html__( 'Save my name, email, and website in this browser for the next time I comment.', 'flavor-flavor' )
                            ),
                        ),

                        // Comment textarea
                        'comment_field' => sprintf(
                            '<div class="mb-4">' .
                            '<label for="comment" class="font-mono uppercase tracking-widest text-xs font-bold block mb-2">' .
                            '<span class="fa-solid fa-comment-dots mr-2" aria-hidden="true"></span>%s <span class="text-pop-pink">*</span>' .
                            '</label>' .
                            '<textarea id="comment" name="comment" rows="6" required class="%s resize-y" placeholder="%s"></textarea>' .
                            '</div>',
                            esc_html__( 'Comment', 'flavor-flavor' ),
                            esc_attr( $field_class ),
                            esc_attr__( 'Write your comment here...', 'flavor-flavor' )
                        ),

                        // Submit button
                        'class_form'   => 'flavor-comment-form',
                        'class_submit' => 'btn-physics inline-flex items-center justify-center bg-pop-black text-white px-6 py-3 border-2 border-pop-black shadow-hard-sm font-sans font-black uppercase tracking-tight cursor-pointer',
                        'label_submit' => esc_html__( 'Post Comment', 'flavor-flavor' ),

                        'submit_button' => '<button name="%1$s" type="submit" id="%2$s" class="%3$s"><span class="fa-solid fa-paper-plane mr-2"></span>%4$s</button>',
                        'submit_field'  => '<div class="flex flex-col sm:flex-row items-start gap-3">%1$s %2$s</div>',
                    ) );
                    ?>

                </div>
            </div>
        </div>
    <?php elseif ( ! comments_open() && get_comments_number() ) : ?>
        <div class="mt-6 accordion overflow-hidden p-5">
            <span class="badge bg-paper">
                <span class="fa-solid fa-lock" aria-hidden="true"></span>
                <?php esc_html_e( 'Comments are closed.', 'flavor-flavor' ); ?>
            </span>
        </div>
    <?php endif; ?>

</section>
