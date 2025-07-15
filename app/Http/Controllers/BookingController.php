<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use App\Models\Venue;

class BookingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get user bookings with related data
        $bookings = $user->bookings()
            ->with(['venue.sport', 'payment'])
            ->orderBy('booking_date', 'desc')
            ->get();
        
        // Update booking statuses based on current time for confirmed bookings
        $this->updateBookingStatuses($bookings);
        
        // Group bookings by status - use the dynamic status
        $activeBookings = $bookings->filter(function($booking) {
            $currentStatus = $booking->getCurrentStatus();
            return in_array($currentStatus, ['confirmed', 'on_going']);
        });
        
        $pendingBookings = $bookings->where('status', 'pending');
        $completedBookings = $bookings->filter(function($booking) {
            return $booking->getCurrentStatus() === 'completed' || $booking->status === 'completed';
        });
        $cancelledBookings = $bookings->where('status', 'cancelled');
        
        return view('pesanan', compact('bookings', 'activeBookings', 'pendingBookings', 'completedBookings', 'cancelledBookings'));
    }
    
    /**
     * Update booking statuses based on current time
     */
    private function updateBookingStatuses($bookings)
    {
        foreach ($bookings as $booking) {
            if ($booking->status === 'confirmed') {
                $currentStatus = $booking->getCurrentStatus();
                
                // If the booking should be completed, update it in the database
                if ($currentStatus === 'completed' && $booking->status !== 'completed') {
                    $booking->update(['status' => 'completed']);
                }
            }
        }
    }
    
    public function cancel(Request $request, $bookingId)
    {
        $booking = Auth::user()->bookings()->findOrFail($bookingId);
        
        if ($booking->status === 'confirmed' || $booking->status === 'pending') {
            $booking->update(['status' => 'cancelled']);
            return redirect()->route('pesanan')->with('success', 'Booking berhasil dibatalkan');
        }
        
        return redirect()->route('pesanan')->with('error', 'Booking tidak dapat dibatalkan');
    }

    public function store(Request $request, Venue $venue)
    {
        $request->validate([
            'booking_date' => 'required|date|after_or_equal:today',
            'selected_slots' => 'required|string',
            'duration' => 'required|integer|min:1',
        ]);

        // Parse selected slots from JSON
        $selectedSlots = json_decode($request->selected_slots, true);
        
        if (empty($selectedSlots)) {
            return redirect()->back()->with('error', 'Silakan pilih minimal satu slot waktu');
        }

        // Validate duration matches selected slots count
        if (count($selectedSlots) != $request->duration) {
            return redirect()->back()->with('error', 'Durasi tidak sesuai dengan jumlah slot yang dipilih');
        }

        // Sort slots to ensure chronological order
        sort($selectedSlots);

        // Get start and end times
        $startTime = $selectedSlots[0];
        $lastSlot = end($selectedSlots);
        $endTime = date('H:i', strtotime($lastSlot . ' + 1 hour'));

        // Check if all slots are available
        foreach ($selectedSlots as $slot) {
            $existingBooking = Booking::where('venue_id', $venue->id)
                ->where('booking_date', $request->booking_date)
                ->where('start_time', '<=', $slot)
                ->where('end_time', '>', $slot)
                ->where('status', '!=', 'cancelled')
                ->first();

            if ($existingBooking) {
                return redirect()->back()->with('error', 'Slot waktu ' . $slot . ' sudah dibooking oleh orang lain');
            }
        }

        // Check for overlapping slots within selected slots (to ensure they are consecutive if needed)
        // For now, we allow non-consecutive slots as per requirements

        // Calculate total price
        $totalPrice = $venue->price_per_hour * count($selectedSlots);

        // Create booking
        $booking = Booking::create([
            'user_id' => auth()->id(),
            'venue_id' => $venue->id,
            'booking_date' => $request->booking_date,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'duration_hours' => count($selectedSlots),
            'total_price' => $totalPrice,
            'status' => 'pending',
            'payment_status' => 'pending',
            'booking_code' => 'LAP-' . strtoupper(uniqid()),
            'selected_time_slots' => $selectedSlots
        ]);

        return redirect()->route('booking.checkout', $booking)->with('success', 'Booking berhasil dibuat! Silakan lakukan pembayaran.');
    }

    public function checkout(Booking $booking)
    {
        // Ensure user can only access their own booking
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        // Check if booking is still valid (not expired, cancelled, etc.)
        if ($booking->status === 'cancelled') {
            return redirect()->route('pesanan')->with('error', 'Booking sudah dibatalkan.');
        }

        if ($booking->status === 'confirmed') {
            return redirect()->route('pesanan')->with('info', 'Booking sudah terkonfirmasi.');
        }

        $venue = $booking->venue->load('sport');
        $user = auth()->user()->load('profile');

        return view('booking-checkout', compact('booking', 'venue', 'user'));
    }

    public function processPayment(Request $request, Booking $booking)
    {
        // Ensure user can only process payment for their own booking
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'payment_method' => 'required|in:transfer,ewallet,credit_card',
            'bank_name' => 'required_if:payment_method,transfer',
            'ewallet_type' => 'required_if:payment_method,ewallet'
        ]);

        // For now, we'll simulate payment processing
        // In real implementation, this would integrate with payment gateway

        $booking->update([
            'status' => 'confirmed',
            'payment_status' => 'paid'
        ]);

        // Update user profile statistics
        $userProfile = auth()->user()->profile;
        if ($userProfile) {
            $userProfile->increment('total_bookings');
            $userProfile->increment('total_points', 10); // Award 10 points per booking
        }

        return redirect()->route('booking.payment.success')->with('success', 'Pembayaran berhasil! Booking telah dikonfirmasi.');
    }

    public function show($bookingId)
    {
        $booking = Auth::user()->bookings()
            ->with(['venue.sport', 'payment'])
            ->findOrFail($bookingId);

        return view('booking-detail', compact('booking'));
    }

    public function payNow($bookingId)
    {
        $booking = Auth::user()->bookings()->findOrFail($bookingId);
        
        if ($booking->status !== 'pending') {
            return redirect()->route('pesanan')->with('error', 'Booking tidak dalam status pending');
        }

        return redirect()->route('booking.checkout', $booking);
    }

    public function showRatingForm($bookingId)
    {
        $booking = Auth::user()->bookings()
            ->with(['venue.sport'])
            ->findOrFail($bookingId);
        
        if ($booking->status !== 'completed') {
            return redirect()->route('pesanan')->with('error', 'Hanya booking yang sudah selesai yang dapat diberi rating');
        }

        if ($booking->rating) {
            return redirect()->route('pesanan')->with('info', 'Anda sudah memberikan rating untuk booking ini');
        }

        return view('booking-rating', compact('booking'));
    }

    public function submitRating(Request $request, $bookingId)
    {
        $booking = Auth::user()->bookings()->findOrFail($bookingId);
        
        if ($booking->status !== 'completed') {
            return redirect()->route('pesanan')->with('error', 'Hanya booking yang sudah selesai yang dapat diberi rating');
        }

        if ($booking->rating) {
            return redirect()->route('pesanan')->with('error', 'Anda sudah memberikan rating untuk booking ini');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:500'
        ]);

        // Update booking with rating
        $booking->update([
            'rating' => $request->rating,
            'review' => $request->review
        ]);

        // Update venue rating
        $venue = $booking->venue;
        $totalRatings = $venue->bookings()->whereNotNull('rating')->count();
        $averageRating = $venue->bookings()->whereNotNull('rating')->avg('rating');
        
        $venue->update([
            'rating' => round($averageRating, 1),
            'total_reviews' => $totalRatings
        ]);

        // Award points for rating
        $userProfile = auth()->user()->profile;
        if ($userProfile) {
            $userProfile->increment('total_points', 5); // Award 5 points for rating
        }

        return redirect()->route('pesanan')->with('success', 'Rating berhasil diberikan! Terima kasih atas feedback Anda.');
    }

    public function markAsCompleted($bookingId)
    {
        $booking = Auth::user()->bookings()->findOrFail($bookingId);
        
        if ($booking->status !== 'confirmed') {
            return redirect()->route('pesanan')->with('error', 'Booking tidak dalam status confirmed');
        }

        // Check if booking date has passed
        $bookingDateTime = \Carbon\Carbon::parse($booking->booking_date . ' ' . $booking->end_time);
        if ($bookingDateTime->isFuture()) {
            return redirect()->route('pesanan')->with('error', 'Booking belum selesai, tidak dapat di-mark sebagai completed');
        }

        $booking->update(['status' => 'completed']);

        return redirect()->route('pesanan')->with('success', 'Booking berhasil di-mark sebagai selesai');
    }
}
