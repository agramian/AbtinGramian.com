<?
function checkEmail($email) 
{
	// checks proper syntax
	if( filter_var( $email, FILTER_VALIDATE_EMAIL ) )
	{	
		// gets domain name
		list($username,$domain)=explode('@',$email);
		// checks for if MX records in the DNS
		if(!checkdnsrr($domain, 'MX')) 
		{
			return false;
		}
		// attempts a socket connection to mail server
		if(!fsockopen($domain,80,$errno,$errstr,30)) 
		{
			return false;
		}
		return true;
	}
	return false;
}
?>