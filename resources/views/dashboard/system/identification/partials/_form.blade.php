<table class = "form-element full">

  <tr>
    <td>{!! Form::label("identification_name","Identification Name") !!}</td>
    <td>{!! Form::text("identification_name", null , ['placeholder' => 'Identification Name','class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td colspan="2" align="right">{!! Form::submit($submitButtonText, array('class' => 'submit-button')) !!}</td>
  </tr>

</table>
