<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
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
        $reservas = Reservation::all();
        return $this->sendResponse('success', 200, 'Lista de reservas recuperada', $reservas);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'usuario'      => 'required|string|max:255',
            'gym_class_id' => 'required|integer',
            'fecha'        => 'required|date_format:Y-m-d'
        ]);

        if ($validator->fails()) {
            return $this->sendResponse('error', 400, 'Error de validación', $validator->errors());
        }

        $reserva = Reservation::create($request->all());
        return $this->sendResponse('success', 201, 'Reserva creada correctamente', $reserva);
    }

    public function show($id)
    {
        $reserva = Reservation::find($id);
        if (!$reserva) {
            return $this->sendResponse('error', 404, 'La reserva no existe');
        }
        return $this->sendResponse('success', 200, 'Reserva encontrada', $reserva);
    }

    public function update(Request $request, $id)
    {
        $reserva = Reservation::find($id);
        if (!$reserva) {
            return $this->sendResponse('error', 404, 'No se puede actualizar una reserva inexistente');
        }

        $reserva->update($request->all());
        return $this->sendResponse('success', 200, 'Reserva actualizada con éxito', $reserva);
    }

    public function destroy($id)
    {
        $reserva = Reservation::find($id);
        if (!$reserva) {
            return $this->sendResponse('error', 404, 'No se puede eliminar una reserva que no existe');
        }

        $reserva->delete();
        return $this->sendResponse('success', 200, 'Reserva eliminada correctamente');
    }
}
