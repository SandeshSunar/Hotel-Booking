<x-mail::message>
# Booking {{ ucfirst($booking->status) }}

Hello {{ $booking->guest_name ?? ($booking->guest ? $booking->guest->name : 'Guest') }},

Your booking for our **{{ $booking->roomType ? $booking->roomType->name : 'Room' }}** has been **{{ $booking->status }}**.

## Booking Details
- **Check-in:** {{ $booking->check_in->format('Y-m-d') }}
- **Check-out:** {{ $booking->check_out->format('Y-m-d') }}
- **Number of Rooms:** {{ $booking->rooms_count }}
- **Guests:** {{ $booking->adults }} Adults, {{ $booking->children ?? 0 }} Children
- **Total Price:** ${{ number_format($booking->total_price, 2) }}

@if($booking->status == 'confirmed')
We are looking forward to hosting you!
@elseif($booking->status == 'cancelled')
We are sorry to see this booking cancelled. If you have any questions, please contact us.
@endif

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
