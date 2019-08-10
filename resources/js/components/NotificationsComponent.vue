<template>
	<div>
		<li class="dropdown dropdown-list-toggle">
			<a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg">
				<i class="far fa-bell"></i>
			</a>
			<div class="dropdown-menu dropdown-list dropdown-menu-right">
				<div class="dropdown-header">Notifications
					<div class="float-right">
						<a href="#">Mark All As Read</a>
					</div>
				</div>
				<div class="dropdown-list-content dropdown-list-icons">
					<a href="#" class="dropdown-item">
						<div class="dropdown-item-icon bg-info text-white">
							<i class="fas fa-bell"></i>
						</div>
						<div class="dropdown-item-desc">
							Welcome to Market Pertanian!
							<div class="time">Yesterday</div>
						</div>
					</a>
				</div>
				<div class="dropdown-footer text-center">
					<a href="#">View All <i class="fas fa-chevron-right"></i></a>
				</div>
			</div>
		</li> 
	</div>
	
</template>

<script>
	export default {
		mounted() {
			console.log('Component mounted.')
		}
	}
</script>
