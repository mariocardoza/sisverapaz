module.exports =  ["$scope", 'people', 'Restangular', '$uibModal', 'toastr', function ($scope, people, Restangular, $uibModal, toastr) {
 $scope.people = people;

  $scope.contribuyenteInmueble = require('html-loader!../templates/contribuyente/contribuyente-inmuble-table.html')

  let darBajaFunction = (id, motivo, estado) => {
    return Restangular.all('contribuyentes')
      .customPOST({
        id,
        motivo: motivo,
        estado: (estado ? 0 : 1)
      },'darBajaContribuyente')
  }

  let cerrarModal = ($uibModalInstance) => {
    $uibModalInstance.close({ response: false, message: 'Has cerrado el modal' })
  }

  $scope.onModalBajaContribuyente = (people) => {
    if(people.estado == 1){
      let open = $uibModal.open({
        resolve: { people: () => people },
        template: require('html-loader!../templates/contribuyente/modalDarBajaContribuyente.html'),
        controller: ($scope, Restangular, people, $uibModalInstance) => {
          $scope.people = people;
          $scope.cerrar = () => { cerrarModal($uibModalInstance) }
  
          $scope.onDarBaja = () => {
            darBajaFunction(people.id, $scope.motivo, $scope.people.estado)
            .then(json => {
              if(json.response) {
                $uibModalInstance.close({
                  people : json.data,
                  response: true
                });
                toastr.info('baja al contribuyente', 'baja')
              }
            });
          }
        }
      });
  
      open.result.then( res => {
        if(res.response)
          $scope.people.estado = 0
      })
    }else{
      darBajaFunction(people.id, '', people.estado).then(json => {
        $scope.people.estado = 1
        toastr.info('activo al contribuyente', 'activo contribuyente')
      })
    }
  }

  $scope.onDeleteBaja = (item) => {
    let estado = (item.estado == 1) ? 0 : 1
    Restangular.all('inmuebles').customDELETE(item.id, {
      estado: estado
    }).then(response => {
      item.estado = estado
      if(estado == 1){
        toastr.info('activo al inmueble', 'activo inmueble')
      }else{
        toastr.info('inactivo al inmueble', 'inactivo inmueble')
      }
    })
  }

  // Modal para agregar o editar un contribuyente
  $scope.onViewCreateEditInmueble = (isNew = true, people) => {
    let open = $uibModal.open({
    template: require('html-loader!../templates/contribuyente/modalCreateEditInmueble.html'),
    controller: ($scope, $uibModalInstance, Restangular) => {
      $scope.people = people;
      $scope.people.nacimiento = new Date(people.nacimiento)
      $scope.cerrar = () => { cerrarModal($uibModalInstance) }

      $scope.onSaveEditContribuyente = () => {
        let { people } = $scope;
        Restangular.all('contribuyentes').customPOST({
          people, 
        }, 'update').then(json => {
          if(json.response){
            toastr.success(json.message, 'Exito')
            $uibModalInstance.close({  response: true, data: json.data })
          }
        })
      } 
    }
    })

    open.result.then(response => {
      people = Object.assign(people, response.data)
      people.nacimiento = new Date(people.nacimiento)
    })
  }

  // Modal para agregar o editar un inmueble
  $scope.onViewCreateEditInmuebleController = (isNew = true, item, $index) => {
    let open = $uibModal.open({
      size: 'lg',
      template: require('html-loader!../templates/contribuyente/modalCreateEditInmuebleController.html'),
      controller: function ($scope, $uibModalInstance, isNew, item, NgMap) {
        $scope.inmueble ={}
        $scope.isNew = isNew
        $scope.geocoder = null;
        $scope.position = { lat:13.644366, lng:-88.870235 }

        NgMap.getMap().then(map => {
          $scope.geocoder = new google.maps.Geocoder();
          google.maps.event.trigger(map, "resize");
          map.setCenter($scope.position)
        })

        if(isNew){
          $scope.inmueble = item;
        }

        $scope.cerrar = () => cerrarModal($uibModalInstance)
        $scope.updateMarkerPoints = (event) => {
          let { latLng } = event
          $scope.geocoder.geocode({'location': latLng}, function (results, status) {
            if(status === 'OK'){
              if(results[0]){
                $scope.$apply(function () {
                  $scope.position = {
                    lat: latLng.lat(), lng: latLng.lng()
                  }
                  $scope.inmueble.direccion_inmueble = results[0].formatted_address;
                })
              }
            }
          })          
        }

        $scope.onSaveEditInmuble = () => {
          $scope.inmueble.longitude = $scope.position.lng;
          $scope.inmueble.latitude  = $scope.position.lat;

          if(isNew){
            Restangular.all('inmuebles').customPUT({
              object: $scope.inmueble,
              contribuyente: people.id
            }, $scope.inmueble.id).then(j => {
              if(j.response){
                toastr.success('Hemos realizado con éxito la peticion.', 'Éxito');
                $uibModalInstance.close({
                  obj: j.inmueble,
                  response : j.response,
                  update: true
                }); 
              }else{
                toastr.error(j.message, 'Error');
                $uibModalInstance.close({
                  response: false
                });
              }
            });
          }else{
            Restangular.all('inmuebles').customPOST({
              object: $scope.inmueble,
              contribuyente: people.id
            }).then(j => {
              if(j.response){
                toastr.success('Hemos realizado con exito la peticion.', 'Exito');
                $uibModalInstance.close({
                  obj: j.inmueble,
                  response : j.response
                });
              }else{
                toastr.error(j.message, 'Error');
                $uibModalInstance.close({
                  response: false
                });
              }
            });
          }
        };
      },
      resolve: {
        isNew  : () => isNew,
        item   : () => item
      }
    });

    open.result.then(resp =>{
      if(resp.response){
        if(resp.update){
          $scope.people.inmuebles[$index] = resp.obj;
        }else{
          $scope.people.inmuebles.push(resp.obj);
        }
      }
    });
  };
 
  // Modal para presentar los tipos de servicio
  $scope.onViewTipoServicio = (id) => {
    let $open = $uibModal.open({
    size:'lg',
    resolve: {
      tipoServicios: ['Restangular', function(Restangular){
      return Restangular.all('tipo_servicios').customGET();
      }],
      inmueble:['Restangular', function(Restangular) {
      return Restangular.all(`inmuebles/${id}`).customGET();
      }]
    },
    controller: ($scope, Restangular, tipoServicios, inmueble, $uibModalInstance) => {
      $scope.tipoServicios = tipoServicios;
      $scope.inmueble = inmueble;

      $scope.cerrar = () => { cerrarModal($uibModalInstance); };

      $scope.isShow = false;
      $scope.onShowAdd = (show) => $scope.isShow = show;

      $scope.deleteImpuesto = ($index, idTipoServicio) => {
      Restangular.all('inmuebles/removeTipoServicio').customPOST({
        id, 
        idTipoServicio
      }).then((json) => {
        if(json.response){
          $scope.inmueble.tipo_servicio.splice($index, 1);
          toastr.info(
            'se elimino correctamente el servicio', 
            'servico eliminado inmueble', { "hideDuration": "5000" }
          );
        }
      });
      };

      $scope.addTipoServicio = () => {
      Restangular.all('inmuebles/addTipoServicio').customPOST({
        id, 
        idTipoServicio: parseInt($scope.impuesto)
      }).then((json) => {
        $scope.onShowAdd(false);
        if(json.response){
        $scope.inmueble.tipo_servicio.push(json.data);
        toastr.info(
          'se agrego correctamente el servicio', 
          'servico agregado inmueble',
          { "timeOut": "0", }
        );
        }else{
          toastr.error(json.message, 'Error');
        }
      }, (error) => toastr.error('Tenemos un problema no puedes eliminar un impuesta ya cobrado', 'Error'));
      };
      
    },
    template: require('html-loader!../templates/contribuyente/modalTipoServicio.html')  
    });
  };

  // Actualizar la ubicacion del inmueble
  $scope.onViewMap = (item, $index) => {
  let open = $uibModal.open({
    size: 'noventa',
    resolve: {
    $parent: $scope.people
    },
    controller: ($scope, NgMap, Restangular, $parent, $uibModalInstance) => {
    $scope.map = null;
    $scope.geocoder  = null;
    $scope.positions = [];

    NgMap.getMap().then(map => {
      $scope.map = map;
      $scope.geocoder = new google.maps.Geocoder();
      let center = {
        "lat": parseFloat(item.latitude),
        "lng": parseFloat(item.longitude)
      };
      google.maps.event.trigger(map, "resize");
      map.setCenter(center);
      $scope.positions.push(center);
    });

    $scope.updateMarkerPoints = function (event) {
      let { latLng } = event;
      if(latLng){
        $scope.geocoder.geocode({'location': latLng}, function (results, status) {
          if(status === 'OK'){
            if(results[0]){
              Restangular.all('contribuyentes').customPOST({
                id: item.id,
                lat: latLng.lat(),
                lng: latLng.lng(),
                direccion_inmueble: results[0].formatted_address
              }, 'updateLatLng').then(result => {
                if(result.response){
                  $parent.inmuebles[$index] = Object.assign($parent.inmuebles[$index], {
                    latitude:           result.data.latitude,
                    longitude:          result.data.longitude,
                    direccion_inmueble: result.data.direccion_inmueble
                  });
                  $scope.positions[0] = { lat: result.data.latitude, lng: result.data.longitude };
                  toastr.info('se actualizo la direccion del inmueble correctamente', 'inmueble ubicacion');
                }
              });
            }else{
              toastr.error('Lo sentimos pero por el momento no podes hacer la actualizacion de la ruta', 'Problemas');
            }
          }else{
            toastr.error('Tenemos problemas con el servidor de google maps intenta mas tarde', 'Problemas');
          }
        });
      }
    };

    $scope.cerrar = () => { cerrarModal($uibModalInstance); };
    },
    template: require('html-loader!../templates/contribuyente/modalViewMap.html')
  });
  };

  // Para los negocios
  $scope.onDesactivarNegocio = function (negocio) {
    Restangular.all('contribuyente/negocio').customPOST({
      id: negocio.id,
      estado: !negocio.estado
    },'darBajaNegocio').then((response => {
      let { ok, message, data } = response;
      if(ok){
        negocio.estado = data.estado
        return toastr.success(message, 'Exito!')
      }
      toastr.error(message, 'Error!')
    }));
  };

  $scope.modalOpenCreateEditNegocio = function (isNew = false, people = {}, $index = 0) {
    let open = $uibModal.open({
      size: 'lg',
      template: require('html-loader!../templates/contribuyente/modalCreateEditNegocioController.html'),
      controller: function ($scope, $uibModalInstance, isNew, people, NgMap, rubros, index) {
        $scope.negocio = {};
        $scope.isNew = isNew;
        $scope.rubros = rubros;
        $scope.geocoder = null;
        $scope.isViewMap = true;
        $scope.position = { lat:13.644366, lng:-88.870235 };

        $scope.cerrar = () => cerrarModal($uibModalInstance);
        NgMap.getMap().then(map => {
          $scope.geocoder = new google.maps.Geocoder();
          google.maps.event.trigger(map, "resize");
          map.setCenter($scope.position);
        });

        $scope.updateMarkerPoints = (event) => {
          let { latLng } = event
          $scope.geocoder.geocode({'location': latLng}, function (results, status) {
            if(status === 'OK'){
              if(results[0]){
                $scope.$apply(function () {
                  $scope.position = {
                    lat: latLng.lat(), lng: latLng.lng()
                  }
                  $scope.negocio.direccion = results[0].formatted_address;
                })
              }
            }
          })          
        };

        if(isNew) {
          let { rubro_id } = people.negocios[index]; 
          $scope.negocio = people.negocios[index];
          $scope.negocio.rubro_id = rubro_id.toString();
          $scope.negocio.capital = parseFloat($scope.negocio.capital);
          $scope.isViewMap = false;
        }

        $scope.onSaveEditNegocio = () => {
          $scope.negocio.lng = $scope.position.lng;
          $scope.negocio.lat = $scope.position.lat;

          if(isNew){
            Restangular.all('negocios').customPUT({
              object: $scope.negocio,
              contribuyente: people.id
            }, $scope.negocio.id).then(j => {
              if(j.response){
                toastr.success(j.message, 'Exito');
                $uibModalInstance.close({
                  obj: j.data,
                  isNew: false,
                  response : j.response
                }); 
              }else{
                toastr.error(j.message, 'Error');
                $uibModalInstance.close({
                  response: false
                });
              }
            });
          }else{
            if($scope.negocio.direccion) {
              Restangular.all('negocios').customPOST({
                object: $scope.negocio,
                contribuyente: people.id
              }).then(j => {
                if(j.response){
                  toastr.success(j.message, 'Exito');
                  $uibModalInstance.close({
                    obj: j.data,
                    isNew: true,
                    response : j.response
                  });
                }else{
                  toastr.error(j.message, 'Error');
                  $uibModalInstance.close({
                    response: false
                  });
                }
              });
            }
          }
        };

      },
      resolve: {
        rubros: ['Restangular', function (Restangular) {
          return Restangular.all('GetRubrosApiController').customPOST()
        }],
        isNew, people, index: $index
      }
    });

    open.result.then(resp => {
      if(resp.isNew && resp.response){
        return $scope.people.negocios.push(resp.obj);
      }else if(!resp.isNew && resp.response){
        return $scope.people.negocios.splice($index, 1, resp.obj)
      }
      return toastr.error(resp.message, 'Error');
    });
  };
}];