<?php
/**
 * Search form template
 *
 * @package Readora
 */
$readora_search_id = wp_unique_id('search-field-');
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <label for="<?php echo esc_attr($readora_search_id); ?>" class="screen-reader-text">
        <?php esc_html_e('Search for:', 'readora'); ?>
    </label>
    <input type="search" id="<?php echo esc_attr($readora_search_id); ?>" name="s" class="search-field"
        placeholder="<?php esc_attr_e('Search articles...', 'readora'); ?>"
        value="<?php echo esc_attr(get_search_query()); ?>" autocomplete="off">
    <button type="submit" class="search-submit">
        <?php esc_html_e('Search', 'readora'); ?>
    </button>
</form>
