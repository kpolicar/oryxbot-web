Nova.booting((Vue, router, store) => {
  router.addRoutes([
    {
      name: 'oryxbot-insights',
      path: '/insights',
      component: require('./components/Tool'),
    },
  ])
})
