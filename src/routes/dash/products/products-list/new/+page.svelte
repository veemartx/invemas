<script>
	import Search from '$components/search.svelte';
	import Segment from '$components/segment.svelte';
	import TitleBar from '$components/title-bar.svelte';
	import { API_BASE_URL } from '$lib/config/base-urls';
	import { current_liu } from '$lib/methods/methods';
	import axios from 'axios';
	import { pack } from 'pdfmake/src/helpers';
	import { asIconData } from 'svelte-ux/utils/icons';
	import { v4 } from 'uuid';
	import pkg from 'notiflix';
	import { goto } from '$app/navigation';
	import { onMount } from 'svelte';
	import { fetch_resource } from '$lib/methods/functions';
	const { Notify } = pkg;

	let search_url = `${API_BASE_URL}search.php`;

	let create_url = `${API_BASE_URL}products/new.php`;

	let adding_product = false;

	let categories = [];

	let subcategories = [];

	let brands = [];

	let manufacturers = [];

	let name;
	let code;

	let category;
	let subcategory;
	let brand;

	let manufacturer;
	let pack_size;

	let cost_price;
	let trade_price;
	let retail_price;
	let discount;

	let description;
	let sold_as;
	let vat;
	let qty;
	let slug;
	let images_url;

	const add_product = async () => {
		let dt = {
			product_id: v4(),
			name: name,
			code: code,
			category: category,
			subcategory: subcategory,
			brand: brand,
			manufacturer: manufacturer,
			pack_size: pack_size,
			cost_price: cost_price,
			trade_price: trade_price,
			retail_price: retail_price,
			discount: discount,
			description: description,
			sold_as: sold_as,
			vat: vat,
			qty: qty,
			images_url: images_url,
			slug: slug,
			init: current_liu().name
		};

		// load
		adding_product = true;

		try {
			let response = await axios({
				method: 'POST',
				data: dt,
				url: `${create_url}`,
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded'
				}
			});

			let res = response.data;

			console.log(res);

			if (res.success) {
				// alert(res.message)

				Notify.success(res.message);

				goto('/dash/products');
			} else {
				Notify.failure(res.message);

				window.location.reload();
			}

			adding_product = false;
		} catch (err) {
			console.log(err);
		}
	};

	onMount(async () => {
		// get categories
		let cat_res = await fetch_resource('categories', `${API_BASE_URL}products/categories.php`);

		let brand_res = await fetch_resource('brands', `${API_BASE_URL}products/brands.php`);

		let manufacturer_res = await fetch_resource(
			'manufacturers',
			`${API_BASE_URL}products/manufacturers.php`
		);

		categories = cat_res.data;

		brands = brand_res.data;

		manufacturers = manufacturer_res.data;

		// console.log(cat_res.data);
	});
</script>

<main>
	<TitleBar title="New List Product" subtitle="create/add list product">
		<div class="" slot="action">
			<i class="ri-more-2-line text-lg font-bold"></i>
		</div>
	</TitleBar>

	<div class="my-3">
		<Segment>
			<div
				class="	<!-- // search -->

"
				slot="content"
			>
				<form on:submit|preventDefault={add_product} class="text-sm text-slate-900">
					<div class="flex flex-col justify-between md:flex-row">
						<div class="p-2">
							<label for="name">Name</label> <br />
							<input
								class="w-full"
								type="text"
								name="name"
								id="name"
								bind:value={name}
								placeholder="Product Name"
								readonly
							/>
						</div>

						<div class="p-2">
							<label for="code">Code</label> <br />
							<input
								class="w-full"
								type="text"
								name="code"
								id="code"
								bind:value={code}
								placeholder="Product Code"
							/>
						</div>

						<div class="p-2">
							<label for="code">Pack Size</label> <br />
							<input
								class="w-full"
								type="text"
								name="pack_size"
								id="pack_size"
								bind:value={pack_size}
								placeholder="Pack Size"
							/>
						</div>

						<div class="p-2">
							<label for="code">Sold As</label> <br />
							<input
								class="w-full"
								type="text"
								name="sold_as"
								id="sold_as"
								bind:value={sold_as}
								placeholder="Sold As"
							/>
						</div>
					</div>

					<div class="flex flex-col justify-between md:flex-row">
						<div class="p-2">
							<label for="name">Category</label> <br />

							<select name="category" id="category" required>
								<option value="">Select category</option>
								{#each categories as cat}
									<option value={cat.name}>{cat.name}</option>
								{/each}
							</select>
						</div>

						<div class="p-2">
							<label for="code">Subcategory</label> <br />
							{#if category}
								<select name="subcategory" id="subcategory" required>
									<option value="">Select subcategory</option>
									{#each subcategories as scat}
										<option value={scat.name}>{scat.name}</option>
									{/each}
								</select>
							{:else}
								<select name="subcategory" id="subcategory" disabled required>
									<option value="">Select subcategory</option>
									{#each subcategories as scat}
										<option value={scat.name}>{scat.name}</option>
									{/each}
								</select>
							{/if}
						</div>

						<div class="p-2">
							<label for="code">Brand</label> <br />
							<select name="brand" id="brand" required>
								<option value="">Select brand</option>
								{#each brands as brand}
									<option value={brand.name}>{brand.name}</option>
								{/each}
							</select>
						</div>

						<div class="p-2">
							<label for="code">Manufacturer</label> <br />
							<select name="manufacturer" id="manufacturer" required>
								<option value="">Select Manufacturer</option>
								{#each manufacturers as man}
									<option value={man.name}>{man.name}</option>
								{/each}
							</select>
						</div>
					</div>

					<div class="flex flex-col justify-between md:flex-row">
						<div class="p-2">
							<label for="name">Trade Price</label> <br />
							<input
								class="w-full"
								type="number"
								name="trade_price"
								id="trade_price"
								bind:value={trade_price}
								placeholder="0.00"
							/>
						</div>

						<div class="p-2">
							<label for="cost_price">Cost Price</label> <br />
							<input
								class="w-full"
								type="number"
								name="cost_price"
								id="cost_price"
								bind:value={cost_price}
								placeholder="0.00"
							/>
						</div>

						<div class="p-2">
							<label for="retail_price">Retail Price</label> <br />
							<input
								class="w-full"
								type="number"
								name="retail_price"
								id="retail_price"
								bind:value={retail_price}
								placeholder="0.00"
							/>
						</div>

						<div class="p-2">
							<label for="discount">Discount</label> <br />
							<input
								class="w-full"
								type="number"
								name="discount"
								id="discount"
								bind:value={discount}
								placeholder="0"
							/>
						</div>
					</div>

					<div class="flex flex-col justify-between md:flex-row">
						<div class="p-2">
							<label for="name">VAT</label> <br />
							<input
								class="w-full"
								type="number"
								name="vat"
								id="vat"
								bind:value={vat}
								placeholder="VAT"
							/>
						</div>
					</div>

					<div class="flex flex-col justify-between md:flex-row">
						<div class="flex-1 p-2">
							<label for="name">Description</label> <br />
							<textarea
								class="w-full"
								name="description"
								id="description"
								placeholder="Product Description"
								rows="10"
								bind:value={description}
								required
							></textarea>
						</div>
					</div>

					<div class="p-2 text-center">
						<button type="submit" class="ui basic purple button {adding_product ? 'loading' : ''}">
							<i class="send icon"></i> Create
						</button>
					</div>
				</form>
			</div>
		</Segment>
	</div>
</main>

<style>
	input {
		border-radius: 5px;
	}

	textarea {
		border-radius: 5px;
	}
</style>
