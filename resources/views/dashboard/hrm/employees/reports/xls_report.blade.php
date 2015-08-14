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
  <td>Father's Name</td>
  <td>Mother's Name</td>
  <td>Bank</td>
  <td>Bank Account Number</td>
  <td>Qualifications</td>
  <td>Date of Hire</td>
  <td>Basic Salary</td>
  <td>Marital Status</td>
  </tr>
  @foreach($users as $user)
  <tr>
   <td>{{$user['first_name']}}</td>
   <td>{{$user['last_name']}}</td>
   <td>{{$user['email']}}</td>
   <td>{{$user['phone_number']}}</td>
   <td>{{date("F jS, Y",strtotime($user['created_at']))}}</td>
  </tr>
  @endforeach
 </tbody>
</table>
