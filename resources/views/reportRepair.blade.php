@extends('appcx')
@section('content')
@section('title', 'Add Payout')

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-8 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Report Repair</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <form method="post" action="https://api.rentsmallsmall.com/api/report-repair-api">
                            @csrf
                            @if(session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session()->get('message') }}
                                </div>
                            @endif
                            <div class="form-group">
                                <label>Appartment Owner ID</label>
                                <input type="text" name="apartment_owner_id" class="form-control input-rounded" required>
                            </div>
                            <div class="form-group"> 
                                <label>Items Repaired</label>
                                <textarea name="items_repaired" class="form-control" rows="6" required></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label>Repair Amount</label>
                                <input type="text" name="repair_amount" class="form-control input-rounded" required>
                            </div>
                            <div class="form-group">
                                <label>Repair Status</label>
                                <select class="form-control default-select" id="repair_status" name="repair_status">
                                    <option value="pending">Pending</option>
                                    <option value="on going">On going</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Repair Date</label>
                                <input type="date" name="repair_date" class="form-control input-rounded" required>
                                <input type="hidden" name="repair_done_by" class="form-control input-rounded" value="{{Auth::user()->id}}">
                            </div>

                            <button type="submit" class="btn btn-primary">Report Repair</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection