module.exports = (app) => {
 app.config(($stateProvider, $urlRouterProvider) => {
  $stateProvider
   .state('app', {
    url: '/app',
    abstract: true,
    template: require('html-loader!./templates/app.html')
  })
  .state('app.contribuyentepagos',{
    url:'/{contribuyente}/pagos',
    controller: 'ContribuyentePagosController',
    resolve: {
      people: ['Restangular', '$stateParams', function(Restangular, $stateParams) {
        return Restangular.all('contribuyentes').customGET($stateParams.contribuyente)
      }],
      items: ['Restangular', '$stateParams', function(Restangular, $stateParams) {
        return Restangular.all('contribuyentes').customPOST({
          id: $stateParams.contribuyente
        }, 'facturaItems')
      }],
    },
    template: require('html-loader!./templates/contribuyente/pagos/index.html')
  })
  .state('app.contribuyente', {
    url:'/contribuyente',
    controller: 'ContribuyeteController',
    template: require('html-loader!./templates/contribuyente/index.html')
   })
   .state('app.contribuyenteitem', {
    url:'/{id}/contribuyente',
    controller: 'ContribuyeteItemController',
    resolve: {
      people: ['Restangular', '$stateParams', function(Restangular, $stateParams) {
        return Restangular.all('contribuyentes').customGET($stateParams.id)
      }]
    },
    template: require('html-loader!./templates/contribuyente/item.html')
   });
   
   $urlRouterProvider.otherwise(`/app/contribuyente`);
 })
}