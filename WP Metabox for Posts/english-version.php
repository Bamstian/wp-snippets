<?php //DO NOT COPY THIS LINE INTO YOUR functions.php
/**
 * Own metafield "REPLACE_THIS_TITLE" for posts.
 */
function hm_own_metabox_posts()
{
    add_meta_box(
        'hm_your_meta_box',
        __('REPLACE_THIS_TITLE', 'textdomain'), // Replace textdomain with "Text Domain" of your Child-Theme (located in styles.css)
        'hm_your_meta_box_render',
        'post',
        'normal',
        'high'
    );
}

function hm_your_meta_box_render($post)
{
    // Feteches data
    $hm_meta_box = get_post_meta($post->ID, 'hm_metabox', true);
    // WYSIWYG-Editor
    wp_nonce_field(basename(__FILE__), 'hm_your_meta_box_nonce');
    wp_editor($hm_meta_box, 'hm_metabox_editor');
}

function hm_your_meta_box_speichern($post_id)
{
    // Nonce
    if (!isset($_POST['hm_your_meta_box_nonce']) || !wp_verify_nonce($_POST['hm_your_meta_box_nonce'], basename(__FILE__))) {
        return;
    }

    // Permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save
    if (isset($_POST['hm_metabox_editor'])) {
        update_post_meta($post_id, 'hm_metabox', $_POST['hm_metabox_editor']);
    }
}
add_action('add_meta_boxes', 'hm_own_metabox_posts');
add_action('save_post', 'hm_your_meta_box_speichern');
