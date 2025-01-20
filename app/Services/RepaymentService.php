<?php

namespace App\Services;

use App\Models\Project;

class RepaymentService
{
    /**
     * Distribute the repayment amount from a borrower to the investors of a project.
     *
     * This method calculates the proportional distribution of the repayment amount
     * among all the investors of the given project based on their investment shares.
     * It updates the investors' balances and optionally returns the distribution details.
     *
     * @param \App\Models\Project $project The project for which the repayment is being made.
     * @param float $repaymentAmount The total repayment amount to be distributed.
     *
     * @return array An array containing the distribution details for each investor.
     *               Each item includes:
     *               - 'investor_id': The ID of the investor.
     *               - 'project_id': The ID of the project.
     *               - 'amount' (decimal string): The distributed amount to the investor in USD.
     *
     * @throws \Exception If there are no investors or the total investment is invalid.
     */
    public function distributeToInvestors(Project $project, float $repaymentAmount)
    {
        $distributions = [];

        return $distributions;
    }
}
