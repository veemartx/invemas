<script>
	import Segment from '$components/segment.svelte';
	import TitleBar from '$components/title-bar.svelte';
	import { API_BASE_URL } from '$lib/config/base-urls';
	import { fetch_resource } from '$lib/methods/functions';
	import { add_commas } from '$lib/methods/methods';
	import { onMount } from 'svelte';

	import { Button } from 'svelte-ux';

	const url = `${API_BASE_URL}products/suppliers.php`;

	const resource = 'suppliers';

	let suppliers;

	onMount(async () => {
		const res = await fetch_resource(resource, url);

		suppliers = res.data;

		// console.log(suppliers);
	});
</script>

<div class="wrapper">
	<TitleBar title="Suppliers" subtitle="view inventory suppliers">
		<div class="" slot="action">
			<i class="ri-more-2-line text-lg font-bold"></i>
		</div>
	</TitleBar>

	<div class="my-3">
		<Segment>
			<div slot="title">Products Suppliers</div>
			<div slot="actions" class="">
				<!-- svelte-ignore a11y_consider_explicit_label -->
				<button class="ui basic teal button icon mini p-2">
					<i class="plus icon"></i>
				</button>
			</div>

			<div slot="content" class="overflow-x-auto">
				<table class="ui very basic striped unstackable table w-full text-sm">
					<thead>
						<tr class="text-sm">
							<th>No</th>
							<th>Name</th>
							<th>Phone</th>
							<th>Email</th>
							<th>Postal Code</th>
							<th>Website</th>
							<th>Limit</th>
							<th>Pay Cycle</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						{#each suppliers as supp, i}
							<tr class="text-sm text-slate-700">
								<td>{i + 1}</td>
								<td>{supp.name}</td>
								<td><a href="tel:+{supp.phone}"> <i class="phone icon"></i> {supp.phone} </a></td>
								<td><a href="mailto:{supp.email}"><i class="mail icon"></i> {supp.email}</a></td>
								<td>{supp.postal_code}</td>
								<td ><a href="{supp.website}" target="_blank" rel="noopener noreferrer"><i class="globe icon"></i> visit </a></td>
								<td>{add_commas(parseFloat(supp.limit),2)}</td>
								<td>{supp.pay_cycle}</td>

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
