<?php

if (ENVIRONMENT == 'development')
{
	$config['fb_appid'] = '257690257696643';
	$config['fb_secret'] = 'c6880f32c33d0939ca477615f6d00b20';
}
else if (ENVIRONMENT == 'testing')
{
	$config['fb_appid'] = '458845597504327';
	$config['fb_secret'] = 'c24e68ab407f0ada8897d2c142b78b8b';
}
else if (ENVIRONMENT == 'production')
{
	$config['fb_appid'] = '527815700592404';
	$config['fb_secret'] = '7704a55cabf38f217b4ba47969d54f38';
}

/**
 * What you want permission from the user.
 */
$config['fb_scope'] = 'email';

?>
