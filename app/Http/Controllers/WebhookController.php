<?php

namespace App\Http\Controllers;

use App\Library\BotTwo;
use App\Models\Award;
use App\Models\Order;
use App\Models\Participant;
use App\Models\Participation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WebhookController extends Controller
{
    public function contact(Request $request)
    {
        $data = $request->get('data');
        $phone = $data["from"];
        $message_type = $data["type"];
        $user_message = $data["body"];

        $participant = Participant::where('phone', $phone)->first();


        if (!$participant) {
            $participant = Participant::create([
                'phone' => $phone,
                'stage' => 'first_contact',
                'sub_stage' => 'initializating'
            ]);

            $bot = new BotTwo;
            $bot_response = $bot->checkStage($participant->stage, $participant->sub_stage)
                ->createMessage()
                ->sendMessage();

            $participant->sub_stage = 'tos';
            $participant->save();

            return response()->json([
                $bot_response
            ]);
        }

        $participant_stage = $participant->stage;
        $participant_sub_stage = $participant->sub_stage;

        $bot = new BotTwo;

        $bot_response = $bot->checkStage($participant_stage, $participant_sub_stage)
            ->checkUserMessage($user_message, $message_type)
            ->createMessage()
            ->sendMessage();
        $bot_status = $bot->status;

        //primer stage -Primer contacto
        if ($participant_stage == 'first_contact') {
            if ($participant_sub_stage == 'initializating') {
                $participant->update([
                    'sub_stage' => 'tos'
                ]);
            } else if ($participant_sub_stage == 'tos') {
                if ($bot_status == 'tos_not_accepted_first_attempt') {
                    $participant->update([
                        'sub_stage' => 'tos_not_accepted_first_attempt'
                    ]);
                } else if ($bot_status == 'tos_next_stage') {
                    $participant->update([
                        'stage' => 'register',
                        'sub_stage' => 'getting_name'
                    ]);
                }
            } //si el usuario dijo no en el primer intento
            else if ($participant_sub_stage == 'tos_not_accepted_first_attempt') {
                if ($bot_status == 'tos_not_accepted_second_attempt') {
                    $participant->update([
                        'sub_stage' => 'tos_not_accepted_second_attempt'
                    ]);
                } else if ($bot_status == 'tos_next_stage') {
                    $participant->update([
                        'stage' => 'register',
                        'sub_stage' => 'getting_name'
                    ]);
                }
            } //si el usuario dijo no en el segundo intento
            else if ($participant_sub_stage == 'tos_not_accepted_second_attempt') {
                if ($bot_status == 'go_to_menu') {
                    $participant->update([
                        'sub_stage' => 'tos'
                    ]);
                } else if ($bot_status == 'go_to_help') {
                    $participant->update([
                        'sub_stage' => 'help'
                    ]);
                }
            }
            //si el usuario está en ayuda

            if ($participant_sub_stage == 'help') {
                if ($bot_status == 'go_to_menu') {
                    $participant->update([
                        'sub_stage' => 'tos'
                    ]);
                }
            }
        } //segundo stage -Registro
        else if ($participant_stage == 'register') {
            if ($participant_sub_stage == 'getting_name') {
                $participant->update([
                    'name' => $user_message,
                    'sub_stage' => 'getting_state'
                ]);
            } else if ($participant_sub_stage == 'getting_state') {
                $participant->update([
                    'state' => $user_message,
                    'sub_stage' => 'getting_email'
                ]);
            } else if ($participant_sub_stage == 'getting_email') {
                if ($bot_status == 'getting_email_next_stage') {
                    $participant->update([
                        'stage' => 'menu',
                        'sub_stage' => 'menu_select',
                        'email' => $user_message
                    ]);
                }
            }
        } //tercer stage -Menu
        else if ($participant_stage == 'menu') {
            //si esta en la seleccion de menu
            if ($participant_sub_stage == 'menu_select') {
                if ($bot_status == 'menu_select_option_1') {
                    $participant->update([
                        'stage' => 'participation',
                        'sub_stage' => 'unique_code'
                    ]);
                }
                if ($bot_status == 'menu_select_option_2') {
                    $participant->update([
                        'stage' => 'participation',
                        'sub_stage' => 'online_number_code'
                    ]);
                }
                if ($bot_status == 'menu_select_option_3') {
                    $participant->update([
                        'sub_stage' => 'unique_code_help'
                    ]);
                }
                if ($bot_status == 'menu_select_option_4') {
                    $participant->update([
                        'sub_stage' => 'online_number_code_help'
                    ]);
                }
                if ($bot_status == 'menu_select_option_5') {
                    $participant->update([
                        'sub_stage' => 'mechanic_help'
                    ]);
                }
                if ($bot_status == 'menu_select_option_6') {
                    $participant->update([
                        'sub_stage' => 'help'
                    ]);
                }
            } //si esta en las 3 secciones donde solo se acepta si o no
            else if (
                $participant_sub_stage == 'unique_code_help' ||
                $participant_sub_stage == 'online_number_code_help' ||
                $participant_sub_stage == 'online_number_code_help' ||
                $participant_sub_stage == 'mechanic_help') {
                if ($bot_status == 'response_no') {
                    $participant->update([
                        'sub_stage' => 'not_participating'
                    ]);
                } else if ($bot_status == 'return_to_menu') {
                    $participant->update([
                        'sub_stage' => 'menu_select'
                    ]);
                }
            } //si esta en la ayuda general
            else if ($participant_sub_stage == 'help') {
                if ($bot_status == 'return_to_menu') {
                    $participant->update([
                        'sub_stage' => 'menu_select'
                    ]);
                }
            } //si decidio no participar
            else if ($participant_sub_stage == 'not_participating') {
                if ($bot_status == 'return_to_menu') {
                    $participant->update([
                        'sub_stage' => 'menu_select'
                    ]);
                }
            }
        } //cuarto stage -Participacion
        else if ($participant_stage == 'participation') {
            if ($participant_sub_stage == 'unique_code') {
                if ($bot_status == 'unique_code_error') {
                    $participant->update([
                        'sub_stage' => 'unique_code_failed'
                    ]);
                } else if ($bot_status == 'code_verification') {
                    $code_exists = $this->verification($bot->user_message);

                    if ($code_exists) {
                        $participant->update([
                            'sub_stage' => 'unique_code_failed'
                        ]);
                        return response()->json([
                            "¡Lo sentimos! Parece que hay un error. El código único ya fue registrado con anterioridad. \n Por favor ingresa un nuevo código o escribe *menú* para regresar."
                        ]);
                    } else {
                        $this->createParticipation($participant, $bot->user_message, $participant_sub_stage);
                        $awards = $this->getAwards();
                        $award = $this->chooseAward($awards);

                        $participant->update([
                            'stage' => 'award',
                            'sub_stage' => 'final'
                        ]);

                        $token = $this->generateOrder();
                        $participation = $participant->participations()->latest()->first();
                        $participation_order = Order::create([
                            'participation_id' => $participation->id,
                            'order' => $token
                        ]);

                        if (!$award) {
                            $participant->participations()->latest()->first()->update([
                                'status' => 'not_winner',
                                'award' => 'not_award'
                            ]);
                            return response()->json([
                                "¡Qué emoción! \n \n Confirmamos que hemos registrado correctamente tu participación. Recuerda seguir acumulando compras y registrando códigos para ganar un premio semanal o un premio final. Si quieres seguir participando, escribe *registrar* \n Folio: $participation_order->order \n Fecha y Hora: $participation->updated_at"
                            ]);
                        }

                        $award->update([
                            'status' => 'not_available',
                            'updated_at' => now()
                        ]);

                        $participant->participations()->latest()->first()->update([
                            'status' => 'award_received',
                            'award' => $award->award
                        ]);
                        if ($award->award == 'recarga_telefónica') {
                            return response()->json([
                                "PREMIO DIARIO RECARGA \n \n Felicidades, estás a punto de ganar 100 pesos en una recarga telefónica \n Si quieres seguir participando, escribe *registrar* \n \n Folio: $participation_order->order \n Fecha y Hora: $participation->updated_at"
                            ]);
                        } else if ($award->award == 'navegacion_telcel') {
                            return response()->json([
                                "PREMIO DIARIO MEGAS \n \n Felicidades, estás a punto de ganar 100 MB de navegación telcel \n Si quieres seguir participando, escribe *registrar* \n Folio: $participation_order->order \n Fecha y Hora: $participation->updated_at"
                            ]);
                        }
                    }
                }
            } else if ($participant_sub_stage == 'online_number_code') {
                if ($bot_status == 'online_number_code_error') {
                    $participant->update([
                        'sub_stage' => 'online_number_code_failed'
                    ]);
                } else if ($bot_status == 'code_verification') {
                    $code_exists = $this->verification($bot->user_message);

                    if ($code_exists) {
                        $participant->update([
                            'sub_stage' => 'online_number_code_failed'
                        ]);
                        return response()->json([
                            "¡Lo sentimos! Parece que hay un error. El número de pedido ya fue registrado con anterioridad. \n Por favor ingresa un nuevo número de pedido o escribe *menú* para regresar."
                        ]);
                    } else {
                        $this->createParticipation($participant, $bot->user_message, $participant_sub_stage);
                        $participant->update([
                            'sub_stage' => 'getting_image'
                        ]);
                        return response()->json([
                            "Ahora envíanos una fotografía o un screenshot de tu compra en línea donde se vea en totalidad y sea legible"
                        ]);
                    }
                }
            } else if ($participant_sub_stage == 'unique_code_failed' || $participant_sub_stage == 'online_number_code_failed') {
                if ($bot_status == 'go_to_menu') {
                    $participant->update([
                        'stage' => 'menu',
                        'sub_stage' => 'menu_select'
                    ]);
                } else if ($bot_status == 'code_verification') {
                    $code_exists = $this->verification($bot->user_message);

                    if ($code_exists) {
                        if ($participant_sub_stage == 'unique_code_failed') {
                            $participant->update([
                                'sub_stage' => 'unique_code_failed'
                            ]);
                            return response()->json([
                                "¡Lo sentimos! Parece que hay un error. El código único ya fue registrado con anterioridad. \n Por favor ingresa un nuevo código o escribe *menú* para regresar."
                            ]);
                        } else {
                            $participant->update([
                                'sub_stage' => 'online_number_code_failed'
                            ]);
                            return response()->json([
                                "¡Lo sentimos! Parece que hay un error. El número de pedido ya fue registrado con anterioridad. \n Por favor ingresa un nuevo número de pedido o escribe *menú* para regresar."
                            ]);
                        }
                    } else {
                        $this->createParticipation($participant, $bot->user_message, $participant_sub_stage);

                        if ($participant_sub_stage == 'unique_code_failed') {
                            $awards = $this->getAwards();
                            $award = $this->chooseAward($awards);

                            $participant->update([
                                'stage' => 'award',
                                'sub_stage' => 'final'
                            ]);

                            $token = $this->generateOrder();
                            $participation = $participant->participations()->latest()->first();
                            $participation_order = Order::create([
                                'participation_id' => $participation->id,
                                'order' => $token
                            ]);

                            if (!$award) {
                                $participant->participations()->latest()->first()->update([
                                    'status' => 'not_winner',
                                    'award' => 'not_award'
                                ]);
                                return response()->json([
                                    "¡Qué emoción! \n \n Confirmamos que hemos registrado correctamente tu participación. Recuerda seguir acumulando compras y registrando códigos para ganar un premio semanal o un premio final. Si quieres seguir participando, escribe *registrar* \n Folio: $participation_order->order \n Fecha y Hora: $participation->updated_at"
                                ]);
                            }

                            $award->update([
                                'status' => 'not_available',
                                'updated_at' => now()
                            ]);

                            $participant->participations()->latest()->first()->update([
                                'status' => 'award_received',
                                'award' => $award->award
                            ]);
                            if ($award->award == 'recarga_telefónica') {
                                return response()->json([
                                    "PREMIO DIARIO RECARGA \n \n Felicidades, estás a punto de ganar 100 pesos en una recarga telefónica \n Si quieres seguir participando, escribe *registrar* \n Folio: $participation_order->order \n Fecha y Hora: $participation->updated_at"
                                ]);
                            } else if ($award->award == 'navegacion_telcel') {
                                return response()->json([
                                    "PREMIO DIARIO MEGAS \n \n Felicidades, estás a punto de ganar 100 MB de navegación telcel \n Si quieres seguir participando, escribe *registrar* \n Folio: $participation_order->order \n Fecha y Hora: $participation->updated_at"
                                ]);
                            }
                        } else {
                            $participant->update([
                                'sub_stage' => 'getting_image'
                            ]);
                            return response()->json([
                                "Ahora envíanos una fotografía o un screenshot de tu compra en línea donde se vea en totalidad y sea legible"
                            ]);
                        }
                    }
                }
            } else if ($participant_sub_stage == 'getting_image' || $participant_sub_stage == 'getting_image_failed') {
                if ($bot_status == 'getting_image_error') {
                    $participant->update([
                        'sub_stage' => 'getting_image_failed'
                    ]);
                } else if ($bot_status == 'participation_next_stage') {
                    $awards = $this->getAwards();
                    $award = $this->chooseAward($awards);

                    $participant->update([
                        'stage' => 'award',
                        'sub_stage' => 'final'
                    ]);

                    $token = $this->generateOrder();
                    $participation = $participant->participations()->latest()->first();
                    $participation_order = Order::create([
                        'participation_id' => $participation->id,
                        'order' => $token
                    ]);


                    if (!$award) {
                        $participant->participations()->latest()->first()->update([
                            'status' => 'not_winner',
                            'award' => 'not_award'
                        ]);
                        return response()->json([
                            "¡Qué emoción! \n \n Confirmamos que hemos registrado correctamente tu participación. Recuerda seguir acumulando compras y registrando códigos para ganar un premio semanal o un premio final. Si quieres seguir participando, escribe *registrar* \n Folio: $participation_order->order \n Fecha y Hora: $participation->updated_at"
                        ]);
                    }

                    $award->update([
                        'status' => 'not_available',
                        'updated_at' => now()
                    ]);

                    $participant->participations()->latest()->first()->update([
                        'status' => 'award_received',
                        'award' => $award->award
                    ]);
                    if ($award->award == 'recarga_telefónica') {
                        return response()->json([
                            "PREMIO DIARIO RECARGA \n \n Felicidades, estás a punto de ganar 100 pesos en una recarga telefónica \n Si quieres seguir participando, escribe *registrar* \n Folio: $participation_order->order \n Fecha y Hora: $participation->updated_at"
                        ]);
                    } else if ($award->award == 'navegacion_telcel') {
                        return response()->json([
                            "PREMIO DIARIO MEGAS \n \n Felicidades, estás a punto de ganar 100 MB de navegación telcel \n Si quieres seguir participando, escribe *registrar* \n Folio: $participation_order->order \n Fecha y Hora: $participation->updated_at"
                        ]);
                    }
                } else if ($bot_status == 'go_to_menu') {
                    DB::table('registered_codes')->where('registered_by', $participant->id)->orderBy('id', 'desc')->limit(1)->delete();
                    $participant->participations()->latest()->first()->delete();

                    $participant->update([
                        'stage' => 'menu',
                        'sub_stage' => 'menu_select'
                    ]);
                } else if ($bot_status == 'go_to_help') {
                    DB::table('registered_codes')->where('registered_by', $participant->id)->orderBy('id', 'desc')->limit(1)->delete();
                    $participant->participations()->latest()->first()->delete();

                    $participant->update([
                        'stage' => 'menu',
                        'sub_stage' => 'help'
                    ]);
                }
            }
        }
        else if ($participant_stage == 'award') {
            if ($bot_status == 'register_again') {
                $participant->update([
                    'stage' => 'menu',
                    'sub_stage' => 'menu_select'
                ]);
            }
        }

        return response()->json([
            $bot_response
        ]);
    }

    public function verification($user_message): bool
    {
        $code_exists = $this->codeComprobation($user_message);
        if ($code_exists) {
            return true;
        } else {
            return false;
        }
    }

    public function codeComprobation($user_message): bool
    {
        $code = DB::table('registered_codes')->where('code', $user_message)->first();
        if ($code) {
            return true;
        } else {
            return false;
        }
    }

    public function createParticipation($participant, $user_message, $sub_stage)
    {
        $type = $sub_stage == 'unique_code' || $sub_stage == 'unique_code_failed' ? 'unique_code' : 'online_number_code';
        Participation::create([
            "participant_id" => $participant->id,
            "code" => $user_message,
            "type" => $type
        ]);
        DB::table('registered_codes')->insert([
            [
                "registered_by" => $participant->id,
                "code" => $user_message
            ]
        ]);
    }

    public function getAwards()
    {
        $today = date('d-m-Y');
        $awards = Award::where('available_at', $today)
            ->get();
        if ($awards) {
            return $awards;
        }
    }

    public function chooseAward($awards)
    {
        $today = date('d-m-Y');

        $already_send = false;
//        $search_awards = Award::where('available_at', $today)
//            ->where('award', 'recarga_telefónica')
//            ->where('status', 'not_available')
//            ->get();

        $search_awards = Award::where('available_at', $today)
            ->where('status', 'not_available')
            ->get();

        if ($search_awards) {
            foreach ($search_awards as $award) {
                if ($award->updated_at->format('H') == now()->format('H')) {
                    $already_send = true;
                    break;
                }
            }
            if (!$already_send) {
//                return $awards->where('award', 'recarga_telefónica')->first();
                return $awards->random();
            } else {
//                return $awards->where('award', '!=', 'recarga_telefónica')
//                    ->where('status', 'available')
//                    ->first();
                return null;
            }
        } else {
//            return $awards->where('award', 'recarga_telefónica')->first();
             return $awards->random();
        }

    }
    public function generateOrder() {
        $save = [];

        for ($i = 0; $i < 5; $i++) {
            $random_number = rand(1, 3);
            $order = bin2hex(random_bytes($random_number));
            $save[$i] = $order;
        }

        return implode("-", $save);
    }

}
