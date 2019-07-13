var total=0.0;
var contador = 0;
    $(document).ready(function(){
    var tbMaterial = $("#tbMaterial");

    //agregar un nuevo
    $(document).on("click","#registrar", function(e){
        $("#elplan").hide();
        $("#panel_registrar").show();
    });

    $(document).on("click","#cancelar_guardar", function(e){
        $("#elplan").show();
        $("#panel_registrar").hide();
    });

    $(document).on("click","#guardar", function(e){
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
        if(obra){
            var datos=$("#form_paac").serialize();
            modal_cargando();
            $.ajax({
                url:'../paacdetalles',
                type:'POST',
                data:datos,
                success: function(json){
                    if(json[0]==1){
                        toastr.success("Información guardada con éxito");
                        window.location.reload();
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

    function onDisplayTotal () {

    };

    $("#btnsub").on("click", function (e) {
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

    $(document).on("click", "#delete-btn", function (e) {
        var tr     = $(e.target).parents("tr"),
            totaltotal  = $("#totalEnd");
        var totalFila=parseFloat($(this).parents('tr').find('td:eq(1)').text());
        total = parseFloat(totaltotal.text()) - parseFloat(totalFila);
        var totalValue = parseFloat(totaltotal.text()) - parseFloat(totalFila);
        tr.remove();
        $("#total").val(onFixed(totalValue));
        $("#pie #totalEnd").text(onFixed(totalValue));
        contador--;
        $("#contador").val(contador);
    });

    function clearForm () {
        $("#paac").find(":text, #obra").each(function (index, element) {
          $(element).val("");
        });
    }

    function onDisplaySelect (productoID) {
        $("#producto option").each(function (index, element) {
            if($(element).attr("value") == productoID ){
                $(element).css("display", "block");
            }
     });
    }

    function onFixed (valor, maximum) {
        maximum = (!maximum) ? 2 : maximum;
        return valor.toFixed(maximum);
    }
});
