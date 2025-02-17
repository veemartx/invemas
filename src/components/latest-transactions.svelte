<script>
	import { API_BASE_URL } from '$lib/config/base-urls';
	import { fetch_resource } from '$lib/methods/functions';
	import { onMount } from 'svelte';
	import Segment from './segment.svelte';
	import { format_date } from '$lib/methods/methods';

	const url = `${API_BASE_URL}transactions/get.php`;

	const resource = 'transactions';

	let transactions = $state([]);

	const get_transactions = async () => {
		const res = await fetch_resource(resource, url);

		transactions = res.data;

		// console.log(transactions);
	};

	onMount(async () => {
		//get transactions
		await get_transactions();
	});
</script>

<main class="p-2">
	<Segment>
		<div class="" slot="title">
			<div class="font-bold text-slate-900">Latest Transactions</div>
		</div>
		<div class="my-2" slot="content">
			<table class="ui basic striped unstackable table">
				<thead>
					<tr>
						<th>No</th>
						<th>Name</th>
						<th>Desc</th>
						<th>Time</th>
						<th>Init</th>
					</tr>
				</thead>
				<tbody>
					{#each transactions as tr, i}
						<tr class=" text-sm">
							<td>{i + 1}</td>
							<td class="capitalize">{tr.name}</td>
							<td class="capitalize">{tr.description}</td>
							<td>{format_date(tr.created)}</td>
							<td>{tr.init}</td>
						</tr>
					{/each}
				</tbody>
			</table>
		</div>
	</Segment>
</main>
