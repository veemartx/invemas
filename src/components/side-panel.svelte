<script>
	// @ts-nocheck
	import { onMount, createEventDispatcher } from 'svelte';
	import { fly } from 'svelte/transition';
	import AppsQuickAccess from './apps-quick-access.svelte';
	import QuickLinks from './quick-links.svelte';


	import { page } from '$app/stores';

	// send message to close modal
	const dispatch = createEventDispatcher();

	function closeModal() {
		dispatch('close');
	}

	onMount(() => {
		// change body attributes
		// document.body.style.overflow = "hidden"; // ADD THIS LINE
		// document.body.style.height = "100%";
	});
</script>

<main>
	<div class="wrapper">
		<!-- svelte-ignore a11y-click-events-have-key-events -->
		<!-- svelte-ignore a11y-no-static-element-interactions -->
		<div
			id="sidebar_modal"
			class="sidebar_modal"
			on:click={(e) => {
				let modal = document.getElementById('sidebar_modal');

				window.onclick = function (event) {
					if (event.target == modal) {
						closeModal();
					}
				};
			}}
		>
			<div
				transition:fly|global={{ x: 200, duration: 400 }}
				class="sidebar bg-white"
			>
				<div class="sideBarTitle">
					<div class="title">Side Panel</div>
					<div class="close closeModal">
						<!-- svelte-ignore a11y-no-static-element-interactions -->
						<!-- <CloseOutline on:click={closeModal} size="sm" /> -->
						<i class="ri-close-circle-line" on:click={closeModal}></i>
					</div>
				</div>

				<div class="quickLinks">
					<QuickLinks />
				</div>

				<!-- apps quick access -->
				<div class="appsQuickAccess">
					<AppsQuickAccess />
				</div>
				<!-- apps quick access -->
			</div>
		</div>
	</div>
</main>

<style>
	.sidebar_modal {
		background: rgba(0, 0, 0, 0.547);
		position: fixed;
		top: 0;
		left: 0;
		width: 100vw;
		height: 100vh;
		z-index: 10000;
		animation: darken 1s;
		display: flex;
		justify-content: flex-end;
		backdrop-filter: blur(5px);
	}

	.sidebar {
		width: 100%;
		padding: 1em;
	}

	.sideBarTitle {
		border-bottom: 1px solid rgba(128, 128, 128, 0.074);
		font-weight: 500;
		font-size: 20px;
		display: flex;
		justify-content: space-between;
	}

	.title {
		font-weight: 500;
		font-size: 20px;
		color: var(--text-primary-light);
	}

	.closeModal {
		color: crimson;
		padding-right: 0.1em;
		padding-top: 0.3em;
	}

	@media only screen and (min-width: 640px) {
		.sidebar {
			width: 25em;
		}
	}
</style>
