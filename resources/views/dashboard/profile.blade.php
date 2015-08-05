@extends('dashboard.layout')

@section('content')

<div class = "card half">

  @include('errors.error_list')

  {!! Form::model($user, ['method' => 'POST','url' => ['dashboard/profile/save'], 'files'=>true ] ) !!}

    <table class = "form-element full">

      <tr>
        <td>{!! Form::label("first_name","First Name") !!}</td>
        <td>{!! Form::text("first_name", null , ['placeholder' => 'First Name','class'=>'text-input']) !!}</td>
      </tr>

      <tr>
        <td>{!! Form::label("last_name","Last Name") !!}</td>
        <td>{!! Form::text("last_name", null , ['placeholder' => 'Last Name','class'=>'text-input']) !!}</td>
      </tr>

      <tr>
        <td>{!! Form::label("username","Username") !!}</td>
        <td>{!! Form::text("username", null , ['placeholder' => 'Username','class'=>'text-input']) !!}</td>
      </tr>

      <tr>
        <td>{!! Form::label("email","Email") !!}</td>
        <td>{!! Form::text("email", null , ['placeholder' => 'Email','class'=>'text-input']) !!}</td>
      </tr>

      <tr>
        <td>{!! Form::label("password","Password") !!}</td>
        <td>
          {!! Form::password("password", ['placeholder' => 'Password','class'=>'text-input']) !!}
            <span class = "red-note">Leave password fields blank if you do not wish to update it</span>
        </td>
      </tr>

      <tr>
        <td>{!! Form::label("confirm_password","Confirm Password") !!}</td>
        <td>{!! Form::password("confirm_password", ['placeholder' => 'Confirm Password','class'=>'text-input']) !!}</td>
      </tr>

      <tr>
        <td>{!! Form::label("image_name","Image (optional)") !!}</td>
        <td>
          {!! Form::file("image_name") !!}
          @if(isset($user->image_name))
            <div id = "small-image">
              <img src = "/uploads/{{$user->image_name}}" />
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
