<script>
	import Segment from '$components/segment.svelte';
	import StatsCard from '$components/stats-card.svelte';
	import StatsCol from '$components/stats-col.svelte';
	import TitleBar from '$components/title-bar.svelte';
	import { API_BASE_URL } from '$lib/config/base-urls';
	import { fetch_resource } from '$lib/methods/functions';
	import { add_commas, format_date } from '$lib/methods/methods';
	import { onMount } from 'svelte';
	import { v4 } from 'uuid';

	const products_base_url = `${API_BASE_URL}products/get.php`;

	const stats_base_url = `${API_BASE_URL}products/stats.php`;

	const resource = 'products';

	let products = [];

	let product_stats = [];

	const genUid = () => {
		console.log(v4());
	};

	onMount(async () => {
		const stats_res = await fetch_resource(resource, `${stats_base_url}`);

		product_stats = stats_res.data;

		const products_res = await fetch_resource(resource, `${products_base_url}`);

		products = products_res.data;

		// console.log(product_stats);
	});
</script>

<div class="wrapper">
	<TitleBar title="Products" subtitle="view and prdage products">
		<div class="" slot="action">
			<i class="ri-more-2-line text-lg font-bold"></i>
		</div>
	</TitleBar>

	<!-- stats  -->
	<div class="product-stats my-3">
		<StatsCol>
			{#each product_stats as stat}
				<StatsCard {stat} />
			{/each}
		</StatsCol>
	</div>
	<!-- stats  -->

	<div class="my-3">
		<Segment>
			<div slot="title">Products</div>
			<div slot="actions" class="flex items-center gap-2">
				<!-- search trigger  -->
				<div class="text-lg text-slate-700">
					<i class="search icon"></i>
				</div>

				<!-- svelte-ignore a11y_consider_explicit_label -->
				<a href="products/new">
					<button class="ui basic purple button icon mini p-2">
						<i class="plus icon"></i>
					</button>
				</a>

				<!-- svelte-ignore a11y_consider_explicit_label -->
				<button class="ui basic green button icon mini p-2">
					<i class="excel file icon"></i>
				</button>

				<!-- svelte-ignore a11y_consider_explicit_label -->
				<button class="ui basic red button icon mini p-2">
					<i class="pdf file icon"></i>
				</button>
			</div>

			<div slot="content" class="overflow-x-auto">
				<table class="ui very basic striped unstackable table w-full text-sm">
					<thead>
						<tr class="text-sm">
							<th>No</th>
							<th>Name</th>
							<th>Code</th>
							<th>Category</th>
							<th>Qty</th>
							<th>Price</th>
							<th>Value</th>
							<th>Created </th>
							<th>View</th>
						</tr>
					</thead>
					<tbody>
						{#each products as prd, i}
							<tr class="text-sm text-slate-700">
								<td>{i + 1}</td>
								<td>{prd.name}</td>
								<td>{prd.code}</td>
								<td>{prd.category}</td>
								<td>{prd.qty}</td>
								<td>{prd.retail_price}</td>
								<td>{add_commas(parseFloat(prd.value))}</td>
								<td>{format_date(prd.created_at)}</td>

								<td>
									<!-- svelte-ignore a11y_consider_explicit_label -->
									<button class="ui mini red basic icon button">
										<i class="ui red trash icon"></i>
									</button>
									<!-- svelte-ignore a11y_consider_explicit_label -->
									<button class="ui mini orange basic icon button">
										<i class="ui edit icon"></i>
									</button>

									<a href="/dash/products/{prd.slug}">
										<!-- svelte-ignore a11y_consider_explicit_label -->
										<button class="ui mini green basic icon button">
											<i class="ui eye icon"></i>
										</button>
									</a>
								</td>
							</tr>
						{/each}
					</tbody>
				</table>
			</div>
		</Segment>
	</div>

	<div class="my-3">
		<button on:click={genUid} class="ui basic purple mini button"> Gen-Uid </button>
	</div>
</div>
