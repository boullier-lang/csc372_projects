//Mathew Boullier
//Made 3/24/2026
//A simple javascript file that works to create additional service rows, and adds up all of the
//prices to display a projected total.

//Updated 4/4/2026 to include database integration.
//Updated 5/6/2026 to include better date selection
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


//Calendar
function checkDate() {
    var dateInput  = document.getElementById('appt_date_pick');
    var dateError  = document.getElementById('date-error');
    var timeSection = document.getElementById('time-slot-section');
    var slotsGrid  = document.getElementById('time-slots-grid');
    var checkBtn   = document.getElementById('check-date-btn');
 
    // Reset
    dateError.style.display  = 'none';
    timeSection.style.display = 'none';
    slotsGrid.innerHTML = '';
    document.getElementById('appt_date_hidden').value = '';
    document.getElementById('appt_time_hidden').value  = '';
 
    var dateVal = dateInput.value;
    if (!dateVal) {
        dateError.textContent  = 'Please select a date first.';
        dateError.style.display = 'block';
        return;
    }
 
    checkBtn.disabled    = true;
    checkBtn.textContent = 'Checking…';
 
    fetch('check_availability.php?date=' + encodeURIComponent(dateVal))
        .then(function(r) { return r.json(); })
        .then(function(data) {
            checkBtn.disabled    = false;
            checkBtn.textContent = 'Check Availability';
 
            if (!data.open) {
                dateError.textContent  = data.message || 'Sorry, we are closed on that day.';
                dateError.style.display = 'block';
                return;
            }
 
            if (!data.slots || data.slots.length === 0) {
                dateError.textContent  = 'No available time slots on that day — please try another date.';
                dateError.style.display = 'block';
                return;
            }
 
            // Render one button per available slot
            data.slots.forEach(function(slot) {
                var slotBtn = document.createElement('button');
                slotBtn.type      = 'button';
                slotBtn.textContent = slot;
                slotBtn.className = 'time-slot-btn';
                slotBtn.onclick   = function() {
                    document.querySelectorAll('.time-slot-btn').forEach(function(b) {
                        b.classList.remove('selected');
                    });
                    slotBtn.classList.add('selected');
                    document.getElementById('appt_date_hidden').value = dateVal;
                    document.getElementById('appt_time_hidden').value  = slot;
                    document.getElementById('slot-error').style.display = 'none';
                };
                slotsGrid.appendChild(slotBtn);
            });
 
            timeSection.style.display = 'block';
        })
        .catch(function() {
            checkBtn.disabled    = false;
            checkBtn.textContent = 'Check Availability';
            dateError.textContent  = 'Something went wrong. Please try again.';
            dateError.style.display = 'block';
        });
}
 
// Prevent submit if no slot selected
document.getElementById('booking-form').addEventListener('submit', function(e) {
    var timeHidden  = document.getElementById('appt_time_hidden');
    var slotError   = document.getElementById('slot-error');
    var timeSection = document.getElementById('time-slot-section');
    var dateError   = document.getElementById('date-error');
 
    if (!timeHidden.value) {
        e.preventDefault();
        if (timeSection.style.display !== 'none') {
            slotError.textContent  = 'Please select a time slot before submitting.';
            slotError.style.display = 'block';
        } else {
            dateError.textContent  = 'Please select and confirm a date first.';
            dateError.style.display = 'block';
        }
    }
});

document.getElementById('check-date-btn').addEventListener('click', checkDate);
