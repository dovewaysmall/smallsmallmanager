@extends('appcx')
@section('content')
@section('title', 'All Payouts')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">All Payouts</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="display min-w850">
                            <thead>
                                <tr>
                                    <th>Landlord ID</th>
                                    <th>Next Payout</th>
                                    <th>Next Payout Date</th>
                                    <th>Status</th>
                                    <th>Authorized By</th>
                                    <th>Date Paid</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach ($allPayouts as $payout)
                                <tr>
                                    
                                    <td>{{$payout['payee_id']}}</td>
                                    <td>{{$payout['next_payout']}}</td>
                                    <td>{{$payout['next_payout_date']}}</td>
                                    <td>{{$payout['payout_status']}}</td>
                                    <td>{{$payout['authorized_by']}}</td>
                                    <td>{{$payout['date_paid']}}</td>
                                    
                                    
                                </tr>
                                @endforeach
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
@endsection