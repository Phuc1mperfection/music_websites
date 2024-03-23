	<footer>
		<div class="footer-div">
			<ul>
				<li><a href="">Home</a></li>
				<li><a href="">Music</a></li>

				
				<?php if(!logged_in()):?>
					<li><a href="<?=ROOT?>/login">Login</a></li>
				<?php endif;?>

			</ul>
		</div>
		<div class="footer-div">
			<form action="<?=ROOT?>/search">
				<div class="form-group">
					<input class="form-control" type="text" placeholder="Search for music" name="find">
					<button class="btn">Search</button>
				</div>
			</form>
		</div>
		
	</footer>
</body>

<script src="<?=ROOT?>/assets/js/menu-popper.js?35"></script>
</html>