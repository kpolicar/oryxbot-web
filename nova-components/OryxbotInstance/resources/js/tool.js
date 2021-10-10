import Echo from 'laravel-echo'

Nova.booting((Vue, router, store) => {
    _.each(Nova.config.instances, function(instance) {
        router.addRoutes([
            {
                name: 'oryxbot-instance',
                path: '/instances/:resourceName',
                component: require('./components/Tool'),
                params: {
                    resourceName: instance.slug,
                },
            },
        ])
    });
})

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: Nova.config.pusherAppKey,
    wsHost: Nova.config.websocketsHost,
    wsPort: Nova.config.websocketsPort,
    wssPort: Nova.config.websocketsPort,
    enabledTransports: ['ws', 'wss'],
    forceTLS: process.env.NODE_ENV === 'production',
    disableStats: true,
});
