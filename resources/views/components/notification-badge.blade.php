@props(['count'])

@if($count > 0)
    <span class="badge badge-danger" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); font-size: 11px; padding: 3px 6px; border-radius: 10px; background: #ff0000; color: white; min-width: 20px; text-align: center; line-height: 1;">
        {{ $count }}
    </span>
@endif
