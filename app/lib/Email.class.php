<?php

/**
 * Email class provides sending emails.
 *
 * @version 1.0
 * @author MPI
 * */
class Email{
	const MSG_RENEW_TOKEN = 1;
	const MSG_UCR_TOKEN = 2;

	private function Email(){
	}

	/**
	 * Send email.
	 *
	 * @param array $args
	 *        	values given to address email recipient
	 * @param array $msg_data
	 *        	values given to print in email
	 * @return boolean
	 */
	public static function send($args, $msg_data){
		
	}
}
?>