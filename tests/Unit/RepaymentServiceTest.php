<?php

namespace Tests\Unit;

use App\Models\Investment;
use App\Models\Investor;
use App\Models\Project;
use App\Services\RepaymentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class RepaymentServiceTest extends TestCase
{
    use RefreshDatabase; // This will reset the database for each test


    public function setUp(): void
    {
        parent::setUp();

        // Run migrations and seeders
        $this->artisan('migrate', ['--env' => 'testing']);
        $this->artisan('db:seed', ['--env' => 'testing']);
    }

    public function testDistributeToInvestors()
    {
        $cases = [
            ['1500.50',  ['100.00', '400.00', '500.00', '500.50']],
            ['2000.75',  ['1200.00', '800.75']],
            ['500.00', ['100.00', '100.00', '100.00', '100.00', '50.00', '50.00']],
            ['318.15',  ['300.00', '200.00', '500.00']]
        ];
        foreach ($cases as $case) {
            $this->testDistributeToInvestorsCase($case[0], $case[1]);
        }
    }
    private function testDistributeToInvestorsCase($repaymentAmount, array $investmentAmounts)
    {
        $project = Project::factory()->create();

        // Collect all investments and calculate total investment amount
        $totalInvestmentAmount = 0;
        $investors = collect();
        foreach ($investmentAmounts as $amount) {
            $investor = Investor::factory()->create();
            $totalInvestmentAmount = bcadd($totalInvestmentAmount, $amount, 2);
            $investors[] = Investment::factory()->create([
                'project_id' => $project->id,
                'investor_id' => $investor->id,
                'amount' => $amount,
            ]);
        }

        // Call the repayment service to distribute repayments to investors
        $repaymentService = new RepaymentService();
        $distributions = $repaymentService->distributeToInvestors($project, $repaymentAmount);

        $totalDistributedAmount = '0';
        foreach ($distributions as $distribution) {
            // Access distribution using the correct structure
            $investorId = $distribution['investor_id'];
            $distributedAmount = $distribution['amount'];

            // Calculate the expected distribution amount for each investor
            $investmentAmount = $investors->firstWhere('investor_id', $investorId)->amount;
            $expectedDistribution = bcmul($investmentAmount / $totalInvestmentAmount, $repaymentAmount, 2);

            // Assert that the distributed amount matches the expected amount
            $this->assertEqualsWithDelta(
                $expectedDistribution,
                $distributedAmount,
                0.01,
                "Failed for investor ID {$investorId}: expected {$expectedDistribution}, got {$distributedAmount}"

            );

            $totalDistributedAmount = bcadd($totalDistributedAmount, $distributedAmount, 2);
        }

        // Ensure that the total distributed amount equals the repayment amount
        $this->assertEquals($repaymentAmount, $totalDistributedAmount);
    }
}
