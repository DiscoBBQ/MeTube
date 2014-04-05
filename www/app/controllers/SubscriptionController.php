<?php

class SubscriptionController extends BaseController {
  protected $layout = "application";

  public function __construct()
  {
    $this->beforeFilter('@find_user_by_ID_or_raise_404', array('only' => array('subscribe', 'unsubscribe')));
    $this->beforeFilter('@check_if_user_is_already_subscribed', array('only' => array('subscribe')));
    $this->beforeFilter('@check_if_user_is_not_subscribed', array('only' => array('unsubscribe')));
  }


	public function subscribe($id) {
    Subscription::subscribeUserToThisUser(Auth::user()->getAuthIdentifier(), $id);
		return Redirect::route('profile', array('id' => $id));
	}

  public function unsubscribe($id) {
    Subscription::unsubscribeUserFromThisUser(Auth::user()->getAuthIdentifier(), $id);
    return Redirect::route('profile', array('id' => $id));
  }

  public function index(){
    $subscriptions = Subscription::getUsersSubscriptions(Auth::user()->getAuthIdentifier());
    $this->layout->content = View::make('subscription.index')->with(array('subscriptions' => $subscriptions));
  }

  public function check_if_user_is_already_subscribed(){
    if(Subscription::isUserSubscribedToThisUser(Auth::user()->getAuthIdentifier(), Route::input('id'))){
      return Redirect::route('home');
    }
  }

  public function check_if_user_is_not_subscribed(){
    if(Subscription::isUserSubscribedToThisUser(Auth::user()->getAuthIdentifier(), Route::input('id')) == false){
      return Redirect::route('home');
    }
  }

  public function find_user_by_ID_or_raise_404(){
    if(User::getByID(Route::input('id')) == NULL){
      App::abort('404');
    }
  }
}