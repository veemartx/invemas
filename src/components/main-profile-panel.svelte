<script>
	import ProfileAvator from '$assets/icons/profile.png';
	import { current_liu } from '$lib/methods/methods';
	import { onMount } from 'svelte';

    const liu=current_liu();

    onMount(()=>{
        // console.log(liu)
    })
</script>

<div class="wrapper">
	<div class="profile-panel flex justify-center flex-col">
		<div class="icon">
            <img src="{ProfileAvator}" alt="profile avator" width="30" style="margin: auto;">
        </div>
        <div class="name text-white font-semibold capitalize text-xs">
            {liu.username}
        </div>
	</div>
</div>
