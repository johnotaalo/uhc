<template>
	<div>
		<nav class="navbar navbar-expand-lg navbar-light" id="topnav">
			<div class="container">

				<!-- Toggler -->
				<button class="navbar-toggler mr-auto" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>

				<!-- Brand -->
				<a class="navbar-brand" href="index.html">
					<img src="/img/coat_of_arms.png" alt="..." class="navbar-brand-img">
				</a>

				<!-- Collapse -->
				<div class="collapse navbar-collapse mr-n3 order-lg-last" id="navbar">

					<!-- Form -->
					<form class="mt-4 mb-3 d-md-none">
					<input type="search" class="form-control form-control-rounded" placeholder="Search" aria-label="Search">
					</form>

					<!-- Navigation -->
					<ul class="navbar-nav mr-auto">
						<li class="nav-item"><router-link class="nav-link" :to="{ name: 'enrollment' }">Enrollment</router-link></li>
						<li class="nav-item"><router-link class="nav-link" :to="{ name: 'utilization' }">Utilization</router-link></li>
						<li class="nav-item"><router-link class="nav-link" :to="{ name: 'serviceDelivery' }">Survey Delivery</router-link></li>
						<li class="nav-item"><router-link class="nav-link" :to="{ name: 'financialHealth' }">Financial Health</router-link></li>
					</ul>

				</div>

			</div> <!-- / .container -->
		</nav>
	</div>
</template>

<script type="text/javascript"></script>