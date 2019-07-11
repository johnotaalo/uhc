<template>
	<div>
		<top-bar :type="type" />
		<main class="py-4">
			<div class="container">
				<router-view></router-view>
			</div>
			
		</main>
	</div>

</template>

<script type="text/javascript">
	export default {
		props: {
			type: { type: null, default: null }
		}
	}
</script>