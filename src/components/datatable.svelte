<script>
	import { onMount } from 'svelte';

	let sortable = true;

	let selectable = true;

	let hoverable = true;

	let loading = false;

	let search_query = '';

	let rows = [];

	export let headers = [];

	export let data = [];


	onMount(() => {
		console.log(data);
		rows = data;
	});
</script>

<main>
	<div class="">
		<table class="ui very basic striped unstackable table">
			<thead>
				<tr class="text-sm">
					{#each headers as head}
						<th>{head.name}</th>
					{/each}
				</tr>
			</thead>

			<slot name="table-body"></slot>
		</table>
		<slot name="pagination"></slot>
	</div>
</main>
