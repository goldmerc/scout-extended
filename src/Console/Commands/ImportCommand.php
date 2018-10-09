<?php

declare(strict_types=1);

/**
 * This file is part of Scout Extended.
 *
 * (c) Algolia Team <contact@algolia.com>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Algolia\ScoutExtended\Console\Commands;

use Laravel\Scout\Searchable;
use Illuminate\Console\Command;
use Algolia\ScoutExtended\Algolia;
use Algolia\ScoutExtended\Helpers\SearchableFinder;

final class ImportCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected $signature = 'scout:import {searchable? : The name of the searchable}';

    /**
     * {@inheritdoc}
     */
    protected $description = 'Import the given searchable into the search index';

    /**
     * {@inheritdoc}
     */
    public function handle(SearchableFinder $searchableFinder): void
    {
        foreach ($searchableFinder->fromCommand($this) as $searchable) {
            $this->call('scout:flush', ['searchable' => $searchable]);

            $searchable::makeAllSearchable();

            $this->output->success('All ['.$searchable.'] records have been imported.');
        }
    }
}
