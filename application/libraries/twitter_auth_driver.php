<?php
class Twitter_Auth_Driver extends \Laravel\Auth\Drivers\Driver {
	
	public function retrieve($id) {
		if (filter_var($id, FILTER_VALIDATE_INT) !== false) {
			return User::find($id);
		}
	}
	
	public function getAuthenticateUrl($callback) {
		// Throws an exception if failed to get auth url
		$twitter = new EpiTwitter(Config::get("twitter.oauth.key"), Config::get("twitter.oauth.secret"));
		$url = $twitter->getAuthenticateUrl(null, array('oauth_callback' => $callback));
		return $url;
	}

	public function attempt($arguments = array()) {
		if(!$arguments["oauth_token"] || !$arguments["oauth_verifier"]) {
			return false;
		}
		$twitter = new EpiTwitter(Config::get("twitter.oauth.key"), Config::get("twitter.oauth.secret"));

		$twitter->setToken($arguments["oauth_token"]);
		$token = $twitter->getAccessToken(array("oauth_verifier" => $arguments["oauth_verifier"]));
		$twitter->setToken($token->oauth_token, $token->oauth_token_secret);
		
		$twitterUser = $twitter->get('/account/verify_credentials.json');

		if($twitterUser and $twitterUser->screen_name) {
			$user = User::where_username($twitterUser->screen_name)->first();
			
			if(is_null($user)) {
				return false;
			} else {
				return $this->login($user->id, array_get($arguments, 'remember'));
			}
		} else {
			return false;
		}


	}
}