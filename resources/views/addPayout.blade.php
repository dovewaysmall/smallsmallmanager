@extends('appcx')
@section('content')
@section('title', 'Add Payout')

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-8 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add Payout</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <form method="post" action="https://api.rentsmallsmall.com/api/add-payout-api">
                            @csrf
                            @if(session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session()->get('message') }}
                                </div>
                            @endif
                            <div class="form-group">
                                <input type="text" name="payee_id" class="form-control input-rounded" placeholder="Payee ID" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="next_payout" class="form-control input-rounded" placeholder="Next Payout" required>
                            </div>
                            <div class="form-group">
                                <label>Next Payout Date</label>
                                <input type="date" name="next_payout_date" class="form-control input-rounded" required>
                                <input type="hidden" name="authorized_by" class="form-control input-rounded" value="{{Auth::user()->id}}">
                            </div>


                            <button type="submit" class="btn btn-primary">Add Payout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection