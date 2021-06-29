$(function(e){

    //editar el contribuyente
    $(document).on("click","#edi_contri",function(e){
      e.preventDefault();
      var id=$(this).attr("data-id");
      $.ajax({
        url:'../contribuyentes/'+id+"/edit",
        type:'get',
        dataType:'json',
        success: function(json){
          if(json[0]==1){
            $("#modal_aqui").empty();
            $("#modal_aqui").html(json[2]);
            $('.nit').inputmask("9999-999999-999-9", { "clearIncomplete": true });
            $('.dui').inputmask("99999999-9", { "clearIncomplete": true });
            $('.telefono').inputmask("9999-9999", { "clearIncomplete": true });
            $('.fechita').datepicker({
              selectOtherMonths: true,
              changeMonth: true,
              changeYear: true,
              dateFormat: 'dd-mm-yy',
              minDate: "-60Y",
              maxDate: "1Y",
              format: 'dd-mm-yyyy'
    		    });
            $("#modal_editcontribuyente").modal("show");
          }
        }
      });
    });

    //form_edit
    $(document).on("click","#eform_econtribuyente",function(e){
      e.preventDefault();
      var id=$("#contri_id").val();
      var datos=$("#form_econtribuyente").serialize();
      $.ajax({
        url:'../contribuyentes/'+id,
        type:'put',
        dataType:'json',
        data:datos,
        success: function(json){
          if(json[0]==1){
            toastr.success("Contribuyente modificado con éxito");
            location.reload();
          }else{
            toastr.error("Ocurrió un error con el servidor, intente otra vez");
          }
        },
        error: function(error){
          $.each(error.responseJSON.errors,function(i,v){
            toastr.error(v);
          });
          swal.closeModal();
        }
      });
    });

    //baja a un contribuyente
    $(document).on("click",".baja",function(e){
      var id=$(this).attr("data-id");
      swal({
        title: 'Motivo por el que da de baja',
        input: 'text',
        showCancelButton: true,
        confirmButtonText: 'Dar de baja',
        showLoaderOnConfirm: true,
        preConfirm: (text) => {
          return new Promise((resolve) => {
            setTimeout(() => {
              if (text === '') {
                swal.showValidationError(
                  'El motivo es requerido.'
                )
              }
              resolve()
            }, 2000)
          })
        },
        allowOutsideClick: () => !swal.isLoading()
      }).then((result) => {
        if (result.value) {
          var motivo=result.value;
          $.ajax({
            url:'../contribuyentes/baja/'+id,
            type:'post',
            dataType:'json',
            data:{motivo},
            success: function(json){
              if(json[0]==1){
                toastr.success("Usuario dado de baja");
                location.reload();
              }else{   
                  toastr.error("Ocurrió un error");
              }
            }, error: function(error){
              toastr.error("Ocurrió un error");
            }
          });
        }
      });
    });

    //restaurar contribuyente
    $(document).on("click",".restaurar",function(e){
      e.preventDefault();
      var id=$(this).attr("data-id");
      swal({
          title: 'Contribuyente',
          text: "¿Desea restaurar este contribuyente?",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: '¡Si!',
          cancelButtonText: '¡No!',
          confirmButtonClass: 'btn btn-success',
          cancelButtonClass: 'btn btn-danger',
          buttonsStyling: false,
          reverseButtons: true
        }).then((result) => {
          if (result.value) {
            modal_cargando();
            $.ajax({
              url:'../contribuyentes/alta/'+id,
              type:'post',
              dataType:'json',
              success: function(json){
                if(json[0]==1){
                  
                  toastr.success("Contribuyente restaurado");
                  location.reload();
                }else{
                  toastr.error("Ocurrió un error");
                  swal.closeModal();
                }
              }, error: function(error){
                toastr.error("Ocurrió un error");
                swal.closeModal();
              }
            });
            
          } else if (result.dismiss === swal.DismissReason.cancel) {
          }
        });
    });

    //mapa inmueble
    $(document).on("click","#mapa_inmueble",function(e){
      e.preventDefault();
      var lalat=parseFloat($(this).attr("data-lat"));
      var lalng=parseFloat($(this).attr("data-lng"));
      var id=$(this).attr("data-id");
      $("#elidinmueble").val(id);
      initMap1(lalat,lalng);
      $("#modal_mapainmueble").modal("show");
    });

    //mapa negocio
    $(document).on("click","#mapa_negocio",function(e){
      e.preventDefault();
      var lalat=parseFloat($(this).attr("data-lat"));
      var lalng=parseFloat($(this).attr("data-lng"));
      var id=$(this).attr('data-id');
      $("#elidnegocio").val(id);
      initMapNegocio(lalat,lalng);
      $("#modal_mapanegocio").modal("show");
    });

    //modal nuevo inmueble
    $(document).on("click","#nuevo_inmueble",function(e){
      e.preventDefault();
      $("#form_inmueble").trigger("reset");
      $("#modal_inmueble").modal("show");
      initMap();
    });

    //modal nuevo negocio
    $(document).on("click","#nuevo_negocio",function(e){
      e.preventDefault();
      $("#form_negocio").trigger("reset");
      $("#modal_negocio").modal("show");
      $("#elmapitanegocio").show();
      $(".modal-title-negocio").text("Registrar negocio");
      $(".submit_editarnegocio").hide();
      $(".text-button").show();
      initMap2();
    });

    //submit a inmueble
    $(document).on("submit","#form_inmueble",function(e){
      e.preventDefault();
      var datos=$("#form_inmueble").serialize();
      $.ajax({
        url:'../inmuebles/guardar',
        type:'POST',
        dataType:'json',
        data:datos,
        success: function(json){
          if(json[0]==1){
            toastr.success("Inmueble registrado con éxito");
            $("#form_inmueble").trigger("reset");
            $("#modal_inmueble").modal("hide");
            location.reload();
          }
          
          else{
            toastr.error('Ocurrió un error');
          }
          
        },
        error: function(error){
          $.each(error.responseJSON.errors,function(i,v){
            toastr.error(v);
          });
          swal.closeModal();
        }
      });
    });

    //submit a negocio
    $(document).on("submit","#form_negocio",function(e){
      e.preventDefault();
      var datos=$("#form_negocio").serialize();
      modal_cargando();
      $.ajax({
        url:'../negocios',
        type:'POST',
        dataType:'json',
        data:datos,
        success: function(json){
          if(json.response==true){
            toastr.success("Negocio registrado con éxito");
            $("#form_negocio").trigger("reset");
            $("#modal_negocio").modal("hide");
            location.reload();
          }
          
          else{
            toastr.error('Ocurrió un error');
            swal.closeModal()
          }
          
        },
        error: function(error){
          $.each(error.responseJSON.errors,function(i,v){
            toastr.error(v);
          });
          swal.closeModal();
        }
      });
    });

    //editar inmueble (abrir modal)
    $(document).on("click",".edit_inmueble",function(e){
      e.preventDefault();
      var id=$(this).attr("data-id");
      $.ajax({
        url:'../inmueble/'+id+'/edit',
        type:'get',
        dataType:'json',
        success: function(json){
          if(json[0]==1){
            $("#modal_aqui").empty();
            $("#modal_aqui").html(json[2]);
            $("#modal_einmueble").modal("show");
            $(".chosen-select-width").chosen({'width':'100%'});
          }
        }
      });
    });

    /* cambiar radio button */
    $('input[type=radio][name=tipo_cobro]').change(function() {
      if (this.value == '1') {
          $(".tipo_cobro_text").text('Capital');
          $(".tipo_cobro_field").attr('name', 'capital'); 
          $(".tipo_cobro_field").attr('placeholder', 'Digite el capital inicial'); 
          $( ".tipo_cobro_field" ).prop( "disabled", false );
          $(".ganado").hide();
      }
      else if (this.value == '2') {
        $(".tipo_cobro_text").text('Licencia');
        $(".tipo_cobro_field").attr('name', 'licencia'); 
        $(".tipo_cobro_field").attr('placeholder', 'Digite el costo de la licencia'); 
        $( ".tipo_cobro_field" ).prop( "disabled", false );
        $(".ganado").hide();
      }else if(this.value == '3'){
        $(".tipo_cobro_text").text('Otro');
        $(".tipo_cobro_field").attr('name', 'otro'); 
        $(".tipo_cobro_field").attr('placeholder', 'Digite el valor'); 
        $( ".tipo_cobro_field" ).prop( "disabled", false );
        $(".ganado").hide();
      }else{
        $(".ganado").show();
        $( ".tipo_cobro_field" ).prop( "disabled", true );
        $(".tipo_cobro_text").text('Ganado');
      }
  });


      //submit editar a inmueble
      $(document).on("click",".submit_editinmueble",function(e){
        e.preventDefault();
        var datos=$("#form_einmueble").serialize();
        var id=$(this).attr("data-id");
        modal_cargando();
        $.ajax({
          url:'../inmueble/'+id,
          type:'put',
          dataType:'json',
          data:datos,
          success: function(json){
            if(json[0]==1){
              toastr.success("Inmueble editar con éxito");
              $("#form_einmueble").trigger("reset");
              $("#modal_einmueble").modal("hide");
              location.reload();
            }
            
            else{
              toastr.error('Ocurrió un error');
              swal.closeModal();
            }
            
          },
          error: function(error){
            $.each(error.responseJSON.errors,function(i,v){
              toastr.error(v);
            });
            swal.closeModal();
          }
        });
      });

      //editar negocio (abrir modal)
    $(document).on("click",".edit_negocio",function(e){
      e.preventDefault();
      var id=$(this).attr("data-id");
      $.ajax({
        url:'../negocios/'+id+'/edit',
        type:'get',
        dataType:'json',
        success: function(json){
          if(json[0]==1){
            $("#n_negocio").val(json[3].nombre);
            $("#direcc_negocio").val(json[3].direccion);
            $("#n_id").val(json[3].id);
            $("#elmapitanegocio").hide();
            $(".modal-title-negocio").text("Editar negocio");
            $(".submit_editarnegocio").show();
            $(".text-button").hide();
            if(json[3].tipo_cobro==1){
              $(".tipo_cobro_field").val(json[3].capital);
              $( ".tipo_cobro_field" ).prop( "disabled", false );
              $(".tipo_cobro_text").text('Capital');
              $(".tipo_cobro_field").attr('name', 'capital'); 
              $(".tipo_cobro_field").attr('placeholder', 'Digite el capital inicial');
              $(".ganado").hide();
              $("#ganado").prop("checked", false);
              $("#otro").prop("checked", false);
              $("#licencia").prop("checked", false);
              $("#capitall").prop("checked", true);
              $("#ganado").parent().removeClass("active");
              $("#capitall").parent().addClass("active");
              $("#licencia").parent().removeClass("active");
              $("#otro").parent().removeClass("active");
            }else if(json[3].tipo_cobro==2){
              $(".tipo_cobro_field").val(json[3].licencia);
              $( ".tipo_cobro_field" ).prop( "disabled", false );
              $(".tipo_cobro_text").text('Licencia');
              $(".tipo_cobro_field").attr('name', 'licencia'); 
              $(".tipo_cobro_field").attr('placeholder', 'Digite el costo de la licencia');
              $(".ganado").hide();
              $("#ganado").prop("checked", false);
              $("#otro").prop("checked", false);
              $("#licencia").prop("checked", true);
              $("#capitall").prop("checked", false);
              $("#ganado").parent().removeClass("active");
              $("#capitall").parent().removeClass("active");
              $("#licencia").parent().addClass("active");
              $("#otro").parent().removeClass("active");
            }else if(json[3].tipo_cobro==3){
              $(".tipo_cobro_field").val(json[3].otro);
              $( ".tipo_cobro_field" ).prop( "disabled", false );
              $(".tipo_cobro_text").text('Otro');
              $(".tipo_cobro_field").attr('name', 'otro'); 
              $(".tipo_cobro_field").attr('placeholder', 'Digite el otro valor');
              $(".ganado").hide();
              $("#ganado").prop("checked", false);
              $("#otro").prop("checked", true);
              $("#licencia").prop("checked", false);
              $("#capitall").prop("checked", false);
              $("#ganado").parent().removeClass("active");
              $("#capitall").parent().removeClass("active");
              $("#licencia").parent().removeClass("active");
              $("#otro").parent().addClass("active");
            }else{
              $("#ganado").prop("checked", true);
              $("#otro").prop("checked", false);
              $("#licencia").prop("checked", false);
              $("#capitall").prop("checked", false);
              $("#ganado").parent().addClass("active");
              $("#capitall").parent().removeClass("active");
              $("#licencia").parent().removeClass("active");
              $("#otro").parent().removeClass("active");
              $( ".tipo_cobro_field" ).prop( "disabled", true );
              $(".tipo_cobro_text").text('Ganado'); 
              $(".ganado").show();
              $("#p_cabezas").val(json[3].precio_cabezas);
              $("#n_cabezas").val(json[3].numero_cabezas);
            }
            
            $("#modal_negocio").modal("show");
            /*$("#modal_aqui").empty();
            $("#modal_aqui").html(json[2]);
            $(".esee").chosen({"width":'100%'});
            $(".chosen-select-width").chosen({"width":'100%'});
            $("#modal_enegocio").modal("show");*/
          }
        }
      });
    });

     //submit a inmueble
     $(document).on("click",".submit_editarnegocio",function(e){
      e.preventDefault();
      var datos=$("#form_negocio").serialize();
      var id=$("#n_id").val();
      modal_cargando();
      $.ajax({
        url:'../negocios/'+id,
        type:'put',
        dataType:'json',
        data:datos,
        success: function(json){
          if(json.response==true){
            toastr.success("Negocio editado con éxito");
            $("#form_enegocio").trigger("reset");
            $("#modal_enegocio").modal("hide");
            location.reload();
          }
          
          else{
            toastr.error('Ocurrió un error');
            swal.closeModal();
          }
          
        },
        error: function(error){
          $.each(error.responseJSON.errors,function(i,v){
            toastr.error(v);
          });
          swal.closeModal();
        }
      });
    });

    //ver los impuestos/servicios de un inmueble
    $(document).on("click",".verservicios",function(e){
        e.preventDefault();
        var id=$(this).attr("data-id");
        $("#modal_servicios_inmueble").modal("show");
        cargar_impuesto_inmueble(id);
    });

    //agregarle un nuevo impuesto a un inmueble
    $(document).on("click","#nuevo_impuesto",function(e){
        e.preventDefault();
        $(this).hide();
        $("#eldiv_agregar_impuesto").show();
    });

    //cancelar agregar impuesto
    $(document).on("click",".ccc",function(e){
        e.preventDefault();
        $("#nuevo_impuesto").show();
        $("#eldiv_agregar_impuesto").hide();
    });

    //agregar impuesto al inmuele
    $(document).on("click",".ggg",function(e){
        e.preventDefault();
        var inmueble_id=$("#idinm").val();
        var tiposervicio_id=$("#elimpuestito").val();
        $.ajax({
            url:'../inmuebles/agregarimpuesto',
            type:'post',
            dataType:'json',
            data:{id:inmueble_id,idTipoServicio:tiposervicio_id},
            success: function(json){
                if(json.response==true){
                    toastr.success("Impuesto agregado");
                    cargar_impuesto_inmueble(inmueble_id);
                }
            }
        });
    });

    //quitar impuesto
    $(document).on("click",".quitaimpuesto",function(e){
        e.preventDefault();
        var inmueble_id=$(this).attr("data-inmueble");
        var tiposervicio_id=$(this).attr("data-servicio");
        $.ajax({
            url:'../inmuebles/quitarimpuesto',
            type:'post',
            dataType:'json',
            data:{id:inmueble_id,idTipoServicio:tiposervicio_id},
            success: function(json){
                if(json[0]==1){
                    toastr.success("Impuesto removido");
                    cargar_impuesto_inmueble(inmueble_id);
                }else{
                  toastr.error("Ocurrió un error, o no se puede eliminar el impuesto");
                }
            },error: function(e){
              toastr.error("Ocurrió un error, o no se puede eliminar el impuesto");
            }
        });
    });
  });

  function cargar_impuesto_inmueble(id)
  {
    $.ajax({
        url:'../inmuebles/impuestos/'+id,
        type:'get',
        dataType:'json',
        success: function(json){
            if(json[0]==1){
                $(".tbimpuestos>tbody").empty();
                $(".tbimpuestos>tbody").html(json[2]);
                $("#elimpuestito").empty();
                $("#elimpuestito").html(json[3]);
                $("#elimpuestito").trigger('chosen:updated');
                $("#idinm").val(id);
            }
        }
    });
  }

  function initMap1(lalat,lalng) {
			console.log(lalat,lalng);
			var map;
			
			map = new google.maps.Map(document.getElementById('elmapaimueble'), {
			center: {lat: lalat, lng: lalng},
			zoom: 15,   
			});

			marker = new google.maps.Marker({
				position: {lat: lalat, lng: lalng},
				map: map,
				title: 'Inmueble',
				draggable: true,
			});

			marker.addListener('click', toggleBounce);
			

			marker.addListener( 'dragend', function (event)
			{
				//escribimos las coordenadas de la posicion actual del marcador dentro del input #coords
				var lat = this.getPosition().lat();
				var lng = this.getPosition().lng();
        var id = $("#elidinmueble").val();
        $.ajax({
          url:'/inmuebles/ubicacion',
          type:'post',
          dataType:'json',
          data:{lat,lng,id},
          success: function(json){
            if(json[0]==1){
                toastr.success("Ubicación del inmueble actualizada con éxito");
                //location.reload();
            }else{
              toastr.error("Ocurrió un error, o no se puede modificar la ubicación");
            }
          },error: function(e){
            toastr.error("Ocurrió un error, o no se puede modificar la ubicación");
          }
        })
			});
		}

    //mapa negocio
    function initMapNegocio(lalat,lalng) {
			console.log(lalat,lalng);
			var map;
			
			map = new google.maps.Map(document.getElementById('elmapanegocio'), {
			center: {lat: lalat, lng: lalng},
			zoom: 15,   
			});

			marker = new google.maps.Marker({
				position: {lat: lalat, lng: lalng},
				map: map,
				title: 'Inmueble',
				draggable: true,
			});

			marker.addListener('click', toggleBounce);
			

			marker.addListener( 'dragend', function (event)
			{
				//escribimos las coordenadas de la posicion actual del marcador dentro del input #coords
				var lat = this.getPosition().lat();
				var lng = this.getPosition().lng();
        var id= $("#elidnegocio").val();
        $.ajax({
          url:'/negocios/ubicacion',
          type:'post',
          dataType:'json',
          data:{lat,lng,id},
          success: function(json){
            if(json[0]==1){
                toastr.success("Ubicación del negocio actualizada con éxito");
                //location.reload();
            }else{
              toastr.error("Ocurrió un error, o no se puede modificar la ubicación");
            }
          },error: function(e){
            toastr.error("Ocurrió un error, o no se puede modificar la ubicación");
          }
        })
			});
		}

			function toggleBounce() {
				if (marker.getAnimation() !== null) {
					marker.setAnimation(null);
				} else {
					marker.setAnimation(google.maps.Animation.BOUNCE);
				}
			}

      initMap = function () 
      {
  //usamos la API para geolocalizar el usuario
      /*navigator.geolocation.getCurrentPosition(
        function (position){*/
          coords =  {
            lng: -88.87197894152527,
            lat: 13.643449058476703
          };
          setMapa(coords);  //pasamos las coordenadas al metodo para crear el mapa
          
          
        /*},function(error){console.log(error);});*/
      }

      initMap2 = function () 
      {
  //usamos la API para geolocalizar el usuario
      /*navigator.geolocation.getCurrentPosition(
        function (position){*/
          coords =  {
            lng: -88.87197894152527,
            lat: 13.643449058476703
          };
          setMapa2(coords);  //pasamos las coordenadas al metodo para crear el mapa
          
          
        //},function(error){console.log(error);});
      }



function setMapa (coords)
{   
      //Se crea una nueva instancia del objeto mapa
      var map = new google.maps.Map(document.getElementById('elmapitainmueble'),
      
      {
        zoom: 15,
        center:new google.maps.LatLng(13.643449058476703,-88.87197894152527),

      });
      document.getElementById("lat").value = 13.643449058476703;
      document.getElementById("lng").value = -88.87197894152527;

      //Creamos el marcador en el mapa con sus propiedades
      //para nuestro obetivo tenemos que poner el atributo draggable en true
      //position pondremos las mismas coordenas que obtuvimos en la geolocalización
      marker = new google.maps.Marker({
        map: map,
        draggable: true,
        animation: google.maps.Animation.DROP,
        position: new google.maps.LatLng(coords.lat,coords.lng),
      });
      toggleBounce();
      //agregamos un evento al marcador junto con la funcion callback al igual que el evento dragend que indica 
      //cuando el usuario a soltado el marcador
      marker.addListener('click', toggleBounce);
      
      marker.addListener( 'dragend', function (event)
      {
        //escribimos las coordenadas de la posicion actual del marcador dentro del input #coords
        document.getElementById("lat").value = this.getPosition().lat();
        document.getElementById("lng").value = this.getPosition().lng();
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({
          'latLng': event.latLng
        }, function(results, status) {
          if (status == google.maps.GeocoderStatus.OK) {
            if (results[0]) {
              $("#direcc").val(results[0].formatted_address);
              $("#ladireccion").text(results[0].formatted_address);
            }
          }
        });
      });
}

function setMapa2 (coords)
{   
      //Se crea una nueva instancia del objeto mapa
      var map = new google.maps.Map(document.getElementById('elmapitanegocio'),
      
      {
        zoom: 15,
        center:new google.maps.LatLng(13.643449058476703,-88.87197894152527),

      });
      document.getElementById("latnegocio").value = 13.643449058476703;
      document.getElementById("lngnegocio").value = -88.87197894152527;

      //Creamos el marcador en el mapa con sus propiedades
      //para nuestro obetivo tenemos que poner el atributo draggable en true
      //position pondremos las mismas coordenas que obtuvimos en la geolocalización
      marker = new google.maps.Marker({
        map: map,
        draggable: true,
        animation: google.maps.Animation.DROP,
        position: new google.maps.LatLng(coords.lat,coords.lng),
      });
      toggleBounce();
      //agregamos un evento al marcador junto con la funcion callback al igual que el evento dragend que indica 
      //cuando el usuario a soltado el marcador
      marker.addListener('click', toggleBounce);
      
      marker.addListener( 'dragend', function (event)
      {
        //escribimos las coordenadas de la posicion actual del marcador dentro del input #coords
        document.getElementById("latnegocio").value = this.getPosition().lat();
        document.getElementById("lngnegocio").value = this.getPosition().lng();
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({
          'latLng': event.latLng
        }, function(results, status) {
          if (status == google.maps.GeocoderStatus.OK) {
            if (results[0]) {
              $("#direcc_negocio").val(results[0].formatted_address);
            }
          }
        });
      });
}
