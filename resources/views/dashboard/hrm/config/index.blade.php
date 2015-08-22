@extends('dashboard.layout')

@section('content')

<div class = "card half">

  @include('errors.error_list')

  {!! Form::open(['method' => 'POST','action' => 'ConfigController@save'] ) !!}

    <table class = "form-element full">

      <tr>
        <td>{!! Form::label("ssnit_percentage","Percentage of SSNIT*") !!}</td>
        @if(isset($configDetails))
          <td>{!! Form::text("ssnit_percentage", $configDetails -> ssnit_percentage , ['placeholder' => '%','class'=>'text-input']) !!}</td>
        @else
          <td>{!! Form::text("ssnit_percentage", null , ['placeholder' => '%','class'=>'text-input']) !!}</td>
        @endif
      </tr>

      <tr>
        <td>{!! Form::label("employer_welfare_contribution","Company's Welfare Contribution (Amount)*") !!}</td>
        @if(isset($configDetails))
          <td>{!! Form::text("employer_welfare_contribution", $configDetails -> employer_welfare_contribution , ['placeholder' => 'GHC','class'=>'text-input']) !!}</td>
        @else
            <td>{!! Form::text("employer_welfare_contribution", null , ['placeholder' => 'GHC','class'=>'text-input']) !!}</td>
        @endif
      </tr>


      <tr>
        <td>{!! Form::label("employee_leave_entitlement","Leave Days Entitlement (Number of Days)*") !!}</td>
        @if(isset($configDetails))
          <td>{!! Form::text("employee_leave_entitlement", $configDetails -> employee_leave_entitlement , ['placeholder' => 'Days','class'=>'text-input']) !!}</td>
        @else
            <td>{!! Form::text("employee_leave_entitlement", null , ['placeholder' => 'Days','class'=>'text-input']) !!}</td>
        @endif
      </tr>


      <tr>
        <td colspan="2" align="right">{!! Form::submit("Save", array('class' => 'submit-button')) !!}</td>
      </tr>

    </table>

    {!! Form::close() !!}

  </div>


@endsection
