<script>
	// @ts-nocheck

	export let apps = [];
</script>

<main>
	<div class="wrapper">
		<div class="appDrawer py-4 p-2 flex justify-between gap-4 flex-wrap">
			{#each apps as app}
				<div
					class="appPanel shadow bg-slate-200  hover:bg-slate-100 border border-invm_border rounded w-16 h-16 m-1 my-4"
				>
					<a href={app.url} class="bg-green-500">
						<div class="appIcon flex items-center h-full justify-center p-4">
							<img src={app.icon} alt="connect icon" />
						</div>
						<div class="appName mt-2 text-center text-slate-900 text-sm sm:font-medium">{app.name}</div>
					</a>
				</div>
			{/each}
		</div>
	</div>
</main>

<style>
</style>
