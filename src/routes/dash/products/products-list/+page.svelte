<script>
	import Segment from '$components/segment.svelte';
	import TitleBar from '$components/title-bar.svelte';
	import { API_BASE_URL } from '$lib/config/base-urls';
	import { fetch_resource } from '$lib/methods/functions';
	import { onMount } from 'svelte';

	import { Button } from 'svelte-ux';

	const url = `${API_BASE_URL}products/list.php`;

	const resource = 'list';

	let list;

	onMount(async () => {
		const res = await fetch_resource(resource, url);

		list = res.data;

		// console.log(list);
	});
</script>

<div class="wrapper">
	<TitleBar title="Products List" subtitle="view inventory list">
		<div class="" slot="action">
			<i class="ri-more-2-line text-lg font-bold"></i>
		</div>
	</TitleBar>

	<div class="my-3">
		<Segment>
			<div slot="title">Products List</div>
			<div slot="actions" class="">
				<!-- svelte-ignore a11y_consider_explicit_label -->
				<a href="products-list/new">
					<button class="ui basic teal button icon mini p-2">
						<i class="plus icon"></i> New
					</button>
				</a>
			</div>

			<div slot="content" class="overflow-x-auto">
				<table class="ui very basic striped unstackable table w-full text-sm">
					<thead>
						<tr class="text-sm">
							<th>No</th>
							<th>Name</th>
							<th>Code</th>
							<th>Cost Price</th>
							<th>Retail Price</th>
							<th>Discount</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						{#each list as user, i}
							<tr class="text-sm text-slate-700">
								<td>{i + 1}</td>
								<td>{user.name}</td>
								<td>{user.code}</td>
								<td>{user.cost_price}</td>
								<td>{user.retail_price}</td>
								<td>{user.discount}</td>
								<td>
									<!-- svelte-ignore a11y_consider_explicit_label -->
									<button class="ui mini red basic icon button">
										<i class="ui red trash icon"></i>
									</button>
									<!-- svelte-ignore a11y_consider_explicit_label -->
									<button class="ui mini orange basic icon button">
										<i class="ui edit icon"></i>
									</button>
									<!-- svelte-ignore a11y_consider_explicit_label -->
									<button class="ui mini green basic icon button">
										<i class="ui eye icon"></i>
									</button>
								</td>
							</tr>
						{/each}
					</tbody>
				</table>
			</div>
		</Segment>
	</div>
</div>

<style>
</style>
