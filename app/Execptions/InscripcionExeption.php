<?php

namespace App\Exceptions;

use Exception;

class InscripcionException extends Exception
{
    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function render($request)
    {
        if ($request->expectsJson() || $request->header('X-Livewire')) {
            return response()->json([
                'error' => true,
                'message' => $this->getMessage()
            ], 422);
        }

        return back()->withErrors([
            'inscripcion' => $this->getMessage()
        ])->withInput();
    }

    public function report()
    {
        return false;
    }
}