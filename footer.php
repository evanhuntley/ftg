<?php get_sidebar(); ?>

<footer role="contentinfo">
	<div class="container">
		<p>&copy;<?php echo date("Y"); ?> <a href="#top" title="Jump back to top">&#8593;</a></p>
	</div>
</footer>


<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script>!window.jQuery && document.write(unescape('%3Cscript src="<?php echo bloginfo('template_directory'); ?>/assets/scripts/jquery-2.0.3.min.js"%3E%3C/script%3E'))</script>
<script src="<?php echo bloginfo('template_directory'); ?>/assets/js/scripts.min.js"></script>

<?php wp_footer(); ?>


<?php if ( is_singular() ) wp_print_scripts( 'comment-reply' ); ?>
</body>
</html>
