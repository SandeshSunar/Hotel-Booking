<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking {{ ucfirst($booking->status) }}</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f4f7f6; color: #333333;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color: #f4f7f6; padding: 40px 0;">
        <tr>
            <td align="center">
                <table width="600" border="0" cellspacing="0" cellpadding="0" style="background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 8px 24px rgba(0,0,0,0.05);">
                    <!-- Header -->
                    <tr>
                        @php
                            $headerBg = '#2563eb';
                            $statusText = 'Confirmed';
                            if($booking->status == 'pending') {
                                $headerBg = '#f59e0b';
                                $statusText = 'Pending Confirmation';
                            } elseif($booking->status == 'cancelled') {
                                $headerBg = '#ef4444';
                                $statusText = 'Cancelled';
                            }
                        @endphp
                        <td align="center" style="background-color: {{ $headerBg }}; padding: 40px 20px;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 28px; font-weight: 600; letter-spacing: 1px;">{{ config('app.name') }}</h1>
                            <p style="color: rgba(255,255,255,0.9); margin: 10px 0 0 0; font-size: 16px;">Your Booking is {{ $statusText }}</p>
                        </td>
                    </tr>
                    
                    <!-- Body -->
                    <tr>
                        <td style="padding: 40px 40px 20px 40px;">
                            <h2 style="margin: 0 0 20px 0; font-size: 20px; color: #1e293b;">Hello {{ $booking->guest_name ?? ($booking->guest ? $booking->guest->name : 'Guest') }},</h2>
                            
                            <p style="margin: 0 0 30px 0; font-size: 16px; line-height: 1.6; color: #475569;">
                                @if($booking->status == 'confirmed')
                                    Great news! Your reservation for our <strong>{{ $booking->roomType ? $booking->roomType->name : 'Room' }}</strong> has been confirmed. We are thrilled to host you and ensure you have a wonderful stay.
                                @elseif($booking->status == 'pending')
                                    We have received your reservation request for our <strong>{{ $booking->roomType ? $booking->roomType->name : 'Room' }}</strong>. Our team is currently reviewing it and will send you a confirmation shortly.
                                @else
                                    We're sorry to inform you that your reservation for our <strong>{{ $booking->roomType ? $booking->roomType->name : 'Room' }}</strong> has been cancelled. If you have any questions, please reach out to us.
                                @endif
                            </p>
                            
                            <!-- Booking Details Card -->
                            <table width="100%" border="0" cellspacing="0" cellpadding="20" style="background-color: #f8fafc; border-radius: 8px; border: 1px solid #e2e8f0; margin-bottom: 30px;">
                                <tr>
                                    <td>
                                        <h3 style="margin: 0 0 15px 0; font-size: 14px; text-transform: uppercase; color: #64748b; letter-spacing: 0.5px;">Reservation Details</h3>
                                        
                                        <table width="100%" border="0" cellspacing="0" cellpadding="8">
                                            <tr>
                                                <td width="40%" style="color: #64748b; font-size: 15px;">Check-in</td>
                                                <td width="60%" style="color: #0f172a; font-size: 15px; font-weight: 600;">{{ $booking->check_in->format('M d, Y') }}</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #64748b; font-size: 15px;">Check-out</td>
                                                <td style="color: #0f172a; font-size: 15px; font-weight: 600;">{{ $booking->check_out->format('M d, Y') }}</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #64748b; font-size: 15px;">Rooms</td>
                                                <td style="color: #0f172a; font-size: 15px; font-weight: 600;">{{ $booking->rooms_count }}</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #64748b; font-size: 15px;">Guests</td>
                                                <td style="color: #0f172a; font-size: 15px; font-weight: 600;">{{ $booking->adults }} Adults{{ $booking->children > 0 ? ', ' . $booking->children . ' Children' : '' }}</td>
                                            </tr>
                                            <tr>
                                                <td style="border-top: 1px solid #cbd5e1; padding-top: 15px; color: #64748b; font-size: 15px;">Total Amount</td>
                                                <td style="border-top: 1px solid #cbd5e1; padding-top: 15px; color: #10b981; font-size: 18px; font-weight: 700;">${{ number_format($booking->total_price, 2) }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            
                            <p style="margin: 0; font-size: 16px; line-height: 1.6; color: #475569;">
                                If you need to make any changes or have special requests, please reply directly to this email.
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td align="center" style="background-color: #f1f5f9; padding: 30px; border-top: 1px solid #e2e8f0;">
                            <p style="margin: 0; font-size: 14px; color: #64748b;">
                                Warm regards,<br>
                                <strong>The {{ config('app.name') }} Team</strong>
                            </p>
                            <p style="margin: 15px 0 0 0; font-size: 12px; color: #94a3b8;">
                                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
