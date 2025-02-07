<script>
	// @ts-nocheck

	import dayjs from 'dayjs';
	import { format_date } from '$lib/methods/methods';



	// const check_user = current_lia();

	const lia = {
        name:"_vee"
    };

	let today = dayjs();

	setInterval(() => {
		today = dayjs();
	}, 1000);
</script>

<main>
	{#if lia}
		<div class="bg-white shadow-md" padding="none">
			<div class="col flex justify-between items-center p-1 gap-x-2">
				<div class="greeting_tag p-1">
					<div class="greeting_title font-semibold">
						Howday <span class="capitalize text-pp-red font-semibold"> {lia.name}</span>
					</div>
					<div class="greeting_subtitle font-thin text-sm">Here's what's happening today.</div>
				</div>

				<div class="date_add flex items-center">
					<div class="current_date p-1 font-bold text-sm">
						{format_date(today, 'ddd MMM DD, YYYY  hh:mm:ss a')}
					</div>

					<div class="add_product p-1 hidden md:block">
						<a href="products/new">
							<!-- <Button color="red"  variant="fill-outline" size="sm"  >
								<i class="ri-add-circle-line text-md"></i> <span class="py-1">Add Product</span>
							</Button> -->
                            <button>
                                Add Product
                            </button>
						</a>
					</div>
				</div>
			</div>
		</div>
	{/if}
</main>
