<table>
 <tbody>
  <tr><td>First Name</td><td>{{ $employee -> first_name }}</td></tr>
  <tr><td>Last Name</td><td>{{ $employee -> last_name }}</td></tr>
  <tr><td>Other Name</td><td>{{ $employee -> other_names }}</td></tr>
  <tr><td>Date of birth</td><td>{{ $employee -> date_of_birth }}</td></tr>
  <tr><td>Gender</td><td>{{ $employee -> gender }}</td></tr>
  <tr><td>Marital Status</td><td>{{ $employee -> marital_status }}</td></tr>
  <tr><td>Next of Kin</td><td>{{ $employee -> next_of_kin }}</td></tr>
  <tr><td>Email</td><td>{{ $employee -> email }}</td></tr>
  <tr><td>Telephone Number</td><td>{{ $employee -> telephone_number }}</td></tr>
  <tr><td>Mailing Address</td><td>{{ $employee -> mailing_address }}</td></tr>
  <tr><td>Residential Address</td><td>{{ $employee -> residential_address }}</td></tr>
  <tr><td>Emergency Contact Name</td><td>{{ $employee -> emergency_contact_name }}</td></tr>
  <tr><td>Emergency Contact Number</td><td>{{ $employee -> emergency_contact_number }}</td></tr>
  <tr><td>Alergies</td><td>{{ $employee -> alergies }}</td></tr>
  <tr><td>Father's Name</td><td>{{ $employee -> fathers_name }}</td></tr>
  <tr><td>Mother's Name</td><td>{{ $employee -> mothers_name }}</td></tr>
  <tr><td>Qualifications</td><td>{{ $employee -> qualifications }}</td></tr>
  <tr><td>Date of Hire</td><td>{{ $employee -> date_of_hire }}</td></tr>
  <tr><td>Basic Salary</td><td>{{ $employee -> basic_salary }}</td></tr>
  <tr><td>SSNIT Contribution</td><td>{{ $employee -> ssnit_amount }}</td></tr>
  <tr><td>Taxable Salary</td><td>{{ $employee -> taxable_salary }}</td></tr>
  <tr><td>Tax Amount</td><td>{{ $employee -> tax_amount }}</td></tr>
  <tr><td>Net Salary</td><td>{{ $employee -> net_salary }}</td></tr>
  <tr><td>Bank</td><td>{{ \DB::table("banks")->where("id",$employee->bank_id)->get()[0]->bank_name }}</td></tr>
  <tr><td>Bank Account Number</td><td>{{ $employee -> bank_account_number }}</td></tr>
  <tr><td>Tax Identification Number</td><td>{{ $employee -> tax_identification_number }}</td></tr>
  <tr><td>Identification Type</td><td>{{ \DB::table("identification")->where("id",$employee->identification_id)->get()[0]->identification_name }}</td></tr>
  <tr><td>Identification Number</td><td>{{ $employee -> identification_number }}</td></tr>
  <tr><td>Job Position</td><td>{{ \DB::table("jobs")->where("id",$employee->job_id)->get()[0]->job_title }}</td></tr>
  <tr><td>Branch</td><td>{{ \DB::table("branches")->where("id",$employee->branch_id)->get()[0]->branch_name }}</td></tr>


 </tbody>
</table>
