<?php

namespace Asciisd\Zoho\Console\Commands;

use Illuminate\Console\Command;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
use zcrmsdk\oauth\exception\ZohoOAuthException;
use zcrmsdk\oauth\ZohoOAuth;

class SetupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zoho:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup zoho credentials';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws ZohoOAuthException
     */
    public function handle()
    {
        $grantToken = $this->ask('Please enter your Grant Token');
        if (!$grantToken) {
            $this->comment('The Grant Token is required.');
            return;
        }
        ZCRMRestClient::initialize($this->getAllCredentials());
        $oAuthClient = ZohoOAuth::getClientInstance();
        $oAuthTokens = $oAuthClient->generateAccessToken($grantToken);
        $this->info('Zoho CRM has been set up successfully.');
    }
}