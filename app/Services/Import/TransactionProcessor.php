<?php
/**
 * TransactionProcessor.php
 * Copyright (c) 2019 - 2019 thegrumpydictator@gmail.com
 *
 * This file is part of the Firefly III CSV importer
 * (https://github.com/firefly-iii-csv-importer).
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

namespace App\Services\Import;

use App\Services\Import\Task\TaskInterface;
use Log;

/**
 * Class TransactionProcessor
 */
class TransactionProcessor
{
    /** @var array */
    private $tasks;

    /**
     * TransactionProcessor constructor.
     */
    public function __construct()
    {
        $this->tasks = config('csv_importer.transaction_tasks');
    }

    /**
     * @param array $transaction
     *
     * @return array
     */
    public function process(array $transaction): array
    {
        Log::debug(sprintf('Now in %s', __METHOD__));
        foreach($this->tasks as $task) {
            /** @var TaskInterface $object */
            $object = app($task);
            $transaction = $object->process($transaction);
        }
        return $transaction;
    }

}