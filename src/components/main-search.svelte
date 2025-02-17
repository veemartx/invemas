<script>
	import axios from 'axios';
	import { createEventDispatcher } from 'svelte';
	import pkg from 'notiflix';
	import { API_BASE_URL } from '$lib/config/base-urls';
	const { Notify, Confirm } = pkg;

	const dispatch = createEventDispatcher();

	const url = `${API_BASE_URL}products/search.php`;

	let q;

	// let results = [
	// 	{
	// 		id: '1',
	// 		name: 'Amex earphones',
	// 		code: 'AE424',
	// 		price: '266.00',
	// 		qty: '12',
	// 		slug: 'amex-earphonesdqlxh'
	// 	},
	// 	{
	// 		id: '2',
	// 		name: 'Oraimo Eaphones 205',
	// 		code: 'OE2948',
	// 		price: '224.00',
	// 		qty: '20',
	// 		slug: 'oraimo-eaphones-205jdlos'
	// 	}
	// ];

	let results = [];

	const search = async () => {
		if (q == '') {
			results = [];

			return;
		}

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
	<div class="ui search">
		<input
			class="w-full rounded-md shadow-sm"
			type="search"
			name="q"
			id="search"
			placeholder="Search Products"
			bind:value={q}
			onkeyup={search}
		/>

		{#if results.length !== 0}
			<div class="absolute z-10 my-2 max-w-md rounded-md bg-white p-2 shadow-md">
				<div class="title flex justify-between border-b-2">
					<div class="">Results</div>
					<div class="font-bold">({results.length}) Items</div>
				</div>

				<div class="mt-2">
					<div class="flex justify-between p-2 text-sm font-semibold">
						<div class="">Name</div>
						<div class="">Code</div>
						<div class="">Qty</div>
						<div class="">Price (Sh)</div>
					</div>

					{#each results as r, i}
						<!-- svelte-ignore a11y_click_events_have_key_events -->
						<!-- svelte-ignore a11y_no_static_element_interactions -->
						<a
							class="flex cursor-pointer items-center justify-start gap-10 p-2 text-sm hover:bg-slate-200 {i %
								2 ==
							0
								? 'bg-green-100'
								: ''}"
							href="/dash/products/{r.slug}"
							onclick={() => {
								results = [];
								q = '';
							}}
						>
							<div class="flex-1">{r.name}</div>
							<div class="">{r.code}</div>
							<div class="">{r.qty}</div>
							<div class="">{r.price}</div>
						</a>
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
