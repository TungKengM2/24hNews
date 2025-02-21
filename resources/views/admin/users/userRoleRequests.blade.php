<table>
    <thead>
    <tr>
        <th>User</th>
        <th>Requested Role</th>
        <th>Remarks</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($requests as $request)
        <tr>
            <td>{{ $request->user->username }}</td>
            <td>{{ $request->requested_role }}</td>
            <td>{{ $request->remarks }}</td>
            <td>
                <form action="{{ route('admin.approve-role-upgrade', $request->approval_id) }}" method="POST"
                      style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-success">Approve</button>
                </form>
                <form action="{{ route('admin.reject-role-upgrade', $request->approval_id) }}" method="POST"
                      style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger">Reject</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
