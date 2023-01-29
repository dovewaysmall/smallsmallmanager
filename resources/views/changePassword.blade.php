@extends('appcx')
@section('content')
@section('title', 'Add Payout')

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-8 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Change Password</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <form method="post" action="{{url('/save-new-password')}}">
                            @csrf
                            @if(session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session()->get('message') }}
                                </div>
                            @endif
                            <div class="form-group">
                                <label>New Password</label>
                                <input type="password" name="password" class="form-control input-rounded" required>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Change Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection