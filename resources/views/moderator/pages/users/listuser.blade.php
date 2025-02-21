<div class="container">
    <h1>Danh Sách Yêu Cầu Nâng Cấp Vai Trò</h1>

    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>User ID</th>
            <th>Requested Role</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($approvals as $approval)
            <tr>
                <td>{{ $approval->approval_id }}</td>
                <td>{{ $approval->user_id }}</td>
                <td>{{ $approval->requested_role }}</td>
                <td>{{ $approval->status }}</td>
                <td>
                    <form action="{{ route('approve.upgrade', $approval->approval_id) }}" method="POST"
                          style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-success">Approve</button>
                    </form>
                    <form action="{{ route('reject.upgrade', $approval->approval_id) }}" method="POST"
                          style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger">Reject</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
