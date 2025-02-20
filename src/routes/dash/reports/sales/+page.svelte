<script>
	import Segment from '$components/segment.svelte';
	import { API_BASE_URL } from '$lib/config/base-urls';
	import { fetch_resource } from '$lib/methods/functions';
	import { onMount } from 'svelte';

	const stats_url=`${API_BASE_URL}sales/stats.php`;


	const resource="sales";


	let category;

	let subcategory;

	let brand;

	let manufacturer;

	let addition_date_from;

	let addition_date_to;

	let quick_access_links;

	// let quick_access_links = [
	// 	{
	// 		name: 'All Sales',
	// 		value: 2000,
	// 		icon: ``
	// 	},
	// 	{
	// 		name: 'Sales Today',
	// 		value: 120,
	// 		icon: ''
	// 	},
	// 	{
	// 		name: 'Top Products',
	// 		value: 10,
	// 		icon: ''
	// 	},
	// 	{
	// 		name: 'Top Categories',
	// 		value: 18,
	// 		icon: ''
	// 	},
	// 	{
	// 		name: 'Top Brands',
	// 		value: 8,
	// 		icon: ''
	// 	},
	// 	{
	// 		name: 'Top Manufacturers',
	// 		value: 8,
	// 		icon: ''
	// 	}
	// ];

	const get_stats=async()=>{

		const res=await fetch_resource(resource,stats_url);

		quick_access_links=res.data;
	}

	onMount(async()=>{
		await get_stats();
	})
</script>

<main>
	<div class="">
		<Segment>
			<div class="" slot="title">
				<div class="">Sale Reports</div>
			</div>

			<div class="" slot="actions">
				<i class="ri-more-2-line text-lg font-bold"></i>
			</div>

			<div class="content my-2 pb-2" slot="content">
				<div class="title mb-2 py-2">Quick Access Reports</div>

				<div class="flex flex-wrap gap-4 md:justify-between">
					{#each quick_access_links as qal}
						<div class="cursor-pointer text-sm text-blue-400 hover:text-blue-300">
							{qal.name} ({qal.value})
						</div>
					{/each}
				</div>
			</div>
		</Segment>
	</div>

	<div class="my-4">
		<Segment>
			<div class="" slot="content">
				<!-- filter form -->
				<div class="p-2">
					<form class="ui form text-sm">
						<fieldset class="rounded-sm border border-gray-400 p-2">
							<legend>Attributes</legend>
							<div class="four fields flex flex-wrap items-center justify-between gap-2">
								<div class="field">
									<label for="category">Category</label>
									<select name="category" id="category" bind:value={category}>
										<option value="">Select Option</option>
									</select>
								</div>

								<div class="field">
									<label for="subcategory">SubCategory</label>
									<select name="subcategory" id="subcategory" bind:value={subcategory}>
										<option value="">Select Option</option>
									</select>
								</div>

								<div class="field">
									<label for="brand">Brand</label>
									<select name="brand" id="brand" bind:value={brand}>
										<option value="">Select Brand</option>
									</select>
								</div>

								<div class="field">
									<label for="manufacturer">Manufacturer</label>
									<select name="manufacturer" id="manufacturer" bind:value={manufacturer}>
										<option value="">Select Option</option>
									</select>
								</div>
							</div>
						</fieldset>

						<fieldset class="my-2 rounded-sm border border-slate-400 p-2">
							<legend>Addition Dates</legend>
							<div class="two fields flex justify-between gap-2">
								<div class="field flex-1">
									<label for="addition_date_from"
										>Date <span class="text-red-500">(From)</span></label
									>
									<input
										type="date"
										name="date_from"
										id="addition_date_from"
										bind:value={addition_date_from}
									/>
								</div>

								<div class="field flex-1">
									<label for="addition_date_to">Date <span class="text-red-500">(To)</span></label>
									<input
										type="date"
										name="date_to"
										id="addition_date_to"
										bind:value={addition_date_to}
									/>
								</div>
							</div>
						</fieldset>

						<div class="my-4 pt-2 text-center">
							<button class="ui red mini icon button" type="reset"
								><i class="trash icon"></i> Clear</button
							>
							<button class="ui green mini icon button" type="submit"
								><i class="send icon"></i> Filter</button
							>
						</div>
					</form>
				</div>
				<!-- filter form -->
			</div>
		</Segment>
	</div>

	<div class="my-4">
		<Segment>
			<div class="text-md" slot="content">
				<div class="flex flex-wrap justify-between gap-2">
					<div class="">
						Category : <span>{category}</span>
					</div>

					<div class="">
						Subcategory : <span>{subcategory}</span>
					</div>

					<div class="">
						Brand : <span>{brand}</span>
					</div>

					<div class="">
						Manufacturer : <span>{manufacturer}</span>
					</div>

					<div class="">
						Added Between : <span>{addition_date_from}</span> And <span>{addition_date_to}</span>
					</div>
				</div>
			</div>
		</Segment>
	</div>
</main>

<style>
	label {
		display: block;
		font-size: small;
		padding: 2px;
	}

	.field {
		width: 45%;
		/* flex: 1; */
	}

	select {
		border-radius: 5px;
		width: 100%;
		font-size: small;
	}

	input {
		border-radius: 5px;
		width: 100%;
		font-size: small;
	}

	@media only screen and (min-width: 768px) {
		.field {
			flex: 1;
		}
	}
</style>
