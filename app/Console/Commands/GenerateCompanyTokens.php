<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Company;

class GenerateCompanyTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'company:generate-tokens';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate access tokens for companies that don\'t have them';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating access tokens for companies...');

        $companiesWithoutTokens = Company::whereNull('access_token')
            ->orWhere('access_token', '')
            ->get();

        if ($companiesWithoutTokens->isEmpty()) {
            $this->info('All companies already have access tokens!');
            return 0;
        }

        $count = 0;
        foreach ($companiesWithoutTokens as $company) {
            $company->access_token = Company::generateUniqueToken();
            $company->save();
            $count++;
            
            $this->line("✓ Token generated for: {$company->company_name}");
        }

        $this->info("\nSuccessfully generated {$count} access token(s)!");
        return 0;
    }
}
