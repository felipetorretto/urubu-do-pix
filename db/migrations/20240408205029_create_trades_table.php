<?php

use Phinx\Migration\AbstractMigration;

class CreateTradesTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('trades');
        $table->addColumn('value_in', 'decimal', ['precision' => 10, 'scale' => 2])
            ->addColumn('value_out', 'decimal', ['precision' => 10, 'scale' => 2, 'default' => 0])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'datetime')
            ->create();
    }
}
