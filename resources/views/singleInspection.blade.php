@extends('appcx')
@section('content')
@section('title', 'Single Inspection')

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
                            @foreach($singleInspection as $singleTenantone)
                            <div class="profile-name px-3 pt-2">
                                <h4 class="text-primary mb-0">{{$singleTenantone['firstName'].' '.$singleTenantone['lastName']}}</h4>
                                
                                    {{-- @if(($singleTenantone['verified']) == 'yes')
                                    <p>
                                        <a href="#nogo" class="btn btn-primary btn-md mb-2">Verified</a>
                                    </p>
                                    @else 
                                    <p>
                                        <a href="#nogo" class="btn btn-primary btn-md mb-2">Not Verified</a>
                                    </p>
                                    @endif  --}}
                            </div>
                            <div class="profile-email px-2 pt-2">
                                <h4 class="text-muted mb-0">{{$singleTenantone['email']}}</h4>
                                <p>{{$singleTenantone['phone']}}</p>
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
                        <h4 class="fs-20 text-black mb-0">Inspection Details</h4>
                    </div>
                    <div class="dropdown">
                        <button type="button" class="btn btn-primary light btn-md" data-toggle="dropdown" aria-expanded="false">
                            {{-- {{$singleTenantone['assigned_tsr']}} --}}
                            @php
                            $users = DB::table('users')->select('name')->where('parent_id',$singleTenantone['assigned_tsr'])->get();
                            // echo count($users);
                            if(count($users) == 0){
                                echo 'Assigned TSR: Not Assigned';
                            }else{
                                $data= json_decode( ($users), true);
                            // echo $data;
                            // $arr = json_decode($users);

                                foreach($data as $item) { //foreach element in $arr
                                    $tsr = $item['name']; //etc
                                    echo 'Assigned TSR: '.$tsr;

                                }
                            
                            // echo json_decode($users, true);
                            // foreach ($users as $key => $value) {
                            //     foreach ($$value as $user) {
                            //         echo $user;
                            //     }
                            }
                            
                            @endphp
                                {{-- @php
                                if($singleTenantone['assigned_tsr'] == ''){
                                    echo 'Assigned TSR: Not Assigned';
                                }else {
                                    $tsr = DB::table('users')->select('name')->where('parent_id',$singleTenantone['assigned_tsr']);
                                    // $tsr = Auth::user()->name->where('parent_id',$singleTenantone['assigned_tsr']);
                                    echo 'Assigned TSR: '.$tsr;
                                }

                                @endphp --}}
                            {{-- Assigned TSR: {{$singleTenantone['tsr_firstName'].' '.$singleTenantone['tsr_lastName']}} --}}
                            
                            {{-- <i class="fa fa-chevron-down ml-2" aria-hidden="true"></i> --}}
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">Edit</a>
                            <a class="dropdown-item" href="#">Delete</a>
                        </div>
                    </div>
                </div>
                @endforeach

                <div class="card-body p-0">
                    <div class="table-responsive">

                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header d-block">
                                    <h4 class="card-title">User Journey </h4>
                                    
                                </div>
                                <div class="card-body">
                                    {{-- {{dd($singleTenantone['assigned_tsr'])}} --}}
                                    @if($singleTenantone['inspection_status'] == 'pending-not-assigned'  || $singleTenantone['inspection_status'] == null)
                                        <h6>Subscriber Scheduled Inspection </h6>
                                            <span class="pull-right">15%</span>
                                        </h6>
                                        <div class="progress ">
                                            <div class="progress-bar bg-success progress-animated" style="width: 15%; height:6px;" role="progressbar">
                                                <span class="sr-only">15% Complete</span>
                                            </div>
                                        </div>
                                    @elseif($singleTenantone['inspection_status'] == 'pending-assigned')
                                        <h6>Inspection Assigned</h6>
                                            <span class="pull-right">25%</span>
                                        </h6>
                                        <div class="progress ">
                                            <div class="progress-bar bg-success progress-animated" style="width: 25%; height:6px;" role="progressbar">
                                                <span class="sr-only">25% Complete</span>
                                            </div>
                                        </div>
                                    @elseif($singleTenantone['inspection_status'] == 'completed')
                                        <h6>Property Inspected</h6>
                                        <span class="pull-right">40%</span>
                                        </h6>
                                        <div class="progress ">
                                            <div class="progress-bar bg-success progress-animated" style="width: 40%; height:6px;" role="progressbar">
                                                <span class="sr-only">40% Complete</span>
                                            </div>
                                        </div>
                                    @elseif($singleTenantone['inspection_status'] == 'canceled')
                                        <h6>Inspection Canceled</h6>
                                        <span class="pull-right">0%</span>
                                        </h6>
                                        <div class="progress ">
                                            <div class="progress-bar bg-danger progress-animated" style="width: 0%; height:6px;" role="progressbar">
                                                <span class="sr-only">0% Complete</span>
                                            </div>
                                        </div>
                                    @elseif($singleTenantone['inspection_status'] == 'apartment-not-available')
                                        <h6>Apartment Not Available</h6>
                                        <span class="pull-right">0%</span>
                                        </h6>
                                        <div class="progress ">
                                            <div class="progress-bar bg-danger progress-animated" style="width: 0%; height:6px;" role="progressbar">
                                                <span class="sr-only">0% Complete</span>
                                            </div>
                                        </div>
                                    @elseif($singleTenantone['inspection_status'] == 'multiple-bookings')
                                        <h6>Multiple Bookings</h6>
                                        <span class="pull-right">0%</span>
                                        </h6>
                                        <div class="progress ">
                                            <div class="progress-bar bg-danger progress-animated" style="width: 0%; height:6px;" role="progressbar">
                                                <span class="sr-only">0% Complete</span>
                                            </div>
                                        </div>
                                    @else 
                                        
                                    @endif
                                    
                                </div>
                            </div>
                        </div>

                        <table class="table shadow-hover">
                            <thead>
                                <tr>
                                    <th><span class="font-w600 text-black fs-16">Date</span></th>
                                    <th><span class="font-w600 text-black fs-16">Inspection ID</span></th>
                                    <th><span class="font-w600 text-black fs-16">Property</span></th>
                                    <th><span class="font-w600 text-black fs-16">Type</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @if($singleInspection != '') --}}
                                @foreach ($singleInspection as $tenantRentalInfo_single)
                                <tr>
                                    <td>
                                        {{-- <p class="text-black mb-1 font-w600">Sunday</p> --}}
                                        <span class="fs-14">{{date('d-m-Y',strtotime($tenantRentalInfo_single['dateOfEntry']))}}</span>
                                    </td>
                                    <td>
                                        {{-- <p class="text-black mb-1 font-w600">14,2 Km</p> --}}
                                        <span class="fs-14">{{$tenantRentalInfo_single['inspectionID']}}</span>
                                    </td>
                                    <td>
                                        {{-- <p class="text-black mb-1 font-w600">00:53:22”</p> --}}
                                        <span class="fs-14"><a href="{{url('https://rent.smallsmall.com/property/'.$tenantRentalInfo_single['propertyID'])}}" target="_blank" style="color: black !important">{{$tenantRentalInfo_single['propertyTitle']}}</a></span>
                                    </td>
                                    <td>
                                        {{-- <p class="text-black mb-1 font-w600">00:53:22”</p> --}}
                                        <span class="fs-14">{{$tenantRentalInfo_single['inspectionType']}}</span>
                                    </td>
                                </tr>
                                @endforeach
                                {{-- @else  --}}
                                <p></p>
                                {{-- @endif --}}
                                
                            </tbody>
                            <thead>
                                <tr>
                                    <th><span class="font-w600 text-black fs-16">Client Proposed Date</span></th>
                                    <th><span class="font-w600 text-black fs-16">Updated Inspection Date</span></th>
                                    
                                    <th><span class="font-w600 text-black fs-16">TSR Remark</span></th>
                                    <th><span class="font-w600 text-black fs-16">Status</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @if($singleInspection != '') --}}
                                @foreach ($singleInspection as $tenantRentalInfo_single)
                                <tr>
                                    <td>
                                        {{-- <p class="text-black mb-1 font-w600">Sunday</p> --}}
                                        <span class="fs-14">{{date('d-m-Y',strtotime($tenantRentalInfo_single['inspectionDate']))}}</span>
                                    </td>
                                    <td>
                                        <span class="fs-14">
                                        @if($tenantRentalInfo_single['updated_inspection_date'] == '0000-00-00 00:00:00' || $tenantRentalInfo_single['updated_inspection_date'] == '')
                                        <a href="{{ URL::to('inspection-feedback-cx/'.$tenantRentalInfo_single['id']) }}" class="btn btn-warning btn-xxs shadow">Not Updated</a>
                                        @else
                                        {{date('d-m-Y',strtotime($tenantRentalInfo_single['updated_inspection_date']))}}
                                        @endif
                                        </span>
                                        {{-- <span class="fs-14">{{date('d-m-Y',strtotime($tenantRentalInfo_single['updated_inspection_date']))}}</span> --}}
                                    </td>
                                    <td>
                                        @if($tenantRentalInfo_single['inspection_remarks'] == 'interested')
                                        <a href="#" class="btn btn-success btn-xxs shadow">Interested</a>
                                        @elseif($tenantRentalInfo_single['inspection_remarks'] == 'uninterested')
                                        <a href="#" class="btn btn-danger btn-xxs shadow">Uninterested</a>
                                        @elseif($tenantRentalInfo_single['inspection_remarks'] == 'indecisive')
                                        <a href="#" class="btn btn-warning btn-xxs shadow">Indecisive</a>
                                        @else
                                        <a href="#" class="btn btn-warning btn-xxs shadow">Not Updated</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if($tenantRentalInfo_single['inspection_status'] == 'pending-assigned')
                                        <a href="#" class="btn btn-primary btn-xxs shadow">Pending(Assigned)</a>
                                        @elseif($tenantRentalInfo_single['inspection_status'] == 'completed')
                                        <a href="#" class="btn btn-success btn-xxs shadow">Completed</a>
                                        @elseif($tenantRentalInfo_single['inspection_status'] == 'canceled')
                                        <a href="#" class="btn btn-danger btn-xxs shadow">Canceled</a>
                                        @elseif($tenantRentalInfo_single['inspection_status'] == 'apartment-not-available')
                                        <a href="#" class="btn btn-danger btn-xxs shadow">Apartment Not Available</a>
                                        @elseif($tenantRentalInfo_single['inspection_status'] == 'multiple-bookings')
                                        <a href="#" class="btn btn-danger btn-xxs shadow">Multiple Bookings</a>
                                        @else 
                                        <a href="#" class="btn btn-primary btn-xxs shadow">Pending(Not Assigned)</a>
                                        @endif
                                    </td>
                                    
                                    

                                </tr>
                                @endforeach
                                {{-- @else  --}}
                                <p></p>
                                {{-- @endif --}}
                                
                            </tbody>

                            <thead>
                                <tr>
                                    <th><span class="font-w600 text-black fs-16">TSR Comment</span></th>
                                    <th><span class="font-w600 text-black fs-16">Follow Up Stage</span></th>
                                    
                                    <th><span class="font-w600 text-black fs-16">Customer Inspection Feedback</span></th>
                                    <th><span class="font-w600 text-black fs-16">CX Feedback Details</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @if($singleInspection != '') --}}
                                @foreach ($singleInspection as $tenantRentalInfo_single)
                                <tr>
                                    <td>
                                        @if($tenantRentalInfo_single['comment'] == '')
                                        <a href="{{ URL::to('inspection-feedback-cx/'.$tenantRentalInfo_single['id']) }}" class="btn btn-warning btn-xxs shadow">Not Updated</a>
                                        @else
                                        <span class="fs-14">{{$tenantRentalInfo_single['comment']}}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($tenantRentalInfo_single['follow_up_stage'] == '' || $tenantRentalInfo_single['follow_up_stage'] == NULL)
                                        <a href="{{ URL::to('inspection-feedback-cx/'.$tenantRentalInfo_single['id']) }}" class="btn btn-warning btn-xxs shadow">Not Updated</a>
                                        @else 
                                        {{$tenantRentalInfo_single['follow_up_stage']}}
                                        @endif
                                    </td>
                                    <td>
                                        @if($tenantRentalInfo_single['customer_inspec_feedback'] == 'Post Inspection Call Made')
                                        <a href="{{ URL::to('inspection-feedback-cx/'.$tenantRentalInfo_single['id']) }}" class="btn btn-success btn-xxs shadow">Post Inspection Call Made</a>
                                        @elseif($tenantRentalInfo_single['customer_inspec_feedback'] == 'Post Inspection Mail Sent')
                                        <a href="{{ URL::to('inspection-feedback-cx/'.$tenantRentalInfo_single['id']) }}" class="btn btn-success btn-xxs shadow">Post Inspection Mail Sent</a>
                                        @else
                                        <a href="{{ URL::to('inspection-feedback-cx/'.$tenantRentalInfo_single['id']) }}" class="btn btn-warning btn-xxs shadow">Not Updated</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if($tenantRentalInfo_single['cx_feedback_details'] == '' || $tenantRentalInfo_single['cx_feedback_details'] == NULL)
                                        <a href="#" class="btn btn-warning btn-xxs shadow">Not Updated</a>
                                        @else 
                                        {{$tenantRentalInfo_single['cx_feedback_details']}}
                                        @endif
                                    </td>
                                    
                                    

                                </tr>
                                @endforeach
                                {{-- @else  --}}
                                <p></p>
                                {{-- @endif --}}
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="col-xl-4 col-xxl-12 col-lg-12">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="d-flex align-items-center mr-3">
                        <span class="p-sm-3 p-2 mr-sm-3 mr-2 rounded-circle bg-warning">
                            <svg width="32" height="32" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip2)">
                                <path d="M14.9993 7.49987C17.0704 7.49987 18.7493 5.82097 18.7493 3.74993C18.7493 1.6789 17.0704 0 14.9993 0C12.9283 0 11.2494 1.6789 11.2494 3.74993C11.2494 5.82097 12.9283 7.49987 14.9993 7.49987Z" fill="#fff"/>
                                <path d="M22.2878 27.2871L17.6697 29.0191L19.9663 29.8803C20.9546 30.2473 22.021 29.7388 22.3804 28.7826C22.5718 28.2725 22.5152 27.7381 22.2878 27.2871Z" fill="#fff"/>
                                <path d="M6.28312 20.7436C5.31545 20.3847 4.23328 20.8718 3.86895 21.8412C3.50549 22.8108 3.99715 23.891 4.96658 24.2554L6.98941 25.0139L12.3298 23.011L6.28312 20.7436Z" fill="#fff"/>
                                <path d="M26.1303 21.8413C25.7659 20.8717 24.6838 20.3847 23.7162 20.7436L8.71647 26.3685C7.74692 26.7329 7.25532 27.8132 7.61878 28.7827C7.97813 29.7386 9.0443 30.2474 10.033 29.8804L25.0326 24.2555C26.0022 23.8911 26.4938 22.8108 26.1303 21.8413Z" fill="#fff"/>
                                <path d="M28.1244 14.9997H23.6585L20.4268 8.53623C20.0909 7.86516 19.4077 7.48284 18.7036 7.49989L14.9993 7.49987L11.2954 7.49989C10.5914 7.48284 9.90912 7.86522 9.5725 8.53623L6.34077 14.9997H1.87494C0.83953 14.9997 0 15.8392 0 16.8746C0 17.9101 0.83953 18.7496 1.87494 18.7496H7.49981C8.21026 18.7496 8.85936 18.3486 9.177 17.7132L11.2497 13.5679V20.6038L14.9995 22.0099L18.7496 20.6034V13.5679L20.8222 17.7132C21.1399 18.3486 21.789 18.7496 22.4994 18.7496H28.1243C29.1597 18.7496 29.9992 17.9101 29.9992 16.8746C29.9992 15.8392 29.1598 14.9997 28.1244 14.9997Z" fill="#fff"/>
                                </g>
                                <defs>
                                <clipPath id="clip2">
                                <rect width="30" height="30" fill="white"/>
                                </clipPath>
                                </defs>
                            </svg>
                        </span>
                        <h4 class="fs-20 text-black mb-0">Yoga</h4>
                    </div>
                    <div class="dropdown">
                        <button type="button" class="btn btn-primary light btn-md" data-toggle="dropdown" aria-expanded="false">
                            Newest
                            <i class="fa fa-chevron-down ml-2" aria-hidden="true"></i>
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
                                    <th><span class="font-w600 text-black fs-16">Date</span></th>
                                    <th><span class="font-w600 text-black fs-16">Distance</span></th>
                                    <th><span class="font-w600 text-black fs-16">Time</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <p class="text-black mb-1 font-w600">Sunday</p>
                                        <span class="fs-14">September 2, 2020</span>
                                    </td>
                                    <td>
                                        <p class="text-black mb-1 font-w600">14,2 Km</p>
                                        <span class="fs-14">Target 15Km</span>
                                    </td>
                                    <td>
                                        <p class="text-black mb-1 font-w600">00:53:22”</p>
                                        <span class="fs-14">Target 40mins</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="text-black mb-1 font-w600">Monday</p>
                                        <span class="fs-14">September 3, 2020</span>
                                    </td>
                                    <td>
                                        <p class="text-black mb-1 font-w600">14,2 Km</p>
                                        <span class="fs-14">Target 15Km</span>
                                    </td>
                                    <td>
                                        <p class="text-black mb-1 font-w600">00:53:22”</p>
                                        <span class="fs-14">Target 40mins</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="text-black mb-1 font-w600">Tuesday</p>
                                        <span class="fs-14">September 4, 2020</span>
                                    </td>
                                    <td>
                                        <p class="text-black mb-1 font-w600">14,2 Km</p>
                                        <span class="fs-14">Target 15Km</span>
                                    </td>
                                    <td>
                                        <p class="text-black mb-1 font-w600">00:53:22”</p>
                                        <span class="fs-14">Target 40mins</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="text-black mb-1 font-w600">Wednesday</p>
                                        <span class="fs-14">September 5, 2020</span>
                                    </td>
                                    <td>
                                        <p class="text-black mb-1 font-w600">14,2 Km</p>
                                        <span class="fs-14">Target 15Km</span>
                                    </td>
                                    <td>
                                        <p class="text-black mb-1 font-w600">00:53:22”</p>
                                        <span class="fs-14">Target 40mins</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="text-black mb-1 font-w600">Thursday</p>
                                        <span class="fs-14">September 8, 2020</span>
                                    </td>
                                    <td>
                                        <p class="text-black mb-1 font-w600">14,2 Km</p>
                                        <span class="fs-14">Target 15Km</span>
                                    </td>
                                    <td>
                                        <p class="text-black mb-1 font-w600">00:53:22”</p>
                                        <span class="fs-14">Target 40mins</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="text-black mb-1 font-w600">Friday</p>
                                        <span class="fs-14">September 7, 2020</span>
                                    </td>
                                    <td>
                                        <p class="text-black mb-1 font-w600">14,2 Km</p>
                                        <span class="fs-14">Target 15Km</span>
                                    </td>
                                    <td>
                                        <p class="text-black mb-1 font-w600">00:53:22”</p>
                                        <span class="fs-14">Target 40mins</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="text-black mb-1 font-w600">Saturday</p>
                                        <span class="fs-14">September 8, 2020</span>
                                    </td>
                                    <td>
                                        <p class="text-black mb-1 font-w600">14,2 Km</p>
                                        <span class="fs-14">Target 15Km</span>
                                    </td>
                                    <td>
                                        <p class="text-black mb-1 font-w600">00:53:22”</p>
                                        <span class="fs-14">Target 40mins</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="text-black mb-1 font-w600">Sunday</p>
                                        <span class="fs-14">September 9, 2020</span>
                                    </td>
                                    <td>
                                        <p class="text-black mb-1 font-w600">14,2 Km</p>
                                        <span class="fs-14">Target 15Km</span>
                                    </td>
                                    <td>
                                        <p class="text-black mb-1 font-w600">00:53:22”</p>
                                        <span class="fs-14">Target 40mins</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
</div>
<script>
    $('#datatable').dataTable( {
        // responsive: true
        "scrollX": true
} );
</script>
@endsection