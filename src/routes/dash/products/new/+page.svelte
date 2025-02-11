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
	const { Notify } = pkg;

	let search_url = `${API_BASE_URL}search.php`;

	let create_url = `${API_BASE_URL}products/new.php`;

	let adding_product = false;

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

	const reset_form=(id)=>{
		document.getElementById(id).reset();
	}

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
			images_url:images_url,
			slug:slug,
			init:current_liu().name,
		};

		// load
		adding_product=true;

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

			if(res.success){
				// alert(res.message)

				Notify.success(res.message);

				reset_form('create-product-form');
				

			}else{
				Notify.failure(res.message);

				// window.location.reload();
			}

			adding_product=false;

		} catch (err) {
			console.log(err);
		}
	};
</script>

<main>
	<TitleBar title="New Product" subtitle="create/add stock product">
		<div class="" slot="action">
			<i class="ri-more-2-line text-lg font-bold"></i>
		</div>
	</TitleBar>

	<!-- // search  -->

	<div class="">
		<Search
			url={search_url}
			on:selected={(e) => {
				name = e.detail.name;
				code = e.detail.code;
				pack_size = e.detail.pack_size;
				sold_as = e.detail.sold_as;
				category = e.detail.category;
				subcategory = e.detail.subcategory;
				brand = e.detail.brand;
				manufacturer = e.detail.manufacturer;
				trade_price = e.detail.trade_price;
				cost_price = e.detail.cost_price;
				retail_price = e.detail.retail_price;
				discount = e.detail.discount;
				vat = e.detail.vat;
				description = e.detail.description;
				images_url=e.detail.images_url;
				slug=e.detail.slug;

				// console.log(e.detail);
			}}
		></Search>
	</div>

	<div class="my-3">
		<Segment>
			<div class="" slot="content">
				<form on:submit|preventDefault={add_product} id="create-product-form" class="text-slate-900">
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
								readonly
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
								readonly
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
								readonly
							/>
						</div>
					</div>

					<div class="flex flex-col justify-between md:flex-row">
						<div class="p-2">
							<label for="name">Category</label> <br />
							<input
								class="w-full"
								type="text"
								name="category"
								id="category"
								bind:value={category}
								placeholder="category"
								readonly
							/>
						</div>

						<div class="p-2">
							<label for="code">Subcategory</label> <br />
							<input
								class="w-full"
								type="text"
								name="subcategory"
								id="subcategory"
								bind:value={subcategory}
								placeholder="Subcategory"
								readonly
							/>
						</div>

						<div class="p-2">
							<label for="code">Brand</label> <br />
							<input
								class="w-full"
								type="text"
								name="brand"
								id="brand"
								bind:value={brand}
								placeholder="Brand"
								readonly
							/>
						</div>

						<div class="p-2">
							<label for="code">Manufacturer</label> <br />
							<input
								class="w-full"
								type="text"
								name="manufacturer"
								id="manufacturer"
								bind:value={manufacturer}
								placeholder="Manufacturer"
								readonly
							/>
						</div>
					</div>

					<div class="flex flex-col justify-between md:flex-row">
						<div class="p-2">
							<label for="name">Trade Price</label> <br />
							<input
								class="w-full"
								type="text"
								name="trade_price"
								id="trade_price"
								bind:value={trade_price}
								placeholder="Trade Price"
								readonly
							/>
						</div>

						<div class="p-2">
							<label for="cost_price">Cost Price</label> <br />
							<input
								class="w-full"
								type="text"
								name="cost_price"
								id="cost_price"
								bind:value={cost_price}
								placeholder="Cost Price"
								readonly
							/>
						</div>

						<div class="p-2">
							<label for="retail_price">Retail Price</label> <br />
							<input
								class="w-full"
								type="text"
								name="retail_price"
								id="retail_price"
								bind:value={retail_price}
								placeholder="Retail Price"
								readonly
							/>
						</div>

						<div class="p-2">
							<label for="discount">Discount</label> <br />
							<input
								class="w-full"
								type="text"
								name="discount"
								id="discount"
								bind:value={discount}
								placeholder="Discount"
								readonly
							/>
						</div>
					</div>

					<div class="flex flex-col justify-between md:flex-row">
						<div class="p-2">
							<label for="name">VAT</label> <br />
							<input
								class="w-full"
								type="text"
								name="vat"
								id="vat"
								bind:value={vat}
								placeholder="VAT"
								readonly
							/>
						</div>

						<div class="p-2">
							<label for="qty">Qty</label> <br />
							<input
								class="w-full"
								type="number"
								name="qty"
								id="qty"
								bind:value={qty}
								placeholder="Stock Qty"
								required
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
