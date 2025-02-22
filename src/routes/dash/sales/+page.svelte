<script>
	import Segment from '$components/segment.svelte';

	import TitleBar from '$components/title-bar.svelte';
	import { API_BASE_URL } from '$lib/config/base-urls';
	import { fetch_resource } from '$lib/methods/functions';
	import {
		add_commas,
		calculate_percentage,
		format_date,
		get_current_page,
		make_pages,
		update_page
	} from '$lib/methods/methods';
	import Pagination from '$utilities/pagination/pagination.svelte';
	import { onMount } from 'svelte';
	import { page } from '$app/stores';
	import { COMPANY } from '$lib/config/consts';
	import { generate_pdf } from '$lib/methods/pdf-make';

	const url = `${API_BASE_URL}sales/get.php`;

	const resource = 'Sales';

	const pdf_column_titles = [
		{ text: 'No', bold: true, fontSize: 9 },
		{ text: 'Item', bold: true, fontSize: 9 },
		{ text: 'Qty', bold: true, fontSize: 9 },
		{ text: 'Retail Price', bold: true, fontSize: 9 },
		{ text: 'Sale Price', bold: true, fontSize: 9 },
		{ text: 'Discount', bold: true, fontSize: 9 },
		{ text: 'Sale Value', bold: true, fontSize: 9 },
		{ text: 'Date', bold: true, fontSize: 8 },
		{ text: 'Init', bold: true, fontSize: 8 }
	];

	const pdf_column_widths = ['6%', '20%', '9%', '10%', '10%', '8%', '8%', '10%', '11%'];

	const pdf_make_rows = (sales) => {
		let rows = [];
		sales.forEach((s, i) => {
			rows.push([
				{
					text: i + 1,
					style: 'reportValue',
					fillColor: i % 2 == 0 ? '#f7f0f0' : '#f7f7f7'
				},

				{
					text: `${s.name} (${s.code})`,
					style: 'reportValue',
					fillColor: i % 2 == 0 ? '#f7f0f0' : '#f7f7f7'
				},

				{
					text: s.qty,
					style: 'reportValue',
					fillColor: i % 2 == 0 ? '#f7f0f0' : '#f7f7f7'
				},

				{
					text: add_commas(parseFloat(s.retail_price)),
					style: {
						fontSize: 8
					},
					fillColor: i % 2 == 0 ? '#f7f0f0' : '#f7f7f7'
				},

				{
					text: add_commas(parseFloat(s.sale_price)),
					style: 'reportValue',
					fillColor: i % 2 == 0 ? '#f7f0f0' : '#f7f7f7'
				},
				{
					text: add_commas(parseFloat(s.discount)),
					style: 'reportValue',
					fillColor: i % 2 == 0 ? '#f7f0f0' : '#f7f7f7'
				},
				{
					text: add_commas(parseFloat(s.value)),
					style: 'reportValue',
					fillColor: i % 2 == 0 ? '#f7f0f0' : '#f7f7f7'
				},
				{
					text: format_date(s.date),
					style: 'reportValue',
					fillColor: i % 2 == 0 ? '#f7f0f0' : '#f7f7f7'
				},
				{
					text: s.init,
					style: 'reportValue',
					fillColor: i % 2 == 0 ? '#f7f0f0' : '#f7f7f7'
				}
			]);
		});

		return rows;
	};

	let sales = [];

	let filtered_sales = [];

	let current_page = 1;

	let page_size = 50;

	let page_items = [];

	let pages = [];

	$: {
		if ($page) {
			current_page = get_current_page($page.url.search);

			page_items = update_page(filtered_sales, current_page, page_size);
		}
	}

	const filter_sales = (q) => {
		if (q) {
			let lowerQ = q.toLowerCase();

			const ftd = sales.filter((s) => {
				if (s.name.toLowerCase().includes(lowerQ)) {
					return s;
				}
			});

			// console.log(ftd);
			filtered_sales = ftd;
		} else {
			filtered_sales = sales;
		}
	};

	const get_sales = async () => {
		const res = await fetch_resource(resource, url);

		sales = res.data;
		filtered_sales = sales;
	};

	const export_pdf = (data) => {
		let title = 'Sales';

		let rows = pdf_make_rows(data);

		let doc_number = 'SLS001';

		let filters = [
			{
				name: 'Sales',
				value: 'All'
			}
		];

		generate_pdf(title, doc_number, filters, pdf_column_titles, pdf_column_widths, rows, COMPANY);
	};

	onMount(async () => {
		//get sales
		await get_sales();
		pages = make_pages(filtered_sales.length, page_size);
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
				<button onclick={()=>{
					export_pdf(sales);
				}} class="ui basic red icon mini button p-0 text-xs">
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
						{#each page_items as sale, i}
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

				<div class="">
					<Pagination {current_page} {pages} {page_size} items={filtered_sales.length}></Pagination>
				</div>
			</div>
		</Segment>
	</div>
</main>
<style>
	button {
		font-size: x-small !important;
		font-weight: 900 !important;
	}
</style>
