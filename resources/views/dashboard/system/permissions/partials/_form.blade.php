<table class = "form-element full">

  <tr>
    <td>{!! Form::label("permission_name","Permission Name") !!}</td>
    <td>{!! Form::text("permission_name", null , ['placeholder' => 'Permission Name','class'=>'text-input']) !!}</td>
  </tr>

  @if(isset($roles))
  <tr>
    <td>{!! Form::label("role_id","Role") !!}</td>

    @if(isset($permissions_role))
    <td>
      {!! Form::select("role_id", array( $permissions_role -> id => $permissions_role -> role_name ) +  $roles, $permissions_role, array('class' => 'select-input') ) !!}
    </td>
    @else
    <td>
      {!! Form::select("role_id", $roles,null,array('class' => 'select-input') ) !!}
    </td>
    @endif
  </tr>
  @endif

  <tr>
    <td colspan="2" align="right">{!! Form::submit($submitButtonText, array('class' => 'btn btn-primary')) !!}</td>
  </tr>

</table>
