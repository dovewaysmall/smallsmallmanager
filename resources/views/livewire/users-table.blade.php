<div class="widget-content searchable-container list">
    <div class="card card-body">
        <div class="row">
            <div class="col-md-4 col-xl-3">
                <form class="position-relative">
                    <input 
                        type="text" 
                        class="form-control product-search ps-5" 
                        placeholder="Search Users..." 
                        wire:model.live="searchTerm" />
                    <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                </form>
            </div>
            <div class="col-md-8 col-xl-9 text-end d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">
                <div class="action-btn show-btn">
                    <a href="javascript:void(0)" class="delete-multiple bg-danger-subtle btn me-2 text-danger d-flex align-items-center">
                        <i class="ti ti-trash me-1 fs-5"></i> Delete All Row
                    </a>
                </div>
                <a href="javascript:void(0)" class="btn btn-primary d-flex align-items-center">
                    <i class="ti ti-users text-white me-1 fs-5"></i> Add User
                </a>
            </div>
        </div>
    </div>

    <div class="card card-body">
        <div class="table-responsive">
            <table id="usersTable" class="table search-table align-middle text-nowrap">
                <thead class="header-item">
                    <tr>
                        <th>
                            <div class="n-chk align-self-center text-center">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input primary" id="contact-check-all" />
                                    <label class="form-check-label" for="contact-check-all"></label>
                                    <span class="new-control-indicator"></span>
                                </div>
                            </div>
                        </th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Location</th>
                        <th>Phone</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if($loading)
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center">
                                    <div class="spinner-border text-primary mb-3" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <p class="mb-0 text-muted">Loading users...</p>
                                </div>
                            </td>
                        </tr>
                    @elseif(empty($users) && empty($error))
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center">
                                    <iconify-icon icon="solar:users-group-rounded-line-duotone" class="fs-8 text-primary mb-2"></iconify-icon>
                                    <p class="mb-2 text-muted">Ready to load users</p>
                                    <button wire:click="loadUsers" class="btn btn-primary">
                                        <i class="ti ti-users me-1"></i> Load Users
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @elseif($error)
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center">
                                    <iconify-icon icon="solar:info-circle-line-duotone" class="fs-8 text-danger mb-2"></iconify-icon>
                                    <p class="mb-2 text-danger">{{ $error }}</p>
                                    <button wire:click="loadUsers" class="btn btn-sm btn-outline-primary">
                                        <i class="ti ti-refresh me-1"></i> Retry
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @elseif(empty($filteredUsers))
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center">
                                    <iconify-icon icon="solar:users-group-rounded-line-duotone" class="fs-8 text-muted mb-2"></iconify-icon>
                                    <p class="mb-0 text-muted">
                                        @if(empty($searchTerm))
                                            No users found
                                        @else
                                            No users match "{{ $searchTerm }}"
                                        @endif
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @else
                        @foreach($filteredUsers as $index => $user)
                        <tr class="search-items">
                            <td>
                                <div class="n-chk align-self-center text-center">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input contact-chkbox primary" id="checkbox{{ $index + 1 }}" />
                                        <label class="form-check-label" for="checkbox{{ $index + 1 }}"></label>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('assets/images/profile/user-' . (($index % 10) + 1) . '.jpg')}}" alt="avatar" class="rounded-circle" width="35" />
                                    <div class="ms-3">
                                        <div class="user-meta-info">
                                            <h6 class="user-name mb-0" data-name="{{ ($user['firstName'] ?? '') . ' ' . ($user['lastName'] ?? '') }}">
                                                {{ ($user['firstName'] ?? '') . ' ' . ($user['lastName'] ?? '') }}
                                            </h6>
                                            <span class="user-work fs-3" data-occupation="User">User</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="usr-email-addr" data-email="{{ $user['email'] ?? 'N/A' }}">{{ $user['email'] ?? 'N/A' }}</span>
                            </td>
                            <td>
                                <span class="usr-location" data-location="N/A">N/A</span>
                            </td>
                            <td>
                                <span class="usr-ph-no" data-phone="{{ $user['phone'] ?? 'N/A' }}">{{ $user['phone'] ?? 'N/A' }}</span>
                            </td>
                            <td>
                                <div class="action-btn">
                                    <a href="javascript:void(0)" class="text-primary edit">
                                        <i class="ti ti-eye fs-5"></i>
                                    </a>
                                    <a href="javascript:void(0)" class="text-dark delete ms-2">
                                        <i class="ti ti-trash fs-5"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        
        @if(!$loading && !$error && !empty($filteredUsers))
        <div class="d-flex justify-content-between align-items-center mt-3">
            <small class="text-muted">
                Showing {{ count($filteredUsers) }} of {{ count($users) }} users
                @if(!empty($searchTerm))
                    (filtered)
                @endif
            </small>
        </div>
        @endif
    </div>
</div>
