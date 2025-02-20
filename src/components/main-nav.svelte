<script>
	import { logout } from '$lib/methods/methods';
</script>

<div class="wrapper">
	<div class="nav-panel flex min-w-40 flex-col p-2 text-sm font-thin">
		<div class="nav-col border-b-2 p-2 hover:bg-slate-50">
			<a href="/dash" class="flex gap-2 hover:font-bold"> <i class="ri-home-line"></i> Home</a>
		</div>

		<div class="nav-col nav-col border-b-2 p-2 hover:bg-slate-50">
			<a href="/dash/products/" class="flex gap-2 hover:font-bold">
				<i class="ri-price-tag-line"></i> Products</a
			>
		</div>

		<div class="nav-col nav-col border-b-2 p-2 hover:bg-slate-50">
			<a href="/dash/sales" class="flex gap-2 hover:font-bold">
				<i class="ri-money-pound-circle-line"></i> Sales</a
			>
		</div>

		<div class="nav-col nav-col border-b-2 p-2 hover:bg-slate-50">
			<a href="/dash/reports" class="flex gap-2 hover:font-bold">
				<i class="ri-pie-chart-line"></i> Reports</a
			>
		</div>

		<div class="nav-col nav-col border-b-2 p-2 hover:bg-slate-50">
			<a href="/dash/users" class="flex gap-2 hover:font-bold"
				><i class="ri-user-2-line"></i> Users</a
			>
		</div>

		<div class="nav-col nav-col border-b-2 p-2 hover:bg-slate-50">
			<a href="/dash/settings" class="flex gap-2 hover:font-bold"
				><i class="ri-settings-line"></i> Settings</a
			>
		</div>

		<div class="nav-col nav-col border-b-2 p-2 hover:bg-slate-50">
			<a href="/dash/profile" class="flex gap-2 hover:font-bold"
				><i class="ri-user-line"></i> Profile</a
			>
		</div>

		<div class="nav-col nav-col border-b-2 p-2 hover:bg-slate-50">
			<a href="/dash/help" class="flex gap-2 hover:font-bold"
				><i class="ri-information-line"></i> Help</a
			>
		</div>

		<div class="nav-col nav-col border-b-2 p-2 hover:bg-red-50">
			<!-- svelte-ignore a11y_no_static_element_interactions -->
			<!-- svelte-ignore a11y_click_events_have_key_events -->
			<div on:click={logout} class="flex cursor-pointer gap-2 hover:font-bold hover:text-red-500">
				<i class="ri-logout-circle-line"></i> Logout
			</div>
		</div>
	</div>
</div>
