@extends('layouts.app')

@section('migasdepan')
<h1>
	Planillas
</h1>
<ol class="breadcrumb">
	<li><a href="{{ url('/planillas') }}"><i class="fa fa-dashboard"></i>Control de planillas</a></li>
	<li class="active">Planillas</li> </ol>
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10" >
            <table class="table table-striped table-bordered table-hover" >
                <thead>
                    <th>Empleado</th>
                    <th>Salario base</th>
                    <th>ISSS Empleado</th>
                    <th>ISSS Patronal</th>
                    <th>AFP Empleado</th>
                    <th>AFP Patronal</th>
                    <th>INSAFORP Patronal</th>
                    <th>Renta</th>
                    <th>Crédito</th>
                    <th>Total deducciones</th>
                    <th>Salario líquido</th>
                </thead>
                <tbody>
                    @foreach($planillas as $planilla)
                    <tr>
                    <td>{{$planilla->empleado->nombre}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
		</div>
	</div>
</div>
@endsection