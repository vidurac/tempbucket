<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package blogster_utility
 */
?>

</div><!-- #content -->

<footer id="colophon" class="site-footer" role="contentinfo">
    <div class="site-info">
        <?php
        if (get_theme_mod('text_setting')) {
            echo wp_kses_post(balanceTags(get_theme_mod('text_setting')));
        } else {
            echo esc_html( ' &copy; 2017 ' . get_bloginfo( 'name' ) );
        }
        ?>
    </div><!-- .site-info -->
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
