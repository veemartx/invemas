<script>
	import Segment from '$components/segment.svelte';
	import TitleBar from '$components/title-bar.svelte';
	import { API_BASE_URL } from '$lib/config/base-urls';
	import { fetch_resource } from '$lib/methods/functions';
	import { onMount } from 'svelte';
	import { Button, Modal, Label, Input, Checkbox, Textarea } from 'flowbite-svelte';
	import { v4 } from 'uuid';
	import pkg from 'notiflix';
	import axios from 'axios';
	import { page } from '$app/stores';
	import Pagination from '$utilities/pagination/pagination.svelte';
	import { get_current_page, make_pages, update_page } from '$lib/methods/methods';


	const { Notify, Confirm } = pkg;

	const url = `${API_BASE_URL}products/brands.php`;

	const resource = 'brands';

	let show_modal = false;

	let brands=[];

	let brand_name;

	let brand_id;

	let brand_action = 'create';

	let brand_action_loading = false;


	let current_page = 1;

	let page_size = 50;

	let page_items = [];

	let pages = [];

	$: {
		if ($page) {
			current_page = get_current_page($page.url.search);

			page_items = update_page(brands, current_page, page_size);
		}
	}


	// send the data, if id exists update if not create
	const brand_form_submit = async () => {
		let br_id = brand_action == 'create' ? v4() : brand_id;

		let dt = {
			brand_id: br_id,
			brand: brand_name
		};

		//load
		brand_action_loading = true;

		try {
			let response = await axios({
				method: 'POST',
				data: dt,
				url: `${API_BASE_URL}brands/brand.php`,
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded'
				}
			});

			let res = response.data;

			if (res.success) {
				Notify.success(res.message);

				await get_brands();

				show_modal = false;
			} else {
				Notify.failure(res.message);
			}
			brand_action_loading = false;
		} catch (err) {
			brand_action_loading = false;
			console.log(err);
		}
	};

	const delete_brand = async (brand) => {
		let dt = {
			brand_id: brand.brand_id,
			name: brand.name
		};

		try {
			let response = await axios({
				method: 'POST',
				data: dt,
				url: `${API_BASE_URL}brands/delete.php`,
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded'
				}
			});

			let res = response.data;

			if (res.success) {
				Notify.success(res.message);

				await get_brands();
			} else {
				Notify.failure(res.message);
			}
		} catch (err) {
			console.log(err);
		}
	};

	const get_brands = async () => {
		const res = await fetch_resource(resource, url);

		brands = res.data;

		page_items = update_page(brands, current_page, page_size);

	};

	onMount(async () => {
		await get_brands();

		// console.log(brands);
		pages = make_pages(brands.length, page_size);

	});
</script>

<div class="wrapper">
	<TitleBar title="Brands" subtitle="view and manage brands">
		<div class="" slot="action">
			<i class="ri-more-2-line text-lg font-bold"></i>
		</div>
	</TitleBar>

	<div class="my-3">
		<Segment>
			<div slot="title">Product Brands</div>
			<div slot="actions" class="">
				<!-- svelte-ignore a11y_consider_explicit_label -->
				<button
					on:click={() => {
						brand_action = 'create';
						show_modal = true;
					}}
					class="ui basic teal button icon mini p-2"
				>
					<i class="plus icon"></i>
				</button>
			</div>

			<div slot="content" class="overflow-x-auto">
				<table class="ui very basic striped unstackable table w-full text-sm">
					<thead>
						<tr class="text-sm">
							<th>No</th>
							<th>Name</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						{#each page_items as brand, i}
							<tr class="text-sm text-slate-700">
								<td>{i + 1}</td>
								<td>{brand.name}</td>

								<td>
									<!-- svelte-ignore a11y_consider_explicit_label -->
									<button
										on:click={() => {
											Confirm.show('Delete', `Delete Brand ${brand.name}?`, 'Yes', 'Cancel', () => {
												delete_brand(brand);
											});
										}}
										class="ui mini red basic icon button"
									>
										<i class="ui red trash icon"></i>
									</button>
									<!-- svelte-ignore a11y_consider_explicit_label -->
									<button
										on:click={() => {
											brand_action = 'Update';

											brand_id = brand.brand_id;
											brand_name = brand.name;

											//show
											show_modal = true;
										}}
										class="ui mini orange basic icon button"
									>
										<i class="ui edit icon"></i>
									</button>
								</td>
							</tr>
						{/each}
					</tbody>
				</table>


				<div class="">
					<Pagination {current_page} {pages} {page_size} items={brands.length}></Pagination>
				</div>
			</div>
		</Segment>
	</div>
</div>

<!-- modal  -->
<Modal bind:open={show_modal} size="xs" autoclose={false} class="w-full">
	<form class="flex flex-col space-y-6" on:submit|preventDefault={brand_form_submit}>
		<h3 class="mb-4 text-xl font-medium capitalize text-gray-900 dark:text-white">
			{brand_action} brand
		</h3>
		<Label class="space-y-2">
			<span>brand</span>
			<Input type="text" name="brand" bind:value={brand_name} placeholder="brand" required />
		</Label>

		<div class="my-2 text-center">
			<button class="ui green mini icon button {brand_action_loading ? 'loading' : ''}">
				<i class="send icon"></i> Submit
			</button>
		</div>
	</form>
</Modal>
<!-- modal -->

<style>
</style>
