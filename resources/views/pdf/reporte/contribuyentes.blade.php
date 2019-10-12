<style>
    @page { margin: 190px 50px; }
    #header { position: fixed; left: 0px; top: -180px; right: 0px; height: 200px;  text-align: center; }
    #titulo { position: fixed; left: 0px; top: -70px; right: 0px; height: 200px;  text-align: center; }
    #footer { position: fixed; left: 0px; bottom: -180px; right: 0px; height: 50px; }
    #footer2 { position: fixed; left: 0px; bottom: -110px; right: 0px; height: 50px;}
    #footer .page:after { content: counter(page, upper-decimal); }

.table {
    position: relative; left: 0px; top: 20px;
width: 100%;
max-width: 100%;
margin-bottom: 20px;
}

table {
background-color: transparent;
}

.table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
border: 1px solid #f4f4f4;
}

</style>
    <body>
            <div id="header">

                    <table rules="" width="100%">
                        <tr>
                            <td width="15%" rowspan=""><center><img src="{{asset('img/verapaz.png')}}" width="130px" height="130px" alt=""></center></td>
                
                            <td width="50%">
                                <h5><center>
                                    ALCALDIA MUNICIPAL DE VERAPAZ
                                </center></h5>
                                <h5><center>
                                    DEPARTAMENTO DE SAN VICENTE, EL SALVADOR C.A.
                                </center></h5>
                                <h5><center>
                                    UNIDAD DE REGISTRO Y CONTROL TRIBUTARIO
                                </center></h5>
                            </td>
                            <td width="15%" rowspan=""><center><img src="{{asset('img/escudoes.gif')}}" height="100px" alt="escudo El Salvador"></center></td>
                        </tr>                    
                    </table>
                </div>
                <div id="titulo">
                        <table width="100%">
                                <tr>
                                    <td> <strong>
                                            <h1>
                                                <center> LISTADO DE CONTRIBUYENTES
                                                </center>
                                            </h1>
                                    </strong>
                                    </td>
                                </tr>
                        </table>
                    </div>

                <div id="footer2">
                        <table width="100%">
                                <tr>
                                    <td> <strong>
                                        <center>Calle Pbro. Norberto Marroquín y 1a avenida sur barrio Mercedes, Verapaz, departamento de San Vicente
                                            TEL:2347-0300 FAX:2396-3012 e-mail:uaci.alcaldiaverapaz@gmail.com
                                        </center>
                                    </strong>
                                    </td>
                                </tr>
                        </table>
                    </div>
                <div id="footer">
                    <table width="100%">
                        <tr>
                            <td><center class="page"> Página </center></td>
                        </tr>
                    </table>
                </div>
<div class="col-md-12"> 
    <table class="table" border="1" style="border-collapse:collapse">
        <thead class="thead-dark">
                <tr>                    
                        <th style="text-align:center">N°</th>
                        <th style="text-align:center">Nombre</th>
                        <th style="text-align:center">DUI</th>
                        <th style="text-align:center">NIT</th>
                        <th style="text-align:center">Fecha Nacimiento</th>
                        <?php $correlativo=0?>
                      </tr>
        </thead>
        @foreach ($contribuyentes as $item)
        <tbody>
        <tr>
            <td style="text-align:center">{{ $item->id }}
            </td>
            <td>{{ $item->nombre }}
            </td>
            <td style="text-align:center">{{ $item->dui }}
            </td>
            <td style="text-align:center">{{ $item->nit }}
            </td>
            <td style="text-align:center"><?php $originalDate = $item->nacimiento;
        $newDate = date("d/m/Y", strtotime($originalDate));
        echo  $newDate;
        ?>
            </td>
        </tr>
        @endforeach
    </tbody>
    </table>
  </div>
