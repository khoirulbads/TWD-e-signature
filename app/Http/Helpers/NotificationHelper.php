<?php
namespace App\Http\Helpers;

use App\Http\Models\SC\GeneralNotificationModel;
use Ramsey\Uuid\Uuid;

class NotificationHelper {
       
		function createNotif($user_id_to, $user_id_from ,$message,$body, $type){
			$data = new GeneralNotificationModel();
			$data->id = Uuid::uuid4();
			$data->user_id_to = $user_id_to;
			$data->user_id_from = $user_id_from;
			$data->message = $message;
			if ($body != NULL ) {
				$data->data = json_encode($body);	
			}
			$data->type = $type;	
			if ($user_id_to != auth('api')->user()->id) {
				$data->save();
			}
			
			return true;
		}
	}

	?>
