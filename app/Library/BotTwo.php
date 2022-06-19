<?php


namespace App\Library;


class BotTwo
{
    public $stage;
    public $sub_stage;
    public $message;
    public $user_message;
    public $status;
    public $type;
    public $code_required_length;

    CONST FIRST_MESSAGE = "Bienvenid@ la promoción de ''Momento de ganar con tus consentidos Nestlé'' \n \n ¿Ya tienes un cupón con tu código único? Antes de comenzar, es importante que leas y aceptes el Aviso de Privacidad (AdP) y los Términos y Condiciones (TyC) de la promoción que encontrarás en este link: \n https://link.com \n \n https://link2.com \n \n ¿Estás de acuerdo con el AdP y los TyC? \n *(Si/No)*";
    CONST MENU_STAGE_FIRST_MESSAGE = "¡Excelente! ¡Ya casi estás participando! Ahora, ¿qué te gustaría hacer? Escribe el número. \n \n 1️⃣ Registrar mi código único en cupón Chedraui \n 2️⃣ Registrar mi número de pedido en compra online \n 3️⃣ ¿Dónde encuentro mi código único? \n 4️⃣ ¿Dónde encuentro mi número de pedido en compra online? \n 5️⃣ Mecánica \ 6️⃣ Ayuda";
    //message errors
    CONST MENU_HELP_WORD_ERROR = "Lo siento, no entiendo lo que dices. Por favor, ingresa la palabra *menú* para regresar o *ayuda* para soporte";
    CONST MENU_REGISTER_WORD_ERROR = "Lo siento, no entiendo lo que dices. Por favor, ingresa la palabra *menú* para regresar o *registrar* para registrar un código.";
    CONST MENU_WORD_ERROR = "Lo siento, no entiendo lo que dices. Por favor, ingresa la palabra *menú* para regresar al menú.";
    CONST NOT_EMAIL_ERROR = "¡Ups! Parece que tu correo no es válido. Escribe tu correo electrónico. \n Ejemplo: momentodeganar@gmail.com";
    CONST MENU_SELECT_ERROR = "Lo siento, la opción que has ingresado no es válida 😖. Por favor, escoge una de las siguientes opciones: \n 1️⃣ Registrar mi código único en cupón Chedraui \n 2️⃣ Registrar mi número de pedido en compra online \n 3️⃣ ¿Dónde encuentro mi código único? \n 4️⃣ ¿Dónde encuentro mi número de pedido en compra online? \n 5️⃣ Mecánica \ 6️⃣ Ayuda";
    CONST YES_NO_ERROR = "Lo siento, no entiendo lo que dices. Por favor, escribe *si* o *no* para confirmar tu elección";
    CONST UNIQUE_CODE_ERROR = "¡Lo sentimos! Tu código es incorrecto, por favor ingrésalo nuevamente siguiendo el ejemplo. \n Ó Escribe *menú* para regresar";
    CONST ONLINE_NUMBER_CODE_ERROR = "¡Lo sentimos! Tu número de pedido en compra es incorrecto, por favor ingrésalo nuevamente siguiendo el ejemplo. \n Ó Escribe *menú* para regresar";
    CONST REGISTER_WORD_ERROR = "Lo siento, no entiendo lo que dices. Si deseas registrar un nuevo código, escribe la palabra *registrar*";
    //available responses
    CONST YES_NO_AVAILABLE_MESSAGES = [
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
        ],
        "5" => [
            "5",
            "cinco",
            "five"
        ],
        "6" => [
            "6",
            "seis",
            "six"
        ]
    ];
    CONST REGISTER_AVAILABLE_MESSAGES = [
        "registrar",
        "register"
    ];
    CONST MENU_WORD_AVAILABLE_MESSAGES = [
        "menú",
        "menu",
        "MENU",
        "ménu"
    ];
    CONST HELP_AVAILABLE_MESSAGES = [
        "ayuda",
        "help",
    ];

    public function checkStage($stage, $participant_sub_stage)
    {
        $this->stage = $stage;
        $this->sub_stage = $participant_sub_stage;
        if ($this->stage == 'participation') {
            if ($this->sub_stage == 'unique_code' || $this->sub_stage == 'unique_code_failed') {
                $this->code_required_length = 8;
            }
            else if ($this->sub_stage == 'online_number_code' || $this->sub_stage == 'online_number_code_failed') {
                $this->code_required_length = 15;
            }
        }
        return $this;

    }

    public function checkUserMessage($user_message, $message_type)
    {
        $this->user_message = strtolower($user_message);

        //primer stage -Primer contacto
        if ($this->stage == 'first_contact') {
            if ($this->sub_stage == 'tos') {
                $exists = in_array($this->user_message, self::YES_NO_AVAILABLE_MESSAGES, TRUE);
                if ($exists === FALSE || $this->user_message == "no") {
                    $this->status = 'tos_not_accepted_first_attempt';
                } else {
                    $this->status = 'tos_next_stage';
                }
            }
            else if ($this->sub_stage == 'tos_not_accepted_first_attempt') {
                $exists = in_array($this->user_message, self::YES_NO_AVAILABLE_MESSAGES, TRUE);
                if ($exists === FALSE || $this->user_message == "no") {
                    $this->status = 'tos_not_accepted_second_attempt';
                } else {
                    $this->status = 'tos_next_stage';
                }
            }
            else if ($this->sub_stage == 'tos_not_accepted_second_attempt') {
                $exists_in_help = in_array($this->user_message, self::HELP_AVAILABLE_MESSAGES, TRUE);
                $exists_in_menu = in_array($this->user_message, self::MENU_WORD_AVAILABLE_MESSAGES, TRUE);
                if ($exists_in_menu === TRUE || $exists_in_help === TRUE) {
                    if ($exists_in_menu) {
                        $this->status = 'go_to_menu';
                    }
                    if ($exists_in_help) {
                        $this->status = 'go_to_help';
                    }
                } else {
                    $this->status = 'tos_not_accepted_second_attempt_error';
                }

            }
            else if ($this->sub_stage == 'help') {
                $this->status = 'go_to_menu';
            }
        }
        //segundo stage -Registro
        else if ($this->stage == 'register') {
            if ($this->sub_stage == 'getting_name') {
                $this->status = 'getting_name_next_sub_stage';
            }
            else if ($this->sub_stage == 'getting_state') {
                $this->status = 'getting_state_next_sub_stage';
            }
            else if ($this->sub_stage == 'getting_email') {
                $regex = '/\w+@\w+\.com/';
                $coincide = preg_match($regex, $user_message);

                if ($coincide == 0) {
                    $this->status = 'getting_email_error';
                } else {
                    $this->status = 'getting_email_next_stage';
                }
            }
        }
        //tercer stage -Menu
        else if ($this->stage == 'menu') {
            if ($this->sub_stage == 'menu_select') {
                $is_option_1 = in_array($this->user_message, self::MENU_AVAILABLE_MESSAGES["1"], TRUE);
                $is_option_2 = in_array($this->user_message, self::MENU_AVAILABLE_MESSAGES["2"], TRUE);
                $is_option_3 = in_array($this->user_message, self::MENU_AVAILABLE_MESSAGES["3"], TRUE);
                $is_option_4 = in_array($this->user_message, self::MENU_AVAILABLE_MESSAGES["4"], TRUE);
                $is_option_5 = in_array($this->user_message, self::MENU_AVAILABLE_MESSAGES["5"], TRUE);
                $is_option_6 = in_array($this->user_message, self::MENU_AVAILABLE_MESSAGES["6"], TRUE);

                if ($is_option_1 === TRUE) {
                    $this->status = 'menu_select_option_1';
                }
                if ($is_option_2 === TRUE) {
                    $this->status = 'menu_select_option_2';
                }
                if ($is_option_3 === TRUE) {
                    $this->status = 'menu_select_option_3';
                }
                if ($is_option_4 === TRUE) {
                    $this->status = 'menu_select_option_4';
                }
                if ($is_option_5 === TRUE) {
                    $this->status = 'menu_select_option_5';
                }
                if ($is_option_6 === TRUE) {
                    $this->status = 'menu_select_option_6';
                }
                if ($is_option_1 === FALSE &&
                    $is_option_2 === FALSE &&
                    $is_option_3 === FALSE &&
                    $is_option_4 === FALSE &&
                    $is_option_5 === FALSE &&
                    $is_option_6 === FALSE
                ) {
                    $this->status = 'menu_select_error';
                }
            }
            else if (
                $this->sub_stage == 'unique_code_help' ||
                $this->sub_stage == 'online_number_code_help' ||
                $this->sub_stage == 'mechanic_help'
            ) {
                $exists_in_yes_no = in_array($this->user_message, self::YES_NO_AVAILABLE_MESSAGES, TRUE);
                if ($exists_in_yes_no === TRUE) {
                    if ($this->user_message == "no"){
                        $this->status = 'response_no';
                    } else {
                        $this->status = 'return_to_menu';
                    }
                } else {
                    $this->status = 'yes_no_error';
                }
            }
            else if ($this->sub_stage == 'help') {
                $exists_in_menu = in_array($this->user_message, self::MENU_WORD_AVAILABLE_MESSAGES ,TRUE);
                if ($exists_in_menu === TRUE) {
                    $this->status = 'return_to_menu';
                } else {
                    $this->status = 'help_error';
                }
            }
            else if ($this->sub_stage == 'not_participating') {
                $exists_in_menu = in_array($this->user_message, self::MENU_WORD_AVAILABLE_MESSAGES ,TRUE);
                $exists_in_register = in_array($this->user_message, self::REGISTER_AVAILABLE_MESSAGES ,TRUE);

                if ($exists_in_menu === TRUE || $exists_in_register === TRUE ) {
                    $this->status = 'return_to_menu';
                } else {
                    $this->status = 'not_participating_error';
                }
            }
        }
        //cuarto stage -Participacion
        else if ($this->stage == 'participation') {
            if ($this->sub_stage == 'unique_code_failed' ||
                $this->sub_stage == 'online_number_code_failed' ||
                $this->sub_stage == 'unique_code' ||
                $this->sub_stage == 'online_number_code'
            ) {
                if ($this->sub_stage == 'unique_code_failed' || $this->sub_stage == 'online_number_code_failed') {
                    $exists_in_menu = in_array($this->user_message, self::MENU_WORD_AVAILABLE_MESSAGES, TRUE);
                    if ($exists_in_menu === TRUE) {
                        $this->status = 'go_to_menu';
                        return $this;
                    }
                }

                $contains_space = strpos($this->user_message, ' ');
                $invalid_length = (strlen($this->user_message)) > $this->code_required_length || (strlen($this->user_message)) < $this->code_required_length  ? true : false;
                if (
                    $contains_space ||
                    $invalid_length
                ) {
                    if ($this->sub_stage == 'unique_code' || $this->sub_stage == 'unique_code_failed') {
                        $this->status = 'unique_code_error';
                    }
                    else if ($this->sub_stage == 'online_number_code' || $this->sub_stage == 'online_number_code_failed') {
                        $this->status = 'online_number_code_error';
                    }
                } else {
                    $this->status = 'code_verification';
                }
            }
            else if ($this->sub_stage == 'getting_image') {
                if ($message_type != 'image') {
                    $this->status = 'getting_image_error';
                } else {
                    $this->status = 'participation_next_stage';
                }
            }
            else if ($this->sub_stage == 'getting_image_failed') {
                if ($message_type != 'image') {
                    $exists_in_menu = in_array($this->user_message, self::MENU_WORD_AVAILABLE_MESSAGES, TRUE);
                    $exists_in_help = in_array($this->user_message, self::HELP_AVAILABLE_MESSAGES, TRUE);

                    if ($exists_in_menu === TRUE) {
                        $this->status = 'go_to_menu';
                    }
                    if ($exists_in_help === TRUE) {
                        $this->status = 'go_to_help';
                    }
                    if ($exists_in_menu === FALSE && $exists_in_help === FALSE) {
                        $this->status = 'getting_image_error';
                    }
                } else {
                    $this->status = 'participation_next_stage';
                }
            }

        }
        //quinto stage -Award (si desea participar de nuevo)
        else if ($this->stage == 'award') {
            $exists_in_register = in_array($this->user_message, self::REGISTER_AVAILABLE_MESSAGES, TRUE);
            if ($exists_in_register === FALSE) {
                $this->status = 'award_word_error';
            } else {
                $this->status = 'register_again';
            }
        }
        return $this;

    }

    public function createMessage()
    {
        //primer stage -Primer contacto
        if ($this->stage == 'first_contact') {
            if ($this->sub_stage == 'initializating') {
                $this->message = self::FIRST_MESSAGE;
            }
            else if ($this->sub_stage == 'tos') {
                if ($this->status == 'tos_not_accepted_first_attempt') {
                    $this->message = "Recuerda que para continuar es importante puedas aceptar los TyC y el Aviso de Privacidad. ¿Estás de acuerdo con el AdP y los TyC? \n *(Si/No)*";
                } else {
                    $this->message = "¡Vaya!, parece que es la primera vez que participas con nosotros, ¿nos ayudas por favor a proporcionarnos lo siguiente para completar tu registro? *Nombre completo* (sin abreviaturas)";
                }
            }
            else if ($this->sub_stage == 'tos_not_accepted_first_attempt') {
                if ($this->status == 'tos_not_accepted_second_attempt') {
                    $this->message = "Recuerda que para participar, necesitas aceptar los TyC y el Aviso de Privacidad. Aquí estaremos por si deseas continuar con tu participación. Escribe *menú* para regresar o *ayuda* para soporte";
                } else {
                    $this->message = "¡Vaya!, parece que es la primera vez que participas con nosotros, ¿nos ayudas por favor a proporcionarnos lo siguiente para completar tu registro? *Nombre completo* (sin abreviaturas)";
                }
            }
            else if ($this->sub_stage == 'tos_not_accepted_second_attempt') {
                if ($this->status == 'tos_not_accepted_second_attempt_error') {
                    $this->message = self::MENU_HELP_WORD_ERROR;
                }
                else if ($this->status == 'go_to_menu') {
                    $this->message = self::FIRST_MESSAGE;
                }
                else if ($this->status == 'go_to_help') {
                    $this->message = "Para más información o aclaraciones puedes ponerte en contacto al siguiente número 2+56546. O al correo electrónico asdas@asdasd.com.mx \n Horario de atención de lunes a viernes de 09:00 a 18:00 horas. \n Escribe *menú* para comenzar nuevamente";
                }
            }
            else if ($this->sub_stage == 'help') {
                $this->message = self::FIRST_MESSAGE;
            }
        }
        //segundo stage -Registro
        else if ($this->stage == 'register') {
            if ($this->sub_stage == 'getting_name') {
                $this->message = "¡Gracias! Por favor compártenos el *Estado* de residencia: ";
            }
            else if ($this->sub_stage == 'getting_state') {
                $this->message = "Escribe tu correo electrónico. Ejemplo: momentodeganar@gmail.com";
            }
            else if ($this->sub_stage == 'getting_email') {
                if ($this->status == 'getting_email_error') {
                    $this->message = self::NOT_EMAIL_ERROR;
                } else {
                    $this->message = self::MENU_STAGE_FIRST_MESSAGE;
                }
            }
        }
        //tercer stage -Menu
        else if ($this->stage == 'menu') {
            if ($this->sub_stage == 'menu_select') {
                if ($this->status == 'menu_select_option_1') {
                    $this->message = "Por favor ingresa las claves del código único que se encuentra en tu cupón Chedraui, sin espacios entre letras.";
                }
                if ($this->status == 'menu_select_option_2') {
                    $this->message = "Por favor ingresa número completo de tu pedido en compra online, sin espacios entre letras.";
                }
                if ($this->status == 'menu_select_option_3') {
                    $this->message = "El código único de tu cupón se encuentra debajo del código de barras. \n ¿Quieres participar ahora? \n (Si/No)";
                }
                if ($this->status == 'menu_select_option_4') {
                    $this->message = "El número de pedido encuentra en la parte superior izquierda de el recibo de confirmación de pago. \n ¿Quieres participar ahora? \n (Si/No)";
                }
                if ($this->status == 'menu_select_option_5') {
                    $this->message = "Participar es muy fácil: \n 1.- Compra $200 pesos de producto Nestlé participante. \n 2.- Recibe un cupón con un código único. \n 3.- ¡Registra el código por este medio, gana y acumula compras! \n ¿Quieres participar ahora? \n (Si/No)";
                }
                if ($this->status == 'menu_select_option_6') {
                    $this->message = "Para más información o aclaraciones puedes ponerte en contacto al siguiente número 2+56546. O al correo electrónico asdas@asdasd.com.mx \n Horario de atención de lunes a viernes de 09:00 a 18:00 horas. \n Escribe *menú* para comenzar nuevamente";
                }
                if ($this->status == 'menu_select_error') {
                    $this->message = self::MENU_SELECT_ERROR;
                }
            }
            else if (
                $this->sub_stage == 'unique_code_help' ||
                $this->sub_stage == 'online_number_code_help' ||
                $this->sub_stage == 'mechanic_help'
            ) {
                if ($this->status == 'response_no') {
                    $this->message = "Entiendo 😪. \n Si en un futuro quieres participar escribe la palabra *registrar* o *menú*";
                }
                else if ($this->status == 'return_to_menu') {
                    $this->message = self::MENU_STAGE_FIRST_MESSAGE;
                }
                else if ($this->status == 'yes_no_error') {
                    $this->message = self::YES_NO_ERROR;
                }
            }
            else if ($this->sub_stage == 'help') {
                if ($this->status == 'return_to_menu') {
                    $this->message = self::MENU_STAGE_FIRST_MESSAGE;
                }
                else if ($this->status == 'help_error') {
                    $this->message = self::MENU_WORD_ERROR;
                }
            }
            else if ($this->sub_stage == 'not_participating') {
                if ($this->status == 'return_to_menu') {
                    $this->message = self::MENU_STAGE_FIRST_MESSAGE;
                } else {
                    $this->message = self::MENU_REGISTER_WORD_ERROR;
                }
            }
        }
        //cuarto stage -Particicion
        else if ($this->stage == 'participation') {
            if ($this->sub_stage == 'unique_code_failed' ||
                $this->sub_stage == 'online_number_code_failed' ||
                $this->sub_stage == 'unique_code' ||
                $this->sub_stage == 'online_number_code'
            ) {
                if ($this->status == 'unique_code_error') {
                    $this->message = self::UNIQUE_CODE_ERROR;
                }
                else if ($this->status == 'online_number_code_error') {
                    $this->message = self::ONLINE_NUMBER_CODE_ERROR;
                }
                else if ($this->status == 'go_to_menu') {
                    $this->message = self::MENU_STAGE_FIRST_MESSAGE;
                }
            }
            else if ($this->sub_stage == 'getting_image') {
                if ($this->status == 'getting_image_error') {
                    $this->message = "Lo siento, necesito una fotografía o un screenshot de tu compra en línea para poder continuar. \n Si tienes problemas escribe *ayuda* o *menú* para comenzar nuevamente";
                }
            }
            else if ($this->sub_stage == 'getting_image_failed') {
                if ($this->status == 'go_to_menu') {
                    $this->message = self::MENU_STAGE_FIRST_MESSAGE;
                }
                else if ($this->status == 'go_to_help') {
                    $this->message = "Para más información o aclaraciones puedes ponerte en contacto al siguiente número 2+56546. O al correo electrónico asdas@asdasd.com.mx \n Horario de atención de lunes a viernes de 09:00 a 18:00 horas. \n Escribe *menú* para comenzar nuevamente";
                }
                else if ($this->status == 'getting_image_error') {
                    $this->message = "Lo siento, necesito una fotografía o un screenshot de tu compra en línea para poder continuar. \n Si tienes problemas escribe *ayuda* o *menú* para comenzar nuevamente";
                }
            }

        }
        else if ($this->stage == 'award') {
            if ($this->status == 'award_word_error') {
                $this->message = self::REGISTER_WORD_ERROR;
            } else {
                $this->message = self::MENU_STAGE_FIRST_MESSAGE;
            }
        }
        return $this;

    }

    public function sendMessage()
    {
        if ($this->status == 'code_verification') {
            return $this->message;
        } else {
            return $this->message;
        }
    }
}
