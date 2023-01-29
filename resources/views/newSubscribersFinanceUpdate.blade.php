@extends('appcx')
@section('content')
@section('title', 'Update New Subscribers')

<div class="container-fluid">
    <!-- row -->

    <div class="row">

        <div class="col-xl-12 col-xxl-12 col-lg-12">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="d-flex mr-3 align-items-center">
                        <span class="p-sm-3 p-2 mr-sm-3 mr-2 rounded-circle bg-secondary">
                            <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip1)">
                                <path d="M1.70023 22.6666C0.850779 22.8294 0.294244 23.6495 0.456974 24.499C0.600176 25.2476 1.2576 25.7683 1.99314 25.7683C2.09078 25.7683 2.19167 25.7585 2.28931 25.739L8.73339 24.5023C9.10116 24.4307 9.42987 24.2321 9.66421 23.9392L12.4306 20.4503L11.5063 19.9784C10.8229 19.6334 10.3477 19.0085 10.1849 18.2502L7.57476 21.5406L1.70023 22.6666Z" fill="#fff"/>
                                <path d="M24.6515 9.06246C26.5461 9.06246 28.0819 7.52664 28.0819 5.63212C28.0819 3.7376 26.5461 2.20178 24.6515 2.20178C22.757 2.20178 21.2212 3.7376 21.2212 5.63212C21.2212 7.52664 22.757 9.06246 24.6515 9.06246Z" fill="#fff"/>
                                <path d="M17.166 4.77294C16.8048 4.40191 16.4696 4.25546 16.1018 4.25546C15.9683 4.25546 15.8349 4.27498 15.6917 4.30753L9.80418 5.70375C8.99054 5.89577 8.48933 6.71267 8.68135 7.52306C8.84733 8.21954 9.46571 8.68821 10.1524 8.68821C10.2696 8.68821 10.3868 8.67519 10.504 8.6459L15.5193 7.45797C15.8447 7.81923 17.4753 9.58647 17.7714 9.89891C15.6983 12.1185 13.6251 14.3349 11.5519 16.5545C11.5194 16.5904 11.4901 16.6261 11.4608 16.6619C10.8554 17.4333 11.041 18.644 11.9522 19.1029L18.3084 22.3477L15.0083 27.695C14.5559 28.4306 14.7837 29.3939 15.5192 29.8495C15.7763 30.009 16.0595 30.0839 16.3394 30.0839C16.8634 30.0839 17.3776 29.8202 17.6738 29.3418L21.8657 22.5495C22.0968 22.1752 22.1586 21.7228 22.0382 21.303C21.9178 20.8799 21.6281 20.5284 21.2343 20.3299L16.9285 18.1395L21.4556 13.2967L24.8729 16.1933C25.1561 16.4341 25.5043 16.5513 25.8493 16.5513C26.2203 16.5513 26.5914 16.4146 26.881 16.1477L30.8028 12.4928C31.4147 11.9233 31.4504 10.9664 30.8809 10.3546C30.5815 10.0356 30.1779 9.87288 29.7743 9.87288C29.4066 9.87288 29.0355 10.0063 28.7459 10.2764L25.8102 13.007C25.8069 13.0103 18.4516 6.09104 17.166 4.77294Z" fill="#fff"/>
                                </g>
                                <defs>
                                <clipPath id="clip1">
                                <rect width="30.8571" height="30.8571" fill="white" transform="translate(0.428711 0.714233)"/>
                                </clipPath>
                                </defs>
                            </svg>
                        </span>
                        <h4 class="fs-20 text-black mb-0">Update New Subscribers</h4>
                    </div>
                    {{-- <div class="dropdown">
                        <button type="button" class="btn btn-primary light btn-md" data-toggle="dropdown" aria-expanded="false">
                            Newest
                            <i class="fa fa-chevron-down ml-2" aria-hidden="true"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">Edit</a>
                            <a class="dropdown-item" href="#">Delete</a>
                        </div>
                    </div> --}}
                </div>

                <div class="card-body">
                    <div class="basic-form">
                        <form method="post" action="https://api.smallsmall.com/staging/api/update-new-subscribers-api/">
                            @method('PUT')
                            @csrf
                            @if(session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session()->get('message') }}
                                </div>
                            @endif
                            {{-- {{dd($singleInspection)}} --}}
                            <div class="form-group">
                                <label>Move In Date</label>
                                <input type="date" name="move_in_date" class="form-control input-rounded" value="{{($responseNewSubscribersFinanceUpdate[0]['move_in_date'])}}" >
                            </div>
                            <input type="hidden" name="id" value="{{($responseNewSubscribersFinanceUpdate[0]['id'])}}">
                            <div class="form-group">
                                <label>Move Out Date</label>
                                <input type="date" name="move_out_date" class="form-control input-rounded" value="{{($responseNewSubscribersFinanceUpdate[0]['move_out_date'])}}" >
                            </div>
                            <div class="form-group">
                                <label>Rent Expiration</label>
                                <input type="date" name="rent_expiration" class="form-control input-rounded" value="{{($responseNewSubscribersFinanceUpdate[0]['rent_expiration'])}}" >
                            </div>
                            <div class="form-group">
                                <label>Next Rental</label>
                                <input type="date" name="next_rental" class="form-control input-rounded" value="{{($responseNewSubscribersFinanceUpdate[0]['next_rental'])}}" >
                            </div>
                            
                            

                            {{-- <div class="form-group">
                                <input type="text" name="frequency" class="form-control input-rounded" placeholder="Frequency">
                            </div> --}}
                            {{-- <div class="form-group">
                                <input type="date" name="regDate" class="form-control input-rounded">
                            </div> --}}
                            <button type="submit" class="btn btn-primary">Update New Subscriber</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

@endsection