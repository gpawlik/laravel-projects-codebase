<table class = "form-element full">

  <tr>
    <td>{!! Form::label("role_name","Role Name") !!}</td>
    <td>{!! Form::text("role_name", null , ['placeholder' => 'Role Name','class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td colspan="2" align="right">{!! Form::submit($submitButtonText, array('class' => 'submit-button')) !!}</td>
  </tr>

</table>
