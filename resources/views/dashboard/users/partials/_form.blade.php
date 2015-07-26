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


  @if(isset($roles))
  <tr>
    <td>{!! Form::label("role_id","Role") !!}</td>

    @if(isset($affiliated_role))
    <td>
      {!! Form::select("role_id", array( $affiliated_role -> id => $affiliated_role -> role_name ) +  $roles, $affiliated_role, array('class' => 'select-input') ) !!}
    </td>
    @else
    <td>
      {!! Form::select("role_id", $roles,null,array('class' => 'select-input') ) !!}
    </td>
    @endif
  </tr>
  @endif

  <tr>
    <td colspan="2" align="right">{!! Form::submit($submitButtonText, array('class' => 'submit-button')) !!}</td>
  </tr>

</table>
