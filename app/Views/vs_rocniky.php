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
                <a href="<?= base_url() ?>" class="btn btn-sm btn-outline-primary">vrat se na zacatek</a>
            </div>

            <div class="card shadow-sm border-0 mt-4">
                <div class="table-responsive">
                    <?php
                    $table = new \CodeIgniter\View\Table();

                    $template = array(
                        'table_open'         => '<table class="table table-bordered table-striped" id="sortableTable">',
                        'thead_open'         => '<thead>',
                        'thead_close'        => '</thead>',
                        'heading_row_start'  => '<tr>',
                        'heading_row_end'    => '</tr>',
                        'heading_cell_start' => '<th style="cursor: pointer;" class="sort-header">',
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

                    $table->setHeading('ID', 'Etapa / Trasa', 'Datum', 'Délka (km)', 'Typ etapy', 'Vítěz', 'Pořadí v etapě', 'Pořadí po etapě');

                    foreach ($stages as $stage) {
                        $stageName = (!empty($stage->departure) && !empty($stage->arrival))
                            ? $stage->departure . ' – ' . $stage->arrival
                            : 'Etapa ' . ($stage->number ?? $stage->id);

                        if (!empty($stage->winner_last)) {
                            $winnerOutput = trim($stage->winner_first . ' ' . $stage->winner_last);
                        } else {
                            $winnerOutput = 'N/A';
                        }

                        $linkStageResult = '<a href="' . base_url('tri/stage/' . $stage->id . '/1') . '" class="btn btn-sm btn-outline-primary">'
                            . 'Pořadí v etapě'
                            . '</a>';

                        $linkAfterStageResult = '<a href="' . base_url('tri/stage/' . $stage->id . '/4') . '" class="btn btn-sm btn-outline-info">'
                            . 'Pořadí po etapě'
                            . '</a>';

                        $table->addRow([
                            $stage->id,
                            $stageName,
                            date('d.m.y', strtotime($stage->date)), 
                            round($stage->distance) . ' km',
                            $stage->parcour_name ?? 'N/A',
                            $winnerOutput,
                            $linkStageResult,
                            $linkAfterStageResult
                        ]);
                    }

                    echo $table->generate();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>