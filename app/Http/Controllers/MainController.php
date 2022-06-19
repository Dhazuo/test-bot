<?php

namespace App\Http\Controllers;

use App\Library\Bot;
use App\Models\Participant;
use App\Models\Participation;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function contact(Request $request)
    {
        $data = $request->get('data');
        $phone = $data["from"];
        $message_type = $data["type"];
        $user_message = $data["body"];

        $user = Participant::where('phone', $phone)->first();


        if (!$user) {
            $participant = Participant::create([
                'phone' => $phone,
                'stage' => 'initializating'
            ]);

            $bot = new Bot;
            $bot_response = $bot->checkStage($participant->stage)
                ->createMessage()
                ->sendMessage();

            $participant->stage = 'tos';
            $participant->save();

            return response()->json([
                $bot_response
            ]);
        }

        $user_stage = $user->stage;

        $bot = new Bot;
        $bot_response = $bot->checkStage($user_stage)
            ->checkUserMessage($user_message, $message_type)
            ->createMessage()
            ->sendMessage();

        //cuando está en tos
        if ($user_stage == 'tos') {
            if ($bot->status == 'tos_next_stage') {
                $user->update([
                    "stage" => "getting_name"
                ]);
            }

        }
        //cuando está obteniendo el nombre
        else if ($user_stage == 'getting_name') {
            if ($bot->status == 'getting_name_next_stage') {
                $user->update([
                    "name" => $user_message
                ]);
                $user->update([
                    "stage" => "menu_select"
                ]);
            }
        }
        //cuando está seleccionando en el menu
        else if ($user_stage == 'menu_select') {
            if ($bot->status != 'menu_select_error') {
                if ($bot->status == 'menu_select_next_stage_as_option_1' || $bot->status == 'menu_select_next_stage_as_option_2') {
                    $user->update([
                       "stage" => 'menu_select_as_nothing'
                    ]);
                }
                if ($bot->status == 'menu_select_next_stage_as_option_3') {
                    $user->update([
                        "stage" => 'getting_ticket'
                    ]);
                }
                if ($bot->status == 'menu_select_next_stage_as_option_4') {
                    $user->update([
                        "stage" => 'pending_to_delete'
                    ]);
                }
            }
        }
        //si se escogio la opcion 1 o 2
        else if ($user_stage == 'menu_select_as_nothing') {
            if ($bot->status == 'return_to_menu') {
                $user->update([
                    "stage" => 'menu_select'
                ]);
            }
        }
        //si se escogio la opcion 3: avanzar
        else if ($user_stage == 'getting_ticket') {
            if ($bot->status == 'getting_ticket_next_stage') {
                $participation = Participation::create([
                    "participant_id" => $user->id,
                    "ticket" => $user_message
                ]);
                $user->update([
                    "stage" => 'getting_image'
                ]);
            }
        }
        else if ($user_stage == 'getting_image') {
            if ($bot->status == 'getting_image_next_stage') {
                $user->update([
                    "stage" => 'getting_email'
                ]);
            }
        }
        //si se escogio la opcion 4: eliminar participacion
        else if ($user_stage == 'pending_to_delete') {
            if ($bot->status != 'pending_to_delete_error') {
                if ($bot->status == 'return_to_menu') {
                    $user->update([
                        "stage" => 'menu_select'
                    ]);
                }
                if ($bot->status == 'pending_to_delete_next_stage') {
                    $user->delete();
                }
            }

        }


        return response()->json([
            $bot_response,
        ]);
    }
}
