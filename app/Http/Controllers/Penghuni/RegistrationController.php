<?php

namespace App\Http\Controllers\Penghuni;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Room;
use App\Models\RoomTenant;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    public function showRegisterFormTenant()
    {
        $roomId = request()->query('room_id');

        if (!$roomId) {
            return redirect()->route('dashboard.penghuni')->with('error', 'Room ID is required for booking.');
        }

        // Simpan room id ke session untuk dipakai di storeTenant dan createRoomTenant
        session(['selected_room_id' => $roomId]);

        return inertia('Penghuni/RegisterTenant', [
            'room_id' => $roomId,
            'user' => Auth::user(),
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'Registerasi', 'url' => route('penghuni.register', ['room_id' => $roomId])],
                ['label' => 'Pembayaran'],
                ['label' => 'Menunggu Konfirmasi']
            ],
        ]);
    }


    public function storeTenant(Request $request)
    {
        $roomId = session('selected_room_id');
        if (!$roomId) {
            return redirect()->route('dashboard.penghuni')->with('error', 'Room ID is missing in the session.');
        }

        $validatedData = $request->validate([
            'fullname' => 'required|string|max:255',
            'ktp_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $userId = Auth::id(); // Ambil user_id dari user yang login

        // Cek tenant sudah ada berdasarkan user_id
        $existingTenant = Tenant::where('user_id', $userId)->first();
        if ($existingTenant) {
            return redirect()->back()->with('error', 'You already have a tenant registered.');
        }

        if ($request->hasFile('ktp_photo')) {
            $filePath = $request->file('ktp_photo')->store('ktp_photos', 'public');
        } else {
            return back()->withErrors(['ktp_photo' => 'KTP photo is required']);
        }

        // Simpan tenant baru
        $tenant = new Tenant();
        $tenant->user_id = $userId;
        $tenant->fullname = $validatedData['fullname'];
        $tenant->ktp_photo = $filePath;
        $tenant->save();

        // Data untuk insert ke pivot room_tenant
        $roomTenant = new RoomTenant();
        $roomTenant->room_id = $roomId;
        $roomTenant->tenant_id = $tenant->id;
        $roomTenant->start_date = Carbon::now()->toDateString();
        $roomTenant->end_date = null;
        $roomTenant->status = 'active';
        $roomTenant->payee_id = $tenant->id;
        $roomTenant->save();

        // Update status kamar menjadi 'occupied'
        $room = Room::findOrFail($roomId);
        $room->status = 'occupied';
        $room->save();

        // Bersihkan session
        session()->forget('selected_room_id');

        return redirect()->route('penghuni.register-payment', ['roomTenant' => $roomTenant->id])->with('success', 'Tenant registered successfully and room booked. Please proceed to payment.');
    }
    public function showRegisterFormPayment(Request $request)
    {
        $roomTenant = RoomTenant::with('tenant', 'room')->find($request->roomTenant);
        // dd($roomTenant);
        return inertia('Penghuni/RegisterPayment', [
            'roomTenant' => $roomTenant,

            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'Registerasi'],
                ['label' => 'Pembayaran', 'url' => route('penghuni.register-payment', ['roomTenant' => $roomTenant->id])],
                ['label' => 'Menunggu Konfirmasi']
            ],
        ]);
    }

    public function storeRegisterPayment(Request $request)
    {
        $validated = $request->validate([
            'room_tenant_id' => 'required|exists:room_tenants,id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_status' => 'required|in:unpaid,pending,completed,failed',
            'payment_method' => 'required|string|max:255',
            'penalty_fee' => 'nullable|numeric|min:0',
            'payment_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',

        ]);

        if ($request->hasFile('payment_photo')) {
            $filePath = $request->file('payment_photo')->store('payment_photos', 'public');
        } else {
            return back()->withErrors(['payment_photo' => 'Payment photo is required']);
        }

        // Simpan data pembayaran
        $payment = new Payment();
        $payment->room_tenant_id = $validated['room_tenant_id'];
        $payment->amount = $validated['amount'];
        $payment->payment_date = Carbon::parse($validated['payment_date'])->toDateString();
        $payment->payment_status = $validated['payment_status'];
        $payment->payment_method = $validated['payment_method'];
        $payment->penalty_fee = $validated['penalty_fee'] ?? 0;
        $payment->payment_photo = $filePath;
        $payment->billing_period = Carbon::now()->toDateString(); // Set billing period to current date in dd-mm-yyyy format

        $payment->save();

        return redirect()->route('dashboard.penghuni')->with('success', 'Payment registered successfully. Please wait for confirmation.');
    }
}
