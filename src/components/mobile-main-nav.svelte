<script>
	import MainNav from './main-nav.svelte';
	import { page } from '$app/stores';
	import Logo from './logo.svelte';
	import { createEventDispatcher } from 'svelte';

	const dispatch = createEventDispatcher();

	export let showMenu;

	// when page changes
	$: {
		if ($page) {
			showMenu = false;
		}
	}

	const hideMenu = () => {
		dispatch('hide');
	};
</script>

<div class="wrapper">
	<div class="trigger text-right">
		<!-- svelte-ignore a11y_click_events_have_key_events -->
		<!-- svelte-ignore a11y_no_static_element_interactions -->
		<i
			onclick={() => {
				showMenu = true;
			}}
			class="ri-menu-line text-2xl font-bold text-white"
		></i>
	</div>

	{#if showMenu}
		<div class="nav-container fixed left-0 top-0 z-10 h-full w-full">
			<div class="nav-panel h-full w-3/5 bg-white shadow-lg">
				<div class="nav-title flex justify-between border-b-2 bg-green-700 p-1">
					<div class="title">
						<Logo />
					</div>

					<div class="close">
						<!-- svelte-ignore a11y_click_events_have_key_events -->
						<!-- svelte-ignore a11y_no_static_element_interactions -->
						<i
							onclick={() => {
								showMenu = false;
							}}
							class="ri-close-circle-line text-lg font-bold text-red-600"
						></i>
					</div>
				</div>

				<MainNav />
			</div>
		</div>
	{/if}
</div>

<style>
	.nav-container {
		background: rgba(56, 56, 56, 0.418);
		backdrop-filter: blur(2px);
	}
</style>
