import { useState } from 'react'
import servicesData from '../assets/services.json'
import ServiceCategory from '../components/ServiceCategory'
import Sidebar from '../components/sideBar'
import './services.css'
import { Link } from 'react-router-dom'

export default function Services() {

  const [openCategories, setOpenCategories] = useState(
    servicesData.services.map(() => true)
  )

  function handleToggle(index) {

    setOpenCategories(prev => {
      const updated = [...prev]
      updated[index] = !updated[index]
      return updated
    })
  }

  return (
    <div id="main">
      <div id="left">
        <Sidebar />
      </div>
      <div id="right">
        <div id="services">
          <h2>Services</h2>
          {servicesData.services.map((category, index) => (
            <ServiceCategory
              key={category.category}
              category={category}
              isOpen={openCategories[index]}
              onToggle={() => handleToggle(index)}
            />
          ))}
          <Link to="/order">
			<button id="book-btn">BOOK NOW</button>
			</Link>
        </div>
      </div>
    </div>
  )
}