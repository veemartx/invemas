<script>
	// import { Card } from 'flowbite-svelte';
	// import {
	// 	ArrowDownOutline,
	// 	ArrowRightOutline,
	// 	ArrowUpOutline,
	// 	ArrowUpRightFromSquareOutline
	// } from 'flowbite-svelte-icons';

	export let title = 'Total Earnings';

	export let change = 0;

	export let value = 0;

	export let color = 'gray';
</script>

<div class="bg-white shadow-md m-2 w-full md:w-auto">
	<div class="p-3 flex flex-col justify-between">
		<div class="top_col flex justify-between">
			<div class="title uppercase text-sm">
				{title}
			</div>

			<div class="change ml-5">
				{#if change > 0}
					<div class="text-invm_green font-bold flex">
						<i class="ri-arrow-up-line"></i>
						<div class="inline-block text-base">+{change}%</div>
					</div>
				{:else if change < 0}
					<div class="text-invm_red font-bold flex gap-1">
						<div class="inline-block">
                            <i class="ri-arrow-down-line"></i>
                        </div>
						<div class="inline-block text-base">{change}%</div>
					</div>
				{:else}
					<div class="text-gray-500 font-bold">
						{change}%
					</div>
				{/if}
			</div>
		</div>

		<div class="middle_col">
			<div class="value text-2xl pt-2">
				{value}
			</div>
		</div>

		<div class="bottom_col flex justify-between items-end">
			<div class="link underline text-base">
				<slot name="link" />
			</div>
			<div
				class={`text-${color}-800 opacity-60  bg-${color}-200 font-extrabold icon ml-6 flex items-center pt-1 justify-center`}
			>
				<slot name="icon" />
			</div>
		</div>
	</div>
</div>

<style>
	.icon {
		/* background: rgba(255, 0, 0, 0.267); */
		width: 2.2em;
		height: 2.2em;
		border-radius: 5px;
		font-size: large;
	}

	.value {
		font-weight: 900;
	}
</style>
