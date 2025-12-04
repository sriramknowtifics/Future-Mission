
<div class="premium-card">
    <h3 class="premium-title mb-3">My Orders</h3>

    <div class="premium-table-wrapper">
        <table class="table premium-table align-middle">
            <thead>
            <tr>
                <th>Order #</th>
                <th>Date</th>
                <th>Status</th>
                <th>Total</th>
                <th></th>
            </tr>
            </thead>

            <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>
                        <strong>{{ $order->order_number }}</strong>
                        <br>
                        <small class="text-muted">
                            {{ $order->items->count() }} items
                        </small>
                    </td>

                    <td>{{ $order->created_at->format('d M Y') }}</td>

                    <td>
                        <span class="badge status-{{ $order->status }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>

                    <td>
                        <strong>BHD {{ number_format($order->total_amount, 2) }}</strong>
                    </td>

                    <td>
                        <a href="{{ route('account.orders.show', $order->id) }}" 
                           class="premium-btn-sm">
                            View
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">
                        No orders found.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $orders->links() }}
    </div>
</div>

