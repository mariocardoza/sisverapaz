var total=0.0;
var contador = 0;
    $(document).ready(function(){
        inicio();

    //agregar un nuevo
    $(document).on("click","#registrar", function(e){
        $("#elplan").hide();
        $("#panel_registrar").show();
        $("#panel_editar").hide();
    });

    $(document).on("click","#cancelar_guardar,#cancelar_editar", function(e){
        $("#elplan").show();
        $("#panel_registrar").hide();
        $("#panel_editar").hide();
        $("#form_paac").trigger("reset");
        $("#form_paac_editar").trigger("reset");
    });

    $(document).on("click","#guardar", function(e){
        e.preventDefault();
        obra = $("#obra").val() || 0,
        enero = $("#ene").val() || 0.00,
        febrero = $("#feb").val() || 0.00,
        marzo = $("#mar").val() || 0.00,
        abril = $("#abr").val() || 0.00,
        mayo = $("#may").val() || 0.00,
        junio = $("#jun").val() || 0.00,
        julio = $("#jul").val() || 0.00,
        agosto = $("#ago").val() || 0.00,
        septiembre = $("#sep").val() || 0.00,
        octubre = $("#oct").val() || 0.00,
        noviembre = $("#nov").val() || 0.00,
        diciembre = $("#dic").val() || 0.00;
        var subtotal = parseFloat(enero) + parseFloat(febrero) + parseFloat(marzo) + parseFloat(abril) + parseFloat(mayo) + parseFloat(junio) + parseFloat(julio) + parseFloat(agosto) + parseFloat(septiembre) + parseFloat(octubre) + parseFloat(noviembre) + parseFloat(diciembre);
        if(obra){
            var datos=$("#form_paac").serialize();
            modal_cargando();
            $.ajax({
                url:'../paacdetalles',
                type:'POST',
                data:{paac_id:idpaac,obra,enero,febrero,marzo,abril,mayo, junio, julio,agosto,septiembre,octubre,noviembre,diciembre,subtotal},
                success: function(json){
                    if(json[0]==1){
                        toastr.success("Información guardada con éxito");
                        inicio();
                        $("#elplan").show();
                        $("#panel_registrar").hide();
                        swal.closeModal();
                        $("#form_paac").trigger("reset");
                    }else{
                        swal.closeModal();
                        toastr.error("Error");
                    }
                }
            })
        }else{
            swal(
                '¡Aviso!',
                'Debe llenar todos los campos',
                'warning'
            );
        }
    });

    $(document).on("click","#editar", function(e){
        e.preventDefault();
        id=$("#ideditar").val();
        obra = $("#e_obra").val() || 0,
        enero = $("#e_ene").val() || 0.00,
        febrero = $("#e_feb").val() || 0.00,
        marzo = $("#e_mar").val() || 0.00,
        abril = $("#e_abr").val() || 0.00,
        mayo = $("#e_may").val() || 0.00,
        junio = $("#e_jun").val() || 0.00,
        julio = $("#e_jul").val() || 0.00,
        agosto = $("#e_ago").val() || 0.00,
        septiembre = $("#e_sep").val() || 0.00,
        octubre = $("#e_oct").val() || 0.00,
        noviembre = $("#e_nov").val() || 0.00,
        diciembre = $("#e_dic").val() || 0.00;
        var subtotal = parseFloat(enero) + parseFloat(febrero) + parseFloat(marzo) + parseFloat(abril) + parseFloat(mayo) + parseFloat(junio) + parseFloat(julio) + parseFloat(agosto) + parseFloat(septiembre) + parseFloat(octubre) + parseFloat(noviembre) + parseFloat(diciembre);
        if(obra){
           
            modal_cargando();
            $.ajax({
                url:'../paacdetalles/'+id,
                type:'PUT',
                dataType:'json',
                data:{paac_id:idpaac,obra,enero,febrero,marzo,abril,mayo, junio, julio,agosto,septiembre,octubre,noviembre,diciembre,subtotal},
                success: function(json){
                    if(json[0]==1){
                        toastr.success("Información actualizada con éxito");
                        inicio();
                        $("#elplan").show();
                        $("#panel_editar").hide();
                        swal.closeModal();
                        $("#form_paac_editar").trigger("reset");
                    }else{
                        swal.closeModal();
                        toastr.error("Error");
                    }
                }
            })
        }else{
            swal(
                '¡Aviso!',
                'Debe llenar todos los campos',
                'warning'
            );
        }
    });

    $(document).on("click","#eleditar",function(e){
        var id=$(this).attr("data-id");
        $.ajax({
            url:'../paacdetalles/'+id+"/edit",
            type:'get',
            dataType:'json',
            data:{},
            success: function(json){
                if(json[0]==1){
                    $("#form_aqui").empty();
                    $("#form_aqui").html(json[2]);
                    $("#panel_editar").show();
                    $("#elplan").hide();
                    $("#panel_registrar").hide();
                }
            }
        })
    });

    $(document).on("click","#eliminar",function(e){
        var id=$(this).attr('data-id');
        swal({
            title: 'Eliminar',
            text: "¿Está seguro de eliminar este ítem?",
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
              $.ajax({
                url:'../paacdetalles/'+id,
                type:'DELETE',
                dataType:'json',
                data:{},
                success: function(json){
                  if(json[0]==1){
                    inicio();
                    $("#elplan").show();
                    $("#panel_registrar").hide();
                    toastr.success("Eliminado con exito");
                  }else{
                    toastr.error("Ocurrió un error");
                  }
                }, error: function(error){
  
                }
              });
            }
          });
    });
    
     $(document).on("click","#agregar", function(e) {
    //     //var tr     = $(e.target).parents("tr"),

         e.preventDefault();
             obra = $("#obra").val() || 0,
             ene = $("#ene").val() || 0.00,
             feb = $("#feb").val() || 0.00,
             mar = $("#mar").val() || 0.00,
             abr = $("#abr").val() || 0.00,
             may = $("#may").val() || 0.00,
             jun = $("#jun").val() || 0.00,
             jul = $("#jul").val() || 0.00,
             ago = $("#ago").val() || 0.00,
             sep = $("#sep").val() || 0.00,
             oct = $("#oct").val() || 0.00,
             nov = $("#nov").val() || 0.00,
             dic = $("#dic").val() || 0.00;

         //if(ene && feb && mar && abr && may && jun && jul && ago && sep && oct && nov &&dic){
        if(obra){

             var subtotal = parseFloat(ene) + parseFloat(feb) + parseFloat(mar) + parseFloat(abr) + parseFloat(may) + parseFloat(jun) + parseFloat(jul) + parseFloat(ago) + parseFloat(sep) + parseFloat(oct) + parseFloat(nov) + parseFloat(dic) ;
             contador++;
             $(tbMaterial).append(
                 "<tr>"+
                     "<td>" + obra + "</td>" +
                     "<td>" + onFixed( subtotal, 2 ) + "</td>" +
                     "<td>"+
                     "<input type='hidden' name='obras[]' value='"+obra+"' />"+
                     "<input type='hidden' name='enero[]' value='"+ene+"' />"+
                     "<input type='hidden' name='febrero[]' value='"+feb+"' />"+
                     "<input type='hidden' name='marzo[]' value='"+mar+"' />"+
                     "<input type='hidden' name='abril[]' value='"+abr+"' />"+
                     "<input type='hidden' name='mayo[]' value='"+may+"' />"+
                     "<input type='hidden' name='junio[]' value='"+jun+"' />"+
                     "<input type='hidden' name='julio[]' value='"+jul+"' />"+
                     "<input type='hidden' name='agosto[]' value='"+ago+"' />"+
                     "<input type='hidden' name='septiembre[]' value='"+sep+"' />"+
                     "<input type='hidden' name='octubre[]' value='"+oct+"' />"+
                     "<input type='hidden' name='noviembre[]' value='"+nov+"' />"+
                     "<input type='hidden' name='diciembre[]' value='"+dic+"' />"+
                     "<input type='hidden' name='totales[]' value='"+subtotal+"' />"+
                     "<button type='button' id='delete-btn' class='btn btn-danger'>Eliminar</button></td>" +
                 "</tr>"
             );
             total +=subtotal;
             $("#total").val(onFixed(total));
             $("#contador").val(contador);
             $("#pie #totalEnd").text(onFixed(total));
             //total2=total;
             clearForm();
         }else{
           swal(
              '¡Aviso!',
              'Debe llenar todos los campos',
              'warning'
            );
         }
     });

    $(document).on("click","#btnsub", function (e) {
        var elementos = new Array(),
            token        = null;
            proyecto  = null;
            totalpre     = null;
        $(tbMaterial).find("tr").each(function (index, element) {
            if(element){
                elementos.push({
                    material : $(element).attr("data-material"),
                    cantidad :$(element).attr("data-cantidad"),
                    precio   : $(element).attr("data-precio")
                });
                //total = totalp+(parseFloat(cantidad))*(parseFloat(precio));
            }
            token = $("#_token").val();
            proyecto = $("#proyecto").val();
            totalpre    = $("#pie #totalEnd").text();
        });

       /*var elemento = {
            cliente : cliente,
            mejora  : mejora,
            trabajados : trabajados,
            total   : totalpre,
            elementos : arrayElement
        };*/


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $.ajax({
            type: "POST",
            headers: {'X-CSRF-TOKEN' : token },
            url: '/alcaldia/public/presupuestos',
            dataType: 'json',
            data: {materiales: elementos, presupuesto: presupuesto, total: totalpre },
           success : function(msj){
                //alert('Dato insertado');
                console.log(msj.responseJSON);
                window.location.reload();
            },
            error : function(msj){
                //console.log(msj.responseJSON);


            }
      });

        /*$.post("", elemento)
        .done(function (response) {
            console.log(response);
            if(response){
                  alert("guardo");

                //win2ow.location.reload();
            }

        });*/
    });

    $(document).on("click",".realizado",function(e){
        exportado();
    });
});

function inicio(){
    modal_cargando();
    $.ajax({
        url:'../paacs/show2/'+idpaac,
        type:'get',
        dataType:'json',
        data:{},
        success: function(json){
            if(json[0]==1){
                swal.closeModal();
                $("#elplan").empty();
                $("#elplan").html(json[2]);
                tabla_excel("latabla",eltitulo);
            }else{
                swal.closeModal();
            }
        }
    });
}

function tabla_excel(tabla,titulo){
    $('#'+tabla).DataTable({
      dom: 'Bfrtip',
      buttons: [
          {
              extend: 'excelHtml5',
              footer: true,
              title: 'Plan de compras',
              messageTop: 'Plan anual '+titulo+' año '+anioplan,
              text: '<button class="btn btn-info realizado">Exportar a Excel <i class="fa fa-file-excel-o"></i></button>',
              exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13] },
              

          },
          {
              extend:'pdfHtml5',
              footer:true,
              title: 'Plan de compras',
              orientation: 'landscape',
              messageTop: 'Plan anual '+titulo+' año '+anioplan,
              exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13] },
              text: '<button class="btn btn-info realizado">Exportar a PDF <i class="fa fa-file-pdf-o"></i></button>'
          }
      ],
        language: {
            processing: "Búsqueda en curso...",
            search: "Buscar:",
            lengthMenu: "Mostrar _MENU_ Elementos",
            info: "Mostrando _START_ de _END_ de un total de _TOTAL_ Elementos",
            infoEmpty: "Visualizando 0 de 0 de un total de 0 elementos",
            infoFiltered: "(Filtrado de _MAX_ elementos en total)",
            infoPostFix: "",
            loadingRecords: "Carga de datos en proceso..",
            zeroRecords: "Elementos no encontrado",
            emptyTable: "La tabla no contiene datos",
            paginate: {
                first: "Primero",
                previous: "Anterior",
                next: "siguiente",
                last: "Último"
            },
        },
        "paging": true,
        "lengthChange": true,
        "searching": false,
        "ordering": false,
        "info": true,
        "autoWidth": true
    });
  }

  function exportado(){
      modal_cargando();
      $.ajax({
          url:'../paacs/exportar/'+idpaac,
          type:'get',
          dataType:'json',
          data:{},
          success: function(json){
            if(json[0]==1){
                toastr.success('Exportado exitosamente');
                inicio(idpaac);
                swal.closeModal();
            }else{
                swal.closeModal();
            }
          },
          error: function(error){
            swal.closeModal();
          }
      });
  }
