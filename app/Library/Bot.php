<?php


namespace App\Library;


use Illuminate\Support\Facades\Log;

class Bot
{
    public $stage;
    public $message;
    public $user_message;
    public $status;
    public $type;

    //message errors
    CONST TOS_ERROR = "Lo siento, no entiendo lo que dices. Por favor, response con un sí o un no";
    CONST NAME_ERROR = "Lo siento, no entiendo lo que dices. Por favor, ingrese un nombre válido";
    CONST MENU_SELECT_ERROR = "Lo siento, no entiendo lo que dices. Por favor, ingrese una opción válida de las siguientes: 1.- Nada XD / 2.- Nada XD / 3.- Conseguir premio / 4.- Cancelar participación";
    CONST MENU_WORD_ERROR = "Lo siento, no entiendo lo que dices. Por favor, ingresa la palabra 'menú' para volver al menú";
    CONST GETTING_TICKET_ERROR = "Lo siento, lo que estás mandando no son los números de tu ticket de compra. Por favor, ingrese un ticket válido.";
    CONST GETTING_IMAGE_ERROR = "Lo siento, no te entiendo. Por favor, ingrese la URL de su imagen de INE.";
    CONST PENDING_TO_DELETE_ERROR = "Lo siento, no entiendo lo que dices. Por favor, escriba 'sí' para confirmar su elección de eliminación o 'no' para volver al menú";

    //available responses
    CONST TOS_AVAILABLE_MESSAGES = [
        "SÍ",
        "sí",
        "si",
        "s1",
        "yes",
        "no"
    ];
    CONST MENU_AVAILABLE_MESSAGES = [
        "1" => [
            "1",
            "uno",
            "one"
        ],
        "2" => [
            "2",
            "dos",
            "two"
        ],
        "3" => [
            "3",
            "tres",
            "three"
        ],
        "4" => [
            "4",
            "cuatro",
            "four"
        ]
    ];
    CONST MENU_WORD_AVAILABLE_MESSAGES = [
        "menú",
        "menu",
        "MENU",
        "ménu"
    ];

    public function checkStage($stage)
    {
        $this->stage = $stage;
        return $this;
    }
    public function checkUserMessage($user_message, $message_type)
    {
        $this->user_message = strtolower($user_message);

        if ($this->stage == 'tos') {
            $exists = in_array($this->user_message, self::TOS_AVAILABLE_MESSAGES, TRUE);
            if ($exists === false || $message_type != 'chat') {
                $this->status = 'tos_error';
            } else {
                $this->status = 'tos_next_stage';
            }

        }
        if ($this->stage == 'getting_name') {
            if (is_numeric($this->user_message) || $message_type != 'chat'){
                $this->status = 'name_error';
            } else {
                $this->status = 'getting_name_next_stage';
            }
        }
        if ($this->stage == 'menu_select') {
            if ($message_type != 'chat') {
                $this->status = 'menu_select_error';
            } else {
                $exists_in_1 = in_array($this->user_message, self::MENU_AVAILABLE_MESSAGES["1"], TRUE);
                $exists_in_2 = in_array($this->user_message, self::MENU_AVAILABLE_MESSAGES["2"], TRUE);
                $exists_in_3 = in_array($this->user_message, self::MENU_AVAILABLE_MESSAGES["3"], TRUE);
                $exists_in_4 = in_array($this->user_message, self::MENU_AVAILABLE_MESSAGES["4"], TRUE);

                if ($exists_in_1 === true) {
                    $this->status = 'menu_select_next_stage_as_option_1';
                }
                else if ($exists_in_2 === true) {
                    $this->status = 'menu_select_next_stage_as_option_2';
                }
                else if ($exists_in_3 === true) {
                    $this->status = 'menu_select_next_stage_as_option_3';
                }
                else if ($exists_in_4 === true) {
                    $this->status = 'menu_select_next_stage_as_option_4';
                } else {
                    $this->status = 'menu_select_error';
                }
            }

        }
        if ($this->stage == 'menu_select_as_nothing') {
            if ($message_type != 'chat') {
                $this->status = 'menu_word_error';
            } else {
                $exists = in_array($this->user_message, self::MENU_WORD_AVAILABLE_MESSAGES, TRUE);
                if ($exists === FALSE) {
                    $this->status = 'menu_word_error';
                } else {
                    $this->status = 'return_to_menu';
                }
            }
        }
        if ($this->stage == 'getting_ticket') {
            if ($message_type != "chat") {
                $this->status = 'getting_ticket_error';
            } else {
                $this->status = 'getting_ticket_next_stage';
            }
        }
        if ($this->stage == 'getting_image') {
            if ($message_type != "chat") {
                $this->status = 'getting_image_error';
            } else {
                $this->status = 'getting_image_next_stage';
            }
        }
        if ($this->stage == 'pending_to_delete') {
            if ($message_type != 'chat') {
                $this->status = 'pending_to_delete_error';
            } else {
                $exists = in_array($this->user_message, self::TOS_AVAILABLE_MESSAGES, TRUE);
                if ($exists === FALSE) {
                    $this->status = 'pending_to_delete_error';
                } else {
                    $this->status = 'pending_to_delete_next_stage';
                }
            }
        }

        return $this;
    }
    public function createMessage()
    {
        if ($this->stage == 'initializating'){
            $message = 'Bienvenido a este bot de prueba. Consulta nuestros Términos y Condiciones en una URL que no existe XD. ¿Aceptas los Términos y Condiciones? (sí/no)';
            $this->message = $message;
        }

        if ($this->stage == 'tos') {
            if ($this->status == 'tos_error') {
                $this->message = self::TOS_ERROR;
            } else {
                if ($this->user_message == "no") {
                    $this->status = 'tos_not_accepted';
                    $this->message = "Entendido. Si desea aceptar los términos y condiciones, escriba sí";
                } else {
                    $this->message = "Muy bien. Ahora, por favor, concédanos su nombre completo. Recuerde revisar bien su nombre";
                }
            }

        }
        if ($this->stage == 'getting_name') {
            if ($this->status == 'name_error') {
                $this->message = self::NAME_ERROR;
            } else {
                $this->message = "Excelente. Ahora, por favor, escoja una de las siguientes opciones: \n 1.- Nada \n 2.- Nada XD \n 3.-Conseguir premio \n 4.- Cancelar participación";
            }
        }
        if ($this->stage == 'menu_select') {
            if ($this->status == 'menu_select_error') {
                $this->message = self::MENU_SELECT_ERROR;
            } else {
                if ($this->status == 'menu_select_next_stage_as_option_1' || $this->status == 'menu_select_next_stage_as_option_2') {
                    $this->message = "Excelente. Haz seleccionado NADA XD. Así que no haremos nada XD. Escriba 'menú' para volver al menú";
                }
                if ($this->status == 'menu_select_next_stage_as_option_3') {
                    $this->message = "Perfecto. Por favor, envíenos su ticket de compra de X número de carácteres. Ejemplo: (546512164)";
                }
                if ($this->status == 'menu_select_next_stage_as_option_4') {
                    $this->message = "Usted escogió una opción peligrosa. Por favor, escriba 'sí' para confirmar su elección de eliminación o 'no' para volver al menú";
                }
            }
        }
        if ($this->stage == 'menu_select_as_nothing') {
            if ($this->status == 'menu_word_error') {
                $this->message = self::MENU_WORD_ERROR;
            } else {
                $this->message = "Excelente. Ahora, por favor, escoja una de las siguientes opciones: \n 1.- Nada \n 2.- Nada XD \n 3.-Conseguir premio \n 4.- Cancelar participación";

            }
        }
        if ($this->stage == 'getting_ticket') {
            if ($this->status == 'getting_ticket_error') {
                $this->message = self::GETTING_TICKET_ERROR;
            } else {
                $this->message = "Muy bien. Ahora, por favor, concédanos una URL con la imagen de su INE.";
            }
        }
        if ($this->stage == 'getting_image') {
            if ($this->status == 'getting_image_error') {
                $this->message = self::GETTING_IMAGE_ERROR;
            } else {
                $this->message = "Muy bien. Ahora, por favor, concédanos su dirección de correo electrónico y en cuanto hayamos confirmado sus datos. Le enviaremos un XD";
            }
        }
        if ($this->stage == 'pending_to_delete') {
            if ($this->status == 'pending_to_delete_error') {
                $this->message = self::PENDING_TO_DELETE_ERROR;
            } else {
                if ($this->user_message == "no") {
                    $this->status = 'return_to_menu';
                    $this->message = "Excelente. Ahora, por favor, escoja una de las siguientes opciones: \n 1.- Nada \n 2.- Nada XD \n 3.-Conseguir premio \n 4.- Cancelar participación";
                } else {
                    $this->message = "Su participación ha sido eliminada. Mande cualquier cosa para iniciar la participación de nuevo.";
                }
            }
        }

        return $this;
    }
    public function sendMessage()
    {
        return $this->message;
    }
}
