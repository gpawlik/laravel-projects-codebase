<div class = "card half inline">

<table class = "form-element full">

  <tr>
    <td>{!! Form::label("staff_number","Staff Number") !!}</td>
    <td>{!! Form::text("staff_number", null , ['placeholder' => 'Staff Number','class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td>{!! Form::label("first_name","First Name") !!}</td>
    <td>{!! Form::text("first_name", null , ['placeholder' => 'First Name','class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td>{!! Form::label("last_name","Last Name") !!}</td>
    <td>{!! Form::text("last_name", null , ['placeholder' => 'Last Name','class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td>{!! Form::label("other_names","Other Names") !!}</td>
    <td>{!! Form::text("other_names", null , ['placeholder' => 'Other Names','class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td>{!! Form::label("date_of_birth","Date of Birth") !!}</td>
    <td>{!! Form::input("date", 'date_of_birth', null , ['class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td>{!! Form::label("marital_status","Marital Status") !!}</td>
    <td>{!! Form::select("marital_status", ['single'=>'Single','married'=>'Married'], null, array('class' => 'select-input') ) !!}</td>
  </tr>

  <tr>
    <td>{!! Form::label("spouse_name","Name of Spouse") !!}</td>
    <td>{!! Form::text("spouse_name", null , ['placeholder' => 'Name of Spouse','class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td>{!! Form::label("next_of_kin","Next of Kin") !!}</td>
    <td>{!! Form::text("next_of_kin", null , ['placeholder' => 'Next of Kin','class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td>{!! Form::label("gender","Gender") !!}</td>
    <td>{!! Form::select("gender", ['male'=>'Male','female'=>'Female'], null, array('class' => 'select-input') ) !!}</td>
  </tr>

  <tr>
    <td>{!! Form::label("social_security_number","Social Security Number") !!}</td>
    <td>{!! Form::text("social_security_number", null , ['placeholder' => 'Social Security Number','class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td>{!! Form::label("email","Email") !!}</td>
    <td>{!! Form::text("email", null , ['placeholder' => 'Email','class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td>{!! Form::label("telephone_number","Telephone Number") !!}</td>
    <td>{!! Form::text("telephone_number", null , ['placeholder' => 'Telephone Number','class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td>{!! Form::label("mailing_address","Mailing Address") !!}</td>
    <td>{!! Form::textarea("mailing_address", null , ['placeholder' => 'Mailing Address','class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td>{!! Form::label("residential_address","Residential Address") !!}</td>
    <td>{!! Form::textarea("residential_address", null , ['placeholder' => 'Residential Address','class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td>{!! Form::label("emergency_contact_name","Emergency Contact") !!}</td>
    <td>{!! Form::text("emergency_contact_name", null , ['placeholder' => 'Emergency Contact','class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td>{!! Form::label("emergency_contact_number","Emergency Contact Number") !!}</td>
    <td>{!! Form::text("emergency_contact_number", null , ['placeholder' => 'Emergency Contact Number','class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td>{!! Form::label("alergies","Alergies") !!}</td>
    <td>{!! Form::text("alergies", null , ['placeholder' => 'Alergies','class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td>{!! Form::label("fathers_name","Father's Name") !!}</td>
    <td>{!! Form::text("fathers_name", null , ['placeholder' => "Father's Name",'class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td>{!! Form::label("mothers_name","Mother's Name") !!}</td>
    <td>{!! Form::text("mothers_name", null , ['placeholder' => "Mother's Name",'class'=>'text-input']) !!}</td>
  </tr>

</table>
</div>

<div class = "card half inline">

  <table class = "form-element full">

    @if(isset($banks))
    <tr>
      <td>{!! Form::label("bank","Bank") !!}</td>

      @if(isset($employees_bank))
      <td>
        {!! Form::select("bank", array( $employees_bank -> id => $employees_bank -> bank_name ) +  $banks, $employees_bank, array('class' => 'select-input') ) !!}
      </td>
      @else
      <td>
        {!! Form::select("bank", $banks,null,array('class' => 'select-input') ) !!}
      </td>
      @endif
    </tr>
    @endif

    <tr>
      <td>{!! Form::label("bank_account_number","Bank Account number") !!}</td>
      <td>{!! Form::text("bank_account_number", null , ['placeholder' => "Bank Account number",'class'=>'text-input']) !!}</td>
    </tr>

    <tr>
      <td>{!! Form::label("qualifications","Qualifications") !!}</td>
      <td>{!! Form::text("qualifications", null , ['placeholder' => "Qualifications",'class'=>'text-input']) !!}</td>
    </tr>

    <tr>
      <td>{!! Form::label("date_of_hire","Date of hire") !!}</td>
      <td>{!! Form::input("date", 'date_of_hire', null , ['class'=>'text-input']) !!}</td>
    </tr>

    <tr>
      <td>{!! Form::label("gross_salary","Gross Salary") !!}</td>
      <td>{!! Form::text("gross_salary", null , ['placeholder' => "Gross Salary",'class'=>'text-input']) !!}</td>
    </tr>

    <tr>
      <td>{!! Form::label("income_tax","Income Tax(Amount)") !!}</td>
      <td>{!! Form::text("income_tax", null , ['placeholder' => "Income Tax(Amount)",'class'=>'text-input']) !!}</td>
    </tr>

    <tr>
      <td>{!! Form::label("ssnit","SSNIT Contribution (Amount)") !!}</td>
      <td>{!! Form::text("ssnit", null , ['placeholder' => "SSNIT Contribution (Amount)",'class'=>'text-input']) !!}</td>
    </tr>

    <tr>
      <td>{!! Form::label("employer_welfare_contribution","Welfare Contribution (Employer)") !!}</td>
      <td>{!! Form::text("employer_welfare_contribution", null , ['placeholder' => "Welfare Contribution (Employer)",'class'=>'text-input']) !!}</td>
    </tr>

    <tr>
      <td>{!! Form::label("employee_welfare_contribution","Welfare Contribution (Employee)") !!}</td>
      <td>{!! Form::text("employee_welfare_contribution", null , ['placeholder' => "Welfare Contribution (Employee)",'class'=>'text-input']) !!}</td>
    </tr>

    <tr>
      <td>{!! Form::label("allowances","Allowances (Total Amount)") !!}</td>
      <td>{!! Form::text("allowances", null , ['placeholder' => "Allowances (Total Amount)",'class'=>'text-input']) !!}</td>
    </tr>

    @if(isset($jobs))
    <tr>
      <td>{!! Form::label("job","Job") !!}</td>

      @if(isset($employees_job))
      <td>
        {!! Form::select("job", array( $employees_job -> id => $employees_job -> job_title ) +  $jobs, $employees_job, array('class' => 'select-input') ) !!}
      </td>
      @else
      <td>
        {!! Form::select("job", $jobs ,null,array('class' => 'select-input') ) !!}
      </td>
      @endif
    </tr>
    @endif

    @if(isset($branches))
    <tr>
      <td>{!! Form::label("branch","Branch") !!}</td>

      @if(isset($employees_branch))
      <td>
        {!! Form::select("branch", array( $employees_branch -> id => $employees_branch -> branch_name ) +  $branches, $employees_branch, array('class' => 'select-input') ) !!}
      </td>
      @else
      <td>
        {!! Form::select("branch", $branches ,null,array('class' => 'select-input') ) !!}
      </td>
      @endif
    </tr>
    @endif

    @if(isset($ids))
    <tr>
      <td>{!! Form::label("identification","Identification") !!}</td>

      @if(isset($employees_id))
      <td>
        {!! Form::select("identification", array( $employees_id -> id => $employees_id -> identification_name ) +  $ids, $employees_id, array('class' => 'select-input') ) !!}
      </td>
      @else
      <td>
        {!! Form::select("identification", $ids ,null,array('class' => 'select-input') ) !!}
      </td>
      @endif
    </tr>
    @endif

    <tr>
      <td>{!! Form::label("identification_number","Identification Number") !!}</td>
      <td>{!! Form::text("identification_number", null , ['placeholder' => "Identification Number",'class'=>'text-input']) !!}</td>
    </tr>

    <tr>
      <td>{!! Form::label("tax_identification_number","Tax Identification Number") !!}</td>
      <td>{!! Form::text("tax_identification_number", null , ['placeholder' => "Tax Identification Number",'class'=>'text-input']) !!}</td>
    </tr>

    <tr>
      <td>{!! Form::label("number_of_dependants","Number of Dependants") !!}</td>
      <td>{!! Form::text("number_of_dependants", null , ['placeholder' => "Number of Dependants",'class'=>'text-input']) !!}</td>
    </tr>

    {{-- <tr>
      <td>{!! Form::label("leave_entitlement_days","Leave Days Entitlement") !!}</td>
      <td>{!! Form::text("leave_entitlement_days", null , ['placeholder' => "Leave Days Entitlement",'class'=>'text-input']) !!}</td>
    </tr> --}}

    {{-- @if(isset($ranks))
    <tr>
      <td>{!! Form::label("rank","Rank") !!}</td>

      @if(isset($employees_rank))
      <td>
        {!! Form::select("rank", array( $employees_rank -> id => $employees_rank -> rank_name ) +  $ranks, $employees_rank, array('class' => 'select-input') ) !!}
      </td>
      @else
      <td>
        {!! Form::select("rank", $ranks ,null,array('class' => 'select-input') ) !!}
      </td>
      @endif
    </tr>
    @endif --}}

    @if(isset($context))
      @if($context == 'add')
      <tr>
        <td>{!! Form::label("picture_name","Picture") !!}</td>
        <td>{!! Form::file("picture_name") !!}</td>
      </tr>
      @endif

      @if($context == 'update')
        <tr>
          <td>{!! Form::label("picture_name","Picture") !!}</td>
          <td>
            {!! Form::file("picture_name") !!}
            @if(isset($employee->picture_name))
              <div id = "small-image">
                <img src = "/uploads/{{$employee->picture_name}}" />
              </div>
              <input type = "checkbox" name = "clear_check" value = "yes" /> Clear Image (<span class = "small-text">Check to delete image</span>)
            @endif
          </td>
        </tr>
      @endif
    @endif


    <tr>
      <td colspan="2" align="right">{!! Form::submit($submitButtonText, array('class' => 'submit-button')) !!}</td>
    </tr>

  </table>
</div>
