@extends('dashboard.layout')

@section('content')

<div class = "card half">

  @include('errors.error_list')

  {!! Form::open(['method' => 'POST','action' => 'CompanyController@save','files'=>true ] ) !!}

    <table class = "form-element full">

      <tr>
        <td>{!! Form::label("company_name","Company Name") !!}</td>
        @if(isset($companyDetails))
          <td>
              {!! Form::text("company_name", $companyDetails -> company_name , ['placeholder' => 'Company Name','class'=>'form-control']) !!}
          </td>
        @else
          <td>
            {!! Form::text("company_name", null , ['placeholder' => 'Company Name','class'=>'form-control']) !!}
          </td>
        @endif
      </tr>

      <tr>
        <td>{!! Form::label("company_description","Company Description") !!}</td>
        @if(isset($companyDetails))
          <td>
            {!! Form::textarea("company_description", $companyDetails -> company_description , ['placeholder' => 'Company Description','class'=>'form-control']) !!}
          </td>
        @else
            <td>
              {!! Form::textarea("company_description", null , ['placeholder' => 'Company Description','class'=>'form-control']) !!}
          </td>
        @endif
      </tr>

      <tr>
        <td>{!! Form::label("company_address","Company Address") !!}</td>
        @if(isset($companyDetails))
          <td>
            {!! Form::textarea("company_address", $companyDetails -> company_address , ['placeholder' => 'Company Address','class'=>'form-control']) !!}
          </td>
        @else
          <td>
            {!! Form::textarea("company_address", null , ['placeholder' => 'Company Address','class'=>'form-control']) !!}
          </td>
        @endif
      </tr>

      <tr>
        <td>{!! Form::label("company_telephone","Company Telephone") !!}</td>
        @if(isset($companyDetails))
          <td>
            {!! Form::text("company_telephone", $companyDetails -> company_telephone , ['placeholder' => 'Company Telephone','class'=>'form-control']) !!}
          </td>
        @else
          <td>
            {!! Form::text("company_telephone", null , ['placeholder' => 'Company Telephone','class'=>'form-control']) !!}
          </td>
        @endif
      </tr>

      <tr>
        <td>{!! Form::label("company_tin_number","Company Tin Number") !!}</td>
        @if(isset($companyDetails))
          <td>
            {!! Form::text("company_tin_number", $companyDetails -> company_tin_number , ['placeholder' => 'Company Tin Number','class'=>'form-control']) !!}
          </td>
        @else
          <td>
            {!! Form::text("company_tin_number", null , ['placeholder' => 'Company Tin Number','class'=>'form-control']) !!}
          </td>
        @endif
      </tr>

      <tr>
        <td>{!! Form::label("company_ssnit_number","Company SSNIT Number") !!}</td>
        @if(isset($companyDetails))
          <td>
            {!! Form::text("company_ssnit_number", $companyDetails -> company_ssnit_number , ['placeholder' => 'Company SSNIT Number','class'=>'form-control']) !!}
          </td>
        @else
          <td>
            {!! Form::text("company_ssnit_number", null , ['placeholder' => 'Company SSNIT Number','class'=>'form-control']) !!}
          </td>
        @endif
      </tr>

      <tr>
        <td>{!! Form::label("company_email","Company Email") !!}</td>
        @if(isset($companyDetails))
          <td>
            {!! Form::text("company_email", $companyDetails -> company_email , ['placeholder' => 'Company Email','class'=>'form-control']) !!}
          </td>
        @else
          <td>
            {!! Form::text("company_email", null , ['placeholder' => 'Company Email','class'=>'form-control']) !!}
          </td>
        @endif
      </tr>

      <tr>
        <td>{!! Form::label("company_website","Company Website") !!}</td>
        @if(isset($companyDetails))
          <td>
            {!! Form::text("company_website", $companyDetails -> company_website , ['placeholder' => 'Company Website','class'=>'form-control']) !!}
          </td>
        @else
          <td>
            {!! Form::text("company_website", null , ['placeholder' => 'Company Website','class'=>'form-control']) !!}
          </td>
        @endif
      </tr>

      <tr>
        <td>{!! Form::label("company_logo_name","Company Logo") !!}</td>
        <td>
          {!! Form::file("company_logo_name",['class' => 'btn btn-default btn-file']) !!}
          @if(isset($companyDetails->company_logo_name))
            <div id = "small-image">
              <img src = "/uploads/{{$companyDetails->company_logo_name}}" />
            </div>
            <input type = "checkbox" name = "clear_check" value = "checked" /> Clear Image (<span class = "small-text">Check to delete image</span>)
          @endif
        </td>
      </tr>

      <tr>
        <td colspan="2" align="right">{!! Form::submit("Save", array('class' => 'btn btn-primary')) !!}</td>
      </tr>

    </table>

    {!! Form::close() !!}

  </div>


@endsection
