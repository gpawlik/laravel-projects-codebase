@extends('dashboard.layout')

@section('content')

<div class = "card half">

  @include('errors.error_list')

  {!! Form::open(['method' => 'POST','action' => 'CompanyController@save','files'=>true ] ) !!}

    <table class = "form-element full">

      <tr>
        <td>{!! Form::label("company_name","Company Name") !!}</td>
        @if(isset($companyDetails))
          <td>{!! Form::text("company_name", $companyDetails -> company_name , ['placeholder' => 'Company Name','class'=>'text-input']) !!}</td>
        @else
          <td>{!! Form::text("company_name", null , ['placeholder' => 'Company Name','class'=>'text-input']) !!}</td>
        @endif
      </tr>

      <tr>
        <td>{!! Form::label("company_description","Company Description") !!}</td>
        @if(isset($companyDetails))
          <td>{!! Form::textarea("company_description", $companyDetails -> company_description , ['placeholder' => 'Company Description','class'=>'text-input']) !!}</td>
        @else
            <td>{!! Form::textarea("company_description", null , ['placeholder' => 'Company Description','class'=>'text-input']) !!}</td>
        @endif
      </tr>

      <tr>
        <td>{!! Form::label("company_logo_name","Company Logo") !!}</td>
        <td>
          {!! Form::file("company_logo_name") !!}
          @if(isset($companyDetails->company_logo_name))
            <div id = "small-image">
              <img src = "/uploads/{{$companyDetails->company_logo_name}}" />
            </div>
            <input type = "checkbox" name = "clear_check" value = "checked" /> Clear Image (<span class = "small-text">Check to delete image</span>)
          @endif
        </td>
      </tr>

      <tr>
        <td colspan="2" align="right">{!! Form::submit("Save", array('class' => 'submit-button')) !!}</td>
      </tr>

    </table>

    {!! Form::close() !!}

  </div>


@endsection
