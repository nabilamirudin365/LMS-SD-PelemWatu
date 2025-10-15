<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\Kelas;

class UserController extends Controller
{
    /**
     * Menampilkan daftar semua user.
     */
    // Di dalam file UserController.php

public function index(Request $request)
{
    // 1. Ambil input filter dan search dari request
    $selectedKelasId = $request->input('kelas_id');
    $searchKeyword = $request->input('search');
    $selectedRole = $request->input('role');

    // 2. Query user, gunakan with('kelas') untuk Eager Loading (lebih efisien)
    $usersQuery = User::with('kelas')->where('id', '!=', auth()->id());

    // 3. Terapkan filter kelas jika dipilih
    if ($selectedKelasId) {
        $usersQuery->whereHas('kelas', function ($query) use ($selectedKelasId) {
            $query->where('kelas.id', $selectedKelasId);
        });
    }
    if ($selectedRole) {
        $usersQuery->where('role', $selectedRole);
    }
    
    // 4. Terapkan filter search jika ada keyword yang diinput
    if ($searchKeyword) {
        $usersQuery->where('name', 'like', '%' . $searchKeyword . '%');
    }
    
    // 5. Ambil hasil query dengan paginasi
    // Gunakan appends() agar parameter filter & search tetap ada saat pindah halaman
    $users = $usersQuery->orderBy('name')->paginate(10)->appends($request->query());
    
    // 6. Ambil semua data kelas untuk dropdown filter
    $kelasList = Kelas::orderBy('nama_kelas')->get();

    // 7. Kirim semua data yang dibutuhkan ke view
    return view('guru.users.index', compact('users', 'kelasList', 'selectedKelasId', 'searchKeyword','selectedRole'));
}

    /**
     * Menampilkan form untuk membuat user baru.
     */
    public function create()
{
    $kelasList = Kelas::orderBy('nama_kelas')->get();
    return view('guru.users.create', compact('kelasList'));
}

    /**
     * Menyimpan user baru ke database.
     */
    public function store(Request $request)
{
    // 1. Validasi Input
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'role' => 'required|in:guru,murid',
        // Aturan ini berarti: Abaikan validasi field ini jika rolenya guru.
        // Jika bukan guru (artinya murid), maka field ini wajib ada dan harus ada di tabel kelas.
        'kelas_id' => 'exclude_if:role,guru|required|exists:kelas,id',
        'password' => 'required|string|min:3|confirmed',
    ]);

    // 2. Buat User Baru
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'role' => $request->role,
        'password' => Hash::make($request->password),
    ]);

    // 3. Hubungkan user dengan kelas jika rolenya murid
    if ($request->role == 'murid' && $request->kelas_id) {
        // attach() digunakan untuk relasi Many-to-Many
        $user->kelas()->attach($request->kelas_id);
    }

    // 4. Redirect kembali dengan pesan sukses
    return redirect()->route('users.index')->with('success', 'User baru berhasil ditambahkan.');
}

    /**
     * Menampilkan detail satu user.
     */
    public function show(User $user)
    {
        // PERUBAHAN DI SINI
        return view('guru.users.show', compact('user'));
    }

    /**
     * Menampilkan form untuk mengedit user.
     */
    public function edit(User $user)
{
    $kelasList = Kelas::orderBy('nama_kelas')->get();
    return view('guru.users.edit', compact('user', 'kelasList'));
}

    /**
     * Memperbarui data user di database.
     */
    public function update(Request $request, User $user)
{
    // Validasi input
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => [
            'required',
            'string',
            'email',
            'max:255',
            Rule::unique('users')->ignore($user->id),
        ],
        // 'kelas_id' hanya wajib jika user yang diedit adalah murid
        'kelas_id' => 'required_if:role,murid|exists:kelas,id',
        'password' => 'nullable|string|min:3|confirmed',
    ]);

    // Siapkan data untuk diupdate (tanpa password dan role)
    $data = [
        'name' => $request->name,
        'email' => $request->email,
    ];

    // Jika password diisi, maka update passwordnya
    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }
    
    $user->update($data);

    // Jika yang diedit adalah murid dan ada input kelas_id, perbarui relasi kelasnya
    if ($user->role == 'murid' && $request->kelas_id) {
        // sync() akan menghapus relasi lama dan menggantinya dengan yang baru
        $user->kelas()->sync([$request->kelas_id]);
    }

    return redirect()->route('users.index')->with('success', 'Data user berhasil diperbarui.');
}

    /**
     * Menghapus user dari database.
     */
    public function destroy(User $user)
    {
        if ($user->id == auth()->id()) {
            return back()->with('error', 'Anda tidak bisa menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}