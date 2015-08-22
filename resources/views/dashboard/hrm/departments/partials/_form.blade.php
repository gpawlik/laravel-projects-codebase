<table class = "form-element full">

  <tr>
    <td>{!! Form::label("department_name","Department Name*") !!}</td>
    <td>{!! Form::text("department_name", null , ['placeholder' => 'Department Name','class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td colspan="2" align="right">{!! Form::submit($submitButtonText, array('class' => 'submit-button')) !!}</td>
  </tr>

</table>
