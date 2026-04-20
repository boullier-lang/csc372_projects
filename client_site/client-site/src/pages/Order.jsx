import { useState } from 'react'
import servicesData from '../assets/services.json'
import OrderForm from '../components/OrderForm'
import Sidebar from '../components/sideBar'

import './order.css'

// flatten all services from every category into one list
const allServices = servicesData.services.flatMap((cat) => cat.items)

export default function Order() {
  const [submitted, setSubmitted] = useState(false)
  const [formData, setFormData] = useState({
    name: '',
    email: '',
    date: '',
    service: '',
    serviceOptions: allServices
  })

  function handleChange(field, value) {
    // immutable update
    setFormData(prev => ({ ...prev, [field]: value }))
  }

  function handleSubmit() {
    if (!formData.name || !formData.email || !formData.date || !formData.service) {
      alert('Please fill out all fields!')
      return
    }
    setSubmitted(true)
  }

  return (
    <div id="main">
      <div id="left">
        <Sidebar />
      </div>
      <div id="right">
        <OrderForm
          formData={formData}
          onChange={handleChange}
          onSubmit={handleSubmit}
          submitted={submitted}
        />
      </div>
    </div>
  )
}