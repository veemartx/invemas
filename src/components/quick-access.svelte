<script>
	import ReportIcon from '$assets/icons/report.png';
	import ProfileIcon from '$assets/icons/profile.png';
	import LogoutIcon from '$assets/icons/logout.png';
	import UsersIcon from '$assets/icons/users.png';
	// import { logout } from '$lib/methods/methods';
	import Segment from './segment.svelte';
	// import { ClockOutline } from 'flowbite-svelte-icons';
	import ZiadaIcon from '$assets/icons/ziada.png';
	import SapIcon from '$assets/apps/sap_one.png';
	import UberEats from '$assets/apps/uber_eats.png';
	import GlovoIcon from '$assets/apps/glovo_long.png';
	import Folder from '$assets/apps/folder.png';
	import SettingsIcon from '$assets/apps/settings.png';
	import HeadProfileIcon from '$assets/apps/icons8-head-profile-96.png';
	import CrowdIcon from '$assets/apps/icons8-crowd-96.png';
	import ChartsIcon from '$assets/apps/icons8-chart-96.png';

	import AppsDrawer from './apps-drawer.svelte';

	const apps = [
		{
			name: 'Users',
			icon: CrowdIcon,
			url: '/dash/users'
		},

		{
			name: 'Files',
			icon: Folder,
			url: '/dash/apps/files'
		},

		{
			name: 'Profile',
			icon: HeadProfileIcon,
			url: '/dash/profile'
		},
		{
			name: 'Settings',
			icon: SettingsIcon,
			url: '/dash/settings'
		},
		{
			name: 'Reports',
			icon: ChartsIcon,
			url: '/dash/reports'
		},
		{
			name: 'SAP',
			icon: SapIcon,
			url: '/dash/apps'
		},
		{
			name: 'Uber',
			icon: UberEats,
			url: '/dash/apps'
		},
		{
			name: 'Glovo',
			icon: GlovoIcon,
			url: '/dash/apps'
		},
		{
			name: 'Ziada',
			icon: ZiadaIcon,
			url: '/dash/apps'
		}
	];
</script>

<main>
	<div class="wrapper p-1">
		<div class="segment p-1">
			<Segment>
				<div class="title flex justify-start items-center" slot="title">
					<!-- <ClockOutline size="sm" /> -->
					<div class="pl-1 text-slate-900 font-bold">Quick Access</div>
				</div>
				<div class="" slot="content">
					<AppsDrawer {apps} />
				</div>
			</Segment>
		</div>
	</div>
</main>
