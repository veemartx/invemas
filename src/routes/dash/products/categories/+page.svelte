<script>
	import Segment from '$components/segment.svelte';
	import TitleBar from '$components/title-bar.svelte';
	import { API_BASE_URL } from '$lib/config/base-urls';
	import { fetch_resource, post_resource } from '$lib/methods/functions';
	import { onMount } from 'svelte';
	import { Button, Modal, Label, Input, Checkbox, Textarea } from 'flowbite-svelte';
	import { v4 } from 'uuid';
	import axios from 'axios';
	import pkg from 'notiflix';
	import { current_liu, slugify } from '$lib/methods/methods';

	const { Notify, Confirm } = pkg;

	const url = `${API_BASE_URL}products/categories.php`;

	const subcategory_url = `${API_BASE_URL}products/subcategory.php`;

	const resource = 'categories';

	const lia = current_liu();

	let category_action_loading = false;

	let subcategory_action_loading = false;

	let categories;

	let show_modal = false;

	let category_action = 'create';

	let category_id;

	let category;

	let description;

	let selected_category;

	let selected_category_index;

	let category_modal = false;

	let subcategory_modal = false;

	let subcategory;

	// send the data, if id exists update if not create
	const category_form_submit = async () => {
		let cat_id = category_action == 'create' ? v4() : category_id;

		let dt = {
			category_id: cat_id,
			category: category,
			description: description
		};

		//load
		category_action_loading = true;

		try {
			let response = await axios({
				method: 'POST',
				data: dt,
				url: `${API_BASE_URL}categories/cat.php`,
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded'
				}
			});

			let res = response.data;

			if (res.success) {
				Notify.success(res.message);

				await get_categories();

				show_modal = false;
			} else {
				Notify.failure(res.message);
			}
			category_action_loading = false;
		} catch (err) {
			category_action_loading = false;
			console.log(err);
		}
	};

	const delete_category = async (category) => {
		let dt = {
			category_id: category.category_id,
			name: category.name
		};

		try {
			let response = await axios({
				method: 'POST',
				data: dt,
				url: `${API_BASE_URL}categories/delete.php`,
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded'
				}
			});

			let res = response.data;

			if (res.success) {
				Notify.success(res.message);

				await get_categories();
			} else {
				Notify.failure(res.message);
			}
		} catch (err) {
			console.log(err);
		}
	};

	const get_categories = async () => {
		const res = await fetch_resource(resource, url);

		categories = res.data;
	};

	const reset_form = (id) => {
		document.getElementById(id).reset();
	};

	const subcategory_action = async () => {
		let headers = { 'Content-Type': 'application/x-www-form-urlencoded' };

		let dt = {
			subcategory_id: v4(),
			category_id: selected_category.category_id,
			category_name: selected_category.name,
			subcategory_name: subcategory,
			slug: slugify(subcategory),
			init: lia.name
		};

		subcategory_action_loading = true;

		try {
			let res = await post_resource('category', subcategory_url, dt, headers);

			if (res.success) {
				Notify.success(res.message);

				reset_form('subcategory-action-form');

				//hide modal
				subcategory_action_loading = false;
				subcategory_modal = false;

				// refresh category
				await get_categories();

				selected_category = categories[selected_category_index];
			} else {
				Notify.failure(res.message);
			}
		} catch (err) {
			console.log(err);
		}
	};

	onMount(async () => {
		await get_categories();

		// console.log(categories);
	});
</script>

<div class="wrapper">
	<TitleBar title="Categories" subtitle="view and manage product categories">
		<div class="" slot="action">
			<i class="ri-more-2-line text-lg font-bold"></i>
		</div>
	</TitleBar>

	<div class="my-3">
		<Segment>
			<div slot="title">Products Categories</div>
			<div slot="actions" class="">
				<!-- svelte-ignore a11y_consider_explicit_label -->
				<button onclick={() => (show_modal = true)} class="ui basic teal button icon mini p-2">
					<i class="plus icon"></i>
				</button>
			</div>

			<div slot="content" class="overflow-x-auto">
				<table class="ui very basic striped unstackable table w-full text-sm">
					<thead>
						<tr class="text-sm">
							<th>No</th>
							<th>Name</th>
							<th>Description</th>
							<th>Subcategories</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						{#each categories as cat, i}
							<tr class="text-sm text-slate-700">
								<td>{i + 1}</td>
								<td>{cat.name}</td>
								<td>{cat.description}</td>
								<td>{cat.subcategories.length}</td>
								<td>
									<!-- svelte-ignore a11y_consider_explicit_label -->
									<button
										onclick={() => {
											Confirm.show(
												'Delete',
												`Delete Category ${cat.name}?`,
												'Yes',
												'Cancel',
												() => {
													delete_category(cat);
												}
											);
										}}
										class="ui mini red basic icon button"
									>
										<i class="ui red trash icon"></i>
									</button>
									<!-- svelte-ignore a11y_consider_explicit_label -->
									<button
										onclick={() => {
											category_action = 'Update';

											category_id = cat.category_id;
											category = cat.name;
											description = cat.description;

											//show
											show_modal = true;
										}}
										class="ui mini orange basic icon button"
									>
										<i class="ui edit icon"></i>
									</button>

									<!-- svelte-ignore a11y_consider_explicit_label -->
									<button
										onclick={() => {
											selected_category = cat;
											selected_category_index = i;

											//show
											category_modal = true;
										}}
										class="ui mini purple basic icon button"
									>
										<i class="ui right arrow icon"></i>
									</button>
								</td>
							</tr>
						{/each}
					</tbody>
				</table>
			</div>
		</Segment>
	</div>
</div>

<!--create update modal  -->
<Modal bind:open={show_modal} size="xs" autoclose={false} class="w-full">
	<form
		class="flex flex-col space-y-6"
		onsubmit={(e) => {
			e.preventDefault();
			category_form_submit();
		}}
	>
		<h3 class="mb-4 text-xl font-medium capitalize text-gray-900 dark:text-white">
			{category_action} Category
		</h3>
		<Label class="space-y-2">
			<span>Category</span>
			<Input type="text" name="category" bind:value={category} placeholder="category" required />
		</Label>
		<Label class="space-y-2">
			<span>Description</span>
			<Textarea name="description" bind:value={description} placeholder="description" required />
		</Label>

		<div class="my-2 text-center">
			<button class="ui green mini icon button {category_action_loading ? 'loading' : ''}">
				<i class="send icon"></i> Submit
			</button>
		</div>
	</form>
</Modal>
<!--create update modal -->

<!-- category modal  -->
{#if selected_category}
	<Modal bind:open={category_modal} size="md" autoclose={false} class="w-full">
		<div class="border-b-2 py-1 text-lg font-bold">
			{selected_category.name}
		</div>

		<div class="">
			<p class="text-sm">
				{selected_category.description}
			</p>
		</div>

		<div class="flex items-end justify-between border-b-2 border-b-gray-200 py-2">
			<div class="text-large font-semibold">Subcategories</div>

			<div class="">
				<!-- svelte-ignore a11y_consider_explicit_label -->
				<button
					onclick={() => {
						subcategory_modal = true;
					}}
					class=" ui mini teal icon button p-0"
				>
					<i class="plus icon"></i>
				</button>
			</div>
		</div>

		<div class="">
			<table class="ui basic striped unstackable table">
				<thead>
					<tr class="text-sm text-slate-200">
						<td><b>No</b></td>
						<td><b>Name</b></td>
						<td><b>Actions</b></td>
					</tr>
				</thead>
				<tbody>
					{#each selected_category.subcategories as sc, i}
						<tr class="text-sm text-slate-200">
							<td>{i + 1}</td>
							<td>{sc.name}</td>
							<td>
								<!-- svelte-ignore a11y_consider_explicit_label -->
								<button class="ui mini icon basic orange button text-xs">
									<i class="edit icon"></i>
								</button>

								<!-- svelte-ignore a11y_consider_explicit_label -->
								<button class="ui mini icon basic red button text-xs">
									<i class="trash icon"></i>
								</button>
							</td>
						</tr>
					{/each}
				</tbody>
			</table>
		</div>
	</Modal>
{/if}

<!-- category modal  -->

<!--create update subcategory modal  -->
<Modal bind:open={subcategory_modal} size="xs" autoclose={false} class="w-full">
	<form
		class="flex flex-col space-y-6"
		id="subcategory-action-form"
		onsubmit={(e) => {
			e.preventDefault();
			subcategory_action();
		}}
	>
		<h3 class="mb-4 text-xl font-medium capitalize text-gray-900 dark:text-white">
			Add Subcategory
		</h3>
		<Label class="space-y-2">
			<span>Name</span>
			<Input
				type="text"
				name="subcategory"
				bind:value={subcategory}
				placeholder="subcategory name"
				required
			/>
		</Label>

		<div class="my-2 text-center">
			<button class="ui green mini icon button {subcategory_action_loading ? 'loading' : ''}">
				<i class="send icon"></i> Submit
			</button>
		</div>
	</form>
</Modal>

<!--create update subcategory modal -->
<style>
</style>
