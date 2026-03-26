//Mathew Boullier
//Made 3/24/2026
//A simple javascript file that works to create additional service rows, and adds up all of the
//prices to display a projected total.


const priceMap = {};
document.querySelectorAll('#service-rows .service-select option').forEach(opt => {
    if (opt.value) {

        const raw = opt.getAttribute('data-price') || '0';
        priceMap[opt.value] = parseFloat(raw.replace(/[^0-9.]/g, '')) || 0;
    }
});

function updateTotal() {
    let total = 0;
    let anySelected = false;
    document.querySelectorAll('.service-select').forEach(sel => {
        if (sel.value) {
            anySelected = true;
            total += priceMap[sel.value] || 0;
        }
    });
    const summary = document.getElementById('price-summary');
    summary.style.display = anySelected ? 'block' : 'none';
    document.getElementById('price-total').textContent =
        total > 0 ? '$' + total.toFixed(2) : 'varies';
}

function addServiceRow() {

    const container = document.getElementById('service-rows');
    const template  = container.querySelector('.service-row select');

    const row = document.createElement('div');
    row.className = 'service-row';

    const sel = template.cloneNode(true); 
    sel.value = '';                         
    sel.onchange = updateTotal;

    const btn = document.createElement('button');
    btn.type      = 'button';
    btn.className = '.booking-row-dismiss';
    btn.textContent = '✕';
    btn.onclick   = () => removeServiceRow(btn);

    row.appendChild(sel);
    row.appendChild(btn);
    container.appendChild(row);
}

function removeServiceRow(btn) {
    const row = btn.closest('.service-row');
    row.remove();
    updateTotal();
}


document.getElementById('phone').addEventListener('input', function (e) {
    // Strip everything except digits
    let digits = this.value.replace(/\D/g, '').substring(0, 10);

    // Build the mask progressively
    let formatted = '';
    if (digits.length === 0) {
        formatted = '';
    } else if (digits.length <= 3) {
        formatted = '(' + digits;
    } else if (digits.length <= 6) {
        formatted = '(' + digits.substring(0, 3) + ') ' + digits.substring(3);
    } else {
        formatted = '(' + digits.substring(0, 3) + ') ' + digits.substring(3, 6) + ' ' + digits.substring(6);
    }

    this.value = formatted;
});