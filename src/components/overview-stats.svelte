<script>
	import { onMount } from 'svelte';
	import AnalyticWidget from './analytic-widget.svelte';
	import { API_BASE_URL } from '$lib/config/base-urls';
	import { fetch_resource } from '$lib/methods/functions';

	const url=`${API_BASE_URL}dash-stats.php`;


	let stats = [];

	onMount(async() => {

		const response=await fetch_resource('stats',url);

		stats=response.data;

		// stats = [
		// 	{
		// 		name: 'Products',
        //         value: '3,298',
		// 		icon: `<i class="ri-wallet-3-line"></i>`,
		// 		change: 12,
		// 		link: '/reports/revenue',
		// 		color: 'red'
		// 	},

		// 	{
		// 		name: 'Products Value',
        //         value: '513.1k',
		// 		icon: `<i class="ri-file-list-3-line"></i>`,
		// 		change: -0.2,
		// 		link: '/orders',
		// 		color: 'purple'
		// 	},

		// 	{
		// 		name: 'Sales',
		// 		value: '11,827',
		// 		icon: `<i class="ri-user-smile-line"></i>`,
		// 		change: 0,
		// 		link: '/customers',
		// 		color: 'green'
		// 	},

		// 	{
		// 		name: 'Low Stock',
		// 		value: '18',
		// 		icon: `<i class="ri-truck-line"></i>`,
		// 		change: 18.1,
		// 		link: '/deliveries/active',
		// 		color: 'blue'
		// 	}
		// ];
	});
</script>

<main>
	<div class="analytics flex flex-wrap justify-between px-1">
		{#each stats as s}
			<AnalyticWidget title={s.name} value={s.value} change={s.change} color={s.color}>
				<div slot="icon" class="icon">
					{@html s.icon}
				</div>

				<a slot="link" href={s.link} class="text-sm capitalize"> View {s.name} </a>
			</AnalyticWidget>
		{/each}
	</div>
</main>

<style>
	.icon {
		opacity: 1;
	}
</style>
