<script>
	import Logo from '$components/logo.svelte';
	import { API_BASE_URL } from '$lib/config/base-urls';
	import axios from 'axios';
	import pkg from 'notiflix';
	const { Notify } = pkg;

	let username;

	let password;

	let loading=false;

	const login = async () => {
		let fd = { username: username, password: password };

		loading=true;

		try {
			let response = await axios({
				method: 'POST',
				data: fd,
				url: `${API_BASE_URL}login.php`,
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded'
				}
			});

			let res = response.data;

			// console.log(res);

			loading=false;

			if (res.login) {
				Notify.success('Login successful.Redirecting');

				window.localStorage.invema_liu = JSON.stringify(res.user);

				setTimeout(() => {
					window.location.href = '/dash';
				}, 1000);
			} else {
				Notify.failure('Invalid Credentials. Try Again');
			}


		} catch (err) {
			console.log(err);
		}
	};
</script>

<div class="wrapper h-100 flex items-center justify-center bg-slate-100 p-2">
	<div class="login-panel max-w-72 flex-1 bg-white p-3 text-center shadow-md">
		<div class="bg-green-700 p-2">
			<Logo />
		</div>
		<div class="title border-b-2 bg-gray-100 p-2 font-bold shadow-sm">Admin Login</div>

		<div class="">
			<form class="form" on:submit|preventDefault={login}>
				<div class="my-2 p-2">
					<input
						type="text"
						name="username"
						placeholder="username"
						id="login-username"
						bind:value={username}
						required
					/>
				</div>

				<div class="my-2 p-2">
					<input
						type="password"
						placeholder="password"
						name="password"
						bind:value={password}
						id="login-password"
						required
					/>
				</div>

				<div class="my-2 p-2">
					<button class="ui green  mini icon button p-1 px-2 font-bold text-slate-50 shadow-sm {loading?'loading':''}" type="submit">
						<i class="ri-lock-line"></i> Login
					</button>
				</div>

				<div class=""></div>
			</form>
		</div>
	</div>
</div>

<style>
	.wrapper {
		height: 100vh;
	}

	.login-panel {
		border-radius: 5px;
	}

	button {
		border-radius: 3px;
	}
</style>
