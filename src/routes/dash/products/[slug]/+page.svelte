<script>
	import TitleBar from '$components/title-bar.svelte';
	import { page } from '$app/stores';
	import { API_BASE_URL } from '$lib/config/base-urls';
	import pkg from 'notiflix';
	import axios from 'axios';
	import { onMount } from 'svelte';
	import Segment from '$components/segment.svelte';
	import PlaceholderImage from '$assets/images/placeholder-image.jpg';

	const { Notify } = pkg;

	let product;

	// get the slug
	let slug = $page.params.slug;
	const get_product = async (slug) => {
		try {
			let response = await axios({
				method: 'get',
				url: `${API_BASE_URL}products/get.php?p=${slug}`
			});

			if (!response.data.success) {
				Notify.failure(response.data.message);

				return;
			}

			product = response.data.detail;

			console.log(product);
		} catch (err) {
			console.log(err);
		}
	};

	onMount(async () => {
		// const res = await fetch_resource(resource, url);

		get_product(slug);
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
								<button class="ui basic green icon mini button">
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
							<div class="p-2 my-2">
								<table class="ui basic unstackable striped table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Transaction</th>
                                            <th>Init</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                </table>
							</div>
						</div>
                        
                  
					</div>
				</div>
			</Segment>
		</div>
	{/if}
</main>
