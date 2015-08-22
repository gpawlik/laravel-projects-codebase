<table class = "form-element full">

  <tr>
    <td>{!! Form::label("job_title","Job Title*") !!}</td>
    <td>{!! Form::text("job_title", null , ['placeholder' => 'Job Title','class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td>{!! Form::label("job_capacity","Job Capacity*") !!}</td>
    <td>{!! Form::text("job_capacity", null , ['placeholder' => 'Job Capacity','class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td>{!! Form::label("job_description","Job Description") !!}</td>
    <td>{!! Form::textarea("job_description", null , ['placeholder' => 'Job Description','class'=>'text-input']) !!}</td>
  </tr>

  @if(isset($context))

    @if($context == 'add')
      <tr>
        <td>{!! Form::label("job_specifications_file_name","Upload Job Specification File") !!}</td>
        <td>{!! Form::file("job_specifications_file_name", array('class' => 'form_container_input')) !!}</td>
      </tr>
    @elseif($context == 'update')
      <tr>
        <td>{!! Form::label("job_specifications_file_name","Upload Job Specification File") !!}</td>
        <td class = "grey-back">
          @if(isset($job -> job_specifications_file_name))
            <div>File : {{ $job -> job_specifications_file_name }} </div><br/>
            <input type = "checkbox" name = "job_specs_delete_check" value = "yes" /> Delete File (<span class = "small-text">Check to delete file</span>)
            <br/><br/>
          @endif
          {!! Form::file("job_specifications_file_name", array('class' => 'form_container_input')) !!}
        </td>
      </tr>
    @endif
  @endif

  @if(isset($departments))
  <tr>
    <td>{!! Form::label("department","Department*") !!}</td>

    @if(isset($jobs_department))
    <td>
      {!! Form::select("department", array( $jobs_department -> id => $jobs_department -> department_name ) +  $departments, $jobs_department, array('class' => 'select-input') ) !!}
    </td>
    @else
    <td>
      {!! Form::select("department", $departments,null,array('class' => 'select-input') ) !!}
    </td>
    @endif
  </tr>
  @endif

  <tr>
    <td colspan="2" align="right">{!! Form::submit($submitButtonText, array('class' => 'submit-button')) !!}</td>
  </tr>

</table>
