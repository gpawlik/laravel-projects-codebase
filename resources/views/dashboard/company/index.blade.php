@extends('dashboard.layout')

@section('content')

<div class = "card half">

  @include('errors.error_list')

  {!! Form::open(['method' => 'POST','action' => 'RoleController@create'] ) !!}

    <table class = "form-element full">

      <tr>
        <td>{!! Form::label("company_name","Company Name") !!}</td>
        <td>{!! Form::text("company_name", null , ['placeholder' => 'Company Name','class'=>'text-input']) !!}</td>
      </tr>

      <tr>
        <td>{!! Form::label("company_description","Company Description") !!}</td>
        <td>{!! Form::textarea("company_description", null , ['placeholder' => 'Company Description','class'=>'text-input']) !!}</td>
      </tr>

      <tr>
        <td>{!! Form::label("company_logo_name","Company Logo") !!}</td>
        <td>
          {!! Form::file("company_logo_name") !!}
          @if(isset($company->company_logo_name))
            <div id = "small-image">
              <img src = "/uploads/{{$company->company_logo_name}}" />
            </div>
            <input type = "checkbox" name = "clear_check" value = "yes" /> Clear Image (<span class = "small-text">Check to delete image</span>)
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
