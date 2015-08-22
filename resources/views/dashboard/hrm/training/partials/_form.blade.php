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
    <td>{!! Form::label("training_start_date","Training Start Date*") !!}</td>
    <td>{!! Form::input("date", 'training_start_date', null , ['class'=>'text-input']) !!}</td>
  </tr>


    <tr>
      <td>{!! Form::label("training_end_date","Training End Date*") !!}</td>
      <td>{!! Form::input("date", 'training_end_date', null , ['class'=>'text-input']) !!}</td>
    </tr>

    <tr>
      <td>{!! Form::label("training_type","Type of Training*") !!}</td>
      <td>{!! Form::select("training_type", ['INTERNAL'=>'Internal','EXTERNAL'=>'External'], $training_type , array('class' => 'select-input') ) !!}</td>
    </tr>

    <tr>
      <td>{!! Form::label("training_total_cost","Training Cost*") !!}</td>
      <td>{!! Form::text("training_total_cost", null , ['placeholder' => 'Training Cost','class'=>'text-input']) !!}</td>
    </tr>

    <tr>
      <td>{!! Form::label("training_cost_components","Training Cost Components*") !!}</td>
      <td>{!! Form::textarea("training_cost_components", null , ['placeholder' => 'Training Cost Components','class'=>'text-input']) !!}</td>
    </tr>

    <tr>
      <td>{!! Form::label("training_facilitator","Training Facilitator") !!}</td>
      <td>{!! Form::text("training_facilitator", null , ['placeholder' => 'Training Facilitator','class'=>'text-input']) !!}</td>
    </tr>

    <tr>
      <td>{!! Form::label("training_topic","Training Topic") !!}</td>
      <td>{!! Form::text("training_topic", null , ['placeholder' => 'Training Topic','class'=>'text-input']) !!}</td>
    </tr>

    <tr>
      <td>{!! Form::label("training_location","Training Location") !!}</td>
      <td>{!! Form::text("training_location", null , ['placeholder' => 'Training Location','class'=>'text-input']) !!}</td>
    </tr>

  <tr>
    <td colspan="2" align="right">{!! Form::submit($submitButtonText, array('class' => 'submit-button')) !!}</td>
  </tr>

</table>
