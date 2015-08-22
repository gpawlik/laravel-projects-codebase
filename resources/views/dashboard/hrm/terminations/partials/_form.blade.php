<table class = "form-element full">

  <tr>
    <td>{!! Form::label("employee","Employee*") !!}</td>
    <td>
      {!! Form::text('employee', null,

        ['class'=>'text-input','id'=>'employee-field','autocomplete'=>'off','placeholder'=>'Search Employee First / Last Name'])

      !!}
      <div id = "employee-list">

      </div>
    </td>
  </tr>

  <tr>
    <td>{!! Form::label("date_of_termination","Date of Termination*") !!}</td>
    <td>{!! Form::input("date", 'date_of_termination', null , ['class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td>{!! Form::label("reason_for_termination","Reason for Termination*") !!}</td>
    <td>{!! Form::select("reason_for_termination", ['TERMINATION'=>'Job Termination','CONTRACT ENDED'=>'Contract Ended','RESIGNATION'=>'Resignation'], null, array('class' => 'select-input') ) !!}</td>
  </tr>


    <tr>
      <td>{!! Form::label("details_of_termination","Job Termination Details") !!}</td>
      <td>{!! Form::textarea("details_of_termination", null , ['placeholder' => 'Job Termination Details','class'=>'text-input']) !!}</td>
    </tr>

    <tr>
      <td>{!! Form::label("resignation_list","Resignation List") !!}</td>
      <td>{!! Form::textarea("resignation_list", null , ['placeholder' => 'Resignation List','class'=>'text-input']) !!}</td>
    </tr>

  <tr>
    <td colspan="2" align="right">{!! Form::submit($submitButtonText, array('class' => 'submit-button')) !!}</td>
  </tr>

</table>
