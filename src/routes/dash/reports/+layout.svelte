<script>
	import ReportsNav from '$components/reports-nav.svelte';
	import TitleBar from '$components/title-bar.svelte';

	let { children } = $props();
</script>

<main>
	<!-- title -->
	<TitleBar title="Reports" subtitle="view performance reports"></TitleBar>
	<!-- title -->

	<!-- nav  -->
	<div class="">
		<ReportsNav />
	</div>
	<!-- nav  -->

	<!-- content  -->
	<div class="p-2">
		{@render children()}
	</div>
	<!-- content  -->

</main>
