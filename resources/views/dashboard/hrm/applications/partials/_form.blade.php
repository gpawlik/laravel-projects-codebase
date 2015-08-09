<table class = "form-element full">

  <tr>
    <td>{!! Form::label("applicant_first_name","Applicant's First Name*") !!}</td>
    <td>{!! Form::text("applicant_first_name", null , ['placeholder' => 'Applicant\'s First Name','class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td>{!! Form::label("applicant_last_name","Applicant's Last Name*") !!}</td>
    <td>{!! Form::text("applicant_last_name", null , ['placeholder' => 'Applicant\'s Last Name','class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td>{!! Form::label("applicant_email","Applicant's Email*") !!}</td>
    <td>{!! Form::text("applicant_email", null , ['placeholder' => 'Applicant\'s Email','class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td>{!! Form::label("applicant_contact_number","Applicant's Contact Number*") !!}</td>
    <td>{!! Form::text("applicant_contact_number", null , ['placeholder' => 'Applicant\'s Contact Number','class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td>{!! Form::label("application_date","Date of Application*") !!}</td>
    <td>{!! Form::input("date", 'application_date', null , ['class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td>{!! Form::label("applicant_interview_date","Applicant Interview Date") !!}</td>
    <td>{!! Form::input("date", 'applicant_interview_date', null , ['class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td>{!! Form::label("applicant_cv_file_name","Upload Applicant's CV") !!}</td>
    <td>{!! Form::file("applicant_cv_file_name", array('class' => 'form_container_input')) !!}</td>
  </tr>

  <tr>
    <td>{!! Form::label("applicant_letter_file_name","Upload Applicant's Application Letter") !!}</td>
    <td>{!! Form::file("applicant_letter_file_name", array('class' => 'form_container_input')) !!}</td>
  </tr>


  <tr>
    <td colspan="2" align="right">{!! Form::submit($submitButtonText, array('class' => 'submit-button')) !!}</td>
  </tr>

</table>
