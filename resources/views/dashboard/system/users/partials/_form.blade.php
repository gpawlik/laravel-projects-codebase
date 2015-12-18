<table class = "form-element full">

  <tr>
    <td>{!! Form::label("first_name","First Name") !!}</td>
    <td>
        {!! Form::text("first_name", null , ['placeholder' => 'First Name','class'=>'form-control']) !!}
    </td>
  </tr>

  <tr>
    <td>{!! Form::label("last_name","Last Name") !!}</td>
    <td>
        {!! Form::text("last_name", null , ['placeholder' => 'Last Name','class'=>'form-control']) !!}
    </td>
  </tr>

  <tr>
    <td>{!! Form::label("username","Username") !!}</td>
    <td>
        {!! Form::text("username", null , ['placeholder' => 'Username','class'=>'form-control']) !!}
    </td>
  </tr>

  <tr>
    <td>{!! Form::label("email","Email") !!}</td>
    <td>
        {!! Form::text("email", null , ['placeholder' => 'Email','class'=>'form-control']) !!}
    </td>
  </tr>

  @if(isset($context))
    @if($context == 'add')
    <tr>
      <td>{!! Form::label("image_name","Image (optional)") !!}</td>
      <td>{!! Form::file("image_name") !!}</td>
    </tr>
    @endif

    @if($context == 'update')
      <tr>
        <td>{!! Form::label("image_name","Image (optional)") !!}</td>
        <td>
          {!! Form::file("image_name",['class' => 'btn btn-default btn-file']) !!}
          @if(isset($user->image_name))
            <div id = "small-image">
              <img src = "/uploads/{{$user->image_name}}" />
            </div>
            <input type = "checkbox" name = "clear_check" value = "yes" /> Clear Image (<span class = "small-text">Check to delete image</span>)
          @endif
        </td>
      </tr>
    @endif
  @endif

  @if(isset($roles))
    <tr>
      <td>{!! Form::label("role_id","Role") !!}</td>

      @if(isset($users_role))
      <td>
          {!! Form::select("role_id", array( $users_role -> id => $users_role -> role_name ) +  $roles, $users_role, array('class' => 'form-control') ) !!}
      </td>
      @else
      <td>
        
          {!! Form::select("role_id", $roles,null,array('class' => 'form-control') ) !!}

      </td>
      @endif
    </tr>
  @endif

  <tr>
    <td colspan="2" align="right">{!! Form::submit($submitButtonText, array('class' => 'btn btn-primary')) !!}</td>
  </tr>

</table>
