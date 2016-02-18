	<?php if ( is_active_sidebar( 'inner-sidebar' ) ): ?>
		<?php dynamic_sidebar( 'inner-sidebar' ); ?>
	<?php else: ?>
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<hr class="footer-separator">
				</div>
			</div>
		</div>
	<?php endif; ?>

	<footer id="footer">
		<div class="container">
			<div class="row">
				<div class="col-sm-4">
					<?php dynamic_sidebar( 'footer-sidebar-one' ); ?>
				</div>

				<div class="col-sm-4">
					<?php dynamic_sidebar( 'footer-sidebar-two' ); ?>
				</div>

				<div class="col-sm-4">
					<?php dynamic_sidebar( 'footer-sidebar-three' ); ?>
				</div>
			</div>
		</div>

		<div class="container footer-credits">
			<div class="row">
				<div class="col-xs-12">
					<p>&copy; <?php echo get_bloginfo( 'name' ) . ' ' . date( 'Y' ); ?></p>
				</div>
			</div>
		</div>
	</footer>

</div> <!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
