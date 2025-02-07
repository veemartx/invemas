<script>
	import ActionButton from '$components/action-button.svelte';
	import MainFooter from '$components/main-footer.svelte';
	import MainMenuBar from '$components/main-menu-bar.svelte';
	import MainNav from '$components/main-nav.svelte';
	import SidePanel from '$components/side-panel.svelte';

	let show_side_panel=false;

	let { children } = $props();
</script>

<div class="wrapper">
	<div class="main-menu-bar">
		<MainMenuBar />
	</div>

	<div class="main-content-container bg-slate-50">
		<div class="content-container flex justify-between">
			<div class="side-nav m-2 mr-2 hidden bg-white p-2 shadow-md md:block">
				<MainNav />
			</div>

			
			<div class="content-container flex-1">
				{@render children()}
			</div>
		</div>

		<!-- side panel -->
		{#if show_side_panel}
			<SidePanel
				on:close={() => {
					show_side_panel = false;
				}}
			/>
		{/if}
		<!-- side panel -->

		<!-- action button -->
		<ActionButton
			on:open={() => {
				show_side_panel = true;
			}}
		/>
		<!-- action button -->

		<!-- footer  -->
		<div class="footer">
			<MainFooter />
		</div>
		<!-- footer  -->
	</div>
</div>

<style>
	.content-container {
		max-width: 85em;
		margin: auto;
		min-height: 80vh;
	}

	.side-nav {
		border-radius: 5px;
	}
</style>
