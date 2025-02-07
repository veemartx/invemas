<script>
	import love_icon from '$assets/icons/love.png';
	import buy_icon from '$assets/icons/buy.png';
	import comment_icon from '$assets/icons/comment.png';
	import user_male_icon from '$assets/icons/user_male.png';
	import { onMount } from 'svelte';

	let activities = [];

	onMount(() => {
		activities = [
			{
				title: 'Purchase By Kimani Muturi',
				description: 'Bio Balance Sun Spf 30 75ml',
				date: '02:14 PM Today',
				image: buy_icon
			},

			{
				title: 'Products Liked - Natasha Mukami',
				description: '2 Pack Nivea Deep Shower Gel For Men -250ml',
				date: '2023-11-17 10:09:19',
				image: love_icon
			},
			{
				title: 'Frank Hook Commented',
				description:
					'<i>  A product that has reviews is more likable to be sold than a product. "<i>',
				date: '11:08 PM Yesterday',
				image: comment_icon
			},

			{
				title: 'User Registration',
				description: '<i>  New user registration Dennis Otunga "<i>',
				date: '2023-10-20 16:07:43',
				image: user_male_icon
			}
		];
	});
</script>

<main>
	<div class="wrapper">
		<div class="recent">
			<div class="titlebar">
				<div class="title st text-xs p-3 font-extrabold">Recent Activity</div>
			</div>

			<div class="content_bar">
				{#each activities as a}
					<div class="activity flex items-center p-3">
						<div class="a_icon">
							<div class="icon m-2 p-2">
								<img src={a.image} alt="icon" />
							</div>
						</div>
						<div class="a_desc">
							<div class="a_title font-semibold text-sm">
								{a.title}
							</div>

							<div class="a_description my-2 text-xs">
								{@html a.description}
							</div>
						</div>
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

	.icon {
		background: rgba(255, 166, 0, 0.295);
		width: 2.5em;
		height: 2.5em;
		border-radius: 50%;
	}
</style>
