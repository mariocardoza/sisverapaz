
@section('migasdepan')
    <h1>
        Pagina principal
        <small>Control panel Tesorería</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li class="active">Pagina principal</li>
    </ol>

@endsection
@section('content')
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{\App\Requisicione::where('user_id',Auth()->user()->id)->where('created_at','<=',date('Y'.'-12-31'))->count()}}</h3>
              <p>Mis requisicion en el año {{date('Y')}}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="{{url('requisiciones/porusuario')}}" class="small-box-footer">Ver todas <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                <h3>{{\App\Cuenta::where('estado',1)->whereYear('created_at',date("Y"))->count()}}<sup style="font-size: 20px"></sup></h3>

                    <p>Cuentas</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{url('cuentas')}}" class="small-box-footer">Ver <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{cantcontri()}}</h3>

                    <p>Contribuyentes Registrados</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="{{ url('/contribuyentes') }}" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3><i class="fa fa-user"></i></h3>

                    <p>Solicitud extraordinaria</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="javascript:void(0)" id="form_autorizacion" class="small-box-footer">Aceptar <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>
    <!-- /.row -->
@endsection
