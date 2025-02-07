<script>
	import { createEventDispatcher } from 'svelte';

	// send message to close modal
	const dispatch = createEventDispatcher();

	function openSidebar() {
		dispatch('open');
	}
</script>

<main>
	<div class="wrapper">
		<!-- svelte-ignore a11y-click-events-have-key-events -->
		<!-- svelte-ignore a11y-no-static-element-interactions -->
		<div class="actionButtonContainer bg-red-700 z-50" on:click={openSidebar}>
			<span class="icon">
				<i class="ri-settings-line"></i>
			</span>
		</div>
	</div>
</main>

<style>
	.actionButtonContainer {
		width: 0.5em;
		height: 0.5em;
		padding: 1em;
		font-size: 25px;
		color: aliceblue;
		margin: 1em;
		position: fixed;
		right: 0.4em;
		bottom: 1em;
		display: flex;
		justify-content: center;
		align-items: center;
		cursor: pointer;
		border-radius: 50%;
		box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
	}

	.actionButtonContainer .icon {
		animation: spin 4s linear infinite;
	}

	@keyframes spin {
		100% {
			-webkit-transform: rotate(360deg);
			transform: rotate(360deg);
		}
	}
</style>
