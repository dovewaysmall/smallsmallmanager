@extends('appcx')
@section('content')
@section('title', 'Update Account Manager')

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-8 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Assign Account Manager</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <form method="post" action="https://api.smallsmall.com/api/update-account-manager-api">
                            @method('PUT')
                            @csrf
                            @if(session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session()->get('message') }}
                                </div>
                            @endif
                            
                            {{-- <div class="form-group">
                                <input type="text" class="form-control input-rounded" value="{{$userID[0]['firstName']}}">
                            </div> --}}
                            <div class="form-group">
                                <label>CX Personnel</label>
                                <select class="form-control default-select" id="sel1" name="account_manager">
                                    @foreach($cx as $cx_single)
                                        <option value="{{$cx_single['adminID']}}">{{$cx_single['firstName']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                {{-- <input type="hidden" name="id" value="{{dd($cx)}}" class="form-control input-rounded"> --}}
                                {{-- <input type="text" name="id" value="{{($userID[0]['userID'])}}" class="form-control input-rounded"> --}}
                                <input type="hidden" name="userID" value="{{$id}}" class="form-control input-rounded">
                                <input type="hidden" name="assigned_by" class="form-control input-rounded" value="{{Auth::user()->id}}">
                            </div>


                            <button type="submit" class="btn btn-primary">Assign</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection