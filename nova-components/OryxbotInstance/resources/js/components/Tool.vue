<template>
    <div>
        <heading class="mb-6">Bot #1</heading>

        <div class="flex mb-4">
            <button class="btn btn-default btn-primary hover:bg-primary-dark px-8" v-on:click="StartBot">
                Start
            </button>

            <button class="btn btn-default bg-30 text-90 hover:text-white hover:bg-primary-dark ml-2" style="transition: 150ms">
                Restart Service
            </button>
        </div>


        <div class="flex mb-8">
            <loading-card :loading="false" class="px-6 py-4 w-1/4">
                <div class="flex mb-4">
                    <h3 class="mr-3 text-base text-80 font-bold uppercase">Step</h3>
                </div>
                <p class="flex items-center text-4xl mb-4">{{ step }}</p>
                <p class="flex items-center text-80 font-bold">{{ progress }}</p>
            </loading-card>
            <loading-card :loading="false" class="px-6 py-4 w-1/4 mx-8">
                <div class="flex mb-4">
                    <h3 class="mr-3 text-base text-80 font-bold uppercase">Location</h3>
                </div>
                <p class="flex items-center text-4xl mb-4">{{ location }}</p>
                <p class="flex items-center text-80 font-bold">{{ speed }} m/s</p>
            </loading-card>
            <loading-card :loading="false" class="px-6 py-4 w-1/4">
                <div class="flex mb-4">
                    <h3 class="mr-3 text-base text-80 font-bold uppercase">Session</h3>
                </div>
                <p class="flex items-center text-4xl mb-4">{{ session }}</p>
                <p class="flex items-center text-80 font-bold">{{ status }}</p>
            </loading-card>
        </div>

        <heading :level="2" class="mb-6 text-2xl">Connection</heading>
        <div class="flex">

            <div class="mb-4 ml-2 flex justify-start items-start w-1/4">

                <svg v-if="vpn_connected"
                     aria-hidden="true"
                     focusable="false"
                     data-prefix="far"
                     data-icon="check-circle"
                     class="w-8 text-success mr-2"
                     role="img"
                     xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 512 512">
                    <path fill="currentColor" d="M256 8C119.033 8 8 119.033 8 256s111.033 248 248 248 248-111.033 248-248S392.967 8 256 8zm0 48c110.532 0 200 89.451 200 200 0 110.532-89.451 200-200 200-110.532 0-200-89.451-200-200 0-110.532 89.451-200 200-200m140.204 130.267l-22.536-22.718c-4.667-4.705-12.265-4.736-16.97-.068L215.346 303.697l-59.792-60.277c-4.667-4.705-12.265-4.736-16.97-.069l-22.719 22.536c-4.705 4.667-4.736 12.265-.068 16.971l90.781 91.516c4.667 4.705 12.265 4.736 16.97.068l172.589-171.204c4.704-4.668 4.734-12.266.067-16.971z"></path>
                </svg>
                <svg v-else
                     aria-hidden="true"
                     focusable="false"
                     data-prefix="fas"
                     data-icon="ban"
                     class="w-8 text-danger mr-2"
                     role="img"
                     xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 512 512"><path fill="currentColor" d="M256 8C119.034 8 8 119.033 8 256s111.034 248 248 248 248-111.034 248-248S392.967 8 256 8zm130.108 117.892c65.448 65.448 70 165.481 20.677 235.637L150.47 105.216c70.204-49.356 170.226-44.735 235.638 20.676zM125.892 386.108c-65.448-65.448-70-165.481-20.677-235.637L361.53 406.784c-70.203 49.356-170.226 44.736-235.638-20.676z"></path>
                </svg>

                <div class="flex flex-col">

                    <heading :level="3" class="mb-4 flex items-center mt-2 text-60">
                        VPN
                    </heading>

                    <div class="flex">
                        <ul class="text-80 list-reset mr-4">
                            <li class="mb-2">Server name:</li>
                            <li class="mb-2">Username:</li>
                            <li class="mb-2">Password:</li>
                        </ul>
                        <ul class="text-60 list-reset font-bold">
                            <li class="mb-2">138.67.23.148</li>
                            <li class="mb-2">example123</li>
                            <li class="mb-2">passwn21k</li>
                        </ul>
                    </div>
                    <a href="#" class="text-primary mt-2 no-underline hover:underline">Help</a>
                </div>

            </div>
            <div class="mb-4 ml-8 flex justify-start items-start w-1/4">

                <svg v-if="remote_connected"
                     aria-hidden="true"
                     focusable="false"
                     data-prefix="far"
                     data-icon="check-circle"
                     class="w-8 text-success mr-2"
                     role="img"
                     xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 512 512">
                    <path fill="currentColor" d="M256 8C119.033 8 8 119.033 8 256s111.033 248 248 248 248-111.033 248-248S392.967 8 256 8zm0 48c110.532 0 200 89.451 200 200 0 110.532-89.451 200-200 200-110.532 0-200-89.451-200-200 0-110.532 89.451-200 200-200m140.204 130.267l-22.536-22.718c-4.667-4.705-12.265-4.736-16.97-.068L215.346 303.697l-59.792-60.277c-4.667-4.705-12.265-4.736-16.97-.069l-22.719 22.536c-4.705 4.667-4.736 12.265-.068 16.971l90.781 91.516c4.667 4.705 12.265 4.736 16.97.068l172.589-171.204c4.704-4.668 4.734-12.266.067-16.971z"></path>
                </svg>
                <svg v-else
                     aria-hidden="true"
                     focusable="false"
                     data-prefix="fas"
                     data-icon="ban"
                     class="w-8 text-danger mr-2"
                     role="img"
                     xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 512 512"><path fill="currentColor" d="M256 8C119.034 8 8 119.033 8 256s111.034 248 248 248 248-111.034 248-248S392.967 8 256 8zm130.108 117.892c65.448 65.448 70 165.481 20.677 235.637L150.47 105.216c70.204-49.356 170.226-44.735 235.638 20.676zM125.892 386.108c-65.448-65.448-70-165.481-20.677-235.637L361.53 406.784c-70.203 49.356-170.226 44.736-235.638-20.676z"></path>
                </svg>

                <div class="flex flex-col">

                    <heading :level="3" class="mb-4 flex items-center mt-2 text-60">
                        Tight VNC Server
                    </heading>

                    <div class="flex">
                        <ul class="text-80 list-reset mr-4">
                            <li class="mb-2">Resolution:</li>
                            <li class="mb-2">Bandwidth:</li>
                        </ul>
                        <ul class="text-60 list-reset font-bold">
                            <li class="mb-2">{{ remote_resolution }}</li>
                            <li class="mb-2">{{ remote_bandwidth}}</li>
                        </ul>
                    </div>
                    <a href="#" class="text-primary mt-2 no-underline hover:underline">Help</a>
                </div>

            </div>
        </div>

        <heading :level="2" class="mb-6 text-2xl">Logs</heading>
        <div class="flex mb-4 bg-white rounded px-2 pb-4 pt-3 text-90">
            2021-09-18 00:36:02.4070 | Info | Action executed: Unknown action<br>
            2021-09-18 00:36:02.7440 | Info | Action executed: Unknown action<br>
            2021-09-18 00:36:08.7168 | Info | Maging AI updated: Custom Maging AI<br>
            2021-09-18 00:36:08.7168 | Info | Maging AI updated: Custom Maging AI<br>
            2021-09-18 00:36:08.7168 | Info | Maging AI updated: Custom Maging AI<br>
            2021-09-18 00:36:09.9348 | Info | Maging AI updated: Maging AI<br>
            2021-09-18 00:36:16.1491 | Info | Action executed: Unknown action<br>
            2021-09-18 00:36:16.4911 | Info | Action executed: Unknown action<br>
            2021-09-18 00:36:18.3522 | Info | Action executed: Unknown action<br>
            2021-09-18 00:36:18.8892 | Info | Action executed: Unknown action<br>
            2021-09-18 00:36:22.6649 | Info | Action executed: Unknown action<br>
            2021-09-18 00:36:23.7060 | Info | Action executed: Unknown action<br>
            2021-09-18 00:36:24.2360 | Info | Action executed: Unknown action<br>
            2021-09-18 00:36:26.2162 | Info | Mage config has changed.<br>
            2021-09-18 00:36:26.2162 | Info | Mage config has been reset.<br>
            2021-09-18 00:36:26.2162 | Debug | New config:
        </div>
    </div>
</template>

<script>
function initBrodcasting() {
    let channel = Echo.private(`App.Models.User.${Nova.config.userId}`);

    channel.listen('VpnConnectionChanged', (e) => {
        if (e.established) {
            Nova.success('VPN Connection has been successfully established!')
        } else {
            Nova.error('VPN Connection has been lost!')
        }
    });

    channel.listen('BotRunningChanged', (e) => {
        let el = document.getElementById(`nav_oryxbot-instance-${e.instanceId}`);
        el = el ? el.querySelector('svg') : el;
        if (!el)
            return;

        if (e.running) {
            el.classList.add('text-primary')
            el.classList.remove('text-60')
        } else {
            el.classList.remove('text-primary')
            el.classList.add('text-60')
        }
    });

    channel.listen('RemoteDesktopConnectionChanged', (e) => {
        this.remote_connected = e.resolution;
        this.remote_resolution = e.resolution;
    });

    channel.listen('BotStepChanged', (e) => {
        this.step = e.step;
    });

    channel.listen('BotLocationChanged', (e) => {
        this.location = e.location;
        this.speed = e.speed;
    });
}

export default {
    metaInfo() {
        return {
          title: 'OryxbotInstance',
        }
    },
    mounted() {
        initBrodcasting.bind(this)();
    },
    data: () => ({
        step: '-',
        location: '-',
        session: '-',
        speed: '0',
        progress: '0% complete',
        status: 'Bot is disconnected',
        vpn_connected: false,
        remote_connected: false,
        remote_resolution: '-',
        remote_bandwidth: '-',
    }),
    methods: {
        StartBot() {
            Nova.request().get('instances/run');
        }
    }
}
</script>

<style>
/* Scoped Styles */
</style>
