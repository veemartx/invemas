<script>
	import FolderIcon from '$assets/icons/folder.png';
	import ZiadaIcon from '$assets/icons/ziada.png';
	import SapIcon from '$assets/apps/sap_one.png';
	import UberEats from '$assets/apps/uber_eats.png';
	import GlovoIcon from '$assets/apps/glovo_long.png';


</script>

<main>
	<div class="wrapper">
		<div class="content">
			<div class="titlebar">
				<div class="title">Invemas Apps</div>
			</div>
			<div class="appDrawer py-4 p-2 flex justify-between gap-4 flex-wrap">
				<div class="appPanel bg-slate-100 dark:bg-slate-600 dark:hover:bg-slate-700 hover:bg-slate-100 border border-invm_border rounded w-20 h-20 m-2 my-4">
					<a href="/apps/sap" class="bg-green-500">
						<div class="appIcon flex items-center h-full justify-center p-2">
							<img src={SapIcon} alt="connect icon" />
						</div>
						<div class="appName mt-2 text-center text-sm">SAP <sup>&trade;</sup></div>
					</a>
				</div>

				<div class="appPanel bg-slate-100 dark:bg-slate-600 dark:hover:bg-slate-700 hover:bg-slate-100 border border-invm_border rounded w-20 h-20 m-2 my-4">
					<a href="/apps/uber-eats">
						<div class="appIcon flex items-center h-full justify-center p-2">
							<img src={UberEats} alt="uber icon" />
						</div>
						<div class="appName mt-2 text-center text-sm">Uber</div>
					</a>
				</div>

				<div class="appPanel bg-slate-100 dark:bg-slate-600 dark:hover:bg-slate-700 hover:bg-slate-100 border border-invm_border rounded w-20 h-20 m-2 my-4">
					<a href="/apps/files">
						<div class="appIcon flex items-center h-full justify-center p-2">
							<img src={FolderIcon} alt="fold icon" />
						</div>
						<div class="appName mt-2 text-center text-sm">Files</div>
					</a>
				</div>

				<div class="appPanel bg-slate-100 dark:bg-slate-600 dark:hover:bg-slate-700 hover:bg-slate-100 border border-invm_border rounded w-20 h-20 m-2 my-4">
					<a href="/apps/glovo">
						<div class="appIcon flex items-center h-full justify-center p-2">
							<img src={GlovoIcon} alt="glovo icon" />
						</div>
						<div class="appName mt-2 text-center text-sm">Glovo</div>
					</a>
				</div>

                <div class="appPanel bg-slate-100 dark:bg-slate-600 dark:hover:bg-slate-700 hover:bg-slate-100 border border-invm_border rounded w-20 h-20 m-2 my-4">
					<a href="/apps/ziada">
						<div class="appIcon flex items-center h-full justify-center p-2">
							<img src={ZiadaIcon} alt="ziada icon" />
						</div>
						<div class="appName mt-2 text-center text-sm">Ziada</div>
					</a>
				</div>
			</div>
		</div>
	</div>
</main>

<style>
	main {
		margin-top: 1em;
	}

	.content {
		border: 1px solid rgba(255, 166, 0, 0.345);
	}
	.title {
		color: green;
		font-size: 15px;
		padding: 0.8em;
		font-weight: 600;
	}

	.titlebar {
		border-bottom: 1px solid rgba(255, 166, 0, 0.345);
	}
</style>
