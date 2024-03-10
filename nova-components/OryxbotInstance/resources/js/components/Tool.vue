<template>
    <div>
        <heading class="mb-6">
            {{ instance.name }}
            <small :class="{'opacity-50': requestingStatus, 'text-primary': serverOnline}"
                   class="text-xs font-mono uppercase">
                {{ serverOnline ? 'Online' : (instance.server ? 'Offline' : 'Requires setup') }}
            </small>
        </heading>

        <div class="flex mb-4">
            <button class="btn btn-default btn-primary px-8"
                    v-bind:class="{'cursor-wait': requestingRunningChange, 'cursor-not-allowed': !serverOnline, 'hover:bg-primary-dark': !requestingRunningChange && serverOnline}"
                    v-show="!running"
                    :disabled="requestingRunningChange || recording || !serverOnline"
                    v-on:click="showStartModal = true">
                Start
            </button>
            <button class="btn btn-default btn-primary px-8"
                    v-bind:class="{'cursor-wait': requestingRunningChange, 'cursor-not-allowed': !serverOnline, 'hover:bg-primary-dark': !requestingRunningChange && serverOnline}"
                    v-show="running"
                    :disabled="requestingRunningChange || !serverOnline"
                    v-on:click="StopBot">
                Stop
            </button>
            <button class="btn btn-default btn-primary px-8 ml-2"
                    v-bind:class="{'cursor-wait': requestingRunningChange, 'cursor-not-allowed': !serverOnline, 'hover:bg-primary-dark': !requestingRunningChange && serverOnline}"
                    v-show="!running"
                    :disabled="requestingRunningChange || recording || !serverOnline"
                    v-on:click="showResumeModal = true">
                Resume
            </button>
            <button class="btn btn-default btn-primary px-8 ml-2"
                    v-bind:class="{'cursor-wait': requestingRunningChange, 'cursor-not-allowed': !serverOnline, 'hover:bg-primary-dark': !requestingRunningChange && serverOnline}"
                    :disabled="requestingRunningChange || running || !serverOnline || true"
                    v-on:click="showStartRecordingModal = true">
                Record
            </button>

            <button class="btn btn-default bg-30 text-90 ml-2" style="transition: 150ms"
                    :disabled="requestingServerReboot || !instance.server"
                    v-bind:class="{'cursor-wait opacity-50': requestingServerReboot, 'hover:bg-primary-dark hover:text-white': !requestingServerReboot && instance.server}"
                    v-on:click="OnAttemptServerReboot">
                Restart Service
            </button>

            <button class="btn btn-default bg-30 text-90 ml-2 hover:bg-primary-dark hover:text-white" style="transition: 150ms"
                    v-on:click="OnConfirmSetupWizard">
                Setup
            </button>
            <portal to="modals" transition="fade-transition">
                <confirm-action-modal
                    v-if="setupWizardConfirmModal"
                    @confirm="OnConfirmSetupWizard"
                    @close="setupWizardConfirmModal = false"
                    :working="false"
                    resourceName="oryxbot-instance"
                    :selectedResources="['oryxbot-instance']"
                    :errors="{}"
                    :action="{name: 'Setup Instance', confirmText: 'It seems you have not completed the setup process for this instance. Would you like to complete it now?', confirmButtonText: 'Begin Setup', cancelButtonText: 'Cancel', fields: [], class: 'btn-primary'}">
                </confirm-action-modal>

                <confirm-action-modal
                    v-if="showRebootServerConfirmModal"
                    @confirm="OnConfirmServerReboot"
                    @close="OnCancelServerReboot"
                    :working="false"
                    resourceName="oryxbot-instance"
                    :selectedResources="['oryxbot-instance']"
                    :errors="{}"
                    :action="{name: 'Restart service', confirmText: 'Are you sure you want to restart your server? This normally takes up to one minute.', confirmButtonText: 'Confirm', cancelButtonText: 'Cancel', fields: [], class: 'btn-primary'}">

                </confirm-action-modal>
                <confirm-action-modal
                    v-if="showStartModal"
                    @confirm="OnStartBot"
                    ref="startModal"
                    @close="showStartModal = false"
                    :working="false"
                    resourceName="oryxbot-instance"
                    :selectedResources="['oryxbot-instance']"
                    :errors="this.cityFieldErrors"
                    :action="this.startBotAction">

                </confirm-action-modal>
                <confirm-action-modal
                    v-if="showResumeModal"
                    @confirm="OnResumeBot"
                    ref="resumeModal"
                    @close="showResumeModal = false"
                    :working="false"
                    resourceName="oryxbot-instance"
                    :selectedResources="['oryxbot-instance']"
                    :errors="this.cityFieldErrors"
                    :action="this.resumeBotAction">

                </confirm-action-modal>
                <confirm-action-modal
                    v-if="showStartRecordingModal"
                    @confirm="OnStartRecordingBot"
                    ref="startRecordingModal"
                    @close="showStartRecordingModal = false"
                    :working="false"
                    resourceName="oryxbot-instance"
                    :selectedResources="['oryxbot-instance']"
                    :errors="this.cityFieldErrors"
                    :action="this.startRecordingBotAction">

                </confirm-action-modal>
            </portal>
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

                <svg v-show="vpn_connected || remote_connected || vpn_status === 'Online'"
                     aria-hidden="true"
                     focusable="false"
                     data-prefix="far"
                     data-icon="check-circle"
                     class="w-8 text-success mr-2"
                     style="overflow: visible"
                     role="img"
                     xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 512 512">
                    <path fill="currentColor" d="M256 8C119.033 8 8 119.033 8 256s111.033 248 248 248 248-111.033 248-248S392.967 8 256 8zm0 48c110.532 0 200 89.451 200 200 0 110.532-89.451 200-200 200-110.532 0-200-89.451-200-200 0-110.532 89.451-200 200-200m140.204 130.267l-22.536-22.718c-4.667-4.705-12.265-4.736-16.97-.068L215.346 303.697l-59.792-60.277c-4.667-4.705-12.265-4.736-16.97-.069l-22.719 22.536c-4.705 4.667-4.736 12.265-.068 16.971l90.781 91.516c4.667 4.705 12.265 4.736 16.97.068l172.589-171.204c4.704-4.668 4.734-12.266.067-16.971z"></path>
                </svg>
                <svg v-show="!vpn_connected && !remote_connected && vpn_status !== 'Online'"
                     aria-hidden="true"
                     focusable="false"
                     data-prefix="fas"
                     data-icon="ban"
                     class="w-8 text-danger mr-2"
                     style="overflow: visible"
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
                            <li class="mb-2">Service Status:</li>
                            <li class="mb-2">Server:</li>
                            <li class="mb-2">Username:</li>
                            <li class="mb-2">Password:</li>
                        </ul>
                        <ul class="text-60 list-reset font-bold">
                            <li class="mb-2">{{ vpn_status }}</li>
                            <li class="mb-2">{{ instance.server && instance.server.ip_address ? instance.server.ip_address : '-' }}</li>
                            <li class="mb-2">{{ instance.server && instance.server.ip_address && instance.server.vpn_username ? instance.server.vpn_username : '-' }}</li>
                            <li class="mb-2">{{ instance.server && instance.server.ip_address && instance.server.vpn_password ? instance.server.vpn_password : '-' }}</li>
                        </ul>
                    </div>
                </div>

            </div>
            <div class="mb-4 ml-8 flex justify-start items-start w-1/4">

                <svg v-show="remote_connected || vnc_status === 'Online'"
                     aria-hidden="true"
                     focusable="false"
                     data-prefix="far"
                     data-icon="check-circle"
                     class="w-8 text-success mr-2"
                     style="overflow: visible"
                     role="img"
                     xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 512 512">
                    <path fill="currentColor" d="M256 8C119.033 8 8 119.033 8 256s111.033 248 248 248 248-111.033 248-248S392.967 8 256 8zm0 48c110.532 0 200 89.451 200 200 0 110.532-89.451 200-200 200-110.532 0-200-89.451-200-200 0-110.532 89.451-200 200-200m140.204 130.267l-22.536-22.718c-4.667-4.705-12.265-4.736-16.97-.068L215.346 303.697l-59.792-60.277c-4.667-4.705-12.265-4.736-16.97-.069l-22.719 22.536c-4.705 4.667-4.736 12.265-.068 16.971l90.781 91.516c4.667 4.705 12.265 4.736 16.97.068l172.589-171.204c4.704-4.668 4.734-12.266.067-16.971z"></path>
                </svg>
                <svg v-show="!remote_connected && vnc_status !== 'Online'"
                     aria-hidden="true"
                     focusable="false"
                     data-prefix="fas"
                     data-icon="ban"
                     class="w-8 text-danger mr-2"
                     style="overflow: visible"
                     role="img"
                     xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 512 512"><path fill="currentColor" d="M256 8C119.034 8 8 119.033 8 256s111.034 248 248 248 248-111.034 248-248S392.967 8 256 8zm130.108 117.892c65.448 65.448 70 165.481 20.677 235.637L150.47 105.216c70.204-49.356 170.226-44.735 235.638 20.676zM125.892 386.108c-65.448-65.448-70-165.481-20.677-235.637L361.53 406.784c-70.203 49.356-170.226 44.736-235.638-20.676z"></path>
                </svg>

                <div class="flex flex-col">

                    <heading :level="3" class="mb-4 flex items-center mt-2 text-60">
                        VNC Server
                    </heading>

                    <div class="flex">
                        <ul class="text-80 list-reset mr-4">
                            <li class="mb-2">Service Status:</li>
                            <li class="mb-2">Resolution:</li>
                            <li class="mb-2">Bandwidth:</li>
                        </ul>
                        <ul class="text-60 list-reset font-bold">
                            <li class="mb-2">{{ vnc_status }}</li>
                            <li class="mb-2">{{ remote_resolution }}</li>
                            <li class="mb-2">{{ remote_bandwidth}}</li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>

        <heading :level="2" class="mb-6 text-2xl">Live Logs</heading>

        <div class="relative"
             @mouseenter="isHoveringLogs = true"
             @mouseleave="isHoveringLogs = false"
             @mousedown="allowAutoScrollLogs = false;">
            <div class="flex justify-center z-10">
                <a href="#"
                   @click.prevent="allowAutoScrollLogs = true"
                   :class="{ 'opacity-0': !logsHasScrollbar, 'opacity-75': logsHasScrollbar}"
                   class=" text-20 absolute bg-90 rounded-full flex justify-center items-center m-3 z-10"  style="height: 40px;width: 40px">
                    <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" style="height: 28px;width: 28px;" viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M169.4 470.6c12.5 12.5 32.8 12.5 45.3 0l160-160c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 370.8 224 64c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 306.7L54.6 265.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l160 160z"/></svg>
                </a>
            </div>
            <div class="mb-4 bg-white rounded px-2 pb-4 pt-3 text-90 relative text-60 overflow-scroll" style="height: 200px" ref="logs">
                <p v-for="item in this.logEntries">{{ item.Timestamp }} | {{ item.Level }} | {{ item.Message }}</p>
            </div>
        </div>
    </div>
</template>

<script>
import { Errors } from 'form-backend-validation'

function initBrodcasting() {
    if (typeof window.Echo === 'function')
        window.Echo = Echo();

    let channel = Echo.private(`App.Models.User.${Nova.config.userId}`);

    channel.listen('VpnConnectionChanged', (e) => {
        if (e.established) {
            Nova.success('VPN Connection has been successfully established!')
        } else {
            Nova.error('VPN Connection has been lost!')
        }
    });

    channel.listenForWhisper('LogEntry', (e) => {
        this.logEntries.push(e)
    });

    channel.listen('BotRunningChanged', (e) => {
        this.running = e.running;
        this.recording = e.recordingRunning;
        this.requestingRunningChange = false;
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

    channel.listen('Status', (e) => {
        this.requestingStatus = false;
        this.requestingRunningChange = false;

        this.location= e.characterLocation;
        this.speed= e.characterSpeed;
        this.running= e.botRunning;
        this.step= e.botStep;
        this.remote_connected= e.remoteDesktopConnected;
        this.remote_resolution= e.remoteDesktopResolution;
        this.vpn_connected= e.vpnEstablished;
        //this.session= e.param;
        //this.progress= e.param;
        //this.status= e.param;
        //this.remote_bandwidth= e.param;
        this.serverOnline = true;
    });

    channel.subscribed(() => {
        let requestServerOnlineStatusUntilReceivedResponse = function () {
            this.RequestStatus();
            this.refreshTimeout = setTimeout(function () {
                this.refreshTimeout = null;
                if (this.requestingStatus) {
                    if (!document.hidden && this.websocketServerConnected)
                        Nova.error('Failed to connect to bot. Retrying...');
                    requestServerOnlineStatusUntilReceivedResponse();
                }
            }.bind(this), 5000);
        }.bind(this);

        requestServerOnlineStatusUntilReceivedResponse();
    });

    let websocketConnectionAlertCallback = () => this.websocketConnectionAlert = setTimeout(() => {
        if (!document.hidden && !this.websocketServerConnected) {
            Nova.error('Failed to connect to Oryxbot messaging server. Retrying...');
        }
        websocketConnectionAlertCallback();
    }, 5000);
    websocketConnectionAlertCallback();

    window.Echo.connector.pusher.connection.bind('state_change', this.pusherConnectionSuccessCallback);
}

export default {
    metaInfo() {
        return {
          title: 'Instances',
        }
    },
    mounted() {
        console.log('mounted');
        initBrodcasting.bind(this)();

        Nova.$on('field-city-change', value => this.fieldCityValue = value);
        Nova.$on('field-hearts-change', value => this.fieldHeartsValue = value);
        Nova.$on('field-destination-change', value => this.fieldDestinationValue = value);
        Nova.$on('field-name-change', value => this.fieldNameValue = value);
        Nova.$on('field-region-change', value => this.fieldRegionValue = value);
        Nova.$on('field-progressed-change', value => this.fieldProgressedValue = value);

        let timeout = () => {
            this.servicesStatusTimeouts = setTimeout( () => {
                refreshVncServiceStatus();
                refreshVpnServiceStatus();
                timeout();
            }, 5000);
        };

        let refreshVncServiceStatus =
            () => fetch("http://127.0.0.1:5801", { mode: 'no-cors'})
                .then(r => {
                    if (this.vnc_status !== 'Online') {
                        console.log('Successfully pinged local TightVNC server');
                    }
                    this.vnc_status = 'Online'
                })
                .catch(reason => {
                    this.vnc_status = 'Unknown';
                    console.log('Failed to ping local TightVNC server');
                });
        let refreshVpnServiceStatus =
            () => fetch("http://127.0.0.1:5558", { mode: 'no-cors'})
                .then(r => {
                    if (this.vpn_status !== 'Online') {
                        console.log('Successfully pinged VPN discoverability server');
                    }
                    this.vpn_status = 'Online'
                })
                .catch(reason => {
                    this.vpn_status = 'Unknown';
                    console.log('Failed to ping VPN discoverability server');
                });

        timeout();
        refreshVncServiceStatus();
        refreshVpnServiceStatus();

        setTimeout( () => {
            this.setupWizardConfirmModal = !this.instance.is_active
        }, 500);
    },
    beforeDestroy() {
        if (this.websocketConnectionAlert !== null)
            clearTimeout(this.websocketConnectionAlert);

        if (this.servicesStatusTimeouts !== null)
            clearTimeout(this.servicesStatusTimeouts);

        if (this.refreshTimeout !== null)
            clearTimeout(this.refreshTimeout)

        window.Echo.connector.pusher.connection.unbind('state_change', this.pusherConnectionSuccessCallback);
    },
    destroyed() {
        Echo.leave(`App.Models.User.${Nova.config.userId}`);
    },
    data: () => ({
        step: '-',
        location: '-',
        session: '-',
        speed: '0',
        progress: '0% complete',
        vpn_connected: false,
        remote_connected: false,
        vnc_status: 'Unknown',
        vpn_status: 'Unknown',
        remote_resolution: '-',
        remote_bandwidth: '-',
        running: false,
        recording: false,
        serverOnline: false,
        requestingRunningChange: false,
        requestingStatus: false,
        requestingServerReboot: false,
        refreshTimeout: null,
        showRebootServerConfirmModal: false,
        setupWizardConfirmModal: false,
        showStartModal: false,
        showResumeModal: false,
        showStartRecordingModal: false,
        websocketServerConnected: false,
        allowAutoScrollLogs: true,
        isHoveringLogs: false,
        logsHasScrollbar: false,
        websocketConnectionAlert: null,
        servicesStatusTimeouts: null,
        logEntries: [],
        cityFieldErrors: new Errors(),
        fieldCityValue: 'fort-sterling',
        fieldDestinationValue: 'aspenwood',
        fieldHeartsValue: 3,
        fieldNameValue: '',
        fieldRegionValue: 'aspenwood',
        fieldProgressedValue: false,
        startBotAction: {name: 'Start Oryxbot', confirmButtonText: 'Confirm', cancelButtonText: 'Cancel', fields: [
            {component: 'select-field', field: 'city', attribute: 'field-city', value: 'fort-sterling', options: [
                    {label: 'Thetford (broken)', value: 'thetford'},
                    {label: 'Fort Sterling', value: 'fort-sterling'},
                    {label: 'Lymhurst (broken)', value: 'lymhurst'},
                    {label: 'Bridgewatch (broken)', value: 'bridgewatch'},
                    {label: 'Martlock (broken)', value: 'martlock'},
                    {label: 'Caerleon (broken)', value: 'caerleon'},
                ], name: 'Royal City', helpText: 'Please select the city you will begin running from'},

            {component: 'select-field', field: 'hearts', attribute: 'field-hearts', value: 3, options: [
                    {label: '3', value: 3},
                    {label: '7', value: 7},
                    {label: '15', value: 15},
                ], name: 'Faction Hearts', helpText: 'Please select how many faction hearts you would like to transport'}
        ], class: 'btn-primary'},
        resumeBotAction: {name: 'Resume Oryxbot Run', confirmButtonText: 'Confirm', cancelButtonText: 'Cancel', fields: [
            {component: 'select-field', field: 'city', attribute: 'field-city', value: 'fort-sterling', options: [
                    {label: 'Thetford (broken)', value: 'thetford'},
                    {label: 'Fort Sterling', value: 'fort-sterling'},
                    {label: 'Lymhurst (broken)', value: 'lymhurst'},
                    {label: 'Bridgewatch (broken)', value: 'bridgewatch'},
                    {label: 'Martlock (broken)', value: 'martlock'},
                    {label: 'Caerleon (broken)', value: 'caerleon'},
                ], name: 'Royal City', helpText: 'Please select the city you will begin running from'},

            {component: 'select-field', field: 'region', attribute: 'field-region', value: 'aspenwood', options: [
                    {label: 'Mawar Gorge', value: 'mawar-gorge'},
                    {label: 'Pen Kerrig', value: 'pen-kerrig'},
                    {label: 'Cedarcopse', value: 'cedarcopse'},
                    {label: 'Russerdell', value: 'russerdell'},
                    {label: 'Oakcopse', value: 'oakcopse'},
                    {label: 'Aspenwood', value: 'aspenwood'},
                ], name: 'Current Region', helpText: 'Please select the region your character is currently located in'},
            {component: 'boolean-field', field: 'progressed', attribute: 'field-progressed', value: false, name: 'Progressed', helpText: 'Check this field if you have already arrived at the faction emissary and progressed the quest'},

                {component: 'select-field', field: 'hearts', attribute: 'field-hearts', value: 3, options: [
                        {label: '3', value: 3},
                        {label: '7', value: 7},
                        {label: '15', value: 15},
                    ], name: 'Faction Hearts', helpText: 'Please select how many faction hearts you would like to transport on your next run'}

        ], class: 'btn-primary'},
        startRecordingBotAction: {name: 'Custom Route', confirmButtonText: 'Start Recording', cancelButtonText: 'Cancel', fields: [
            {component: 'text-field', field: 'name', attribute: 'field-name', value: '', name: 'Name', helpText: 'How you would like to name your route'},
            {component: 'select-field', field: 'city', attribute: 'field-city', value: 'fort-sterling', options: [
                    {label: 'Thetford (broken)', value: 'thetford'},
                    {label: 'Fort Sterling', value: 'fort-sterling'},
                    {label: 'Lymhurst (broken)', value: 'lymhurst'},
                    {label: 'Bridgewatch (broken)', value: 'bridgewatch'},
                    {label: 'Martlock (broken)', value: 'martlock'},
                    {label: 'Caerleon (broken)', value: 'caerleon'},
                ], name: 'Royal City', helpText: 'Please select the city you will begin running from'},
            {component: 'select-field', field: 'destination', attribute: 'field-destination', value: 'aspenwood', options: [
                    {label: 'Aspenwood', value: 'aspenwood'},
                ], name: 'Destination', helpText: 'Please select the destination of your trade mission'},
        ], class: 'btn-primary'},
    }),
    methods: {
        OnStartBot() {
            this.showStartModal = false;
            this.StartBot();
        },
        OnResumeBot() {
            this.showResumeModal = false;
            this.ResumeBot();
        },
        StartBot() {
            this.requestingRunningChange = true;
            Nova.request().post(this.$route.fullPath + '/start?city=' + this.fieldCityValue + '&hearts=' + this.fieldHeartsValue);
        },
        ResumeBot() {
            this.requestingRunningChange = true;
            Nova.request().post(this.$route.fullPath + '/resume?city=' + this.fieldCityValue + '&region=' + this.fieldRegionValue + '&progressed=' + this.fieldProgressedValue + '&hearts=' + this.fieldHeartsValue);
        },
        StopBot() {
            this.requestingRunningChange = true;
            Nova.request().post(this.$route.fullPath + '/stop');
        },
        RebootServer() {
            this.requestingServerReboot = true;
            Nova.request().post(this.$route.fullPath + '/server-reboot')
                .then(() => Nova.success('Server is rebooting'))
                .catch(error => Nova.error(error.response.data.message))
                .finally(() => this.requestingServerReboot = false);
        },
        RequestStatus() {
            this.requestingStatus = true;
            Nova.request().post(this.$route.fullPath + '/status');
        },
        OnAttemptServerReboot() {
            this.showRebootServerConfirmModal = true;
        },
        OnConfirmServerReboot() {
            this.showRebootServerConfirmModal = false;
            this.RebootServer();
        },
        OnConfirmSetupWizard() {
            window.location.href = this.instance.setup_route;
        },
        OnCancelServerReboot() {
            this.showRebootServerConfirmModal = false;
        },
        pusherConnectionSuccessCallback(stateInfo) {
            this.websocketServerConnected = window.Echo.connector.pusher.connection.state === 'connected';
            if (stateInfo.previous !== 'connected' && stateInfo.current === 'connected') {
                Nova.success('Connection to Oryxbot messaging server established.');
            }
        },
        OnStartRecordingBot() {
            this.showStartRecordingModal = false;
            this.requestingRunningChange = true;
            Nova.request().post(this.$route.fullPath + '/start-recording?city=' + this.fieldCityValue + '&destination=' + this.fieldDestinationValue + '&name=' + this.fieldNameValue);
        },
        OnStopRecordingBot() {
            this.requestingRunningChange = true;
            Nova.request().post(this.$route.fullPath + '/stop');
        },
    },
    computed: {
        instance() {
            return _.find(Nova.config.instances, function(instance) {
                return this.$route.params.resourceName === instance.slug;
            }.bind(this));
        },
        status() {
            return this.recording
                ? 'Bot is recording'
                : this.running
                  ? 'Bot is running'
                  : 'Bot is not running';
        }
    },
    watch: {
        logEntries: function() {
            if (!this.allowAutoScrollLogs || this.isHoveringLogs)
                return;
            this.logsHasScrollbar = this.$refs.logs.scrollHeight >= 200;
            this.$nextTick(function() {
                var container = this.$refs.logs;
                container.scrollTop = container.scrollHeight + 120;
            });
        },
        running(val) {
            let el = document.getElementById(`nav_oryxbot-instance-${this.instance.id}`);
            el = el ? el.querySelector('svg') : el;
            if (!el)
                return;

            if (val) {
                el.classList.add('text-primary')
                el.classList.remove('text-60')
            } else {
                el.classList.remove('text-primary')
                el.classList.add('text-60')
            }
        }
    }
}
</script>

<style>
/* Scoped Styles */
</style>
