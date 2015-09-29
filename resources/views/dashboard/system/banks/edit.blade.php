@extends('dashboard.layout')

@section('content')

  <div class = "card half">

    @include('errors.error_list')

    {!! Form::model($bank, ['method' => 'PATCH','url' => ['system/banks',$bank->id]] ) !!}

      @include('dashboard.system.banks.partials._form',['submitButtonText'=>'Update','roles'=>$bank,'context'=>'update'])

    {!! Form::close() !!}

  </div>

@endsection
