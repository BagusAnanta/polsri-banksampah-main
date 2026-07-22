@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="profile card card-body px-3 pt-3 pb-0">
            <div class="profile-head">
                <div class="photo-content">
                    <div class="cover-photo rounded"></div>
                </div>
                <div class="profile-info">
                    <div class="profile-photo">
                        <img src="{{asset('ui/images/profile/'.($user->avatar ?? 'user.png'))}}" width="100" class="img-fluid rounded-circle" alt="">
                    </div>
                    <div class="profile-details">
                        <div class="profile-name px-3 pt-2">
                            <h4 class="text-primary mb-0">{{ucfirst($user->username)}}</h4>
                            <p>Username</p>
                        </div>
                        <div class="profile-email px-2 pt-2">
                            <h4 class="text-muted mb-0">{{$user->email}}</h4>
                            <p>Email</p>
                        </div>
                        <div class="action-button ms-auto">
                            @if (auth()->user()->getRoleNames()[0] == 'Job Seeker')
                            <a href="{{route('users.edit', $user->id)}}" class="btn btn-primary">Edit Profile</a>
                            @else
                            <a href="{{route('users.edit-recruiter', $user->id)}}" class="btn btn-primary">Edit Profile</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card h-auto">
            <div class="card-body">
                <div class="profile-tab">
                    <div class="custom-tab-1">
                        <div class="tab-content">
                            <div id="about-me" class="tab-pane fade active show">
                                @if (auth()->user()->getRoleNames()[0] == 'Job Seeker')
                                <div class="profile-about-me">
                                    <div class="pt-4 border-bottom-1 pb-3">
                                        <h4 class="text-primary">About Me</h4>
                                        <p class="mb-2">{{$user->bio}}</p>
                                    </div>
                                </div>
                                <div class="profile-skills mb-5">
                                    <h4 class="text-primary mb-2">Skills</h4>
                                    @foreach ($skills as $item)
                                        <a href="javascript:void(0);" class="btn btn-primary light btn-xs mb-1">{{$item->skill}}</a>
                                    @endforeach
                                </div>
                                <div class="profile-educations mb-5">
                                    <h4 class="text-primary mb-2">Education</h4>
                                    @foreach ($educations as $item)
                                    <div class="mb-3">
                                        <h5>{{$item->field_of_study}}</h5>
                                        <a href="javascript:void(0);" class="text-muted pe-3 f-s-16"><i class="flag-icon flag-icon-bd"></i>{{$item->degree}}</a><br>
                                        <a href="javascript:void(0);" class="text-muted pe-3 f-s-16"><i class="flag-icon flag-icon-bd"></i>{{date('Y', strtotime($item->start_date))}} - {{date('Y', strtotime($item->end_date))}}</a>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="profile-lang  mb-5">
                                    <h4 class="text-primary mb-2">Language</h4>
                                    @foreach ($languages as $item)
                                    <a href="javascript:void(0);" class="text-muted pe-3 f-s-16"><i class="flag-icon flag-icon-bd"></i>{{$item->language}}</a>
                                    @endforeach
                                </div>
                                @endif
                                <div class="profile-personal-info">
                                    <h4 class="text-primary mb-4">Personal Information</h4>
                                    <div class="row mb-2">
                                        <div class="col-sm-3 col-5">
                                            <h5 class="f-w-500">Name <span class="pull-end">:</span>
                                            </h5>
                                        </div>
                                        <div class="col-sm-9 col-7"><span>{{ucfirst($user->name)}}</span>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-3 col-5">
                                            <h5 class="f-w-500">Email <span class="pull-end">:</span>
                                            </h5>
                                        </div>
                                        <div class="col-sm-9 col-7"><span>{{$user->email}}</span>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-3 col-5">
                                            <h5 class="f-w-500">Phone <span class="pull-end">:</span>
                                            </h5>
                                        </div>
                                        <div class="col-sm-9 col-7"><span>{{$user->phone}}</span>
                                        </div>
                                    </div>
                                    @if (auth()->user()->getRoleNames()[0] == 'Job Seeker')
                                    <div class="row mb-2">
                                        <div class="col-sm-3 col-5">
                                            <h5 class="f-w-500">Availability <span class="pull-end">:</span></h5>
                                        </div>
                                        <div class="col-sm-9 col-7"><span>{{$user->availability}}</span>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-3 col-5">
                                            <h5 class="f-w-500">Age <span class="pull-end">:</span>
                                            </h5>
                                        </div>
                                        <div class="col-sm-9 col-7"><span>{{$user->age}}</span>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-3 col-5">
                                            <h5 class="f-w-500">Location <span class="pull-end">:</span></h5>
                                        </div>
                                        <div class="col-sm-9 col-7"><span>{{$user->location}}</span>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-3 col-5">
                                            <h5 class="f-w-500">Year Experience <span class="pull-end">:</span></h5>
                                        </div>
                                        <div class="col-sm-9 col-7"><span>{{(!$user->year_experience) ? '' : $user->experience.' Year Experience'}}</span>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-3 col-5">
                                            <h5 class="f-w-500">CV <span class="pull-end">:</span></h5>
                                        </div>
                                        <div class="col-sm-9 col-7">
                                            <a href="{{ url('ui/doc/cv/' . $user->cv) }}" target="__blank">
                                                <span>{{ $user->cv }}</span>
                                            </a>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="replyModal">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Post Reply</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <textarea class="form-control" rows="4">Message</textarea>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Reply</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection