document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.rd-prevent-double-submit').forEach(form => {

        form.addEventListener('submit', function () {

            const btn = form.querySelector('.rd-submit-btn');

            if (btn) {
                btn.disabled = true;
                btn.classList.add('disabled');
                btn.dataset.originalText = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
            }

        }, { once: true });

    });

});
