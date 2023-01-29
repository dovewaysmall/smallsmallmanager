@extends('appcx')
@section('content')
@section('title', 'Single Staysmallsmall Booking')

<div class="container-fluid">
    <!-- row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="profile card card-body px-3 pt-3 pb-0">
                <div class="profile-head">
                    <div class="photo-content">
                        <div class="cover-photo"></div>
                    </div>
                    <div class="profile-info">
                        <div class="profile-photo">
                            <img src="{{ asset('assets/images/profile/profile.png')}}" class="img-fluid rounded-circle" alt="">
                        </div>
                        <div class="profile-details">
                            {{-- <h4 class="text-primary mb-0">{{dd($singleTenant)}}</h4> --}}
                            {{-- <h4 class="text-primary mb-0">{{dd($tenant)}}</h4> --}}
                            @foreach($singleStaySmallSmallBooking as $singleBooking)
                            <div class="profile-name px-3 pt-2">
                                <h4 class="text-primary mb-0">{{$singleBooking['firstname'].' '.$singleBooking['lastname']}}</h4>
                                
                            </div>
                            <div class="profile-email px-2 pt-2">
                                <h4 class="text-muted mb-0">{{$singleBooking['email']}}</h4>
                                <p>{{$singleBooking['phone']}}</p>
                            </div>
                            
                            <div class="dropdown ml-auto">
                                <a href="#" class="btn btn-primary light sharp" data-toggle="dropdown" aria-expanded="true"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg></a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li class="dropdown-item"><i class="fa fa-user-circle text-primary mr-2"></i> View profile</li>
                                    <li class="dropdown-item"><i class="fa fa-users text-primary mr-2"></i> Add to close friends</li>
                                    <li class="dropdown-item"><i class="fa fa-plus text-primary mr-2"></i> Add to group</li>
                                    <li class="dropdown-item"><i class="fa fa-ban text-primary mr-2"></i> Block</li>
                                </ul>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                        <h4 class="fs-20 text-black mb-0">Staysmallsmall Booking Details</h4>
                    </div>
                    <div class="dropdown">
                        <button type="button" class="btn btn-primary light btn-md" data-toggle="dropdown" aria-expanded="false">
                            {{-- {{$singleBooking['assigned_tsr']}} --}}
                            
                                {{-- @php
                                if($singleBooking['assigned_tsr'] == ''){
                                    echo 'Assigned TSR: Not Assigned';
                                }else {
                                    $tsr = DB::table('users')->select('name')->where('parent_id',$singleBooking['assigned_tsr']);
                                    // $tsr = Auth::user()->name->where('parent_id',$singleBooking['assigned_tsr']);
                                    echo 'Assigned TSR: '.$tsr;
                                }

                                @endphp --}}
                            {{-- Assigned TSR: {{$singleBooking['tsr_firstName'].' '.$singleBooking['tsr_lastName']}} --}}
                            
                            {{-- <i class="fa fa-chevron-down ml-2" aria-hidden="true"></i> --}}
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">Edit</a>
                            <a class="dropdown-item" href="#">Delete</a>
                        </div>
                    </div>
                </div>
                

                <div class="card-body p-0">
                    <div class="table-responsive">

                        <table class="table shadow-hover">
                            <thead>
                                <tr>
                                    <th><span class="font-w600 text-black fs-16">Booking Details</span></th>
                                    <th><span class="font-w600 text-black fs-16"></span></th>
                                    <th><span class="font-w600 text-black fs-16"></span></th>
                                    <th><span class="font-w600 text-black fs-16"></span></th>
                                    
                                </tr>
                            </thead>

                            <thead>
                                <tr>
                                    <th><span class="font-w600 text-black fs-16">Date of Booking</span></th>
                                    <th><span class="font-w600 text-black fs-16">Apartment</span></th>
                                    <th><span class="font-w600 text-black fs-16">Guests</span></th>
                                    <th><span class="font-w600 text-black fs-16">No. of nights</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($singleStaySmallSmallBooking as $singleBooking)
                                <tr>
                                    <td>{{date('d-m-Y H:m:i',strtotime($singleBooking['date_of_booking']))}}</td>
                                    <td>{{$singleBooking['apartmentName']}}</td>
                                    <td>{{$singleBooking['guests']}}</td>
                                    <td>{{$singleBooking['no_of_nights']}}</td>
                                </tr>
                                @endforeach
                            </tbody>

                            <thead>
                                <tr>
                                    <th><span class="font-w600 text-black fs-16">Check in</span></th>
                                    <th><span class="font-w600 text-black fs-16">Check out</span></th>
                                    <th><span class="font-w600 text-black fs-16">Address</span></th>
                                    <th><span class="font-w600 text-black fs-16">Comment</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($singleStaySmallSmallBooking as $singleBooking)
                                <tr>
                                    <td>{{date('d-m-Y',strtotime($singleBooking['checkin']))}}</td>
                                    <td>{{date('d-m-Y',strtotime($singleBooking['checkout']))}}</td>
                                    <td>{{$singleBooking['address']}}</td>
                                    <td>{{$singleBooking['comment']}}</td>
                                </tr>
                                @endforeach
                            </tbody>

                            <thead>
                                <tr>
                                    <th><span class="font-w600 text-black fs-16">Cost</span></th>
                                    <th><span class="font-w600 text-black fs-16">Pickup Option</span></th>
                                    <th><span class="font-w600 text-black fs-16">Pickup Location</span></th>
                                    <th><span class="font-w600 text-black fs-16">Pickup Cost</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($singleStaySmallSmallBooking as $singleBooking)
                                <tr>
                                    <td>&#x20A6;{{$singleBooking['cost']}}</td>
                                    <td>{{$singleBooking['pickup_option']}}</td>
                                    <td>{{$singleBooking['pickup_location']}}</td>
                                    <td>&#x20A6;{{$singleBooking['pickup_cost']}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <thead>
                                <tr>
                                    <th><span class="font-w600 text-black fs-16">Identification</span></th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($singleStaySmallSmallBooking as $singleBooking)
                                <tr>
                                    <td><a href="https://stay.smallsmall.com/uploads/identification/{{$singleBooking['userID']}}/{{$singleBooking['identification']}}" target="_blank"><img src="https://stay.smallsmall.com/uploads/identification/{{$singleBooking['userID']}}/{{$singleBooking['identification']}}" width="500" height="300"></a></td>
                                    
                                </tr>
                                @endforeach
                            </tbody>

                            <thead>
                                <tr>
                                    <th><span class="font-w600 text-black fs-16">Next of Kin Profile</span></th>
                                    <th><span class="font-w600 text-black fs-16"></span></th>
                                    <th><span class="font-w600 text-black fs-16"></span></th>
                                    <th><span class="font-w600 text-black fs-16"></span></th>
                                    
                                </tr>
                            </thead>

                            <thead>
                                <tr>
                                    <th><span class="font-w600 text-black fs-16">Next of Kin Name</span></th>
                                    <th><span class="font-w600 text-black fs-16">Next of Kin Email</span></th>
                                    <th><span class="font-w600 text-black fs-16">Next of Kin Phone</span></th>
                                    <th><span class="font-w600 text-black fs-16">Next of Kin Address</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($singleStaySmallSmallBooking as $singleBooking)
                                <tr>
                                    <td>{{$singleBooking['nok_fullname']}}</td>
                                    <td>{{$singleBooking['nok_email']}}</td>
                                    <td>{{$singleBooking['nok_phone']}}</td>
                                    <td>{{$singleBooking['nok_address']}}</td>
                                    
                                </tr>
                                @endforeach
                            </tbody>

                        
                            
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
        "scrollX": true
} );
</script>
@endsection