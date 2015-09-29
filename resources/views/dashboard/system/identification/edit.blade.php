@extends('dashboard.layout')

@section('content')

  <div class = "card half">

    @include('errors.error_list')

    {!! Form::model($identification, ['method' => 'PATCH','url' => ['system/identification',$identification->id]] ) !!}

      @include('dashboard.system.identification.partials._form',['submitButtonText'=>'Update','roles'=>$identification,'context'=>'update'])

    {!! Form::close() !!}

  </div>

@endsection
