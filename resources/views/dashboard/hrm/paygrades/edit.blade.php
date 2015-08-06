@extends('dashboard.layout')

@section('content')

  <div class = "card half">

    @include('errors.error_list')

    {!! Form::model($payGrade, ['method' => 'POST','url' => ['hrm/pay_grades/update',$payGrade->id], 'files'=>true ] ) !!}

      @include('dashboard.hrm.paygrades.partials._form',['submitButtonText'=>'Update','jobs'=>$jobs,'context'=>'update'])

    {!! Form::close() !!}

  </div>

@endsection
