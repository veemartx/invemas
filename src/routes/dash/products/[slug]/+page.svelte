<script>
	import TitleBar from '$components/title-bar.svelte';
	import { page } from '$app/stores';
	import { API_BASE_URL } from '$lib/config/base-urls';
	import pkg from 'notiflix';
	import axios from 'axios';
	import { onMount } from 'svelte';
	import Segment from '$components/segment.svelte';
	import PlaceholderImage from '$assets/images/placeholder-image.jpg';
	import { fetch_resource, post_resource } from '$lib/methods/functions';
	import { Checkbox, Label, Modal } from 'flowbite-svelte';
	import { Input } from 'svelte-ux';
	import { current_liu, format_date } from '$lib/methods/methods';
	import { v4 } from 'uuid';

	const { Notify } = pkg;

	const resource = 'product';

	const lia = current_liu();

	// get the slug
	const slug = $page.params.slug;

	const product_url = `${API_BASE_URL}products/get.php?p=${slug}`;

	const sale_url = `${API_BASE_URL}products/sale-edit.php`;

	let product;

	let sale_edit_modal = false;

	let sale_price;

	let discount;

	let sale_qty;

	let sale_edit_loading = false;

	const update_discount = () => {
		//update discount
		if (!sale_price) {
			discount = product.retail_price - 0;
		} else {
			discount = product.retail_price - sale_price;
		}
	};

	const sale_edit = async () => {
		let headers = { 'Content-Type': 'application/x-www-form-urlencoded' };

		let dt = {
			sale_id: v4(),
			product_id: product.product_id,
			name: product.name,
			code: product.code,
			retail_price: product.retail_price,
			sale_price: sale_price,
			discount: discount,
			sale_qty: sale_qty,
			remaining_qty: product.qty - sale_qty,
			init: lia.name
		};

		sale_edit_loading = true;

		try {
			let res = await post_resource(resource, sale_url, dt, headers);

			// console.log(res);
			await get_product();

			if (res.success) {
				Notify.success(res.message);
			} else {
				Notify.failure(res.message);
			}

			setTimeout(() => {
				sale_edit_modal = false;

				sale_edit_loading = false;
			}, 1000);
		} catch (err) {
			sale_edit_loading = false;

			console.log(err);
		}
	};

	const get_product = async (slug) => {
		let products_res = await fetch_resource('product', product_url);

		product = products_res.data;

		console.log(product);

		//
		update_discount();
	};

	onMount(async () => {
		await get_product(slug);
	});
</script>

<main>
	<TitleBar title="Product" subtitle="view and manage product">
		<div class="" slot="action">
			<i class="ri-more-2-line text-lg font-bold"></i>
		</div>
	</TitleBar>

	{#if product}
		<div class="my-3">
			<Segment>
				<div class="flex flex-col justify-between gap-2 md:flex-row" slot="content">
					<div class="p-2">
						<img class="md:max-w-72" src={PlaceholderImage} alt="product" />
					</div>

					<div class="flex-auto text-sm text-slate-700">
						<div class="p-2 text-lg font-extrabold md:py-0">
							{product.name}
						</div>

						<div class="flex gap-3 p-2 font-medium text-slate-600">
							<div class="">
								<b>CODE: </b>
								{product.code}
							</div>

							<div class="">
								<b>QTY: </b>
								{product.qty}
							</div>

							<div class="">
								<b>PACK SIZE: </b>
								{product.pack_size}
							</div>

							<div class="">
								<b>SOLD AS: </b>
								{product.sold_as}
							</div>
						</div>

						<div class="flex gap-3 p-2 font-medium text-slate-600">
							<div class="capitalize">
								Category: {product.category}
							</div>

							<div class="capitalize">
								Subcategory: {product.subcategory}
							</div>
						</div>

						<div class="flex gap-3 p-2 font-medium text-slate-600">
							<div class="capitalize">
								Brand: {product.brand}
							</div>

							<div class="capitalize">
								Manufacturer: {product.manufacturer}
							</div>
						</div>

						<div class="flex gap-3 p-2 font-medium text-slate-600">
							<div class="capitalize">
								Cost Price: <span class="font-bold text-invm_red">{product.cost_price}</span>
							</div>

							<div class="capitalize">
								Retail Price: <span class="font-bold text-invm_green">{product.retail_price}</span>
							</div>

							<div class="capitalize">
								Discount: <span class="font-bold">{product.discount}</span>
							</div>
						</div>

						<div class="my-2 p-2">
							<div class="border-b-2 font-semibold">Actions</div>
							<div class="py-3">
								<button
									onclick={() => {
										sale_edit_modal = true;
									}}
									class="ui basic green icon mini button"
								>
									<i class="edit icon"></i> Sale Edit
								</button>

								<button class="ui basic orange icon mini button">
									<i class="edit icon"></i> Adjust
								</button>

								<button class="ui basic red icon mini button">
									<i class="trash icon"></i> Delete
								</button>

								<button class="ui basic purple icon mini button">
									<i class="archive icon"></i> Archive
								</button>
							</div>
						</div>

						<div class="my-2 p-2">
							<div class="border-b-2 font-semibold">Description</div>
							<div class="p-2">
								{@html product.description}
							</div>
						</div>

						<div class="my-2 p-2">
							<div class="border-b-2 font-semibold">Transaction History</div>
							<div class="my-2 p-2">
								<table class="ui basic unstackable striped table">
									<thead>
										<tr>
											<th>No</th>
											<th>Type</th>
											<th>Qty</th>
											<th>Init</th>
											<th>Date</th>
										</tr>
									</thead>
									<tbody>
										{#each product.history as ph,i}
											<tr>
												<td>
													{i+1}
												</td>
												<td class="capitalize">
													{ph.name}
												</td>
												<td>
													{ph.qty}
												</td>
												<td>
													{ph.init}
												</td>
												<td>
													{format_date(ph.created_at)}
												</td>
											</tr>
										{/each}
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</Segment>
		</div>

		<!-- sale edit modal -->
		<Modal bind:open={sale_edit_modal} size="md" autoclose={false} class="w-full">
			<form
				class="flex flex-col space-y-6"
				onsubmit={(e) => {
					e.preventDefault();

					sale_edit();
				}}
			>
				<h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Product Sale Edit</h3>

				<div class="flex flex-col gap-2 md:flex-row">
					<div class="flex-1">
						<Label class="space-y-2">
							<span>Title</span>
							<Input
								class="rounded-sm"
								type="text"
								name="name"
								placeholder="product title"
								bind:value={product.name}
								readonly
							/>
						</Label>
					</div>

					<div class="my-2 flex-1 md:my-0">
						<Label class="space-y-2">
							<span>Code</span>
							<Input
								class="rounded-sm"
								type="text"
								name="code"
								placeholder="product code"
								bind:value={product.code}
								readonly
							/>
						</Label>
					</div>
				</div>

				<div class="flex gap-2">
					<div class="flex-1">
						<Label class="space-y-2">
							<span>Retail Price</span>
							<Input
								class="rounded-sm"
								type="number"
								name="retail_price"
								placeholder="0.00"
								bind:value={product.retail_price}
								readonly
							/>
						</Label>
					</div>

					<div class="flex-1">
						<Label class="space-y-2">
							<span>Discount</span>
							<Input
								class="rounded-sm"
								type="number"
								name="discount"
								bind:value={discount}
								placeholder="0.00"
								readonly
							/>
						</Label>
					</div>
				</div>

				<div class="flex gap-2">
					<div class="flex-1">
						<Label class="space-y-2">
							<span>Sale Price</span>
							<Input
								class="rounded-sm"
								type="number"
								name="sale_price"
								placeholder="0.00"
								bind:value={sale_price}
								max={product.retail_price}
								on:keyup={(e) => {
									if (e.target.value) {
										update_discount();
									}
								}}
								required
							/>
						</Label>
					</div>

					<div class="flex-1">
						<Label class="space-y-2">
							<span>Sale Qty</span>
							<span class="text-xs italic text-invm_green">(Instock <b>{product.qty}</b>)</span>
							<Input
								class="rounded-sm"
								type="number"
								name="qty"
								placeholder="0"
								min="1"
								max={product.qty}
								bind:value={sale_qty}
								required
							/>
						</Label>
					</div>
				</div>

				<div class="p-2 text-center">
					<button
						type="submit"
						class="ui basic teal mini icon button {sale_edit_loading ? 'loading' : ''}"
					>
						<i class="send icon"></i> Submit
					</button>
				</div>
			</form>
		</Modal>
		<!-- sale edit modal -->
	{/if}
</main>
