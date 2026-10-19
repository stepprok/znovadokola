<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<?php
/** 
 * @var object $vse
 */
?>
<div class="container-fluid px-3 px-md-4 py-4 py-md-5">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">
            <div class="text-center my-4 my-md-5 pb-4 border-bottom">
                <h1 class="display-4 fw-bold text-dark mb-2">
                    Seznam etap
                </h1>
                <h2 class="h5 text-muted fw-normal text-uppercase tracking-wider mb-0">
                    Přehled etap, tras a vítězů
                </h2>

                <a href="<?= base_url('vytvor') ?>" class="btn btn-sm btn-outline-primary">vytvor etapu</a>
            </div>

            <?php

            $table = new \CodeIgniter\View\Table();

            $template = [
                'table_open'         => '<table class="table table-bordered table-striped table-hover">',
                'thead_open'         => '<thead>',
                'thead_close'        => '</thead>',
                'heading_row_start'  => '<tr>',
                'heading_row_end'    => '</tr>',
                'heading_cell_start' => '<th>',
                'heading_cell_end'   => '</th>',
                'tbody_open'         => '<tbody>',
                'tbody_close'        => '</tbody>',
                'row_start'          => '<tr style="position: relative; cursor: pointer;">',
                'row_end'            => '</tr>',
                'cell_start'         => '<td>',
                'cell_end'           => '</td>',
                'row_alt_start'      => '<tr style="position: relative; cursor: pointer;">',
                'row_alt_end'        => '</tr>',
                'cell_alt_start'     => '<td>',
                'cell_alt_end'       => '</td>',
                'table_close'        => '</table>'
            ];

            $table->setTemplate($template);

            $table->setHeading('ID', 'Název závodu', 'Datum začátku', 'Datum ukončení', 'Délka (km)');

           foreach ($vse as $row) {
    $startDate = $row->start_date ? date('j. n. Y', strtotime($row->start_date)) : '';
    
    $endDate = $row->end_date ? date('j. n. Y', strtotime($row->end_date)) : '';

    $table->addRow([
        $row->id,
        anchor('dva/' . $row->id, $row->real_name, ['class' => 'stretched-link text-decoration-none']),
        $startDate,
        $endDate,
        round($row->total_distance) . ' km'
    ]);
}

            echo $table->generate();
            ?>
        </div>
    </div>
</div>


<?= $this->endSection(); ?>