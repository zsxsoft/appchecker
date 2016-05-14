<?php
namespace AppChecker;
use AppChecker\Log;

class MainFunc {
	public static function testApp($appId, $bloghost) {

		global $zbp;
		global $app;
		global $bloghost;

		if ($bloghost == "") {
			$bloghost = "http://localhost/";
		}
		//$zbp->option['ZC_PERMANENT_DOMAIN_ENABLE'] = false;
		//$zbp->option['ZC_ORIGINAL_BLOG_HOST'] = $zbp->option['ZC_BLOG_HOST'];
		$zbp->option['ZC_BLOG_HOST'] = $bloghost;

		Log::Log('Detected $bloghost = ' . $bloghost);
		Log::Info('Completed!');
		Log::Log('Getting App...');
		if ($zbp->CheckApp($appId)) {
			Log::Error('You should disable ' . $appId . ' in Z-BlogPHP first.');
		}
		$app = $zbp->LoadApp('plugin', $appId);
		if ($app->id !== null) {
			Log::Info('Detected Plugin.');
		} else {
			$app = $zbp->LoadApp('theme', $appId);
			if ($app->id !== null) {
				Log::Info('Detected Theme.');
			} else {
				Log::Error('App not Found!');
			}
		}

		Log::Title("System Information");
		Log::Info("Z-BlogPHP: " . $zbp->version);
		Log::Info("System: " . \GetEnvironment());
		Scanner::Run();
		Log::Info('OK!');
	}
}