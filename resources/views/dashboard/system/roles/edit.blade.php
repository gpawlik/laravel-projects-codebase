@extends('dashboard.layout')

@section('content')

<div class = "card half">

  @include('errors.error_list')

  {!! Form::model($role, ['method' => 'POST','url' => ['system/roles/update',$role->id] ] ) !!}

    @include('dashboard.system.roles.partials._form',['submitButtonText'=>'Update','context'=>'update'])

  {!! Form::close() !!}

</div>

@endsection
