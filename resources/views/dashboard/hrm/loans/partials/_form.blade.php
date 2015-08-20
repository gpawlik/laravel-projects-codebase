<table class = "form-element full">

  <tr>
    <td>{!! Form::label("loan_type","Loan Type*") !!}</td>
    @if(isset($loan_type))
      <td>{!! Form::select("loan_type", ['COMPANY LOAN'=>'Company Loan','BANK LOAN'=>'Bank Loan'], $loan_type, array('class' => 'select-input', 'id'=>'loan-type-select') ) !!}</td>
    @else
      <td>{!! Form::select("loan_type", ['COMPANY LOAN'=>'Company Loan','BANK LOAN'=>'Bank Loan'], null, array('class' => 'select-input','id'=>'loan-type-select'))  !!}</td>
    @endif
  </tr>

  @if(isset($banks))
  <tr id = "loan-type-row">
    <td>{!! Form::label("bank","Bank") !!}</td>

    @if(isset($loans_bank))
    <td>
      {!! Form::select("bank", array( $loans_bank -> id => $loans_bank -> bank_name ) +  $banks, $loans_bank, array('class' => 'select-input') ) !!}
    </td>
    @else
    <td>
      {!! Form::select("bank", $banks,null,array('class' => 'select-input') ) !!}
    </td>
    @endif
  </tr>
  @endif

  <tr>
    <td>{!! Form::label("amount","Amount") !!}</td>
    <td>{!! Form::text("amount", null , ['placeholder' => 'Amount','class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td>{!! Form::label("payment_frequency","Payment Frequency") !!}</td>
    <td>{!! Form::text("payment_frequency", null , ['placeholder' => 'Payment Frequency','class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td>{!! Form::label("start_date","Start Date") !!}</td>
    <td>{!! Form::input("date", 'start_date', null , ['class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td>{!! Form::label("end_date","End Date") !!}</td>
    <td>{!! Form::input("date", 'end_date', null , ['class'=>'text-input']) !!}</td>
  </tr>

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
      <td colspan="2" align="right">{!! Form::submit($submitButtonText, array('class' => 'submit-button')) !!}</td>
    </tr>



</table>
