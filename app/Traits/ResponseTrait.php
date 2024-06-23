<?php
namespace App\Traits;

trait ResponseTrait {

    public function response($status, $message = null, $data = null, $errors = null) {

        if ($status === true && $message === null) {
            $message = "la réponse est revenue avec succès";
        } elseif ($status === false && $message === null) {
            $message ="Quelque chose s'est passé, il y a une erreur";
        }

        return [
            'status' => $status,
            'message' => $message,
            'data' => $data,
            'errors' => $errors,
        ];
    }

}
