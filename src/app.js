import uiRouter from 'angular-ui-router'
import uiBootstrap from 'angular-ui-bootstrap'
import AngularDatables from 'angular-datatables'
import restangular from 'restangular'
import ngMap from 'ngmap'

import ngAnimate from 'angular-animate'
import toastr from 'angular-toastr'
import angularUiBootstrap from 'angular-ui-bootstrap'

let app = angular.module('app.sistema', [
 'ui.router',
 'datatables',
 'restangular',
 'ui.bootstrap',
 'ngMap',
 'ngAnimate',
 'toastr',
 'ui.bootstrap'
])

require('./config')(app)
require('./controllers')(app)
require('./routers')(app)

export default app