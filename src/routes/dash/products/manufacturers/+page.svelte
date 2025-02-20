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

	const url = `${API_BASE_URL}products/manufacturers.php`;

	const resource = 'manufacturers';

	let show_modal = false;

	let manufacturers = [];

	let manufacturer;

	let manufacturer_id;

	let manufacturer_action = 'create';

	let manufacturer_action_loading = false;

	let current_page = 1;

	let page_size = 50;

	let page_items = [];

	let pages = [];

	$: {
		if ($page) {
			current_page = get_current_page($page.url.search);

			page_items = update_page(manufacturers, current_page, page_size);
		}
	}

	// send the data, if id exists update if not create
	const manufacturer_form_submit = async () => {
		let mn_id = manufacturer_action == 'create' ? v4() : manufacturer_id;

		let dt = {
			manufacturer_id: mn_id,
			manufacturer: manufacturer
		};

		//load
		manufacturer_action_loading = true;

		try {
			let response = await axios({
				method: 'POST',
				data: dt,
				url: `${API_BASE_URL}manufacturers/manufacturer.php`,
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded'
				}
			});

			let res = response.data;

			if (res.success) {
				Notify.success(res.message);

				await get_manufacturers();

				show_modal = false;
			} else {
				Notify.failure(res.message);
			}
			manufacturer_action_loading = false;
		} catch (err) {
			manufacturer_action_loading = false;
			console.log(err);
		}
	};

	const delete_manufacturer = async (manufacturer) => {
		let dt = {
			manufacturer_id: manufacturer.manufacturer_id,
			name: manufacturer.name
		};

		try {
			let response = await axios({
				method: 'POST',
				data: dt,
				url: `${API_BASE_URL}manufacturers/delete.php`,
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded'
				}
			});

			let res = response.data;

			if (res.success) {
				Notify.success(res.message);

				await get_manufacturers();
			} else {
				Notify.failure(res.message);
			}
		} catch (err) {
			console.log(err);
		}
	};

	const get_manufacturers = async () => {
		const res = await fetch_resource(resource, url);

		manufacturers = res.data;
	};

	onMount(async () => {
		await get_manufacturers();

		// console.log(manufacturers);
		pages = make_pages(manufacturers.length, page_size);
	});
</script>

<div class="wrapper">
	<TitleBar title="Manufacturers" subtitle="view and manage manufacturers">
		<div class="" slot="action">
			<i class="ri-more-2-line text-lg font-bold"></i>
		</div>
	</TitleBar>

	<div class="my-3">
		<Segment>
			<div slot="title">Products Manufacturers</div>
			<div slot="actions" class="">
				<!-- svelte-ignore a11y_consider_explicit_label -->
				<button
					on:click={() => {
						manufacturer_action = 'create';
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
						{#each page_items as man, i}
							<tr class="text-sm text-slate-700">
								<td>{i + 1}</td>
								<td>{man.name}</td>
								<td>
									<!-- svelte-ignore a11y_consider_explicit_label -->
									<button
										on:click={() => {
											Confirm.show(
												'Delete',
												`Delete Manufacturer ${man.name}?`,
												'Yes',
												'Cancel',
												() => {
													delete_manufacturer(man);
												}
											);
										}}
										class="ui mini red basic icon button"
									>
										<i class="ui red trash icon"></i>
									</button>
									<!-- svelte-ignore a11y_consider_explicit_label -->
									<button
										on:click={() => {
											manufacturer_action = 'Update';

											manufacturer_id = man.manufacturer_id;
											manufacturer = man.name;

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
					<Pagination {current_page} {pages} {page_size} items={manufacturers.length}></Pagination>
				</div>
			</div>
		</Segment>
	</div>
</div>

<!-- modal  -->
<Modal bind:open={show_modal} size="xs" autoclose={false} class="w-full">
	<form class="flex flex-col space-y-6" on:submit|preventDefault={manufacturer_form_submit}>
		<h3 class="mb-4 text-xl font-medium capitalize text-gray-900 dark:text-white">
			{manufacturer_action} Manufacturer
		</h3>
		<Label class="space-y-2">
			<span>Name</span>
			<Input
				type="text"
				name="manufacturer"
				bind:value={manufacturer}
				placeholder="manufacturer"
				required
			/>
		</Label>

		<div class="my-2 text-center">
			<button class="ui green mini icon button {manufacturer_action_loading ? 'loading' : ''}">
				<i class="send icon"></i> Submit
			</button>
		</div>
	</form>
</Modal>

<!-- modal -->

<style>
</style>
