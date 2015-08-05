@extends('dashboard.layout')

@section('content')

  <div class = "card half">

    @include('errors.error_list')

    {!! Form::model($identification, ['method' => 'POST','url' => ['system/identification/update',$identification->id]] ) !!}

      @include('dashboard.system.identification.partials._form',['submitButtonText'=>'Update','roles'=>$identification,'context'=>'update'])

    {!! Form::close() !!}

  </div>

@endsection
