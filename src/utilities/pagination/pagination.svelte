<script>
	// @ts-nocheck

	import { createEventDispatcher, onMount } from 'svelte';
	import PageCell from './page-cell.svelte';

	const dispatch = createEventDispatcher();

	const navigate = (page) => {
		dispatch('navigate', page);
	};
	

	let {current_page,pages,page_size,items}=$props();

	// export let current_page = 0;

	// export let items = 0;

	// export let page_size = 0;

	let resource = 'Entries';

	onMount(() => {
		// console.log(pages);
	
		
		console.log(pages);

	});
</script>

<div class="my-2 shadow-sm border border-pp_border py-2 px-1">
	<div class="summary text-gray-400 text-sm px-2 my-2 text-right">
		Showing <b class="text-slate-900">{current_page * page_size + 1 - page_size}</b> to
		<b class="text-slate-900">{current_page * page_size}</b>
		of <b class="text-slate-900">{items}</b>
		{resource}
	</div>
	<!-- svelte-ignore a11y-no-static-element-interactions -->
	<div class="flex justify-end">
		{#if current_page > 1}
			<!-- svelte-ignore a11y-click-events-have-key-events -->
			<div
				on:click={() => {
					navigate(current_page - 1);
				}}
				class="prev font-bold flex px-2 items-center cursor-pointer hover:bg-slate-200 rounded"
			>
				<i class="ri-arrow-left-s-line"></i>
			</div>
		{/if}
		{#each pages as p}
			<PageCell>
				<div
					class="p-2 text-sm hover:text-rose-400 rounded {p +
						1 ==
					current_page
						? 'text-pp_red font-extrabold'
						: ''}"
				>
					<a
						href={`?page=${p + 1}`}
					>
						{p + 1}
					</a>
				</div>
			</PageCell>
		{/each}

		{#if current_page < pages.length}
			<!-- svelte-ignore a11y-click-events-have-key-events -->
			<!-- svelte-ignore a11y_click_events_have_key_events -->
			<div
				on:click={() => {
					// navigate(current_page + 1);
				}}
				class="next font-bold flex px-2 bg-slate-300 dark:bg-slate-600 items-center cursor-pointer hover:bg-slate-200 dark:hover:bg-slate-700 rounded"
			>
				<i class="ri-arrow-right-s-line"></i>
			</div>
		{/if}
	</div>
</div>
