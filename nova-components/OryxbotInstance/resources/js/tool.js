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
    cluster: Nova.config.pusherAppCluster,
    wsHost: window.location.hostname,
    wsPort: 6001,
    forceTLS: false,
    disableStats: true,
});
