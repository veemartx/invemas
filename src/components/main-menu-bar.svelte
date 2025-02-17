<script>
	import Logo from './logo.svelte';
	import MainActionPanel from './main-action-panel.svelte';
	import MainProfilePanel from './main-profile-panel.svelte';
	import MainSearch from './main-search.svelte';
	import MobileMainNav from './mobile-main-nav.svelte';

	let showMenu = true;

</script>

<div class="wrapper bg-green-900 p-2">
	<div class="main-bar flex items-center justify-between gap-2">
		<!-- mobile main nav -->
		<div class="mobile-nav md:hidden">
			<MobileMainNav
				{showMenu}
				on:hide={() => {
					showMenu = false;
				}}
			/>
		</div>
		<!-- mobile main nav -->
		<!-- logo  -->
		<div class="logo flex-auto">
			<Logo />
		</div>
		<!-- logo  -->

		<!-- comp search  -->
		<div class="search mx-5 hidden flex-1 md:block">
			<MainSearch />
		</div>
		<!-- comp search  -->

		<div class="top-panels flex items-center justify-between gap-2">
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

	<!-- mobile search -->
	<div class="mt-2 md:hidden border-t border-slate-50 py-2">
		<MainSearch />
	</div>
	<!-- mobile search -->
</div>

<style>
	.main-bar {
		max-width: 85em;
		margin: auto;
	}
</style>
