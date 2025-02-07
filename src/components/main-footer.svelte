<script>
	import { POWERED_BY_URL } from '$lib/config/base-urls';
	import dayjs from 'dayjs';

	let currentYear = dayjs().year();
</script>

<div class="wrapper bg-green-900">
	<div class="footer ">
		<div class="copyrights py-2 text-xs  text-white flex justify-between">
			<div class="copy p-2 md:p-0">
				All Rights Reserved || Invemas &copy; {currentYear}
			</div>

			<div class="power p-2 md:p-0 ">
				Powered By <a class="text-green-500" href={POWERED_BY_URL.url}>{POWERED_BY_URL.name}</a>
			</div>
		</div>
	</div>
</div>

<style>
	.footer {
		max-width: 85em;
		margin: auto;
	}
</style>
