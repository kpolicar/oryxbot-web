Nova.booting((Vue, router, store) => {
  router.addRoutes([
    {
      name: 'oryxbot-logs',
      path: '/logs',
      component: require('./components/Tool'),
    },
  ])
})
