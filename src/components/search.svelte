<script>
	import axios from 'axios';
	import { createEventDispatcher } from 'svelte';
	import pkg from 'notiflix';
	const { Notify, Confirm } = pkg;

	const dispatch = createEventDispatcher();

	export let url;

	let q;

	// let results = [
	// 	{
	// 		id: '1',
	// 		name: 'sasa',
	// 		code: 'S0001',
	// 		price: '1386.00'
	// 	},
	// 	{
	// 		id: '2',
	// 		name: 'Abidec Multivitamin Drops Caps',
	// 		code: 'A0001',
	// 		price: '336.00'
	// 	},
	// 	{
	// 		id: '4',
	// 		name: 'Durexcx Matiein',
	// 		code: 'D0001',
	// 		price: '1681.00'
	// 	},
	// 	{
	// 		id: '5',
	// 		name: 'Durex Feather lite ',
	// 		code: 'D0001',
	// 		price: '1260.00'
	// 	},
	// 	{
	// 		id: '6',
	// 		name: 'Durex Xtra safe',
	// 		code: 'D0001',
	// 		price: '126.00'
	// 	}
	// ];

	let results = [];

	const select = (result) => {
		dispatch('selected', result);

        q="";

        results=[];
	};

	const search = async () => {
		let dt = { q: q };

		try {
			let response = await axios({
				method: 'POST',
				data: dt,
				url: `${url}`,
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded'
				}
			});

			let res = response.data;

			results = res;
			console.log(res);
		} catch (err) {
			console.log(err);
		}
	};
</script>

<main>
	<div class="ui search my-3 bg-white">
		<input
			class="w-full shadow-sm"
			type="search"
			name="q"
			id="search"
			placeholder="Search product list"
			bind:value={q}
			on:keyup={search}
		/>

		{#if results.length !== 0}
			<div class="my-2 p-2">
				<div class="title flex justify-between border-b-2">
					<div class="">Results</div>
					<div class="font-bold">({results.length}) Items</div>
				</div>

				<div class="mt-2">
					{#each results as r, i}
						<!-- svelte-ignore a11y_click_events_have_key_events -->
						<!-- svelte-ignore a11y_no_static_element_interactions -->
						<div
							on:click={() => {
								Confirm.show(
									'Select',
									`Select ${results[i].name}?`,
									'Yes',
									'No',
									() => {
										select(results[i]);
									},
									() => {
										// clear results
                                        q='';
										results = [];
									},
									{}
								);
							}}
							class="flex cursor-pointer items-center justify-start gap-10 p-2 hover:bg-slate-200 {i % 2 == 0
								? 'bg-green-100'
								: ''}"
						>
							<div class="">{r.name}</div>
							<div class="">{r.code}</div>
							<div class="">Ksh. {r.retail_price}</div>
						</div>
					{/each}
				</div>
			</div>
		{/if}
	</div>
</main>

<style>
	input {
		border-radius: 5px;
		border-color: rgba(64, 74, 88, 0.24);
	}
</style>
