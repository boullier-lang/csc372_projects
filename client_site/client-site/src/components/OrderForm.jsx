export default function OrderForm({ formData, onChange, onSubmit, submitted }) {
  return (
    <div id="order-form">
      {submitted ? (
        <div id="confirmation">
          <h2>Booking Received! 🎉</h2>
          <p>Thanks, {formData.name}! We'll see you on {formData.date}.</p>
          <p>Service: {formData.service}</p>
        </div>
      ) : (
        <div>
          <h2>Book an Appointment</h2>

          <label>Name</label>
          <input
            type="text"
            value={formData.name}
            onChange={(e) => onChange('name', e.target.value)}
            placeholder="Your name"
          />

          <label>Email</label>
          <input
            type="email"
            value={formData.email}
            onChange={(e) => onChange('email', e.target.value)}
            placeholder="Your email"
          />

          <label>Date</label>
          <input
            type="date"
            value={formData.date}
            onChange={(e) => onChange('date', e.target.value)}
          />

          <label>Service</label>
          <select
            value={formData.service}
            onChange={(e) => onChange('service', e.target.value)}
          >
            <option value="">-- Select a service --</option>
            {formData.serviceOptions.map((item) => (
              <option key={item.name} value={item.name}>
                {item.name} — {item.price}
              </option>
            ))}
          </select>

          <button onClick={onSubmit}>BOOK NOW</button>
        </div>
      )}
    </div>
  )
}