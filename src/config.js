module.exports = (app) => {
 app.config(['$interpolateProvider', ($interpolateProvider) => {
  $interpolateProvider.startSymbol('((')
  $interpolateProvider.endSymbol('))')
 }])

 app.config(['RestangularProvider', (RestangularProvider) => {
  let contentToken = document.querySelector('meta[name="csrf-token"]')
  RestangularProvider.setBaseUrl('./api/');
  RestangularProvider.setDefaultHeaders({  
   'X-CSRF-TOKEN' : contentToken.content,
   'Content-Type': 'application/json'
  });
 }])
}