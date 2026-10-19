<?= $this->extend('Layout/template'); ?>

<?= $this->section('content'); ?>

<div class="p-3">
    <div class="mb-3">
        <a href="javascript:history.back()" class="btn btn-secondary btn-sm">&laquo; Zpět na detail závodu</a>
    </div>

    <h1>
        <?= ($typeResult == 1) ? 'Pořadí v etapě' : 'Pořadí po etapě' ?>
        (<?= !empty($stage->departure) ? $stage->departure . ' – ' . $stage->arrival : 'Etapa ' . ($stage->number ?? $stage->id) ?>)
    </h1>

    <?php if (!empty($results)): ?>
        <?php
        $table = new \CodeIgniter\View\Table();

        $template = array(
            'table_open'         => '<table class="table table-bordered table-striped">',
            'thead_open'         => '<thead>',
            'thead_close'        => '</thead>',
            'heading_row_start'  => '<tr>',
            'heading_row_end'    => '</tr>',
            'heading_cell_start' => '<th>',
            'heading_cell_end'   => '</th>',
            'tbody_open'         => '<tbody>',
            'tbody_close'        => '</tbody>',
            'row_start'          => '<tr>',
            'row_end'            => '</tr>',
            'cell_start'         => '<td>',
            'cell_end'           => '</td>',
            'row_alt_start'      => '<tr>',
            'row_alt_end'        => '</tr>',
            'cell_alt_start'     => '<td>',
            'cell_alt_end'       => '</td>',
            'table_close'        => '</table>'
        );
        $table->setTemplate($template);

        $table->setHeading('Pozice', 'Jezdec', 'Čas / Odstup');

        $position = 1;

        foreach ($results as $row) {
            $riderName = trim($row->first_name . ' ' . $row->last_name);

            $table->addRow([
                $position++ . '.', 
                $riderName,
                !empty($row->time) ? $row->time : '-',
            ]);
        }

        echo $table->generate();
        ?>
    <?php else: ?>
        <div class="alert alert-warning mt-3">
            Pro tuto etapu a typ výsledku (<?= $typeResult ?>) nebyly nalezeny žádné záznamy.
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection(); ?>