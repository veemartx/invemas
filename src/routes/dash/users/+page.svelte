<script>
	import Segment from '$components/segment.svelte';
	import TitleBar from '$components/title-bar.svelte';
	import { API_BASE_URL } from '$lib/config/base-urls';
	import { fetch_resource } from '$lib/methods/functions';
	import { onMount } from 'svelte';

	import { Button } from 'svelte-ux';

	const url = `${API_BASE_URL}users.php`;

	const resource = 'Users';

	let users;

	onMount(async () => {
		const res = await fetch_resource(resource, url);

		users = res.data;

		console.log(users);
	});
</script>

<div class="wrapper">
	<TitleBar title="Users" subtitle="view & manage users">
		<div class="" slot="action">
			<i class="ri-more-2-line text-lg font-bold"></i>
		</div>
	</TitleBar>

	<div class="">
		<Segment>
			<div  slot="title">Users</div>
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
							<th>Username</th>
							<th>Email</th>
							<th>Phone</th>
							<th>Position</th>
							<th>View</th>
						</tr>
					</thead>
					<tbody>
						{#each users as user, i}
							<tr class="text-sm text-slate-700">
								<td>{i + 1}</td>
								<td>{user.name}</td>
								<td>{user.username}</td>
								<td>{user.email}</td>
								<td>{user.phone}</td>
								<td>{user.position}</td>
								<td>
									<a href="/dash/users/{user.user_id}">
										<button class="ui mini green basic button"> View </button>
									</a>
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
