<?php

namespace App\Http\Controllers;

use App\Models\GymClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GymClassController extends Controller
{
    private function sendResponse($status, $code, $message, $data = null)
    {
        return response()->json([
            'status'  => $status,
            'code'    => $code,
            'message' => $message,
            'data'    => $data
        ], $code);
    }

    public function index()
    {
        $clases = GymClass::all();
        return $this->sendResponse('success', 200, 'Lista de clases recuperada', $clases);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre'           => 'required|string|max:255',
            'instructor'       => 'required|string',
            'capacidad_maxima' => 'required|integer',
            'horario'          => 'required|string'
        ]);

        if ($validator->fails()) {
            return $this->sendResponse('error', 400, 'Error de validación', $validator->errors());
        }

        $clase = GymClass::create($request->all());
        return $this->sendResponse('success', 201, 'Clase creada correctamente', $clase);
    }

    public function show($id)
    {
        $clase = GymClass::with('reservations')->find($id);
        if (!$clase) {
            return $this->sendResponse('error', 404, 'La clase no existe');
        }
        return $this->sendResponse('success', 200, 'Clase encontrada con sus reservas', $clase);
    }

    public function update(Request $request, $id)
    {
        $clase = GymClass::find($id);
        if (!$clase) {
            return $this->sendResponse('error', 404, 'No se puede actualizar una clase inexistente');
        }

        $clase->update($request->all());
        return $this->sendResponse('success', 200, 'Clase actualizada con éxito', $clase);
    }

    public function destroy($id)
    {
        $clase = GymClass::find($id);
        if (!$clase) {
            return $this->sendResponse('error', 404, 'No se puede eliminar una clase que no existe');
        }

        $clase->delete();
        return $this->sendResponse('success', 200, 'Clase eliminada correctamente');
    }
}
