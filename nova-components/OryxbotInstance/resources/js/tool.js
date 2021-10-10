import Echo from 'laravel-echo'

Nova.booting((Vue, router, store) => {
  router.addRoutes([
    {
      name: 'oryxbot-instance',
      path: '/instances',
      component: require('./components/Tool'),
    },
  ])
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
