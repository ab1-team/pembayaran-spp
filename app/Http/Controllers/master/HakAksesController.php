<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;



class HakAksesController extends Controller
{
    public function index()
    {
        $users = User::orderBy('nama')->get();
        $menus = DB::table('menu')
            ->where('status', 'aktif')
            ->orderBy('group')
            ->orderBy('urutan')
            ->get();

        $byId = $menus->keyBy('id');
        $menus = $menus->map(function ($m) use ($byId) {
            if (is_null($m->group) && $m->parent_id && isset($byId[$m->parent_id])) {
                $m->group = $byId[$m->parent_id]->group;
            }
            return $m;
        });

        $grouped = $menus->groupBy(fn ($m) => $m->group ?: 'Lainnya')->map(function ($items) {
            return [
                'parents' => $items->whereNull('parent_id')->values(),
                'children' => $items->whereNotNull('parent_id')->groupBy('parent_id'),
            ];
        });

        $jabatans = DB::table('jabatan')->orderBy('nama_jabatan')->get(['id', 'nama_jabatan']);

        return view('master.hak-akses', compact('users', 'grouped', 'jabatans'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:120'],
            'username' => ['required', 'string', 'max:60', 'alpha_dash', Rule::unique('users', 'username')],
            'email' => ['nullable', 'email', 'max:120'],
            'password' => ['required', 'string', 'min:6', 'max:60'],
            'jabatan' => ['nullable'],
            'telepon' => ['nullable', 'string', 'max:30'],
            'menu_ids' => ['array'],
        ]);

        $menuIds = array_map('intval', (array) ($data['menu_ids'] ?? []));
        $jabatanId = is_numeric($data['jabatan'] ?? null) ? (int) $data['jabatan'] : null;
        $jabatanNama = $jabatanId ? DB::table('jabatan')->where('id', $jabatanId)->value('nama_jabatan') : null;

        $user = new User();
        $user->nama = $jabatanNama ?: $data['nama'];
        $user->username = $data['username'];
        $user->email = $data['email'] ?? null;
        $user->password = $data['password'];
        $user->jabatan = $jabatanId;
        $user->telepon = $data['telepon'] ?? null;
        $user->hak_akses = array_values(array_unique($menuIds));
        $user->save();

        return response()->json([
            'ok' => true,
            'count' => count($user->hak_akses),
            'user' => [
                'id' => $user->id,
                'nama' => $user->nama,
                'username' => $user->username,
            ],
        ]);
    }

    public function update(Request $request, User $user)
    {
        $menuIds = array_map('intval', (array) $request->input('menu_ids', []));
        $user->hak_akses = array_values(array_unique($menuIds));

        if (is_numeric($user->jabatan)) {
            $jabatanNama = DB::table('jabatan')->where('id', (int) $user->jabatan)->value('nama_jabatan');
            if ($jabatanNama) {
                $user->nama = $jabatanNama;
            }
        }

        $user->save();

        return response()->json(['ok' => true, 'count' => count($user->hak_akses)]);
    }
}
