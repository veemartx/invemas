<script>
	import Logo from './logo.svelte';
	import MainActionPanel from './main-action-panel.svelte';
	import MainProfilePanel from './main-profile-panel.svelte';
	import MainSearch from './main-search.svelte';
	import MobileMainNav from './mobile-main-nav.svelte';
</script>

<div class="wrapper bg-green-900 p-2">
	<div class="main-bar flex items-center gap-2 justify-between">
		<!-- mobile main nav -->
		<div class="mobile-nav  md:hidden">
			<MobileMainNav />
		</div>
		<!-- mobile main nav -->
		<!-- logo  -->
		<div class="logo flex-auto">
			<Logo />
		</div>
		<!-- logo  -->

		<!-- comp search  -->
		<div class="search hidden md:block">
			<MainSearch />
		</div>
		<!-- comp search  -->

		<div class="top-panels flex items-center gap-2">
			<!-- action panel  -->
			<div class="action-panel">
				<MainActionPanel />
			</div>
			<!-- action panel  -->

			<!-- profile panel  -->
			<div class="profile-panel">
				<MainProfilePanel />
			</div>
			<!-- profile panel  -->
		</div>
	</div>
</div>

<style>
	.main-bar {
		max-width: 85em;
		margin: auto;
	}
</style>
