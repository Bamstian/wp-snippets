<?php // DIESE ZEILE NICHT MIT EINFÜGEN!
/**
 * Benutzerdefiniertes Feld für "DEIN_NAME" zu einem Post.
 */
function hm_eigene_metabox_posts()
{
    add_meta_box(
        'hm_deine_meta_box',
        __('DIESEN TITEL ERSETZEN', 'textdomain'), // Ersetze 'textdomain' durch die Textdomain deines (Child-)Themes (Die "Text Domain" steht in der styles.css)
        'hm_deine_meta_box_render',
        'post',
        'normal',
        'high'
    );
}

function hm_deine_meta_box_render($post)
{
    // Holt bereits vorhandene Daten
    $hm_meta_box = get_post_meta($post->ID, 'hm_metabox', true);
    // WYSIWYG-Editor
    wp_nonce_field(basename(__FILE__), 'hm_deine_meta_box_nonce');
    wp_editor($hm_meta_box, 'hm_metabox_editor');
}

function hm_deine_meta_box_speichern($post_id)
{
    // Nonce
    if (!isset($_POST['hm_deine_meta_box_nonce']) || !wp_verify_nonce($_POST['hm_deine_meta_box_nonce'], basename(__FILE__))) {
        return;
    }

    // Berechtigungen
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Speichen
    if (isset($_POST['hm_metabox_editor'])) {
        update_post_meta($post_id, 'hm_metabox', $_POST['hm_metabox_editor']);
    }
}
add_action('add_meta_boxes', 'hm_eigene_metabox_posts');
add_action('save_post', 'hm_deine_meta_box_speichern');
