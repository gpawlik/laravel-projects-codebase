<table class = "form-element full">

  <tr>
    <td>{!! Form::label("note","Note*") !!}</td>
    <td>{!! Form::textarea("note", null , ['placeholder' => 'Note','class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td>{!! Form::label("description","Description") !!}</td>
    <td>{!! Form::textarea("description", null , ['placeholder' => 'Description','class'=>'text-input']) !!}</td>
  </tr>


  <tr>
    <td>{!! Form::label("due_date","Due Date*") !!}</td>
    <td>{!! Form::input("date", 'due_date', null , ['class'=>'text-input']) !!}</td>
  </tr>


    <tr>
      <td colspan="2" align="right">{!! Form::submit($submitButtonText, array('class' => 'submit-button')) !!}</td>
    </tr>

</table>
