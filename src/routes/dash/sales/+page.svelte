<script>
	import Segment from '$components/segment.svelte';

	import TitleBar from '$components/title-bar.svelte';
	import { API_BASE_URL } from '$lib/config/base-urls';
	import { fetch_resource } from '$lib/methods/functions';
	import { add_commas, calculate_percentage, format_date } from '$lib/methods/methods';
	import { onMount } from 'svelte';

	const url = `${API_BASE_URL}sales/get.php`;

	const resource = 'Sales';

	let sales = $state([]);

	let filtered_sales = $state([]);

	const filter_sales = (q) => {
		if (q) {
			
            let lowerQ=q.toLowerCase();

            const ftd=sales.filter((s)=>{
                if(s.name.toLowerCase().includes(lowerQ)){
                    return s;
                }
            })

            // console.log(ftd);
            filtered_sales=ftd;
		} else {
			filtered_sales = sales;
		}
	};

	const get_sales = async () => {
		const res = await fetch_resource(resource, url);

		sales = res.data;
        filtered_sales=sales;
	};

	onMount(async () => {
		//get sales
		await get_sales();
	});
</script>

<main>
	<!-- title  -->
	<div class="">
		<TitleBar title="Sales" subtitle="view product sales">
			<div class="" slot="action">
				<i class="ri-more-2-line text-lg font-bold"></i>
			</div>
		</TitleBar>
	</div>
	<!-- title  -->

	<div class="my-2">
		<Segment>
			<div class="" slot="title">Sales</div>
			<div class="flex items-center gap-2" slot="actions">
				<div class="inline">
					<input
						class="rounded-md"
						type="text"
						placeholder="filter sales"
						onkeyup={(e) => {
							filter_sales(e.target.value);
						}}
					/>
				</div>

				<!-- svelte-ignore a11y_consider_explicit_label -->
				<button class="ui basic red icon mini button p-0 text-xs">
					<i class="pdf file icon"></i>
				</button>

				<!-- svelte-ignore a11y_consider_explicit_label -->
				<button class="ui basic green icon mini button p-0 text-xs">
					<i class="excel file icon"></i>
				</button>
			</div>

			<div class="my-2" slot="content">
				<table class="ui basic striped unstackable table">
					<thead>
						<tr class="text-sm">
							<th>No</th>
							<th>Item</th>
							<th>Code</th>
							<th>Qty</th>
							<th>Retail Price</th>
							<th>Sale Price</th>
							<th>Discount</th>
							<th>Sale Value</th>
							<th>Date</th>
							<th>Sale By</th>
						</tr>
					</thead>
					<tbody>
						{#each filtered_sales as sale, i}
							<tr class="text-sm">
								<td>{i + 1}</td>
								<td>{sale.name}</td>
								<td>{sale.code}</td>
								<td>{sale.qty}</td>
								<td>{add_commas(parseFloat(sale.retail_price))}</td>
								<td>{add_commas(parseFloat(sale.sale_price))}</td>
								<td
									>{add_commas(parseFloat(sale.discount))}
									<span class="font-semibold text-red-500"
										>(-{calculate_percentage(sale.discount, sale.retail_price)}%)
									</span>
								</td>
								<td>{add_commas(parseFloat(sale.value))}</td>
								<td>{format_date(sale.date)}</td>
								<td>{sale.init}</td>
							</tr>
						{/each}
					</tbody>
				</table>
			</div>
		</Segment>
	</div>
</main>
