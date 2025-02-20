<script>
	import Search from '$components/search.svelte';
	import Segment from '$components/segment.svelte';
	import TitleBar from '$components/title-bar.svelte';
	import { API_BASE_URL } from '$lib/config/base-urls';
	import { current_liu, slugify } from '$lib/methods/methods';
	import axios from 'axios';
	import { pack } from 'pdfmake/src/helpers';
	import { asIconData } from 'svelte-ux/utils/icons';
	import { v4 } from 'uuid';
	import pkg from 'notiflix';
	import { goto } from '$app/navigation';
	import { onMount } from 'svelte';
	import { fetch_resource } from '$lib/methods/functions';
	import { browser } from '$app/environment';
	import { Button, Input, Label, Select, Textarea } from 'flowbite-svelte';
	import AdditionsIcon from '$assets/icons//product-additions.png';
	import UploadIcon from '$assets/icons/upload.png';

	const { Notify } = pkg;

	const toolbar_options = [
		['bold', 'italic', 'underline', 'strike'], // toggled buttons
		['blockquote', 'code-block'],

		[{ header: 1 }, { header: 2 }], // custom button values
		[{ list: 'ordered' }, { list: 'bullet' }],
		[{ script: 'sub' }, { script: 'super' }], // superscript/subscript
		[{ indent: '-1' }, { indent: '+1' }], // outdent/indent
		[{ direction: 'rtl' }], // text direction

		[{ size: ['small', false, 'large', 'huge'] }], // custom dropdown
		[{ header: [1, 2, 3, 4, 5, 6, false] }],
		['link', 'image', 'video', 'formula'], // add's image support
		[{ color: [] }, { background: [] }], // dropdown with defaults from theme
		[{ font: [] }],
		[{ align: [] }],

		['clean'] // remove formatting button
	];

	const liu = current_liu();

	const search_url = `${API_BASE_URL}search.php`;

	const create_url = `${API_BASE_URL}product-list/new.php`;

	const create_form_id="create-list-product";

	let sale_types = [
		{
			name: 'Assorted',
			value: 'assorted'
		},
		{
			name: 'Packs',
			value: 'packs'
		},
		{
			name: 'Pieces',
			value: 'pieces'
		}
	];

	let adding_product = false;

	let categories = [];

	let subcategories = [];

	let filtered_subcategories=[];

	let brands = [];

	let manufacturers = [];

	let product_featured_image = [];

	let product_gallery = [];

	let keywords = [];

	let editor;

	let name;

	let category;
	let subcategory = '';
	let brand;

	let manufacturer;
	let pack_size;

	let cost_price;
	let trade_price;
	let retail_price;
	let discount=0;

	let short_description;

	let description;
	let sold_as;
	let vat = 16;
	let images_url;

	let current_keyword;

	const update_retail_price = (cost_price) => {
		retail_price = cost_price * 1.4;
	};

	const reset_form=(id)=>{
		document.getElementById(id).reset();
	}

	const add_product = async () => {
		let dt = {
			product_id: v4(),
			name: name,
			category: category,
			subcategory: subcategory,
			brand: brand,
			manufacturer: manufacturer,
			pack_size: pack_size,
			cost_price: cost_price,
			trade_price: trade_price,
			retail_price: retail_price,
			discount: discount,
			short_description: short_description,
			description: description,
			sold_as: sold_as,
			vat: vat,
			images_url: images_url,
			slug: slugify(name),
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

			// console.log(res);

			if (res.success) {
				// alert(res.message)

				Notify.success(res.message);

				// reset_form(create_form_id);
			} else {
				Notify.failure(res.message);
			}

			adding_product = false;
		} catch (err) {
			console.log(err);
		}
	};

	const filter_subcategories=(category)=>{
		const filtered=subcategories.filter((sc)=>{
			if(sc.category==category){
				return sc;
			}
		})

		console.log(filtered);
		subcategory="";
		filtered_subcategories=filtered;
	}

	onMount(async () => {
		//init quill
		const { default: Quill } = await import('quill');

		let quill = new Quill(editor, {
			modules: {
				toolbar: toolbar_options
			},
			theme: 'snow',
			placeholder: 'Product Description'
		});

		quill.on('text-change', () => {
			description = quill.root.innerHTML;
		});

		// get categories
		let cat_res = await fetch_resource('categories', `${API_BASE_URL}products/categories.php`);

		let brand_res = await fetch_resource('brands', `${API_BASE_URL}products/brands.php`);

		let scat_res = await fetch_resource('subcategories', `${API_BASE_URL}products/subcategories.php`);


		let manufacturer_res = await fetch_resource(
			'manufacturers',
			`${API_BASE_URL}products/manufacturers.php`
		);

		categories = cat_res.data;

		brands = brand_res.data;

		manufacturers = manufacturer_res.data;

		subcategories=scat_res.data;


		// console.log(scat_res.data);
	});
</script>

<main>
	<TitleBar title="New List Product" subtitle="create/add list product">
		<div class="" slot="action">
			<i class="ri-more-2-line text-lg font-bold"></i>
		</div>
	</TitleBar>

	<div class="my-3">
		<div class="	<!-- // search -->">
			<form
				onsubmit={(e) => {
					e.preventDefault();
					add_product();
				}}
				id="create-list-product"
				class="text-sm text-slate-900"
			>
				<div class="form-container flex flex-col gap-2 md:flex-row">
					<div class="main-col px-2">
						<div class="">
							<Segment>
								<div class="title" slot="title">Product Title</div>
								<div class="content" slot="content">
									<!-- title code  -->
									<div
										class="title-desc flex flex-col justify-between
md:flex-row"
									>
										<div class="flex-auto p-2">
											<label for="name">Name</label> <br />
											<input
												class="w-full"
												type="text"
												name="name"
												id="name"
												bind:value={name}
												placeholder="Product Name"
												required
											/>
										</div>
										<!-- title  -->
									</div>

									<!-- descriptions  -->
									<div class="mt-5 p-2">
										<label for="short_description" class="mb-2"
											>Short Description <span class="text-xs font-semibold italic text-invm_red">
												(Max {short_description ? 200 - short_description.length : 200} Chars)</span
											></label
										> <br />
										<textarea
											id="short_description"
											class="mt-2 w-full"
											placeholder="Short Description"
											rows="3"
											maxlength="200"
											name="short_description"
											bind:value={short_description}
										></textarea>
									</div>

									<div class="flex-1 p-2">
										<label for="name" class="mb-2">Full Description</label> <br />

										<div class="editor-wrapper mt-2 rounded-sm">
											<div class="editor min-h-48" bind:this={editor}></div>
										</div>
									</div>
									<br />
									<!-- descriptions  -->
								</div>
							</Segment>
						</div>

						<div class="my-4">
							<Segment>
								<div class="title" slot="title">Product Details</div>

								<div class="content mt-2" slot="content">
									<div class="fields flex justify-between">
										<div class="field mx-2 flex-auto">
											<label class="mb-2" for="Trade Price">Trade Price</label>
											<input
												type="number"
												name="trade_price"
												id="trade_price"
												placeholder="0.00"
												step="0.00"
												readonly
												bind:value={trade_price}
											/>
										</div>

										<div class="field mx-2 flex-auto">
											<label class="mb-2" for="Retail Price">Cost Price</label>
											<input
												type="number"
												name="price"
												id="price"
												placeholder="0.00"
												step="0.00"
												bind:value={cost_price}
												onkeyup={(e) => {
													console.log(e.target.value);
													if (e.target.value) {
														update_retail_price(e.target.value);

														//set trade price
														trade_price = e.target.value;
													} else {
														retail_price = '';
														trade_price = '';
													}
												}}
											/>
										</div>
									</div>
									<div class="fields flex justify-between py-4">
										<div class="field mx-2 flex-auto">
											<label class="mb-2" for="Retail Price">Retail Price</label> <br />
											<input
												type="number"
												name="retail_price"
												id="retail_price"
												placeholder="0.00"
												step="0.00"
												readonly
												bind:value={retail_price}
											/>
										</div>

										<div class="field mx-2 flex-auto">
											<label class="mb-2" for="Retail Price"
												>Discount(%) <span class="italic text-invm_red">Allowable</span></label
											> <br />
											<input
												type="number"
												name="discount"
												id="discount"
												placeholder="0"
												bind:value={discount}
											/>
										</div>
									</div>
								</div>
							</Segment>
						</div>
					</div>

					<div class="side-col">
						<div class="">
							<Segment>
								<div class="title" slot="title">Extra Details</div>

								<div class="content mt-2" slot="content">
									<div class="flex justify-between gap-2">
										<div class="flex-auto">
											<label class="mb-2" for="pack_size">Pack Size</label> <br />
											<input
												type="number"
												name="pack_size"
												id="pack_size"
												placeholder="Pack Size"
												bind:value={pack_size}
												min="1"
												required
											/>
										</div>

										<div class="field flex-auto">
											<label for="sale_types" class="mb-2">Sold As</label> <br />
											<select name="sold_as" id="sold_as" bind:value={sold_as} required>
												<option value="">Select Option</option>
												{#each sale_types as st}
													<option value={st.value}>{st.name}</option>
												{/each}
											</select>
										</div>
									</div>
								</div>
							</Segment>
						</div>

						<div class="my-4">
							<Segment>
								<div class="title" slot="title">Product Categories</div>

								<div class="content mt-2" slot="content">
									<div class="flex flex-col justify-between gap-2">
										<div class="flex-auto">
											<label for="name">Category</label> <br />

											<select name="category" id="category" bind:value={category} onchange={(e)=>{

												if(e.target.value){
													filter_subcategories(e.target.value);
												}else{
													subcategory="";
												}
											}} required>
												<option value="">Select category</option>
												{#each categories as cat}
													<option value={cat.name}>{cat.name}</option>
												{/each}
											</select>
										</div>


										<div class="flex-auto">
											<label for="name">Subcategory</label> <br />

											<select name="subcategory" id="subcategory" bind:value={subcategory} required>
												<option value="">Select subcategory</option>
												{#each filtered_subcategories as scat}
													<option value={scat.name}>{scat.name}</option>
												{/each}
											</select>
										</div>


										<div class="field flex-auto">
											<label for="code">Brand</label> <br />
											<select name="brand" id="brand" bind:value={brand}>
												<option value="">Select brand</option>
												{#each brands as brand}
													<option value={brand.name}>{brand.name}</option>
												{/each}
											</select>
										</div>

										<div class="field flex-auto">
											<label for="code">Manufacturer</label> <br />
											<select name="manufacturer" id="manufacturer" bind:value={manufacturer}>
												<option value="">Select Manufacturer</option>
												{#each manufacturers as man}
													<option value={man.name}>{man.name}</option>
												{/each}
											</select>
										</div>
									</div>
								</div>
							</Segment>
						</div>

						<div class="my-4">
							<Segment>
								<div class="" slot="title">Submit</div>
								<div class="" slot="content">
									<div class="py-4 text-center">
										<button type="reset" class="ui basic red mini button">
											<i class="trash icon"></i> Clear
										</button>

										<button
											type="submit"
											class="ui basic green mini button {adding_product ? 'loading' : ''}"
										>
											<i class="send icon"></i> Create
										</button>
									</div>
								</div>
							</Segment>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</main>

<style>
	input {
		border-radius: 5px;
		font-size: small;
		width: 100%;
	}

	textarea {
		border-radius: 5px;
		font-size: small;
		width: 100%;
	}

	select {
		border-radius: 5px;
		font-size: small;
		width: 100%;
	}

	.main-col {
		flex: 3;
	}

	.side-col {
		flex: 1;
	}
</style>
