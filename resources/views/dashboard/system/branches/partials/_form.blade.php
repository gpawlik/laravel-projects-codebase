<table class = "form-element full">

  <tr>
    <td>{!! Form::label("branch_name","Branch Name*") !!}</td>
    <td>{!! Form::text("branch_name", null , ['placeholder' => 'Branch Name','class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td>{!! Form::label("branch_location","Branch Location") !!}</td>
    <td>{!! Form::text("branch_location", null , ['placeholder' => 'Branch Location','class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td colspan="2" align="right">{!! Form::submit($submitButtonText, array('class' => 'submit-button')) !!}</td>
  </tr>

</table>
