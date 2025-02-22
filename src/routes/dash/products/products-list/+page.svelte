<script>
	import Segment from '$components/segment.svelte';
	import TitleBar from '$components/title-bar.svelte';
	import { API_BASE_URL } from '$lib/config/base-urls';
	import { fetch_resource } from '$lib/methods/functions';
	import {
		add_commas,
		current_liu,
		get_current_page,
		make_pages,
		update_page
	} from '$lib/methods/methods';
	import { onMount } from 'svelte';
	import pkg from 'notiflix';
	import axios from 'axios';
	import Datatable from '$components/datatable.svelte';
	import Pagination from '$utilities/pagination/pagination.svelte';
	import { page } from '$app/stores';
	import { COMPANY } from '$lib/config/consts';
	import { generate_pdf } from '$lib/methods/pdf-make';

	const { Notify, Confirm } = pkg;

	const url = `${API_BASE_URL}products/list.php`;

	const resource = 'list';

	const liu = current_liu();

	const pdf_column_titles = [
		{ text: 'No', bold: true, fontSize: 9 },
		{ text: 'Name', bold: true, fontSize: 9 },
		{ text: 'Code', bold: true, fontSize: 9 },
		{ text: 'Category (Subcategory)', bold: true, fontSize: 9 },
		{ text: 'Cost', bold: true, fontSize: 9 },
		{ text: 'Retail', bold: true, fontSize: 9 },
		{ text: 'Brand', bold: true, fontSize: 9 },
		{ text: 'Manufacturer', bold: true, fontSize: 8 }
	];

	const pdf_column_widths = ['6%', '20%', '9%', '27%','8%', '8%', '10%', '11%'];

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
					style: {
						fontSize:8
					},
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
					text: p.brand,
					style: 'reportValue',
					fillColor: i % 2 == 0 ? '#f7f0f0' : '#f7f7f7'
				},
				{
					text: p.manufacturer,
					style: 'reportValue',
					fillColor: i % 2 == 0 ? '#f7f0f0' : '#f7f7f7'
				}
			]);
		});

		return rows;
	};

	let list = [];

	let current_page = 1;

	let page_size = 50;

	let page_items = [];

	let pages = [];

	let headers = [
		{ name: 'No', value: 'no' },
		{ name: 'Name', value: 'name' },
		{ name: 'Code', value: 'code' },
		{ name: 'Category', value: 'category' },
		{ name: 'Subcategory', value: 'subcategory' },
		{ name: 'Cost Price', value: 'cost_price' },
		{ name: 'Retail Price', value: 'retail_price' },
		{ name: 'Discount', value: 'discount' },
		{ name: 'Actions', value: '' }
	];

	$: {
		if ($page) {
			current_page = get_current_page($page.url.search);

			page_items = update_page(list, current_page, page_size);
			// console.log();
		}
	}

	const delete_list_product = async (pl) => {
		console.log(pl);

		let dt = {
			pl_id: pl.pl_id,
			name: pl.name,
			init: liu.name
		};

		try {
			let response = await axios({
				method: 'POST',
				data: dt,
				url: `${API_BASE_URL}product-list/delete.php`,
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded'
				}
			});

			let res = response.data;

			if (res.success) {
				Notify.success(res.message);

				await get_list();
			} else {
				Notify.failure(res.message);
			}
		} catch (err) {
			console.log(err);
		}
	};

	const get_list = async () => {
		const res = await fetch_resource(resource, url);

		list = res.data;

		page_items = update_page(list, current_page, page_size);
	};

	const export_pdf=(data)=>{

		let title="Products List";

		let rows=pdf_make_rows(data);

		let doc_number="PL001";

		let filters=[
			{
				name:"Products List",
				value:"All"
			}
		]

        generate_pdf(title,doc_number,filters,pdf_column_titles,pdf_column_widths,rows,COMPANY);

	}

	onMount(async () => {
		//get ist
		await get_list();

		pages = make_pages(list.length, page_size);
	});
</script>

<div class="wrapper">
	<TitleBar title="Products List" subtitle="view inventory list">
		<div class="" slot="action">
			<i class="ri-more-2-line text-lg font-bold"></i>
		</div>
	</TitleBar>

	<div class="my-3">
		<Segment>
			<div slot="title">Products List</div>
			<div slot="actions" class="p-2">
				<!-- svelte-ignore a11y_consider_explicit_label -->
				<a href="products-list/new">
					<button class="ui basic teal button icon mini p-2">
						<i class="plus icon"></i> New
					</button>
				</a>

				<!-- svelte-ignore a11y_consider_explicit_label -->
				<button onclick={()=>{
					export_pdf(list);
				}} class="ui basic mini icon red button hover:bg-slate-200">
					<i class="pdf file icon"></i>
				</button>

				<!-- svelte-ignore a11y_consider_explicit_label -->
				<button class="ui basic mini icon green button">
					<i class="excel file icon"></i>
				</button>

				<!-- svelte-ignore a11y_consider_explicit_label -->
				<button class="ui basic mini icon purple button">
					<i class="print file icon"></i>
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
							<th>Cost Price</th>
							<th>Retail Price</th>
							<th>Discount</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						{#each page_items as lp, i}
							<tr class="text-sm text-slate-700">
								<td>{i + 1}</td>
								<td>{lp.name}</td>
								<td>{lp.code}</td>
								<td>{lp.category}</td>
								<td>{add_commas(parseFloat(lp.cost_price), 2)}</td>
								<td>{add_commas(parseFloat(lp.retail_price), 2)}</td>
								<td>{lp.discount}</td>
								<td>
									<!-- svelte-ignore a11y_consider_explicit_label -->
									<button
										onclick={() => {
											Confirm.show(
												'Delete',
												`Delete List Item ${lp.name}?`,
												'Yes',
												'Cancel',
												() => {
													delete_list_product(lp);
												}
											);
										}}
										class="ui mini red basic icon button"
									>
										<i class="ui red trash icon"></i>
									</button>

									<!-- svelte-ignore a11y_consider_explicit_label -->
									<a href="products-list/edit/{lp.slug}">
										<button class="ui mini orange basic icon button">
											<i class="ui edit icon"></i>
										</button>
									</a>

									<!-- svelte-ignore a11y_consider_explicit_label -->
									<a href="products-list/{lp.slug}">
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
					<Pagination {current_page} {pages} {page_size} items={list.length}></Pagination>
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
