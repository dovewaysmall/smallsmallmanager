@extends('appcx')
@section('content')
@section('title', 'New Subscribers')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Subscription Due This Month</h4>
                    <span>
                    {{-- <a href="{{url('/inspections-last-month')}}" class="btn btn-warning btn-xxs shadow">Last Month</a> --}}
                    {{-- <a href="{{url('/inspections-this-month')}}" class="btn btn-success btn-xxs shadow">This Month</a> --}}
                    </span>
                </div>
                <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
                <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table shadow-hover display responsive nowrap" id="datatable" width="100%">
                            <thead>
                                <tr>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Property Name</th>
                                    <th>Move In</th>
                                    <th>Next Rental</th>                                    
                                    <th>Status</th>
                                   
                                    <th>Update</th>
                                                                  
                                    {{-- <th>Customer Inspection Feedback</th>
                                    <th>CX Feedback Details</th> --}}
                                    
                                 
                                </tr>
                            </thead>
                            <tbody>
                                
                                
                                @php 
                                

$api_url = 'https://api.smallsmall.com/api/subscription-due-this-month-api';

// Get the JSON data from the API
$json_data = file_get_contents($api_url);

// Define the JSON data
//$json_data = '[{"id":11,"userID":"194385013034"},{"id":11,"userID":"194385013034"},{"id":11,"userID":"194375013034"}]';

// Decode the JSON data
$data = json_decode($json_data, true);

// Create an associative array to store the user ID counts
$user_id_counts = array();

// Iterate through the JSON data
foreach ($data as $item) {
    // Check if the user ID is already in the user ID counts array
    if (isset($user_id_counts[$item['userID']])) {
        // If it is, increment the count
        $user_id_counts[$item['userID']]++;
    } else {
        // If not, add it to the user ID counts array with a count of 1
        $user_id_counts[$item['userID']] = 1;
    }
    
}
$today = date('d-m-Y');
// Iterate through the JSON data
foreach ($data as $item) {
    // Check if the user ID count is equal to 1
    if ($user_id_counts[$item['userID']] > 1) {
        // Display the user ID and its corresponding id
    //    echo $today ."<br>"; 
    //    if($today > date('d-m-Y',strtotime($item['move_in_date']))){
    //     echo date('d-m-Y',strtotime($item['move_in_date'])) . "is older than". $today;
    //    }else{
    //     echo 'Its not';
    //    }
       //exit;
        echo "<tr>
                 <td>" . $item['firstName'] . "</td>
                 <td>" . $item['lastName'] . "</td>
                 <td>" . $item['propertyTitle'] . "</td>
                 <td>" . date('d-m-Y',strtotime($item['move_in_date'])) . "</td>
                 <td>" . date('d-m-Y',strtotime($item['next_rental'])) . "</td>";
                if($today > date('d-m-Y',strtotime($item['move_in_date']))){
                    echo "<td><a href='#' class='btn btn-danger btn-xxs shadow'>Payment Overdue</a></td>";
                }elseif($today < date('d-m-Y',strtotime($item['move_in_date']))){
                    echo "<td><a href='#' class='btn btn-warning btn-xxs shadow'>Payment Not Due</a></td>";
                }
               echo "<td><a href='#' class='btn btn-warning btn-xxs shadow'>Update</a></td>";
                 
             echo "</tr>";
    }
}
// foreach ($user_id_counts as $user_id => $count) {
//     // Display the user ID and its count
//     //echo $user_id . ": " . $count . "<br>";
//     if($count==1){
//         echo "<tr>
//                 <td>$user_id</td>
//                 <td>$move_in_date</td>
//               </tr>";
//     }
// }

//


// Get the count of each item


@endphp
                            </tbody>
                            {{-- <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Office</th>
                                    <th>Age</th>
                                    <th>Start date</th>
                                    <th>Salary</th>
                                </tr>
                            </tfoot> --}}
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    $('#datatable').dataTable( {
        // responsive: true
        "scrollX": true,
        order: [],
} );
</script>
@endsection