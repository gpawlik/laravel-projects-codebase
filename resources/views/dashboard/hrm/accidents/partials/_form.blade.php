<table class = "form-element full">

  <tr>
    <td>{!! Form::label("employee","Employee*") !!}</td>
    <td>
      {!! Form::text('employee', $employee_name,

        ['class'=>'text-input','id'=>'employee-field','autocomplete'=>'off','placeholder'=>'Search Employee First / Last Name'])

      !!}
      <div id = "employee-list">

      </div>
    </td>
  </tr>

  <tr>
    <td>{!! Form::label("accident_date","Date of Accident*") !!}</td>
    <td>{!! Form::input("date", 'accident_date', null , ['class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td>{!! Form::label("accident_time","Time of Accident*") !!}</td>
    <td>{!! Form::text("accident_time", null , ['placeholder' => 'Time of Accident','class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td>{!! Form::label("accident_report_date","Accident Report Date") !!}</td>
    <td>{!! Form::input("date", 'accident_report_date', null , ['class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td>{!! Form::label("accident_report_time","Accident Report Time*") !!}</td>
    <td>{!! Form::text("accident_report_time", null , ['placeholder' => 'Accident Report Time','class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td>{!! Form::label("accident_description","Accident Description") !!}</td>
    <td>{!! Form::textarea("accident_description", null , ['placeholder' => 'Accident Description','class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td>{!! Form::label("accident_location","Accident Location") !!}</td>
    <td>{!! Form::textarea("accident_location", null , ['placeholder' => 'Accident Location ','class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td>{!! Form::label("witness_1_name","Name of Witness #1") !!}</td>
    <td>{!! Form::text("witness_1_name", null , ['placeholder' => 'Name of Witness #1','class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td>{!! Form::label("witness_2_name","Name of Witness #2") !!}</td>
    <td>{!! Form::text("witness_2_name", null , ['placeholder' => 'Name of Witness #2','class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td>{!! Form::label("injury_type","Injury Type") !!}</td>
    @if(isset($injury_type))
      <td>{!! Form::select("injury_type", ['WORK RELATED'=>'Work Related','NON WORK RELATED'=>'Non Work Related'], $injury_type, array('class' => 'select-input') ) !!}</td>
    @else
      <td>{!! Form::select("injury_type", ['WORK RELATED'=>'Work Related','NON WORK RELATED'=>'Non Work Related'], null, array('class' => 'select-input') ) !!}</td>
    @endif
  </tr>

  <tr>
    <td>{!! Form::label("supervisor","Supervisor / HOD / Manager*") !!}</td>
    <td>
      {!! Form::text('supervisor', $supervisor_name,

        ['class'=>'text-input','id'=>'employee-field','autocomplete'=>'off','placeholder'=>'Search Supervisor First / Last Name'])

      !!}
      <div id = "employee-list">

      </div>
    </td>
  </tr>




  <tr>
    <td colspan="2" align="right">{!! Form::submit($submitButtonText, array('class' => 'submit-button')) !!}</td>
  </tr>

</table>
