<script>
	import DashTopBar from './dash-top-bar.svelte';
	import LatestTransactions from './latest-transactions.svelte';
	import OverviewStats from './overview-stats.svelte';
	import QuickAccess from './quick-access.svelte';
	import RecentActivity from './recent-activity.svelte';
	import TitleBar from './title-bar.svelte';
	import TopCategories from './top-categories.svelte';
</script>

<div class="wrapper">
	<div class="content-container">
		<DashTopBar />

		<TitleBar title="Dashboard" subtitle="Performance Overview">
			<div class="" slot="action">
				<i class="ri-more-2-line cursor-pointer text-xl font-extrabold"></i>
			</div>
		</TitleBar>

		<div class="flex flex-col gap-2 md:flex-row">
			<div class="mainbar my-2 flex-1">
				<!-- stats  -->
				<div class="overview-stats">
					<OverviewStats />
				</div>
				<!-- stats  -->

				<!-- quick access -->
				<div class="quick-access">
					<QuickAccess />
				</div>
				<!-- quick access -->

				<!-- latest transactions  -->
				<div class="latest-transactions">
					<LatestTransactions />
				</div>
				<!-- latest transactions  -->
			</div>

			<div class="sidebar">
				<div class="recent-activity m-2 bg-white shadow-sm md:w-60">
					<RecentActivity />
				</div>

				<div class="top-categories m-2 bg-white shadow-sm md:w-60">
					<TopCategories />
				</div>
			</div>
		</div>
	</div>
</div>
