<div class="card p-3">
  <h6>Notifications</h6>
  <ul class="list-unstyled mb-0">
    @foreach($notifications ?? [] as $n)
      <li class="mb-2">
        <small class="text-muted">{{ $n->created_at->diffForHumans() }}</small>
        <div>{{ Str::limit($n->data['message'] ?? $n->data['title'] ?? 'Notification', 120) }}</div>
      </li>
    @endforeach

    @if(empty($notifications) || count($notifications)===0)
      <li>No notifications.</li>
    @endif
  </ul>
  <div class="mt-2">
    <a href="{{ route('vendor.notifications.index') }}" class="btn btn-sm btn-outline-primary">See all</a>
  </div>
</div>
