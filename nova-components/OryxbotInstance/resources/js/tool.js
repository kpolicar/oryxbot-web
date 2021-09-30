Nova.booting((Vue, router, store) => {
  router.addRoutes([
    {
      name: 'oryxbot-instance',
      path: '/instances',
      component: require('./components/Tool'),
    },
  ])
})
