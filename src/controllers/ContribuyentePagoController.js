module.exports =  ["$scope", 'people', 'items', 'Restangular', '$uibModal', 'toastr', 
  function ($scope, people, items, Restangular, $uibModal, toastr) {
    $scope.people = people;
    $scope.inmuebles = items.data;

    $scope.onViewPagosPendiente = (factura_id) => {
      Restangular.all('contribuyentes/inmuebles').customPOST({
        id: factura_id
      }, 'facturaItems').then(json => {
        console.log(json);
      })
    }
  }
]