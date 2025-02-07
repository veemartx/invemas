<script>
</script>

<main>
	<div class="wrapper">
		<div class="content">
			<div class="titlebar">
				<div class="title">Quick Links</div>
			</div>
			<div class="qdivsColumn pb-2">
				<div to="/products/new">
					<div class="qdiv">
						<div class="qli"><i class="ri-add-circle-line" ></i></div>
						<div class="qlt">New</div>
					</div>
				</div>

				<a href="https://cpd.pharmaplusziadalite.co.ke/" target="_blank" rel="noreferrer">
					<div class="qdiv">
						<div class="qli"><i class="ri-stethoscope-line"></i></div>
						<div class="qlt">Training</div>
					</div>
				</a>

				<div to="/services">
					<div class="qdiv">
						<div class="qli"><i class="ri-apps-line" ></i></div>
						<div class="qlt">Services</div>
					</div>
				</div>

				<div to="/apps">
					<div class="qdiv">
						<div class="qli"><i class="ri-apps-line" ></i></div>
						<div class="qlt">Apps</div>
					</div>
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

	.qdivsColumn {
		display: flex;
		justify-content: space-between;
		padding-top: 1em;
		flex-wrap: wrap;
		margin-right: 2px;
	}

	.qdiv {
		display: flex;
		margin-inline: 0.4em;
		font-size: small;
	}

	.qli {
		/* display: inline-block; */
		padding: 0.1em;
		color: var(--text-primary-light);
	}

	.qlt {
		/* display: inline-block; */
		padding-inline-start: 0.2em;
		color: var(--text-primary-light);
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
	@media only screen and (min-width: 640px) {
		main {
			margin-top: 0.5em;
		}
	}
</style>
