
      <html lang="es">
<title>Reporte de círculo de nino </title>
<body style="font-size: 10px; font-family: Times New Roman; " >

<!-- Bootstrap 3.3.7 -->
<link rel="stylesheet" href="{{ asset('/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('/bower_components/font-awesome/css/font-awesome.min.css') }}">
<style>
#personal {
    float:left;  
}
</style>


<table class="table">
  <thead>
    <tr>
      <th width="10%">
      <img src="{{ url('/dist/img/logo-ES.jpg') }}" width="60px" height="60px">
      </th>
      <th width="80%" class="text-center" style="font-size: 10px;" >
        REPORTE “MODELO DE EDUCACIÓN Y DESARROLLO INTEGRAL PARA LA PRIMERA INFANCIA”.<br> 
            <?php $str = strtoupper("hola"); ; ?>.<br> 
          FICHA DE INSCRIPCIÓN Y MATRICULA PARA LA VÍA FAMILIAR COMUNITARIA<br>
        <?php
              date_default_timezone_set('America/El_Salvador');
      
              $week_days = array ("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado");  
              $months = array ("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");  
              $year_now = date ("Y");  
              $month_now = date ("n");  
              $day_now = date ("j");  
              $week_day_now = date ("w");  
              $date = $week_days[$week_day_now] . ", " . $day_now . " de " . $months[$month_now] . " de " . $year_now; 
              $hoy=$year_now."-".$month_now."-".$day_now;
              echo strtoupper($date);

              ?> HORA DE IMPRESIÓN: <?php echo date('h:i:s A'); ?>
      </th>
      <th width="10%">
      <img src="{{ url('/dist/img/logo2.jpg') }}"  width="60px" height="60px">
  	  </th>
    </tr>
  </thead>
</table>


<table class="table table-condensed table-striped table-bordered table-hover ">
  <thead>
    <tr class="info">
      <th scope="col" class="text-center" colspan="5" >1. INFORMACIÓN BÁSICA DEL NIÑO O LA NIÑA.</th>
    </tr>
    <tr class="info">
      <th scope="col" colspan="5">1.1. Datos personales</th>
    </tr>
  </thead>
  <tbody>
  	<tr>
      <td colspan="1" width="20%">
        	Nombre:  
    	</td>
    	<td colspan="3">
    		<b></b>
    	</td>
      <td colspan="1" rowspan="4" width="18%" width="120px" align="center" >
        
      </td>
    </tr>
  	<tr>
        <td colspan="1">
        	Dirección:  
    	</td>
    	<td colspan="3">
    		<b></b>
    	</td>
      
    </tr>
    <tr>
      <td colspan="1">
          Fecha nacimiento:  
      </td>
      <td colspan="1">
        <b><?php $originalDate = $nino->fec_nac;
            $newDate = date("d/m/Y", strtotime($originalDate));
            echo  $newDate;
            ?>
        </b>
      </td>
      <td colspan="1">
          Edad:  
      </td>
      <td colspan="1">
        

         <?php  $cumpleanos = new DateTime($nino->fec_nac);
              $hoy = new DateTime();
              $annos = $hoy->diff($cumpleanos);

              if($annos->y >= 1){
                  echo "$annos->y años y $annos->m meses ";
                  $meses=($annos->y*12)+$annos->m;
              }else{
                echo " $annos->m meses y $annos->d dias";
                  $meses=$annos->m;
              }
              
        ?>
      </td>

    </tr>

    <tr>
        <td colspan="2">
          Parientes con los que vive el niño o la niña:  
      </td>
      <td colspan="2">
        <b>@switch($nino->est_fam)
                          @case(1)
                              Vive solo con su madre
                              @break
                          @case(2)
                              Vive solo con su padre
                             @break
                          @case(3)
                              Vive con la madre y el padre
                             @break
                          @case(4)
                              Vive con sus familiares
                              @break
                      @endswitch</b>
      </td>
    </tr>
    <tr>
        <td colspan="2">
          Nombre de la persona que cuida el niño o la niña:  
      </td>
      <td colspan="3">
        <b>{{$nino->nom_cud}}</b>
      </td>
    </tr>
    
  </tbody>
 </table>

 <table class="table table-striped table-bordered table-hover table-condensed">
  <thead>
    <tr class="info">
      <th scope="col" colspan="4">1.2. Estado nutricional y de salud. </th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td colspan="1" width="20%">
          Presenta tarjeta de vacunación:  
      </td>
      <td colspan="1">
        <b>@switch($nino->tar_vac)
                          @case(1)
                              Si
                              @break
                          @case(2)
                              No
                             @break
                      @endswitch</b>
      </td>
      <td colspan="1">
         Presenta esquema de vacuna, según edad correspondiente:  
      </td>
      <td colspan="1">
       <b>@switch($nino->com_vac)
                          @case(1)
                              Si
                              @break
                          @case(2)
                              No
                             @break
                      @endswitch</b>
      </td>
    </tr>
    <tr>
        <td colspan="1">
          Estado nutricional actual:  
      </td>
      <td colspan="3">
        <b>{{$nino->desarrollo}}</b>
      </td>
    </tr>
    <tr>
      <td colspan="4" align="center">
          Discapacidades presentes en el niño o niña:  
      </td>
    </tr>
    <tr>
      <td width="25%">
        @if($discapacidades->baj_vis)
        <b><i class="fa fa-check-square-o" aria-hidden="true"></i>&nbsp;&nbsp;Baja vision</b>
        @else
        <b><i class="fa fa-window-close" aria-hidden="true"></i>&nbsp;&nbsp;Baja visión  </b>
        @endif
      </td>
      <td width="25%">
        @if($discapacidades->autismo)
        <b><i class="fa fa-check-square-o" aria-hidden="true"></i>&nbsp;&nbsp;Autismo</b>
        @else
        <b><i class="fa fa-window-close" aria-hidden="true"></i>&nbsp;&nbsp;Autismo</b>
        @endif
      </td>
      <td width="25%">
        @if($discapacidades->ceguera)
        <b><i class="fa fa-check-square-o" aria-hidden="true"></i>&nbsp;&nbsp;Ceguera</b>
        @else
        <b><i class="fa fa-window-close" aria-hidden="true"></i>&nbsp;&nbsp;Ceguera</b>
        @endif
      </td>
      <td width="25%">
        @if($discapacidades->miopia)
        <b><i class="fa fa-check-square-o" aria-hidden="true"></i>&nbsp;&nbsp;Miopía</b>
        @else
        <b><i class="fa fa-window-close" aria-hidden="true"></i>&nbsp;&nbsp;Miopía</b>
        @endif
      </td>
    </tr>
    <tr>
      <td width="25%">
        @if($discapacidades->sin_dow)
        <b><i class="fa fa-check-square-o" aria-hidden="true"></i>&nbsp;&nbsp;Síndrome de down</b>
        @else
        <b><i class="fa fa-window-close" aria-hidden="true"></i>&nbsp;&nbsp;Síndrome de down</b>
        @endif
      </td>
      <td width="25%">
        @if($discapacidades->sordera)
        <b><i class="fa fa-check-square-o" aria-hidden="true"></i>&nbsp;&nbsp;Sordera</b>
        @else
        <b><i class="fa fa-window-close" aria-hidden="true"></i>&nbsp;&nbsp;Sordera</b>
        @endif
      </td>
      <td width="25%">
        @if($discapacidades->aus_mie)
        <b><i class="fa fa-check-square-o" aria-hidden="true"></i>&nbsp;&nbsp;Ausencia de miembros</b>
        @else
        <b><i class="fa fa-window-close" aria-hidden="true"></i>&nbsp;&nbsp;Ausencia de miembros</b>
        @endif
      </td>
      <td width="25%">
        @if($discapacidades->baj_aud)
        <b><i class="fa fa-check-square-o" aria-hidden="true"></i>&nbsp;&nbsp;Baja audición</b>
        @else
        <b><i class="fa fa-window-close" aria-hidden="true"></i>&nbsp;&nbsp;Baja audición</b>
        @endif
      </td>
    </tr>
    <tr>
      <td width="25%">
        @if($discapacidades->ret_men)
        <b><i class="fa fa-check-square-o" aria-hidden="true"></i>&nbsp;&nbsp;Retardo mental</b>
        @else
        <b><i class="fa fa-window-close" aria-hidden="true"></i>&nbsp;&nbsp;Retardo mental</b>
        @endif
      </td>
      <td width="25%">
        @if($discapacidades->pro_mot)
        <b><i class="fa fa-check-square-o" aria-hidden="true"></i>&nbsp;&nbsp;Problema motores</b>
        @else
        <b><i class="fa fa-window-close" aria-hidden="true"></i>&nbsp;&nbsp;Problema motores</b>
        @endif
      </td>
      <td width="25%">
        @if($discapacidades->otro)
        <b><i class="fa fa-check-square-o" aria-hidden="true"></i>&nbsp;&nbsp;Otro</b>
        @else
        <b><i class="fa fa-window-close" aria-hidden="true"></i>&nbsp;&nbsp;Otro</b>
        @endif
      </td>
      <td width="25%">
        
      </td>
    </tr>
    <tr>
        <td colspan="2">
          Condición medica especial presente en el niño que deba asegurarse en el centro:  
      </td>
      <td colspan="2">
        <b>@switch($nino->con_esp)
                          @case(1)
                              Si
                              @break
                          @case(2)
                              No
                             @break
                      @endswitch</b>
      </td>
    </tr>
    @if($nino->con_esp == 1)
    <tr>
        <td colspan="2">
          Detalle de condición  medica especial:  
      </td>
      <td colspan="2">
        <b>{{$nino->det_con}}</b>
      </td>
    </tr>
    @endif
    
  </tbody>
 </table>

<table class="table table-striped table-bordered table-hover table-condensed">
  <thead>
    <tr class="info">
      <th scope="col" class="text-center" colspan="3" >2. HÁBITOS Y ALIMENTACIÓN.</th>
    </tr>
    <tr class="info">
      <th scope="col" colspan="3">2.1. Hábitos</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td colspan="1" width="30%">
          Horario de sueño por la noche:  
      </td>
      <td colspan="2">
        <b>{{$nino->s_noc}}</b>
      </td>
    </tr>
    <tr>
      <td colspan="1">
          Horario de sueño durante el día:  
      </td>
      <td colspan="2">
        <b>{{$nino->s_dia}}</b>
      </td>
    </tr>
    <tr>
        <td colspan="1">
          Presenta trastornos en el sueño:  
      </td>
      <td colspan="2">
        <b>@switch($nino->pro_dor)
                          @case(1)
                              Si
                              @break
                          @case(2)
                              No
                             @break
                      @endswitch</b>
      </td>
    </tr>
    @if($nino->con_esp == 1)
      <tr>
          <td colspan="1">
            Detalle de condición medica especial:  
        </td>
        <td colspan="2">
          <b>{{$nino->det_con}}</b>
        </td>
      </tr>
    @endif
    <tr>
      <td colspan="1">
          Persona o personas con las que duerme:  
      </td>
      <td colspan="2">
        <b>{{$nino->p_dorm}}</b>
      </td>
    </tr>
    
  </tbody>
 </table>

<table class="table table-condensed table-striped table-bordered table-hover ">
  <thead>
    <tr class="info">
      <th scope="col" colspan="5">2.2. Alimentación</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td colspan="2" width="25%">
          Es o fue alimentado con leche materna de forma exclusiva:  
      </td>
      <td colspan="1">
        <b>@switch($nino->lec_mat)
                          @case(1)
                              Si
                              @break
                          @case(2)
                              No
                             @break
                      @endswitch</b>
      </td>
      <td colspan="1">
          Cantidad de meses:  
      </td>
      <td colspan="1">
        <b>{{$nino->c_mat}}</b>
      </td>
    </tr>
    <tr>
        <td colspan="2">
          Presenta alguna dificultad o problema para alimentarse:  
      </td>
      <td colspan="3">
        <b>@switch($nino->alim)
                          @case(1)
                              Si
                              @break
                          @case(2)
                              No
                             @break
                      @endswitch</b>
      </td>
    </tr>
    @if($nino->alim == 1)
      <tr>
          <td colspan="1">
            Detalle de problema al alimentarse:  
        </td>
        <td colspan="4">
          <b>{{$nino->d_alim}}</b>
        </td>
      </tr>
    @endif
    <tr>
      <td colspan="5" align="center">
          Alimentos que consume:
      </td>
    </tr>
    <tr>
      <td width="20%">
        @if($alimentos->lacteos)
        <b><i class="fa fa-check-square-o" aria-hidden="true"></i>&nbsp;&nbsp;Lacteos</b>
        @else
        <b><i class="fa fa-window-close" aria-hidden="true"></i>&nbsp;&nbsp;Lacteos</b>
        @endif
      </td>
      <td width="20%">
        @if($alimentos->jugos)
        <b><i class="fa fa-check-square-o" aria-hidden="true"></i>&nbsp;&nbsp;Jugos</b>
        @else
        <b><i class="fa fa-window-close" aria-hidden="true"></i>&nbsp;&nbsp;Jugos</b>
        @endif
      </td>
      <td width="20%">
        @if($alimentos->pollo)
        <b><i class="fa fa-check-square-o" aria-hidden="true"></i>&nbsp;&nbsp;Pollo</b>
        @else
        <b><i class="fa fa-window-close" aria-hidden="true"></i>&nbsp;&nbsp;Pollo</b>
        @endif
      </td>
      <td width="20%">
        @if($alimentos->pescado)
        <b><i class="fa fa-check-square-o" aria-hidden="true"></i>&nbsp;&nbsp;Pescado</b>
        @else
        <b><i class="fa fa-window-close" aria-hidden="true"></i>&nbsp;&nbsp;Pescado</b>
        @endif
      </td>
      <td width="20%">
        @if($alimentos->verdura)
        <b><i class="fa fa-check-square-o" aria-hidden="true"></i>&nbsp;&nbsp;Verdura</b>
        @else
        <b><i class="fa fa-window-close" aria-hidden="true"></i>&nbsp;&nbsp;Verdura</b>
        @endif
      </td>
    </tr>
    <tr>
      <td width="20%">
        @if($alimentos->cereales)
        <b><i class="fa fa-check-square-o" aria-hidden="true"></i>&nbsp;&nbsp;Cereales</b>
        @else
        <b><i class="fa fa-window-close" aria-hidden="true"></i>&nbsp;&nbsp;Cereales</b>
        @endif
      </td>
      <td width="20%">
        @if($alimentos->frutas)
        <b><i class="fa fa-check-square-o" aria-hidden="true"></i>&nbsp;&nbsp;Frutas</b>
        @else
        <b><i class="fa fa-window-close" aria-hidden="true"></i>&nbsp;&nbsp;Frutas</b>
        @endif
      </td>
      <td width="20%">
        @if($alimentos->huevos)
        <b><i class="fa fa-check-square-o" aria-hidden="true"></i>&nbsp;&nbsp;Huevos</b>
        @else
        <b><i class="fa fa-window-close" aria-hidden="true"></i>&nbsp;&nbsp;Huevos</b>
        @endif
      </td>
      <td width="20%">
        @if($alimentos->legumbres)
        <b><i class="fa fa-check-square-o" aria-hidden="true"></i>&nbsp;&nbsp;Legumbres</b>
        @else
        <b><i class="fa fa-window-close" aria-hidden="true"></i>&nbsp;&nbsp;Legumbres</b>
        @endif
      </td>
      <td width="20%">
        @if($alimentos->otro)
        <b><i class="fa fa-check-square-o" aria-hidden="true"></i>&nbsp;&nbsp;Otro</b>
        @else
        <b><i class="fa fa-window-close" aria-hidden="true"></i>&nbsp;&nbsp;Otro</b>
        @endif
      </td>
    </tr>
    <tr>
      <td colspan="2">
          Veces que come durante el dia:
      </td>
      <td colspan="1">
        @if($nino->des)
        <b><i class="fa fa-check-square-o" aria-hidden="true"></i>&nbsp;&nbsp;Desayuno</b>
        @else
        <b><i class="fa fa-window-close" aria-hidden="true"></i>&nbsp;&nbsp;Desayuno</b>
        @endif
      </td>
      <td colspan="1">
        @if($nino->alm)
        <b><i class="fa fa-check-square-o" aria-hidden="true"></i>&nbsp;&nbsp;Almuerzo</b>
        @else
        <b><i class="fa fa-window-close" aria-hidden="true"></i>&nbsp;&nbsp;Almuerzo</b>
        @endif
      </td>
      <td colspan="1">
        @if($nino->cen)
        <b><i class="fa fa-check-square-o" aria-hidden="true"></i>&nbsp;&nbsp;Cena</b>
        @else
        <b><i class="fa fa-window-close" aria-hidden="true"></i>&nbsp;&nbsp;Cena</b>
        @endif
      </td>
    </tr>
    <tr>
      <td colspan="2">
        Cantidad de refrigerios que consume:
      </td>
      <td colspan="3">
        <b>{{$nino->c_ref}}</b>
      </td>
    </tr>
     <tr>
      <td colspan="2">
        Alimentos que prefiere:
      </td>
      <td colspan="3">
       <b> {{$nino->d_pref}}</b>
      </td>
    </tr>
    <tr>
      <td colspan="2">
        Alimentos que rechaza:
      </td>
      <td colspan="3">
        <b>{{$nino->d_rec}}</b>
      </td>
    </tr>
    <tr>
      <td colspan="1">
       Es alérgico a algún tipo de alimento:
      </td>
      <td colspan="1">
        <b>@switch($nino->alergico)
                          @case(1)
                              Si
                              @break
                          @case(2)
                              No
                             @break
                      @endswitch</b>
      </td>
      <td colspan="1">
       Detalle:
      </td>
      <td colspan="2">
       <b>{{$nino->d_aler}}</b>
      </td>
    </tr>
    <tr>
      <td colspan="1">
       Tratamiento médico actualmente:
      </td>
      <td colspan="1">
        <b>@switch($nino->tra_med)
                          @case(1)
                              Si
                              @break
                          @case(2)
                              No
                             @break
                      @endswitch</b>
      </td>
      <td colspan="1">
       Detalle:
      </td>
      <td colspan="2">
       <b>{{$nino->d_tra}}</b>
      </td>
    </tr>
  </tbody>
 </table>

<table class="table table-condensed table-striped table-bordered table-hover ">
  <thead>
    <tr class="info">
      <th scope="col" class="text-center" colspan="5" >3. DATOS FAMILIARES.</th>
    </tr>
    <tr class="info">
      <th scope="col" colspan="5">3.1. Información de los padres.</th>
    </tr>
  </thead>
  <tbody>
    @foreach($padres as $padre)
    <tr >
      <th scope="col" colspan="5" align="center">
        <b>@switch($padre->sexo_p)
                          @case(1)
                              Datos del padre
                              @break
                          @case(2)
                              Datos de la madre
                             @break
                      @endswitch</b></th>
    </tr>
    <tr>
      <td colspan="1" width="20%">
          Nombre:  
      </td>
      <td colspan="2">
        <b>{{$padre->nombres}}</b>
      </td>
      <td colspan="1">
          Fecha nacimiento:  
      </td>
      <td colspan="1">
        <b><?php $originalDate = $padre->fec_nac_p;
            $newDate = date("d/m/Y", strtotime($originalDate));
            echo  $newDate;
            ?></b>
      </td>
    </tr>
    <tr>
      <td colspan="1">
          DUI:  
      </td>
      <td colspan="2">
        <b>{{$padre->dui}}</b>
      </td>
      <td colspan="1">
          Teléfono:  
      </td>
      <td colspan="1">
        <b>{{$padre->tel_p}}</b>
      </td>
    </tr>
    <tr>
      <td colspan="1">
          Lugar de trabajo:  
      </td>
      <td colspan="2">
        <b>{{$padre->lugar_trab}}</b>
      </td>
      <td colspan="1">
          Edad:  
      </td>
      <td colspan="1">
        <?php  $cumpleanos = new DateTime($padre->fec_nac_p);
              $hoy = new DateTime();
              $annos = $hoy->diff($cumpleanos);
              echo $annos->y;
        ?>
      </td>
    </tr>
    <tr>
      <td colspan="1">
          Escolaridad:  
      </td>
      <td colspan="2">
        <b>{{$padre->escolaridad}}</b>
      </td>
      <td colspan="1">
          Profesión u oficio:  
      </td>
      <td colspan="1">
        <b>{{$padre->oficio}}</b>
      </td>
    </tr>
    @endforeach
  </tbody>
 </table> 

 <table class="table table-condensed table-striped table-bordered table-hover ">
  <thead>
    <tr class="info">
      <th scope="col" colspan="4">3.2. Otros miembros del grupo familiar con los que convive el niño o niña. </th>
    </tr>
  </thead>
  <tbody>
    @foreach($familiares as $familia)
    <tr class="success">
      <td colspan="1" width="20%">
          Nombre:  
      </td>
      <td colspan="3">
        <b>{{$familia->nom_pad}}</b>
      </td>
    </tr>
    <tr>
      <td colspan="1">
          Edad:  
      </td>
      <td colspan="1">
       <?php  $cumpleanos = new DateTime($familia->fec_nac_p);
              $hoy = new DateTime();
              $annos = $hoy->diff($cumpleanos);
              echo $annos->y;
        ?>
      </td>
      <td colspan="1">
          Sexo:  
      </td>
      <td colspan="1">
        <b>@switch($familia->sexo_p)
                          @case(1)
                              Hombre
                              @break
                          @case(2)
                              Mujer
                             @break
                      @endswitch</b>
      </td>
    </tr>
    <tr>
      <td colspan="1">
          Parentesco:  
      </td>
      <td colspan="1">
        <b>@switch($familia->parentesco)
                          @case(1)
                              Abuelo/as
                              @break
                          @case(2)
                              Tios/as
                             @break
                          @case(3)
                              Primo/a
                             @break
                          @case(4)
                              Hermano/a
                             @break
                          @case(5)
                              Otro
                             @break
                      @endswitch
        </b>
      </td>
      <td colspan="1">
          Escolaridad:  
      </td>
      <td colspan="1">
        <b>@switch($familia->for_aca)
                          @case(1)
                              Basica 1°-9°
                              @break
                          @case(2)
                              Media Bachillerato
                             @break
                          @case(3)
                              Superior Universitarios
                             @break
                      @endswitch
        </b>
      </td>
    </tr>
    <tr>
      <td colspan="1">
          Recibe atención educativa:  
      </td>
      <td colspan="1">
        <b>@switch($familia->ate_edu)
                          @case(1)
                              Si
                              @break
                          @case(2)
                              No
                             @break
                      @endswitch</b>
      </td>
      <td colspan="1">
         Detalle donde:  
      </td>
      <td colspan="1">
        <b>{{$familia->d_edu}}</b>
      </td>
    </tr>
    @endforeach
  </tbody>
 </table>

 <table class="table table-striped table-bordered table-hover table-condensed">
  <thead>
    <tr class="info">
      <th scope="col" class="text-center" colspan="4" >4. PARTICIPACIÓN Y COMPROMISOS DEL PADRE, MADRE O PERSONA ENCARGADA</th>
    </tr>
    <tr class="info">
      <th scope="col" colspan="4">4.1. En que actividades le gustaría apoyar en el círculo de familia: </th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td width="25%">
        @if($compromisos->educativas)
        <b><i class="fa fa-check-square-o" aria-hidden="true"></i>&nbsp;&nbsp;Educativas</b>
        @else
        <b><i class="fa fa-window-close" aria-hidden="true"></i>&nbsp;&nbsp;Educativas</b>
        @endif
      </td>
      <td width="25%">
        @if($compromisos->culturales)
        <b><i class="fa fa-check-square-o" aria-hidden="true"></i>&nbsp;&nbsp;Culturales</b>
        @else
        <b><i class="fa fa-window-close" aria-hidden="true"></i>&nbsp;&nbsp;Culturales</b>
        @endif
      </td>
      <td width="25%">
        @if($compromisos->recreativas)
        <b><i class="fa fa-check-square-o" aria-hidden="true"></i>&nbsp;&nbsp;Recreativas</b>
        @else
        <b><i class="fa fa-window-close" aria-hidden="true"></i>&nbsp;&nbsp;Recreativas</b>
        @endif
      </td>
      <td width="25%">
        @if($compromisos->deportivas)
        <b><i class="fa fa-check-square-o" aria-hidden="true"></i>&nbsp;&nbsp;Deportivas</b>
        @else
        <b><i class="fa fa-window-close" aria-hidden="true"></i>&nbsp;&nbsp;Deportivas</b>
        @endif
      </td>
    </tr>
    <tr>
      <td width="25%">
        @if($compromisos->salud)
        <b><i class="fa fa-check-square-o" aria-hidden="true"></i>&nbsp;&nbsp;Salud</b>
        @else
        <b><i class="fa fa-window-close" aria-hidden="true"></i>&nbsp;&nbsp;Salud</b>
        @endif
      </td>
      <td width="25%">
        @if($compromisos->higiene)
        <b><i class="fa fa-check-square-o" aria-hidden="true"></i>&nbsp;&nbsp;Higiene y ornato</b>
        @else
        <b><i class="fa fa-window-close" aria-hidden="true"></i>&nbsp;&nbsp;Higiene y ornato</b>
        @endif
      </td>
      <td width="25%">
        @if($compromisos->voluntario)
        <b><i class="fa fa-check-square-o" aria-hidden="true"></i>&nbsp;&nbsp;Voluntaria de cocina</b>
        @else
        <b><i class="fa fa-window-close" aria-hidden="true"></i>&nbsp;&nbsp;Voluntaria de cocina</b>
        @endif
      </td>
      <td width="25%">
        
      </td>
    </tr>
  </tbody>
 </table>

<br>
<br>
 <p align="justify">Así mismo AUTORIZO, la toma de fotografías de mi niño(a) para fines administrativos y de seguimiento a procesos de su aprendizaje y desarrollo.</p>

<p align="justify">De igual forma, AUTORIZO la toma de fotografías en el desarrollo de actividades propias del programa para validación y seguimiento a los procesos implicados en el desarrollo del “Modelo de Educación y Desarrollo Integral de Primera Infancia”, en conformidad y respeto a lo establecido en los artículos 46 y 47 de la Ley de Protección Integral de la Niñez y Adolescencia.</p>
<br>
<br>
<br>

<table  width="100%">
  <tbody align="center">
    <tr>
      <td>
        F. ________________________________
      </td>
      <td>
        F. ________________________________
      </td>
    </tr>
    <tr>
      <td>
        Asistente Técnico para la Primera Infancia.
      </td>
      <td>
        Padre, madre o encargado/a del niño o niña.
      </td>
    </tr>
  </tbody>
</table>

</body>

<script type="text/php">
    if (isset($pdf)) {
        $text = "Pagina {PAGE_NUM} / {PAGE_COUNT}";
        $size = 10;
        $font = $fontMetrics->getFont("Verdana");
        $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
        $x = ($pdf->get_width() - $width) / 2;
        $y = $pdf->get_height() - 35;
        $pdf->page_text($x, $y, $text, $font, $size);
    }
</script>

<!-- Bootstrap WYSIHTML5 -->
<script src="{{ asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
</html>