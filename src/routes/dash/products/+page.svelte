<script>
	import { page } from '$app/stores';
	import Segment from '$components/segment.svelte';
	import StatsCard from '$components/stats-card.svelte';
	import StatsCol from '$components/stats-col.svelte';
	import TitleBar from '$components/title-bar.svelte';
	import { API_BASE_URL } from '$lib/config/base-urls';
	import { COMPANY } from '$lib/config/consts';
	import { fetch_resource } from '$lib/methods/functions';
	import {
		add_commas,
		format_date,
		get_current_page,
		make_pages,
		update_page
	} from '$lib/methods/methods';
	import { generate_pdf } from '$lib/methods/pdf-make';
	import Pagination from '$utilities/pagination/pagination.svelte';
	import { onMount } from 'svelte';
	import { v4 } from 'uuid';

	const products_base_url = `${API_BASE_URL}products/get.php`;

	const stats_base_url = `${API_BASE_URL}products/stats.php`;

	const resource = 'products';

	const pdf_column_titles = [
		{ text: 'No', bold: true, fontSize: 9 },
		{ text: 'Name', bold: true, fontSize: 9 },
		{ text: 'Code', bold: true, fontSize: 9 },
		{ text: 'Category (Subcategory)', bold: true, fontSize: 9 },
		{ text: 'Cost', bold: true, fontSize: 9 },
		{ text: 'Retail', bold: true, fontSize: 9 },
		{ text: 'Qty', bold: true, fontSize: 9 },
		{ text: 'Value', bold: true, fontSize: 9 },
		{ text: 'Created', bold: true, fontSize: 9 }
	];

	const pdf_column_widths = ['6%', '20%', '9%', '25%', '8%', '8%', '7%', '9%', '10%'];

	const pdf_make_rows = (products) => {
		let rows = [];
		products.forEach((p, i) => {
			rows.push([
				{
					text: i + 1,
					style: 'reportValue',
					fillColor: i % 2 == 0 ? '#f7f0f0' : '#f7f7f7'
				},

				{
					text: p.name,
					style: 'reportValue',
					fillColor: i % 2 == 0 ? '#f7f0f0' : '#f7f7f7'
				},

				{
					text: p.code,
					style: 'reportValue',
					fillColor: i % 2 == 0 ? '#f7f0f0' : '#f7f7f7'
				},

				{
					text: `${p.category} (${p.subcategory})`,
					style: 'reportValue',
					fillColor: i % 2 == 0 ? '#f7f0f0' : '#f7f7f7'
				},

				{
					text: add_commas(parseFloat(p.cost_price)),
					style: 'reportValue',
					fillColor: i % 2 == 0 ? '#f7f0f0' : '#f7f7f7'
				},
				{
					text: add_commas(parseFloat(p.retail_price)),
					style: 'reportValue',
					fillColor: i % 2 == 0 ? '#f7f0f0' : '#f7f7f7'
				},
				{
					text: p.qty,
					style: 'reportValue',
					fillColor: i % 2 == 0 ? '#f7f0f0' : '#f7f7f7'
				},
				{
					text: add_commas(parseFloat(p.qty * p.cost_price)),
					style: 'reportValue',
					fillColor: i % 2 == 0 ? '#f7f0f0' : '#f7f7f7'
				},
				{
					text: format_date(p.created_at, 'YYYY-MM-DD'),
					style: 'reportValue',
					fillColor: i % 2 == 0 ? '#f7f0f0' : '#f7f7f7'
				}
			]);
		});

		return rows;
	};

	let products = [];

	let product_stats = [];

	let current_page = 1;

	let page_size = 50;

	let page_items = [];

	let pages = [];

	$: {
		if ($page) {
			current_page = get_current_page($page.url.search);

			page_items = update_page(products, current_page, page_size);
		}
	}

	const export_pdf = (data) => {
		//make rows
		let rows = pdf_make_rows(data);

		let doc_number = 'STK001';

		let title = 'Products';

		let filters = [
			{
				name: 'Stock Products',
				value: ''
			}
		];

        generate_pdf(title,doc_number,filters,pdf_column_titles,pdf_column_widths,rows,COMPANY);

	};
	onMount(async () => {
		const stats_res = await fetch_resource(resource, `${stats_base_url}`);

		product_stats = stats_res.data;

		const products_res = await fetch_resource(resource, `${products_base_url}`);

		products = products_res.data;

		// console.log(product_stats);

		pages = make_pages(products.length, page_size);
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
				<button onclick={()=>{
					export_pdf(products);
				}} class="ui basic red button icon mini p-2">
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
						{#each page_items as prd, i}
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

				<div class="">
					<Pagination {current_page} {pages} {page_size} items={products.length}></Pagination>
				</div>
			</div>
		</Segment>
	</div>
</div>

<style>
	button {
		font-size: x-small !important;
		font-weight: 900 !important;
	}
</style>
