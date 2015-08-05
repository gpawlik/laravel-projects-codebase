<table class = "form-element full">

  <tr>
    <td>{!! Form::label("bank_name","Bank Name") !!}</td>
    <td>{!! Form::text("bank_name", null , ['placeholder' => 'Bank Name','class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td>{!! Form::label("bank_swift_code","Bank Swift Code") !!}</td>
    <td>{!! Form::text("bank_swift_code", null , ['placeholder' => 'Bank Swift Code','class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td colspan="2" align="right">{!! Form::submit($submitButtonText, array('class' => 'submit-button')) !!}</td>
  </tr>

</table>
