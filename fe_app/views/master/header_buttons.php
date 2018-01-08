<div class="headerbar-item pull-right">
    <div class="btn-group btn-group-sm">
        <?php if (!isset($hide_submit_button)) : ?>
            <button id="btn-submit" name="btn_submit" class="btn btn-success ajax-loader form-submit" type="submit">
                <i class="fa fa-check"></i> Guardar
            </button>
        <?php endif; ?>
        <?php if (!isset($hide_cancel_button)) : ?>
            <a id="btn-cancel" name="btn_cancel" class="btn btn-danger" href="/clientes">
                <i class="fa fa-times"></i> Cancelar
            </a>
        <?php endif; ?>
    </div>
</div>