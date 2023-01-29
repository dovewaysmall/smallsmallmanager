@extends('appcx')
@section('content')
@section('title', 'Post Inspection Update Success')

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-6">
            <div class="alert alert-success left-icon-big alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                </button>
                <div class="media">
                    <div class="alert-left-icon-big">
                        <span><i class="mdi mdi-check-circle-outline"></i></span>
                    </div>
                    <div class="media-body">
                        <h5 class="mt-1 mb-2">Congratulations!</h5>
                        <p class="mb-0">You have successfully updated the Post Inspection Feedback record.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection