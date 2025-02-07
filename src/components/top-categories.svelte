<script>
	let top_categories = [
		{
			name: 'Vitamins And Supplements',
			qty: '1,282'
		},
		{
			name: 'Personal Care',
			qty: '1,101'
		},
		{
			name: 'Beauty And Skin Care',
			qty: '1,098'
		},
		{
			name: 'Medical Devices',
			qty: '891'
		},
		{
			name: 'Snacks And Drinks',
			qty: '702'
		}
	];
</script>

<main>
	<div class="wrapper">
		<div class="recent">
			<div class="titlebar">
				<div class="st text-xs p-3 font-extrabold">Top Categories</div>
			</div>

			<div class="content_bar p-3">
				{#each top_categories as tc, i}
					<div class="tc_col flex text-sm font-semibold">
						<div class="no">{i + 1}</div>
						<div class="name ml-4">
							{tc.name}
						</div>
						<div class="qty ml-2">({tc.qty})</div>
					</div>
				{/each}
			</div>
		</div>
	</div>
</main>

<style>
	.st {
		text-transform: uppercase;
		color: green;
		font-size: 14px !important;
	}

	.tc_col {
		line-height: 2.5em;
	}
</style>
