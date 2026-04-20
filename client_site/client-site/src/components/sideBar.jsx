import { useState } from 'react'
import hoursData from '../assets/hours.json'
import announcementsData from '../assets/announcements.json'

export default function Sidebar() {
  const [showAnnouncements, setShowAnnouncements] = useState(true)
  const [expandedIndex, setExpandedIndex] = useState(null)

  return (
    <div id="sidebar">

      <h2>Hours</h2>
      <ul>
        {hoursData.hours.map((h) => (
          <li key={h.day}>{h.day} — {h.open}–{h.close}</li>
        ))}
      </ul>

      <h2 onClick={() => setShowAnnouncements(!showAnnouncements)} style={{ cursor: 'pointer' }}>
        Announcements {showAnnouncements ? '▲' : '▼'}
      </h2>

      {showAnnouncements && (
        <ul>
          {announcementsData.announcements.map((a, i) => (
            <li key={i} onClick={() => setExpandedIndex(expandedIndex === i ? null : i)} style={{ cursor: 'pointer' }}>
              <strong>{a.title}</strong> — {a.date}
              {expandedIndex === i && <p>{a.message}</p>}
            </li>
          ))}
        </ul>
      )}

    </div>
  )
}