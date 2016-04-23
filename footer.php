<?php get_sidebar(); ?>

<footer role="contentinfo">
	<div class="container">
		<p>&copy;<?php echo date("Y"); ?> <a href="#top" title="Jump back to top">&#8593;</a></p>
	</div>
</footer>

<script src="<?php echo bloginfo('template_directory'); ?>/assets/js/scripts.min.js"></script>

<?php wp_footer(); ?>


<?php if ( is_singular() ) wp_print_scripts( 'comment-reply' ); ?>
</body>
</html>
