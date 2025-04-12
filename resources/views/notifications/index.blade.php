@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Thông báo</h4>
                </div>

                <div class="card-body">
                    @if($notifications->isEmpty())
                        <div class="alert alert-info">
                            Bạn chưa có thông báo nào.
                        </div>
                    @else
                        <div class="list-group">
                            @foreach($notifications as $notification)
                                <div class="list-group-item list-group-item-action {{ $notification->read_at ? '' : 'bg-light' }}">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">{{ $notification->data['message'] }}</h5>
                                        <small>{{ $notification->created_at->diffForHumans() }}</small>
                                    </div>
                                    
                                    @if(isset($notification->data['type']))
                                        @if($notification->data['type'] === 'article_reported')
                                            <div class="mt-2">
                                                <p class="mb-1">Bài viết của bạn đã bị báo cáo</p>
                                                @if(isset($notification->data['data']['reason']))
                                                    <p class="text-danger mb-1">
                                                        <i class="fa fa-info-circle"></i> Lý do: {{ $notification->data['data']['reason'] }}
                                                    </p>
                                                @endif
                                            </div>
                                        @elseif($notification->data['type'] === 'role_upgrade_rejected')
                                            <div class="mt-2">
                                                <p class="mb-1">Yêu cầu nâng cấp vai trò của bạn đã bị từ chối</p>
                                                @if(isset($notification->data['data']['reason']))
                                                    <p class="text-danger mb-1">
                                                        <i class="fa fa-info-circle"></i> Lý do: {{ $notification->data['data']['reason'] }}
                                                    </p>
                                                @endif
                                            </div>
                                        @endif
                                    @endif

                                    @if(isset($notification->data['link']))
                                        <a href="{{ $notification->data['link'] }}" class="btn btn-sm btn-primary mt-2">
                                            Xem chi tiết
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-3">
                            {{ $notifications->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 