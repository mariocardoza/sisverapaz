module.exports =  ["$scope", '$compile', 'DTOptionsBuilder', 'DTColumnBuilder', 'Restangular', '$uibModal', 'toastr', function ($scope, $compile, DTOptionsBuilder, DTColumnBuilder, Restangular, $uibModal, toastr) {
  var language = {
    processing: "Procesando...",
    search: "Buscar:",
    lengthMenu: "Mostrar _MENU_ el&eacute;mentos",
    info: "Mostrando desde _START_ al _END_ de _TOTAL_ elementos",
    infoEmpty: "Mostrando ningún elemento.",
    infoFiltered: "(filtrado _MAX_ elementos total)",
    infoPostFix: "",
    loadingRecords: "Cargando registros...",
    zeroRecords: "No se encontraron registros",
    emptyTable: "No hay datos disponibles en la tabla",
    paginate: {
      first: "Primero",
      previous: "Anterior",
      next: "Siguiente",
      last: "Último"
    },
    aria: {
      sortAscending: ": Activar para ordenar la tabla en orden ascendente",
      sortDescending: ": Activar para ordenar la tabla en orden descendente"
    }
  }

  $scope.generarPagosContribuyente = function() {
    Restangular.all('contribuyentes/pagos').post().then((json) => {
      if(json.error){
        toastr.error(json.message, 'Error')
      }else{
        toastr.success(json.message, 'Exito!')
      }
    })
  }

  $scope.dtOptions = DTOptionsBuilder
   .fromSource('api/contribuyentes')
   // para cambiar el idioma de la tabla (38)
   .withLanguage(language)
   .withOption('createdRow', createdRow)
   .withPaginationType('full_numbers')

  $scope.dtColumns =  [
    DTColumnBuilder.newColumn('id').withTitle('Id'),
    DTColumnBuilder.newColumn('nombre').withTitle('Nombre'),
    DTColumnBuilder.newColumn('telefono').withTitle('Telefono'),
    DTColumnBuilder.newColumn('dui').withTitle('DUI').notSortable(),
    DTColumnBuilder.newColumn('nit').withTitle('NIT').notSortable(),
    DTColumnBuilder.newColumn(null).withTitle('Opciones').notSortable()
    .renderWith(actionsHtml)
  ]

  function createdRow(row, data, dataIndex) {
    $compile(angular.element(row).contents())($scope);
  }

 $scope.DarBajaStudent = (id, estado) => {
   Restangular.all('contribuyentes').customDELETE(id, {
    estado: (estado == 1) ? 0 : 1
  }).then(response => {

  })
 }

  function actionsHtml(data, type, full, meta) {
    return `
     <div class='btn-group text-align'>
      <a ui-sref="app.contribuyenteitem({ id: ${data.id} })" class='btn btn-warning'><i class="fa fa-eye"></i></a>
      <a ui-sref="app.contribuyentepagos({ contribuyente: ${data.id} })" class="btn btn-success">
        <i class="fa fa-fw fa-dollar"></i>
      </a>
      <a class="btn btn-info" href="/pagos/${data.id}">
        <i class="fa fa-fw fa-dollar"></i>
      </a>
     </div>
    `;
  }

  // para la creacion del nuevo contribuyente
  $scope.openModalContribuyente = () => {
    let open = $uibModal.open({
      template: require('html-loader!../templates/contribuyente/modalCreateAddContribuyente.html'),
      controller: function ($scope, $uibModalInstance) {
        $scope.people = {};
        $scope.cerrar = () => $uibModalInstance.close({ })

        $scope.onSaveContribuyente = () => {
          Restangular.all('contribuyentes').customPOST({
            object: $scope.people
          }).then(j => {
            if(j.response){
              $uibModalInstance.close({
                obj: j.data,
                resp: j.response
              })
              toastr.success(j.message, 'Exito')              
            }else{
              toastr.error(j.message, 'Error')
              $uibModalInstance.close({ resp: false })
            }
          })
        }
      }
    })

    open.result.then(obj => {
      if(obj.resp){
        
      }
    })
  }

  // Programacion para los rubros
  // --- modal-rubros-contribuyente.html ---
  $scope.openModalRubros = function () {
    $uibModal.open({
      size: 'lg',
      template: require('html-loader!../templates/contribuyente/modal-rubros-contribuyente.html'),
      controller: function ($scope, Restangular, rubros) {
        $scope.rubroCopy = {};
        $scope.rubros = rubros; 
        $scope.isValueNuevo = false;

        $scope.createNuevoRubro = () => {
          $scope.isValueNuevo = true;
          $scope.rubroCopy = {};
          $scope.rubros.push({ nombre: null, porcentaje: null, estado: 0, edit: true  });
        };

        $scope.cancelar = () => {
          $scope.rubros.splice($scope.rubros.length -1, 1);
          $scope.isValueNuevo = false;        
        }

        $scope.onSaveRubro = () => {
          const rubro = $scope.rubroCopy;
          if(rubro.nombre && rubro.porcentaje){
            if(rubro.porcentaje <= 0){
              toastr.error('El porcentaje no puede ser menor o igual a cero', 'Error');
              return;
            }

            Restangular.all('rubros').customPOST({
              data: rubro
            }).then(j => {
              $scope.cancelar();
              $scope.rubros.push( j.data );
            });
          }else{
            toastr.error('Todos los campos son requerido', 'Error');
          }         
        }

        // Desactivar un rubro
        $scope.onDesactivarRubro = function (rubro) {
          Restangular.all('rubros').customDELETE(rubro.id,{
            estado: !rubro.estado
          }).then(j => {
            if(j.ok) {
              toastr.success(j.message, 'Exito')
              rubro.estado = !rubro.estado
            }else{
              toastr.error(j.message, 'Error')
            }
          })
        };

        // Editar        
        $scope.edit = function ($index, rubro, options) {
          rubro.edit = options.edit
          $scope.rubroCopy = angular.copy(rubro)
        };

        $scope.onEditRubro = function (rubro, $index) {
          if($scope.rubroCopy.nombre && $scope.rubroCopy.porcentaje){
            if($scope.rubroCopy.porcentaje <= 0){
              toastr.error('El porcentaje no puede ser menor o igual a cero', 'Error');
              return;
            }

            Restangular.all('rubros').customPUT({
              data: $scope.rubroCopy
            }, rubro.id).then(j => {
              if(j.ok){
                $scope.edit(null, rubro, { edit: false })
                toastr.success(j.message, 'Exito')
                $scope.rubros[$index] = j.data
              }else{
                toastr.error(j.message, 'Error')
              }
            })
            
          }else{
            toastr.error('Todos los campos son requerido', 'Error');
          }
        };
      },
      resolve: {
        rubros: ['Restangular', function () {
          return Restangular.all('rubros').customGET();
        }]
      }
    })
  };

  // --- openModalServicio ---
  $scope.openModalServicio = function () {    
    $uibModal.open({
      size: 'lg',
      template: require('html-loader!../templates/contribuyente/modal-tipo-servicio-contribuyente.html'),
      controller: function ($scope, Restangular, tipo_servicios) {
        $scope.tipoCopy = {};
        $scope.isValueNuevo = false;
        $scope.TipoServicios = tipo_servicios;

        /* Nuevo Tipo servicio */
        $scope.createNuevoTipo = () => {
          $scope.isValueNuevo = true;
          $scope.tipoCopy = {};
          $scope.TipoServicios.push({ nombre: null, costo: null, estado: 0, edit: true  });
        };

        $scope.cancelar = () => {
          $scope.TipoServicios.splice($scope.TipoServicios.length -1, 1);
          $scope.isValueNuevo = false;        
        };

        $scope.onSaveTipo = () => {
          const tipo = $scope.tipoCopy;
          if(tipo.nombre && tipo.costo){
            if(tipo.costo <= 0){
              toastr.error('El porcentaje no puede ser menor o igual a cero', 'Error');
              return;
            }

            Restangular.all('tipo_servicios').customPOST({
              data: tipo
            }).then(j => {
              $scope.cancelar();
              $scope.TipoServicios.push( j.data );
            });
          }else{
            toastr.error('Todos los campos son requerido', 'Error');
          }
        };

        /* Desactivar: Tipo Servicio */
        $scope.onDesactivarTipoServicio = function (tipo) {
          Restangular.all('tipo_servicios').customDELETE(tipo.id,{
            estado: !tipo.estado
          }).then(j => {
            if(j.ok) {
              toastr.success(j.message, 'Exito')
              tipo.estado = !tipo.estado
            }else{
              toastr.error(j.message, 'Error')
            }
          });
        };

        /* Editar: Tipo Servicio */
        $scope.edit = function ($index, tipo, options) {
          tipo.edit = options.edit
          $scope.tipoCopy = angular.copy(tipo)
        };

        $scope.onEditServicio = function (tipo, $index) {
          if($scope.tipoCopy.nombre && $scope.tipoCopy.costo){
            if($scope.tipoCopy.costo <= 0){
              toastr.error('El costo no puede ser menor o igual a cero', 'Error');
              return;
            }

            Restangular.all('tipo_servicios').customPUT({
              data: $scope.tipoCopy
            }, tipo.id).then(j => {
              if(j.ok){
                $scope.edit(null, tipo, { edit: false });
                toastr.success(j.message, 'Exito');
                $scope.TipoServicios[$index] = j.data;
              }else{
                toastr.error(j.message, 'Error');
              }
            });
            
          }else{
            toastr.error('Todos los campos son requerido', 'Error');
          }
        };
      },
      resolve: {
        tipo_servicios: ['Restangular', function () {
          return Restangular.all('tipo_servicios').customGET();
        }]
      }
    })
  };
}]