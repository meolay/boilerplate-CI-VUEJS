// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'

import HelloWorld from './components/hello-world/hello-world'

Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({
  el: '#app',
  components:
  {
    HelloWorld: HelloWorld,
  },
})
