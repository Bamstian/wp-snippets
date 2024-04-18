<?php // DIESE ZEILE NICHT MIT EINFÜGEN! / DON´T PASTE IN THIS LINE!
/**
 * WP-Metabox für Posts.
 * WP-Metabox for a post.
 */
function benutzerdefiniertes_feld_meine_gedanken_hinzufuegen()
{
    add_meta_box(
        'meine_gedanken_meta_box',
        __('Meine Gedanken', 'textdomain'), // Ersetze 'textdomain' durch die Textdomain deines Themes
        'meine_gedanken_meta_box_render',
        'post',
        'normal',
        'high'
    );
}

function meine_gedanken_meta_box_render($post)
{
    // Holt bereits vorhandene Daten / Catches field data
    $meine_gedanken = get_post_meta($post->ID, 'meine_gedanken', true);
    // WYSIWYG-Editor
    wp_nonce_field(basename(__FILE__), 'meine_gedanken_meta_box_nonce');
    wp_editor($meine_gedanken, 'meine_gedanken_editor');
}

function meine_gedanken_meta_box_speichern($post_id)
{
    // Nonce
    if (!isset($_POST['meine_gedanken_meta_box_nonce']) || !wp_verify_nonce($_POST['meine_gedanken_meta_box_nonce'], basename(__FILE__))) {
        return;
    }

    // Berechtigungen / Permission
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Speichen / Save
    if (isset($_POST['meine_gedanken_editor'])) {
        update_post_meta($post_id, 'meine_gedanken', $_POST['meine_gedanken_editor']);
    }
}
add_action('add_meta_boxes', 'benutzerdefiniertes_feld_meine_gedanken_hinzufuegen');
add_action('save_post', 'meine_gedanken_meta_box_speichern');
