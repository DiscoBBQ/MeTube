<?php

class Subscription {
  public $subscribing_user_id;
  public $subscription_user_id;

  static public function isUserSubscribedToThisUser($subscribing_user_id, $subscription_user_id){
    $subscribing_user_id  = intval($subscribing_user_id);
    $subscription_user_id = intval($subscription_user_id);
    $result = DB::select("SELECT * FROM subscriptions WHERE subscribing_user_id = ? AND subscription_user_id = ?", array($subscribing_user_id, $subscription_user_id));

    if(count($result) == 0){
      return false;
    }

    return true;
  }

  static public function subscribeUserToThisUser($subscribing_user_id, $subscription_user_id){
    $subscribing_user_id  = intval($subscribing_user_id);
    $subscription_user_id = intval($subscription_user_id);
    DB::statement("INSERT INTO subscriptions (subscribing_user_id, subscription_user_id) VALUES (?,?)", array($subscribing_user_id, $subscription_user_id));
  }

  static public function unsubscribeUserFromThisUser($subscribing_user_id, $subscription_user_id){
    $subscribing_user_id  = intval($subscribing_user_id);
    $subscription_user_id = intval($subscription_user_id);
    DB::statement("DELETE FROM subscriptions WHERE subscribing_user_id = ? AND subscription_user_id = ?", array($subscribing_user_id, $subscription_user_id));
  }

  static public function getUsersSubscriptions($user_id){
    $user_id = intval($user_id);
    $results = DB::select("SELECT * FROM subscriptions WHERE subscribing_user_id = ?", array($user_id));

    $subscriptions = array();

    foreach ($results as $result) {
      array_push($subscriptions, self::buildSubscriptionFromResult($result));
    }
    return $subscriptions;
  }

  static public function getSubscriptionsForThisUser($user_id){
    $user_id = intval($user_id);
    $results = DB::select("SELECT * FROM subscriptions WHERE subscription_user_id = ?", array($user_id));

    $subscriptions = array();

    foreach ($results as $result) {
      array_push($subscriptions, self::buildSubscriptionFromResult($result));
    }

    return $subscriptions;
  }

  static protected function buildSubscriptionFromResult($result){
    $subscription = new self();
    if($result == NULL){
      return NULL;
    }

    $subscription->subscribing_user_id  = intval($result->subscribing_user_id);
    $subscription->subscription_user_id = intval($result->subscription_user_id);

    return $subscription;
  }

  public function getSubscriptionUser(){
    return User::getByID($this->subscription_user_id);
  }

  public function getSubscribedUser(){
    return User::getByID($this->subscribing_user_id);
  }

}


?>