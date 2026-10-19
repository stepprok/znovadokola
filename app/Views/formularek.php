<?= $this->extend('Layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container my-4">
    <a href="<?= base_url(); ?>" class="btn btn-secondary btn-sm mb-3">Zpět</a>

    <div class="card">
        <div class="card-header">
            <h3>Přidat nový ročník závodu</h3>
        </div>
        <div class="card-body">

            <form action="<?= base_url('uloz'); ?>" method="post" enctype="multipart/form-data">
                
                <div class="mb-3">
                    <label for="real_name" class="form-label">Název ročníku (real_name):</label>
                    <input type="text" class="form-control" id="real_name" name="real_name" value="<?= old('real_name') ?>" required>
                </div>

                <div class="mb-3">
                    <label for="race_id" class="form-label">Závod (race_id):</label>
                    <select class="form-select" id="race_id" name="race_id" required>
                        <option value="">-- Vyberte závod --</option>
                        <?php foreach ($races as $race): ?>
                            <option value="<?= $race->id ?>">
                                <?= $race->real_name ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="logo" class="form-label">Logo závodu:</label>
                    <input class="form-control" type="file" id="logo" name="logo" required>
                </div>

                <button type="submit" class="btn btn-primary">Uložit ročník</button>
            </form>

        </div>
    </div>
</div>

<?= $this->endSection(); ?>