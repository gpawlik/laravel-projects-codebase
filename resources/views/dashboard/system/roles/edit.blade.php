@extends('dashboard.layout')

@section('content')

<div class = "well half">

  @include('errors.error_list')

  {!! Form::model($role, ['method' => 'PATCH','url' => ['system/roles',$role->id] ] ) !!}

    @include('dashboard.system.roles.partials._form',['submitButtonText'=>'Update','context'=>'update'])

  {!! Form::close() !!}

</div>

@endsection
