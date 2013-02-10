<?php

/*
 * What protocol to use?
 * mail, sendmail, smtp
 */
$config['protocol'] = 'mail';

/*
 * SMTP server address and port
 */
$config['smtp_host'] = '';
$config['smtp_port'] = '';

/*
 * SMTP username and password.
 */
$config['smtp_user'] = '';
$config['smtp_pass'] = '';

/*
 * Mail.
 */
if (ENVIRONMENT != 'development')
{
	$config['protocol'] = 'smtp';
	$config['smtp_host'] = 'smtp.mandrillapp.com';
	$config['smtp_port'] = 587;
	$config['smtp_user'] = $_SERVER['MANDRILL_USERNAME'];
	$config['smtp_pass'] = $_SERVER['MANDRILL_APIKEY'];
}