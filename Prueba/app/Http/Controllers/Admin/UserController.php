<?php
// app/Http/Controllers/Admin/UserController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Country;
use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        
        // Filtro de búsqueda
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('cedula', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $countries = Country::all();
        return view('admin.users.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'cedula' => 'required|string|max:11',
            'phone' => 'nullable|digits:10',
            'birth_date' => 'required|date|before_or_equal:-18 years',
            'city_id' => 'required|exists:cities,id',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $validated['role'] = 'user';
        $validated['identifier'] = mt_rand(100000, 999999); // Generar identificador único

        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'Usuario creado exitosamente.');
    }

    public function edit(User $user)
    {
        $countries = Country::all();
        
        // 🔥 CARGAR ESTADOS Y CIUDADES BASADO EN LA CIUDAD ACTUAL DEL USUARIO
        $states = [];
        $cities = [];
        
        if ($user->city) {
            $states = State::where('country_id', $user->city->state->country_id)->get();
            $cities = City::where('state_id', $user->city->state_id)->get();
        }
        
        return view('admin.users.edit', compact('user', 'countries', 'states', 'cities'));
    }

    public function update(Request $request, User $user)
    {
        // 🔥 VALIDACIÓN COMPLETA CON TODOS LOS CAMPOS
        $rules = [
            'name' => 'required|string|max:100',
            'phone' => 'nullable|digits:10',
            'birth_date' => 'required|date|before_or_equal:-18 years',
            'country_id' => 'required|exists:countries,id',
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
        ];

        // 🔥 VALIDAR PASSWORD SOLO SI SE PROPORCIONA
        if ($request->filled('password')) {
            $rules['password'] = 'min:8|confirmed';
        }

        $validated = $request->validate($rules);

        // 🔥 PREPARAR DATOS PARA ACTUALIZAR
        $updateData = [
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'birth_date' => $validated['birth_date'],
            'city_id' => $validated['city_id'],
        ];

        // ACTUALIZAR PASSWORD SOLO SI SE PROPORCIONA
        if ($request->filled('password')) {
            $updateData['password'] = bcrypt($validated['password']);
        }

        // DEBUG: Ver qué datos se van a actualizar
        Log::info('Actualizando usuario:', $updateData);
        
        $user->update($updateData);

        return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado exitosamente.');
    }


    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'No puedes eliminar tu propio usuario.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado exitosamente.');
    }

    public function getStates(Request $request)
    {
        $countryId = $request->country_id;
        $states = \App\Models\State::where('country_id', $countryId)->get();
        return response()->json($states);
    }

    public function getCities(State $state)
    {
        $cities = $state->cities;
        return response()->json($cities);
    }
}