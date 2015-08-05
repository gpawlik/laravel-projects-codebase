@extends('dashboard.layout')

@section('content')

  <div class = "card half">

    @include('errors.error_list')

    {!! Form::model($bank, ['method' => 'POST','url' => ['system/banks/update',$bank->id]] ) !!}

      @include('dashboard.system.banks.partials._form',['submitButtonText'=>'Update','roles'=>$bank,'context'=>'update'])

    {!! Form::close() !!}

  </div>

@endsection
