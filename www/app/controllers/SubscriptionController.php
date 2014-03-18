<?php

class SubscriptionController extends BaseController {

	public function subscribe($id) {
		if(Auth::check()) {
			$result = DB::select("SELECT * FROM subscriptions WHERE subscribing_user_id = ? AND subscription_user_id = ?", array(Auth::user()->id, $id));
				
			if (sizeof($result) == 0)
				DB::statement("INSERT INTO subscriptions (subscribing_user_id, subscription_user_id) VALUES (?,?)", array(Auth::user()->id, $id));
		}

		return Redirect::to('/profile/'.$id);
	}
}