<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressDefaultRequest;
use App\Http\Requests\AddressStoreRequest;
use App\Models\Address;
use App\Models\Province; // Import model Province
use App\Models\City;     // Import model City
use App\Models\District; // Import model District
use App\Models\Village;  // Import model Village
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            return view('ManageAddress', compact('user'));
        } else {
            return redirect()->route('login');
        }
    }

    public function setDefaultAddress(AddressDefaultRequest $request)
    {
        $user = Auth::user();
        $loggedInUserId = $user->userId;

        $requestedAddressId = $request->input('address_id');

        try {
            // Nonaktifkan semua alamat utama pengguna saat ini
            Address::where('userId', $loggedInUserId)
                ->where('is_default', true)
                ->update(['is_default' => false]);

            // Set alamat yang dipilih menjadi utama
            $newDefaultAddress = Address::where('userId', $loggedInUserId)
                ->where('addressId', $requestedAddressId)
                ->firstOrFail();
            $newDefaultAddress->is_default = true;
            $newDefaultAddress->save();

            return response()->json(['success' => true, 'message' => 'Alamat utama berhasil diatur.']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Alamat tidak ditemukan atau bukan milik Anda.'], 404);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan internal: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('addAddress');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddressStoreRequest $request)
    {
        $newAddress = new Address();
        $newAddress->userId = Auth::id();

        // Ambil nama berdasarkan ID yang dikirim
        $newAddress->provinsi = Province::find($request->provinsi_id)->name;
        $newAddress->kota = City::find($request->kota_id)->name;
        $newAddress->kecamatan = District::find($request->kecamatan_id)->name;
        $newAddress->kelurahan = Village::find($request->kelurahan_id)->name;

        $newAddress->jalan = $request->jalan;
        $newAddress->kode_pos = $request->kode_pos;
        $newAddress->notes = $request->notes;
        $newAddress->recipient_name = $request->recipient_name;
        $newAddress->recipient_phone = $request->recipient_phone;
        $newAddress->is_default = 0; // Default to not default, user can set it later

        $newAddress->save();

        logActivity('Successfully', 'Added', "New Address");
        return redirect('/manage-address')->with('success', 'Alamat berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Address $address)
    {
        if (Auth::id() !== $address->userId) {
            return redirect()->route('manage-address')->with('error', 'Unauthorized action.');
        }

        return view('editAddress', compact('address'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AddressStoreRequest $request, Address $address)
    {
        if (Auth::id() !== $address->userId) {
            abort(403, 'Unauthorized action.');
        }

        // Ambil nama berdasarkan ID yang dikirim
        $address->provinsi = Province::find($request->provinsi_id)->name;
        $address->kota = City::find($request->kota_id)->name;
        $address->kecamatan = District::find($request->kecamatan_id)->name;
        $address->kelurahan = Village::find($request->kelurahan_id)->name;

        $address->jalan = $request->jalan;
        $address->kode_pos = $request->kode_pos;
        $address->notes = $request->notes;
        $address->recipient_name = $request->recipient_name;
        $address->recipient_phone = $request->recipient_phone;

        $address->save();

        return redirect('/manage-address')->with('update_success', 'Alamat berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address)
    {
        if (Auth::id() !== $address->userId) {
            abort(403, 'Unauthorized action.');
        }

        // Anda bisa mengaktifkan kembali validasi ini jika tidak ingin alamat default bisa dihapus
        if ($address->is_default) {
             return redirect('/manage-address')->with('error', 'Tidak dapat menghapus alamat utama. Silakan atur alamat lain sebagai utama terlebih dahulu.');
        }

        $address->delete();

        return redirect('/manage-address')->with('delete_success', 'Alamat berhasil dihapus.');
    }
}