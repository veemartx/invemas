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

	const { Notify, Confirm } = pkg;

	const url = `${API_BASE_URL}products/list.php`;

	const resource = 'list';

	const liu = current_liu();

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

			page_items = update_page(list, current_page,page_size);
			// console.log();
		}
	}

	const make_rows = (list) => {
		list.forEach((v, i) => {
			rows.push([
				i + 1,
				v.name,
				v.code,
				v.category,
				v.subcategory,
				v.cost_price,
				v.retail_price,
				v.discount,
				''
			]);
		});

		rows = rows;

		// console.log(rows);
	};

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

		page_items=update_page(list,current_page,page_size);
	};

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
			<div slot="actions" class="">
				<!-- svelte-ignore a11y_consider_explicit_label -->
				<a href="products-list/new">
					<button class="ui basic teal button icon mini p-2">
						<i class="plus icon"></i> New
					</button>
				</a>
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
</style>
