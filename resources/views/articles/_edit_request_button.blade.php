@if(auth()->check() && $article->user_id == auth()->id() && in_array($article->status, ['pending', 'approved']))
    @if($article->hasEditRequest())
        <button class="btn btn-secondary" disabled>
            <i class="fas fa-clock"></i> Đang chờ phê duyệt chỉnh sửa
        </button>
    @else
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editRequestModal">
            <i class="fas fa-edit"></i> Xin phép chỉnh sửa
        </button>

        <!-- Modal xin phép chỉnh sửa -->
        <div class="modal fade" id="editRequestModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('articles.edit-request.store', $article->id) }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Xin phép chỉnh sửa bài viết</h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="reason">Lý do chỉnh sửa</label>
                                <textarea name="reason" id="reason" class="form-control" rows="3" required></textarea>
                                <small class="form-text text-muted">Vui lòng nêu rõ lý do bạn muốn chỉnh sửa bài viết này.</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Gửi yêu cầu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endif
