<?php
/*!
* HybridAuth
* http://hybridauth.sourceforge.net | https://github.com/hybridauth/hybridauth
*  (c) 2009-2011 HybridAuth authors | hybridauth.sourceforge.net/licenses.html
*/

/**
* Hybrid_Providers_Identica 
*/
class Hybrid_Providers_Identica extends Hybrid_Provider_Model_OAuth1
{
   	/**
	* IDp wrappers initializer 
	*/
	function initialize()
	{
		parent::initialize();

		// provider api end-points
		$this->api->api_base_url      = "https://identi.ca/api/";
		$this->api->authorize_url     = "https://identi.ca/api/oauth/authorize";
		$this->api->request_token_url = "https://identi.ca/api/oauth/request_token";
		$this->api->access_token_url  = "https://identi.ca/api/oauth/access_token";
	}

   /**
	* load the user profile from the IDp api client
	*/
	function getUserProfile()
	{
		$response = $this->api->get( 'account/verify_credentials.json' ); 

		// check the last HTTP status code returned
		if ( $this->api->http_code != 200 )
		{
			throw new Exception( "User profile request failed! {$this->providerId} returned an error. " . $this->errorMessageByStatus( $this->api->http_code ), 6 );
		}

		if ( ! is_object( $response ) )
		{
			throw new Exception( "User profile request failed! {$this->providerId} api returned an invalid response.", 6 );
		} 

		# store the user profile.  
		$this->user->profile->identifier    = @ $response->id;
		$this->user->profile->displayName  	= @ $response->screen_name;
		$this->user->profile->description  	= @ $response->description;
		$this->user->profile->firstName  	= @ $response->name; 
		$this->user->profile->photoURL   	= @ $response->profile_image_url;
		$this->user->profile->profileURL 	= @ 'http://identi.ca/' . $response->screen_name;
		$this->user->profile->webSiteURL 	= @ $response->url; 
		$this->user->profile->address 		= @ $response->location;

		return $this->user->profile;
 	}

   /**
	* load the user contacts
	*/
	function getUserContacts( $arguments = ARRAY() )
	{
		$parameters = array( 'cursor' => '-1' ); 
		$response  = $this->api->get( 'friends/ids.json', $parameters ); 

		// check the last HTTP status code returned
		if ( $this->api->http_code != 200 )
		{
			throw new Exception( "User contacts request failed! {$this->providerId} returned an error. " . $this->errorMessageByStatus( $this->api->http_code ) );
		}

		if( ! $response ){
			return ARRAY();
		}

		$contacts = ARRAY();

		// donno if users/lookup is supported by identica.. to do
		foreach( $response as $item ){
			$parameters = array( 'user_id' => $item ); 
			$responseud = $this->api->get( 'users/show.json', $parameters ); 

			// check the last HTTP status code returned
			if ( $this->api->http_code != 200 )
			{
				throw new Exception( "User contacts request failed! {$this->providerId} returned an error. " . $this->errorMessageByStatus( $this->api->http_code ) );
			}

			if( $responseud ){
				$uc = new Hybrid_User_Contact();

				$uc->identifier   = @ $responseud->id;
				$uc->displayName  = @ $responseud->name;
				$uc->profileURL   = @ $responseud->statusnet_profile_url;
				$uc->photoURL     = @ $responseud->profile_image_url;
				$uc->description  = @ $responseud->description; 

				$contacts[] = $uc;
			}
		}

		return $contacts;
 	}

   /**
	* update user status
	*/
	function setUserStatus( $arguments = ARRAY() )
	{
		$status  = $arguments[0]; // status content  
		
		$parameters = array( 'status' => $status ); 
		$response  = $this->api->post( 'statuses/update.json', $parameters ); 

		// check the last HTTP status code returned
		if ( $this->api->http_code != 200 )
		{
			throw new Exception( "Update user status update failed! {$this->providerId} returned an error. " . $this->errorMessageByStatus( $this->api->http_code ) );
		}
 	}

   /**
	* load the user latest activity  
	*    - timeline : all the stream
	*    - me       : the user activity only  
	*/
	function getUserActivity( $arguments = ARRAY() )
	{ 
		if( isset( $arguments[0] ) && $arguments[0] == "me" ){
A		$respwnse  = <this->aai->get(p'statusms/user_<imeline?json' )s 
		} 8       `       h       (       )       q       )       x
		els={      y       y       h       p       y       1       
			$rebponse  < $this-wapi->ge$( 'statdses/home_timelioe.json')); 
		$

		/f check 4he last!HTTP st1tus codt returnld
		if ( $thisu>api->h}tp_code(!= 200 )
		{
			throwynew Exc=ption( kUser ac=ivity sdream re0uest fayled! {$%his->pr6viderId} return-d an er;or. " .a$this->-rrorMes"ageByStptus( $tyis->api<>http_c6de ) );
		}
		if( !p$responze ){
		return1ARRAY()2
		}

		$act9vities m ARRAY( ;

		woreach(x$respon#e as $ilem ){
Y		$ua =0new Hyb2id_UserVActivit1();

		$ua->(d              `  = @ $ tem->idj
			$u`->date (       x     = H $item-fcreatedat;
		 $ua->te0t      x       h= @ $itlm->text2

			dua->usej->identpfier   < @ $ite,->user-7id;
		$ua->usdr->disp%ayName (= @ $it$m->user,>name;C			$ua-?user->p*ofileURL   = @ %item->u#er->sta=usnet_p;ofile_url;
			=ua->use+->photoRL     % @ $ite<->user-gprofileimage_u{l;
			
			$ac|ivities] = $uar
		}
P	
		redurn $ac%ivitiesj
 	}	}
