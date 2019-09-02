<html>
    <head>
        <style>
            @page { margin: 180px 50px; }
            #header { position: fixed; left: 0px; top: -180px; right: 0px; height: 200px;  text-align: center; }
            #footer { position: fixed; left: 0px; bottom: -180px; right: 0px; height: 150px; }
            #footer .page:after { content: counter(page, upper-roman); }
        </style>
            <body>
                    <div id="header">
	
                            <table rules="" width="100%">
                                <tr>
                                    <td width="15%" rowspan=""><center><img src="{{asset('img/verapaz.png')}}" width="130px" height="130px" alt=""></center></td>
                        
                                    <td width="50%">
                                        <h5><center>
                                            ALCALDIA MUNICIPAL DE VERAPAZ, DEPTO. SAN VICENTE
                                            UNIDAD DE TESORERÍA
                                            <p></p>
                                        </center></h5>
                                    </td>
                                    <td width="15%" rowspan=""><center><img src="{{asset('img/escudoes.gif')}}" width="100px" height="100px" alt="escudo El Salvador"></center></td>
                                </tr>
                            
                            </table>
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



                <div id="content">
                        <p></p>
                        <p></p>
                    <table>
                            @foreach ($contribuyentes as $item)
                            <tr>
                                <td>{{ $item->nombre }}
                                </td>
                            </tr>
                            @endforeach
                    </table>
                
                </div>
        </body>
            
</html>