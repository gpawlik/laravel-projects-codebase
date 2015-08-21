<table>
 <tbody>
  <tr>
   <td>First Name</td>
   <td>Last Name</td>
   <td>Other Name</td>
    <td>Date of birth</td>
    <td>Gender</td>
    <td>Marital Status</td>
    <td>Next of Kin</td>
    <td>Email</td>
    <td>Telephone Number</td>
    <td>Mailing Address</td>
    <td>Residential Address</td>
    <td>Emergency Contact Name</td>
    <td>Emergency Contact Number</td>
    <td>Alergies</td>
    <td>Father's Name</td>
    <td>Mother's Name</td>
    <td>Qualifications</td>
    <td>Date of Hire</td>
    <td>Basic Salary</td>
    <td>SSNIT Contribution</td>
    <td>Taxable Salary</td>
    <td>Tax Amount</td>
    <td>Net Salary</td>
    <td>Bank</td>
    <td>Bank Account Number</td>
    <td>Tax Identification Number</td>
    <td>Identification Type</td>
    <td>Identification Number</td>
    <td>Job Position</td>
    <td>Branch</td>
    </tr>
  @foreach($employees as $employee)
    <tr>
     <td>{{$employee -> first_name}}</td>
     <td>{{$employee -> last_name}}</td>
     @if(isset($employee->other_names))<td>{{ $employee->other_names }}</td>@else <td></td> @endif
     <td>{{$employee->date_of_birth}}</td>
     <td>{{$employee->gender}}</td>
     <td>{{$employee->marital_status}}</td>
     <td>{{$employee->next_of_kin}}</td>
     <td>{{$employee->email}}</td>
     <td>{{$employee->telephone_number}}</td>
     <td>{{$employee->mailing_address}}</td>
     <td>{{$employee->residential_address}}</td>
     <td>{{$employee->emergency_contact_name}}</td>
     <td>{{$employee->emergency_contact_number}}</td>
     @if(isset($employee->alergies))<td>{{$employee->alergies}}</td>@else <td></td> @endif
     <td>{{$employee->fathers_name}}</td>
     <td>{{$employee->mothers_name}}</td>
     <td>{{$employee->qualifications}}</td>
     <td>{{$employee->date_of_hire}}</td>
     <td>{{$employee->basic_salary}}</td>
     <td>{{$employee->ssnit_amount}}</td>
     <td>{{$employee->taxable_salary}}</td>
     <td>{{$employee->tax_amount}}</td>
     <td>{{$employee->net_salary}}</td>
     <td>{{ \DB::table("banks")->where("id",$employee->bank_id)->get()[0]->bank_name }}</td>
     <td>{{$employee->bank_account_number}}</td>
     @if(isset($employee->tax_identification_number))<td>{{$employee->tax_identification_number}}</td>@else <td></td> @endif
     <td>{{ \DB::table("identification")->where("id",$employee->identification_id)->get()[0]->identification_name }}</td>
     <td>{{$employee->identification_number}}</td>
     <td>{{ \DB::table("jobs")->where("id",$employee->job_id)->get()[0]->job_title }} </td>
     <td>{{ \DB::table("branches")->where("id",$employee->branch_id)->get()[0]->branch_name }}</td>
    </tr>
  @endforeach
 </tbody>
</table>
