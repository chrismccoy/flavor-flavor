<?php
/**
 * Sidebar Template
 *
 * @package    Flavor_Flavor
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
    // Render default widgets if no widgets assigned.
    ?>
    <aside class="lg:col-span-4 lg:sticky lg:top-28 space-y-6">
        <?php
        the_widget( 'Flavor_Search_Widget', array(), array(
            'before_widget' => '',
            'after_widget'  => '',
        ) );
        the_widget( 'Flavor_Categories_Widget', array( 'max_categories' => 4 ), array(
            'before_widget' => '',
            'after_widget'  => '',
        ) );
        the_widget( 'Flavor_Popular_Posts_Widget', array( 'count' => 3 ), array(
            'before_widget' => '',
            'after_widget'  => '',
        ) );
        the_widget( 'Flavor_Newsletter_Widget', array(), array(
            'before_widget' => '',
            'after_widget'  => '',
        ) );
        ?>
    </aside>
    <?php
    return;
}
?>
<aside class="lg:col-span-4 lg:sticky lg:top-28 space-y-6">
    <?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside>
