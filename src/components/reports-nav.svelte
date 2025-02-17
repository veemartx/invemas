<script>
	import Segment from './segment.svelte';
	import InventoryIcon from '$assets/icons/inventory_icon.png';
	import SalesIcon from '$assets/icons/sale_reports.png';
	import UsageIcon from '$assets/icons/usage_icon.png';
	import TransactionsIcon from '$assets/icons/all-transactions.png';
	import { createEventDispatcher } from 'svelte';
	import { page } from '$app/stores';

	const dispatch = createEventDispatcher();

    let current_report;

    $:{
        if($page){
            let current_link_arr=$page.url.pathname.split('/');

            current_report=current_link_arr[current_link_arr.length-1];

            // console.log(current_link);
        }
    }

	let links = [
		{
			name: 'Inventory',
			icon: InventoryIcon,
			url: '/inventory'
		},
		{
			name: 'Sales',
			icon: SalesIcon,
			url: '/sales'
		},
		{
			name: 'Usage',
			icon: UsageIcon,
			url: '/usage'
		},
		{
			name: 'Transactions',
			icon: TransactionsIcon,
			url: '/transactions'
		}
	];
</script>

<main class="my-2">
	<div class="flex flex-wrap justify-between gap-2 px-2">
		{#each links as link}
			<!-- svelte-ignore a11y_missing_attribute -->
			<div class="link-panel shadow-md md:w-1/4 {current_report==link.name.toLowerCase()?"bg-gray-100 border":"bg-white"}">
				<a href="/dash/reports{link.url}" class="p-3 text-center">
					<div class="icon px-5 py-1">
						<img src={link.icon} alt="link icon" class="w-10" />
					</div>
					<div class="name py-1 font-bold text-invm_green">
						{link.name}
					</div>
				</a>
			</div>
		{/each}
	</div>
</main>

<style>
	.link-panel {
		width: 45vw;
	}
	.link-panel:hover {
		border: 1px solid crimson;
	}

	.icon {
		text-align: center;
	}

	.icon img {
		margin: auto;
	}

	@media screen and (min-width: 768px) {
		.link-panel {
			width: 15vw;
		}
	}
</style>
